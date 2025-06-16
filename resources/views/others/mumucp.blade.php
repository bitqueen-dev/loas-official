<!DOCTYPE html>
<html lang="jp">
<head>
	<meta charset="UTF-8">
	<title>『League of Angels Ⅱ』</title>
	<meta name="keywords" content="リーグオブエンジェル,League of Angel,leagueofangel,LOA,loa,game,ブラウザゲーム,ゲーム,RPG,MMO,声優,田村ゆかり,朴璐美">
	<meta name="description" content="ダークファンタジーRPG『League of AngelsⅡ(リーグオブエンジェル)』">

	<meta name="csrf-token" content="{{ csrf_token() }}">
	<script src="//ap-statics.loas.jp/mm2/official/js/jquery.min.js"></script>
	<script src="//ap-statics.loas.jp/mm2/official/js/layer.js"></script>
	<script src="//ap-statics.loas.jp/mm2/official/js/howler.core.js"></script>

	<link rel="stylesheet" type="text/css" href="//ap-statics.loas.jp/mm2/official/css/campaign/mumucp.css">
</head>
<body>

	<div class="top">
		<div class="top_content">
			<a href="/" target="_blank" class="logo"></a>
			<div onclick="audioClick('h');" class="top_voice_btn hoverAnim"></div>
		</div>
	</div>

	<div class="index_area">
		<a href="#contents_1"><div class="index_btn_1"></div></a>
		<a href="#contents_2"><div class="index_btn_2"></div></a>
		<a href="#contents_3"><div class="index_btn_3"></div></a>
	</div>

	<div id="contents_1">
		<div class="header_label_1"></div>
		<div class="panel">
			<div class="caution">
				</br><font size="4">※注意事項※</font>
				</br>◯通信料はご利用者様負担となります。（Wifi通信利用推奨）
				</br>◯通信環境により適切に動作しないことがあります。
				</br>　また、通信制限下の端末では適切に再生ができない場合があります。ご注意下さい。
				</br>◯アプリはご利用の機種・期間により動作しない場合があります。
				</br>◯視聴期限は2018年9月18日までとなります。
				</br>◯暗い環境での利用は、認識できない原因になります。なるべく明るい場所でご利用ください。
				</br>
				</br>※Android、Google Playは、Google Inc.の商標または登録商標です。
				</br>※iOS商標は、米国Ciscoのライセンスに基づき使用されています。
				</br>　App Store は、Apple Inc.のサービスマークです。
			</div>
		</div>
		<div class="game">
			<div class="play_area">
				@if($endCp)
				<div class="end_cp">キャンペーンは終了しています。</div>
				@else
					@if($login)
					<div class="play_btn hoverAnim" onclick="givePoint();"></div>
					@else
					<div class="play_btn hoverAnim" onclick="login();"></div>
					@endif
				@endif

				<div class="play_count">
					<span class="left_count">{{ $leftCount }}</span> / 5 回
				</div>
			</div>
			<div class="AR_area"></div>
			<div class="game_title"></div>
			<div class="detail_link_btn"></div>
			<div class="detail_area">
				</br>・1日1回無料で占うことができます。(毎日0時に無料回数はリセットされます)
				</br>
				</br>・ACポイントを10ポイント消費することで、占い回数を1回増やすことができます。
				</br>(※ACポイントは"ポイントモール"にてお使いください)
				</br>
				</br>・占いで獲得したり、消費したACポイント数は“ACポイント履歴”から確認できます
				</br>
				</br>・1日最大で5回(無料回数含)まで占うことができます。
				</br>　ACポイントを1日に50ポイント以上消費しても、6回以上の回数は増えませんので、ご注意ください。
				</br>
				</br>・前日に消費したACポイント数は0時でリセットされます。
				</br>　翌日の占い回数が増える事はありませんので、ご注意ください
			</div>
		</div>
	</div>

	<div id="contents_2">
		<div class="header_label_2"></div>
		<div class="panel">
			<div class="voice_btns">
				<div onclick="audioClick(1);" class="voice_btn_1 hoverAnim voice_btn_upper"></div>
				<div onclick="audioClick(2);" class="voice_btn_2 hoverAnim voice_btn_upper"></div>
				<div onclick="audioClick(34);" class="voice_btn_3 hoverAnim voice_btn_upper"></div>
				<div onclick="audioClick(34);" class="voice_btn_4 hoverAnim voice_btn_upper"></div>
				<div onclick="audioClick(59);" class="voice_btn_5 hoverAnim voice_btn_upper"></div>
				<div onclick="audioClick(6);" class="voice_btn_6 hoverAnim voice_btn_lower"></div>
				<div onclick="audioClick(7);" class="voice_btn_7 hoverAnim voice_btn_lower"></div>
				<div onclick="audioClick(8);" class="voice_btn_8 hoverAnim voice_btn_lower"></div>
				<div onclick="audioClick(59);" class="voice_btn_9 hoverAnim voice_btn_lower"></div>
				<div onclick="audioClick(10);" class="voice_btn_10 hoverAnim voice_btn_lower"></div>
			</div>
		</div>
	</div>

	<div id="contents_3">
		<div class="header_label_3"></div>
		<div class="panel"></div>
	</div>

	<a href="/" target="_blank" class="gameStartBtn hoverAnim"></a>
	<div id="top_div"><a id="top_a" onclick="return false;"></a></div>
	<div class="copyright">お問い合わせ : support@loas.jp<br />©BITQUEEN INC. All Rights Reserved.</div>

<script>
	var __inputEnabled = true;
	var __gId = null;
	var __sound = null;
	var __isMax = '{{ $isPlayCountMax }}';

	@if($login)
	__gId = '{{ $gameId }}';
	@endif

	$(function(){
		$(window).scroll(function(){
			var scrolltop = $(this).scrollTop();

			if(scrolltop >= 100){
				$("#top_div").show();
				$(".gameStartBtn").show();
			}else{
				$("#top_div").hide();
				$(".gameStartBtn").hide();
			}
		});

		$("#top_a").click(function(){
			$("html,body").animate({scrollTop: 0}, 500);
		});

		$('.detail_link_btn').click(function(){
			$('.detail_area').slideToggle();
		});

		$('.detail_area').slideToggle();
	});

	function givePoint(){
		if (__gId) {
			if ($('.left_count').text() == 0) {
				if (__isMax == '1') {
					layer.alert('残り回数が足りません。 ACポイントを10ポイント消費で、回数を1回増やせます。',{title:null,btn:['閉じる'],});
				} else {
					layer.alert('本日の占い回数を全て使いきりました。',{title:null,btn:['閉じる'],});
				}
			} else {
				if (__inputEnabled) {
					__inputEnabled = false;
					postGivePoint();
				}
			}
		} else {
			layer.alert('ログインしてください。',{title:null,btn:['閉じる'],});
		}
	}

	function postGivePoint () {
		return $.ajax({
			method: 'POST',
			url: '/Mumucp_play',
			data: {
				gId: __gId,
			},
			type: 'json',
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			timeout: 5000,
		}).done(function(res){
			__inputEnabled = true;

			if (res.status === false && res.code == -9) {
				layer.alert('残り回数が足りません。',{title:null,btn:['閉じる'],});
			} else if (res.status === false && res.code == -7) {
				layer.alert('データベースエラー：お問い合わせフォームよりお問い合わせください。',{title:null,btn:['閉じる'],});
			} else if (res.status === false && res.code == -6) {
				layer.alert('ログインしてください。',{title:null,btn:['閉じる'],});
			} else if (res.status === false && res.code == -10) {
				layer.alert('キャンペーンは終了しています。',{title:null,btn:['閉じる'],});
			} else if (res.status === true && res.code == 0) {
				$('.play_area').hide();
				var AR_area = $('.AR_area');
				AR_area.show();
				AR_area.css('background-image','url("//ap-statics.loas.jp/mm2/official/images/campaign_1807/AR/'+res.img+'.jpg")');

				var leftCount = $('.left_count');
				leftCount.text(leftCount.text()-1);

			} else {
				// console.log(res);
				layer.alert('不明なエラー：お問い合わせフォームよりお問い合わせください。',{title:null,btn:['閉じる'],});
			}
		}).fail(function(err){
			// console.log(err);
			layer.alert('不明なエラー：お問い合わせフォームよりお問い合わせください。',{title:null,btn:['閉じる'],});
		});
	}

	function login(){
		layer.msg('ログインしますか？', {
			time: 0,
			btn: ['ログインする', '閉じる'],
			yes: function(index){
				layer.close(index);
				window.open('//www.loas.jp');
			}
		});
	}

	function audioClick (key) {
		if (__sound) {
			__sound.unload();
		}
	
		__sound = new Howl({
			src: ['//ap-statics.loas.jp/mm2/official/sounds/campaign_1807/' + key + '.wav'],
			volume: 0.5
		});
	
		__sound.play();
	}
</script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-85680179-1', 'auto');
  ga('send', 'pageview');
</script>

</body>
</html>