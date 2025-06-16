<!DOCTYPE html>
<html>
<head>
  <meta NAME=”ROBOTS” CONTENT=”NOINDEX,NOFOLLOW,NOARCHIVE”>
  <script src="//ap-statics.loas.jp/mm2/official/js/jquery.min.js"></script>
  <script src="//ap-statics.loas.jp/mm2/official/js/messenger.js"></script>
  <script src="//ap-statics.loas.jp/mm2/official/js/layer.js"></script>
</head>
<body>

<button onclick="gachaAreaShow()">ミニゲーム起動TEST</button>
Server: <input type="text" class="s" value="2433310001">
UserId: <input type="text" class="u" value="official-58b6160a9497c6b2fcd20d5c084a5e0b">

<script type="text/javascript">
function gachaAreaShow () {
  __currentServerId = $('.s').val();
  __currentAccountId = $('.u').val();

  layer.open({
    type: 2,
    title: false,
    closeBtn: 1,
    shadeClose: false,
    shade: 0.4,
    anim: 2,
    offset: '100px',
    area: ['850px', '510px'],
    content: '/minigame/gacha/top?uId='+__currentAccountId+'&sId='+__currentServerId
  });

  return false;
}
// gachaAreaShow();
</script>

<?php
require(app_path('/Support/minigame.php'));
$items = config('minigame.gacha.items');
/*
for($j=0;$j<20;$j++){
echo '====================== '.($j+1).'回目<br>';
for ($i = 0; $i < 10; $i++) {
  if($i==9){
    $g = gachaSystem(config('minigame.gacha.decidedItems'));
  }else{
    $g = gachaSystem($items);
  }
  echo '<img width=30 src="http://static.test.loas.jp/mm2/official/images/minigame/gacha/items/'.$g['itemId'].'.png"> '.$g['name'].'  '.$g['rare'].'<br>';}
echo '<br>';}
*/
echo '<br><br>======================<br><br>全リスト<br>';
foreach($items as $g)echo '<img width=30 src="http://static.test.loas.jp/mm2/official/images/minigame/gacha/items/'.$g['itemId'].'.png"> '.$g['name'].$g['rare'].' '.($g['probability']/10000).'<br>';
$decidedItems = config('minigame.gacha.decidedItems');
echo '<br><br>======================<br><br>全リスト(10回目)<br>';
foreach($decidedItems as $g)echo '<img width=30 src="http://static.test.loas.jp/mm2/official/images/minigame/gacha/items/'.$g['itemId'].'.png"> '.$g['name'].$g['rare'].' '.($g['probability']/10000).'<br>';
?>
<br><br>
</body>
</html>