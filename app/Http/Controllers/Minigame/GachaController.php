<?php
namespace App\Http\Controllers\Minigame;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\DB;

class GachaController extends Controller{

	public function __construct(){
		require(app_path('Support/minigame.php'));
		$this->config = config('minigame.gacha');
		$this->gameName = 'gacha';
	}

	public function mumuRoom (Request $request) {
		$nowGameName = 'gacha';

		$userGameId = $request->input('uId', false);
		$serverId = $request->input('sId', false);

		$data = [
			'isValidGame' => false,
			'uId' => $userGameId,
			'sId' => $serverId,
		];

		if (checkPeriod($nowGameName) && $userGameId && $serverId)
			$data['isValidGame'] = true;

		return response(view('minigame.mumuRoom', $data), 200);
	}

	public function showGacha (Request $request) {
		$userGameId = $request->input('uId', false);
		$serverId = $request->input('sId', false);

		$data = [
			'isValidGame' => false,
			'uId' => $userGameId,
			'sId' => $serverId,
		];

		if (checkPeriod($this->gameName) && $userGameId && $serverId) {
			$data['isValidGame'] = true;

			self::setGachaGameInfo($userGameId, $data);
			// self::setGachaGameInfo($userGameId, $serverId, $data);
		}
		return response(view('minigame.gacha', $data), 200);
	}

	// Call By Reference
	private function setGachaGameInfo ($userGameId, &$data) {
	// private function setGachaGameInfo ($userGameId, $serverId, &$data) {
		$minigameUserInfo = self::getUserInfo($userGameId);
		// $minigameUserInfo = self::getUserInfo($userGameId, $serverId);
		if ($minigameUserInfo) {
			$specialPlayCreditA = $minigameUserInfo->specialPlayCreditA;
			$specialPlayCreditB = $minigameUserInfo->specialPlayCreditB;
			$haveTicket = $minigameUserInfo->ticket;
		} else {
			$specialPlayCreditA = 1;
			$specialPlayCreditB = 1;
			$haveTicket = 0;
			self::insertUserInfo([
				'userGameId' => $userGameId,
				// 'serverId' => $serverId,
				'specialPlayCreditA' => $specialPlayCreditA,
				'specialPlayCreditB' => $specialPlayCreditB,
			]);
		}

		$data['specialPlayCreditA'] = $specialPlayCreditA;
		$data['specialPlayCreditB'] = $specialPlayCreditB;
		$data['haveTicket'] = $haveTicket;
		$data['gachaInfo'] = json_encode($this->config['gachaInfo']);

		$itemsConfig = $this->config['items'];
		$items = [];
		$itemInfo = [];
		foreach ($itemsConfig as $key => $value) {
			$items[] = $key;
			$itemInfo[] = [
				'n' => str_replace('の欠片','',$value['name']),
				'r' => $value['rare'],
				'p' => $value['probability']/10000,
				'u' => $value['probability_up'],
			];
		}
		$data['itemList'] = json_encode($items);
		$data['itemInfo'] = json_encode($itemInfo);

		$decidedItemsConfig = $this->config['decidedItems'];
		$decidedItemInfo = [];
		foreach ($decidedItemsConfig as $key => $value) {
			$decidedItemInfo[] = [
				'n' => str_replace('の欠片','',$value['name']),
				'r' => $value['rare'],
				'p' => $value['probability']/10000,
				'u' => $value['probability_up'],
			];
		}
		$data['decidedItemInfo'] = json_encode($decidedItemInfo);
	}

	public function playGacha (Request $request) {
		if (checkPeriod($this->gameName)) {
			$userGameId = $request->input('uId', false);
			$serverId = $request->input('sId', false);
			$gachaId = $request->input('gachaId', false);
			$gachaInfo = $this->config['gachaInfo'];
			$minigameUserInfo = self::getUserInfo($userGameId);
			// $minigameUserInfo = self::getUserInfo($userGameId, $serverId);

			if ($userGameId && $minigameUserInfo && $userGameId == $minigameUserInfo->userGameId && $serverId && isset($gachaInfo[$gachaId])) {
				try {
					$data = [];
					$curGachaInfo = $gachaInfo[$gachaId];

					if (
						($curGachaInfo['specialPlayA'] == true && $minigameUserInfo->specialPlayCreditA <= 0)
						|| ($curGachaInfo['specialPlayB'] == true && $minigameUserInfo->specialPlayCreditB <= 0)
					) {
						return jsonResponse('NOT_ENOUGHT_BALANCE');
					}

					if ($curGachaInfo['type'] == 'ticket' && $curGachaInfo['specialPlayA'] == false && $curGachaInfo['specialPlayB'] == false) {
						if ($minigameUserInfo->ticket >= $curGachaInfo['ticket']) {
							$curTicket = $minigameUserInfo->ticket - $curGachaInfo['ticket'];
							self::updateUserInfo($userGameId, ['ticket' => $curTicket]);
							// self::updateUserInfo($userGameId, $serverId, ['ticket' => $curTicket]);
							$data['haveTicket'] = $curTicket;
						} else {
							return jsonResponse('NOT_ENOUGHT_BALANCE');
						}
					} else {
						$data['haveTicket'] = $minigameUserInfo->ticket;
						// $consumeRes = consumeDiamond($userGameId, $serverId, 1, $curGachaInfo['type']);//TEST
						$consumeRes = consumeDiamond($userGameId, $serverId, $curGachaInfo['payDiamond'], $curGachaInfo['type']);
						if ($consumeRes['status'] == -1) {
							return jsonResponse('NOT_ENOUGHT_BALANCE');
						} else if ($consumeRes['status'] < 0) {
							return jsonResponse('REQUEST_ERROR');
						}
					}

					$getCardInfo = self::getCard($curGachaInfo['playGachaCount'],$curGachaInfo['type']);
					$data['getCardList'] = $getCardInfo['getCardList'];
					$orderNumber = genOrderNumber($userGameId);
					insertMinigameHistory($this->gameName, $orderNumber, $userGameId, $serverId, (int)'-'.$curGachaInfo['payDiamond'], $curGachaInfo['type'], $gachaId, $getCardInfo['historyItemName']);

					if (self::giveItem($serverId, $userGameId, $getCardInfo['itemList'])) {
						updateMinigameHistory($orderNumber);
						if($curGachaInfo['specialPlayA'] == true) self::updateUserInfo($userGameId, ['specialPlayCreditA' => 0]);
						if($curGachaInfo['specialPlayB'] == true) self::updateUserInfo($userGameId, ['specialPlayCreditB' => 0]);
						// if($curGachaInfo['specialPlayA'] == true) self::updateUserInfo($userGameId, $serverId, ['specialPlayCreditA' => 0]);
						// if($curGachaInfo['specialPlayB'] == true) self::updateUserInfo($userGameId, $serverId, ['specialPlayCreditB' => 0]);
						return jsonResponse('SUCCESS', $data);
					}
				} catch (RequestException $re) {
					return jsonResponse('REQUEST_ERROR');
				} catch (Exception $e) {
					return jsonResponse('DB_ERROR');
				}
			}
			return jsonResponse('REQUEST_ERROR');
		}
		return jsonResponse('CLOSED_GAME');
	}

	private function getCard ($playGachaCount, $type) {
		$getCardList = [];
		$items = $this->config['items'];
		$animationMap = $this->config['animationMap'];
		$itemList = '';
		$historyItemName = '';

		for ($i = 0; $i < $playGachaCount; $i++) {
			if ($i == 9 && ($type == 'goldDiamond' || $type == 'ticket')) {
				$getCard = gachaSystem($this->config['decidedItems']);
			} else {
				$getCard = gachaSystem($items);
			}
			
			// if($i==0)$getCard=$items[mt_rand(2301,2306)];//TEST
			// if($i==0)$getCard=$items[2307];//TEST
			
			$itemList .= $getCard['item_list'] . ','; // ** Caution [change logic] ** itemId1:count,itemId2:count,itemId3:count
			$historyItemName .= $getCard['name'] . ',';

			if ($getCard['rare'] == 'GR' && isset($animationMap[$getCard['itemId']]['image'])) {
				$getCard['animImg'] = $animationMap[$getCard['itemId']]['image'];
			} else {
				$getCard['animImg'] = '';
			}

			unset($getCard['item_list']);
			unset($getCard['probability']);

			$getCardList[] = $getCard;
		}

		$itemList = substr($itemList, 0, -1);
		$historyItemName = substr($historyItemName, 0, -1);

		return [
			'getCardList' => $getCardList,
			'itemList' => $itemList,
			'historyItemName' => $historyItemName,
		];
	}

	private function giveItem ($serverId, $userGameId, $itemList) {
		$currentTime = time();
		$params = [
			'time' => $currentTime,
			'verify' => md5('@#$%6666&^%$' . $currentTime . $serverId),
			'title' => 'アイテム獲得のお知らせ',
			'content' => 'お客様は、ゲームアイテムを獲得しました。 添付アイテムをお受取ください。',
			'server_id' => $serverId,
			'user_list' => $userGameId,
			'item_list' => $itemList, //** Caution [change logic] ** itemId1:count,itemId2:count,itemId3:count
		];
		return giveGameItem($params);
	}

	private function getUserInfo ($userGameId) {
	// private function getUserInfo ($userGameId, $serverId) {
		$record = DB::table('gachaUserInfo')
				->where('userGameId','=',$userGameId)
				// ->where('serverId','=',$serverId)
				->limit(1)
				->get();
		if (isset($record[0])) {
			return $record[0];
		}
		return false;
	}

	private function updateUserInfo ($userGameId, $values) {
	// private function updateUserInfo ($userGameId, $serverId, $values) {
		DB::table('gachaUserInfo')
		->where('userGameId','=',$userGameId)
		// ->where('serverId','=',$serverId)
		->update($values);
	}

	private function insertUserInfo ($insertData) {
		DB::table('gachaUserInfo')->insert($insertData);
	}
}
