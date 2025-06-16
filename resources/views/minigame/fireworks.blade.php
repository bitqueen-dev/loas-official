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

  <script src="//ap-statics.loas.jp/mm2/official/js/minigame/phaser.min.js"></script>
  <script src="//ap-statics.loas.jp/mm2/official/js/jquery.min.js"></script>

  <style type="text/css">
  body {
    margin: 0px 0px 1px 0px; /* the extra 1px allows the iOS inner/outer check to work */
    background: #000;
  }

  canvas {
    margin: auto;
  }

  #game {
    text-align: center;
  }

  #noneLogin {
    color: white;
    margin: 10px 10px 10px 10px;
  }

  #noneLogin a:link { color: white; }
  #noneLogin a:visited { color: white; }
  #noneLogin a:hover { color: white; }
  #noneLogin a:active { color: white; }
  </style>

  <script src="//ap-statics.loas.jp/mm2/official/js/minigame/fireworks/Boot.min.js"></script>
  <script src="//ap-statics.loas.jp/mm2/official/js/minigame/fireworks/Preloader.min.js"></script>
  <script src="//ap-statics.loas.jp/mm2/official/js/minigame/fireworks/MainMenu.min.js"></script>
  <script src="//ap-statics.loas.jp/mm2/official/js/minigame/fireworks/Play.min.js"></script>

</head>
<body>

@if ($login && $gameId)
<div id="game"></div>

<script type="text/javascript">
  var game = new Phaser.Game(900, 1600, Phaser.AUTO, 'game');
  var gameId = "{{ $gameId }}"

  // Add the game States; could be done in Boot but just as easy here
  game.state.add('Boot', BasicGame.Boot);
  game.state.add('Preloader', BasicGame.Preloader);
  game.state.add('MainMenu', BasicGame.MainMenu);
  game.state.add('Play', BasicGame.Play);

  // Now start the Boot state.
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
