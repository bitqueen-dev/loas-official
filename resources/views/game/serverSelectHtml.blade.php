
<script src="{{ config('app.httpsBaseUrl') }}/js/protocolcheck.js?202009085"></script>

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
<div id="server_list_div" class="wrapper_server_list_new" style="display: none">
  <div class="server_exe_download">クライアントダウンロード</div>
  <div class="server_list_title"></div>
  <div class="server_list_recommended">
    <?php foreach ($serverInfo as $serverId => $info) {
      if(in_array('recommended', $info['iconState'])) {
        echo '<div class="server_list_recommended_item play_btn" data-id="'.$serverId.'" >' . $info['serverName'] . '</div>';
        break;
      }
    }?>
  </div>
  <div class="server_area_new">
    <?php foreach ($serverInfo as $serverId => $info) {
      if(in_array('new', $info['iconState'])) {
        echo '<div class="server_item_new play_btn" data-id="'.$serverId.'" >' . $info['serverName'] . '</div>';
        continue;
      } else {
        echo '<div class="server_item_normal play_btn" data-id="'.$serverId.'" >' . $info['serverName'] . '</div>';
      }
    }?>
  </div>
</div>
<script type="text/javascript">
  $(function() {
    var isOpenEXE = true;
    $(".flash_version").click(function () {
      loadindex = layer.load();
      isOpenEXE = false;
      setTimeout(function () {
        $(".flash_version").hide();
        $(".exe_version").show();
        layer.close(loadindex);
      }, 500);
      return false;
    });
    $(".exe_version").click(function () {
      loadindex = layer.load();
      isOpenEXE = true;
      setTimeout(function () {
        $(".flash_version").show();
        $(".exe_version").hide();
        layer.close(loadindex);
      }, 500);
      return false;
    });
    $(".server_exe_download").click(function () {
      window.open("{{ config('app.httpsBaseUrl') }}/support/download_guide", '_blank');
      return false;
    });
    $(".play_btn").click(function () {
      var serverId = $(this).data("id");
      if (isOpenEXE) {
        playGameEXE(serverId);
      } else {
        playGameFlash(serverId);
      }
    });
    function playGameFlash(serverId) {
      var playUri = '{{ config('app.httpsBaseUrl') }}/game/play/' + serverId;
      window.open(playUri);
      parent.layer.closeAll();
    }
    function playGameEXE(serverId) {
      parent.layer.load();
      var playUri = '{{ config('app.httpsBaseUrl') }}/game/startClient/' + serverId;
      $.ajax({
        url: playUri,
        type:'get',
      }).done(function(res){
        var url = res.url;
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
                      window.open("{{ config('app.httpsBaseUrl') }}/support/download_guide");
                    }
                  });
                }, function () {
                  parent.layer.closeAll('loading');
                }
        );
      });
    }
  });
</script>

