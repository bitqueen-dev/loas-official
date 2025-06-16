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
      <div class="sub_page_right" id="historyContents" name ="historyContents">
        <div class="sub_page_right_top">
          <span class="sub_page_nav"><a href="{{ config('app.httpsBaseUrl') }}/">HOME</a></span> ＞ <span class="sub_page_nav"><a href="/purchase/intro#introContents">LAコイン購入</a></span> ＞ <span class="sub_page_nav_current">LAコインとは</span>
        </div>
        <div class="sub_page_right_contents">
          <div class="sub_page_coin_title"></div>
          <div class="coin_page_tabs">
            <div class="coin_tab_item coin_tab_item1">LAコインとは</div>
            <div class="coin_tab_item coin_tab_item2">LAコイン購入</div>
            <div class="coin_tab_item coin_tab_item3 on">LAコイン履歴</div>
          </div>
          <div class="coin_history_title"></div>
          @if(!empty($expCoin))
          <div class="coin_history_function">
            {{ config('app.coinExpirationAlertDays') }}日以内に失効するLAコインはございます！({{ $expCoin['num'] }} LAコイン　失効日：{{ $expCoin['earliestTime'] }})
            <!--<select>
              <option>2016/11</option>
              <option selected="selected">2016/11</option>
              <option>2016/11</option>
              <option>2016/11</option>
            </select>-->
          </div>
          @endif
          <div class="coin_history_list">
            <div class="coin_history_list_header">
              <div class="coin_history_list_header_item item1">購入日時</div>
              <div class="coin_history_list_header_item item2">内容</div>
              <div class="coin_history_list_header_item item3">LAコイン</div>
              <div class="coin_history_list_header_item item4">注文番号</div>
              <div class="coin_history_list_header_item item5">有効期限</div>
              <div class="coin_history_list_header_item item6">利用サーバー</div>
            </div>
            @for($i = 0; $i < count($historys); $i++)
            <div class="coin_history_list_body"@if(isset($expCoin['expIds']) && in_array($historys[$i]['id'], $expCoin['expIds'])) style="color: #ffa500;"@endif @if($historys[$i]['type'] == 'system') style="color: #ff0000;"@endif>
              <div class="coin_history_list_body_item_{{ ($i % 2 == 0) ? '1' : '2' }} item1">{{ $historys[$i]['createdAt'] }}</div>
              <div class="coin_history_list_body_item_{{ ($i % 2 == 0) ? '1' : '2' }} item2">
                @if ($historys[$i]['type'] == 'purchase')購入
                @elseif ($historys[$i]['type'] == 'consumption')ダイヤチャージ
                @elseif ($historys[$i]['type'] == 'system')有効期限切れ
                @endif</div>
              <div class="coin_history_list_body_item_{{ ($i % 2 == 0) ? '1' : '2' }} item3">{{ $historys[$i]['coinCount'] }} LAコイン</div>
              @if ($historys[$i]['type'] == 'system')
              <div class="coin_history_list_body_item_{{ ($i % 2 == 0) ? '1' : '2' }} item4" style="text-decoration: none !important;cursor: auto !important;">--</div>
              @else
              <div class="coin_history_list_body_item_{{ ($i % 2 == 0) ? '1' : '2' }} item4" onclick="orderNumShow('{{ $historys[$i]['orderNumber'] }}', this);" id="{{ $historys[$i]['orderNumber'] }}">表示する</div>
              @endif
              <div class="coin_history_list_body_item_{{ ($i % 2 == 0) ? '1' : '2' }} item5">{{ $historys[$i]['expiration'] }}</div>
              <div class="coin_history_list_body_item_{{ ($i % 2 == 0) ? '1' : '2' }} item6">{{ $historys[$i]['serverName'] }}</div>
            </div>
            @endfor
          </div>
        </div>
        <div class="sub_page_right_bottom" style="text-align: center;">
        @include('pagination.limit_links', ['paginator' => $coinHistory])
        </div>
      </div>
    </div>
    @include('vendor.footer')
    <div style="clear:both;"></div>
  </div>
</div>

@include('adTag.googleAnalytics')
</body>
</html>