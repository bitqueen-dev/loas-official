<?php
namespace App\Http\Controllers\Minigame;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MumuLetterController extends Controller{

	public function __construct(){
		require(app_path('Support/minigame.php'));
		$this->gameName = 'mumu_letter';
		$this->config = config('minigame.'.$this->gameName.'.questionnaireInfo');
	}

	public function showTop (Request $request) {
		$data = [];
		$data['uId'] = $userGameId = $request->input('uId', false);
		$data['sId'] = $serverId = $request->input('sId', false);
		$data['questionnaireInfo'] = $this->config;
		$data['posted'] = false;

		if ($userGameId && $serverId) {
			if (!checkPeriod($this->gameName)) {
				$data['posted'] = true;
			} else {
				if (DB::table('mumu_letter')->where('userGameId','=',$userGameId)->where('serverId','=',$serverId)->count()>0)
					$data['posted'] = true;
			}
			return response(view('others.mumu_letter', $data), 200);
		}
		echo 'Error: Please Login.';
	}

	public function answer (Request $request) {
		$formValues = $request->all();
		$userGameId = isset($formValues['uId']) ? $formValues['uId'] : false;
		$serverId = isset($formValues['sId']) ? $formValues['sId'] : false;

		if ($userGameId && $serverId) {
			if (DB::table('mumu_letter')->where('userGameId','=',$userGameId)->where('serverId','=',$serverId)->count()>0)
				return jsonResponse('ALREADY');

			$conf = $this->config;

			$insertData = [];
			foreach ($formValues as $id => $formValue) {
				if (isset($conf[$id])) {
					$info = $conf[$id];

					if ($info['type'] == 'checkbox') {
						$checkboxValue = '';
						foreach ($formValue as $value)
							$checkboxValue .= $value.';';
						$insertData[$id] = substr($checkboxValue, 0, -1);
					} else {
						$insertData[$id] = $formValue;
					}
				}
			}

			$insertData['userGameId'] = $userGameId;
			$insertData['serverId'] = $serverId;

			$currentTime = time();
			$giveItemData = [
				'time' => $currentTime,
				'verify' => md5('@#$%6666&^%$' . $currentTime . $serverId),
				'title' => 'アイテム獲得のお知らせ',
				'content' => 'お客様は、【ダイヤの宝箱（Lv.35）*1、ガチャボックス(英雄)*10、デュアルルーンの宝箱Lv.7 *1】を獲得しました。 添付アイテムをお受取ください。',
				'server_id' => $serverId,
				'user_list' => $userGameId,
				'item_list' => '80500:1,201635:10,200217:1',
			];

			try {
				if (DB::table('mumu_letter')->insert($insertData) && giveGameItem($giveItemData))
					return jsonResponse('SUCCESS');
			} catch (Exception $e) {
				return jsonResponse('DB_ERROR');
			}
		}
		return jsonResponse('REQUEST_ERROR');
	}
}