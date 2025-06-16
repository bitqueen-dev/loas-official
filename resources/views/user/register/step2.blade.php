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
      <div class="step_title step_title2"></div>
      <div class="info_table">
        必要事項を入力し「入力内容を確認」ボタンをクリックしてください。
        <form action="/user/register/step2Confirm" id="formInfo" name="formInfo" method="post">
        <table class="step2_table">
          <tr>
            <th>ご希望の外部アカウント</th>
            <td>{{ $openIdProviderName }}</td>
          </tr>
          <tr>
            <th>生年月日</th>
            <td>
              <select name="year" id="year">
                <option value="0" selected="selected">----</option>
                @for ($y = $thisYear; $y >= 1900; $y--)
                <option value="{{ $y }}">{{ $y }}</option>
                @endfor
              </select> 年
              <select name="month" id="month">
                <option value="0" selected="selected">----</option>
                @for ($m = 1; $m <= 12; $m++)
                <option value="{{ $m }}">{{ $m }}</option>
                @endfor
              </select> 月
              <select name="day" id="day">
                <option value="0" selected="selected">----</option>
                @for ($d = 1; $d <= 31; $d++)
                <option value="{{ $d }}">{{ $d }}</option>
                @endfor
              </select> 日
              <span style="float: right;color: #ff0000;">※ 変更不可</span>
            </td>
          </tr>
          <tr>
            <th>性別</th>
            <td>
              <input type="radio" name="gender" id="gender" value="male"> 男性　　
              <input type="radio" name="gender" id="gender" value="female"> 女性
              <span style="float: right;color: #ff0000;">※ 変更不可</span>
            </td>
          </tr>
        </table>
        <div class="error_info" id="errorInfo">　　</div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="openid" value="{{ $openid }}">
        <input type="hidden" name="openIdProvider" value="{{ $openIdProvider }}">
        <input type="hidden" name="openIdProviderName" value="{{ $openIdProviderName }}">
        </form>
      </div>
    </div>
  </div>
  <div class="step_button step_button2" id="infoConfirm"></div>
  <div class="footer">- <a href="/">HOME</a> -</div>
</div>
<script type="text/javascript">
$(function() {
	$("#infoConfirm").click(function() {
		if(($("#year").val() == '0') || ($("#month").val() == '0') || ($("#day").val() == '0')) {
			$("#errorInfo").show().html("※ 生年月日を選択してください。");
			return false;
		}

		if(typeof($('input[name=gender]:checked', '#formInfo').val()) == 'undefined') {
			$("#errorInfo").show().html("※ 性別を選択してください。");
			return false;
		}

		$("#formInfo").submit();
	});
});
</script>

@include('adTag.googleAnalytics')
@include('adTag.user_register_step2')

</body>
</html>