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
      <div class="sub_page_right" id="rightContents" name="rightContents">
        <div class="sub_page_right_top">
          <span class="sub_page_nav"><a href="{{ config('app.httpsBaseUrl') }}/">HOME</a></span> ＞ <span class="sub_page_nav_current">チャージ特典</span>
        </div>
        <div class="sub_page_right_contents">
          <div class="sub_page_charge_cp_title"></div>
          <div class="sub_page_charge_cp_contents">
            <iframe src="//easygame.jp/loa2/officialsite/charge-cp.html" style="width: 100%;height: 100%;border: 0" allowtransparency="true"></iframe>
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
</body>
</html>