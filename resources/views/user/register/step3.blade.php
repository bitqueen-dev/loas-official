<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  @include('vendor.metaCommon')
  @include('vendor.titleCommon')

  <link rel="stylesheet" href="//ap-statics.loas.jp/mm2/official/css/reg.css">
</head>
<body>
<div class="wrapper">
  <div class="title"></div>
  <div class="contents">
    <div class="info_area">
      <div class="info_title">無料会員登録</div>
      <div class="step_info step_info3"></div>
      <div class="step_title step_title3"></div>
      <div class="info_table">
        <span style="color: #ff0000;">会員登録が完了しました。</span><br /><br />下記ボタンをクリックして、ゲームをお楽しみください。
      </div>
    </div>
  </div>
  <div class="step_button step3_button" onclick="javascript:window.location.href='/?pop=showServers'"></div>
  <div class="footer">- <a href="/">HOME</a> -</div>
</div>

@include('adTag.googleAnalytics')
@include('adTag.user_register_step3')

</body>
</html>
