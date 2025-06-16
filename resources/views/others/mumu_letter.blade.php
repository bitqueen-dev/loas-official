<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta NAME=”ROBOTS” CONTENT=”NOINDEX,NOFOLLOW,NOARCHIVE”>
	<title>ムムの手紙</title>
	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<link rel="stylesheet" type="text/css" href="//ap-statics.loas.jp/mm2/official/css/campaign/mumu_letter.css">
</head>
<body>
	@if($posted)
	<div class="wrapper">
		<div class="mumu_motion" style="display:block;"></div>
	</div>
	@else
	<div class="wrapper">
		<div class="envelope_back"></div>
		<div class="mumu_back"></div>
		<div class="letter">
			<form>
				<div class="form_wrapper">
					<?php
						$element = '';
						foreach ($questionnaireInfo as $id => $info) {
							$type = $info['type'];
							$contents = $info['contents'];

							$element .= '<div id="'.$id.'">'
									.'<p>'.$info['title'].'</p>';

							switch ($type) {
								case 'radio':
									$element .= '<p id="'.$id.'Empty" class="caution">ひとつ以上選択してください。</p>';
									foreach ($contents as $key => $value) 
										$element .= '<input type="radio" name="'.$id.'" value="'.$key.'">'.$value.'<br>';
									break;
								case 'checkbox':
									$element .= '<p id="'.$id.'Empty" class="caution">ひとつ以上選択してください。</p>';
									foreach ($contents as $key => $value) 
										$element .= '<input type="checkbox" name="'.$id.'[]" value="'.$key.'">'.$value.'<br>';
									break;
								case 'textarea':
									$element .= '<p id="'.$id.'Empty" class="caution">入力してください。</p>';
									$element .= '<textarea maxlength="30" name="'.$id.'"></textarea>';
									break;
								default:break;
							}
							$element .= '</div>';
						}

						echo $element;
					?>
					<div class="send_btn"></div>
					<div style="text-align: center;">
						<p>【ボタンをクリックして送信しましょう】</p>
					</div>
					<input type="hidden" name="uId" value="{{ $uId }}"/>
					<input type="hidden" name="sId" value="{{ $sId }}"/>
            		<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            	</div>
			</form>
		</div>
		<div class="envelope_front"></div> 
		<div class="closed_letter"></div>
		<div class="mumu_motion"></div>
	</div>

	<script type="text/javascript">
		var __formElem,__sendBtnElem,
			__isPostSuccess = false;

		$(function(){
			__formElem = $('form');
			__sendBtnElem = $('.send_btn');

			__sendBtnElem.click(function(){
				__formElem.submit();
			});

			__formElem.submit(doSubmit);
		});

		function doSubmit () {
			if(inputValue()){
				answerPost(this);
				moveLetter();
			}
			return false;
		}

		function answerPost (self) {
			var data = $(self).serialize();
			$.ajax({
				url: '/minigame/mumuletter/answer',
				type:'POST',
				data: data,
				dataType: 'json',
			}).then(function(res){
				if (res.code == 0 && res.status == true)
					__isPostSuccess = true;
			});
		}

		function inputValue () {
			if(!$('input[name=gender]:checked').val())
				return cautionEmpty('gender');
			if(!$('input[name=age]:checked').val())
				return cautionEmpty('age');

			var checkboxNames=
				['join_single','join_cooperation','join_multiple','join_event','interest'];
			for(var k in checkboxNames){
				var name=checkboxNames[k];
				if(!$('input[name="'+name+'[]"]:checked').length>0)
					return cautionEmpty(name);
			}

			if(!$('#event textarea').val())
				return cautionEmpty('event');
			if(!$('#message textarea').val())
				return cautionEmpty('message');

			return true;
		}

		function cautionEmpty (name) {
			$('.caution').hide();
			$('#'+name+'Empty').show();
			var pos = $('.form_wrapper').outerHeight() + $('#'+name).offset().top - __sendBtnElem.offset().top - __sendBtnElem.outerHeight();
			__formElem.animate({scrollTop: pos},'slow');
			return false;
		}

		function moveLetter () {
			$('.letter').animate({
				top: '300px'
			}, 1000, function(){
				$(this).hide();
				$('.envelope_back').hide();
				$('.envelope_front').hide();
				$('.closed_letter').show();
				setTimeout(function(){
					$('.closed_letter').animate({
						top: '0px',
						scaling:.8
					},{
						duration: 1000,
						step: function(now,prop){
							if(prop.prop=='scaling'){
								$(this).css({transform:'scale('+(1-now)+')'});
							}
						},
						complete:function(){
							if (__isPostSuccess == true) {
								setTimeout(function(){
									$('.mumu_back').hide();
									$('.closed_letter').hide();
									$('.mumu_motion').show();
								},300);
							} else {
								alert('通信エラーです。時間をおいてから、もう一度お試しください。');
							}
						}
					});
				},500);
			});
		}
	</script>
	@endif

	<script type="text/javascript">
		$(function(){
			$('.mumu_motion').html(
				'<div class="mumu_motion_gif"></div>'
				+'<p><b>ご協力ありがとうございます</b></p>'
				+'<p><b>報酬アイテム<br>【ダイヤの宝箱（Lv.35）*1、ガチャボックス(英雄)*10、デュアルルーンの宝箱Lv.7 *1】は<br>メールボックスに届きます。</b></p>'
				+'<span style="font-size:12px;">※ダイヤの宝箱（Lv.35）を開くと、ダイヤ*500を貰えます。<br>(キャラクターレベル35から開けます)</span>'
			);
		});
	</script>
</body>
</html>