<?php
namespace App\Http\Controllers;

use Cookie;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller {

    private $purchaseInfo;
    private $pointChargeInfo;

    public function __construct()
    {
        $this->purchaseInfo = config('gameInfo.purchaseInfo');
        $this->pointChargeInfo = config('gameInfo.pointChargeInfo');
    }

    public function chargePage() {
		$data = [];
		$data['purchaseInfo'] = $this->purchaseInfo;

		$content = view('purchase.chargePage', $data);
		return response($content, 200);
	}

	public function intro() {
		//TODO session logic is not good now
		genSession();

		$data = [];

		$content = view('purchase.intro', $data);

		return response($content, 200);
	}

	private function getChargeInfo() {
		$chargeInfo = $this->pointChargeInfo;
		$ret = ['pointCP' => false, 'coinCP' => false, 'chargeInfo' => $chargeInfo];
		$currentTime = time();

		$bonusInfoPoint = config('gameInfo.chargeBonus.point');
		$cpStartTimePoint = strtotime($bonusInfoPoint['startTime']) ?: 0;
		$cpEndTimePoint = strtotime($bonusInfoPoint['endTime']) ?: 0;
		$cpRulePoint = $bonusInfoPoint['rule'];

		if(($currentTime >= $cpStartTimePoint) && ($currentTime <= $cpEndTimePoint)) {
			foreach ($chargeInfo as $id => $info) {
				$tmp[$id]['name'] = $info['name'];
				$tmp[$id]['pay'] = $info['pay'];
				$tmp[$id]['pointOriginal'] = $info['point'];
				switch ($cpRulePoint) {
					case 'x':
						$tmp[$id]['point'] = $info['point'] * $bonusInfoPoint['number'];
					break;

					default:
						$tmp[$id]['point'] = $info['point'];
					break;
				}
			}

			$ret['pointCP'] = true;
			$ret['chargeInfo'] = $tmp;
		}

		return $ret;
	}

	public function process(Request $request) {
		//TODO session logic is not good now
		genSession();
		$gameId = userCheck();

		if ($gameId) {
			$data = [];
			$data['userEmail'] = $request->cookie('MMPM');
			$data['chargeInfo'] = self::getChargeInfo();

			$content = view('purchase.process.step', $data);

			return response($content, 200);
		} else {
			return redirect(config('app.httpsBaseUrl') . '/?pop=showLogin');
		}
	}

	public function makePaymentInfoJS() {
		//$data['pointChargeInfo'] = config('gameInfo.pointChargeInfo');
		$data['purchaseInfo'] =  $this->purchaseInfo;
		$data['payWay'] = config('gameInfo.payWay');
		$data['chargeInfo'] = self::getChargeInfo();

		$content = view('purchase.paymentInfoJS', $data);
		return response($content, 200)->header('Content-Type', 'application/javascript');
	}

	public function complete(Request $request) {
		sleep(1);
		$userId = $request->get('user_id', false);
		$transCode = $request->get('trans_code', false);
		$orderNumber = $request->get('order_number', false);
		$result = $request->get('result', false);

		if ($userId && $orderNumber) {
			try {
				//TODO session logic is not good now
				genSession(true);
				$gameId = userCheck();

				if ($gameId == $userId) {
					$orderInfo = DB::select('select orderNumber,createdAt,expiration,coinPrice from coinHistory where orderNumber=?', [$orderNumber]);

					if (count($orderInfo) == 1) {
						$data = [];
						$data['orderNumber'] = $orderInfo[0]->orderNumber;
						$data['createdAt'] = $orderInfo[0]->createdAt;
						$data['coinPrice'] = $orderInfo[0]->coinPrice;
						$data['expiration'] = $orderInfo[0]->expiration;

						$content = view('purchase.process.comp', $data);

						return response($content, 200);
					}
				}
			} catch (Exception $e) {
				abort(400, 'Bad Request');
			}
		} elseif ($transCode && !$orderNumber) {
			try {
				//TODO session logic is not good now
				genSession(true);

				$orderInfo = DB::select('select orderNumber,createdAt,expiration,coinPrice from coinHistory where orderNumber=(select orderNumber from purchaseProc where transCodeBack=?)', [$transCode]);

				if (count($orderInfo) == 1) {
					$data = [];
					$data['orderNumber'] = $orderInfo[0]->orderNumber;
					$data['createdAt'] = $orderInfo[0]->createdAt;
					$data['coinPrice'] = $orderInfo[0]->coinPrice;
					$data['expiration'] = $orderInfo[0]->expiration;

					$content = view('purchase.process.comp', $data);

					return response($content, 200);
				}
			} catch (Exception $e) {
				abort(400, 'Bad Request');
			}
		}

		abort(400, 'Bad Request');
	}

	public function history() {
		//TODO session logic is not good now
		genSession();
		$gameId = userCheck();//'official-bed461b42e25c82cbd7231e3dd1e7b55';//

		if ($gameId) {
			try {
			    //LA COIN 价格和数量的Map，解决涨税后，价格和数量不对应的问题
                $priceCountMap = array();
                foreach($this->pointChargeInfo as $itemCode => $info) {
                    $priceCountMap[$info['pay']] = $info['coin'];
                }

				$coinHistory = DB::table('coinHistory')->where('userGameId', $gameId)->orderBy('createdAt', 'DESC')->paginate(20);
				$data['historys'] = [];

				foreach ($coinHistory as $history) {
					$tmp = [];
					$tmp['id'] = $history->id;
					$tmp['createdAt'] = $history->createdAt;
					$tmp['type'] = $history->type;

                    $tmp['coinPrice'] = $history->coinPrice;
                    //购买/使用 COIN 数量
					if ('purchase' === $history->type) {
                        $tmp['coinCount'] = $priceCountMap[$history->coinPrice];
                    } else {
                        $tmp['coinCount'] = $history->coinPrice;
                    }

					$tmp['orderNumber'] = $history->orderNumber;
					$tmp['expiration'] = ($history->expiration != '0000-00-00 00:00:00') ? $history->expiration : '--';

					$tmp['serverName'] = '--';
					if (($history->serverId != '0')) {
						$tmp['serverName'] = config('gameInfo.serverInfo')[$history->serverId]['serverName'];
					}

					$data['historys'][] = $tmp;
				}

				$data['expCoin'] = getExpirationCoin(config('app.coinExpirationAlertDays'), $gameId);
				$data['coinHistory'] = $coinHistory;
				$content = view('purchase.history', $data);

				return response($content, 200);
			} catch (Exception $e) {
				abort(500);
			}
		} else {
			return redirect(config('app.httpsBaseUrl') . '/?pop=showLogin');
		}

		abort(500);
	}

	public function completeCallback(Request $request) {
		$orderNumber = $request->get('order_number', false);
		$transCode = $request->get('trans_code', false);
		$paymentCode = $request->get('payment_code', false);
		$contractCode = $request->get('contract_code', false);
		$state = $request->get('state', false);

		if ($orderNumber && ($state == '1') && ($contractCode == config('app.epsilonID'))) {
			try {
				$orderInfo = DB::select('select status,itemCode,userGameId from purchaseProc where orderNumber=?', [$orderNumber]);
				$currentItemInfo = isset($this->pointChargeInfo[$orderInfo[0]->itemCode]) ? $this->pointChargeInfo[$orderInfo[0]->itemCode] : false;

				if ((count($orderInfo) == 1) && ($orderInfo[0]->status == '-1') && $currentItemInfo) {
					DB::update('update purchaseProc set status=1,updatedAt=?,transCodeBack=? where orderNumber=?', [date('Y-m-d H:i:s'), $transCode, $orderNumber]);

					$pointNum = self::getPointNum($currentItemInfo);
					
					DB::update('update users set coin=coin+?, point=point+? where gameId=?', [$currentItemInfo['coin'], $pointNum, $orderInfo[0]->userGameId]);

					$dataDB = [
						$orderNumber,
						'purchase',
						$currentItemInfo['pay'],
						$orderInfo[0]->userGameId,
						date('Y-m-d 23:59:59', strtotime('+6 month -1 day')),
					];
					DB::insert('insert into coinHistory (orderNumber,type,coinPrice,userGameId,expiration) values (?,?,?,?,?)', $dataDB);

					$dataDBPoint = [
						$orderNumber,
						'purchase',
						$pointNum,
						'LAコイン購入(' . $currentItemInfo['coin'] . ')',
						$orderInfo[0]->userGameId,
					];
					DB::insert('insert into pointHistory (orderNumber,type,pointPrice,transName,userGameId) values (?,?,?,?,?)', $dataDBPoint);

					// self::minigameChargeUpdate($orderInfo[0]->userGameId, $currentItemInfo['pay'], 'sugoroku');
					return '1';
				}
			} catch (Exception $e) {
				return '0 999 unknow';
			}
		}

		return '0 999 unknow';
	}

	private function getPointNum($pointChargeInfo) {
		$bonusInfo = config('gameInfo.chargeBonus.point');
		$currentTime = time();
		$cpStartTime = strtotime($bonusInfo['startTime']) ?: 0;
		$cpEndTime = strtotime($bonusInfo['endTime']) ?: 0;
		$cpRule = $bonusInfo['rule'];

		if(($currentTime >= $cpStartTime) && ($currentTime <= $cpEndTime)) {
			switch ($cpRule) {
				case 'x':
					return $pointChargeInfo['point'] * $bonusInfo['number'];
				break;
				
				default:
					return $pointChargeInfo['point'];
				break;
			}
		}

		return $pointChargeInfo['point'];
	}

	public function posterPurchase(Request $request) {
		//TODO session logic is not good now
		genSession();
		$gameId = userCheck();

		$itemCode = $request->get('itemCode', false);
		$payWayCode = $request->get('payWayCode', false);
		$userEmail = $request->get('userEmail', false);
		$userEmailRemember = $request->get('userEmailRemember', false);

		$itemInfoCurrent = isset($this->pointChargeInfo[$itemCode]) ? $this->pointChargeInfo[$itemCode] : false;
		$payWayInfoCurrent = isset(config('gameInfo.payWay')[$payWayCode]) ? config('gameInfo.payWay')[$payWayCode] : false;

		if ($gameId && $itemCode && $payWayCode && $userEmail && $itemInfoCurrent && $payWayInfoCurrent) {
			try {
				$orderNumber = self::genOrderNumber();

				$postData = [
					'item_price' => $itemInfoCurrent['pay'],
					'contract_code' => config('app.epsilonID'),
					'order_number' => $orderNumber,
					'st_code' => $payWayInfoCurrent['epsilonCode'],
					'mission_code' => '1',
					'process_code' => '1',
					'memo1' => '',
					'memo2' => '',
					'item_name' => $itemInfoCurrent['name'],
					'item_code' => $itemCode,
					'user_id' => $gameId,
					'user_mail_add' => $userEmail,
					'user_name' => 'official user',
					'xml' => '1',
					'tds_flag' => '22'
				];

				$client = new GuzzleHttpClient();

				$response = $client->request('POST', config('app.epsilonCallUri'), ['form_params' => $postData]);
				$contents = simplexml_load_string($response->getBody()->getContents());

				//Erroe Code = 908
                //イプシロン管理画面の「オーダー情報発
                //信 元 ホ ス ト 情 報 」 に IPア ド レ ス 、 ホ ス ト
                //名が登録されていません。
                //管理画面の「オーダー情報発信元ホスト情報」に加盟店様の発信元
                //サ ー バ の I P ア ド レ ス 、 も し く は ホ ス ト 名 を 登 録 し て く だ さ い 。

				$respResult = (string) $contents->result['result'];
				$urlRedirect = urldecode((string) $contents->result[1]['redirect']);

				parse_str(parse_url($urlRedirect)['query'], $output);

				$transCode = (isset($output['trans_code']) && $output['trans_code']) ? $output['trans_code'] : false;

				if (($respResult === '1') && $urlRedirect && $transCode) {
					$dataDB = [
						$itemInfoCurrent['pay'],
						$orderNumber,
						$transCode,
						$payWayCode,
						1,
						1,
						null,
						null,
						$itemInfoCurrent['name'],
						$itemCode,
						$gameId,
						$userEmail,
						-1,
						date('Y-m-d H:i:s'),
					];

					if (DB::insert('insert into purchaseProc (itemPrice,orderNumber,transCodePoster, payWay,missionCode,processCode,memo1,memo2,itemName,itemCode,userGameId,email,status,createdAt) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?)', $dataDB)) {
						if ($userEmailRemember == 'on') {
							return redirect($urlRedirect)->cookie('MMPM', $userEmail);
						} else {
							return redirect($urlRedirect)->withCookie(Cookie::forget('MMPM'));
						}
					}
				}
			} catch (RequestException $re) {
				//var_dump($re->getResponse()->getBody()->getContents());exit;
				return redirect('/purchase/process#processContents')->withErrors(['unknow']);
			} catch (Exception $e) {
				return redirect('/purchase/process#processContents')->withErrors(['unknow']);
			}
		}

		return redirect('/purchase/process#processContents')->withErrors(['unknow']);
	}

	private function genOrderNumber() {
		return md5(time() . mt_rand());
	}

	private function minigameChargeUpdate ($gameId, $chargeCoin, $gameName) {
		if ($chargeCoin > 0) {
			$minigameUserInfo = DB::select('select * from minigameUserInfo where gameId=?', [$gameId]);
			if (isset($minigameUserInfo[0])){
				$totalChargeCoin = $minigameUserInfo[0]->chargeCoin + $chargeCoin;

				$chargeBorder = 3000;
				$addCredit = 0;

				while ($totalChargeCoin >= $chargeBorder) {
					$addCredit += 1;
					$totalChargeCoin -= $chargeBorder;
				}

				DB::update('update minigameUserInfo set freePlayCredit=freePlayCredit+?, chargeCoin=?, updatedAt=? where gameId=?', [$addCredit, $totalChargeCoin, date('Y-m-d H:i:s'), $gameId]);

				$conf = config('minigame.'.$gameName.'.chargeCoin');
				DB::insert('insert into minigameHistory (orderNumber, gameId, price, type, itemId, itemName, game, status, serverId) values (?,?,?,?,?,?,?,?)', [self::genOrderNumber($gameId),$gameId,$addCredit,'chargeCoin',$conf['itemId'],$conf['itemName'],$gameName,1,0]);
				return true;
			}
		}
		return false;
	}

}