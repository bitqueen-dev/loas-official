<style>

  .game-privacy-wrapper {
    width: 800px;
    background-color: #fff;
    margin: auto;
  }

  .game-privacy-wrapper .info_area {
    width: 100%;
    height: 100%;
    background-color: #dcdcdc;
  }

  .game-privacy-wrapper .info_title {
    font-size: 35px;
    line-height: 87px;
    text-align: center;
    font-weight: bolder;
  }


  .game-privacy-wrapper .info_table {
    width: 600px;
    margin: auto;
    line-height: 20px;
    padding-bottom: 30px;
  }

  .game-privacy-wrapper .terms_title {
    text-align: center;
    font-weight: bolder;
  }

  .game-privacy-wrapper .confirm_area {
    width: 480px;
    height: 60px;
    background-color: #eeeeee;
    margin: 15px auto 0 auto;
    text-align: center;
    line-height: 30px;
  }

</style>
<div id="gamePrivacyDialogDiv" class="game-privacy-wrapper" style="display: none">
    <div class="info_area">
      <div class="info_title">プレイする前に</div>
      <div class="info_table">以下の利用規約およびプライバシーポリシーをご確認の上、「同意する」チェックボックスを選択した後、「プレイ開始」ボタンを押してください。
      </div>
      <div class="terms_title">利用規約</div>
      <iframe src="/terms_clear" style="width: 580px;height: 150px;border: 0;margin: 15px auto 0 auto;display: block;background-color: #fff;padding: 10px;"></iframe>
      <br/>
      <div class="terms_title">プライバシーポリシー</div>
      <iframe src="/privacy_clear" style="width: 580px;height: 150px;border: 0;margin: 15px auto 0 auto;display: block;background-color: #fff;padding: 10px;"></iframe>

      <div class="confirm_area">
        <input type="checkbox" name="agree" id="agreeTerms" value="利用規約に同意">利用規約に同意 <br/>
        <input type="checkbox" name="agree" id="agreePrivacy" value="プライバシーポリシーに同意">プライバシーポリシーに同意
      </div>
      <br/><br/>
      <div style="text-align: center;">
        <input type="button" id="goToPlay" name="goToPlay" value="プレイ開始" disabled style="width:150px;height:30px;margin: 0 auto;cursor: pointer;"/>
      </div>
      <br/>
    </div>
</div>
<script type="text/javascript">
  $(function() {
    $("#agreeTerms").click(function() {
      checkEnablePlay();
    });
    $("#agreePrivacy").click(function() {
      checkEnablePlay();
    });

    function checkEnablePlay() {
      $agreeTerms = $("#agreeTerms");
      $agreePrivacy = $("#agreePrivacy");
      if ($agreeTerms.prop("checked") && $agreePrivacy.prop("checked")) {
        $("#goToPlay").attr("disabled",false);
      } else {
        $("#goToPlay").attr("disabled","disabled");
      }
    }

    $("#goToPlay").click(function() {
      //发起同意，
      //关闭对话框
      $.get("/agreeGamePrivacy", function(result){
        parent.layer.closeAll();
        showServers();
      });
    });

  });
</script>