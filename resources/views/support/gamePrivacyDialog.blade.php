<!DOCTYPE html>
<html lang="ja" xmlns="http://www.w3.org/1999/html">
<head>
  <meta charset="UTF-8">
  @include('vendor.metaCommon')
  @include('vendor.titleCommon')
  <link rel="stylesheet" href="//ap-statics.loas.jp/mm2/official/css/reg.css">
  <script src="//ap-statics.loas.jp/mm2/official/js/jquery.min.js"></script>
</head>
<body>
<div class="wrapper">
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

    function showServers() {
      parent.layer.open({
        type: 2,
        closeBtn: false,
        title: false,
        shadeClose: true,
        shade: 0.8,
        area: ['910px', '610px'],
        content: '/serverSelect'
      });
    }

    @if(Session::get('userInfo.isAgreedPrivacy') === 1) {
      parent.layer.closeAll();
      showServers()
    }@endif;
  });
</script>
</body>
</html>