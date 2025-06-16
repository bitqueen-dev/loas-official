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

	.exchange_area {
		color: white;
		margin-left: 30px;
		margin-top: 30px;
	}

	table {
		color: white;
		width: 460px;
	}

	td {
		text-align: center;
	}
</style>
<script src="//ap-statics.loas.jp/mm2/official/js/jquery.min.js"></script>

<div class="wrapper">
	<div class="frame_1">
		<div class="exchange_area">
			<?php
				$option = '';
				for ($i = 1; $i < 100; $i++) {
					$option .= '<option value ="'.$i.'">'.$i.'</option>';
				}
			?>

			<p>アイテム交換リスト</p>

			<table border="1">
				<tr>
					<th>消費投票数</th>
					<th>アイテム名</th>
					<th>交換数</th>
					<th></th>
				</tr>
				<tr>
					<td>1</td>
					<td>神聖結晶*1</td>
					<td>
						<select id="item1" name="item1">
							<?php echo $option; ?>
						</select>
					</td>
					<td><button onclick="exchange(1)">交換</button></td>
				</tr>
				<tr>
					<td>5</td>
					<td>出陣シール*1</td>
					<td>
						<select id="item2" name="item2">
							<?php echo $option; ?>
						</select>
					</td>
					<td><button onclick="exchange(2)">交換</button></td>
				</tr>
				<tr>
					<td>10</td>
					<td>限定アイテム引換え券*1</td>
					<td>
						<select id="item3" name="item3">
							<?php echo $option; ?>
						</select>
					</td>
					<td><button onclick="exchange(3)">交換</button></td>
				</tr>
			</table>

			<p>交換可能数: <span class="exchangePoint"></span></p>
		</div>
	</div>
</div>

<script type="text/javascript">
	var imgPath = 'https://ap-statics.loas.jp/mm2/official/images/cp_1905';
	var exchangePoint = 0;
	var itemInfo = <?php echo $itemInfo ?>;
	var inputEnabled = true;

	(function(){
		var userInfo = <?php echo $userInfo ?>;//[] or [0][]

		if (userInfo[0]) {
			exchangePoint = userInfo[0].exchangePoint;
		}

		$('.exchangePoint').text(exchangePoint);
	})();

	function exchange (itemId) {
		if (inputEnabled == false) {
			return;
		}

		inputEnabled = false;

		var itemCount = $('#item'+itemId).val();
		var price = itemInfo[itemId].comsumptionPoint * itemCount;

		if (exchangePoint >= price) {
			$.ajax({
				method: 'POST',
				url: '/venuscp_exchange',
				data: {
					uId: '{{ $uId }}',
					sId: '{{ $sId }}',
					itemId: itemId,
					itemCount: itemCount,
				},
				type: 'json',
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				timeout: 5000,
			}).done(function(res){
				inputEnabled = true;
				console.log(res);
				if (res.code == 0 && res.status == true) {
					exchangePoint = exchangePoint - price;
					$('.exchangePoint').text(exchangePoint);
					alert('アイテムをメールでお送りしました。');
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
		} else {
			alert('残高が足りません');			
		}
	}
</script>

@else

ログインしてください。

@endif