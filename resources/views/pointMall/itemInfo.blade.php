<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @include('vendor.metaCommon')
  @include('vendor.titleCommon')
  <link rel="stylesheet" href="//ap-statics.loas.jp/mm2/official/css/main.css">

  <script src="//ap-statics.loas.jp/mm2/official/js/jquery.min.js"></script>
</head>
<body>
<div class="point_popup" id="confirm">
  <div class="point_popup_title"></div>
  <div class="point_popup_item">
    <img src="{{ $itemInfo['picPath'] }}">{{ $itemInfo['name'] }} X {{ $itemCount }}
  </div>
  @if ($itemInfo['isSalesTime'] === true)
  <div class="point_button_confirm_area"><STRIKE>{{ $itemInfo['point'] * $itemCount }}</STRIKE> <span style="color: #ff0000;">{{ $itemInfo['salesPoint'] * $itemCount }}</span> ACポイント<br /><div class="point_item_buy_button"></div></div>
  @else
  <div class="point_button_confirm_area">{{ $itemInfo['point'] * $itemCount }} ACポイント<br /><div class="point_item_buy_button"></div></div>
  @endif
  <div class="point_button_cancel_area"><div class="point_item_cancel_button"></div></div>
</div>

<div class="point_popup" id="success" style="display: none;">
  <div class="point_popup_comp_title"></div>
  <div class="point_popup_item_comp">
    <img src="{{ $itemInfo['picPath'] }}">{{ $itemInfo['name'] }} X {{ $itemCount }}
  </div>
  <div class="point_code_area_line1">
    <span class="point_code_area_words">お客様が交換されたアイテムをゲーム内メールにお送り致しました。ゲーム内メールをご確認ください。</span>
  </div>
  <div class="point_button_goon"></div>
  <div class="point_button_history"></div>
</div>

<div class="point_popup" style="display: none;" id="error">
  <div class="point_popup_error"></div>
  <div class="point_button_cancel_area_error"><div class="point_item_cancel_button"></div></div>
</div>
<script type="text/javascript">
var indexLayer = parent.layer.getFrameIndex(window.name);

function copyToClipboard(elem) {
  var targetId = "_hiddenCopyText_";
  var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
  var origSelectionStart, origSelectionEnd;
  if (isInput) {
      // can just use the original source element for the selection and copy
      target = elem;
      origSelectionStart = elem.selectionStart;
      origSelectionEnd = elem.selectionEnd;
  } else {
      // must use a temporary form element for the selection and copy
      target = document.getElementById(targetId);
      if (!target) {
          var target = document.createElement("textarea");
          target.style.position = "absolute";
          target.style.left = "-9999px";
          target.style.top = "0";
          target.id = targetId;
          document.body.appendChild(target);
      }
      target.textContent = elem.textContent;
  }
  // select the content
  var currentFocus = document.activeElement;
  target.focus();
  target.setSelectionRange(0, target.value.length);
  
  // copy the selection
  var succeed;
  try {
  	  succeed = document.execCommand("copy");
  	  $("#copySucc").show();
  } catch(e) {
      succeed = false;
  }
  // restore original focus
  if (currentFocus && typeof currentFocus.focus === "function") {
      currentFocus.focus();
  }
  
  if (isInput) {
      // restore prior selection
      elem.setSelectionRange(origSelectionStart, origSelectionEnd);
  } else {
      // clear temporary content
      target.textContent = "";
  }
  return succeed;
}

$(document).ready(function () {
	$('.point_item_cancel_button, .point_button_cancel_area_error').click(function() {
		parent.layer.close(indexLayer);
		$("#copySucc").hide();
	});

	$('.point_button_goon').click(function() {
		window.parent.location.reload(false);
		parent.layer.close(indexLayer);
		$("#copySucc").hide();
	});

	$('.point_button_history').click(function() {
		window.parent.location.href = '/pointMall/history#rightContent';
		parent.layer.close(indexLayer);
		$("#copySucc").hide();
	});

	$('.point_copy_button').click(function() {
		copyToClipboard(document.getElementById("copyTarget"));
	});

	$('.point_item_buy_button').click(function() {
		$('.point_item_buy_button').unbind('click');

		$.ajax({
			method: "POST",
			url: "/pointMall/purchase/{{ $itemId }}/{{ $serverId }}/{{ $itemCount }}",
			type: "json",
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
		})
			.done(function( response ) {
				if((response.status === false) && (response.code == -8)) {
					$("#confirm, #success").hide();
					$("#error").show();

					$(".point_popup_error").html("商品は売り切れました。");
				}

				if((response.status === false) && (response.code == -9)) {
					$("#confirm, #success").hide();
					$("#error").show();

					$(".point_popup_error").html("point残高は足りません。");
				}

				if((response.status === false) && (response.code == -999)) {
					$("#confirm, #success").hide();
					$("#error").show();

					$(".point_popup_error").html("不明なエラーです。もう一度お試してください。");
				}

				if((response.status === true) && (response.code == 0)) {
					$("#confirm, #error").hide();
					$("#success").show();

					$(".point_code").html(response.sCode);
				}
			});
	});
});
</script>
</body>
</html>