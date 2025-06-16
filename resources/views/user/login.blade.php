<?php
$releaseTime = strtotime(config('app.releaseTime'));
$currentTime = time();
if(($releaseTime < $currentTime) || (in_array($_SERVER['REMOTE_ADDR'], config('app.ipWhriteList')))) {
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  @include('vendor.metaCommon')
  @include('vendor.titleCommon')

  <link rel="stylesheet" href="//ap-statics.loas.jp/mm2/official/css/login.css">
  <script src="//ap-statics.loas.jp/mm2/official/js/jquery.min.js"></script>
</head>
<body>
<div class="wrapper">
  <div class="contents">
    <div class="words">下記サービスをご利用の場合は、すでにお持ちのIDでログインする事ができます。</div>
    <div class="openid_area">
      <div class="openid yahoo" id="openidYahoo"></div>
      <div class="openid google" id="openidGoogle"></div>
      <div class="openid twitter" id="openidTwitter"></div>
      <div class="openid facebook" id="openidFacebook"></div>
    </div>
    <div class="words">※ 初めてログインされる方は<a href="/support/terms.html#rightContent" target="_top">利用規約</a>に同意が必要となります。</div>
  </div>
</div>
<script type="text/javascript">
$("#openidYahoo").click(function() {
	window.top.location.href = "/auth/yahoojp";
});
$("#openidGoogle").click(function() {
	window.top.location.href = "/auth/google";
});
$("#openidTwitter").click(function() {
	window.top.location.href = "/auth/twitter";
});
$("#openidFacebook").click(function() {
	window.top.location.href = "/auth/facebook";
});
</script>
<div style="display:none;">
<img src="//ad.maist.jp/ad/rtg/view?_view=256" width="1" height="1">
</div>
</body>
</html>
<?php
} else {
?>
<html lang="ja">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, maximum-scale=1.0" />
  <title>login</title>
  <link rel="stylesheet" href="//ap-statics.loas.jp/mm2/official/css/jbclock.css" type="text/css" media="all" />
  <script type="text/javascript" src="//ap-statics.loas.jp/mm2/official/js/jquery.min.js"></script>
  <script type="text/javascript" src="//ap-statics.loas.jp/mm2/official/js/jbclock.js"></script>
  <script type="text/javascript">
    $(document).ready(function () {
      JBCountDown({
        secondsColor: "#ffdc50",
        secondsGlow: "none",

        minutesColor: "#9cdb7d",
        minutesGlow: "none",

        hoursColor: "#378cff",
        hoursGlow: "none",

        daysColor: "#ff6565",
        daysGlow: "none",

        startDate: "{{ strtotime('2017-01-01 00:00:00') }}",
        endDate: "{{ $releaseTime }}",
        now: "{{ time() }}"
      });
    });
  </script>
</head>

<body>

<div class="wrapper">
  <div style="text-align: center; font-size: 30px; margin-top: 25px; margin-bottom: 25px; width: 100%;">正式サービス開始まで</div>
  <div class="clock">
    <div class="clock_days">
      <canvas id="canvas_days" height="190px" width="190px" id="canvas_days"></canvas>
      <div class="text">
        <p class="val">0</p>
        <p class="type_days">Days</p>
      </div>
    </div>
    <div class="clock_hours">
      <canvas height="190px" width="190px" id="canvas_hours"></canvas>
      <div class="text">
        <p class="val">0</p>
        <p class="type_hours">Hours</p>
      </div>
    </div>
    <div class="clock_minutes">
      <canvas height="190px" width="190px" id="canvas_minutes"></canvas>
      <div class="text">
        <p class="val">0</p>
        <p class="type_minutes">Minutes</p>
      </div>
    </div>
    <div class="clock_seconds">
      <canvas height="190px" width="190px" id="canvas_seconds"></canvas>
      <div class="text">
        <p class="val">0</p>
        <p class="type_seconds">Seconds</p>
      </div>
    </div>
  </div><!--/clock -->
</div><!--/wrapper -->
</body>
</html>
<?php }?>