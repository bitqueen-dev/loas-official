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
          <span class="sub_page_nav"><a href="/">HOME</a></span> ＞ <span class="sub_page_nav"><a href="/notice/newest#rightContent">お知らせ</a></span> ＞ <span class="sub_page_nav_current">{{ $subName }}</span>
        </div>
        <div class="sub_page_right_contents">
          <div class="sub_page_notice_title"></div>
          <div class="notice_category_list">
            <a class="notice_category_item<?php if($subtype == 'newest') echo ' on';?>"
              href="/notice/newest#rightContent">最新情報</a>
            <a class="notice_category_item<?php if($subtype == 'notice') echo ' on';?>"
              href="/notice/notice#rightContent">お知らせ</a>
            <a class="notice_category_item<?php if($subtype == 'event') echo ' on';?>"
              href="/notice/event#rightContent">イベント</a>
            <a class="notice_category_item<?php if($subtype == 'maintenance') echo ' on';?>"
              href="/notice/maintenance#rightContent">メンテナンス</a>
            <a class="notice_category_item<?php if($subtype == 'update') echo ' on';?>"
              href="/notice/update#rightContent">アップデート</a>
          </div>
          <div class="sub_page_notice_item_list">
            @foreach ($topics as $topicInfo)
            <div class="sub_page_notice_item">
              <div class="sub_page_notice_item_type item_type_{{ $topicInfo->typeNameSimp }}">{{ $topicInfo->typeNameJa }}</div>
              <div class="sub_page_notice_items_title">
                <a href="/notice/topic/{{ $topicInfo->fingerprint }}#rightContent">{{ $topicInfo->title }}</a>
              </div>
            </div>
            @endforeach
            @if (!($subtype == 'newest'))
                @if ($pageNumber > 0)
                    @if ($nextButtonFlag)
                        <div class="sub_page_transferPage_button">
                          <a href="/notice/{{ $subtype }}/page/{{ ($pageNumber-1) }}#rightContent">
                            <span>◀</span>
                          </a>
                            <span> [{{ $pageNumber+1 }}] </span>
                          <a href="/notice/{{ $subtype }}/page/{{ ($pageNumber+1) }}#rightContent">
                            <span>▶</span>
                          </a>
                        </div>
                    @else
                        <div class="sub_page_transferPage_button">
                          <a href="/notice/{{ $subtype }}/page/{{ ($pageNumber-1) }}#rightContent">
                            <span>◀</span>
                          </a>
                          <span> [{{ $pageNumber+1 }}] 　</span>
                        </div>
                    @endif
                @else
                    @if ($nextButtonFlag)
                        <div class="sub_page_transferPage_button">
                          <span>　 [{{ $pageNumber+1 }}] </span>
                          <a href="/notice/{{ $subtype }}/page/{{ ($pageNumber+1) }}#rightContent">
                            <span>▶</span>
                          </a>
                        </div>
                    @endif
                @endif
            @endif
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