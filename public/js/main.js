var currentSliderId = '';
var nextSliderId = '';
var scrolling = null;
var itemInfo = null;
var payWay = null;
var __soundObj = __gid = __cid = null;
var __imgSrcUrl = '//ap-statics.loas.jp/mm2/official/images/';
var __soundSrcUrl = '//ap-statics.loas.jp/mm2/official/sounds/';
var __curDescPageNum = __descPagesNum = 1;

$(document).ready(function () {
    $("#topMenu").mouseenter(function () {
        $("#subMenu").fadeIn();
    });

    $("#subMenu").mouseleave(function () {
        $("#subMenu").fadeOut();
    });

    $(".user_function_logout").click(function () {
        window.location.href = __baseUrlSSL + '/logout';
    });

    $(".coin_button, .coin_tab_item1").click(function () {
        window.location.href = __baseUrlSSL + '/purchase/intro#introContents';
    });

    $(".coin_tab_item2, .coin_subpage1_buy_button, .sub_page_diamond_coin_buy_button").click(function () {
        window.location.href = __baseUrlSSL + '/purchase/process#processContents';
    });

    $(".coin_tab_item3").click(function () {
        window.location.href = __baseUrlSSL + '/purchase/history#historyContents';
    });

    $(".more_notice").click(function () {
        window.location.href = __baseUrlSSL + '/notice/newest#rightContent';
    });

    $(".more_character").click(function () {
        window.location.href = __baseUrlSSL + '/intro/character.html#rightContent';
    });

    $(".more_video").click(function () {
        window.location.href = __baseUrlSSL + '/gallery/movies.html#moviesContents';
    });

    $(".logo").click(function () {
        window.location.href = __baseUrlSSL + '/';
    });

    $(".btn_point, .point_tab_item1, .point_button").click(function () {
        window.location.href = __baseUrlSSL + '/pointMall/intro.html#rightContent';
    });

    $(".point_tab_item2, .pointmall_button").click(function () {
        window.location.href = __baseUrlSSL + '/pointMall/itemlist#rightContent';
    });

    $(".point_tab_item3").click(function () {
        window.location.href = __baseUrlSSL + '/pointMall/history#rightContent';
    });

    $(".btn_mclient_download").click(function () {
        window.location.href = __baseUrlSSL + '/intro/download.html#rightContent';
    });

    $(".sub_page_intro_download_btn").click(function () {
        window.location.href = __baseUrlSSL + '/intro/download.html#rightContent';
    });


    $(".btn_coin").click(function () {
        window.location.href = __baseUrlSSL + '/purchase/intro#introContents';
    });


    $(".btn_diamond_charge").click(function () {
        window.location.href = __baseUrlSSL + '/diamondCharge/chargePage#introContents';
    });

    $(".btn_beginner").click(function () {
        window.location.href = __baseUrlSSL + '/playguild/#beginner';
    });

    $(".btn_minigame").click(function () {
        window.location.href = __baseUrlSSL + '/minigame_questionnaire';
    });

    $(".btn_charge").click(function () {
        window.location.href = __baseUrlSSL + '/charge_cp.html#rightContents';
    });

    $(".world").click(function () {
        window.location.href = __baseUrlSSL + '/intro#rightContent';
    });

    $(".character_vote").click(function () {
        window.location.href = 'https://campaign.loas.jp/';
    });

    $(".qa").click(function () {
        window.location.href = __baseUrlSSL + '/intro/playenv.html#rightContent';
    });

    $(".faq").click(function () {
        window.location.href = __baseUrlSSL + '/support/qa#rightContent';
    });

    $(".karma_link").click(function () {
        window.open('//karma-online.jp/', '_blank');
    });

    $(".netcafe").click(function () {
        window.location.href = '//www.nepoca.com/TitleInfo/174';
    });

    $(".audition_link").click(function () {
        window.location.href = 'http://audition.loas.jp/';
    });

    $(".campaign_link").click(function () {
        window.open('/campaign_Lustercp', '_blank');
    });

    $(".webmoneycp_ministop").click(function () {
        window.location.href = __baseUrlSSL + '/WebMoneycp_ministop';
    });

    $(".function_game").click(function () {
        window.location.href = '/notice/topic/833e958e6949de535ecc80dd2dad7632#rightContent';
    });

    $(".character_item_1").click(function () {
        gaClicks('Main Character Link','click','silvia');
        window.location.href = __baseUrlSSL + '/intro/character.html?gc="2-22"#rightContent';
    });

    $(".character_item_2").click(function () {
        gaClicks('Main Character Link','click','julia');
        window.location.href = __baseUrlSSL + '/intro/character.html?gc="1-22"#rightContent';
    });

    $(".character_item_3").click(function () {
        gaClicks('Main Character Link','click','darusasu');
        window.location.href = __baseUrlSSL + '/intro/character.html?gc="3-23"#rightContent';
    });

    $(".character_item_4").click(function () {
        gaClicks('Main Character Link','click','thea');
        window.location.href = __baseUrlSSL + '/intro/character.html?gc="1-21"#rightContent';
    });

    $(".character_item_5").click(function () {
        gaClicks('Main Character Link','click','spica');
        window.location.href = __baseUrlSSL + '/intro/character.html?gc="2-21"#rightContent';
    });

    $(".character_item_6").click(function () {
        gaClicks('Main Character Link','click','lulu');
        window.location.href = __baseUrlSSL + '/intro/character.html?gc="3-21"#rightContent';
    });

    $(".character_item_7").click(function () {
        gaClicks('Main Character Link','click','sophia');
        window.location.href = __baseUrlSSL + '/intro/character.html?gc="3-4"#rightContent';
    });

    var slideItemsStr = '';
    var slideItemsCount = 0;

    $.each(sliderItems, function (key, val) {
        slideItemsCount++;
        slideItemsStr += '<div class="thumb_pic_item" id="' + key + '"><a href="' + val.href + '"><img src="' + val.thumb_pic + '" /></a></div>';
    });

    $('.thumb_pic_mask').html(slideItemsStr);

    $('.big_pic').html('<a href="' + sliderItems.slider1.href + '" id="slideBigCurrent"><img src="' + sliderItems.slider1.big_pic + '" /></a><a href="' + sliderItems.slider2.href + '" id="slideBigNext" style="display: none;"><img src="' + sliderItems.slider2.big_pic + '" /></a>');

    var itemWidth = $(".thumb_pic_item").outerWidth();
    $(".thumb_pic_mask").width(itemWidth * $(".thumb_pic_item").size() + 50);

    if ($('.top_slider').length > 0) {
        scrolling = setInterval(superScroll, 6000);
    }

    $('.thumb_pic_item').hover(function () {
        clearInterval(scrolling);

        nextSliderId = $(this).attr('id');

        //$("#slideBigNext").html('<img src="' + sliderItems[nextSliderId]["big_pic"] + '" />').attr("href", sliderItems[nextSliderId]["href"]);

        $("#slideBigCurrent").fadeOut(200, function () {
            $(".big_pic").html('<a href="' + $("#slideBigNext").attr('href') + '" id="slideBigCurrent">' + $("#slideBigNext").html() + '</a><a href="' + sliderItems[nextSliderId]["href"] + '" id="slideBigNext" style="display: none;"><img src="' + sliderItems[nextSliderId]["big_pic"] + '" /></a>');

            $("#slideBigCurrent").hide();
            $("#slideBigNext").fadeIn(200);
        });
    }, function () {
        if ($('.thumb_pic_mask').css('margin-left') == '-156px') {
            nextSliderId = $('.thumb_pic_item:nth-child(3)').attr('id');
        } else if ($('.thumb_pic_mask').css('margin-left') == '0px') {
            nextSliderId = $('.thumb_pic_item:nth-child(2)').attr('id');
        }

        $(".big_pic").html('<a href="' + $("#slideBigNext").attr('href') + '" id="slideBigCurrent">' + $("#slideBigNext").html() + '</a><a href="' + sliderItems[nextSliderId]["href"] + '" id="slideBigNext" style="display: none;"><img src="' + sliderItems[nextSliderId]["big_pic"] + '" /></a>');

        scrolling = setInterval(superScroll, 6000);
    });

    $(".notice_tabs_items").click(function () {
        var nameCurrent = $(this).attr('name');
        $("#topicContList_newest, #topicContList_notice, #topicContList_event, #topicContList_maintenance, #topicContList_update").hide();
        $('.notice_tabs_items').removeClass('on');

        $("#topicContList_" + nameCurrent).show();
        $(this).addClass('on');
    });

    $(".sub_menu_common").click(function () {
        $('.sub_menu_common').removeClass('on');
        $(this).addClass('on');
    });

    $(".sub_sub_sub_menu").click(function () {
        $('.sub_sub_sub_menu').removeClass('on');
        $(this).addClass('on');
    });

    $(".sub_menu_character_1, .sub_menu_character_2, .sub_menu_character_3, .sub_menu_character_4").click(function () {
        $(".sub_menu_character_1, .sub_menu_character_2, .sub_menu_character_3, .sub_menu_character_4").removeClass("on");
        $(this).addClass("on");
    });
});

!function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0],
        p = /^http:/.test(d.location) ? 'http' : 'https';
    if (!d.getElementById(id)) {
        js = d.createElement(s);
        js.id = id;
        js.src = p + "://platform.twitter.com/widgets.js";
        fjs.parentNode.insertBefore(js, fjs);
    }
}(document, "script", "twitter-wjs");

function scrollClick(moveTo) {
    clearInterval(scrolling);
    superScroll(moveTo);
    scrolling = setInterval(superScroll, 6000);
}

function youtobeVideoPlay(yId) {
    layer.closeAll();
    layer.open({
        type: 2,
        title: false,
        closeBtn: false,
        shadeClose: true,
        shade: 0.8,
        area: ['800px', '445px'],
        content: 'https://www.youtube.com/embed/' + yId + '?autoplay=1&loop=1&playlist=' + yId + '&fs=0'
    });
}

function superScroll(moveTo) {
    var itemWidth = 156;
    var marginLeftValue = 0;
    moveTo = moveTo ? moveTo : 'left';

    if (moveTo == 'left') {
        marginLeftValue = -1 * itemWidth;

        if ($('.thumb_pic_mask').css('margin-left') == '-156px') {
            $('.thumb_pic_mask').find('.thumb_pic_item:first').appendTo($('.thumb_pic_mask'));
            $('.thumb_pic_mask').css({marginLeft: 0});
        }

        nextSliderId = $('.thumb_pic_item:nth-child(2)').attr('id');
        $(".big_pic").html('<a href="' + $("#slideBigCurrent").attr("href") + '" id="slideBigCurrent">' + $("#slideBigCurrent").html() + '</a><a href="' + sliderItems[nextSliderId]["href"] + '" id="slideBigNext" style="display: none;"><img src="' + sliderItems[nextSliderId]["big_pic"] + '" /></a>');

    } else {
        marginLeftValue = 0;

        if ($('.thumb_pic_mask').css('margin-left') == '0px') {
            $('.thumb_pic_mask').find('.thumb_pic_item:last').prependTo($('.thumb_pic_mask'));
            $('.thumb_pic_mask').css({marginLeft: -156});
        }

        nextSliderId = $('.thumb_pic_item:first').attr('id');
        $(".big_pic").html('<a href="' + $("#slideBigCurrent").attr("href") + '" id="slideBigCurrent">' + $("#slideBigCurrent").html() + '</a><a href="' + sliderItems[nextSliderId]["href"] + '" id="slideBigNext" style="display: none;"><img src="' + sliderItems[nextSliderId]["big_pic"] + '" /></a>');
    }

    $('.thumb_pic_mask').animate(
        {
            marginLeft: marginLeftValue + "px"
        },
        {
            duration: 200,
            complete: function () {
                if (moveTo == 'left') {
                    $('.thumb_pic_mask').css({marginLeft: 0}).find('.thumb_pic_item:first').appendTo($('.thumb_pic_mask'));

                    currentSliderId = $('.thumb_pic_item:first').attr('id');
                    nextSliderId = $('.thumb_pic_item:nth-child(2)').attr('id');

                    $(".big_pic").html('<a href="' + sliderItems[currentSliderId]["href"] + '" id="slideBigCurrent"><img src="' + sliderItems[currentSliderId]["big_pic"] + '" /></a><a href="' + sliderItems[nextSliderId]["href"] + '" id="slideBigNext" style="display: none;"><img src="' + sliderItems[nextSliderId]["big_pic"] + '" /></a>');
                } else {
                    $('.thumb_pic_mask').css({marginLeft: -156}).find('.thumb_pic_item:last').prependTo($('.thumb_pic_mask'));

                    currentSliderId = $('.thumb_pic_item:nth-child(2)').attr('id');
                    nextSliderId = $('.thumb_pic_item:first').attr('id');

                    $(".big_pic").html('<a href="' + sliderItems[currentSliderId]["href"] + '" id="slideBigCurrent"><img src="' + sliderItems[currentSliderId]["big_pic"] + '" /></a><a href="' + sliderItems[nextSliderId]["href"] + '" id="slideBigNext" style="display: none;"><img src="' + sliderItems[nextSliderId]["big_pic"] + '" /></a>');
                }
            },
            start: function () {
                switchSliderBigImg();
            }
        }
    );
}

function switchSliderBigImg() {
    $("#slideBigCurrent").fadeOut(200, function () {
        $("#slideBigNext").fadeIn(200);
    });
}

////function
function showServers(_client='exe') {
    showServers(layer, _client);
}

function showServers(_layer = layer, _client = 'exe') {
    _layer.open({
        type: 1,
        closeBtn: false,
        title: false,
        shadeClose: true,
        shade: 0.8,
        area: ['905px', '600px'],
        content: $('#server_list_div')
        //'/serverSelect?client=' + _client
    });
}


function showLogin() {
    layer.open({
        type: 2,
        closeBtn: false,
        title: false,
        shadeClose: true,
        shade: 0.8,
        area: ['800px', '320px'],
        content: '/login'
    });
}

function goStep1() {
    if ($("input[type='radio'][name='itemInfo']:checked").length == 0) {
        layer.msg('ご購入の商品をお選びください', function () {
        });
        return false;
    } else {
        $("#step2").show();
        $("#step1, #step3").hide();
        itemInfo = $('input[type="radio"][name="itemInfo"]:checked').val();
    }
}

function backStep1() {
    $("#step1").show();
    $("#step2, #step3").hide();
}

function goStep2() {
    if ($("input[type='radio'][name='payWay']:checked").length == 0) {
        layer.msg('お支払い方法をお選びください', function () {
        });
        return false;
    } else {
        $("#step3").show();
        $("#step1, #step2").hide();
        payWay = $('input[type="radio"][name="payWay"]:checked').val();

        $("#itemName").html(pointChargeInfo[itemInfo].name);
        $("#itemPay").html(pointChargeInfo[itemInfo].pay);
        $("#payWayName").html(payWayInfo[payWay].name);
        $("#acPoint").html(pointChargeInfo[itemInfo].point);
    }
}

function backStep2() {
    $("#step2").show();
    $("#step1, #step3").hide();
}

function goStep3() {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    var userEmail = $("#userEmail").val();
    if (userEmail == '') {
        layer.msg('メールアドレスをご入力ください', function () {
        });
        return false;
    }

    if (!pattern.test(userEmail)) {
        layer.msg('入力されたメールアドレスが正しくありません', function () {
        });
        return false;
    }

    $("#itemCode").val(itemInfo);
    $("#payWayCode").val(payWay);

    $("#posterPurchase").submit();
}

function go2content() {
    location.href = "#processContents";
}

function orderNumShow(orderNum) {
    layer.tips(orderNum, $("#" + orderNum), {
        tips: [1, '#0FA6D8'],
        time: 5000,
        area: ['270px', '30px'],
    });
}

function showChapter(currentChapter) {
    var dotStr = '';
    var chapterStr = '';

    for (var i = 1; i <= 9; i++) {
        dotStr += '<div class="story_chapter_dot story_chapter_dot_' + i + '"></div>';
    }

    if ((currentChapter == 1) || (currentChapter == 9)) {
        for (var j = 1; j <= 10; j++) {
            chapterStr += '<div class="story_chapter story_chapter_' + j + '" onclick="javascript:showChapter(' + j + ')"></div>'
        }

        $("#chapterButtonList").html(dotStr + chapterStr);
    }

    if ((currentChapter == 10) || (currentChapter == 15)) {
        for (var j = 9; j <= 18; j++) {
            chapterStr += '<div class="story_chapter story_chapter_' + j + '" onclick="javascript:showChapter(' + j + ')"></div>'
        }

        $("#chapterButtonList").html(dotStr + chapterStr);
    }

    if (currentChapter == 18) {
        for (var j = 15; j <= 24; j++) {
            chapterStr += '<div class="story_chapter story_chapter_' + j + '" onclick="javascript:showChapter(' + j + ')"></div>'
        }

        $("#chapterButtonList").html(dotStr + chapterStr);
    }

    if ((currentChapter == 1) || (currentChapter == 2)) {
        $(".story_chapter_title").css("background-image", "url(//ap-statics.loas.jp/mm2/official/images/story_chapter_title_1.png)");
    } else if ((currentChapter >= 3) && (currentChapter <= 8)) {
        $(".story_chapter_title").css("background-image", "url(//ap-statics.loas.jp/mm2/official/images/story_chapter_title_2.png)");
    } else if ((currentChapter >= 9) && (currentChapter <= 16)) {
        $(".story_chapter_title").css("background-image", "url(//ap-statics.loas.jp/mm2/official/images/story_chapter_title_3.png)");
    } else if ((currentChapter >= 17) && (currentChapter <= 24)) {
        $(".story_chapter_title").css("background-image", "url(//ap-statics.loas.jp/mm2/official/images/story_chapter_title_4.png)");
    }

    $("#chapterButtonList div").removeClass("on");
    $(".story_chapter_" + currentChapter).addClass("on");

    $("#storyChapterWords").attr("src", "//easygame.jp/loa2/public/story-" + currentChapter + ".html");
}

function changeCharacter(characterId) {
    if (!characterInfo[characterId]) {
        return changeGroup(1);
    }

    var groupAndCharacter = characterId.split("-");
    var gid = __gid = groupAndCharacter[0];
    var cid = __cid = groupAndCharacter[1];
    var imgWidth = characterInfo[characterId][0];
    var imgHeight = characterInfo[characterId][1];
    var imgTop = characterInfo[characterId][2];
    var nameTop = characterInfo[characterId][3];
    var descPagesNum = __descPagesNum = characterInfo[characterId][4];
    var relatedCharacters = characterInfo[characterId][5];
    var cvTop = characterInfo[characterId][6] || 0;

    $('.group_info').hide();
    $('.boss_group_info').hide();
    $("#characterDescNextPage").hide();
    $("#characterDescPrePage").hide();
    $('.character_info').show();

    soundUnload();

    $(".character_cv_listen_btn").click(function (event) {
        var elementId = event.target.id;
        var tmpArr = elementId.split('_');
        var elementNum = tmpArr[tmpArr.length-1];

        soundPlay(gid, cid, elementNum);
    });

    $(".character_img").css({
        "background-image": "url(" + __imgSrcUrl + "characterImg_" + gid + "_" + cid + ".png)",
        "width": imgWidth,
        "height": imgHeight,
        "top": imgTop
    });

    $("#characterName").attr("src", __imgSrcUrl + "characterName_" + gid + "_" + cid + ".png");
    $(".character_name").css({"top": nameTop});
    $(".character_desc").css({"background-image": "url(" + __imgSrcUrl + "characterDesc_" + gid + "_" + cid + ".png)"});
    $("#characterCVName").attr("src", __imgSrcUrl + "characterCVName_" + gid + "_" + cid + ".png");
    $('.character_cv img').css({"margin-top": cvTop || 0});
    $('.character_backGroup_btn').click(function () { changeGroup(gid); });

    __curDescPageNum = 1;
    if (descPagesNum == 1) {
        $("#characterDescNextPage").hide();
        $("#characterDescPrePage").hide();
    } else {
        $("#characterDescNextPage").show();
    }

    if (relatedCharacters.length > 0) {
        var currentNum = relatedCharacters.length;

        var str = '';

        str = '<div class="character_list_items">';

        for (var key in relatedCharacters) {
            var ids = relatedCharacters[key].split("-");
            var _gid = ids[0];
            var _cid = ids[1];
            str += genStr(_gid, _cid);
        }

        str += '</div>';
        $("#characterListSlider").html(str);

        for (var key in relatedCharacters) {
            var ids = relatedCharacters[key].split("-");
            var _gid = ids[0];
            var _cid = ids[1];
            setBackgroundImage(
                $('.character_list_item_'+_gid+'_'+_cid),
                __imgSrcUrl+'character_button_'+_gid+'_'+_cid+'_off.png',
                __imgSrcUrl+'character_button_'+_gid+'_'+_cid+'_on.png'
            );
        }

        if (currentNum > 7) {
            $("#characterListSlider").scrollForever({
                "dir": "top",
                "continuous": false,
                "speed": 500,
                "delayTime": 5000,
            });
        } else {
            $(".character_list_items").width(132 * currentNum + 10);
        }
    }
}

// [imgWidth,imgHeight,imgTop,nameTop,descPagesNum, relatedCharacters,cvTop=null]
var characterInfo = {
// テンペスト
    '1-1':[889, 640, -97, 5, 1, ['1-20','2-1','1-13','1-18']], // ヴィクトリア
    '1-2':[1108, 679, -133, 5, 2, ['4-5', '1-4', '1-6']], // ヘレン
    '1-3':[931, 616, -76, 5, 1, ['1-7']], // シャル
    '1-4':[1023, 642, -95, 5, 2, ['1-6','1-14','1-18','1-2']],　// ヘラ
    '1-5':[784, 679, -138, 21, 2, ['1-17','3-17','2-15','3-21','3-22']], // カイン
    '1-6':[844, 664, -124, 22, 2, ['1-4','1-14','1-2']], // ルーカス
    '1-7':[1259, 679, -135, 3, 1, ['1-15','1-16','1-3','2-21','1-22']], // パンドラ
    '1-8':[1129, 588, -41, 22, 2, ['3-13','2-9','3-21']], // スコール
    '1-9':[803, 679, -135, 15, 1, ['1-15','2-20']], // アイシャ
    '1-10':[810, 596, -47, 23, 2, ['1-14','3-7']], // パーマー
    '1-11':[1259, 679, -135, 5, 2, ['3-11','2-22']], // ミカエラ
    '1-12':[1053, 635, -91, 12, 2, ['1-13','2-19','3-6','3-5']], // ミランダ
    '1-13':[1110, 679, -135, 15, 2, ['1-1', '1-12', '2-19', '4-1']],　// エレン
    '1-14':[690, 643, -99, 13, 2, ['1-2','1-10','1-4']], //フリマンI世
    '1-15':[961, 638, -94, 13, 1, ['1-7','1-9','2-10','2-5','2-21','1-22']], //ロキ
    '1-16':[682, 622, -78, 5, 2, ['1-7','2-17','3-14']], //アドルフ
    '1-17':[962, 611, -67, 5, 2, ['1-5']], //バイソン
    '1-18':[935, 669, -125, 12, 1, ['1-1','1-4']], //オーランド
    '1-19':[840, 679, -135, 13, 1, ['2-9','3-3']], //リリス
    '1-20':[924, 706, -150, 22, 2, ['1-1','3-11'], 10], //イゾルデ
    '1-21':[1260, 686, -130, 0, 2, ['3-22','2-6']], //テア
    '1-22':[1260, 671, -122, 0, 4, ['4-5','1-15','1-7']], //ジュリア
// セレスティア
    '2-1':[765, 679, -135, 13, 2, ['4-5','3-1','1-1','2-3']], //ディステニア
    '2-2':[1259, 679, -135, 16, 2, ['2-1','2-3','3-10','3-23']], //泰山
    '2-3':[1259, 679, -135, 3, 2, ['2-7','1-1','2-2','2-1','3-23']], //セシリー
    '2-4':[1198, 679, -135, 20, 2, ['4-5','2-1','2-20']], //リズ
    '2-5':[740, 643, -99, 7, 1, ['2-10', '1-15']], //ウォッカー
    '2-6':[834, 679, -135, 9, 2, ['2-1','1-1','2-11','1-21']], //セントリア
    '2-7':[943, 656, -112, 15, 3, ['2-3','2-15','3-17']], //アイオン
    '2-8':[661, 598, -54, 19, 2, ['2-16','2-1']], //ドイル
    '2-9':[1090, 679, -135, 25, 1, ['3-16','1-8','1-19','3-3']], //シエラ
    '2-10':[944, 633, -89, 15, 1, ['2-5','1-15']], //アトラス
    '2-11':[1076, 679, -135, 9, 2, ['2-6']], //セリア
    '2-12':[1259, 679, -135, 13, 2, ['2-1','3-2','3-18']], //ニコル
    '2-13':[1201, 679, -135, 6, 1, ['3-13','3-15']], //ゼノビア
    '2-14':[652, 612, -68, 4, 1, ['3-19']], //アリス
    '2-15':[1091, 632, -88, 4, 2, ['3-17','1-5','2-7']], //リン
    '2-16':[1110, 660, -116, 8, 1, ['2-8','2-1','4-2']], //オースティン
    '2-17':[939, 613, -69, 6, 2, ['1-16','3-14']], //ラミア
    '2-18':[590, 660, -116, 15, 2, ['4-5','2-1']], //ルナリア
    '2-19':[721, 650, -105, 13, 2, ['1-13','1-12','2-1']], //フリダ
    '2-20':[1034, 681, -150, 22, 2, ['1-9','2-4','4-5']], //ジーナ
    '2-21':[1260, 686, -130, 0, 2, ['1-15','1-7']], //スピカ
    '2-22':[1260, 696, -138, 0, 3, ['4-4','3-8','1-11']], //シルビア
// フリーダム
    '3-1':[799, 679, -135, 16, 2, ['3-20','2-1','4-5','1-1']], //プロテニア
    '3-2':[1259, 671, -127, 3, 2, ['4-4','3-8']], //アマリア
    '3-3':[900, 679, -135, 22, 2, ['3-1','1-19','2-9']], //フローラ
    '3-4':[1064, 679, -135, 17, 2, ['3-20','3-1']], //ソフィア
    '3-5':[960, 678, -134, 6, 2, ['3-6','1-12']], //ローラ
    '3-6':[1168, 667, -123, 22, 2, ['3-5','1-12','3-1']], //ランスロット
    '3-7':[997, 635, -91, 18, 1, ['1-10','1-14']], //オーディン
    '3-8':[858, 665, -121, 10, 2, ['3-2','2-22']], //リディア
    '3-9':[884, 628, -84, 16, 2, ['3-12','3-21']], //マリサ
    '3-10':[1035, 622, -78, 2, 2, ['2-2']], //義空
    '3-11':[1013, 673, -129, 22, 2, ['1-11','3-1','1-20']], //グレイシア
    '3-12':[910, 613, -69, 3, 1, ['3-9','3-21']], //チムチム
    '3-13':[1009, 679, -135, 5, 1, ['2-13','3-15','3-20','1-8']], //ロイ
    '3-14':[1125, 638, -94, 14, 2, ['1-16','2-17']], //ガイ
    '3-15':[696, 607, -45, 16, 2, ['2-13','3-13']], //エドワード
    '3-16':[740, 610, -66, 17, 1, ['2-9']], //ナタリア
    '3-17':[940, 673, -129, 11, 1, ['1-5','2-15','2-7']], //ヒルダ
    '3-18':[1095, 679, -135, 13, 1, ['2-12']], //セイレーン
    '3-19':[724, 679, -135, 13, 2, ['2-14']], //リリー
    '3-20':[662, 653, -110, 13, 2, ['3-1','3-4']], //クレア
    '3-21':[931, 677, -130, 13, 2, ['1-8','3-12','3-9','1-5']], //ルル
    '3-22':[952, 684, -135, 13, 2, ['1-5','2-19','1-21']], //イーシャ
    '3-23':[1117, 713, -162, 13, 3, ['4-4','2-3','2-2']], //ダルサス
// BOSS
    '4-1':[1067, 674, -126, 13, 2, ['4-3','4-4','1-13']], //イルマ
    '4-2':[995, 679, -131, 7, 2, ['2-16','4-1','4-3','4-4']], //レイリー
    '4-3':[896, 662, -122, 1, 2, ['4-1','4-4']], //ノーデンス
    '4-4':[750, 679, -135, 13, 2, ['4-1','4-3','3-2','3-23','2-22']], //ユリサス
    '4-5':[678, 679, -134, 13, 2, ['2-1','3-1','2-18','2-20','1-22']], //ダリア
};

var groupOrderListHtml = {};
var groupOrderList = {
    1: [22,21,20,8,4,5,6,7,2,3,9,10,12,13,14,15,11,16,18,17,19], // テンペスト
    2: [22,21,20,2,5,4,6,3,8,7,9,10,11,12,13,14,15,16,17,18,19], // セレスティア
    3: [23,21,22,20,2,5,6,7,8,9,3,10,4,11,12,13,14,15,16,17,18,19], // フリーダム
    4: [1,2,3,4,5], // BOSS
};
var groupNewCharacter = ['1-22','2-22','3-23'];

function setGroupCharacterListNewLabel () {
    for (var key in groupNewCharacter) {
        var tmpArr = groupNewCharacter[key].split("-");
        var gid = tmpArr[0];
        var cid = tmpArr[1];
        $('.group_character_'+gid+'_'+cid).html('<div class="group_new_character_label"></div>');
    }
}

function getGroupCharacterListHtml (gid) {
    return groupOrderListHtml[gid];
}

function setGroupCharacterListHtml () {
    for (var gid in groupOrderList) {
        var str = '';
        for (var key in groupOrderList[gid]) {
            var cid = groupOrderList[gid][key];
            var characterIndex = gid + '-' + cid;
            if (gid == 4) {
                str += '<div class="boss_group_character boss_group_character_'+gid+'_'+cid+'" onclick="javascript:changeCharacter(\'' + characterIndex + '\');"></div>';
            } else {
                str += '<div class="group_character group_character_'+gid+'_'+cid+'" onclick="javascript:changeCharacter(\'' + characterIndex + '\');"></div>';
            }
        }
        groupOrderListHtml[gid] = str;
    }
}

function initialSetCharacter (characterId) {
    setGroupCharacterListHtml();
    if (characterInfo[characterId] && characterId != 0) {
        changeCharacter(characterId);
    } else {
        changeGroup(1);
    }

    $("#characterDescNextPage").click(function () {
        __curDescPageNum++;
        $(".character_desc").css({"background-image": "url(" + __imgSrcUrl + "characterDesc_" + __gid + "_" + __cid + "_p"+__curDescPageNum+".png)"});
        if(__curDescPageNum == __descPagesNum){
            $("#characterDescNextPage").hide();
            $("#characterDescPrePage").show();
        }
    });

    $("#characterDescPrePage").click(function () {
        __curDescPageNum--;
        if(__curDescPageNum == 1){
            $(".character_desc").css({"background-image": "url(" + __imgSrcUrl + "characterDesc_" + __gid + "_" + __cid + ".png)"});
            $("#characterDescNextPage").show();
            $("#characterDescPrePage").hide();
        }else{
            $(".character_desc").css({"background-image": "url(" + __imgSrcUrl + "characterDesc_" + __gid + "_" + __cid + "_p"+__curDescPageNum+".png)"});
        }
    });
}

function changeGroup (gid) {
    if (gid == 4) {
        return bossGroupView();
    }
    $('.character_info').hide();
    $('.boss_group_info').hide();
    $('.group_info').show();

    soundUnload();

    var leaderImgElement = $('.group_leader_character');
    setBackgroundImage(
        leaderImgElement,
        __imgSrcUrl + 'characters/' + gid + '_1_off.png',
        __imgSrcUrl + 'characters/' + gid + '_1_on.png'
    );

    leaderImgElement.click(function () {
        changeCharacter(gid+'-1');
    });

    var str = getGroupCharacterListHtml(gid);
    $("#group_character_list").html(str);

    for (var key in groupOrderList[gid]) {
        var cid = groupOrderList[gid][key];

        var characterElement = $('.group_character_'+gid+'_'+cid);
        setBackgroundImage(
            characterElement,
            __imgSrcUrl+'characters/'+gid+'_'+cid+'_off.png',
            __imgSrcUrl+'characters/'+gid+'_'+cid+'_on.png'
        );
    }

    setGroupCharacterListNewLabel();
}

function bossGroupView () {
    $('.character_info').hide();
    $('.group_info').hide();
    $('.boss_group_info').show();

    var gid = 4;

    var str = getGroupCharacterListHtml(gid);
    $('#boss_group_character_list').html(str);

    for (var key in groupOrderList[gid]) {
        var cid = groupOrderList[gid][key];

        var characterElement = $('.boss_group_character_'+gid+'_'+cid);
        setBackgroundImage(
            characterElement,
            __imgSrcUrl+'characters/'+gid+'_'+cid+'_off.png',
            __imgSrcUrl+'characters/'+gid+'_'+cid+'_on.png'
        );
    }
}

function setBackgroundImage (element, srcOff, srcOn) {
    element.css('background-image', 'url('+srcOff+')');
    if (srcOn) {
        element.hover(function () {
            $(this).css({
                'background-image': 'url('+srcOn+')',
                'transition': '0.4s',
                '-moz-transition': '0.4s',
                /* Firefox 4 */
                '-webkit-transition': '0.4s',
                /* Safari and Chrome */
                '-o-transition': '0.4s',
                /* Opera */
            });
        }, function () {
            $(this).css('background-image', 'url('+srcOff+')');
        });
    }
}

function genStr (gid, cid) {
    var characterIndex = gid + '-' + cid;

    var res = '<div class="character_list_item hoverAnim character_list_item_' + gid + '_' + cid + '" onclick="javascript:changeCharacter(\'' + characterIndex + '\');"></div>';

    return res;
}

function soundUnload () {
    if (__soundObj) __soundObj.unload();
}

function soundPlay(indexCountry, indexMember, trackNumber) {
    soundUnload();

    if (trackNumber) {
        var soundFileName = indexCountry + "-" + indexMember + "-" + trackNumber;
        var fileExtension = 'wav';
    } else {
        var soundFileName = indexCountry + "-" + indexMember;
        var fileExtension = 'mp3';
    }

    __soundObj = new Howl({
        src: [__soundSrcUrl + soundFileName + '.' + fileExtension],
        volume: 0.5
    });

    __soundObj.play();
}