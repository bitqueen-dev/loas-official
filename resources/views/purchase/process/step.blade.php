<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  @include('vendor.metaCommon')
  @include('vendor.titleCommon')
  @include('vendor.cssjs')
  <script src="/purchase/paymentInfo.js"></script>
</head>
<body>

<div class="wrapper">
  @include('vendor.topMenu')

  <div class="contents">
    @include('vendor.left')
    <div class="contents_right">
      @include('vendor.rightSlider')
      <div class="sub_page_right" id="processContents" name ="processContents">
        <div class="sub_page_right_top">
          <span class="sub_page_nav"><a href="{{ config('app.httpsBaseUrl') }}/">HOME</a></span> ＞ <span class="sub_page_nav"><a href="/purchase/intro#introContents">LAコイン購入</a></span> ＞ <span class="sub_page_nav_current">LAコインとは</span>
        </div>
        <div class="sub_page_right_contents" id="step1">
          <div class="sub_page_coin_title"></div>
          <div class="coin_page_tabs">
            <div class="coin_tab_item coin_tab_item1">LAコインとは</div>
            <div class="coin_tab_item coin_tab_item2 on">LAコイン購入</div>
            <div class="coin_tab_item coin_tab_item3">LAコイン履歴</div>
          </div>
          <div class="coin_buy_nav step1"></div>
          <div class="coin_buy_step_contents">
            <div class="coin_buy_step_contents_title">購入する金額をお選び下さい。</div>
            <div class="coin_item_select_100">
              <div class="coin_item_table_head">
                <div class="coin_item_table_head_item item1">商品名</div>
                <div class="coin_item_table_head_item item2">お支払い金額</div>
                <div class="coin_item_table_head_item item3">獲得ACポイント</div>
              </div>
              @foreach ($chargeInfo['chargeInfo'] as $itemId => $pointChargeInfo)
              <div class="coin_item_table_body">
                <div class="coin_item_table_body_item item1"><label><input name="itemInfo" type="radio" value="{{ $itemId }}" />{{ $pointChargeInfo['name'] }}</label></div>
                <div class="coin_item_table_body_item item2">{{ $pointChargeInfo['pay'] }}円（税込）</div>
                <div class="coin_item_table_body_item item3">@if($chargeInfo['pointCP'] == true)<span style="text-decoration:line-through;color:#ff0000;">{{ $pointChargeInfo['pointOriginal'] }}</span> @endif{{ $pointChargeInfo['point'] }} pt</div>
              </div>
              @endforeach
            </div>
            <a href="{{ config('app.httpsBaseUrl') }}/pointMall/intro.html#rightContent" class="blue_word_right">ACポイントとは</a>
            <div class="coin_buy_step_button one_button">
              <div class="coin_buy_step_next" onclick="goStep1();"></div>
            </div>
          </div>
        </div>
        <div class="sub_page_right_contents" id="step2" style="display:none;">
          <div class="sub_page_coin_title"></div>
          <div class="coin_page_tabs">
            <div class="coin_tab_item coin_tab_item1">LAコインとは</div>
            <div class="coin_tab_item coin_tab_item2 on">LAコイン購入</div>
            <div class="coin_tab_item coin_tab_item3">LAコイン履歴</div>
          </div>
          <div class="coin_buy_nav step2"></div>
          <div class="coin_buy_step_contents">
            <div class="coin_buy_step_contents_title">希望するお支払い方法をお選び下さい。</div>
            <div class="coin_buy_step2_contents">
              <div class="coin_pay_way_list">
                <div class="coin_pay_way_item">
                  <label><img src="//ap-statics.loas.jp/mm2/official/images/coin_pay_way_1.png" /><input name="payWay" type="radio" value="card" /><br /><span style="letter-spacing:-1px;">クレジットカード</span></label>
                </div>
                <div class="coin_pay_way_item">
                  <label><img src="//ap-statics.loas.jp/mm2/official/images/coin_pay_way_2.png" /><input name="payWay" type="radio" value="netbank" /><br /><span style="letter-spacing:-1px;">ジャパネット銀行</span></label>
                </div>
                <div class="coin_pay_way_item">
                  <label><img src="//ap-statics.loas.jp/mm2/official/images/coin_pay_way_3.png" /><input name="payWay" type="radio" value="rakuten" /><br />楽天銀行</label>
                </div>
                <div class="coin_pay_way_item">
                  <label><img src="//ap-statics.loas.jp/mm2/official/images/coin_pay_way_4.png" /><input name="payWay" type="radio" value="webmoney" /><br />WebMoney</label>
                </div>
                <!-- <div class="coin_pay_way_item">
                  <label><img src="/images/coin_pay_way_5.png" /><input name="payWay" type="radio" value="payeasy" /><br />Pay-easy</label>
                </div>  -->
                <div class="coin_pay_way_item">
                  <label><img src="//ap-statics.loas.jp/mm2/official/images/coin_pay_way_6.png" /><input name="payWay" type="radio" value="bitcash" /><br />Bitcash</label>
                </div>
              </div>
            </div>
            <div class="coin_buy_step_button">
              <div class="coin_buy_step_back" onclick="backStep1();"></div>
              <div class="coin_buy_step_next" onclick="goStep2();"></div>
            </div>
          </div>
        </div>
        <div class="sub_page_right_contents" id="step3" style="display:none;">
          <div class="sub_page_coin_title"></div>
          <div class="coin_page_tabs">
            <div class="coin_tab_item coin_tab_item1">LAコインとは</div>
            <div class="coin_tab_item coin_tab_item2 on">LAコイン購入</div>
            <div class="coin_tab_item coin_tab_item3">LAコイン履歴</div>
          </div>
          <div class="coin_buy_nav step3"></div>
          <div class="coin_buy_step_contents">
            <div class="coin_buy_step_contents_title">金額をご確認の上、決済画面にお進み下さい。</div>
            <div class="coin_buy_s3_table1">
              <div class="coin_buy_s3_table1_line">
                <div class="coin_buy_s3_table1_c1">商品名</div>
                <div class="coin_buy_s3_table1_c2" id="itemName" name="itemName"></div>
              </div>
              <div class="coin_buy_s3_table1_line">
                <div class="coin_buy_s3_table1_c1">お支払い金額</div>
                <div class="coin_buy_s3_table1_c2" id="itemPay" name="itemPay"></div>
              </div>
              <div class="coin_buy_s3_table1_line">
                <div class="coin_buy_s3_table1_c1">支払方法</div>
                <div class="coin_buy_s3_table1_c2" id="payWayName" name="payWayName"></div>
              </div>
              <div class="coin_buy_s3_table1_line">
                <div class="coin_buy_s3_table1_c1">獲得ACポイント</div>
                <div class="coin_buy_s3_table1_c2" id="acPoint" name="acPoint"></div>
              </div>
            </div>
            <div class="coin_buy_step_contents_title">決済完了通知を送信するメールアドレスを入力して下さい。</div>
            <div class="coin_buy_s3_table2">
              <div class="coin_buy_s3_table2_c1">メールアドレス</div>
              <div class="coin_buy_s3_table2_c2">
              <form action="/purchase/posterPurchase" method="post" id="posterPurchase" name="posterPurchase">
                <input type="hidden" name="itemCode" id="itemCode" value="" />
                <input type="hidden" name="payWayCode" id="payWayCode" value="" />
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <input type="text" name="userEmail" id="userEmail" size="30" value="{{ $userEmail }}" />
                <!-- <label><input name="userEmailRemember" id="userEmailRemember" type="checkbox" <?php if($userEmail != null) echo 'checked';?>/>メールアドレス登録</label> -->
              </form>
              </div>
            </div>
            <div class="coin_buy_step_button">
              <div class="coin_buy_step_back" onclick="backStep2();"></div>
              <div class="coin_buy_step_next" onclick="goStep3();"></div>
            </div>
          </div>
        </div>
        <div class="sub_page_right_bottom"></div>
      </div>
    </div>
    @include('vendor.footer')
    <div style="clear:both;"></div>
  </div>
</div>

@include('adTag.googleAnalytics')
@include('adTag.purchase_process_step')

</body>
</html>