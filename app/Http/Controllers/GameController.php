<?php
namespace App\Http\Controllers;

use Cookie;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameController extends Controller {
	public function serverSelect(Request $request) {
		$gameId = userCheck();
		if ($gameId !== false) {
			$dataPage = [];

			$servers = config('gameInfo.serverInfo');

			//检查打开什么版本的选择界面，默认exe版本
            $client = $request->get('client', 'exe');
            $dataPage['client'] = $client;


			$dataPage['serverInfo'] = [];

			foreach ($servers as $serverId => $info) {
				if (!self::isServerOpen($info)) {
					continue;
				}
				$serverInfo[$serverId]['serverName'] = $info['serverName'];
				$serverInfo[$serverId]['iconState'] = self::serverStateIcon($info);
			}

			$dataPage['serverInfo'] = $serverInfo;
			$dataPage['gameId'] = $gameId;

			$tStamp = date('YmdHis');
			$hash = strtoupper(md5(strtoupper(md5(config('app.netcafeKey'))) . $tStamp));

			$netcafeParams = [
				'gameID' => config('app.netcafeGameId'),
				'userID' => $gameId,
				'tStamp' => $tStamp,
				'hash' => $hash,
			];
			$dataPage['netcafeTimerUri'] = config('app.netcafeTimetoolUri') . '?' . http_build_query($netcafeParams);


            $content = view('game.serverSelect', $dataPage);

			if(isMaintenance() === true) {
				$content = view('game.serverSelectMaint', $dataPage);
			}

			return response($content, 200);
		}

		return 'Unknow Error!';
	}

	public function play($serverId) {
		if(isMaintenance() === true) {
			return '<div style="font-size: 20px;width: 450px;margin: auto;margin-top: 100px;border: 1px dashed #000;padding-left: 20px;padding-bottom: 10px;"><h1 style="text-align: center;">メンテナンス中</h1>ただいまメンテナンスを実施しています。<br /><br />ご利用の皆さんにはご迷惑をおかけし、<br />大変申し訳ございません。<br />メンテナンス終了までしばらくお待ち下さい。</div>';
		}

		$gameId = userCheck();
		$currentServerInfo = isset(config('gameInfo.serverInfo')[$serverId]) ? config('gameInfo.serverInfo')[$serverId] : false;

		if (($gameId !== false) && $serverId && $currentServerInfo && self::isServerOpen($currentServerInfo)) {
			$dataPage = [];

			$dataPage['playUri'] = mm2MakePlayUri($gameId, $currentServerInfo);
			$dataPage['serverName'] = $currentServerInfo['serverName'];

			$time = time();
			$dataPage['sign'] = encrypt($gameId . '|' . $serverId . '|' . $time);

			insertIntoUserEventLog($gameId, 'gameplay', $serverId);

            $dataPage['purchaseInfo'] = config('gameInfo.purchaseInfo');

//	echo json_encode($dataPage);exit;
			$content = view('game.play', $dataPage);
			return response($content, 200);
		}

		return redirect('/');
	}

	public function startClient($serverId) {
        $gameId = userCheck();
		// echo("gameId:".$gameId);
        $currentServerInfo = isset(config('gameInfo.serverInfo')[$serverId]) ? config('gameInfo.serverInfo')[$serverId] : false;
        if (($gameId !== false) && $serverId && $currentServerInfo && self::isServerOpen($currentServerInfo)) {
            return response()->json([
                'url' => getClientUrlFromPlayUrl(mm2MakePlayUri($gameId, $currentServerInfo))
            ]);
        }
    }

	public function diamondPurchase(Request $request) {
		$sign = $request->get('_sign', false);
		$token = $request->get('_token', false);
		$serverId = $request->get('serverId', false);
		$accountId = $request->get('accountId', false);
		$itemId = $request->get('itemId', false);

		DB::beginTransaction();
		try {
			$signInfo = explode('|', decrypt($sign));

			if ((count($signInfo) != 3) || ($signInfo[0] != $accountId) || ($signInfo[1] != $serverId)) {
				return response()->json(['status' => false, 'errNo' => '-2', 'msg' => 'sign error']);
			}

            $purchaseInfo = config('gameInfo.purchaseInfo');

			$currentItemInfo = isset($purchaseInfo[$itemId]) ? $purchaseInfo[$itemId] : false;
			if (!$currentItemInfo) {
				return response()->json(['status' => false, 'errNo' => '-3', 'msg' => 'item id error']);
			}

			$userBalance = getUserBalanceByGameId($accountId);
			if ($userBalance < $currentItemInfo['price']) {
				return response()->json(['status' => false, 'errNo' => '-4', 'msg' => 'coin not enough']);
			}

			$orderId = md5(time() . 'diamondPurchase' . mt_rand());
			$dataProc = [$accountId, $serverId, $itemId, $currentItemInfo['diamond'], $currentItemInfo['price'], $orderId, -1, $token, $sign];
			DB::insert('insert into diamondPurchaseProc (gameAccountId,gameServerId,itemId,diamondNum,price,orderId,state,token,sign) values (?,?,?,?,?,?,?,?,?)', $dataProc);
			DB::update('update users set coin=coin-? where gameId=?', [$currentItemInfo['price'], $accountId]);

			if (giveDiamonds($orderId, $serverId, $accountId)) {
				genSession(true);
				$sign = encrypt($accountId . '|' . $serverId . '|' . time());

				DB::insert('insert into coinHistory (orderNumber,type,coinPrice,userGameId, serverId) values (?,?,?,?,?)', [$orderId, 'consumption', -1 * $currentItemInfo['price'], $accountId, $serverId]);

				// self::minigameChargeBonus($accountId, $itemId, 'gacha');

				DB::commit();

				insertIntoUserEventLog($accountId, 'purchase', $serverId);

				return response()->json(['status' => true, 'errNo' => '', 'msg' => 'success', 'sign' => $sign]);
			}
		} catch (DecryptException $e) {
			DB::rollback();
			return response()->json(['status' => false, 'errNo' => '-2', 'msg' => 'sign error']);
		} catch (QueryException $e) {
			DB::rollback();
			return response()->json(['status' => false, 'errNo' => '-5', 'msg' => 'DB error']);
		} catch (Exception $e) {
			DB::rollback();
			return response()->json(['status' => false, 'errNo' => '-1', 'msg' => 'unknow error']);
		}

		DB::rollback();
		return response()->json(['status' => false, 'errNo' => '-1', 'msg' => 'unknow error']);
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

	private function minigameChargeBonus ($userGameId, $itemId, $gameName) {
		// now gacha only
		if (isset(config('minigame.gacha.purchaseBonus')[$itemId]['ticket'])) {
			$ticket = config('minigame.gacha.purchaseBonus')[$itemId]['ticket'];
			if ($ticket > 0) {
				$table = DB::table('gachaUserInfo');
				$record = $table->where('userGameId','=',$userGameId)->limit(1)->get();
				if (isset($record[0])) {
					$table->where('userGameId','=',$userGameId)->update(['ticket' => $record[0]->ticket + $ticket]);
				} else {
					$table->insert(['userGameId' => $userGameId, 'specialPlayCreditA'=>1, 'specialPlayCreditB'=>1, 'ticket' => $ticket]);
				}
				DB::table('minigameHistory')->insert([
					'orderNumber'=>md5($userGameId . time() . rand(1, 100)),
					'gameId'=>$userGameId,
					'price'=>$ticket,
					'type'=>'addTicket',
					'itemId'=>$itemId,
					'itemName'=>$gameName.'_ticket',
					'game'=>$gameName,
					'status'=>1,
					'serverId'=>0,
				]);
			}
		}
	}
}