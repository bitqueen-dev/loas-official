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
      <div class="sub_page_right" id="introContents" name="introContents">
        <div class="sub_page_right_top">
          <span class="sub_page_nav"><a href="{{ config('app.httpsBaseUrl') }}/">HOME</a></span> ＞ <span class="sub_page_nav"><a href="/purchase/intro#introContents">LAコイン購入</a></span> ＞ <span class="sub_page_nav_current">LAコインとは</span>
        </div>
        <div class="sub_page_right_contents">
          <div class="sub_page_coin_title"></div>
          <div class="coin_page_tabs">
            <div class="coin_tab_item coin_tab_item1 on">LAコインとは</div>
            <div class="coin_tab_item coin_tab_item2">LAコイン購入</div>
            <div class="coin_tab_item coin_tab_item3">LAコイン履歴</div>
          </div>
          <div class="coin_subpage1_line1">
            <div class="coin_subpage1_line1_words1">LAコインは「League of Angels Ⅱ」のゲーム内通貨「ダイヤ」のチャージに必要な電子ポイントです。</div>
            <div class="coin_subpage1_line1_words2">ロイヤルダイヤはゲーム内で取り扱っている便利なアイテムやアバターアイテムなどの購入に利用することができます。</div>
            <div class="coin_subpage1_line1_words3">ACポイントはLAコインを購入する際に、購入金額に応じてACポイントがたまり、ためたポイントをポイントモールで便利なアイテムの</div>
          </div>
          <div class="coin_subpage1_buy_button"></div>
          <div class="coin_subpage1_line2"></div>
          <div class="coin_subpage1_line3">
            <div class="coin_subpage1_step">
              <span class="step_title">Step１　LAコイン購入手続き</span>
              <span class="step_words">ログインのうえ、「コイン購入」ページよりLAコイン購入の手続きにお進みください。<br />購入には「利用規約」への同意が必要となります。</span>
            </div>
            <div class="coin_subpage1_step">
              <span class="step_title">Step２　お支払い方法選択</span>
              <span class="step_words">購入金額やお支払い方法をお選びいただき、各支払い方法の手続きに沿って購入手続きを完了ください。</span>
            </div>
            <div class="coin_subpage1_step">
              <span class="step_title">Step３　LAコイン購入確認メール</span>
              <span class="step_words">LAコインの購入手続き完了後、登録されておりますお客様のメールアドレスへ、LAコイン購入確認のメールを送信させていただきます。<br />こちらのメールにて購入内容を記載させていただいておりますので、内容をご確認のうえ保管していただきますようお願いいたします。</span>
            </div>
            <div class="coin_subpage1_step last">
              <span class="step_title">Step４　LAコイン購入手続き完了</span>
              <span class="step_words">購入手続きが完了しましたら、LAコインが購入されていることをご確認ください。<br />「LAコイン履歴」よりご確認いただけます。</span>
            </div>
          </div>
          <div class="coin_subpage1_line4">
            <div class="coin_subpage1_step">
              <span class="step_title">Step１　ゲームキャラクターログイン</span>
              <span class="step_words">「GAMESTART」より、ダイヤチャージを希望するゲームキャラクターを作成したサーバーにログインしてください。</span>
            </div>
            <div class="coin_subpage1_step">
              <span class="step_title">Step２　チャージボタン</span>
              <span class="step_words">ゲームキャラクターがログインしたうえ、ゲーム画面の「チャージ」ボタンより、ダイヤチャージ画面に進んで、希望するダイヤの額をお選びください。<br />※ ダイヤは、購入時に選択したサーバーでのみご利用になれます。サーバー間の移動はできませんのでご注意ください。</span>
            </div>
            <div class="coin_subpage1_step last">
              <span class="step_title">Step３　チャージ確認</span>
              <span class="step_words">「LAコイン履歴」より、LAコインからダイヤに正しくチャージされておりますことをご確認いただけます。</span>
            </div>
          </div>
          <div class="coin_subpage1_line5">
            <div class="coin_subpage1_step">
              <span class="step_title">Step１</span>
              <span class="step_words">「ポイントモール」より、希望するアイテム商品をお選びください。</span>
            </div>
            <div class="coin_subpage1_step">
              <span class="step_title">Step２</span>
              <span class="step_words">商品購入後、ゲーム内アイテム商品を受け取るためのシリアルコードが発行されます。<br />「ACポイント履歴」より、シリアルコードや有効期限をご確認いただけます。</span>
            </div>
            <div class="coin_subpage1_step">
              <span class="step_title">Step３</span>
              <span class="step_words">「GAMESTART」より、アイテム受取を希望するゲームキャラクターを作成したサーバーにログインしてください。</span>
            </div>
            <div class="coin_subpage1_step last">
              <span class="step_title">Step４</span>
              <span class="step_words">ゲーム画面右上にあるミニマップ下の「シリアルコード」アイコンをクリックして、シリアルコード入力画面に進んで、シリアルコードを入力してください。シリアルコードを入力後、アイテムを受け取れます。</span>
            </div>
          </div>
          <div class="coin_subpage1_note">
            ※LAコインの有効期限は購入日から180日間となります。<br />
            ※ご購入いただいたLAコインは払い戻しすることはできかねます。<br />
            ※LAコインの購入履歴は、サイト内のLAコイン履歴ページよりご確認いただけます。<br />
            ※LAコインの毎月のご購入上限ポイントは下記となります。但し、当社が別途定める一部外部IDを使用して会員IDを取得した<br />
            場合はこの限りではありません。<br />
            ・13歳未満：5,000円まで<br />
            ・13歳以上20歳未満：20,000円まで<br />
            ・20歳以上：制限なし<br />
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
@include('adTag.purchase_intro')

</body>
</html>