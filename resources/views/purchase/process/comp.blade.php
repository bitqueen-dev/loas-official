<?php
//$error = $errors->all();
//var_dump($error);exit;
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  @include('vendor.metaCommon')
  @include('vendor.titleCommon')
  @include('vendor.cssjs')
</head>
<body onload="go2content();">

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
        <div class="sub_page_right_contents">
          <div class="sub_page_coin_title"></div>
          <div class="coin_page_tabs">
            <div class="coin_tab_item coin_tab_item1">LAコインとは</div>
            <div class="coin_tab_item coin_tab_item2 on">LAコイン購入</div>
            <div class="coin_tab_item coin_tab_item3">LAコイン履歴</div>
          </div>
          <div class="coin_buy_nav step5"></div>
          <div class="coin_buy_step_contents">
            <span class="buy_complete">購入完了</span>
            <div class="coin_buy_step_contents_title">ご利用いただき誠にありがとうございます。お手続きが正常に完了しました。</div>
            <div class="coin_buy_s3_table1">
              <div class="coin_buy_s3_table1_line">
                <div class="coin_buy_s3_table1_c1">注文番号</div>
                <div class="coin_buy_s3_table1_c2">{{ $orderNumber }}</div>
              </div>
              <div class="coin_buy_s3_table1_line">
                <div class="coin_buy_s3_table1_c1">購入日時</div>
                <div class="coin_buy_s3_table1_c2">{{ $createdAt }}</div>
              </div>
              <div class="coin_buy_s3_table1_line">
                <div class="coin_buy_s3_table1_c1">購入金額</div>
                <div class="coin_buy_s3_table1_c2">{{ $coinPrice }} 円</div>
              </div>
              <div class="coin_buy_s3_table1_line">
                <div class="coin_buy_s3_table1_c1">有効期限</div>
                <div class="coin_buy_s3_table1_c2">{{ $expiration }}</div>
              </div>
            </div>
            <div class="buy_complete_words"><br />ご登録のメールアドレスに決済の詳細をお送り致しましたので、<br />ご確認下さい。</div>
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
@include('adTag.purchase_process_comp')

</body>
</html>