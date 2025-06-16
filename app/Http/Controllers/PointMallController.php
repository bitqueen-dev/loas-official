<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Session;

class PointMallController extends Controller{
	public function itemList() {
		genSession();
		$gameId = userCheck();

		if ($gameId) {
			$data = [];
			$data['items'] = self::getItemInfo('all');//config('pointMall.items');
			$data['userGameInfo'] = getGameInfoByUserGameId($gameId);

			$content = view('pointMall.itemList', $data);

			return response($content, 200);
		} else {
			return redirect(config('app.httpsBaseUrl') . '/?pop=showLogin');
		}
	}

	public function history() {
		genSession();
		$gameId = userCheck();

		if($gameId) {
			try {
				$pointHistory = DB::table('pointHistory')->where('userGameId', $gameId)->orderBy('id', 'DESC')->paginate(20);
				$data['historys'] = [];

				foreach ($pointHistory as $history) {
					$tmp = [];
					$tmp['createdAt'] = $history->createdAt;
					$tmp['name'] = $history->transName;
					$tmp['price'] = ($history->pointPrice > 0) ? '+' . $history->pointPrice : $history->pointPrice;
					$tmp['orderNumber'] = $history->orderNumber;
					$tmp['code'] = is_null($history->code) ? '--' : $history->code;

					$data['historys'][] = $tmp;
				}
				$data['pointHistory'] = $pointHistory;
				$content = view('pointMall.history', $data);

				return response($content, 200);
			} catch (Exception $e) {
				abort(500);
			}
		} else {
			return redirect(config('app.httpsBaseUrl') . '/?pop=showLogin');
		}
	}

	public function itemInfo($itemId = false, $serverId = false, $itemCount = 0) {
		genSession();
		$gameId = userCheck();

		if($gameId && isset(config('pointMall.items')[$itemId]) && $serverId && $itemCount >= 1) {
			try {
				$data['itemInfo'] = self::getItemInfo([$itemId])[$itemId];//config('pointMall.items')[$itemId];
				$data['itemId'] = $itemId;
				$data['serverId'] = $serverId;
				$data['itemCount'] = $itemCount;

				$content = view('pointMall.itemInfo', $data);

				return response($content, 200);
			} catch (Exception $e) {
				abort(500);
			}
		}

		abort(500);
	}

	public function purchase($itemId = false, $serverId = false, $itemCount = 0) {
		genSession();
		$gameId = userCheck();

		$itemInfo = self::getItemInfo([$itemId]);//isset(config('pointMall.items')[$itemId]) ? config('pointMall.items')[$itemId] : false;

		if($itemInfo && isset($itemInfo[$itemId]) && ($itemInfo[$itemId]['isValid'] === 1) && $serverId && $itemCount >= 1) {
			$price = $itemInfo[$itemId]['isSalesTime'] ? $itemInfo[$itemId]['salesPoint'] : $itemInfo[$itemId]['point'];
		} else {
			return response()->json([
				'status' => false,
				'code' => '-999',
				'msg' => 'Unknow error!'
			]);
		}

		$pointBlance = DB::select('select point from users where gameId=?', [$gameId]);
		$price *= $itemCount;

		if($pointBlance[0]->point < $price) {
			return response()->json([
				'status' => false,
				'code' => '-9',
				'msg' => 'Not enought point'
			]);
		}

		if($gameId) {
			DB::beginTransaction();

			try {
				/*$code = DB::table('codes')
					->where('itemId', '=', $itemId)
					->where('state', '=', 0)
					->where('userGameId', '=', null)
					->lockForUpdate()
					->first();

				if($code === null) {
					return response()->json([
						'status' => false,
						'code' => '-8',
						'msg' => 'No codes!'
					]);
				}*/

				$mailTitle = $itemInfo[$itemId]['name'] . ' X ' . $itemCount;
				$mailContents = 'ポイントモールから購入したアイテムでございます';
				if(!giveUserItem($gameId, $serverId, $itemInfo[$itemId]['id'], $itemCount, $mailTitle, $mailContents)) {
					return response()->json([
						'status' => false,
						'code' => '-999',
						'msg' => 'Unknow error!'
					]);
				}

				$orderNumber = self::genOrderNumber();

				DB::update('update users set point=point-' . $price . ' where gameId=?', [$gameId]);
				$data = [
					$orderNumber,
					'consumption',
					$price * -1,
					$itemInfo[$itemId]['name'] . ' X ' . $itemCount,
					$gameId,
					$itemId,
				];
				DB::insert('insert into pointHistory (orderNumber,type,pointPrice,transName,userGameId,itemId) values (?,?,?,?,?,?)', $data);

				//DB::update('update codes set orderNumber=?,userGameId=?,state=1,updateAt=? where code=?', [$orderNumber, $gameId, date('Y-m-d H:i:s', time()), $code->code]);

				self::updateMinigameUserInfo($gameId,$price);

				DB::commit();
				genSession(true);

				return response()->json([
					'status' => true,
					'code' => '0',
					'msg' => 'success!'
				]);
			} catch (Exception $e) {
				DB::rollback();

				return response()->json([
					'status' => false,
					'code' => '-999',
					'msg' => 'Unknow error!'
				]);
			}
		}

		return response()->json([
			'status' => false,
			'code' => '-999',
			'msg' => 'Unknow error!'
		]);
	}

	private function getItemInfo($ids) {
		$items = config('pointMall.items');
		$currentTime = time();

		$ret = [];
		foreach ($items as $itemId => $itemInfo) {
			if($itemInfo['isValid'] !== 1) {
				continue;
			}

			if(is_array($ids) && !in_array($itemId, $ids)) {
				continue;
			}

			$isSalesTime = false;
			if(($currentTime > strtotime(config('pointMall.salesStartTime'))) && ($currentTime < strtotime(config('pointMall.salesEndTime'))) && ((config('pointMall.salesItems') == 'all') || in_array($itemId, config('pointMall.salesItems')))) {
				$isSalesTime = true;
			}

			$itemInfo['isSalesTime'] = $isSalesTime;

			$ret[$itemId] = $itemInfo;
		}

		return $ret;
	}

	private function genOrderNumber() {
		return md5(time() . rand());
	}

	private function updateMinigameUserInfo($gameId, $price) {
		DB::update('update minigameUserInfo set usedPoint=usedPoint+' . $price . ' where gameId=?', [$gameId]);
	}
}