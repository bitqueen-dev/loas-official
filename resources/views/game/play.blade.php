<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>League of Angels Ⅱ {{ $serverName }}</title>
  <meta name="_token" content="{{ csrf_token() }}"/>
  <meta name="_sign" content="{{ $sign }}"/>
  @include('vendor.metaCommon')

  <script src="//ap-statics.loas.jp/mm2/official/js/jquery.min.js"></script>
  <script src="//ap-statics.loas.jp/mm2/official/js/messenger.js"></script>
  <script src="//ap-statics.loas.jp/mm2/official/js/layer.js"></script>
  <script src="//ap-statics.loas.jp/mm2/official/js/play.js"></script>
  <script language="JavaScript">
  var __payInfo = new Array();

  @foreach ($purchaseInfo as $itemId => $itemInfo)
  __payInfo['{{ $itemId }}'] = {'diamond' : {{ $itemInfo['diamond'] }}, 'price' : {{ $itemInfo['price'] }}, 'name' : '{{ $itemInfo['name'] }}'};
  @endforeach
  </script>
  <style>
    html, body {
      margin: 0;
      padding: 0;
      line-height: 25px;
      font-family: "メイリオ", "Hiragino Kaku Gothic Pro", Meiryo, "ヒラギノ角ゴ Pro W3", "MS PGothic", "MS UI Gothic", Helvetica, Arial, sans-serif;
      font-size: 14px;
      height:100%;
    }

    #playArea {
      height:100%;
    }

    .charge_area {
      height: 578px;
      width: 750px;
      position: absolute;
      top: 30px;
      left: 50%;
      background-color: #4c3826;
      display: none;
      margin-left: -375px;
    }

    .charge_frame {
      width: 100%;
      height: 100%
    }

    .charge_close {
      position: absolute;
      right: 0;
      top: 0;
      width: 30px;
      height: 20px;
      margin-left: 0;
      cursor: pointer;
      color: #fff;
      background-color: #4c3826;
      text-align: center;
      line-height: 22px;
      font-size: 15px;
    }
  </style>
</head>
<body>
<div id="playArea" name="playArea">
  <iframe id="gameFrame" src="{{ $playUri }}" scrolling="no" frameborder="0" border="0" style="height:100%;width:100%;">loa2</iframe>
</div>
<div class="charge_area" id="chargeArea" name="chargeArea">
  <iframe id="chargeFrame" src="/purchase/chargePage" scrolling="no" frameborder="0" border="0" class="charge_frame"></iframe>
  <div class="charge_close" onclick="javascript:chargeAreaClose();">X</div>
</div>
<script type="text/javascript">
  var messenger = new Messenger('parent', 'mm2');
  var gameFrame = document.getElementById('gameFrame');

  messenger.addTarget(gameFrame.contentWindow, 'gameFrame');

  messenger.listen(function(msg){
    var purchaseInfo = $.parseJSON(msg);

    if((typeof(purchaseInfo.accountId) != "undefined") && (typeof(purchaseInfo.serverId) != "undefined")) {
      __currentServerId = purchaseInfo.serverId;
      __currentAccountId = purchaseInfo.accountId;

      chargeAreaShow();
    } else {
      alert('Unknow Error!Please try again!');
    }
  });

  var messengerCharge = new Messenger('parentCharge', 'mm2');

  messengerCharge.listen(function(msg){
    var item = $.parseJSON(msg);

    if((typeof(item.itemId) != "undefined")) {
      purchaseProc(item.itemId);
    } else {
      alert('Unknow Error!Please try again!');
    }
  });

  var messengerGacha = new Messenger('parentGacha', 'mm2');

  messengerGacha.listen(function(msg){
    var _resp = $.parseJSON(msg);

    if((typeof(_resp.accountId) != "undefined") && (typeof(_resp.serverId) != "undefined")) {
      __currentServerId = _resp.serverId;
      __currentAccountId = _resp.accountId;

      layer.open({
        type: 2,
        title: false,
        closeBtn: 1,
        shadeClose: false,
        shade: 0.4,
        anim: 2,
        area: ['850px', '510px'],
        content: '/minigame/gacha/top?uId='+__currentAccountId+'&sId='+__currentServerId
      });
    } else {
      alert('Unknow Error!Please try again!');
    }
  });

  $(document).bind("contextmenu",function(e){
    return false;
  });
</script>

@include('adTag.googleAnalytics')
@include('adTag.game_play')

</body>
</html>