<?php
namespace App\Http\Controllers\Minigame;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Session;

class CommonController extends Controller{

	public function __construct(){
		require(app_path('Support/minigame.php'));
	}

	public function gameView ($gameName = null) {
		if (!checkPeriod($gameName)) { return redirect('/'); }

		$gameId = getGameId();

		$data = [];
		$data['login'] = $gameId ? true : false;
		$data['gameId'] = $gameId ?: null;

		switch ($gameName) {
			case 'fireworks': $content = view('minigame.fireworks', $data); break;
			case 'highAndLow': $content = view('minigame.highAndLow', $data); break;
			case 'questionnaire': $content = view('minigame.questionnaire', $data); break;
			default: return redirect('/');
		}
		return response($content, 200);
	}

	public function getHistory (Request $request) {
		$game = $request->input('game', false);
		$gameId = $request->input('uId', false);
		if ($gameId == false) {
			$gameId = getGameId();
		}
		$limit = $request->input('limit', false);
		$offset = $request->input('offset', false);

		if ($gameId && $game) {
			$serchParams = [$gameId,$game];
			$addLimit = $limit ? 'limit '.$limit : '';
			$addOffset = $offset ? 'offset '.$offset : '';
			$addWhere = '';

			if ($game == 'sugoroku') {
				$addWhere = 'and price<=0';
			}

			$minigameHistory = DB::select('select price, itemName, game, createdAt from minigameHistory where gameId=? and game=? '.$addWhere.' order by id desc '.$addLimit.' '.$addOffset, $serchParams);

			if ($game == 'gacha') {
				$tmpHistory = [];
				foreach ($minigameHistory as $value) {
					$items = explode(';', $value->itemName);
					foreach ($items as $itemName) {
						$tmpHistory[] = [
							'price' => $value->price,
							'itemName' => $itemName,
							'game' => $value->price,
							'createdAt' => $value->createdAt,
						];
					}
				}
				$minigameHistory = $tmpHistory;
			}

			return jsonResponse('SUCCESS', ['history' => $minigameHistory]);
		}
		return jsonResponse('UNKNOWN');
	}

	public function fetchServerList (Request $request) {
		$gameId = getGameId();
		$postGameId = $request->input('gId', false);

		if ($gameId && $gameId == $postGameId) {
			$data = fetchServerInfos($gameId);
			if ($data) {
				return jsonResponse('SUCCESS', ['data' => $data]);
			}
		}
		return jsonResponse('REQUEST_ERROR');
	}

	public function fetchUserPoint  (Request $request) {
		$gameId = getGameId();
		$postGameId = $request->input('gId', false);
		if ($gameId && $gameId == $postGameId) {
			$balance = getUserBalance($gameId);
			if ($balance) {
				return jsonResponse('SUCCESS', ['up' => $balance['point']]);
			}
		}
		return jsonResponse('UNKNOWN');
	}

}