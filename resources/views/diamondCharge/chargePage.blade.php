<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="_token" content="{{ csrf_token() }}"/>
  @include('vendor.metaCommon')
  @include('vendor.titleCommon')
  @include('vendor.cssjs')
  <script language="JavaScript">
    var __payInfo = new Array();

    @foreach ($purchaseInfo as $itemId => $itemInfo)
            __payInfo['{{ $itemId }}'] = {'diamond' : {{ $itemInfo['diamond'] }}, 'price' : {{ $itemInfo['price'] }}, 'name' : '{{ $itemInfo['name'] }}'};
    @endforeach
  </script>
  <style type="text/css">
    .select {
      display:flex;
      flex-direction: column;
      position:relative;
      width:300px;
      height:30px;
      font-size: 14px;
      margin-left: 220px;
    }

    .option {
      padding:0 30px 0 10px;
      min-height:30px;
      display:flex;
      align-items:center;
      background:#111;
      border-top:#111 solid 1px;
      color:#eee;
      position:absolute;
      top:0;
      width: 100%;
      pointer-events:none;
      order:2;
      z-index:1;
      transition:background .4s ease-in-out;
      box-sizing:border-box;
      overflow:hidden;
      white-space:nowrap;

    }

    .option:hover {
      background:#333;
    }

    .select:focus .option {
      position:relative;
      pointer-events:all;

    }

    input {
      opacity:0;
      position:absolute;
      left:-99999px;
    }

    input:checked + label {
      order: 1;
      z-index:2;
      background:#333;
      border-top:none;
      position:relative;
      color:#eee
    }

    input:checked + label:after {
      content:'';
      width: 0;
      height: 0;
      border-left: 5px solid transparent;
      border-right: 5px solid transparent;
      border-top: 5px solid white;
      position:absolute;
      right:10px;
      top:calc(50% - 2.5px);
      pointer-events:none;
      z-index:3;
    }

    input:checked + label:before {
      position:absolute;
      right:0;
      height: 40px;
      width: 40px;
      content: '';
      background:#333;
    }
  </style>
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
          <span class="sub_page_nav">
            <a href="{{ config('app.httpsBaseUrl') }}/">HOME</a>
          </span> ＞
          <span class="sub_page_nav_current">ロイヤルダイヤ購入</span>
        </div>
        <div class="sub_page_right_contents">
          <div class="sub_page_diamond">
          <div class="sub_page_diamond_title"></div>
          <div class="sub_page_diamond_content1">
            「League of Angels2」では、アイテムモール・ゲーム内ショップで販売されている特別なアイテムを「ロイヤルダイヤ」を使って購入することができます。
            「ロイヤルダイヤ」はLAコインで購入することができます。<br/>
            LAコインをお持ちでない方は、まずLAコインをご購入いただいた上で「ロイヤルダイヤ」をご購入ください。
          </div>

          <table class="sub_page_diamond_coin_count" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="50%">LAコインの残高</td>
              <td width="50%">{{ Session::get('userInfo.coin') }}</td>
            </tr>
          </table>
            <div class="sub_page_diamond_coin_buy_button"></div>

            <div class="sub_page_diamond_server_select_title"></div>

            <div class="select serverId" tabindex="1">
              <input class="selectopt" name="serverId" value="0" type="radio" id="opt1" checked>
              <label for="opt1" class="option">キャラクターを選択してください</label>
              @foreach ($userGameInfo as $serverId=>$userinfo)
                <input class="selectopt" name="serverId" type="radio" id="opt{{ $userinfo["serverId"] }}" value ="{{ $userinfo['serverId'] }}"
                       data-servername="{{ $userinfo["serverName"] }}"
                       data-accountId="{{ $userinfo["userGameId"] }}"
                       data-rolename="{{ $userinfo["roleName"] }}"
                       data-sign="{{ $userinfo['sign'] }}">
                <label for="opt{{ $userinfo["serverId"] }}" class="option"> {{ $userinfo['serverName'] }} - {{ $userinfo['roleName'] }} - Lv.{{ $userinfo['level'] }}</label>
              @endforeach
            </div>

{{--            <div class="styled-select blue semi-square">--}}
{{--              <select id="serverId" name="serverId">--}}
{{--                <option value ="0">キャラクターを選択してください</option>--}}
{{--                @foreach ($userGameInfo as $serverId=>$userinfo)--}}
{{--                  <option value ="{{ $userinfo['serverId'] }}"--}}
{{--                          data-servername="{{ $userinfo["serverName"] }}"--}}
{{--                          data-accountId="{{ $userinfo["userGameId"] }}"--}}
{{--                          data-rolename="{{ $userinfo["roleName"] }}"--}}
{{--                          data-sign="{{ $userinfo['sign'] }}">--}}
{{--                    {{ $userinfo['serverName'] }} - {{ $userinfo['roleName'] }} - Lv.{{ $userinfo['level'] }}--}}
{{--                  </option>--}}
{{--                @endforeach--}}
{{--              </select>--}}
{{--            </div>--}}

            <div class="sub_page_diamond_content1">
              ロイヤルダイヤの購入は、必ずキャラクターを作成したワールドで行ってください。<br/>
              ワールド選択の誤りによる返金や交換などの対応は出来かねます。<br/>
              「キャラクター選択」を完了後、「ロイヤルダイヤ購入」で購入するロイヤルダイヤを選択してください。<br/>
            </div>

            <div class="sub_page_diamond_purchase_title"></div>
            <ul class="sub_page_diamond_list">
              @foreach ($purchaseInfo as $pid => $purchaseInfo)
                <li class="sub_page_diamond_item" data-id="{{ $pid }}">
                  <span class="sub_page_diamond_item_count">{{ $purchaseInfo['name'] }}</span>
                  <span class="sub_page_diamond_item_coin_count1">{{ $purchaseInfo['price'] }}LAコイン</span>
                  <span class="sub_page_diamond_item_coin_count2">{{ $purchaseInfo['price'] }}</span>
                </li>
              @endforeach
            </ul>
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
<script>

  $(document).ready(function () {
    @if(Session::get('loggedIn') === false)
      showLogin();
    @endif;
  });

  @if(Session::get('loggedIn') === true)
  $(".sub_page_diamond_item").click(function () {

    var _serverId = $("div.serverId input:checked").val();
    if (_serverId == 0 || _serverId == null) {
      layer.msg('キャラクターを選択してください。', {
        icon: 7,
        time: 0,
        btn: ['閉じる']
      }, function () {
      });
      return;
    }
    var _sign = $("div.serverId input:checked").data("sign");
    var _serverName = $("div.serverId input:checked").data("servername");
    var _accountId = $("div.serverId input:checked").data("accountid");
    var _roleName = $("div.serverId input:checked").data("rolename");
    var _itemId = $(this).data("id");
    purchaseProc(_serverId, _serverName, _accountId, _roleName, _sign, _itemId);
  });

  @elseif (Session::get('loggedIn') === false)
  $(".sub_page_diamond_item").click(function () {
    showLogin();
  });
  @endif;

  function purchaseProc(__selectedServerId, __serverName,  __selectedAccountId, __selectedRoleName, __sign,  _itemId) {
    var loadingLayer = layer.load('0', {
      shade: [0.2, '#000'],
    });

    layer.confirm(__serverName + " - " + __selectedRoleName + "<br/>" + __payInfo[_itemId].name + ' チャージします。', {btn: ['はい','キャンセル'],title: false,closeBtn: 0,icon: 0},
            function() {
              $.ajax({
                method: "POST",
                url: "/game/diamondPurchase",
                data: {
                  _token: $('meta[name=_token]').attr('content'),
                  _sign: __sign,
                  serverId: __selectedServerId,
                  accountId: __selectedAccountId,
                  itemId: _itemId
                }
              })
                      .done(function(_resp) {
                        layer.close(loadingLayer);
                        if(_resp.status == false) {
                          if(_resp.errNo == '-4') {
                            layer.msg('LAコイン残高が足りません。', {
                              icon: 7,
                              time: 0,
                              btn: ['閉じる']
                            }, function () {

                            });
                          } else {
                            layer.msg('エラーが発生しました。(エラーコード：' + _resp.errNo + ') サポートにお問合せください。', {
                              icon: 7,
                              time: 0,
                              btn: ['閉じる']
                            }, function () {

                            });
                          }

                        } else if(_resp.status == true) {
                          layer.msg('ダイヤチャージは完了しました。ゲーム内にでご確認ください。', {
                            icon: 6,
                            time: 0,
                            btn: ['閉じる']
                          }, function () {
                            window.location.reload();
                          });

                          $('meta[name=_sign]').attr('content', _resp.sign);
                        }
                      });
            },
            function() {
              $("#playArea").show();
              layer.close(loadingLayer);
            }
    );


    /*	*/
  }
</script>
</body>
</html>