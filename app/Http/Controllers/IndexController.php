<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class IndexController extends Controller{
	public function index(Request $request) {
		$req = $request->all();

		//TODO session logic is not good now
		genSession();

		$data = [];
		if (isset($req['topic']) && ($req['topic'] == 'refresh')) {
			$data['topics'] = getTopicsAll(['event', 'notice', 'maintenance', 'update'], 17, true);
		} else {
			$data['topics'] = getTopicsAll(['event', 'notice', 'maintenance', 'update'], 17);
		}
		
		$data['popup'] = isset($req['pop']) ? $req['pop'] : false;

		$from = isset($req['from']) ? $req['from'] : false;

		// $affiliate_param_afult = isset($req['afult']) ? $req['afult'] : '';

        $gameId = userCheck();
        if ($gameId) {
            $servers = config('gameInfo.serverInfo');

            //检查打开什么版本的选择界面，默认exe版本
            $client = $request->get('client', 'exe');
            $data['client'] = $client;


            $data['serverInfo'] = [];

            foreach ($servers as $serverId => $info) {
                if (!self::isServerOpen($info)) {
                    continue;
                }
                $serverInfo[$serverId]['serverName'] = $info['serverName'];
                $serverInfo[$serverId]['iconState'] = self::serverStateIcon($info);
            }

            $data['serverInfo'] = $serverInfo;
            $data['gameId'] = $gameId;

            $tStamp = date('YmdHis');
            $hash = strtoupper(md5(strtoupper(md5(config('app.netcafeKey'))) . $tStamp));

            $netcafeParams = [
                'gameID' => config('app.netcafeGameId'),
                'userID' => $gameId,
                'tStamp' => $tStamp,
                'hash' => $hash,
            ];
            $data['netcafeTimerUri'] = config('app.netcafeTimetoolUri') . '?' . http_build_query($netcafeParams);
        }

        $data['isMaintenance'] = isMaintenance();


		$content = view('index', $data);

		if($from) {
			return response($content, 200)
				->cookie('MMCF', $from, 60 * 24, '/');
				// ->cookie('AFAF',$affiliate_param_afult);
		}

		return response($content, 200);
			// ->cookie('AFAF',$affiliate_param_afult);
	}

    private function isServerOpen($serverInfo) {
        $serverOpenTime = strtotime($serverInfo['openTime']) ?: 0;
        $currentTime = time();
        $userIp = \Request::ip();

        if ((($serverOpenTime < $currentTime) && $serverOpenTime != 0) || (in_array($userIp, config('gameInfo.ipWhiteList')))) {
            return true;
        }

        return false;
    }


    private function serverStateIcon($serverInfo) {
        $iconState = isset($serverInfo['iconState']) ? $serverInfo['iconState'] : false;

        if ($iconState && $iconState != 'normal') {
            $ret = [];

            foreach ($iconState as $state => $timeArr) {
                $iconShowTimeArr = explode('|', $timeArr);

                $iconShowTimeStart = strtotime($iconShowTimeArr[0]) ?: 0;
                $iconShowTimeEnd = strtotime($iconShowTimeArr[1]) ?: 0;
                $currentTime = time();

                if (($currentTime >= $iconShowTimeStart) && ($currentTime <= $iconShowTimeEnd)) {
                    $ret[] = $state;
                }
            }

            return $ret;
        }

        return [];
    }
}