<?php
namespace App\Http\Controllers\Minigame;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class SugorokuController extends Controller{

	public function __construct(){
		require(app_path('Support/minigame.php'));
		$this->gameName = 'sugoroku';
	}

	public function showTop (Request $request) {
		$data = [];
		if(checkPeriod($this->gameName)){
			$data['uId'] = $userGameId = $request->input('uId', false);
			$data['sId'] = $serverId = $request->input('sId', false);

			if ($userGameId && $serverId) {
				$data['panelInfo'] = json_encode(self::getPanelInfo());
				$data['boxInfo'] = json_encode(self::getBoxInfo());
				$data['userData'] = json_encode(self::getInitData($userGameId, $serverId));
			}
		}
		return view('minigame.sugoroku', $data);
	}

	public function play (Request $request) {
		if (checkPeriod($this->gameName)) {
			usleep(500000);
			$userGameId = $request->input('uId', false);
			$serverId = $request->input('sId', false);
			$playerPosNum = $request->input('playerPos', false);
			$eventName = $request->input('eventName', false);
			if ($userGameId && $serverId && $playerPosNum >= 0 && $eventName) {
				$consumptionConf = config('minigame.sugoroku.consumption');
				if (isset($consumptionConf[$eventName])) {
					$subValue = $consumptionConf[$eventName];
					$userInfo = self::getUserInfo($userGameId, $serverId);
					if ($userInfo) {
						if ($userInfo->positionNum == $playerPosNum) {
							if ($eventName == 'freePlay') {
								if ($userInfo->freePlayCredit < $subValue)
									return jsonResponse('NOT_ENOUGHT_BALANCE');
							} else {
								$consumeRes = consumeDiamond($userGameId, $serverId, $subValue, $eventName);
								if ($consumeRes['status'] == -1) {
									return jsonResponse('NOT_ENOUGHT_BALANCE');
								} else if ($consumeRes['status'] < 0) {
									return jsonResponse('REQUEST_ERROR');
								}
							}

							$panelInfo = config('minigame.sugoroku.panelInfo');
							$arrivedPanelInfo = self::getArrivedPanelInfo($panelInfo,$playerPosNum);
							if ($arrivedPanelInfo) {
								$itemInfo = $arrivedPanelInfo['itemInfo'];
								$againFlag = isset($itemInfo['again']) ? true : false;

								if (self::processConsumption($userGameId,$serverId,$subValue,$eventName,$arrivedPanelInfo,$againFlag)) {
									return jsonResponse('SUCCESS', [
										'eventName' => $eventName,
										'gotoPanelNum' => $arrivedPanelInfo['gotoPanelNum'],
										'movement' => $arrivedPanelInfo['movement'],
										'totalMovement' => $userInfo->totalMovement + (int) $arrivedPanelInfo['movement'],
										'itemId' => $itemInfo['itemId'],
										'itemName' => $itemInfo['name'],
										'againFlag' => $againFlag,
									]);
								}
								return jsonResponse('DB_ERROR');
							}
							return jsonResponse('UNKNOWN');
						}
						return jsonResponse('REQUEST_ERROR');
					}
					return jsonResponse('DB_ERROR');
				}
			}
			return jsonResponse('REQUEST_ERROR');
		}
		return jsonResponse('CLOSED_GAME');
	}

	private function getArrivedPanelInfo ($panelInfo,$playerPosNum) {
		$rouletteMin = 1;
		$rouletteMax = 6;
		$panelCount = count($panelInfo);
		$percentRand = rand(1, 100);

		$tmp = [];
		for ($i = ($playerPosNum + $rouletteMin); $i <= ($playerPosNum + $rouletteMax); $i++) {
			$willGotoPanelNum = ($i >= $panelCount) ? $i - $panelCount : $i;
			$info = $panelInfo[$willGotoPanelNum];
			$setFlag = false;
			if ($info['probability'] == 0) {
				$setFlag  = true;
			} else {
				if ($info['probability'] > $percentRand) {
					$setFlag  = true;
				}
			}

			if ($setFlag) {
				$tmp[] = [
					'gotoPanelNum' => $willGotoPanelNum,
					'movement' => $i - $playerPosNum,
					'items' => $info['items'],
				];
			}
		}

		if (isset($tmp[0])) {
			$arrivedPanelInfo = $tmp[array_rand($tmp)];
			$rareItems = $arrivedPanelInfo['items'];
			$itemId = $rareItems[array_rand($rareItems)];
			$arrivedPanelInfo['itemInfo'] = config('minigame.sugoroku.itemInfo')[$itemId];
			return $arrivedPanelInfo;
		}
		return false;
	}

	private function processConsumption ($userGameId,$serverId,$subValue,$eventName,$arrivedPanelInfo,$againFlag) {
		try{
			$itemInfo = $arrivedPanelInfo['itemInfo'];
			$orderNumber = genOrderNumber($userGameId);
			$updateData = [ 
				'totalPlayCount' => DB::raw('totalPlayCount+1'),
				'totalMovement' => DB::raw('totalMovement+'.$arrivedPanelInfo['movement']),
				'positionNum' => $arrivedPanelInfo['gotoPanelNum'],
			];
			if ($eventName == 'freePlay' && !$againFlag) {
				$updateData['freePlayCredit'] = DB::raw('freePlayCredit-1');
			} else if ($againFlag) {
				$updateData['freePlayCredit'] = DB::raw('freePlayCredit+1');
			}
			self::updateUserInfo($userGameId, $serverId, $updateData);
			$itemName = $itemInfo['name'];
			$itemList = $itemInfo['item_list'];
			insertMinigameHistory($this->gameName,$orderNumber,$userGameId,$serverId,(int)'-'.$subValue,$eventName,$itemInfo['itemId'],$itemName);
			$res = true;
			if ($itemList) {
				if($eventName == 'goldDiamond'){
					$itemList = self::increaseGiveItemByRoyalDiamond($itemList);
				}

				$currentTime = time();
				$res = giveGameItem([
					'time' => $currentTime,
					'verify' => md5('@#$%6666&^%$' . $currentTime . $serverId),
					'title' => 'アイテム獲得のお知らせ',
					'content' => 'お客様は、【' . $itemName . '】を獲得しました。 添付アイテムをお受取ください。',
					'server_id' => $serverId,
					'user_list' => $userGameId,
					'item_list' => $itemList,
				]);
			}
			if ($res) {
				updateMinigameHistory($orderNumber);
				return true;
			}
		} catch (Exception $e) {}
		return false;
	}

	private function increaseGiveItemByRoyalDiamond ($itemList) {
		$res = '';
		$tmp = explode(',',$itemList);
		foreach ($tmp as $key => $item_list) {
			$item_list = explode(':',$item_list);
			$res .= $item_list[0] . ':' . ($item_list[1] * 2) . ';';
		}
		return substr($res, 0, -1);
	}

	public function giveBoxItem (Request $request) {
		if (checkPeriod($this->gameName)) {
			$userGameId = $request->input('uId', false);
			$serverId = $request->input('sId', false);
			$boxNum = $request->input('boxNum', false);
			$boxItem = config('minigame.sugoroku.boxItems');
			if ($userGameId && $serverId && isset($boxItem[$boxNum])) {
				$boxItemInfo = $boxItem[$boxNum];
				if (self::processBoxItem($userGameId,$serverId,$boxItemInfo)){
					return jsonResponse('SUCCESS');
				}
				return jsonResponse('DB_ERROR');
			}
			return jsonResponse('REQUEST_ERROR');
		}
		return jsonResponse('CLOSED_GAME');
	}

	public function history (Request $request) {
		$userGameId = $request->input('uId', false);
		$serverId = $request->input('sId', false);
		if ($userGameId && $serverId) {
			$records = DB::table('minigameHistory')
				->select('price','type','itemName as name','createdAt as date')
				->where('createdAt','>=','2019-03-01 00:00:00')
				->where('gameId','=',$userGameId)
				->where('game','=',$this->gameName)
				->where('serverId','=',$serverId)
				->where('status','=','1')
				->where('price','<=',0)
				->orderBy('id', 'desc')
				->get();

			return jsonResponse('SUCCESS', ['history' => json_encode($records)]);
		}
		return jsonResponse('REQUEST_ERROR');
	}

	private function processBoxItem ($userGameId,$serverId,$boxItemInfo) {
		try{
			$userInfo = self::getUserInfo($userGameId, $serverId);
			if ($userInfo && $userInfo->totalMovement >= $boxItemInfo['round']*count(config('minigame.sugoroku.panelInfo'))) {
				$orderNumber = genOrderNumber($userGameId);

				insertMinigameHistory($this->gameName,$orderNumber,$userGameId,$serverId,0,'giveItem',$boxItemInfo['itemId'],$boxItemInfo['insertItemName']);
				
				$boxItemState = $userInfo->boxItem;
				$pos = $boxItemInfo['statePos'];
				if ($boxItemState[$pos] == 0) {
					$boxItemState[$pos] = 1;

					self::updateUserInfo($userGameId, $serverId, ['boxItem'=>$boxItemState]);

					$contentText = 'お客様は、';
					foreach ($boxItemInfo['name'] as $value) 
						$contentText .= '【' . $value . '】';
					$contentText .= 'を獲得しました。 添付アイテムをお受取ください。';

					$currentTime = time();
					if (giveGameItem([
						'time' => $currentTime,
						'verify' => md5('@#$%6666&^%$' . $currentTime . $serverId),
						'title' => 'アイテム獲得のお知らせ',
						'content' => $contentText,
						'server_id' => $serverId,
						'user_list' => $userGameId,
						'item_list' => $boxItemInfo['item_list'],
					]) && updateMinigameHistory($orderNumber)) {
						return true;
					}
				}
			}
		}catch(Exception $e){}
		return false;
	}

	private function getPanelInfo () {
		$res = [];
		$panelInfo = config('minigame.sugoroku.panelInfo');
		$itemInfo = config('minigame.sugoroku.itemInfo');
		foreach ($panelInfo as $value) {
			$items = $value['items'];
			$itemNameList = [];
			foreach ($items as $itemId) {
				$itemNameList[] = $itemInfo[$itemId]['name'];
			}
			$res[] = [
				'rare' => $value['rare'],
				'items' => $itemNameList,
			];
		}
		return $res;
	}

	private function getBoxInfo () {
		$res = [];
		$boxItems = config('minigame.sugoroku.boxItems');
		foreach ($boxItems as $value) {
			$res[] = ['itemNames' => $value['name']];
		}
		return $res;
	}

	private function getInitData ($userGameId, $serverId) {
		$userInfo = self::getUserInfo($userGameId, $serverId);
		if (!$userInfo) {
			$insertData = [
				'userGameId' => $userGameId,
				'serverId' => $serverId,
				'freePlayCredit' => 1, // first login
				'totalPlayCount' => 0,
				'totalMovement' => 0,
				'positionNum' => 1,
				'boxItem' => '00000',
			];
			DB::table('sugorokuUserInfo')->insert($insertData);
			$userInfo = (object) $insertData;
		}

		unset(
			$userInfo->id,
			$userInfo->userGameId,
			$userInfo->createdAt,
			$userInfo->updatedAt);

		$tmp = [];
		$boxStates = str_split($userInfo->boxItem);
		foreach ($boxStates as $key => $value) {
			$tmp['box_' . $key] = $value;
		}
		$userInfo->boxConditions = $tmp;

		return $userInfo;
	}

	private function getUserInfo ($userGameId, $serverId) {
		$record = DB::table('sugorokuUserInfo')
			->where('userGameId','=',$userGameId)
			->where('serverId','=',$serverId)
			->limit(1)
			->get();
		if (isset($record[0])) {
			return $record[0];
		}
		return false;
	}

	private function updateUserInfo ($userGameId, $serverId, $values) {
		DB::table('sugorokuUserInfo')->where('userGameId','=',$userGameId)->where('serverId','=',$serverId)->update($values);
	}
}