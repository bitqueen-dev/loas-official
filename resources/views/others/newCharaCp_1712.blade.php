<!DOCTYPE html>
<html lang="jp">
<head>
  <meta charset="UTF-8">
  <meta name="keywords" content="リーグオブエンジェル,League of Angel,leagueofangel,LOA,loa,game,ブラウザゲーム,ゲーム,RPG,MMO,声優,田村ゆかり,朴璐美">
  <meta name="description" content="ダークファンタジーRPG『League of AngelsⅡ(リーグオブエンジェル)』。新GRキャラクター「ルル」(声優:桃河りか)、「イーシャ」(声優:島田紗希)が遂に実装!!お得なキャンペーン開催中!">
  <title>『League of Angels Ⅱ』ルル&イーシャ実装キャンペーン</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="//ap-statics.loas.jp/mm2/official/css/newCharaCp_1712.css?171215">
  <script type="text/javascript" async src="https://platform.twitter.com/widgets.js"></script>
  <script src="//ap-statics.loas.jp/mm2/official/js/minigame/phaser.min.js"></script>
  <script src="//ap-statics.loas.jp/mm2/official/js/jquery.min.js"></script>
  <script src="//ap-statics.loas.jp/mm2/official/js/layer.js"></script>
  <script src="//ap-statics.loas.jp/mm2/official/js/howler.core.js"></script>

  {{-- <script src="/js/minigame/sugoroku/sugoroku.js"></script> --}}
  <script src="//ap-statics.loas.jp/mm2/official/js/minigame/sugoroku/sugoroku.min.js?171215_2"></script>
</head>
<body>

<div class="top">
  <div class="top_contents">
    <a href="https://www.loas.jp" target="_blank" class="logo"></a>
    <div class="luluPopupBtn hoverAnim" onclick="charaPopup('lulu');"></div>
    <div class="ishaPopupBtn hoverAnim" onclick="charaPopup('isha')"></div>
  </div>
</div>

<div class="joinCp">
  @if (!$login)
  <a href="https://www.loas.jp" target="_blank">
    <div class="joinCpBtn hoverAnim"></div>
  </a>
  @else
  <div class="selectArea">
    <select class="serverSelect" name="serverSelect"></select>
  </div>
  @endif
  <div class="joinCp_word">
    本キャンペーンでの獲得アイテムが選択アカウントに付与されます。
    @if (!$login)
    </br>ゲームログイン後、アカウントを選択してくさい。
    @endif
  </div>
</div>

<div class="intro_area">
  <a href="#cp_area_1" class="intro_cp_1 intro_btn hoverAnim"></a>
  <a href="#cp_area_2" class="intro_cp_2 intro_btn hoverAnim"></a>
  <a href="#cp_area_3" class="intro_cp_3 intro_btn hoverAnim"></a>
</div>

<div id="cp_area_1" class="cp_area_1">
  <div class="cp_1_headline headline"></div>
  <div class="cp_1_content_1">
    <a href="//www.loas.jp/notice/topic/8b9bb93da78729d8356f9380f024cef9#rightContent" target="_blank">
      <div class="cp_1_howToBtn"></div>
    </a>
  </div>
  <div class="cp_1_text_1">※アイテム「ルルの欠片」及びキャラクター「ルル」は、12月21日以降より交換させて頂きます。</div>
  <a href="https://www.loas.jp" target="_blank">
    <div class="cp_1_startBtn hoverAnim"></div>
  </a>
  <a href="#" class="toTopBtn hoverAnim"></a>
</div>

<div id="cp_area_2" class="cp_area_2">
  <div class="cp_2_headline headline"></div>
  <div class="cp_2_content_1">
    <div class="cp_2_word_1"></div>
    <div class="reward10 reward"></div>
    <div class="reward20 reward"></div>
    <div class="reward30 reward"></div>
    <div class="reward40 reward"></div>
    <div class="reward50 reward"></div>
  </div>
  <div class="cp_2_content_2">
    <div class="cp_2_word_2"></div>
    <div class="cp_2_condition">
      <table border='1' bordercolor='#a6c82e'>
        <tr bgcolor='#e5ecd5'>
          <th>条件</th>
          <th>獲得回数</th>
          <th> </th>
        </tr>
        <tr>
          <td>Twitterでシェアする</td>
          <td>1回/日</td>
          <td>
            <a href="//twitter.com/share?text=%E6%96%B0GR%E8%8B%B1%E9%9B%84%E3%80%8E%E3%83%AB%E3%83%AB%E3%80%8F%26%E3%80%8E%E3%82%A4%E3%83%BC%E3%82%B7%E3%83%A3%E3%80%8F%E5%AE%9F%E8%A3%85%E3%82%AD%E3%83%A3%E3%83%B3%E3%83%9A%E3%83%BC%E3%83%B3%E5%AE%9F%E6%96%BD%E4%B8%AD%21%21%20&hashtags=LOA_JP,イベント&url=https://www.loas.jp/campaign_newCharacter_1712" id="tweetBtn">
              <div class="cp_2_tweet_btn cp_2_btn hoverAnim"></div>
            </a>
          </td>
        </tr>
        <tr>
          <td>「High&Low」を</br>10回プレイする</td>
          <td>10回プレイ毎</td>
          <td>
            <a href="https://www.loas.jp/minigame_highAndLow" target="_blank" >
              <div class="cp_2_highAndLow_btn cp_2_btn hoverAnim"></div>
            </a>
          </td>
        </tr>
        <tr>
          <td>LAコイン</br>3,000チャージ</td>
          <td>3,000チャージ毎</td>
          <td>
            <a href="https://www.loas.jp/purchase/process#processContents" target="_blank" >
              <div class="cp_2_buyCoin_btn cp_2_btn hoverAnim"></div>
            </a>
          </td>
        </tr>
        <tr>
          <td colspan="3"><font color='#00c0ff' size='5'>毎日0時と12時に1回</br>このキャンペーンページへ訪れることで</br>すごろく回数を獲得できます！</font></td>
        </tr>
      </table>
    </div>
  </div>
  <div class="cp_2_content_3">
    <div id="game"></div>
    <div class="selectArea">
      <select class="serverSelect" name="serverSelect"></select>
    </div>
  </div>
  <a href="#" class="toTopBtn hoverAnim"></a>
</div>

<div id="cp_area_3" class="cp_area_3">
  <div class="cp_3_headline headline"></div>
  <div class="cp_3_content_1">
    <div class="cp_3_detailBtn hoverAnim" onclick="detailPopup();"></div>
  </div>
  <a href="https://twitter.com/intent/retweet?tweet_id=941493983145967616">
    <div class="cp_3_twitterBtn"></div>
  </a>
  <div class="cp_3_content_2">
    <div class="cp_3_youtube"></div>
  </div>
  <a href="#" class="toTopBtn hoverAnim"></a>
</div>

<div class="copyright">©BITQUEEN INC. All Rights Reserved.</div>

<a href="https://www.loas.jp" target="_blank" class="gameStartBtn hoverAnim"></a>

<script type="text/javascript">
  var game = new Phaser.Game(924, 660, Phaser.AUTO, 'game');

  @if ($login && $gameId)
  var gId = "{{ $gameId }}";
  @else
  var gId = null;
  @endif

  ////// This function is set by Play.create
  var tweetBtnFunc = function () {return false;};

  game.state.add('Boot', BasicGame.Boot);
  game.state.add('Preloader', BasicGame.Preloader);
  game.state.add('Play', BasicGame.Play);

  ////// Now start the Boot state.
  game.state.start('Boot');
</script>

<script type="text/javascript" src="//ap-statics.loas.jp/mm2/official/js/newCharaCp_1712.js"></script>

@include('adTag.googleAnalytics')

</body>
</html>