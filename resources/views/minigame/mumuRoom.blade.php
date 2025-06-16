<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>ムムの部屋</title>

	<link rel="stylesheet" type="text/css" href="//ap-statics.loas.jp/mm2/official/css/mumuRoom.css">
	<script src="//ap-statics.loas.jp/mm2/official/js/jquery.min.js"></script>

	<script type="text/javascript">
		var __slide_items = {
			@if($isValidGame)
			// 1:{navi:'ビーナス人気投票',isGame:true,slide_item:'<iframe style="width:850px;height:450px;border:0;" src="/venuscp?uId={{ $uId }}&sId={{ $sId }}"></iframe>'},
			// 2:{navi:'ビーナス交換',isGame:true,slide_item:'<iframe style="width:850px;height:450px;border:0;" src="/venuscp_exchangePage?uId={{ $uId }}&sId={{ $sId }}"></iframe>'},
			1:{navi:'ガチャ',isGame:true,slide_item:'<iframe style="width:850px;height:450px;border:0;" src="/minigame/gacha/showGame?uId={{ $uId }}&sId={{ $sId }}"></iframe>'},
			@else
			1:{navi:'ムムマトリョーシカ',isGame:false,slide_item:'//ap-statics.loas.jp/mm2/official/images/minigame/gachaBanner/190510.jpg'},
			@endif
		};
	</script>
</head>
<body>
	<div class="slide_area">
		<img class="frame frame1" src="//ap-statics.loas.jp/mm2/official/images/minigame/gacha/frame1.png">
		<img class="frame frame2" src="//ap-statics.loas.jp/mm2/official/images/minigame/gacha/frame2.png">
		<img class="frame frame3" src="//ap-statics.loas.jp/mm2/official/images/minigame/gacha/frame3.png">
		<img class="frame frame4" src="//ap-statics.loas.jp/mm2/official/images/minigame/gacha/frame4.png">
		<img class="frame frame5" src="//ap-statics.loas.jp/mm2/official/images/minigame/gacha/frame5.png">
		<div class="slide_area_wrapper"></div>
	</div>
	<div class="slide_navigator">
		<div class="left_btn"></div>
		<div class="item_btns">
			<div class="item_btns_wrapper"></div>
		</div>
		<div class="right_btn"></div>
	</div>

	<script type="text/javascript">
		$(function(){
			var _slide_area_wrapper = $('.slide_area_wrapper');
			var _item_btns_wrapper = $('.item_btns_wrapper');

			var itemCount = 0;
			for(var k in __slide_items){
				var item = __slide_items[k];
				if(item.isGame == true){
					_slide_area_wrapper.append('<div class="slide_item_'+k+'" style="display:none;">'+item.slide_item+'</div>');
				}else{
					_slide_area_wrapper.append('<div class="slide_item_'+k+'" style="display:none;"><img src="'+item.slide_item+'"></div>');
				}
				_item_btns_wrapper.append('<div class="item_btn" data-btn-num="'+k+'">'+item.navi+'</div>');
				itemCount++;
			}
			$('.slide_item_1').show();

			if(itemCount < 4){
				for(var i=0;i<4-itemCount;i++){
					_item_btns_wrapper.append('<div class="empty_item_btn"></div>');
				}
			}

			var _item_btn = $('.item_btn');
			var _left_btn = $('.left_btn');
			var _right_btn = $('.right_btn');
			var item_width = _item_btn.outerWidth();
			var wrapper_position = 0;
			var canPagingCount = _item_btn.length - 4;
			var nowPagingCount = 0;

			if (_item_btn.length > 4) {
				_item_btns_wrapper.width(_item_btn.length * item_width);

				_left_btn.click(function(){
					if (nowPagingCount > 0) {
						nowPagingCount--;

						wrapper_position += item_width;
						_item_btns_wrapper.animate({
							'left': wrapper_position+'px'
						},{
							complete: function(){
								_right_btn.css({'border-color':'transparent transparent transparent #ffffff','cursor':'pointer'});
								if (nowPagingCount == 0) {
									_left_btn.css({'border-color':'transparent #555555 transparent transparent','cursor':'default'});
								}
							}
						});
					}
				});

				_right_btn.click(function(){
					if (nowPagingCount < canPagingCount) {
						nowPagingCount++;

						wrapper_position -= item_width;
						_item_btns_wrapper.animate({
							'left': wrapper_position+'px'
						},{
							complete: function(){
								_left_btn.css({'border-color':'transparent #ffffff transparent transparent','cursor':'pointer'});
								if (nowPagingCount == canPagingCount) {
									_right_btn.css({'border-color':'transparent transparent transparent #555555','cursor':'default'});
								}
							}
						});
					}
				});
			} else {
				_right_btn.css({'border-color':'transparent transparent transparent #555555','cursor':'default'});
			}

			_item_btn.click(function(){
				var btnNum = $(this).data('btn-num');
				_slide_area_wrapper.children().hide();
				$('.slide_item_'+btnNum).show();
			});
		});
	</script>
</body>
</html>