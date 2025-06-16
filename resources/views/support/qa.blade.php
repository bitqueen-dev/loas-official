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
    @include('support.leftMenu', ['page' => 'qa'])
    <div class="contents_right">
      <div class="sub_page_right" id="rightContent" name="rightContent">
        <div class="sub_page_right_top">
          <span class="sub_page_nav"><a href="/">HOME</a></span> ＞ <span class="sub_page_nav"><a href="/support#rightContent">サポート</a></span> ＞ <span class="sub_page_nav"><a href="/support/qa">よくある質問</a></span> ＞ <span class="sub_page_nav_current">動作環境</span>
        </div>
        <div class="sub_page_right_contents">
          <div class="sub_page_support_5_title"></div>
          <div class="support5_sub_title">動作環境</div>
          <div class="support5_contents">
            <iframe src="//easygame.jp/loa2/public/subMenuSupport1.html" style="width: 100%;height: 100%;border: 0" allowtransparency="true" id="support5Contents" name="support5Contents"></iframe>
          </div>
        </div>
        <div class="sub_page_right_bottom"></div>
      </div>
    </div>
    @include('vendor.footer')
    <div style="clear:both;"></div>
  </div>
</div>
<script src="//ap-statics.loas.jp/mm2/official/js/jquery.hashchange.js"></script></head>
<script language="javascript">
$(window).hashchange(
  [{
    hash: "#actionenv",
    onSet: function() {
      location.href = "#rightContent";
      $(".support5_sub_title, .sub_page_nav_current").html("動作環境");
      $("#support5Contents").attr("src", "//easygame.jp/loa2/public/subMenuSupport1.html");
    },
  }, {
    hash: "#login",
    onSet: function() {
      location.href = "#rightContent";
      $(".support5_sub_title, .sub_page_nav_current").html("ログイン");
      $("#support5Contents").attr("src", "//easygame.jp/loa2/public/subMenuSupport2.html");
    },
  }, {
    hash: "#purchuse",
    onSet: function() {
      location.href = "#rightContent";
      $(".support5_sub_title, .sub_page_nav_current").html("課金");
      $("#support5Contents").attr("src", "//easygame.jp/loa2/public/subMenuSupport3.html");
    },
  }, {
    hash: "#game",
    onSet: function() {
      location.href = "#rightContent";
      $(".support5_sub_title, .sub_page_nav_current").html("ゲーム");
      $("#support5Contents").attr("src", "//easygame.jp/loa2/public/subMenuSupport4.html");
    },
  }]
);
</script>
</body>
</html>