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
          <span class="sub_page_nav"><a href="/">HOME</a></span> ＞ <span class="sub_page_nav"><a href="/pointMall/intro.html#rightContent">ポイントモール</a></span> ＞ <span class="sub_page_nav_current">ACポイント履歴</span>
        </div>
        <div class="sub_page_right_contents">
          <div class="sub_page_point_title"></div>
          <div class="coin_page_tabs">
            <div class="coin_tab_item point_tab_item1">ACポイントとは</div>
            <div class="coin_tab_item point_tab_item2">ポイントモール</div>
            <div class="coin_tab_item point_tab_item3 on">ACポイント履歴</div>
          </div>
          <div class="point_history_title"></div>

          <div class="coin_history_list">
            <div class="coin_history_list_header">
              <div class="coin_history_list_header_item item1">購入日時</div>
              <div class="coin_history_list_header_item item2">商品名</div>
              <div class="coin_history_list_header_item item3">ACポイント</div>
              <div class="coin_history_list_header_item item4">注文番号</div>
              <div class="coin_history_list_header_item item_point">シリアルコード</div>
            </div>
            @for($i = 0; $i < count($historys); $i++)
            <div class="coin_history_list_body">
              <div class="coin_history_list_body_item_{{ ($i % 2 == 0) ? '1' : '2' }} item1">{{ $historys[$i]['createdAt'] }}</div>
              <div class="coin_history_list_body_item_{{ ($i % 2 == 0) ? '1' : '2' }} item2">{{ $historys[$i]['name'] }}</div>
              <div class="coin_history_list_body_item_{{ ($i % 2 == 0) ? '1' : '2' }} item3">{{ $historys[$i]['price'] }} ACポイント</div>
              <div class="coin_history_list_body_item_{{ ($i % 2 == 0) ? '1' : '2' }} item4" onclick="orderNumShow('{{ $historys[$i]['orderNumber'] }}', this);" id="{{ $historys[$i]['orderNumber'] }}">表示する</div>
              <div class="coin_history_list_body_item_{{ ($i % 2 == 0) ? '1' : '2' }} item_point"><?php $str =  ($historys[$i]['code'] == '--') ? '--' : '<a style="color: #000;text-decoration: underline;" href="javascript:orderNumShow(\'' . $historys[$i]['code'] . '\')" id="' . $historys[$i]['code'] . '">表示する</a>';echo $str; ?></div>
            </div>
            @endfor
          </div>
        </div>
        <div class="sub_page_right_bottom" style="text-align: center;">
        @include('pagination.limit_links', ['paginator' => $pointHistory])
        </div>
      </div>
    </div>
    @include('vendor.footer')
    <div style="clear:both;"></div>
  </div>
</div>

</body>
</html>