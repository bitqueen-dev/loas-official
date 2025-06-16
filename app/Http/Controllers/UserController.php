<?php
namespace App\Http\Controllers;

use Socialite;
use Cookie;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use GuzzleHttp\Client as GuzzleHttpClient;

class UserController extends Controller{
	private $supportOpenIdProvider = ['yahoojp', 'google', 'facebook', 'twitter'];
	private $openIdName = ['yahoojp' => 'Yahoo! JAPAN ID', 'google' => 'Google ID', 'facebook' => 'Facebook ID', 'twitter' => 'Twitter ID'];

	public function login(Request $request) {
		$content = view('user.login');

		return response($content, 200);
	}

	public function auth($provider) {
		if(!in_array($provider, $this->supportOpenIdProvider)) {
			return 'unsupport openid provider!';
		}

		try {
			return Socialite::driver($provider)->redirect();
		} catch (\Exception $e) {
			return redirect(config('app.httpsBaseUrl') . '/');
		}
	}

	public function authCallback($provider) {
		try {
			$user = Socialite::driver($provider)->user();

			if($openid = $user->getId()) {
				$userStatus = self::getUserStatusByOpenId($openid, $provider);
				$name = $user->getName() ? $user->getName() : null;
				$email = $user->getEmail() ? $user->getEmail() : null;
				$avatar = $user->getAvatar() ? $user->getAvatar() : null;
				$gameId = 'official-' . md5($openid . $provider);
				$userFingerprint = genFingerprintByOpenid($openid, $provider);
				$data = [];

				$cookieStr = array(
					'openid' => $openid,
					'openIdProvider' => $provider
				);

				if($userStatus === -1) {
					$from = Cookie::get('MMCF', false);
					$isFromAD = $from ? 1 : 0;

					$data = [$gameId, $openid, $provider, $name, $email, $avatar, 0, $isFromAD, $from, $userFingerprint];

					DB::insert('insert into users (gameId,openId,openIdProvider,name,email,avatar,isValid,isFromAD,fromWhere,fingerprint,createdAt) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP())', $data);
					return redirect(config('app.httpsBaseUrl') . '/user/register/step2')->cookie('MMCT', json_encode($cookieStr), 1, '/');
				} else if($userStatus === -2) {
					return redirect(config('app.httpsBaseUrl') . '/user/register/step2')->cookie('MMCT', json_encode($cookieStr), 1, '/');
				} else if($userStatus === 1) {
					insertIntoUserEventLog($gameId, 'login', null);

					return redirect(config('app.httpsBaseUrl') . '/?pop=showServers')->cookie('MMC', $userFingerprint, 60 * 24 * 365, '/');
				}
			}
		} catch (\Illuminate\Database\QueryException $e) {
			return redirect(config('app.httpsBaseUrl') . '/');
		} catch (\Exception $e) {
			return redirect(config('app.httpsBaseUrl') . '/');
		}
	}

	public function register($step, Request $request) {
		$postDatas = $request->all();

		if($step == 'step2') {
			$tmpInfo = json_decode(Cookie::get('MMCT'), true);

			if($tmpInfo && isset($tmpInfo['openid'])) {
				$data = [];

				$data['openid'] = $tmpInfo['openid'];
				$data['thisYear'] = date('Y');
				$data['openIdProvider'] = $tmpInfo['openIdProvider'];
				$data['openIdProviderName'] = $this->openIdName[$tmpInfo['openIdProvider']];

				$content = view('user.register.step2', $data);
				return response($content, 200);
			}
		} else if($step == 'step2Confirm' && $request->isMethod('post')) {
			if(isset($postDatas['gender']) && ($postDatas['year'] != '0') && ($postDatas['month'] != '0') && ($postDatas['day'] != '0')) {
				$data = [];

				$data['openid'] = $postDatas['openid'];
				$data['openIdProvider'] = $postDatas['openIdProvider'];
				$data['openIdProviderName'] = $postDatas['openIdProviderName'];
				$data['gender'] = $postDatas['gender'];
				$data['year'] = $postDatas['year'];
				$data['month'] = $postDatas['month'];
				$data['day'] = $postDatas['day'];

				$content = view('user.register.step2Confirm', $data);
				return response($content, 200);
			}
		} else if($step == 'complate') {
			if(isset($postDatas['gender']) && isset($postDatas['birthday']) && isset($postDatas['openid']) && isset($postDatas['openIdProvider'])) {
				try {
					$userFingerprint = genFingerprintByOpenid($postDatas['openid'], $postDatas['openIdProvider']);

					$dataDb = [$postDatas['gender'], $postDatas['birthday'], $userFingerprint];
					DB::update('update users set gender=?,birthday=?,isValid=1 where fingerprint=?', $dataDb);

					$data['gameId'] = 'official-' . md5($postDatas['openid'] . $postDatas['openIdProvider']);

					// self::affiliateUlti($data['gameId']);
					
					$content = view('user.register.step3', $data);
					return response($content, 200)->cookie('MMC', $userFingerprint, 60 * 24 * 365, '/');
					//return redirect('/?pop=showServers')->cookie('MMC', json_encode($cookieStr), 60 * 24 * 365, '/');
				} catch (\Exception $e) {
					//dd($e);exit;
				}
			}
		}

		return redirect(config('app.httpsBaseUrl') . '/');
	}

	public function logout() {
		Session::forget('userInfo');
		Session::put('loggedIn', false);
		return redirect(config('app.httpsBaseUrl') . '/')->withCookie(Cookie::forget('MMC'));
	}

	private function getUserStatusByOpenId($openid, $provider) {
		$data = [$openid, $provider];

		try {
			$userInfo = DB::select('select isValid from users where openId=? and openIdProvider=?', $data);

			if(!$userInfo) {
				//new user
				return -1;
			} else if($userInfo[0]->isValid == 0) {
				//alreday reg but not complated
				return -2;
			} else if($userInfo[0]->isValid == 1) {
				//old user relogin
				return 1;
			} else {
				return -10;
			}
		} catch (\Exception $e) {
			return -5;
		}
	}


    public function agreeGamePrivacy() {
        $userGameId = Session::get('userInfo.gameId', false);
        DB::update('update users set isAgreedPrivacy=1 where gameId=?', [$userGameId]);
        Session::put('userInfo.isAgreedPrivacy', 1);
        return response("ok");
    }


    private function affiliateUlti ($gameId) {
		$affiliate_param_afult = Cookie::get('AFAF');
		if ($affiliate_param_afult != '') {
			try {
				$client = new GuzzleHttpClient();
				$uriBase = 'http://www.ulti.jp/sys/res2.php?';
				$params = [
					'cid' => 'acspt',
					'a' => 'A0019865',
					'afult' => $affiliate_param_afult,
					'uid1' => $gameId,
				];
				$uriReward = $uriBase . http_build_query($params);
				$response = $client->request('GET', $uriReward);
				$contents = $response->getBody()->getContents();
				// $result = json_decode($contents, true);
				if (preg_match('/OK/',$contents)) {
					return true;
				}
			} catch (\Exception $e) {
				// dd($e);
			}
		}
		return false;
	}
}