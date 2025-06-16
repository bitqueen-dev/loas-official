<?php
namespace App\Http\Controllers\Minigame;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

class FireworksController extends Controller{

	public function __construct(){
		require(app_path('Support/minigame.php'));
	}

	public function fireworksPlay (Request $request) {
		$gameName = 'fireworks';
		if (!checkPeriod($gameName)) { return jsonResponse('CLOSED_GAME'); }

		$gameId = getGameId();
		$pointId = $request->input('pointId', false);
		$serverId = $request->input('sId', false);
		$postGameId = $request->input('gId', false);

		$conf = config('minigame.'.$gameName);
		$itemPoint = isset($conf['pointInfo'][$pointId]['point']) ? $conf['pointInfo'][$pointId]['point'] : false;
		$prizeInfo = isset($conf['prizeItem'][$pointId]) ? $conf['prizeItem'][$pointId] : false;

		if ($gameId && $gameId == $postGameId && $pointId && $serverId && $itemPoint && $prizeInfo) {
			$balance = getUserBalance($gameId);
			if ($balance && $balance['point'] < $itemPoint) { return jsonResponse('NOT_ENOUGHT_BALANCE'); }

			$targetItem = gachaSystem($prizeInfo);
			if (!$targetItem) { return jsonResponse('SYSTEM_ERROR'); }
			$itemId = $targetItem['itemId'];
			$itemName = $targetItem['name'];
			$itemImg = $targetItem['itemImg'];
			$worth = $targetItem['worth'];
			$itemList = $targetItem['item_list'];

			if ($pointId == 10) {
				$againFlag = rand(1, 100) > 90 ? true : false;
			} else if ($pointId == 50) {
				$againFlag = rand(1, 100) > 92 ? true : false;
			} else if ($pointId == 100) {
				$againFlag = rand(1, 100) > 95 ? true : false;
			} else {
				$againFlag = false;
			}

			$payInfos = [
				'orderNumber' => genOrderNumber($gameId),
				'gameId' => $gameId,
				'gameName' => $gameName,
				'type' => 'point',
				'serverId' => $serverId,
				'price' => $itemPoint,
				'itemName' => $itemName,
				'itemId' => $itemId,
				'transName' => '花火ミニゲーム',
				'itemList' => $itemList,
			];
			if (consumptionStep1($payInfos)) {
				if ($itemId == 2000 || consumptionStep2($payInfos)) {
					$data = [
						'itemName' => $itemName,
						'itemImg' => $itemImg,
						'againFlag' => $againFlag,
						'worth' => $worth,
					];
					return jsonResponse('SUCCESS', $data);
				}
				return jsonResponse('REQUEST_ERROR');
			}
			return jsonResponse('DB_ERROR');
		}
		return jsonResponse('UNKNOWN');
	}
}
