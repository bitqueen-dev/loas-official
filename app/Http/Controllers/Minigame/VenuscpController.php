<?php
namespace App\Http\Controllers\Minigame;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client as GuzzleHttpClient;

class VenuscpController extends Controller{

	public function __construct(){
		$this->gameName = 'venuscp';
		require(app_path('Support/minigame.php'));
	}

	public function show(Request $request){
		$data = [];
		$data['uId'] = $userGameId = $request->input('uId', false);
		$data['sId'] = $serverId = $request->input('sId', false);
		$data['canPost'] = checkPeriod($this->gameName);

		if ($userGameId && $serverId) {
			$currentTime = time();
			$data['haveTicket'] = self::checkItem([
				'account' => $userGameId,
				'sid' => $serverId,
				'time' => $currentTime,
				'itemId' => config('minigame.venuscp.ticket_id'),
				'verify' => md5('@#$%6666&^%$' . $currentTime . $serverId),
			]);

			$charInfo = DB::table('venusPostedChar')->select('charId', 'postCount')->get()->toArray();
			$data['charInfo'] = json_encode($charInfo);

			$userInfo = DB::table('venusPostedPerUser')->where('userId', '=', $userGameId)->get()->toArray();
			$data['userInfo'] = json_encode($userInfo);
		}

		return response(view('others.venuscp', $data), 200);
	}

	public function showExchangePage(Request $request){
		$data = [];
		$data['uId'] = $userGameId = $request->input('uId', false);
		$data['sId'] = $serverId = $request->input('sId', false);

		if ($userGameId && $serverId) {
			$userInfo = DB::table('venusPostedPerUser')
							->select('exchangePoint')
							->where('userId', '=', $userGameId)
							->get()
							->toArray();
			$data['userInfo'] = json_encode($userInfo);

			$itemInfo = config('minigame.venuscp.exchangeItems');
			foreach ($itemInfo as $value) {
				unset($value['item_list']);
			}

			$data['itemInfo'] = json_encode($itemInfo);
		}

		return response(view('others.venusExchangePage', $data), 200);
	}

	public function exchange (Request $request) {
		$data = [];

		$userGameId = $request->input('uId', false);
		$serverId = $request->input('sId', false);
		$itemId = $request->input('itemId', false);
		$itemCount = $request->input('itemCount', false);
		$itemInfo = config('minigame.venuscp.exchangeItems');

		try {
			if ($userGameId && $serverId && isset($itemInfo[$itemId])) {
				$itemInfo = $itemInfo[$itemId];

				$userInfo = DB::table('venusPostedPerUser')
								->select('exchangePoint')
								->where('userId', '=', $userGameId)
								->get()
								->toArray();

				if (!empty($userInfo[0])) {

					$price = $itemInfo['comsumptionPoint'] * $itemCount;

					if ($price <= $userInfo[0]->exchangePoint) {
						DB::table('venusPostedPerUser')
							->where('userId', '=', $userGameId)
							->decrement('exchangePoint', $price);

						$currentTime = time();
						$verify = md5('@#$%6666&^%$' . $currentTime . $serverId);
						$item_list = $itemInfo['item_list'].':'.$itemCount;
						$giveData = [
							'time' => $currentTime,
							'verify' => $verify,
							'title' => 'アイテム獲得のお知らせ',
							'content' => '添付アイテムをお受取ください。',
							'server_id' => $serverId,
							'user_list' => $userGameId,
							'item_list' => $item_list,
						];

						if (giveGameItem($giveData)) {
							DB::table('venusPostedLog')->insert([
								'userId' => $userGameId,
								'serverId' => $serverId,
								'charId' => 0,
								'type' => 'gived_exch',
								'item_list' => $item_list,
							]);

							return jsonResponse('SUCCESS', $data);
						}

						Log::useFiles(storage_path('logs/venus_exchange.log'));
						Log::error("give||uId:$userGameId;sId:$serverId;itemId:$itemId;itemCount:$itemCount;");
						return jsonResponse('REQUEST_ERROR', $data);
					}
					return jsonResponse('NOT_ENOUGHT_BALANCE', $data);
				}
			}
			return jsonResponse('REQUEST_ERROR', $data);
		} catch (Exception $e) {}
		return jsonResponse('UNKNOWN');
	}

	public function post(Request $request){
		if (!checkPeriod($this->gameName)) {
			return jsonResponse('CLOSED_GAME');
		}

		$data = [];

		$userGameId = $request->input('uId', false);
		$serverId = $request->input('sId', false);
		$charId = $request->input('charId', false);

		try {
			if ($userGameId && $serverId && $charId) {
				Log::useFiles(storage_path('logs/venus_post.log'));

				$config = config('minigame.venuscp');

				$currentTime = time();
				$verify = md5('@#$%6666&^%$' . $currentTime . $serverId);
				$orderNumber = self::genOrderNumber($userGameId);

				$delItemData = [
					'account' => $userGameId,
					'sid' => $serverId,
					'time' => $currentTime,
					'itemId' => $config['ticket_id'],
					'count' => 1,
					'orderId' => $orderNumber,
					'verify' => $verify,
				];

				$delRes = self::delItem($delItemData);
				// $delRes = 0;
				if ($delRes == 0) {
					// Log::info("del item||uId:$userGameId;sId:$serverId;charId:$charId;orderNumber:$orderNumber;");
					DB::table('venusPostedLog')->insert([
						'userId' => $userGameId,
						'serverId' => $serverId,
						'charId' => $charId,
						'type' => 'delete',
						'orderNumber' => $orderNumber,
					]);

					DB::table('venusPostedChar')
						->where('charId', '=', $charId)
						->increment('postCount');

					if (isset($config['items'][$charId])) {
						$item_list = $config['items'][$charId]['item_list'];

						$giveItemData = [
							'time' => $currentTime,
							'verify' => $verify,
							'title' => 'アイテム獲得のお知らせ',
							'content' => '添付アイテムをお受取ください。',
							'server_id' => $serverId,
							'user_list' => $userGameId,
							// 'item_list' => $config['ticket_id'].':22',
							'item_list' => $item_list,
						];

						if (giveGameItem($giveItemData)) {
							// Log::info("gived item||uId:$userGameId;sId:$serverId;charId:$charId;item_list:$item_list;");
							DB::table('venusPostedLog')->insert([
								'userId' => $userGameId,
								'serverId' => $serverId,
								'charId' => $charId,
								'type' => 'gived',
								'item_list' => $item_list,
							]);
							return jsonResponse('SUCCESS', $data);
						}
					}
				} else if ($delRes > 1004) {
					return jsonResponse('NOT_ENOUGHT_BALANCE', $data);
				}

				// $data['err_st'] = $delRes;
				// $data['orderNumber'] = $orderNumber;
				Log::error("del item||uId:$userGameId;sId:$serverId;charId:$charId;orderNumber:$orderNumber;status:$delRes;");
				return jsonResponse('REQUEST_ERROR', $data);
			}
		} catch (Exception $e) {}

		Log::error("other||uId:$userGameId;sId:$serverId;charId:$charId;");

		return jsonResponse('UNKNOWN');
	}

	private function genOrderNumber($userGameId) {
		$tmp = time() . $userGameId;
		return substr(crc32($tmp).crc32(md5($tmp)),0,18);
	}

	private function checkItem ($params) {
		// return 100;
		try {
			$client = new GuzzleHttpClient();
			$uriBase = 'http://webout.loas.jp/checkItem?';
			$uriReward = $uriBase . http_build_query($params);
	
			$response = $client->request('GET', $uriReward);
			$contents = $response->getBody()->getContents();
			$result = json_decode($contents, true);

			if ($result['status'] == 0) {
				return $result['count'];
			}
		} catch (Exception $e) {}
		return 0;
	}

	private function delItem ($params) {
		try {
			$client = new GuzzleHttpClient();
			$uriBase = 'http://webout.loas.jp/delItem?';
			$uriReward = $uriBase . http_build_query($params);
	
			$response = $client->request('POST', $uriReward);
			$contents = $response->getBody()->getContents();
			$result = json_decode($contents, true);

			return $result['status'];
		} catch (Exception $e) {}
		return 999;
	}
}