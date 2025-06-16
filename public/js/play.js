var __currentServerId = null;
var __currentAccountId = null;

function chargeAreaShow() {
	$("#chargeArea").show();
}

function chargeAreaClose() {
	$("#chargeArea").hide();
}

function purchaseProc(_itemId) {
	$("#playArea, #chargeArea").hide();
	var loadingLayer = layer.load('0', {
		shade: [0.2, '#000'],
	});
	
	layer.confirm(__payInfo[_itemId].price + 'LAコイン で ' + __payInfo[_itemId].name + ' を購入します？', {btn: ['OK','キャンセル'],title: false,closeBtn: 0,icon: 0},
		function() {
			$.ajax({
				method: "POST",
				url: "/game/diamondPurchase",
				data: {
					_token: $('meta[name=_token]').attr('content'),
					_sign: $('meta[name=_sign]').attr('content'),
					serverId: __currentServerId,
					accountId: __currentAccountId,
					itemId: _itemId
				}
			})
			.done(function(_resp) {
				layer.close(loadingLayer);
				if(_resp.status == false) {
					if(_resp.errNo == '-4') {
						layer.msg('LAコイン残高が足りません。', {
							icon: 7,
							time: 0,
							btn: ['閉じる']
						}, function () {
							$("#playArea").show();
						});
					} else {
						layer.msg('エラーが発生しました。(エラーコード：' + _resp.errNo + ') サポートにお問合せください。', {
							icon: 7,
							time: 0,
							btn: ['閉じる']
						}, function () {
							$("#playArea").show();
						});
					}

				} else if(_resp.status == true) {
					layer.msg('ダイヤチャージは完了しました。ゲーム内にでご確認ください。', {
						icon: 6,
						time: 0,
						btn: ['閉じる']
					}, function () {
						$("#playArea").show();
					});

					$('meta[name=_sign]').attr('content', _resp.sign);
				}
			});
		},
		function() {
			$("#playArea").show();
			layer.close(loadingLayer);
		}
	);


/*	*/
}