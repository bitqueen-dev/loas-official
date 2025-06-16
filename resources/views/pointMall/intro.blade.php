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
<body>

<div class="wrapper">
  @include('vendor.topMenu')

  <div class="contents">
    @include('vendor.left')
    <div class="contents_right">
      @include('vendor.rightSlider')
      <div class="sub_page_right" id="rightContent" name="rightContent">
        <div class="sub_page_right_top">
          <span class="sub_page_nav"><a href="/">HOME</a></span> ＞ <span class="sub_page_nav"><a href="/pointMall/intro.html#rightContent">ポイントモール</a></span> ＞ <span class="sub_page_nav_current">ACポイントとは</span>
        </div>
        <div class="sub_page_right_contents">
          <div class="sub_page_point_title"></div>
          <div class="coin_page_tabs">
            <div class="coin_tab_item point_tab_item1 on">ACポイントとは</div>
            <div class="coin_tab_item point_tab_item2">ポイントモール</div>
            <div class="coin_tab_item point_tab_item3">ACポイント履歴</div>
          </div>
          <div class="point_subpage_line1"></div>
          <div class="pointmall_button"></div>
          <div class="point_subpage_line2"></div>
          <div class="point_subpage_line3">
            <div class="coin_subpage1_step">
              <span class="step_title">Step１</span>
              <span class="step_words">「ポイントモール」より、希望するアイテム商品をお選びください。</span>
            </div>
            <div class="coin_subpage1_step">
              <span class="step_title">Step２</span>
              <span class="step_words">商品購入後、ゲーム内アイテム商品を受け取るためのシリアルコードが発行されます。<br />「ACポイント履歴」より、シリアルコードや有効期限をご確認いただけます。</span>
            </div>
            <div class="coin_subpage1_step">
              <span class="step_title">Step３</span>
              <span class="step_words">「GAMESTART」より、アイテム受取を希望するゲームキャラクターを作成したサーバーにログインしてください。</span>
            </div>
            <div class="coin_subpage1_step last">
              <span class="step_title">Step４</span>
              <span class="step_words">ゲーム画面右上にあるミニマップ下の「シリアルコード」アイコンをクリックして、シリアルコード入力画面に進んで、シリアルコードを入力してください。シリアルコードを入力後、アイテムを受け取れます。</span>
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

@include('adTag.pointMall_intro')

</body>
</html>