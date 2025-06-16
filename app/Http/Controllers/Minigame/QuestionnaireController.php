<?php
namespace App\Http\Controllers\Minigame;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
// use Log;
use Illuminate\Support\Facades\Log;

class QuestionnaireController extends Controller{

	public function __construct(){
		require(app_path('Support/minigame.php'));
	}

	public function playQuestionnaire (Request $request) {
		$gameName = 'questionnaire';
		if (!checkPeriod($gameName)) return jsonResponse('CLOSED_GAME');

		$gameId = getGameId();
		$postGameId = $request->input('gId', false);
		$serverId = $request->input('sId', false);
		$sendText = $request->input('sendText', '');
		$dataURL = $request->input('dataURL', false);
		$payId = $request->input('payId', false);
		$payInfo = config('minigame.questionnaire.gameInfo.payInfo');
		$type = isset($payInfo[$payId]) ? $payInfo[$payId]['type'] : false;
		$price = isset($payInfo[$payId]) ? $payInfo[$payId]['price'] : false;

		if ($gameId && $gameId == $postGameId && $serverId && $dataURL && $type && $price) {
			$balance = getUserBalance($gameId);
			if ($balance && $balance[$type] < $price) return jsonResponse('NOT_ENOUGHT_BALANCE');

			self::setLog($gameName, $gameId, $dataURL, $sendText, $serverId);

			$items = config('minigame.questionnaire.gameInfo.items');
			$minigameUserInfo = getMinigameUserInfo($gameId);
			if (!$minigameUserInfo) {
				insertMinigameUserInfo(['gameId'=>$gameId]);
				unset($items[2313]);
			} else {
				if ($minigameUserInfo->itemState == '00001') {
					unset($items[2301]);
				} else {
					unset($items[2313]);
				}
			}
			$targetItem = gachaSystem($items);
			if (!$targetItem) return jsonResponse('SYSTEM_ERROR');

			$itemId = $targetItem['itemId'];
			if ($itemId == 2301) {
				updateMinigameUserInfo(['gameId'=>$gameId,'itemState'=>'00001']);
			}

			$itemName = $targetItem['name'];
			$payInfos = [
				'orderNumber' => genOrderNumber($gameId),
				'gameId'      => $gameId,
				'gameName'    => $gameName,
				'type'        => $type,
				'serverId'    => $serverId,
				'price'       => $price,
				'itemName'    => $itemName,
				'itemId'      => $itemId,
				'transName'   => '神社祈願ミニゲーム',
				'itemList'    => $targetItem['item_list'],
			];
			if (consumptionStep1($payInfos)) {
				if (consumptionStep2($payInfos)) {
					return jsonResponse('SUCCESS', ['itemId'=>$itemId]);
				}
				return jsonResponse('REQUEST_ERROR');
			}
			return jsonResponse('DB_ERROR');
		}
		return jsonResponse('UNKNOWN');
	}

	private function setLog ($gameName, $gameId, $dataURL, $sendText, $serverId) {
		$fileName = $gameName.'_'.$gameId.'_'.date('Y_m_d_H_i_s').'.png';
		$outputFile = 'minigame/'.date('Y_m_d').'/'.$fileName;
		if (!putImgFile($dataURL, $outputFile)) return jsonResponse('SYSTEM_ERROR');

		$logMessage = '"'.$gameId.'","'.$sendText.'","'.$fileName.'","'.$serverId.'","'.date('Y-m-d H:i:s').'",';
		self::logger($logMessage, storage_path('logs/minigame_'.$gameName.'.log'));
	}

	private function logger ($message, $path) {
		Log::useFiles($path);
		Log::info($message);
	}
}
