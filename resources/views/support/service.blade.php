<?php
$error = $errors->all();
$imgErrorFlag = false;
$unknowFlag = false;
$backStatus = false;
//var_dump($error);exit;
if(in_array('imgUpload', $error)) {
	$imgErrorFlag = true;
}

if(in_array('unknow', $error)) {
	$unknowFlag = true;
}

if(session('status') == 'succ') {
	$backStatus = true;
}
?>
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
    @include('support.leftMenu', ['page' => 'service'])
    <div class="contents_right">
      <div class="sub_page_right" id="rightContent" name="rightContent">
        <div class="sub_page_right_top">
          <span class="sub_page_nav"><a href="/">HOME</a></span> ＞ <span class="sub_page_nav"><a href="/support#rightContent">サポート</a></span> ＞ <span class="sub_page_nav_current">お問い合わせ</span>
        </div>
        <div class="sub_page_right_contents">
          <div class="sub_page_support_1_title"></div>
          <?php if($backStatus) {?>
          <div class="sub_title_1">送信しました。</div>
          <?php } else if($unknowFlag) {?>
          <div class="sub_title_1">Unknow Error!Please mail to support@loas.jp</div>
          <?php } else {?>
          <div class="sub_title_1">内容をご記入の上、確認画面へボタンをクリックしてください。<span class="support_1_important">※必須項目です。</span></div>
          <form action="/func/poster" method="post" enctype="multipart/form-data" id="userService" name="userService">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
              <tbody>
              <tr>
                <td width="230">ニックネーム　<span class="support_1_important">※</span></td>
                <td>
                  <input size="35" name="nickname" id="nickname" type="text" value="">
                  <span class="support_1_error" id="nicknameEmpty">ニックネームが未入力です。</span>
                </td>
              </tr>
              <tr>
                <td>お問い合わせ項目　<span class="support_1_important">※</span></td>
                <td>
                  <select name="subject" id="subject">
                    <option value="empty">---選択してください---</option>
                    <option value="ログインについて">ログインについて</option>
                    <option value="チャージについて">チャージについて</option>
                    <option value="不具合報告">不具合報告</option>
                    <option value="迷惑ユーザー報告">迷惑ユーザー報告</option>
                    <option value="ご意見・ご要望">ご意見・ご要望</option>
                    <option value="その他">その他</option>
                  </select>
                  <span class="support_1_error" id="subjectEmpty">お問い合わせ項目を選択してください。</span>
                </td>
              </tr>
              <tr>
                <td>サーバー　<span class="support_1_important">※</span></td>
                <td>
                  <input size="35" name="server" id="server" type="text" value="">
                  <span class="support_1_error" id="serverEmpty">サーバーが未入力です。</span>
                </td>
              </tr>
              <tr>
                <td>メールアドレス　<span class="support_1_important">※（半角英数字）</span></td>
                <td>
                  <input size="35" name="email" id="email" type="text" value="">
                  <span class="support_1_error" id="emailEmpty">メールアドレスが未入力です。</span>
                  <span class="support_1_error" id="emailDiff">確認メールアドレスと違います。</span>
                  <span class="support_1_error" id="emailFormatError">メールアドレスのフォーマットが違います。</span>
                </td>
              </tr>
              <tr>
                <td>メールアドレス確認　<span class="support_1_important">※（半角英数字）</span></td>
                <td>
                  <input size="35" name="emailConfirm" id="emailConfirm" type="text" value="">
                  <span class="support_1_error" id="emailConfirmEmpty">メールアドレスが未入力です。</span>
                </td>
              </tr>
              <tr>
                <td>添付ファイル　<span class="support_1_important">(jpg,png,gif,500KB)</span></td>
                <td>
                  <input size="35" type="file" name="imageUpload" id="imageUpload">
                </td>
              </tr>
              <tr>
                <td>発生日時　</td>
                <td>
                  <input size="35" name="time" id="time" type="datetime-local" value="">
                </td>
              </tr>
              <tr>
                <td>お問い合わせ内容　<span class="support_1_important">※</span></td>
                <td>
                  <textarea id="content" name="content" rows='10' cols='50'></textarea>
                  <br /><span class="support_1_error" id="contentEmpty">お問い合わせ内容が未入力です。</span>
                </td>
              </tr>
              </tbody>
            </table>
            <div style="color: white; margin: 0 16px 0 16px">
              <h3>個人情報の取り扱いついて</h3>
              <div style="font-size:14px">このページから知り得た個人情報は、当社へのお問い合わせの内容確認、回答、および対応の目的にのみ利用し、第三者に開示することはいたしません。（ただし、公的機関から法令に基づく開示要請を受けた場合を除きます。）<br>そのほか、個人情報の取り扱いについては、<a style="color:red" href="https://www.loas.jp/support/privacy.html#rightContent">プライバシーポリシー</a>をご確認ください。
                <br>
                <br>
                ※個人情報の取扱いについて同意いただける場合のみ下記のボタンをクリックして進んで下さい。
                <br>
                ※ご記入の内容は、SSL暗号化により安全に送信されます。
              </div>
              <div style="margin-top: 10px">
                <input type="checkbox" name="agree" id="agree">
                <label for="agree">個人情報の取り扱いに同意する (必須)</label>
              </div>
            </div>
            <input type="hidden" name="userId" value="{{ Session::get('userInfo.gameId') }}"/>
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            <button type="submit" value="submit" class="button orange">確　認</button>
          </form>
          <?php }?>
        </div>
        <div class="sub_page_right_bottom"></div>
      </div>
    </div>
    @include('vendor.footer')
    <div style="clear:both;"></div>
  </div>
</div>
<script language="javascript">
  function submitOK() {
    $(".button").addClass("orange");
    $(".button").removeAttr("disabled");
    $(".button").css("cursor", "pointer");
    console.log("OK");
  }
  function submitNG() {
    $(".button").removeClass("orange");
    $(".button").attr("disabled", "true");
    $(".button").css("cursor", "auto");
    console.log("NG");
   }
  submitNG();
  $("#agree").change(function() {
    if($(this).prop("checked")) {
        submitOK();
        }
    else {
        submitNG();
        }
  });
  $("#userService").submit(function() {
    $(".error").hide();

    var nickname = $("#nickname").val();
    var subject = $("#subject").val();
    var server = $("#server").val();
    var email = $("#email").val();
    var emailConfirm = $("#emailConfirm").val();
    var content = $("#content").val();

    if(nickname == "") {
      $("#nicknameEmpty").show();
      $("#nickname").focus();
      return false;
    }

    if(subject == "empty") {
      $("#subjectEmpty").show();
      $("#subject").focus();
      return false;
    }

    if(server == "") {
      $("#serverEmpty").show();
      $("#server").focus();
      return false;
    }

    if(email == "") {
      $("#emailEmpty").show();
      $("#emailDiff").hide();
      $("#emailFormatError").hide();
      $("#email").focus();
      return false;
    }

    if(emailConfirm == "") {
      $("#emailConfirmEmpty").show();
      $("#emailConfirm").focus();
      return false;
    }

    if(content == "") {
      $("#contentEmpty").show();
      $("#content").focus();
      return false;
    }

    if(email != emailConfirm) {
      $("#emailEmpty").hide();
      $("#emailDiff").show();
      $("#emailFormatError").hide();
      $("#email").focus();
      return false;
    }

    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    if(!pattern.test(email)) {
      $("#emailEmpty").hide();
      $("#emailDiff").hide();
      $("#emailFormatError").show();
      $("#email").focus();
      return false;
    }
  });
</script>
</body>
</html>