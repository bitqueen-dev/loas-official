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
          <span class="sub_page_nav"><a href="/">HOME</a></span> ＞ <span class="sub_page_nav"><a href="/notice/newest#rightContent">お知らせ</a></span> ＞ <span class="sub_page_nav"><a href="/notice/{{ $topicInfo->typeNameSimp }}#rightContent">{{ $topicInfo->typeNameJa }}</a></span> ＞ <span class="sub_page_nav_current">{{ $topicInfo->title }}</span>
        </div>
        <div class="sub_page_right_contents">
          <div class="sub_page_notice_title"></div>
          <div class="sub_page_topic_title">
            <div class="sub_page_notice_item_type item_type_{{ $topicInfo->typeNameSimp }}">{{ $topicInfo->typeNameJa }}</div>
            <div class="sub_page_notice_contents_title">{{ $topicInfo->title }}</div>
          </div>
          <div class="sub_page_topic_contents">
            <?php echo htmlspecialchars_decode($topicInfo->content); ?>
          </div>
        </div>
        <div class="sub_page_right_bottom"></div>
      </div>
    </div>
    @include('vendor.footer')
    <div style="clear:both;"></div>
  </div>
</div>

</body>
</html>