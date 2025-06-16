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
      <div class="title_name"><img id="pageTitle" name="pageTitle" src="/images/Story_title.png" /></div>
    </div>
    <div class="contents_submenu_horizontal_story" id="chapterButtonList" name="chapterButtonList"></div>
    <div class="story_chapter_contents">
      <div class="story_chapter_title"></div>
      <div class="story_chapter_words">
        <iframe id="storyChapterWords" name="storyChapterWords" src="//easygame.jp/loa2/public/story-1.html" style="width: 890px;height: 750px;border: 0" allowtransparency="true"></iframe>
      </div>
    </div>
  </div>
  @include('vendor.footerSingle')
</div>
<script language="JavaScript">
  showChapter(1);
</script>
@include('adTag.googleAnalytics')
</body>
</html>