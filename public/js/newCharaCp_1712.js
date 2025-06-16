var tweetBtnFlag = false;
var tweetBtnClick = function () {
  layer.closeAll();
  if (tweetBtnFlag) {
    tweetView();
    return false;
  }
  if (!gId) {
    layer.msg('ログインしていませんが、Twitterでつぶやきますか？</br>※ログインしていない場合、すごろくの無料回数は増えません。', {
      time: 0,
      area: '516px',
      btn: ['はい', 'いいえ'],
      yes: tweetView
    });
    return false;
  }

  $.ajax({
    method: 'POST',
    url: '/minigame/sugoroku/tweet',
    data: {
      gId: gId,
    },
    type: "json",
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    timeout: 5000,
  }).then(function (res) {
    // console.log(res);

    if ((res.status === true) && (res.code == 0)) {
      if (res.addFreePlayCount) {
        tweetBtnFunc();
      }
      tweetBtnFlag = true;
      return true;
    }

    return false;
  }, function (err) {
    return false;
  });

  tweetView();
  return false;
}

$("#tweetBtn").click(tweetBtnClick);

function tweetView () {
  layer.closeAll();

  var href = $("#tweetBtn").attr("href");
  var width = $(window).width();
  var height = $(window).height();
  var windowWidth = 550;
  var windowHeight = 450;
  var left = (width - windowWidth) / 2;
  var top = (height - windowHeight) / 2;

  window.open(
    href,
    "share window",
    "toolbar=no,scrollbars=yes,resizable=yes,top=" + top + ",left=" + left + ",width=" + windowWidth + ",height=" + windowHeight
  );
  return false;
}

function charaPopup (charaName) {
  var style = '<style type="text/css">'
  +'.hoverAnim:hover { transition: 0.4s; -moz-transition: 0.4s; /* Firefox 4 */ -webkit-transition: 0.4s; /* Safari and Chrome */ -o-transition: 0.4s; /* Opera */ }'
  +'.popup { background-image: url("//ap-statics.loas.jp/mm2/official/images/campaign_1712/popup_'+charaName+'.png"); width: 800px; height: 600px; position: relative; }'
  +'.audioBtn { background-image: url("//ap-statics.loas.jp/mm2/official/images/campaign_1712/audioBtnOff.png"); width: 26px; height: 23px; right: 180px; top: 32px; position: absolute; cursor: pointer; }'
  +'.audioBtn:hover { background-image: url("//ap-statics.loas.jp/mm2/official/images/campaign_1712/audioBtnOn.png"); }'
  +'</style>';

  var body = '<div class="popup"><div class="audioBtn hoverAnim" onclick="audioClick(\''+charaName+'\');"></div></div>';

  layer.closeAll();
  layer.open({
    type: 1,
    title: false,
    skin: 'layui-layer-rim',
    area: ['800px', '600px'],
    shadeClose: true,
    content: style+body
  });
}

function detailPopup () {
  layer.closeAll();
  layer.open({
    type: 1,
    title: false,
    skin: 'layui-layer-rim',
    area: ['800px', '600px'],
    shadeClose: true,
    content: '<style type="text/css">.detailLayer { margin: 30px; } .detailLayer h4 { color: #0101DF; }</style><div class="detailLayer"><h4>応募要項</h4><h4>■キャンペーンタイトル</h4><p>フォロー&リツイートキャンペーン</p><h4>■開催期間</h4><p>2017年12月15日(金)～2018年1月8日(月・祝)</p><h4>■商品</h4><p>桃河りかさんサイン入りオリジナルモバイルバッテリー(12000mAh)・・・3名様</p><h4>■応募方法</h4><p>１：公式アカウント（https:\/\/twitter.com/LOA_JP）をフォロー</br>２：該当ツイートをリツイートしてください。</p><p>※非公開設定のアカウントは、応募対象外となりますのでご注意ください。</br>※抽選の対象は、1アカウント1ツイートになります。</br>※フォローを解除されますと応募対象外となりますのでご注意ください。</p><h4>■当選・発表に関して</h4><p>厳正な抽選の上、当選者の方には2018年1月中にDMをお送りいたします。</br>なお、DMをお送りしてから7日間以内にご返信がない場合は、当選を無効とさせて頂きますのでご了承ください。</p><h4>■個人情報保護方針</h4><p>取得した個人情報に関しては、弊社の<a href="http:\/\/www.loas.jp/support/privacy.html#rightContent"><u>個人情報保護方針</u></a>に基づいてお取り扱い致します。</p><h4>■注意事項</h4><p>本キャンペーンは日本国内にお住まいの方に限らせていただきます。</p></div>'
  });
}

var sound = null;
function audioClick (charaName) {
  if (sound) {
    sound.unload();
  }

  sound = new Howl({
    src: ['http://ap-statics.loas.jp/mm2/official/sounds/campaign_1712/' + charaName + '_cp_voice.wav'],
    volume: 0.5
  });

  sound.play();
}
