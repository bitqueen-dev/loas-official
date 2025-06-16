@if ($uId && $sId)

<meta name="csrf-token" content="{{ csrf_token() }}">
<style type="text/css">
	body, img {
		margin: 0;
		padding: 0;
	}

	.wrapper {
		width: 850px;
		height: 450px;
		background-image: url('https://ap-statics.loas.jp/mm2/official/images/cp_1905/bg.jpg');
		position: relative;
	}

	.frame_1 {
		width: 522px;
		height: 332px;
		background-image: url('https://ap-statics.loas.jp/mm2/official/images/cp_1905/frame_1.png');
		position: absolute;
		top: 110px;
		left: 38px;
	}

	.chars {
		padding: 20px 35px 0 35px;
	}

	.char_btn {
		cursor: pointer;
		width: 90px;
		height: 90px;
		display: inline-block;
		margin-bottom: 22px;
	}

	.char_icon {
		width: 90px;
		height: 90px;
		margin-left: -11px;
	}

	.char_posted {
		text-align: center;
		color: white;
		font-size: 14px;
	}

	.have_ticket {
		width: 500px;
		margin-left: 20px;
		margin-top: 30px;
		color: white;
		font-size: 14px;
	}

	.confirm_modal, .result_modal {
		display: none;
	}

	.frame_2 {
		width: 412px;
		height: 196px;
		background-image: url('https://ap-statics.loas.jp/mm2/official/images/cp_1905/frame_2.png');
		position: absolute;
		top: 150px;
		left: 92px;
	}

	.post_text {
		width: 272px;
		height: 32px;
		background-image: url('https://ap-statics.loas.jp/mm2/official/images/cp_1905/post_text.png');
		position: absolute;
		top: 20px;
		left: 70px;
	}

	.frame_char_icon {
		width: 112px;
		height: 111px;
		position: absolute;
		top: 34px;
		left: 152px;
	}

	.cancel_btn {
		width: 126px;
		height: 32px;
		background-image: url('https://ap-statics.loas.jp/mm2/official/images/cp_1905/cancel_btn_off.png');
		position: absolute;
		top: 140px;
		left: 50px;
		cursor: pointer;
	}

	.cancel_btn:hover {
		background-image: url('https://ap-statics.loas.jp/mm2/official/images/cp_1905/cancel_btn_on.png');
	}

	.confirm_btn_post {
		width: 126px;
		height: 32px;
		background-image: url('https://ap-statics.loas.jp/mm2/official/images/cp_1905/confirm_btn_off.png');
		position: absolute;
		top: 140px;
		left: 240px;
		cursor: pointer;
	}

	.success_text {
		width: 307px;
		height: 56px;
		background-image: url('https://ap-statics.loas.jp/mm2/official/images/cp_1905/success_text.png');
		position: absolute;
		top: 4px;
		left: 58px;
	}

	.confirm_btn_result {
		width: 126px;
		height: 32px;
		background-image: url('https://ap-statics.loas.jp/mm2/official/images/cp_1905/confirm_btn_off.png');
		position: absolute;
		top: 140px;
		left: 146px;
		cursor: pointer;
	}

	.confirm_btn_post:hover, .confirm_btn_result:hover {
		background-image: url('https://ap-statics.loas.jp/mm2/official/images/cp_1905/confirm_btn_on.png');
	}

	p {
		margin: 0;
		padding: 0;
	}
</style>
<script src="//ap-statics.loas.jp/mm2/official/js/jquery.min.js"></script>

<div class="wrapper">
	<div class="frame_1">
		<div class="chars"></div>
		{{--
		<div class="have_ticket">
			<p>投票券所持：<span class="have_ticket_count">{{ $haveTicket }}</span>枚</p>
		</div>
		--}}
	</div>

	<div class="confirm_modal">
		<div class="frame_2">
			<div class="post_text"></div>
			<div class="frame_char_icon"></div>
			<div class="cancel_btn"></div>
			<div class="confirm_btn_post"></div>
		</div>
	</div>

	<div class="result_modal">
		<div class="frame_2">
			<div class="success_text"></div>
			<div class="frame_char_icon"></div>
			<div class="confirm_btn_result"></div>
		</div>
	</div>

</div>

<script type="text/javascript">
	var imgPath = 'https://ap-statics.loas.jp/mm2/official/images/cp_1905';

	(function(){
		var charInfo = <?php echo $charInfo ?>;
		var userInfo = <?php echo $userInfo ?>;//[] or [0][]

		var userPostedChars = {};
		if (userInfo[0]) {
			for(var i=1;i<=10;i++){
				userPostedChars[i] = userInfo[0]['char'+i];
			}
		}

		var chars = $('.chars');

		charInfo.sort(function(a,b){
			return (a.postCount < b.postCount ? 1 : -1);
		});

		for (k in charInfo) {
			var info = charInfo[k];
			var charId = info.charId;
			chars.append(
				'<div class="char_btn">'+
					'<div class="char_icon">'+
						'<img '+
							'class="char_img" '+
							'data-charid="'+charId+'" '+
							'src="'+imgPath+'/char_'+charId+'_off.png" '+
							'onmouseover="this.src=\''+imgPath+'/char_'+charId+'_on.png\'" '+
							'onmouseout="this.src=\''+imgPath+'/char_'+charId+'_off.png\'" '+
						'>'+
					'</div>'+
					'<div class="char_posted">'+
						'<p><small>投票合計: <span class="posted_count_char_'+charId+'">'+info.postCount+'</span></small></p>'+
						'<p><small>投票数: <span>'+(userPostedChars[charId] || 0)+'</span></small></p>'+
					'</div>'+
				'</div>'
			);
		}

		var confirm_modal = $('.confirm_modal');
		var result_modal = $('.result_modal');
		var charId = 0;
		var inputEnabled = true;

		@if ($canPost)

		$('.char_img').on('click', function(){
			if (inputEnabled) {
				charId = $(this).data('charid');
				confirm_modal.show();
				$('.frame_char_icon').css({
					'background-image': 'url("'+imgPath+'/char_'+charId+'_off.png")'
				});
			}
		});

		var have_ticket_count = $('.have_ticket_count');

		$('.confirm_btn_post').on('click', function(){
			inputEnabled = false;
			confirm_modal.hide();

			if (have_ticket_count.text() == 0) {
				return alert('投票券が足りません');
			}

			$.ajax({
				method: 'POST',
				url: '/venuscp_post',
				data: {
					uId: '{{ $uId }}',
					sId: '{{ $sId }}',
					charId: charId,
				},
				type: 'json',
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				timeout: 5000,
			}).done(function(res){
				inputEnabled = true;
				console.log(res);
				if (res.code == 0 && res.status == true) {
					var charPostedCount = $('.posted_count_char_'+charId);
					charPostedCount.text(Number(charPostedCount.text())+1);

					have_ticket_count.text(Number(have_ticket_count.text())-1);

					result_modal.show();
				} else if (res.code == -5) {
					alert('投票券が足りません');
				} else if (res.code == -10) {
					alert('キャンペーン期間が終了しました。');
				} else {
					alert('Request Error');
				}
			}).fail(function(){
				inputEnabled = true;
				alert('Unknown Error');
			});
		});

		$('.cancel_btn').on('click', function(){
			confirm_modal.hide();
		});

		$('.confirm_btn_result').on('click', function(){
			result_modal.hide();
		});

		@endif
	})();
</script>

@else

ログインしてください。

@endif