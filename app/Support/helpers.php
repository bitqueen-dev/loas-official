<?php
function getTopicInfoFromMT($type = NULL, $start = 0, $count = 50) {
	$client = new GuzzleHttp\Client();

	if ($type) {
		$res = $client->request('GET', 'https://easygame.jp/loa2/all_platform/official_' . $type . 'List.xml', [
			'connect_timeout' => 3,
		]);

		if (($res->getStatusCode() == '200') && $res->getBody()) {
			try {
				$topics = simplexml_load_string($res->getBody(), 'SimpleXMLElement', LIBXML_NOCDATA);

				foreach ($topics->entry as $entry) {
					$tmp['title'] = trim((string) $entry->title);
					$tmp['link'] = trim((string) $entry->link->attributes()->href);
					$tmp['published'] = trim((string) $entry->published);
					$tmp['updated'] = trim((string) $entry->updated);
					$tmp['summary'] = trim((string) $entry->summary);
					$tmp['content'] = trim((string) $entry->content);

					$eventInfo[] = $tmp;
				}

				if (is_array($eventInfo)) {
					return $eventInfo;
				}
			} catch (Exception $e) {
				return false;
			}
		}
	}

	return false;
}

function getClientUrlFromPlayUrl($playUrl) {
//    echo $playUrl;
    $http = 'http:';
    $http =is_ssl()?'https:':$http;
	// echo("playUrl:".$playUrl);
    // $headers = get_headers($http.$playUrl,1);

	$url = $http.$playUrl;
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_HEADER => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_NOBODY => true));
	$headers = explode("\n", curl_exec($curl));
	curl_close($curl);

    if ($headers){
		foreach($headers as $info){
			if (strpos($info, "location") !== false){
				$gameUrl = str_replace("location: ","", $info);
				return 'loas2mclient://' . base64_encode($gameUrl);
			}
		}
    }
    return "/";
}

function is_ssl() {
    if(isset($_SERVER['HTTPS']) && ('1' == $_SERVER['HTTPS'] || 'on' == strtolower($_SERVER['HTTPS']))){
        return true;
    }elseif(isset($_SERVER['SERVER_PORT']) && ('443' == $_SERVER['SERVER_PORT'] )) {
        return true;
    }
    return false;
}

function makeNewestTopic($limit = 20) {
	if ($topicsNewest = DB::select('select * from topics order by createdAt desc limit ' . $limit)) {
		return $topicsNewest;
	}

	return false;
}

function getLastUpdateTimeByTypeFromMT($type = 'newest') {
	try {
		$client = new GuzzleHttp\Client();
		$res = $client->request('GET', 'https://easygame.jp/loa2/all_platform/lastUpdateTime.xml', [
			'connect_timeout' => 3,
		]);

		if (($res->getStatusCode() == '200') && $res->getBody()) {
			$time = simplexml_load_string($res->getBody(), 'SimpleXMLElement', LIBXML_NOCDATA);

			if ($ret = trim((string) $time->$type)) {
				return $ret;
			}

		}

	} catch (Exception $e) {
		return false;
	}

	return false;
}

function getLastUpdateTimeByTypeFromDB($type) {
	$time = DB::select('select updatedAt from topics where type=? order by updatedAt desc limit 1', [config('app.typeIds')[$type]['id']]);
	if ($time) {
		return $time[0]->updatedAt;
	}

	return false;
}

function syncTopicsByType($type) {
	DB::delete('delete from topics where type=?', [config('app.typeIds')[$type]['id']]);
	$infos = getTopicInfoFromMT($type);

	if (is_array($infos)) {
		foreach ($infos as $info) {
			$data = [$info['title'], $info['link'], $info['summary'], config('app.typeIds')[$type]['id'], config('app.typeIds')[$type]['name'], config('app.typeIds')[$type]['navName'], $type, $info['content'], md5($info['link'] . $info['title']), $info['published'], $info['updated']];

			DB::insert('insert into topics (title,link,summary,type,typeName,typeNameJa,typeNameSimp,content,fingerprint,createdAt,updatedAt) values (?,?,?,?,?,?,?,?,?,?,?)', $data);
		}
	}
}

function getTopicsByType($type, $limit = false, $needRefresh = false) {
	if ($needRefresh === true) {
		syncTopicsByType($type);
	}

	if ($type == 'newest') {
		return makeNewestTopic();
	}

	$sql = 'select * from topics where type=? order by createdAt desc';
	if ($limit) {
		$sql = 'select * from topics where type=? order by createdAt desc limit ' . $limit;
	}

	$ret = DB::select($sql, [config('app.typeIds')[$type]['id']]);
	if ($ret === false) {
		return array();
	} else {
		return $ret;
	}

	return false;
}

function getTopicsAll($typeList, $limit = false, $needRefresh = false) {
	if (is_array($typeList)) {
		$topic['newest'] = $topicsNewest = makeNewestTopic($limit);

		if ($topicsNewest != false) {

			$lastupdateTimeDB = '0000-00-00 00:00:00';
			foreach ($topicsNewest as $value) {
				if ($lastupdateTimeDB < $value->updatedAt) {
					$lastupdateTimeDB = $value->updatedAt;
				}
			}

			$lastupdateTimeMT = getLastUpdateTimeByTypeFromMT();
			if ($needRefresh == false && $lastupdateTimeMT != false && $lastupdateTimeDB != $lastupdateTimeMT) {
				$needRefresh = true;
			}

		} else {
			$needRefresh = true;
		}

		foreach ($typeList as $type) {
			$topic[$type] = getTopicsByType($type, $limit, $needRefresh);
		}

		if ($needRefresh) {
			$topic['newest'] = makeNewestTopic($limit);
		}

		return $topic;
	}

	return false;
}

function getTopicById($topicId) {
	if ($ret = DB::select('select * from topics where fingerprint=?', [$topicId])) {
		return $ret[0];
	}

	return false;
}

function mm2MakePlayUri($accountId, $currentServerInfo) {
	$currentTime = time();
	$remoteIP = getenv('REMOTE_ADDR');
	$uriBase = config('gameInfo.apiBaseUri');
	$key = $currentServerInfo['apiKey'];

	$paras = array(
		'op_id' => $currentServerInfo['opId'],
		'sid' => $currentServerInfo['serverId'],
		'game_id' => $currentServerInfo['gameId'],
		'account' => $accountId,
		'adult_flag' => 1,
		'game_time' => $currentTime,
		'ip' => $remoteIP,
		'ad_info' => null,
		'time' => $currentTime,
	);
//	var_dump(http_build_query ( $paras ));exit;
	$auth = base64_encode(http_build_query($paras));
	$verify = md5($auth . $key);

	return $uriBase . "/login?auth=$auth&verify=$verify";
}

function userCheck() {
	$cookieInfo = Cookie::get('MMC');

	if ($cookieInfo && Session::get('userInfo.gameId', false)) {
		return Session::get('userInfo.gameId');
	}

	return false;
}

function getUserBaseInfoByFingerprint($userFingerprint) {
	if ($userFingerprint) {
		try {
			$dataDB = [$userFingerprint];
			$userBaseInfo = DB::select('select gameId,isValid,coin,point, isAgreedPrivacy from users where fingerprint=?', $dataDB);

			if ($userBaseInfo) {
				return $userBaseInfo[0];
			}
		} catch (\Exception $e) {
			//dd($e);exit;
			return false;
		}
	}

	return false;
}

function genSession($needRefresh = false) {
	try {
		$userFingerprint = Cookie::get('MMC', false);

		if ($userFingerprint) {
			if (!Session::has('userInfo') || $needRefresh) {
				$userInfo = getUserBaseInfoByFingerprint($userFingerprint);

				if ($userInfo) {
					Session::put('loggedIn', true);
					Session::put('userInfo.gameId', $userInfo->gameId);
					Session::put('userInfo.coin', $userInfo->coin);
					Session::put('userInfo.point', $userInfo->point);
					Session::put('userInfo.isAgreedPrivacy', $userInfo->isAgreedPrivacy);
				} else {
					Session::put('loggedIn', false);
				}
			}

			loginBonusProc();
		} else {
			Session::put('loggedIn', false);
		}
	} catch (\Exception $e) {
		Session::put('loggedIn', false);
	}
}

function loginBonusProc() {
	$loginBonusInfo = config('app.loginBonus');
	$currentTime = time();
	$todayStartTime = strtotime(date('Y-m-d 00:00:00'));
	$userGameId = Session::get('userInfo.gameId', false);

	foreach ($loginBonusInfo as $type => $info) {
		switch ($type) {
			case 'point':
				if(($currentTime >= strtotime($info['startTime'])) && ($currentTime <= strtotime($info['endTime']))) {
					$todayFirstActiveTime = getTodayFirstActiveTimeByGameId();

					if($todayFirstActiveTime < $todayStartTime) {
						try {
							Redis::set($userGameId . ':todayFirstActiveTime', $currentTime);
							DB::update('update users set updatedAt=?,point=point+? where gameId=?', [date('Y-m-d H:i:s', $currentTime), $info['pointNum'], $userGameId]);
							DB::insert('insert into pointHistory (orderNumber,type,pointPrice,transName,userGameId,createdAt) values (?,?,?,?,?,?)', [md5($userGameId . $currentTime), 'bonus', $info['pointNum'], $info['name'], $userGameId, date('Y-m-d H:i:s', $currentTime)]);
							genSession(true);
						} catch (\Exception $e) {
							// TODO add logs
							//var_dump($e->getMessage());exit;
						}
					}
				}

				break;
			default:
				# nothing to do
				break;
		}
	}
}

function getTodayFirstActiveTimeByGameId() {
	$userGameId = Session::get('userInfo.gameId', false);
	
	try {
		$todayFirstActiveTime = Redis::get($userGameId . ':todayFirstActiveTime');
		
		if(is_null($todayFirstActiveTime)) {
			$updatedAtFromDB = DB::select('select updatedAt from users where gameId=?', [$userGameId]);

			if(is_array($updatedAtFromDB)) {
				return strtotime($updatedAtFromDB[0]->updatedAt);
			}
		} else {
			return $todayFirstActiveTime;
		}
	} catch (\Exception $e) {
		//var_dump($e->getMessage());exit;
		return false;
	}

	return false;
}

function genFingerprintByOpenid($openId, $openIdProvider) {
	return md5($openId . $openIdProvider . config('app.userFingerprintKey'));
}

function getUserBalanceByGameId($userGameId) {
	try {
		$dataDB = [$userGameId];
		$userBaseInfo = DB::select('select coin from users where gameId=?', $dataDB);

		if ($userBaseInfo) {
			return $userBaseInfo[0]->coin;
		}
	} catch (\Exception $e) {
		//dd($e);exit;
		return false;
	}

	return false;
}

function giveDiamonds($orderId, $serverId, $accountId) {
	$orderInfo = DB::select('select * from diamondPurchaseProc where orderId=?', [$orderId]);

	$currentTime = time();
	$remoteIP = getenv('REMOTE_ADDR');
	$uriBase = config('gameInfo.apiBaseUri');

	$serverInfo = config('gameInfo.serverInfo')[$serverId];

	if (is_array($serverInfo) && ($accountId == $orderInfo[0]->gameAccountId)) {
		$key = $serverInfo['apiKey'];

		$paras = array(
			'op_id' => $serverInfo['opId'],
			'sid' => $serverId,
			'game_id' => $serverInfo['gameId'],
			'account' => $orderInfo[0]->gameAccountId,
			'order_id' => $orderId,
			'game_money' => $orderInfo[0]->diamondNum,
			'u_money' => $orderInfo[0]->price,
			'time' => $currentTime,
			'currency' => 'JPY',
		);

		$auth = base64_encode(http_build_query($paras));
		$verify = md5($auth . $key);

		$gameChargeUri = $uriBase . "/charge?auth=$auth&verify=$verify";

		$client = new GuzzleHttp\Client();
		$res = $client->request('GET', $gameChargeUri);
		$body = json_decode($res->getBody()->getContents(), true);

		if (isset($body['status']) && ($body['status'] === 0)
			&& (DB::update('update diamondPurchaseProc set state=1,updatedAt=CURRENT_TIMESTAMP() where orderId=?', [$orderId]))) {
			return true;
		}
	}

	return false;
}

/**
 * Insert into userEventLog value each log of event.
 *
 * @param string $gameAccountId
 * @param string $event
 * @param string $gameServerId|null
 * @return boolean
 */
function insertIntoUserEventLog ($gameAccountId, $event, $gameServerId = null) {
	try {
		DB::insert('insert into userEventLog (gameAccountId,event,gameServerId) values (?,?,?)', [$gameAccountId, $event, $gameServerId]);

		return true;
	} catch (\Exception $e) {

		return false;
	}

	return false;
}

function getExpirationCoin($days, $userGameId) {
	$unExpDays = date('Y-m-d 00:00:00', strtotime("+$days days"));
	$expDay = date('Y-m-d 23:59:59', strtotime('+'. $days -1 . ' days'));

	$info = DB::select('select sum(coinPrice) as balance,sum(if(expiration>="' . $unExpDays . '", coinPrice, 0)) as uec from coinHistory where userGameId="' . $userGameId . '"');

	$num = $info[0]->balance - $info[0]->uec;

	$infoExp = DB::select('select id,coinPrice,expiration from coinHistory where expiration<="' . $expDay . '" and userGameId="' . $userGameId . '" and type="purchase" order by expiration desc');

	$ret = [];
	if($num > 0) {
		$numTmp = $num;
		$expIds = [];
		$earliestTime = null;

		foreach ($infoExp as $purchaseExp) {
			$numTmp = $numTmp - $purchaseExp->coinPrice;
			if($numTmp > 0) {
				$expIds[] = $purchaseExp->id;
			} else if($numTmp <= 0) {
				$expIds[] = $purchaseExp->id;
				$earliestTime = $purchaseExp->expiration;
				break;
			}
		}

		$ret['num'] = $num;
		$ret['expIds'] = $expIds;
		$ret['earliestTime'] = $earliestTime;
		return $ret;
	}

	return $ret;
}

function getValidServers($includeTestServer) {
	$serverList = config('gameInfo.serverInfo');
	$currentTime = time();

	foreach ($serverList as $serverId => $server) {
		$openTime = strtotime($server['openTime']);

		if(($server['openTime'] == 'nerver')) {
			if($includeTestServer == true) {
				$ret[$serverId] = $server;
			}
		} else {
			if($currentTime > $openTime) {
				$ret[$serverId] = $server;
			}
		}
	}

	return $ret;
}

function getGameInfoByUserGameId($userGameId, $includeTestServer = false) {
	$serverList = getValidServers($includeTestServer);

	$ret = [];
	foreach ($serverList as $serverId => $server) {
		$paras = array(
			'op_id' => $server['opId'],
			'sid' => $server['serverId'],
			'game_id' => $server['gameId'],
			'accounts' => $userGameId,
			'time' => time(),
		);

		$key = $server['apiKey'];
		$auth = base64_encode(http_build_query($paras));
		$verify = md5($auth . $key);
		$uriGetUserGameInfo = "http://pay.loas.jp/api/accessport/userInfo?auth=$auth&verify=$verify";

		$client = new GuzzleHttp\Client();
		$res = $client->request('GET', $uriGetUserGameInfo);
		$info = json_decode($res->getBody()->getContents(), true);

		if($info['data'] && isset($info['data'][$userGameId])) {
			foreach ($info['data'][$userGameId] as $gameId => $gameInfo) {
				$ret[$gameId]['userGameId'] = $userGameId;
				$ret[$gameId]['serverId'] = $serverId;
				$ret[$gameId]['serverName'] = $server['serverName'];
				$ret[$gameId]['activeTime'] = $gameInfo['active_time'];
				$ret[$gameId]['gender'] = $gameInfo['gender'];
				$ret[$gameId]['level'] = $gameInfo['level'];
				$ret[$gameId]['roleName'] = $gameInfo['role_name'];
			}
		}
	}

	return $ret;
}

function giveUserItem($userGameID, $serverId, $itemId, $itemCount, $mailTitle = 'title', $mailContents = 'contents') {
	$uriBase = 'http://webout.loas.jp/reward?';

	$time = time();
	$serverId = $serverId;
	$userList = $userGameID;//userId1,userId2,userId3...
	$itemList = $itemId . ':' . $itemCount;//'41000:1';//itemId1:count;itemId2:count;itemId3:count;

	$params = [
		'time' => $time,
		'verify' => md5('@#$%6666&^%$' . $time . $serverId),
		'title' => $mailTitle,
		'content' => $mailContents,
		'server_id' => $serverId,
		'user_list' => $userList,
		'item_list' => $itemList,
	];

	$uriReward = $uriBase . http_build_query($params);

	$client = new GuzzleHttp\Client();
	$res = $client->request('GET', $uriReward);
	$body = json_decode($res->getBody()->getContents(), true);

	if(($body['errCode'] == 0) && ($body['message'] == 'success')) {
		return true;
	}

	return false;
}

function isMaintenance () {
	// return config('app.maintenance');
	$record = DB::connection('maintenance')->select('select maintenanceStatus from game_status where gameName="loas"');
	if (isset($record[0])) {
		if ($record[0]->maintenanceStatus == 'on') {
			return true;
		}
	}
	return false;
}
