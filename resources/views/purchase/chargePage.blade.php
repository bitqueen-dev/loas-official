<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Charge Page</title>
  <style type="text/css">
html, body {
    margin: 0;
    padding: 0;
    line-height: 1;
    font-family: "メイリオ", "Hiragino Kaku Gothic Pro", Meiryo, "ヒラギノ角ゴ Pro W3", "MS PGothic", "MS UI Gothic", Helvetica, Arial, sans-serif;
    background-color: #000;
}

td {
    background-color: #1f1912;
    color: #f1c373;
    text-align: center;
}

td img {
    vertical-align: middle;
}

tr {
    width: 100%;
    height: 70px;
}

.item_list {
    width: 100%;
    background-color: #4c3826;
}
  </style>
  <script src="//ap-statics.loas.jp/mm2/official/js/messenger.js" type="text/javascript"></script>
</head>
<body>
<table class="item_list">
  <tbody>
  @foreach ($purchaseInfo as $itemId => $itemInfo)
  <tr>
    <td width="220px">{{ $itemInfo['price'] }} LAコイン</td>
    <td width="220px"><img src="//ap-statics.loas.jp/mm2/official/images/diamond.png">{{ $itemInfo['diamond'] }} ダイヤ</td>
    <td><a href="javascript:charge('{{ $itemId }}')"><img src="//ap-statics.loas.jp/mm2/official/images/charge.png"></a></td>
  </tr>
  @endforeach
  </tbody>
</table>
<script type="text/javascript">
var messenger = new Messenger('charge', 'mm2');
messenger.addTarget(window.parent, 'parentCharge');

function charge(_itemId) {
	var sendArr = {};
	sendArr.itemId = _itemId;

	messenger.targets['parentCharge'].send(JSON.stringify(sendArr));
}
</script>
@include('adTag.googleAnalytics')
</body>
</html>