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
    @include('support.leftMenu', ['page' => 'kessai'])
    <div class="contents_right">
      <div class="sub_page_right" id="rightContent" name="rightContent">
        <div class="sub_page_right_top">
          <span class="sub_page_nav"><a href="/">HOME</a></span> ＞ <span class="sub_page_nav"><a href="/support#rightContent">サポート</a></span> ＞ <span class="sub_page_nav_current">資金決済法に基づく表記</span>
        </div>
        <div class="sub_page_right_contents">
          <div class="sub_page_support_x_title"></div>
          <div class="sub_page_support_2_contents">
            <div class="support2_table_line">
              <div class="support2_table_line_left">前払式支払手段の名称</div>
              <div class="support2_table_line_right">LAコイン</div>
              <div style="clear: both;"></div>
            </div>
            <div class="support2_table_line">
              <div class="support2_table_line_left">支払可能金額等</div>
              <div class="support2_table_line_right">会員による1ヶ月の購入限度額は、次のとおりです。<br /> ・16歳未満の会員：5,000円まで<br /> ・16歳以上20歳未満の会員：20,000円まで<br /> ・20歳以上の会員：上限なし<br />なお、所持できるLAコインの上限限度額はありません。</div>
              <div style="clear: both;"></div>
            </div>
            <div class="support2_table_line">
              <div class="support2_table_line_left">有効期限</div>
              <div class="support2_table_line_right">購入した日から6ヶ月までとします。</div>
              <div style="clear: both;"></div>
            </div>
            <div class="support2_table_line">
              <div class="support2_table_line_left">残高の確認	</div>
              <div class="support2_table_line_right">マイページよりご確認いただけます。（ログインが必要です）</div>
              <div style="clear: both;"></div>
            </div>
            <div class="support2_table_line">
              <div class="support2_table_line_left">お問い合わせ先</div>
              <div class="support2_table_line_right">所在地:〒107-0052東京都港区赤坂四丁目15番1号 赤坂ガーデンシティ16階<br /><br />連絡先:<a href="/support/service.html#rightContent" style="color: blue !important;text-decoration: underline !important;">お問い合わせフォーム</a>が窓口となります。</div>
              <div style="clear: both;"></div>
            </div>
            <div class="support2_table_line">
              <div class="support2_table_line_left">運営統括責任者</div>
              <div class="support2_table_line_right">沈 海寅</div>
              <div style="clear: both;"></div>
            </div>
            <div class="support2_table_line last">
              <div class="support2_table_line_left">注意事項</div>
              <div class="support2_table_line_right">購入したLAコインの払い戻しは原則としてできません。<br /><a href="/support/terms.html#rightContent" style="color: blue !important;text-decoration: underline !important;">利用規約</a>を十分にご確認の上、購入、及びご使用をお願いいたします。</div>
              <div style="clear: both;"></div>
            </div>
            <div style="clear: both;"></div>
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