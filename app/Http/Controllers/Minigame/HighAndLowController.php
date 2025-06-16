<?php
namespace App\Http\Controllers\Minigame;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class HighAndLowController extends Controller{

	public function __construct(){
		require(app_path('Support/minigame.php'));
	}

	public function highAndLowBet (Request $request) {
		$gameName = 'highAndLow';
		if (!checkPeriod($gameName)) return jsonResponse('CLOSED_GAME');

		$gameId = getGameId();
		$postGameId = $request->input('gId', false);
		$pointId = $request->input('pId', false);

		$conf = config('minigame.highAndLow.gameInfo');
		$pointConf = isset($conf[$pointId]) ? $conf[$pointId] : false;

		if ($gameId && $gameId == $postGameId && $pointConf) {
			$betPoint = $pointConf['betPoint'];
			$balance = getUserBalance($gameId);
			if ($balance && $balance['point'] < $betPoint) return jsonResponse('NOT_ENOUGHT_BALANCE');

			$orderNumber = genOrderNumber($gameId);
			$payInfos = [
				'orderNumber' => $orderNumber,
				'gameId'      => $gameId,
				'gameName'    => $gameName,
				'type'        => 'point',
				'serverId'    => 0,
				'price'       => $betPoint,
				'itemName'    => 'High&Low BET',
				'itemId'      => $pointConf['itemId'],
				'transName'   => 'High&Lowミニゲーム BET',
			];
			if (consumptionStep1($payInfos)) {
				// self::addPlayCountHighAndLowToSugoroku($gameId);
		
				$cardNum = rand(1, 11); // 3~K
				$userPointNow = $balance['point'] - $betPoint;
				$probability = $pointConf['probability'];
				$data = [
					'up' => $userPointNow,
					'cn' => $cardNum,
					'p' => $probability,
					'o' => $orderNumber,
				];
				return jsonResponse('SUCCESS', $data);
			}
			return jsonResponse('DB_ERROR');
		}
		return jsonResponse('UNKNOWN');
	}

	public function highAndLowResult (Request $request) {
		$gameName = 'highAndLow';
		if (!checkPeriod($gameName)) return jsonResponse('CLOSED_GAME');

		$gameId = getGameId();
		$postGameId = $request->input('gId', false);
		$pointId = $request->input('pId', false);
		$orderNumber = $request->input('oNum', false);
		$result = $request->input('res', false);

		$conf = config('minigame.highAndLow.gameInfo');
		$pointConf = isset($conf[$pointId]) ? $conf[$pointId] : false;

		try {
			if ($gameId && $gameId == $postGameId && $pointConf && $orderNumber) {
				$userPoint = getUserBalance($gameId)['point'];

				DB::beginTransaction();
				updateMinigameHistory($orderNumber);

				$givePoint = 0;
				if ($result == "win") {
					$orderNumber = genOrderNumber($gameId);
					$givePoint = $pointConf['givePoint'];
					givePoint($orderNumber,$gameId,$givePoint,$pointConf['itemId'],'High&Lowミニゲーム WIN');
					$userPoint += $givePoint;
				}
				DB::commit();
				return jsonResponse('SUCCESS', [ 'up' => $userPoint, 'gp' => $givePoint ]);
			}
		} catch (Exception $e) {
			DB::rollback();
			return jsonResponse('DB_ERROR');
		}
		return jsonResponse('UNKNOWN');
	}

	/*
	private function addPlayCountHighAndLowToSugoroku ($gameId) {
		$minigameUserInfo = getMinigameUserInfo($gameId);
		if($minigameUserInfo){
			if ($minigameUserInfo->highAndLowPlayCount == 9) {
				updateMinigameUserInfo([
					'gameId' => $gameId,
					'freePlayCredit' => 'freePlayCredit+1',
					'highAndLowPlayCount' => 0,
				]);

				$conf = config('minigame.sugoroku.userAction.playHighAndLow');

				insertMinigameHistory('highAndLow',genOrderNumber($gameId),$gameId,0,1,'playCount',$conf['itemId'],$conf['itemName']);
			} else {
				updateMinigameUserInfo(['gameId'=>$gameId,'highAndLowPlayCount'=>'highAndLowPlayCount+1']);
			}
			return true;
		}
		return false; // this player dont play sugoroku but he is playing highAndLow
	}
	*/
}
