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
      <a class="sub_menu_common" href="/intro#rightContent">ゲーム紹介</a>
      <a class="sub_menu_common last" href="/intro/outlook.html#rightContent">世界観</a>
      <div class="sub_sub_menu">
        <div class="sub_sub_menu_body">
          <a class="sub_sub_sub_menu" href="/intro/outlook.html#rightContent">勢力</a>
          <a class="sub_sub_sub_menu" href="/intro/race.html#rightContent">種族</a>
          <a class="sub_sub_sub_menu" href="/intro/outlook/story.html#rightContent" target="_blank">ストーリー</a>
        </div>
        <div class="sub_sub_menu_footer"></div>
      </div>
      <a class="sub_menu_common sub_next" href="/intro/character.html#rightContent" target="_blank">キャラクター紹介</a>
      <a class="sub_menu_common" href="/casting.html" target="_blank">声優</a>
      <a class="sub_menu_common on" href="/intro/playenv.html#rightContent">プレイ環境</a>
    </div>
    <div class="contents_right">
      <div class="sub_page_right" id="rightContent" name="rightContent">
        <div class="sub_page_right_top">
          <span class="sub_page_nav"><a href="/">HOME</a></span> ＞ <span class="sub_page_nav"><a href="/intro#rightContent">ゲーム紹介</a></span> ＞ <span class="sub_page_nav_current">プレイ環境</span>
        </div>
        <div class="sub_page_right_contents">
          <div class="sub_page_intro_playenv_title"></div>
          <div class="play_env"></div>
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