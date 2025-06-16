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
    @include('support.leftMenu', ['page' => 'tokusyo'])
    <div class="contents_right">
      <div class="sub_page_right" id="rightContent" name="rightContent">
        <div class="sub_page_right_top">
          <span class="sub_page_nav"><a href="/">HOME</a></span> ＞ <span class="sub_page_nav"><a href="/support#rightContent">サポート</a></span> ＞ <span class="sub_page_nav_current">特定商取引について</span>
        </div>
        <div class="sub_page_right_contents">
          <div class="sub_page_support_2_title"></div>
          <div class="sub_page_support_2_word">「特定商取引に関する法律」通信販売（通信販売についての広告）第十一条に基づき、以下に明示致します。</div>
          <div class="sub_page_support_2_contents">
            <div class="support2_table_line">
              <div class="support2_table_line_left">運営会社</div>
              <div class="support2_table_line_right">ビットクイーン株式会社</div>
              <div style="clear: both;"></div>
            </div>
            <div class="support2_table_line">
              <div class="support2_table_line_left">運営統括責任者</div>
              <div class="support2_table_line_right">馮 達</div>
              <div style="clear: both;"></div>
            </div>
            <div class="support2_table_line">
              <div class="support2_table_line_left">住所</div>
              <div class="support2_table_line_right">東京都港区赤坂四丁目15番1号 赤坂ガーデンシティ4階</div>
              <div style="clear: both;"></div>
            </div>
            <div class="support2_table_line">
              <div class="support2_table_line_left">お問い合わせ先</div>
              <div class="support2_table_line_right">
                メールでのお問い合わせ：support@loas.jp<br />
                電話番号：0335828230<br />
                お問い合せは原則メールにて行っております。何卒ご協力お願いいたします。<br />
                お問い合わせは、24時間受けしておりますがご返答は月曜日～金曜日 （祝日、祭日、年末年始をのぞく）AM10:00からPM6:00となっております。 </div>
              <div style="clear: both;"></div>
            </div>
            <div class="support2_table_line">
              <div class="support2_table_line_left">販売価格</div>
              <div class="support2_table_line_right">購入手続きの際に画面に表示されます。</div>
              <div style="clear: both;"></div>
            </div>
            <div class="support2_table_line">
              <div class="support2_table_line_left">販売価格以外の費用</div>
              <div class="support2_table_line_right">電気通信回線の通信料金等(インターネット接続料金を含む) </div>
              <div style="clear: both;"></div>
            </div>
            <div class="support2_table_line">
              <div class="support2_table_line_left">代金のお支払い方法</div>
              <div class="support2_table_line_right">お支払方法は、以下のいずれかよりお選びいただけます<br />　LAコインの購入<br />　　・クレジットカードによる支払方法<br />　　・電子マネーによる支払方法<br />　各種ゲーム内アイテム等<br />　　・LAコインによる支払方法<br /></div>
              <div style="clear: both;"></div>
            </div>
            <div class="support2_table_line">
              <div class="support2_table_line_left">代金のお支払時期</div>
              <div class="support2_table_line_right">コンテンツ提供の前</div>
              <div style="clear: both;"></div>
            </div>
            <div class="support2_table_line">
              <div class="support2_table_line_left">提供時期</div>
              <div class="support2_table_line_right">コンテンツは、お支払手続完了後、直ちに提供いたします。</div>
              <div style="clear: both;"></div>
            </div>
            <div class="support2_table_line">
              <div class="support2_table_line_left">返品について</div>
              <div class="support2_table_line_right">コンテンツの返品及び交換はできないものとします。</div>
              <div style="clear: both;"></div>
            </div>
            <div class="support2_table_line last">
              <div class="support2_table_line_left">動作環境</div>
              <div class="support2_table_line_right">ゲームをご利用いただくために必要な動作環境は、<br />ゲーム紹介の「プレイ環境」よりご確認ください。</div>
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