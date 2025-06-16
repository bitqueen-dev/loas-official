<?php
namespace App\Http\Controllers;

use Cookie;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiamondChargeController extends Controller {

    private $purchaseInfo;

    public function __construct()
    {
        $this->purchaseInfo = config('gameInfo.purchaseInfo');
    }

    public function chargePage() {
		$data = [];
		$data['purchaseInfo'] = $this->purchaseInfo;

        genSession();
        $gameId = userCheck();

        $userGameInfo = getGameInfoByUserGameId($gameId);
        $time = time();
        foreach ($userGameInfo as $gameId => $userinfo ) {
            $userGameInfo[$gameId]['sign'] =  encrypt($userinfo['userGameId'] . '|' . $userinfo['serverId'] . '|' . $time);
        }

        $data['userGameInfo'] = $userGameInfo;

		$content = view('diamondCharge.chargePage', $data);
		return response($content, 200);
	}



}