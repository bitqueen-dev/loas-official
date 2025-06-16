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

{{--<script src="/js/minigame/gacha/game.js?{{time()}}"></script>--}}
<script src="//ap-statics.loas.jp/mm2/official/js/minigame/gacha/gacha.min.js?190306"></script>
<link rel="stylesheet" type="text/css" href="//ap-statics.loas.jp/mm2/official/css/minigame_gacha.css?190305">

<div class="wrapper">
	<div id="game"></div>
</div>

<script type="text/javascript">
	var __gachaInfo = <?php echo $gachaInfo ?>;
	var __itemList = <?php echo $itemList ?>;
	var __data = {
		specialPlayCreditA: '{{ $specialPlayCreditA }}',
		specialPlayCreditB: '{{ $specialPlayCreditB }}',
		haveTicket: '{{ $haveTicket }}',
		curGachaId: 1001,
		curGachaInfo: __gachaInfo[1001],
		uId: '{{ $uId }}',
		sId: '{{ $sId }}',
		getCardList: null,
		// historyContents: null,
	};

	var __itemInfo1 = <?php echo $itemInfo ?>;
	var __itemInfo2 = <?php echo $decidedItemInfo ?>;

	var game = new Phaser.Game(800,450,Phaser.AUTO,'game');
	for (var className in BasicGame)game.state.add(className, BasicGame[className]);
	game.state.start('Boot');
</script>

<div class="minigame_detail_area">
	<div class="minigame_detail_tab">
		<div class="detail_item_btn" data-btn-num="1">ガチャ説明</div>
		<div class="detail_item_btn" data-btn-num="2">注意事項</div>
		<div class="detail_item_btn" data-btn-num="3">提供割合</div>
	</div>
	<div class="minigame_detail_contents">
		<div class="detail_content_1">
			<p>有償ダイヤ、無償ダイヤまたは専用のガチャ券を消費して、利用できるガチャです。</p>
			<!--
			<p>毎回一括チャージをする毎に、ガチャ券が貰えます。</p>
			<br>
			<p>一括200ダイヤ　=　ガチャ券1枚</p>
			<p>一括400ダイヤ　=　ガチャ券2枚</p>
			<p>一括1236ダイヤ　=　ガチャ券6枚</p>
			<p>一括2080ダイヤ　=　ガチャ券10枚</p>
			<p>一括4200ダイヤ　=　ガチャ券21枚</p>
			<br>
			<p>※累計チャージは適用外となります、一括チャージのチャージ回数によって、ガチャ券が貰えます。</p>
			<p>※ガチャ券の所持数はガチャメイン画面にてご確認をお願い致します。</p>
			-->
			<p>ガチャの画面にてビクトリアの剣をクリックすると、ガチャが開始されます。</p>
			<p>ゲーム内のガチャを引く毎に、ロイヤルダイヤの消費状況はリアルタイムではないため、</p>
			<p>ロイヤルダイヤ残高を確認する際にはゲームを再起動してから確認をお願い致します。</p>
			<p>また、ガチャ内では最低でSSRキャラが必ず出現します。</p>
			<p>※ダイヤで「10回引く」では、「レア度UR以上のキャラが最低1体必ず出現する」は適用外となりますのでご注意下さい。</p>
			<p>GRキャラ出現時には特別演出がございます。</p>
			<p>全てのキャラは欠片の形でメールボックスに送られます。</p>
		</div>
		<div class="detail_content_2" style="display: none;">
			<p>・ピックアップガチャから出現するキャラの提供割合は、キャラによって異なります。</p>
			<p>・ピックアップガチャで出現するキャラは、重複する場合があります。同じキャラの欠片を重複して獲得することができます。</p>
			<p>・ガチャで獲得したキャラは欠片の形でメールボックスに送られます。</p>
			<p>・サーバーとの通信状況等によっては、ガチャ演出がスキップされたり、ガチャ演出の一部または全部が正常では無い状況で表ありますが、キャラの追加は正常に完了しております。キャラ一覧をご確認ください。</p>
			<p>・ガチャは1回ごとに提供割合にもとづいて抽選を行います。そのため、提供割合が１％のキャラが、100回中１回必ず出現するません。</p>
			<p>・ガチャ券につきまして、リセットはされませんがチャージ毎にガチャ券を獲得可能なイベントを期間中のみ行います。</p>
			<p>・１日１回限定で引けるガチャは、毎日00:00にリセットされます。</p>
			<p>・１日１回限定で引けるガチャは、キャラ出現率は「10回引く」の1回目～9回目の割合と同じです。※10回「1日1回限定ガチャ」0％レア度UR以上キャラが出ることになりません。</p>
			<p>・１日１回ダイヤで引けるガチャは、キャラ出現率が10連ロイヤルダイヤガチャの1回目～9回目の割合と同じです。※10連で100％上キャラが出ることになりません。</p>
			<・1日1回ダイヤで引くことが可能なガチャはダイヤのみ使用可能となっております、1日ダイヤは対象外になりますので、ご注意下>
			<p>1日1回限定で引けるガチャはアカウント１つにつき、1日1回となっております。</p>
			<p>サーバー毎に1日1回ではありませんのでご了承下さい。</p>
		</div>
		<div class="detail_content_3" style="display: none;">
			<!--
			<p><ピックアップキャラ></p>
			<p>・イザエル</p>
			<p>・イザエルは今後再登場する場合があります。</p>
			<br>
			-->
			<p>カテゴリ別の提供割合</p>
			<p>・「ロイヤルダイヤ１０回引く」（１回目～９回目）</p>
			<p>GRキャラ	1.0000%</p>
			<p>URキャラ	4.0000%</p>
			<p>SSRキャラ	95.0000%</p>
			<br>
			<p>・「ロイヤルダイヤ１０回引く」（１0回目）</p>
			<p>GRキャラ	1.0000%</p>
			<p>URキャラ	99.0000%</p>
			<br>
			<p>※「ロイヤルダイヤ１０回引く」レア度UR以上キャラが確定で出現します。</p>
			<br>
			<p>・「ロイヤルダイヤ１０回引く」（１回目～９回目）個別提供割合＜全38種＞</p>
			<table class="detail_table">
				<tbody class="detail_table_body_1">
					<tr><th>レア度</th><th>キャラクター詳細</th><th>出現率</th></tr>
					<!--LIST-->
				</tbody>
			</table>
			<p>・「ロイヤルダイヤ１０回引く」（１0回目）個別提供割合＜全11種＞</p>
			<table class="detail_table">
				<tbody class="detail_table_body_2">
					<tr><th>レア度</th><th>キャラクター詳細</th><th>出現率</th></tr>
					<!--LIST-->
				</tbody>
			</table>
			<p>※キャラごとに表示させている提供割合は、表示上小数第５位にてきりすてしているため、すべてを合算しても100％にならないす。</p>
		</div>
	</div>
</div>
