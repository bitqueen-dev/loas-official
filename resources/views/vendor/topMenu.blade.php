  <div class="logo"></div>
  <div class="top_menu" id="topMenu">
    <div class="menu_item menu_first">お知らせ</div>
    <div class="menu_item">ゲーム紹介</div>
    <div class="menu_item">プレイガイド</div>
    <div class="menu_item">ギャラリー</div>
    <div class="menu_item">サポート</div>
  </div>
  <div class="sub_menu" id="subMenu" style="display: none;">
    <div class="sub_menu_item menu_first">
      <a href="{{ config('app.httpsBaseUrl') }}/notice/newest#rightContent">最新情報</a>
      <a href="{{ config('app.httpsBaseUrl') }}/notice/notice#rightContent">お知らせ</a>
      <a href="{{ config('app.httpsBaseUrl') }}/notice/event#rightContent">イベント</a>
      <a href="{{ config('app.httpsBaseUrl') }}/notice/maintenance#rightContent">メンテナンス</a>
      <a href="{{ config('app.httpsBaseUrl') }}/notice/update#rightContent">アップデート</a>
    </div>
    <div class="sub_menu_item">
      <a href="{{ config('app.httpsBaseUrl') }}/intro#rightContent">ゲーム紹介</a>
      <a href="{{ config('app.httpsBaseUrl') }}/intro/outlook.html#rightContent">世界観</a>
      <a href="{{ config('app.httpsBaseUrl') }}/intro/character.html#rightContent" target="_blank">キャラクター紹介</a>
      <a href="{{ config('app.httpsBaseUrl') }}/casting.html" target="_blank">声優</a>
      <a href="{{ config('app.httpsBaseUrl') }}/intro/playenv.html#rightContent">プレイ環境</a>
    </div>
    <div class="sub_menu_item">
      <a href="{{ config('app.httpsBaseUrl') }}/playguild#beginner">ビギナーズガイド</a>
      <a href="{{ config('app.httpsBaseUrl') }}/playguild#howtoplay">基本操作</a>
      <a href="{{ config('app.httpsBaseUrl') }}/playguild#gamesystem">ゲームシステム</a>
      <a href="{{ config('app.httpsBaseUrl') }}/playguild#randomitem">ランダムアイテムの確率</a>
    </div>
    <div class="sub_menu_item">
      <a href="{{ config('app.httpsBaseUrl') }}/gallery/movies.html#moviesContents">ムービー</a>
      <!-- <a href="#">壁紙</a>  -->
    </div>
    <div class="sub_menu_item">
      <a href="{{ config('app.httpsBaseUrl') }}/support/terms.html#rightContent">利用規約</a>
      <a href="{{ config('app.httpsBaseUrl') }}/support/tokusyo.html#rightContent">特定商取引について</a>
      {{-- <a href="{{ config('app.httpsBaseUrl') }}/support/kessai.html#rightContent">資金決済法に基づく表記</a> --}}
      <a href="{{ config('app.httpsBaseUrl') }}/support/privacy.html#rightContent">プライバシーポリシー</a>
      <a href="{{ config('app.httpsBaseUrl') }}/support/service.html#rightContent">お問い合わせ</a>
      <a href="{{ config('app.httpsBaseUrl') }}/support/qa#rightContent">よくある質問</a>
    </div>
  </div>