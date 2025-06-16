<?php
namespace Laravel\Socialite\Two;

class YahooJpProvider extends AbstractProvider implements ProviderInterface{
	
	// scopeの区切り文字設定
	protected $scopeSeparator = ' ';
	
	// スコープ設定
	protected $scopes = [
		'openid',
		'profile',
		'email'
	];
	
	// 認証用URL($stateはオプション)
	protected function getAuthUrl($state){
		return $this->buildAuthUrlFromBase('https://auth.login.yahoo.co.jp/yconnect/v2/authorization', $state);
	}
	
	// token取得用URL
	protected function getTokenUrl(){
		return 'https://auth.login.yahoo.co.jp/yconnect/v2/token';
	}
	
	// Token取得の際のオプション
	// Basic認証と必要なPOSTパラメータを送付
	public function getAccessTokenResponse($code){
		$basic_auth_key = base64_encode($this->clientId . ":" . $this->clientSecret);

		$response = $this->getHttpClient()->post($this->getTokenUrl(), [
			// 認証
			'headers' => [
				'Authorization' => 'Basic ' . $basic_auth_key
			],
			// 'form_params' => $this->getTokenFields($code),
			// 直接記述
			'form_params' => [
				'grant_type' => 'authorization_code',
				'code' => $code,
				'redirect_uri' => $this->redirectUrl
			]
		]);
		
		return $this->parseAccessToken($response->getBody());
	}
	
	// ユーザー情報取得
	protected function getUserByToken($token){
		// url + schema=openidが必要だった
		$response = $this->getHttpClient()->get('https://userinfo.yahooapis.jp/yconnect/v2/attribute', [
			'headers' => [
				'Authorization' => 'Bearer ' . $token
			]
		]);
		return json_decode($response->getBody(), true);
	}
	
	// Userにパラメーターをマップ（必要に応じてその他のパラメータ追加）
	protected function mapUserToObject(array $user){
		return (new User())->setRaw($user)->map([
			'id' => $user['sub'],
			'name' => $user['nickname'],
			'email' => $user['email']
		]);
	}
	
	// token parse用の関数
	protected function parseAccessToken($body){
		return json_decode($body, true);
	}
}