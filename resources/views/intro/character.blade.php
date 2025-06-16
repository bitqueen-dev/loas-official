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
  <div class="contents_intro" id="rightContent" name="rightContent">
    <div class="title">
      <div class="title_name"><img id="pageTitle" name="pageTitle" src="//ap-statics.loas.jp/mm2/official/images/Character_title.png" /></div>
    </div>
    <div class="contents_submenu_horizontal">
      <div class="sub_menu_item_horizontal sub_menu_character_1 on" onclick="javascript:changeGroup(1);"></div>
      <div class="sub_menu_item_horizontal sub_menu_character_2" onclick="javascript:changeGroup(2);"></div>
      <div class="sub_menu_item_horizontal sub_menu_character_3" onclick="javascript:changeGroup(3);"></div>
      <div class="sub_menu_item_horizontal sub_menu_character_4" onclick="javascript:bossGroupView();"></div>
    </div>
    <div class="character_info">
      <div class="character_img"></div>
      <div class="character_name"><img src="//ap-statics.loas.jp/mm2/official/images/characterName_1_1.png" id="characterName" name="characterName" /></div>
      <div class="character_cv">
        <div class="character_cv_listen_icon"></div>
        <div id="character_cv_listen_btn_1" class="character_cv_listen_btn">①</div>
        <div id="character_cv_listen_btn_2" class="character_cv_listen_btn">②</div>
        <div id="character_cv_listen_btn_3" class="character_cv_listen_btn">③</div>
        <img src="//ap-statics.loas.jp/mm2/official/images/characterCVName_1_1.png" id="characterCVName" name="characterCVName" />
      </div>
      <div class="character_desc"></div>
      <div class="character_desc_next_page" id="characterDescNextPage" name="characterDescNextPage"></div>
      <div class="character_desc_pre_page" id="characterDescPrePage" name="characterDescPrePage"></div>
      <div class="character_list">
        <div class="character_list_text"></div>
        <div class="character_list_contents" id="characterListSlider"></div>
      </div>
      <div class="character_backGroup_btn hoverAnim"></div>
    </div>
    <div class="group_info">
      <div class="group_leader_character"></div>
      <div id="group_character_list" class="group_character_list"></div>
    </div>
    <div class="boss_group_info">
      <div id="boss_group_character_list" class="boss_group_character_list"></div>
    </div>
  </div>
  @include('vendor.footerSingle')
</div>
<script src="//ap-statics.loas.jp/mm2/official/js/scrollForever.min.js"></script>
<script src="//ap-statics.loas.jp/mm2/official/js/howler.core.js"></script>
<script language="JavaScript">
  var characterId = <?php echo isset($_GET['gc']) ? $_GET['gc'] : 0 ?>;
  initialSetCharacter(characterId);
</script>
@include('adTag.googleAnalytics')
</body>
</html>