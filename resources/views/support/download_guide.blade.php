<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  @include('vendor.metaCommon')
  @include('vendor.titleCommon')
  <script src="//ap-statics.loas.jp/mm2/official/js/jquery.min.js"></script>
{{--  @include('vendor.cssjs')--}}

  <style type="text/css">
    .content {
      width: 1000px;
      height: auto;
      margin: 0px auto;
      position: center;
      padding: 10px;
      color:white;
    }
    .text {
      text-align: left;
    }

    .yellow {
       color:yellow;
     }
    .red {
      color:yellow;
    }
    h2 {
      text-align: center;
    }
    h4 {
      background-color: #8eb4cb;
      height: 30px;
      line-height: 30px;
      padding-left: 5px;
    }

    .content img {
      position: center;
      text-align:center;
      margin: 0px auto;
      margin-left: 20px
    }

    .content a {
      color:white;
    }

    .footer {
      background-color: black;
      color: white;
      width: 1000px;
      height: 50px;
      line-height: 50px;
      text-align: center;
      float: left;
      margin-top: 30px;
    }

    .download-button {
      background-image: url(//ap-statics.loas.jp/mm2/official/images/sub_menu_common_bg_off.png);
      background-repeat: no-repeat;
      background-position: center;
      width: 239px;
      height: 54px;
      color: #fff;
      text-align: center;
      line-height: 54px;
      font-size: 15px;
      margin: 0px auto 0 auto;
      cursor: pointer;
      display: block;
      padding-top: 10px;
      padding-bottom: 10px;
    }
    .download-button:hover {
      padding-top: 9px;
      padding-bottom: 11px;
    }

  </style>
</head>
<body style="background-color:black;">
<div class="content">
  <div style="height: 120px;width: 100%;padding-top: 20px;text-align: center">
    <div class="download-button">クライアントダウンロード</div>
  </div>
  <hr>
  <h2>「League of AngelsⅡ」クライアントのダウンロード及びプレイガイドのご案内</h2>
  <ul class="text">
    <li> クライアントダウンロードと「League of AngelsⅡ」のランチャーの起動方法について</li>
    <li> ロイヤルダイヤ購入について</li>
    <li> Flash Playerについて</li>
  </ul>
  <h4>ゲームクライアントのダウンロード方法</h4>
1.クライアントダウンロードのボタンより「 League of AngelsⅡ.exe 」をダウンロードしてくださ い 。<br>
2.ダウンロードした「League of AngelsⅡ.exe」を実行し、インストールの手順の通りに「League of AngelsⅡ」のインストールを開始してください。 <br>
3.「League of AngelsⅡ」のインストールが完了すると、インストール保存したのフォルダに「League of AngelsⅡ」のランチャーが作成されるのと同時に、デスクトップに「League of AngelsⅡ」のアイコンが自動的に表示します。<br>
  以上の操作を行うことで、ダウンロードが完了します。<br><br>
<img src="{{ config('app.httpsBaseUrl') }}/images/download_guide/icon.png"alt=""><br>
<span class="red">
  ・この「League of AngelsⅡ」のアイコンをクリックすると、「ブラウザから起動してください」というメッセージが表示します。直接「League of AngelsⅡ」のランチャーを起動することはできません。<br>
  ・ブラウザからランチャーを起動する必要がありますので、このアイコンだけを削除しても影響はありません。<br>
</span>
<br>
4.ブラウザを起動後、League of AngelsⅡのWEBサイトにアクセスして、ゲームスタートをクリックすると、サーバー選択のページが表示します。任意サーバーを選択すると、ランチャーが起動して、ゲームをプレイすることができるようになります。<br><br>
<img src="{{ config('app.httpsBaseUrl') }}/images/download_guide/pic1.png" ><br>
  <br>
<img src="{{ config('app.httpsBaseUrl') }}/images/download_guide/pic2.png" ><br>
  <br>
・サーバーを選択後、下記ようなメッセージ画面が表示された場合は、「League of AngelsⅡ」インストールが正常に行われていない可能性がございます。この場合は、コントロール パネル→プログラム→プログラムと機能、この順番で
  プログラムと機能のところに「League of AngelsⅡ」クライアントがあるかとかを確認してください。再度インストールを実行ください。<br>
  <br>
<img src="{{ config('app.httpsBaseUrl') }}/images/download_guide/pic3.png" alt=""><br>
<br>
  <hr/>
<h4>ロイヤルダイヤ購入について</h4>
  ロイヤルダイヤの購入は公式ホームページ【ロイヤルダイヤ購入】ページにてご利用可能でございます。<br>
  <br>
<img src="{{ config('app.httpsBaseUrl') }}/images/download_guide/pic4.png" alt=""><br>
<br>
●購入手順<br>
  ロイヤルダイヤ購入のボタンを押すとブラウザから下記の画像ようなロイヤルダイヤ購入の画面を入ります。<br>
  ロイヤルダイヤ購入する前にキャラクターを選択する必要があります。  <br>
  キャラクターを選択して、指定した金額のロイヤルダイヤボタンを押すると、指定のキャラクターへロイヤルダイヤを購入できます。<br>
  <br>
<img src="{{ config('app.httpsBaseUrl') }}/images/download_guide/pic5.png" alt=""><br>
  <span class="yellow">
  ・キャラクター選択のところで選択したキャラクターおよびサーバーを表示するので、金貨を購入する前に必ず確認してください。<br>
  ・キャラクターを間違えた場合は、前の画面に戻して、再度キャラクターを選択してください。<br>
    </span>
  <br>
  ●ゲーム内よりロイヤルダイヤ購入について<br>
  クライアント版ではゲーム内のロイヤルダイヤ購入ができません、チャージボタンを押すと「ホームページにてチャージしてください」のメッセージが表示されます。<br>
  Flash版について、引き続きゲーム内のロイヤルダイヤ購入のご利用が可能でございます。<br>
<br>
  <hr/>

  <br>
  <h4>Flash Playerについて</h4>
<br>
  Flashをご利用したいのお客様は、「Flash版」のボタンをクリックすると、直接にブラウザからFlash版ゲームサーバーの選択画面よりゲーム内を入るごとができます。<br>
<br>
<img src="{{ config('app.httpsBaseUrl') }}/images/download_guide/pic6.png" alt="" style="width: 90%"><br>
<br>
  <hr/>
  <br>
  「League of AngelsⅡ」をご利用いただく上で、下記の環境を推奨しています。<br>
  【Windows】Windows 8、8.1、10<br>
  【ブラウザ】Microsoft Edge 最新版、<br>
  　　　　　　Mozilla Firefox 最新版、<br>
  　　　　　　Google Chrome 最新版<br>
  【Flash】Adobe Flash Player最新版<br>
  <br>
  まだゲーム画面が表示されない場合は、<br>
  下記URLより【Windows】【ブラウザ】【Flash】 の状況を確認いただけますようお願い申し上げます。<br>
  ■【Windows】の状況確認<br>
  　<a href="https://support.microsoft.com/ja-jp/help/13443/windows-which-version-am-i-running" target="_blank">https://support.microsoft.com/ja-jp/help/13443/windows-which-version-am-i-running</a><br>
  ■【ブラウザ】の状況確認<br>
  　Microsoft Edge最新バージョン<br>
  　<a href="https://www.microsoft.com/ja-jp/edge" target="_blank">https://www.microsoft.com/ja-jp/edge</a><br>
  　Mozilla Firefox最新バージョン<br>
  　<a href="https://www.mozilla.org/ja/firefox/new/?utm_campaign=footer&utm_medium=referral&utm_source=support.mozilla.org" target="_blank">https://www.mozilla.org/ja/firefox/new/?utm_campaign=footer&utm_medium=referral&utm_source=support.mozilla.org</a><br>
  　Google Chrome 最新バージョン<br>
  　<a href="https://www.google.com/intl/ja_jp/chrome/" target="_blank">https://www.google.com/intl/ja_jp/chrome/</a><br>
  ■【Flash】 の状況確認<br>
  　<a href="https://helpx.adobe.com/jp/flash-player/kb/235703.html" target="_blank">https://helpx.adobe.com/jp/flash-player/kb/235703.html</a><br>
  　<br>
  <span class="red">
    ・推奨環境は、OSとブラウザ両方の環境条件を含んでいます。<br>
    ・推奨環境外での課金コンテンツの購入はお控えください。<br>
    ・推奨環境外はサポート対象外となります。あらかじめご了承ください。<br>
        </span>
  <br>
  <hr/>
<br>
  2020年12月末Flashサービス終了に伴い、アクセス集中が予想されます。<br>
  事前にゲームクライアントのダウンロードを行っていただくことをお勧めいたします。<br>
  <br>
  なお、インストールが正しく行えない場合など、お困りの場合は、<br>
  詳細状況やスクリーンショットを添付した上で、お問い合わせ窓口までご連絡ください。<br>
<br>
『League of AngelsⅡ 運営チーム』
  @include('vendor.footer')
</div>
<div style="clear:both;"></div>
</body>
<script>
  $(function () {
    $("div.download-button").click(function () {
      if (navigator.userAgent.indexOf('Mac OS X') !== -1) {
        window.open("{{ config('gameInfo.clientDownloadUrlMac') }}", '_blank');
      } else {
        window.open("{{ config('gameInfo.clientDownloadUrl') }}", '_blank');
      }
      return false;
    });
  });

</script>
</html>