<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class CampaignController extends Controller{

	public function pageView ($pageName = null, Request $request) {
		$gameId = $this->getGameId();

		$data = [];
		if ($gameId) {
			$data['login'] = true;
			$data['gameId'] = $gameId;
		} else {
			$data['login'] = false;
			$data['gameId'] = null;
		}

		switch ($pageName) {
			case 'newCharacter_1712':
				return response(view('others.newCharaCp_1712', $data), 200);
			case 'first_anniversary':
				return response(view('others.firstAnniversary', $data), 200);
			case 'cosplay2018':
				return response(view('others.cosplay2018', $data), 200);
			case 'Lustercp':
				$req = $request->all();
				$data['from'] = isset($req['from']) ? $req['from'] : false;
				return response(view('others.lusterCp', $data), 200);
            case 'cpColabo201909':
                $req = $request->all();
                $data['from'] = isset($req['from']) ? $req['from'] : false;
                return response(view('others.cpColabo201909', $data), 200);
			case '2thyear':
				$req = $request->all();
				$data['from'] = isset($req['from']) ? $req['from'] : false;
				return response(view('others.2thyear', $data), 200);
			default:
				return redirect('/');
		}
	}

	public function showHTfesta (Request $request) {
		$data = [];

		$req = $request->all();
		$data['from'] = isset($req['from']) ? $req['from'] : false;

		$content = view('others.100k_festa', $data);
		return response($content, 200);
	}

	private function getGameId () {
		genSession();
		return userCheck();
	}
}