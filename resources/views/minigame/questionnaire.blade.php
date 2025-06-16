<!DOCTYPE HTML>
<html>
<head>
  <meta charset="utf-8">
  <title>League of Angels Ⅱ ミニゲーム</title>
  <meta name="apple-mobile-web-app-title" content="League of Angels Ⅱ ミニゲーム">

  <meta name="viewport" content="initial-scale=1 maximum-scale=1 user-scalable=0 minimal-ui" />

  <meta http-equiv="X-UA-Compatible" content="chrome=1, IE=9">
  <meta name="format-detection" content="telephone=no">
  <meta name="HandheldFriendly" content="true" />

  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="black" />

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <style type="text/css">
  body {
    margin: 0px 0px 1px 0px; /* the extra 1px allows the iOS inner/outer check to work */
    background: #000;
  }

  #game, canvas {
    margin: auto;
  }

  #game {
    text-align: center;
    position: relative;
  }

  #noneLogin {
    color: white;
    margin: 10px 10px 10px 10px;
  }

  #noneLogin a:link { color: white; }
  #noneLogin a:visited { color: white; }
  #noneLogin a:hover { color: white; }
  #noneLogin a:active { color: white; }

  .textArea {
    position: absolute;
    display: none;
  }

  .server_area {
    background-image: url(//ap-statics.loas.jp/mm2/official/images/server_list_bg_new.png);
    background-repeat: no-repeat;
    width: 900px;
    height: 560px;
    padding-top: 40px;
  }

  .server_list_title {
    background-image: url(//ap-statics.loas.jp/mm2/official/images/server_list_title.png);
    width: 210px;
    height: 33px;
    margin: auto;
  }

  .server_area_items {
    width: 850px;
    height: 350px;
    margin-left: 55px;
    margin-top: 40px;
    margin-bottom: 20px;
    overflow: hidden;
    padding-top: 120px;
  }

  .server_item {
    background-image: url(//ap-statics.loas.jp/mm2/official/images/server_list_normal_off_c5.png);
    background-repeat: no-repeat;
    background-position: left bottom;
    color: #fff;
    float: left;
    cursor: pointer;
    width: 123px;
    height: 20px;
    padding: 16px 0 0 27px;
    font-size: 14px;
    margin: 0 13px 27px 0;
  }

  .server_item:hover {
      background-image: url("//ap-statics.loas.jp/mm2/official/images/server_list_normal_on_c5.png");
      transition: 0.4s;
      -moz-transition: 0.4s;
      /* Firefox 4 */
      -webkit-transition: 0.4s;
      /* Safari and Chrome */
      -o-transition: 0.4s;
      /* Opera */
  }

  </style>

@if ($login && $gameId)
  {{-- <script src="/js/minigame/phaser.js"></script> --}}
  <script src="//ap-statics.loas.jp/mm2/official/js/minigame/phaser.min.js"></script>
  <script src="//ap-statics.loas.jp/mm2/official/js/jquery.min.js"></script>
  <script src="//ap-statics.loas.jp/mm2/official/js/layer.js"></script>

  <script src="//ap-statics.loas.jp/mm2/official/js/minigame/questionnaire/questionnaire.min.js"></script>
  {{--
  <script src="/js/minigame/questionnaire/Boot.js?{{time()}}"></script>
  <script src="/js/minigame/questionnaire/Preloader.js?{{time()}}"></script>
  <script src="/js/minigame/questionnaire/Title.js?{{time()}}"></script>
  <script src="/js/minigame/questionnaire/Play.js?{{time()}}"></script>
  <script src="/js/minigame/questionnaire/Result.js?{{time()}}"></script>
  --}}
@endif

</head>
<body>

@if ($login && $gameId)

<div id="game">
  <div class="textArea">
    <textarea rows="7" cols="26" maxlength="150">ここに記入ができます。</textarea>
  </div>
</div>

<script type="text/javascript">
  var game = new Phaser.Game(900, 1600, Phaser.AUTO, 'game');
  var __gId = "{{ $gameId }}";
  var __selectServer = function () {};

  for (var className in BasicGame) {
    game.state.add(className, BasicGame[className]);
  }

  game.state.start('Boot');
</script>

@else

<div id="noneLogin">
  <p>ゲームをプレイするにはログインが必要です。トップページよりログインしてください。</p>
  <a href="/">トップページへ</a>
</div>

@endif

</body>
</html>
