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
      <a class="sub_menu_common">ゲーム紹介</a>
      <a class="sub_menu_common last on">世界観</a>
      <div class="sub_sub_menu">
        <div class="sub_sub_menu_body">
          <a class="sub_sub_sub_menu" href="/intro/outlook.html#rightContent">勢力</a>
          <a class="sub_sub_sub_menu on" href="/intro/race.html#rightContent">種族</a>
          <a class="sub_sub_sub_menu" href="/intro/outlook/story.html#rightContent" target="_blank">ストーリー</a>
        </div>
        <div class="sub_sub_menu_footer"></div>
      </div>
      <a class="sub_menu_common sub_next" href="/intro/character.html#rightContent" target="_blank">キャラクター紹介</a>
      <a class="sub_menu_common" href="/casting.html" target="_blank">声優</a>
      {{--      <a class="sub_menu_common" href="/intro/playenv.html#rightContent">プレイ環境</a>--}}
      <a class="sub_menu_common" href="/intro/download.html#rightContent">ダウンロード</a>
    </div>
    <div class="contents_right">
      <div class="sub_page_right" id="rightContent" name="rightContent">
        <div class="sub_page_right_top">
          <span class="sub_page_nav"><a href="/">HOME</a></span> ＞ <span class="sub_page_nav"><a href="/intro#rightContent">ゲーム紹介</a></span> ＞ <span class="sub_page_nav"><a href="/intro/outlook.html#rightContent">世界観</a></span> ＞ <span class="sub_page_nav_current">種族</span>
        </div>
        <div class="sub_page_right_contents">
          <div class="sub_page_intro_race_title"></div>
          <div class="support5_sub_title">種族</div>
          <div class="intro_race_country_contents">
            <div class="intro_race_line line1"></div>
            <div class="intro_race_line line2"></div>
            <div class="intro_race_line line3"></div>
            <div class="intro_race_line line4"></div>
            <div class="intro_race_line line5"></div>
            <div class="intro_race_line line6"></div>
            <div class="intro_race_line line7"></div>
            <div class="intro_race_line line8"></div>
            <div class="intro_race_line line9"></div>
            <div class="intro_race_line line10"></div>
            <div class="intro_race_line line11"></div>
            <div class="intro_race_line line12"></div>
            <div class="intro_race_line line13"></div>
            <div class="intro_race_line line14"></div>
            <div class="intro_race_line line15"></div>
            <div class="intro_race_line line16"></div>
            <div class="intro_race_line line17"></div>
            <div class="intro_race_line line18"></div>
            <div class="intro_race_line line19"></div>
            <div class="intro_race_line line20"></div>
            <div class="intro_race_line line21"></div>
            <div class="intro_race_line line22"></div>
            <div class="intro_race_line line23"></div>
            <div class="intro_race_line line24"></div>
            <div class="intro_race_line line25"></div>
            <div class="intro_race_line line26"></div>
            <div class="intro_race_line line27"></div>
            <div class="intro_race_line line28"></div>
            <div class="intro_race_line line29"></div>
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