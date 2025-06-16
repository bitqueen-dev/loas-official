<meta name="theme-color" content="#000000">
<meta name="viewport" content="initial-scale=1 maximum-scale=1 user-scalable=0 minimal-ui" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="format-detection" content="telephone=no">
<meta name="HandheldFriendly" content="true" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="//ap-statics.loas.jp/mm2/official/js/jquery.min.js"></script>
<script src="//ap-statics.loas.jp/mm2/official/js/minigame/phaser.min.js"></script>

{{-- <script src="//ap-statics.loas.jp/mm2/official/js/minigame/sugoroku/sugoroku.min.js?190319"></script> --}}
<script src="/js/minigame/sugoroku/sugoroku.min.js?{{time()}}"></script>

<style type="text/css">
html,body {
    overflow: hidden;
    margin: 0;
    padding: 0;
    background:#000;
    font-family: "ＭＳ Ｐゴシック","メイリオ","Hiragino Kaku Gothic Pro",Meiryo,"ヒラギノ角ゴ Pro W3","MS PGothic","MS UI Gothic",Helvetica,Arial,sans-serif;
    font-weight: bold;
}
canvas {margin:auto !important;}
.wrapper{width: 850px;height: 450px;position: relative;margin: 0;padding: 0;}
.howto_wrapper{
    display:none;
    width:570px;
    height:270px;
    position: absolute;
    top: 80px;
    left: 120px;
    overflow-x: scroll;
    padding: 5px 15px 5px 10px;
    word-break : break-all;
}
</style>

<div class="wrapper">
    <div id="game"></div>
</div>

<div class="howto_wrapper">
    <p>★ゲーム説明</p>
    <p>サイコロを回し、キャラクターを進めて、周回数をどんどん増やそう！</p>
    <p>各マスの宝箱にはアイテムが入っていて、そのマスに止まると</p>
    <p>宝箱からランダムでアイテムがゲーム内システムメールに送付されます。</p>
    <p>(宝箱の中身はマウスオーバーすることで確認できます)</p>
    <br>
    <p>STARTを通過した回数(周回数)によって、特別な宝箱を開くことができます。</p>
    <p>無料回数は条件を満たして増やすことができます。</p>
    <br>
    <p>★ゲームの遊び方</p>
    <p>手順1</p>
    <p>ダイヤ、無料、ロイヤルダイヤのどれかを消費してサイコロを回す。</p>
    <p>※ロイヤルダイヤで回す場合は、貰った報酬が2倍になります。</p>
    <br>
    <p>手順2</p>
    <p>コマが進み、止まったマスのイベントが発生。</p>
</div>

<script type="text/javascript">
    var __uId = '{{$uId}}';
    var __sId = '{{$sId}}';
    var __panelInfo = <?php echo $panelInfo; ?>;
    var __boxInfo = <?php echo $boxInfo; ?>;for(var k in __boxInfo)__boxInfo[k].itemName=(__boxInfo[k].itemNames).join('\n');
    var __userData = <?php echo $userData; ?>;

    var game = new Phaser.Game(850,450,Phaser.AUTO,'game');
    for (var className in BasicGame)game.state.add(className, BasicGame[className]);
    game.state.start('Boot');
</script>