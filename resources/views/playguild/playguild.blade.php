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
    <div class="contents_left">
      <div class="sub_menu_left_top"></div>
      <a class="sub_menu_common on" href="#beginner">ビギナーズガイド</a>
      <a class="sub_menu_common" href="#howtoplay">基本操作</a>
      <a class="sub_menu_common last" href="#gamesystem">ゲームシステム</a>
      <div class="sub_sub_menu">
        <div class="sub_sub_menu_body">
          <a class="sub_sub_sub_menu" href="#growth">育成</a>
          <a class="sub_sub_sub_menu" href="#singleplay">シングルプレイ</a>
          <a class="sub_sub_sub_menu" href="#playtogether">協力プレイ</a>
          <a class="sub_sub_sub_menu" href="#multiplay">マルチプレイ</a>
          <a class="sub_sub_sub_menu" href="#function">機能</a>
        </div>
        <div class="sub_sub_menu_footer"></div>
      </div>
      <a class="sub_menu_common sub_next" href="#randomitem">ランダムアイテム確率</a>
    </div>
    <div class="contents_right" id="playguildContents" name="playguildContents">
      <div class="sub_page_right" id="rightContent" name="rightContent">
        <div class="sub_page_right_top">
          <span class="sub_page_nav"><a href="/">HOME</a></span> ＞
          <span class="sub_page_nav"><a href="/playguild#playguildContents">プレイガイド</a></span> ＞
          <span class="sub_page_nav" style="display: none;" id="navlevel3" name="navlevel3"><a href="/playguild#gamesystem">ゲームシステム</a></span>
          <span class="sub_page_nav_current">ビギナーズガイド</span>
        </div>
        <div class="sub_page_right_contents">
          <div class="sub_page_playguild_title"></div>
          <div class="support5_sub_title" style="display: none"></div>
          <div class="playguild_contents">
            <iframe src="//easygame.jp/loa2/public/beginner.html" style="width: 100%;height: 100%;border: 0" allowtransparency="true" id="support5Contents" name="support5Contents"></iframe>
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
    [
      {
        hash: "#beginner",
        onSet: function () {
          location.href = "#playguildContents";
          $('.sub_menu_common').removeClass('on');
          $('.sub_sub_sub_menu').removeClass('on');
          $("[href='#beginner']").addClass('on');
          $(".sub_page_nav_current").html("ビギナーズガイド");
          $(".support5_sub_title, #navlevel3").hide();
          $(".sub_page_playguild_title").css("background-image", "url(//ap-statics.loas.jp/mm2/official/images/sub_page_playguild_beginner_title.png)");
          $("#support5Contents").attr("src", "//easygame.jp/loa2/public/beginner.html");
        },
      },
      {
        hash: "#howtoplay",
        onSet: function () {
          location.href = "#playguildContents";
          $('.sub_menu_common').removeClass('on');
          $('.sub_sub_sub_menu').removeClass('on');
          $("[href='#howtoplay']").addClass('on');
          $(".sub_page_nav_current").html("基本操作");
          $(".support5_sub_title, #navlevel3").hide();
          $(".sub_page_playguild_title").css("background-image", "url(//ap-statics.loas.jp/mm2/official/images/sub_page_playguild_howtoplay_title.png)");
          $("#support5Contents").attr("src", "//easygame.jp/loa2/public/playguide_howtoplay.html");
        },
      },
      {
        hash: "#randomitem",
        onSet: function () {
          location.href = "#playguildContents";
          $('.sub_menu_common').removeClass('on');
          $('.sub_sub_sub_menu').removeClass('on');
          $("[href='#randomitem']").addClass('on');
          $(".sub_page_nav_current").html("ランダムアイテム確率");
          $(".support5_sub_title, #navlevel3").hide();
          $(".sub_page_playguild_title").css("background-image", "url(//ap-statics.loas.jp/mm2/official/images/sub_page_playguild_randomitem_title.png)");
          $("#support5Contents").attr("src", "//easygame.jp/loa2/public/playguide.html");
        },
      },
      {
        hash: "#gamesystem",
        onSet: function () {
          location.href = "#playguildContents";
          $('.sub_menu_common').removeClass('on');
          $('.sub_sub_sub_menu').removeClass('on');
          $("[href='#gamesystem']").addClass('on');
          $("[href='#growth']").addClass('on');
          $("#navlevel3").show();
          $(".support5_sub_title").show().html("育成");
          $(".sub_page_nav_current").show().html(" ＞ 育成");
          $(".sub_page_playguild_title").css("background-image", "url(//ap-statics.loas.jp/mm2/official/images/sub_page_playguild_gamesystem_title.png)");
          $("#support5Contents").attr("src", "//easygame.jp/loa2/public/playGuideGameSystem1.html");
        },
      },
      {
        hash: "#growth",
        onSet: function () {
          location.href = "#playguildContents";
          $('.sub_menu_common').removeClass('on');
          $('.sub_sub_sub_menu').removeClass('on');
          $("[href='#gamesystem']").addClass('on');
          $("[href='#growth']").addClass('on');
          $("#navlevel3").show();
          $(".support5_sub_title").show().html("育成");
          $(".sub_page_nav_current").show().html(" ＞ 育成");
          $(".sub_page_playguild_title").css("background-image", "url(//ap-statics.loas.jp/mm2/official/images/sub_page_playguild_gamesystem_title.png)");
          $("#support5Contents").attr("src", "//easygame.jp/loa2/public/playGuideGameSystem1.html");
        },
      },
      {
        hash: "#singleplay",
        onSet: function () {
          location.href = "#playguildContents";
          $('.sub_menu_common').removeClass('on');
          $('.sub_sub_sub_menu').removeClass('on');
          $("[href='#gamesystem']").addClass('on');
          $("[href='#singleplay']").addClass('on');
          $("#navlevel3").show();
          $(".support5_sub_title").show().html("シングルプレイ");
          $(".sub_page_nav_current").show().html(" ＞ シングルプレイ");
          $(".sub_page_playguild_title").css("background-image", "url(//ap-statics.loas.jp/mm2/official/images/sub_page_playguild_gamesystem_title.png)");
          $("#support5Contents").attr("src", "//easygame.jp/loa2/public/playGuideGameSystem2.html");
        },
      },
      {
        hash: "#playtogether",
        onSet: function () {
          location.href = "#playguildContents";
          $('.sub_menu_common').removeClass('on');
          $('.sub_sub_sub_menu').removeClass('on');
          $("[href='#gamesystem']").addClass('on');
          $("[href='#playtogether']").addClass('on');
          $("#navlevel3").show();
          $(".support5_sub_title").show().html("協力プレイ");
          $(".sub_page_nav_current").show().html(" ＞ 協力プレイ");
          $(".sub_page_playguild_title").css("background-image", "url(//ap-statics.loas.jp/mm2/official/images/sub_page_playguild_gamesystem_title.png)");
          $("#support5Contents").attr("src", "//easygame.jp/loa2/public/playGuideGameSystem3.html");
        },
      },
      {
        hash: "#multiplay",
        onSet: function () {
          location.href = "#playguildContents";
          $('.sub_menu_common').removeClass('on');
          $('.sub_sub_sub_menu').removeClass('on');
          $("[href='#gamesystem']").addClass('on');
          $("[href='#multiplay']").addClass('on');
          $("#navlevel3").show();
          $(".support5_sub_title").show().html("マルチプレイ");
          $(".sub_page_nav_current").show().html(" ＞ マルチプレイ");
          $(".sub_page_playguild_title").css("background-image", "url(//ap-statics.loas.jp/mm2/official/images/sub_page_playguild_gamesystem_title.png)");
          $("#support5Contents").attr("src", "//easygame.jp/loa2/public/playGuideGameSystem4.html");
        },
      },
      {
        hash: "#function",
        onSet: function () {
          location.href = "#playguildContents";
          $('.sub_menu_common').removeClass('on');
          $('.sub_sub_sub_menu').removeClass('on');
          $("[href='#gamesystem']").addClass('on');
          $("[href='#function']").addClass('on');
          $("#navlevel3").show();
          $(".support5_sub_title").show().html("機能");
          $(".sub_page_nav_current").show().html(" ＞ 機能");
          $(".sub_page_playguild_title").css("background-image", "url(//ap-statics.loas.jp/mm2/official/images/sub_page_playguild_gamesystem_title.png)");
          $("#support5Contents").attr("src", "//easygame.jp/loa2/public/playGuideGameSystem5.html");
        },
      }
     ]
  );
</script>
@include('adTag.googleAnalytics')
</body>
</html>