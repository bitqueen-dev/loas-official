<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  @include('vendor.metaCommon')
  @include('vendor.titleCommon')
{{--    <link rel="stylesheet" href="//ap-statics.loas.jp/mm2/official/css/main.css?190527">--}}
  <link rel="stylesheet" href="{{ config('app.httpsBaseUrl') }}/css/main.css?20221003">
  <script src="//ap-statics.loas.jp/mm2/official/js/jquery.min.js"></script>
{{--  <script src="{{ config('app.httpsBaseUrl') }}/js/main.js?20180814"></script>--}}
  <script src="{{ config('app.httpsBaseUrl') }}/js/protocolcheck.js?20200908"></script>
  <script language="javascript">
    __baseUrl = "{{ config('app.httpBaseUrl') }}";
    __baseUrlSSL = "{{ config('app.httpsBaseUrl') }}";
  </script>
  <style>
    .server_exe_download {
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

  </style>
</head>
<body>
<div class="wrapper_server_list_new">
  <div class="server_exe_download">クライアントダウンロード</div>
  <div class="server_list_title"></div>
  <div class="server_list_recommended">
    <?php foreach ($serverInfo as $serverId => $info) {
      if(in_array('recommended', $info['iconState'])) {
        echo '<div class="server_list_recommended_item" onclick="playGame(\'' . $serverId .'\');">' . $info['serverName'] . '</div>';
        break;
      }
    }?>
  </div>
  <div class="server_area_new">
    <?php foreach ($serverInfo as $serverId => $info) {
      if(in_array('new', $info['iconState'])) {
        echo '<div class="server_item_new" onclick="playGame(\'' . $serverId .'\');">' . $info['serverName'] . '</div>';
        continue;
      } else {
        echo '<div class="server_item_normal" onclick="playGame(\'' . $serverId .'\');">' . $info['serverName'] . '</div>';
      }
    }?>
  </div>
</div>
<script type="text/javascript">
  ////function
  function showServers(_client='exe') {
    showServers(layer, _client);
  }

  function showServers(_layer = layer, _client = 'exe') {
    _layer.open({
      type: 2,
      closeBtn: false,
      title: false,
      shadeClose: true,
      shade: 0.8,
      area: ['910px', '610px'],
      content: '/serverSelect?client=' + _client
    });
  }

  $(function() {

  $(".flash_version").click(function () {
    parent.layer.closeAll();
    showServers(parent.layer, "flash");
    return false;
  });

  $(".exe_version").click(function () {
    parent.layer.closeAll();
    showServers(parent.layer, "exe");
    return false;
  });
  $(".server_exe_download").click(function () {
    window.open("{{ config('app.httpsBaseUrl') }}/support/download_guide", '_blank');
    return false;
  });


});

@if ($client === 'exe' )
  @if(preg_match('/Macintosh/', $_SERVER['HTTP_USER_AGENT']))
    function playGame(serverId) {
        alert('MACでは遊べません。');
        return false;
    }
  @else
    function playGame(serverId) {
      parent.layer.load();
      var playUri = '{{ config('app.httpsBaseUrl') }}/game/startClient/' + serverId;
      $.ajax({
        url: playUri,
        type:'get',
      }).done(function(res){
        var url = res.url;
        // window.open(url, "_blank");
        //debugger;
        window.protocolCheck(url,
            function () {
              parent.layer.closeAll('loading');
              parent.layer.msg('「League of Angels2」クライアントをインストールしてください。', {
                icon: 7,
                time: 0,
                btn: ['ダウンロード'],
                closeBtn: 1,
                yes: function (index) {
                  parent.layer.close(index);
                  window.open( __baseUrlSSL + '/intro/download.html#rightContent');
                }
              });
            }, function () {
                parent.layer.closeAll('loading');
                // window.open(url, "_blank");
            }
        );

      });
    }

    // $("#selectedServer").click(function (event) {
    //   window.protocolCheck($(this).attr("href"),
    //         function () {
    //           parent.layer.closeAll('loading');
    //           parent.layer.msg('「League of Angels2」クライアントをインストールしてください。', {
    //             icon: 7,
    //             time: 0,
    //             btn: ['ダウンロード'],
    //             closeBtn: 1,
    //             yes: function (index) {
    //               parent.layer.close(index);
    //               window.open( __baseUrlSSL + '/intro/download.html#rightContent');
    //             }
    //           });
    //         }, function () {
    //             parent.layer.closeAll('loading');
    //             window.open(data, "_blank");
    //           });
    //   event.preventDefault ? event.preventDefault() : event.returnValue = false;
    // });

  @endif
@elseif ($client ==='flash')
  function playGame(serverId) {
    var playUri = '{{ config('app.httpsBaseUrl') }}/game/play/' + serverId;
    window.open(playUri);
    parent.layer.closeAll();
  }
@endif


</script>

@include('adTag.googleAnalytics')
@include('adTag.game_serverSelect')

</body>
</html>