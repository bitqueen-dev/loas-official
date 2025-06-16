<?php
use GuzzleHttp\Client as GuzzleHttpClient;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

function consumptionStep1 ($datas) {
	$orderNumber = isset($datas['orderNumber']) ? $datas['orderNumber'] : false;
	$gameId      = isset($datas['gameId'])      ? $datas['gameId']      : false;
	$gameName    = isset($datas['gameName'])    ? $datas['gameName']    : false;
	$type        = isset($datas['type'])        ? $datas['type']        : false;
	$serverId    = isset($datas['serverId'])    ? $datas['serverId']    : 0;
	$price       = isset($datas['price'])       ? $datas['price']       : false;
	$itemName    = isset($datas['itemName'])    ? $datas['itemName']    : false;
	$itemId      = isset($datas['itemId'])      ? $datas['itemId']      : false;
	$transName   = isset($datas['transName'])   ? $datas['transName']   : false;
	if ($gameId && $gameName && $type && $price && $itemName && $itemId) {
		try {
			DB::beginTransaction();
			if ($type == 'coin') {
				consumptionCoin($orderNumber,$gameId,$serverId,$price,$gameName);
			} else if ($type == 'point') {
				if ($transName) {
					consumptionPoint($orderNumber,$gameId,$price,$itemId,$transName);
				} else {
					DB::rollback(); return false;
				}
			} else {
				DB::rollback(); return false;
			}
			insertMinigameHistory($gameName,$orderNumber,$gameId,$serverId,$price,$type,$itemId,$itemName);
			DB::commit();
			return true;
		} catch (Exception $e) {
			DB::rollback();
		}
	}
	return false;
}

function consumptionStep2 ($datas) {
	$orderNumber  = isset($datas['orderNumber'])  ? $datas['orderNumber']  : false;
	$gameId       = isset($datas['gameId'])       ? $datas['gameId']       : false;
	$gameName     = isset($datas['gameName'])     ? $datas['gameName']     : false;
	$serverId     = isset($datas['serverId'])     ? $datas['serverId']     : 0;
	$itemName     = isset($datas['itemName'])     ? $datas['itemName']     : false;
	$itemList     = isset($datas['itemList'])     ? $datas['itemList']     : false;
	$giveGameItem = isset($datas['giveGameItem']) ? $datas['giveGameItem'] : false;
	if (
		($orderNumber && $giveGameItem) ||
		($orderNumber && $gameId && $gameName && $itemName && $itemList)
	) {
		$currentTime = time();
		$params = $giveGameItem ?: [
			'time' => $currentTime,
			'verify' => md5('@#$%6666&^%$' . $currentTime . $serverId),
			'title' => 'アイテム獲得のお知らせ',
			'content' => 'お客様は、【' . $itemName . '】を獲得しました。 添付アイテムをお受取ください。',
			'server_id' => $serverId,
			'user_list' => $gameId,
			'item_list' => $itemList, //itemId1:count;itemId2:count;itemId3:count
		];
		if (giveGameItem($params) && updateMinigameHistory($orderNumber)) {
			return true;
		}
	}
	return false;
}

function insertMinigameHistory ($gameName,$orderNumber,$gameId,$serverId,$price,$type,$itemId,$itemName) {
	DB::insert('insert into minigameHistory (orderNumber, gameId, price, type, itemId, itemName, game, status, serverId) values (?,?,?,?,?,?,?,?,?)', 
		[$orderNumber,$gameId,'-'.$price,$type,$itemId,$itemName,$gameName,0,$serverId]);
}

function insertCompleteMinigameHistory ($gameName,$orderNumber,$gameId,$serverId,$price,$type,$itemId,$itemName) {
	DB::insert('insert into minigameHistory (orderNumber, gameId, price, type, itemId, itemName, game, status, serverId) values (?,?,?,?,?,?,?,?,?)', 
		[$orderNumber,$gameId,$price,$type,$itemId,$itemName,$gameName,1,$serverId]);
}

function updateMinigameHistory ($orderNumber) {
	return DB::update('update minigameHistory set status=1,updatedAt=? where orderNumber=?', [date('Y-m-d H:i:s'), $orderNumber]);
}

function consumptionPoint ($orderNumber,$gameId,$point,$itemId,$transName) {
	DB::insert('insert into pointHistory (orderNumber, type, pointPrice, transName, userGameId, code, itemId) values (?,?,?,?,?,?,?)', 
		[$orderNumber,'consumption','-'.$point,$transName,$gameId,null,$itemId,]);
	DB::update('update users set point=point-? where gameId=?', [$point, $gameId]);
}

function consumptionCoin ($orderNumber,$gameId,$serverId,$coin,$gameName) {
	DB::insert('insert into coinHistory (orderNumber, type, coinPrice, serverId, userGameId,game) values (?,?,?,?,?,?)', 
		[$orderNumber,'consumption','-'.$coin,$serverId,$gameId,'loas_minigame_'.$gameName]);
	DB::update('update users set coin=coin-? where gameId=?', [$coin, $gameId]);
}

function givePoint ($orderNumber,$gameId,$point,$itemId,$transName) {
	DB::insert('insert into pointHistory (orderNumber, type, pointPrice, transName, userGameId, code, itemId) values (?,?,?,?,?,?,?)', 
		[$orderNumber,'bonus',$point,$transName,$gameId,null,$itemId,]);
	DB::update('update users set point=point+? where gameId=?', [$point,$gameId]);
}

// itemList => itemId1:count;itemId2:count;itemId3:count
// Caution: last ";"is not need
// ** Caution [change logic] ** itemId1:count,itemId2:count,itemId3:count / Jan19 GachaGame
function giveGameItem ($params) {
	try {
		$client = new GuzzleHttpClient();
		$uriBase = 'http://webout.loas.jp/reward?';
		$uriReward = $uriBase . http_build_query($params);

		$response = $client->request('GET', $uriReward);
		$contents = $response->getBody()->getContents();
		$result = json_decode($contents, true);

		if ($result['errCode'] == 0) {
			return true;
		}
	} catch (Exception $e) {}
	return false;
}

function consumeDiamond ($userGameId, $serverId, $price, $type) {
	$res = ['status' => -999, 'msg' => 'unknown'];
	$currentTime = time();
	$params = [
		'account' => $userGameId,
		'sid' => $serverId,
		'bmoney' => $type == 'blueDiamond' ? $price : 0,
		'gmoney' => $type == 'goldDiamond' ? $price : 0,
		'time' => $currentTime,
		'verify' => md5('@#$%6666&^%$' . $currentTime . $serverId),
	];

	try {
		$client = new GuzzleHttpClient();
		$uriBase = 'http://webout.loas.jp/consume?';
		$uriReward = $uriBase . http_build_query($params);

		$response = $client->request('GET', $uriReward);
		$contents = $response->getBody()->getContents();
		$result = json_decode($contents, true);

		if (isset($result)) {
			if ($result['status'] == 0) {
				$res['status'] = 1;
				$res['mgs'] = 'Success';
			} else if ($result['status'] == 8) {
				$res['status'] = -1;
				$res['mgs'] = 'Not Enought';
			}
		}
	} catch (Exception $e) {}
	return $res;
}

function fetchServerInfos ($gameId) {
	if ($gameId) {
		try {
			$userInfo = [];
			$data['serverInfo'] = [];
			foreach (config('gameInfo.serverInfo') as $server) {
				$serverId = $server['serverId'];
				/////////TEST
				/*
					$data['serverInfo'][$serverId]['userName'] = 'TEST'.$serverId;
					$data['serverInfo'][$serverId]['serverName'] = 'ワールド'.mb_substr($serverId,-2);
					$data['serverInfo'][$serverId]['level'] = 100;
					continue;
				*/
				/////////TEST
				$params = array(
					'op_id' => $server['opId'],
					'sid' => $serverId,
					'game_id' => $server['gameId'],
					'accounts' => $gameId,
					'time' => time(),
				);
				$auth = base64_encode(http_build_query($params));
				$verify = md5($auth . $server['apiKey']);
				$uriGetUserGameInfo = "http://pay.loas.jp/api/accessport/userInfo?auth=$auth&verify=$verify";

				$client = new GuzzleHttpClient();
				$response = $client->request('GET', $uriGetUserGameInfo);
				$contents = $response->getBody()->getContents();
				$userInfo = json_decode($contents, true);

				if (isset($userInfo['data']) && isset($userInfo['data'][$gameId])) {
					$userGameInfo = array_values($userInfo['data'][$gameId]);

					if (isset($userGameInfo[0])) {
						$data['serverInfo'][$serverId]['userName'] = $userGameInfo[0]['role_name'];
						$data['serverInfo'][$serverId]['serverName'] = $server['serverName'];
						$data['serverInfo'][$serverId]['level'] = $userGameInfo[0]['level'];
					}
				}
			}
			return $data;
		} catch (Exception $e) {}
	}
	return false;
}

function getUserBalance ($gameId) {
	$balance = DB::select('select coin, point from users where gameId=?', [$gameId]);
	if (isset($balance[0])) {
		return [ 'coin' => $balance[0]->coin, 'point' => $balance[0]->point, ];
	}
	return false;
}

function getMinigameUserInfo ($gameId) {
	$record = DB::select('select * from minigameUserInfo where gameId=? limit 1', [$gameId]);
	if (!empty($record)) {
		return $record[0];
	}
	return false;
}

function insertMinigameUserInfo ($datas) {
	$keys   = '';
	$values = '';
	$params = [];
	foreach ($datas as $key => $value) {
		if ($keys   != '') { $keys  .=','; }
		if ($values != '') { $values.=','; }
		$keys    .= $key;
		$values  .= '?';
		$params[] = $value;
	}
	return DB::insert('insert into minigameUserInfo ('.$keys.') values ('.$values.')', $params);
}

function updateMinigameUserInfo ($datas) {
	$set = '';
	$gameId = null;
	foreach ($datas as $key => $value) {
		if ($set != '') $set.=',';
		if ($key == 'gameId') {
			$gameId = $value;
			continue;
		}
		$set .= $key.'="'.$value.'"';
	}
	$set.=',updatedAt="'.date('Y-m-d H:i:s').'"';
	return DB::update('update minigameUserInfo set '.$set.' where gameId=?', [$gameId]);
}

function genOrderNumber($gameId) {
	return md5($gameId . time() . rand(1, 100));
}

function getSugorokuPanelInfo () {
	$panelInfo = [];
	$panelInfoConf = config('minigame.sugoroku.gameInfo.panelInfo');
	$probabilityPanel = $panelInfoConf['probabilityPanel'];
	foreach ($probabilityPanel as $panelNum => $rareKey) {
		$items = $panelInfoConf['rare'][$rareKey]['items'];
		$tmp = [];
		foreach ($items as $id) {
			$tmp[] = $panelInfoConf['itemIds'][$id]['name'];
		}
		$panelInfo[] = [
			'items' => $tmp,
			'rare' => $rareKey,
		];
	}
	return $panelInfo;
}

function getGameId () {
	genSession();
	return userCheck();
}

function checkPeriod($gameName) {
	$conf = config('minigame.' . $gameName);
	if ($conf) {
		$ipWhiteList = isset($conf['ipWhiteList']) ? $conf['ipWhiteList'] : config('minigame.commonInfo.ipWhiteList');
		$currentIp = \Request::ip();
		foreach ($ipWhiteList as $value) {
			if ($currentIp == $value) { return true; }
		}

		$nowTime = date("Y-m-d H:m:s", time());
		$canPlayTime = explode('|', $conf['setting']['period']);
		if ($canPlayTime[0] <= $nowTime && $nowTime <= $canPlayTime[1]) {
			return true;
		}
	}
	return false;
}

function gachaSystem ($items) {
	if (isset($items[0]['probability'])) return false;

	$overallProbability = 0;
	foreach ($items as $value) {
		$overallProbability += $value['probability'];
	}

	$target = rand(1, $overallProbability);
	foreach ($items as $value) {
		$checkProbability = $value['probability'];
		if ($target <= $checkProbability) {
			return $value;
		} else {
			$target -= $checkProbability;
		}
	}
	return false;
}

function putImgFile ($base64_string, $outputFile) {
	$data = explode(',', $base64_string);
	$contents = base64_decode($data[1]);
	return Storage::put($outputFile, $contents);
}

function addPlayCountHighAndLowToSugoroku ($gameId) {
	$minigameUserInfo = getMinigameUserInfo($gameId);
	if (!$minigameUserInfo) { return false; } // this player dont play sugoroku but he is playing highAndLow

	$playCount = $minigameUserInfo->highAndLowPlayCount;

	if ($playCount == 9) {
		updateMinigameUserInfo([
			'gameId' => $gameId,
			'freePlayCredit' => 'freePlayCredit+1',
			'highAndLowPlayCount' => 0,
		]);

		$conf = config('minigame.sugoroku.gameInfo.userAction.playHighAndLow');
		$orderNumber = genOrderNumber($gameId);

		insertMinigameHistory('highAndLow',$orderNumber,$gameId,0,1,'playCount',$conf['itemId'],$conf['itemName']);
	} else {
		updateMinigameUserInfo(['gameId'=>$gameId,'highAndLowPlayCount'=>'highAndLowPlayCount+1']);
	}
	return true;
}

/**
 * @param 	$status 	string
 * @param 	$dataArr 	array
 * @return 	response()->json($resArr);
 * */
function jsonResponse($status = null, $dataArr = []) {
	switch ($status) {
		case 'SUCCESS':             $resArr = [ 'status' => true,  'code' => '0',    'msg' => 'Success!' ]; break;
		case 'SYSTEM_ERROR':        $resArr = [ 'status' => false, 'code' => '-2',   'msg' => 'System error!' ]; break;
		case 'NETWORK_ERROR':       $resArr = [ 'status' => false, 'code' => '-3',   'msg' => 'Network error!' ]; break;
		case 'NOT_SELECT_SERVER':   $resArr = [ 'status' => false, 'code' => '-4',   'msg' => 'Not select server!' ]; break;
		case 'NOT_ENOUGHT_BALANCE': $resArr = [ 'status' => false, 'code' => '-5',   'msg' => 'Not enought balance!' ]; break;
		case 'NOT_LOGIN':           $resArr = [ 'status' => false, 'code' => '-6',   'msg' => 'Not login!' ]; break;
		case 'DB_ERROR':            $resArr = [ 'status' => false, 'code' => '-7',   'msg' => 'DB error!' ]; break;
		case 'REQUEST_ERROR':       $resArr = [ 'status' => false, 'code' => '-8',   'msg' => 'Request Error!' ]; break;
		case 'NOT_ENOUGHT_POINT':   $resArr = [ 'status' => false, 'code' => '-9',   'msg' => 'Not enought point!' ]; break;
		case 'CLOSED_GAME':         $resArr = [ 'status' => false, 'code' => '-10',  'msg' => 'Already closed game!'];break;
		case 'ALREADY':             $resArr = [ 'status' => false, 'code' => '-11',  'msg' => 'Already done!' ]; break;
		default:                    $resArr = [ 'status' => false, 'code' => '-999', 'msg' => 'Unknown error!' ];
	}

	foreach ($dataArr as $key => $val) {
		$resArr[$key] = $val;
	}
	return response()->json($resArr);
}