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
      <div class="sub_page_right" id="moviesContents" name="moviesContents">
        <div class="sub_page_right_top">
          <span class="sub_page_nav"><a href="/">HOME</a></span> ＞ <span class="sub_page_nav"><a href="/gallery#moviesContents">ギャラリー</a></span> ＞ <span class="sub_page_nav_current">ムービー</span>
        </div>
        <div class="sub_page_right_contents sub_page_movie_right_contents">
          <div class="sub_page_gallery_title"></div>
          <div class="sub_page_moviePageNav_upperBtns">
            <div class="sub_page_pre_page_btn sub_page_moviePageNav">＜前のページへ</div>
            <div class="sub_page_moviePageNum">1</div>
            <div class="sub_page_next_page_btn sub_page_moviePageNav">次のページへ＞</div>
          </div>
          <div class="sub_page_movie_contents">
            <div class="sub_page_movie_item item1"></div>
            <div class="sub_page_movie_item item2"></div>
            <div class="sub_page_movie_item item3"></div>
            <div class="sub_page_movie_item item4"></div>
            <div class="sub_page_movie_item item5"></div>
            <div class="sub_page_movie_item item6"></div>
          </div>
          <div class="sub_page_moviePageNav_lowerBtns">
            <div class="sub_page_pre_page_btn sub_page_moviePageNav">＜前のページへ</div>
            <div class="sub_page_moviePageNum">1</div>
            <div class="sub_page_next_page_btn sub_page_moviePageNav">次のページへ＞</div>
          </div>
        </div>
        <div class="sub_page_right_bottom"></div>
      </div>
    </div>
    @include('vendor.footer')
    <div style="clear:both;"></div>
  </div>
</div>

<script type="text/javascript" src="//easygame.jp/loa2/officialsite/movies.js?{{ md5(time()) }}"></script>
<script type="text/javascript">
  initMoviePage();
</script>

@include('adTag.googleAnalytics')
@include('adTag.gallery_movies')

</body>
</html>