<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <meta name="url1" content="https://www.loas.jp/?utm_source=itac_GDN_standard&utm_medium=cpc&utm_campaign=new_sever&utm_content=Astrid&from=itac_GDN_standard">
  <meta name="url2" content="https://www.loas.jp/?utm_source=itac_GDN&utm_medium=cpc&utm_campaign=new_sever&utm_content=Astrid&from=itac_GDN">

  @include('vendor.metaCommon')
  @include('vendor.titleCommon')
  @include('vendor.cssjs')

  @include('adTag.googleAnalytics')
  @include('adTag.indexHeaderTag')

</head>
<body>

<div class="wrapper">
  @include('vendor.topMenu')

  <div class="contents">
    <div class="contents_upper">
      <div class="contents_left">
        @include('vendor.gamestart')
      </div>
      <div class="contents_right">
        @include('vendor.rightSlider')
      </div>
{{--      @include('vendor.floatBtn')--}}
    </div>
    <div class="contents_middle">
      <div class="character">
        <div class="character_items_list">
          <div class="character_item character_item_1"><div class="character_feature_label"></div></div>
          <div class="character_item character_item_2"><div class="character_feature_label"></div></div>
          <div class="character_item character_item_3"></div>
          <div class="character_item character_item_4"></div>
          <div class="character_item character_item_5"></div>
          <div class="character_item character_item_6"></div>
          <div class="character_item character_item_7"></div>
        </div>
        <div class="more more_character"></div>
      </div>
    </div>
    <div class="contents_lower">
      <div class="contents_left">
      @include('vendor.leftContents')
      </div>
      <div class="contents_right">
        <div class="contents_right_left">
          <div class="notice">
              <div class="notice_tabs_list">
              <div class="notice_tabs_items on" name="newest">最新情報</div>
              <div class="notice_tabs_items" name="notice">お知らせ</div>
              <div class="notice_tabs_items" name="event">イベント</div>
              <div class="notice_tabs_items" name="maintenance">メンテナンス</div>
              <div class="notice_tabs_items" name="update">アップデート</div>
            </div>
            <div id="topicContList_newest" name="topicContList_newest">
              @foreach ($topics['newest'] as $newest)
              <div class="notice_item">
                <div class="notice_item_type item_type_{{ $newest->typeNameSimp }}">{{ $newest->typeNameJa }}</div>
                <div class="notice_items_title"><a href="/notice/topic/{{ $newest->fingerprint }}#rightContent">{{ $newest->title }}</a></div>
              </div>
              @endforeach
            </div>
            <div id="topicContList_notice" name="topicContList_notice" style="display: none;">
              @foreach ($topics['notice'] as $notice)
              <div class="notice_item">
                <div class="notice_item_type item_type_notice">お知らせ</div>
                <div class="notice_items_title"><a href="/notice/topic/{{ $notice->fingerprint }}#rightContent">{{ $notice->title }}</a></div>
              </div>
              @endforeach
            </div>
            <div id="topicContList_event" name="topicContList_event" style="display: none;">
              @foreach ($topics['event'] as $event)
              <div class="notice_item">
                <div class="notice_item_type item_type_event">イベント</div>
                <div class="notice_items_title"><a href="/notice/topic/{{ $event->fingerprint }}#rightContent">{{ $event->title }}</a></div>
              </div>
              @endforeach
            </div>
            <div id="topicContList_maintenance" name="topicContList_maintenance" style="display: none;">
              @foreach ($topics['maintenance'] as $maintenance)
              <div class="notice_item">
                <div class="notice_item_type item_type_maintenance">メンテナンス</div>
                <div class="notice_items_title"><a href="/notice/topic/{{ $maintenance->fingerprint }}#rightContent">{{ $maintenance->title }}</a></div>
              </div>
              @endforeach
            </div>
            <div id="topicContList_update" name="topicContList_update" style="display: none;">
              @foreach ($topics['update'] as $update)
              <div class="notice_item">
                <div class="notice_item_type item_type_update">アップデート</div>
                <div class="notice_items_title"><a href="/notice/topic/{{ $update->fingerprint }}#rightContent">{{ $update->title }}</a></div>
              </div>
              @endforeach
            </div>
            <div class="more more_notice"></div>
          </div>
          <div class="videos">
            <div class="video_item item1"></div>
            <div class="video_item item2"></div>
            <div class="video_item item3"></div>
            <div class="more more_video"></div>
          </div>
        </div>
        <div class="contents_right_right">
          <div class="campaign_link_2">
            <a href="/campaign_cosplay2018" target="_blank">
              <img src="//ap-statics.loas.jp/mm2/official/images/campaign_1810/cosplay2018_banner.jpg">
            </a>
          </div>
          {{--<div class="campaign_link"></div>--}}
          {{-- <div class="function_game"></div> --}}
          {{-- <div class="world"></div> --}}
          <div class="sns_area">
            <a href="https://www.facebook.com/loa2.japan/" target="_blank"><img src="//ap-statics.loas.jp/mm2/official/images/btn_facebook.png" /></a>
            <a href="https://twitter.com/LOA_JP" target="_blank"><img src="//ap-statics.loas.jp/mm2/official/images/btn_twitter.png" /></a>
            <a href="https://www.youtube.com/channel/UCt29fgXBxiypiT3bpyMaoOg" target="_blank"><img src="//ap-statics.loas.jp/mm2/official/images/btn_youtube.png" /></a>
          </div>
{{--          <div class="character_vote"></div>--}}
          <div class="netcafe"></div>
{{--          <div class="qa"></div>--}}
          <div class="faq"></div>
          {{-- <div class="karma_link"></div> --}}
        </div>
      </div>
    </div>
    @include('vendor.footer')
    <div style="clear:both;"></div>
  </div>
</div>

@if(Session::get('loggedIn') === true){
@if ($isMaintenance )
  @include('game.serverSelectMaintHtml')
@else
  @include('game.serverSelectHtml')
@endif
}@endif
@include('support.gamePrivacyDialogHtml')
@include('vendor.autoPopup')

<script type="text/javascript" src="//easygame.jp/loa2/officialsite/movies.js?{{ md5(time()) }}"></script>
<script type="text/javascript">
  initIndexPage();
</script>
@include('adTag.index')

{{--<div id="floatBanner" style="width: 240px;height: 243px;position: fixed;top: 50%;left: 5px;background-image: url('//ap-statics.loas.jp/mm2/official/images/float_180712_off.png');cursor: pointer;" onmouseover="this.style.backgroundImage='url(//ap-statics.loas.jp/mm2/official/images/float_180712_on.png)';" onmouseout="this.style.backgroundImage='url(//ap-statics.loas.jp/mm2/official/images/float_180712_off.png)';"><span style="cursor: pointer;background-image: url('//ap-statics.loas.jp/mm2/official/images/close.png');width: 28px;height: 28px;display: block;" onclick="javascript:$('#floatBanner').hide();return false;"></span><div style="width: 240px;height: 220px;" onclick="javascript:window.open('https://play.fan.tsite.jp/', '_blank');"></div></div>--}}

{{--<div id="floatBanner" style="width: 200px;height: 260px;position: fixed;top: 50%;right: 5px;background-image: url('//ap-statics.loas.jp/mm2/official/images/float_170801.jpg');cursor: pointer;"><span style="cursor: pointer;background-image: url('//ap-statics.loas.jp/mm2/official/images/close.png');width: 28px;height: 28px;display: block;" onclick="javascript:$('#floatBanner').hide();return false;"></span><div style="width: 180px;height: 220px;" onclick="javascript:window.location.href = '/notice/topic/e44742cfe981dc91237bcffa04db1423#rightContent';"></div></div>--}}
</body>
</html>