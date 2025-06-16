<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  @include('vendor.metaCommon')
  @include('vendor.titleCommon')

  <link rel="stylesheet" href="//ap-statics.loas.jp/mm2/official/css/reg.css">
  <script src="//ap-statics.loas.jp/mm2/official/js/jquery.min.js"></script>
</head>
<body>
<div class="wrapper">
  <div class="title"></div>
  <div class="contents">
    <div class="info_area">
      <div class="info_title">無料会員登録</div>
      <div class="step_info step_info2"></div>
      <div class="step_title step_confirm_title2"></div>
      <div class="info_table">
        生年月日・性別は登録後の変更ができません、再度ご確認下さい。<br />ご入力いただいた内容に間違いがなければ、利用規約・プライバシーポリシーをご確認いただいた上「登録する」ボタンをクリックして登録を完了してください。
        <table class="step2_table">
          <tr>
            <th>ご希望の外部アカウント</th>
            <td>{{ $openIdProviderName }}<span style="float: right;color: #ff0000;">※変更不可</span></td>
          </tr>
          <tr>
            <th>生年月日</th>
            <td>{{ $year . '年' . $month . '月' . $day . '日' }}<span style="float: right;color: #ff0000;">※変更不可</span></td>
          </tr>
          <tr>
            <th>性別</th>
            <td>@if($gender == 'male')男性@elseif ($gender == 'female')女性@endif<span style="float: right;color: #ff0000;">※変更不可</span></td>
          </tr>
        </table>
      </div>
      <div class="terms_title">利用規約</div>
      <iframe src="/terms_clear" style="width: 580px;height: 180px;border: 0;margin: 15px auto 0 auto;display: block;background-color: #fff;padding: 10px;"></iframe>
      <div class="confirm_area">
        ご登録前に、利用規約および<a href="/support/privacy.html#rightContent" class="profile" target="_blank">プライバシーポリシー</a>をご確認ください。<br />
        <input type="checkbox" name="agree" id="agree"> 利用規約に同意
      </div>
      <div style="height: 20px;"></div>
    </div>
  </div>
  <div class="button_area">
    <div class="step_button3" id="back"></div>
    <div class="step_button4" id="complate"></div>
  </div>
  <div class="footer">- <a href="/">HOME</a> -</div>
</div>
<form action="/user/register/complate" id="formComp" name="formComp" method="post">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="openid" value="{{ $openid }}">
  <input type="hidden" name="openIdProvider" value="{{ $openIdProvider }}">
  <input type="hidden" name="birthday" value="{{ $year . '-' . $month . '-' . $day }}">
  <input type="hidden" name="gender" value="{{ $gender }}">
</form>
<script type="text/javascript">
$(function() {
	$("#back").click(function() {
		window.history.go(-1);
	});

	$("#complate").click(function() {
		if($("#agree").prop('checked')) {
			$("#formComp").submit();
		}
		else {
			$(".confirm_area").css("color", "red");
			return false;
		}
	});
});
</script>

@include('adTag.googleAnalytics')
@include('adTag.user_register_step2Confirm')

</body>
</html>