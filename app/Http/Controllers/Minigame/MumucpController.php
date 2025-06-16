<?php
namespace App\Http\Controllers\Minigame;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class MumucpController extends Controller{

	public function __construct(){
		require(app_path('Support/minigame.php'));
	}

	public function showMumucp(){
		$gameName = 'mumucp';

		$data = [];
		$data['endCp'] = (checkPeriod($gameName)) ? false : true;

		$gameId = getGameId();
		$data['isPlayCountMax'] = 0;

		if ($gameId) {
			$data['login'] = true;
			$data['gameId'] = $gameId;
			$data['leftCount'] = 1;

			$record = getMinigameUserInfo($gameId);
			if (!$record) {
				insertMinigameUserInfo(['gameId'=>$gameId]);
			} else {
				$usedPoint = $record->usedPoint;
				$data['leftCount'] -= $record->givePointState;

				if ($usedPoint != 0) {
					$canPlayCount = floor($usedPoint / 10);

					if ($canPlayCount >= 5) {
						$canPlayCount = 4;
						$data['isPlayCountMax'] = 1;
					}
					$data['leftCount'] += $canPlayCount;
				}
			}
		} else {
			$data['login'] = false;
			$data['leftCount'] = 0;
		}

		$content = view('others.mumucp', $data);
		return response($content, 200);
	}

	public function playMumucp(Request $request){
		$gameName = 'mumucp';
		if (!checkPeriod($gameName)) return jsonResponse('CLOSED_GAME');

		$gameId = getGameId();
		$postGameId = $request->input('gId', false);

		if ($gameId && $gameId == $postGameId) {
			try {
				$record = getMinigameUserInfo($gameId);
				if ($record) {
					$data = [];
					
					$givePointState = intval($record->givePointState);
					$givePointItems = config('minigame.mumucp.givePointItems');

					if ($givePointState == 0) {

						$itemInfo = gachaSystem($givePointItems);
						$itemId = $itemInfo['itemId'];
						$itemName = $itemInfo['name'];
						$price = $itemInfo['givePoint'];

						DB::beginTransaction();

						$orderNumber = genOrderNumber($gameId);
						givePoint($orderNumber,$gameId,$price,$itemId,$itemName);
						insertCompleteMinigameHistory($gameName,$orderNumber,$gameId,0,$price,'point',$itemId,$itemName);

						updateMinigameUserInfo([
							'gameId' => $gameId, 
							'givePointState' => 1, 
							'preGivePointId' => $itemId,
						]);

						DB::commit();
					} else {
						if ($givePointState >= 5) return jsonResponse('NOT_ENOUGHT_POINT');

						if (($givePointState * 10) <= intval($record->usedPoint)) {
							
							if ($givePointState == 1 || $givePointState == 3) {
								$nextNum = $givePointItems[$record->preGivePointId]['next'];

								if ($nextNum == 0) {
									$itemInfo = gachaSystem($givePointItems);
								} else {
									$nextInfo = config('minigame.mumucp.nextInfo')[$nextNum];
									$tmpInfo = gachaSystem($nextInfo);
									$itemInfo = $givePointItems[$tmpInfo['itemId']];
								}
							} else {
								$itemInfo = gachaSystem($givePointItems);
							}

							DB::beginTransaction();

							$itemId = $itemInfo['itemId'];
							$itemName = $itemInfo['name'];
							$price = $itemInfo['givePoint'];

							$orderNumber = genOrderNumber($gameId);
							givePoint($orderNumber,$gameId,$price,$itemId,$itemName);
							insertCompleteMinigameHistory($gameName,$orderNumber,$gameId,0,$price,'point',$itemId,$itemName);

							updateMinigameUserInfo([
								'gameId' => $gameId, 
								'givePointState' => ($givePointState+1), 
								'preGivePointId' => $itemId,
							]);

							DB::commit();
						} else {
							return jsonResponse('NOT_ENOUGHT_POINT');
						}
					}

					$data['img'] = $itemInfo['img'];

					return jsonResponse('SUCCESS', $data);
				} else {
					return jsonResponse('NOT_LOGIN');
				}
			} catch (Exception $e) {
				DB::rollback();
				return jsonResponse('DB_ERROR');
			}
		}
		return jsonResponse('UNKNOWN');
	}
}