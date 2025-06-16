      <div class="start_area">
        <div class="start_button"
             onclick="javascript:
             @if(Session::get('loggedIn') === true){
                 @if(Session::get('userInfo.isAgreedPrivacy') === 1) {
                     showServers();
                     // showPrivacy();
                 }
                 @else {
                    showPrivacy();
                 }
                 @endif;
             }
             @elseif (Session::get('loggedIn') === false)
                     showLogin()
             @endif;
                     gaClicks('Game Start Button','click','Official');">
        </div>
        @if(Session::get('loggedIn') === false)
        <div class="start_button_shadow"></div>
        @elseif (Session::get('loggedIn') === true)
        <div class="start_button_shadow" style="display: none;"></div>
        <div class="start_user_info">
          <div class="start_title">マイページ</div>
          <div class="user_function">
            <div class="user_function_bank">
              <div class="user_function_coin">
                <div class="coin_title">コイン</div>
                <div class="coin_number">：{{ Session::get('userInfo.coin') }}</div>
                <div class="coin_button"></div>
              </div>
              <div class="user_function_point">
                <div class="point_title">ポイント</div>
                <div class="point_number">：{{ Session::get('userInfo.point') }}</div>
                <div class="point_button"></div>
              </div>
            </div>
            <div class="user_function_logout">ログアウト</div>
          </div>
        </div>
        @endif
      </div>
      <script type="text/javascript">
          function showPrivacy() {
              // layer.open({
              //     type: 2,
              //     closeBtn: true,
              //     title: false,
              //     shadeClose: true,
              //     shade: 0.8,
              //     area: ['800px', '550px'],
              //     content: '/gamePrivacyDialog'
              // });
              layer.open({
                  type: 1,
                  closeBtn: true,
                  title: false,
                  shadeClose: true,
                  shade: 0.8,
                  area: ['800px', '550px'],
                  content: $("#gamePrivacyDialogDiv")
              });
          }

      </script>