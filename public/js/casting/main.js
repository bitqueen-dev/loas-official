var width = 0;
var widthRe = 0;
var baseWidth = 1366;

var listTopIndex = 340 / baseWidth;
var cvPicWidthIndex = 185 / baseWidth;
var cvPicHeightIndex = 289 / baseWidth;

var needToPreLoad = [
    '/images/casting/cc1_1x.png',
    '/images/casting/cc2_1x.png',
    '/images/casting/cc3_1x.png',
    '/images/casting/cc4_1x.png',
    '/images/casting/cc5_1x.png',
    '/images/casting/cc6_1x.png',
    '/images/casting/cc7_1x.png',
    '/images/casting/cc8_1x.png',
    '/images/casting/cc9_1x.png',
    '/images/casting/cc10_1x.png',
    '/images/casting/cc11_1x.png',
    '/images/casting/cc12_1x.png',
    '/images/casting/cc13_1x.png',
    '/images/casting/cc14_1x.png',
    '/images/casting/cc15_1x.png',
    '/images/casting/cc16_1x.png',
    '/images/casting/cc17_1x.png',
    '/images/casting/cc18_1x.png',
    '/images/casting/cc19_1x.png',
    '/images/casting/cc20_1x.png',
    '/images/casting/cc21_1x.png',
];

$(function () {
    width = $(window).width();
    height = $(window).height();

    var cvPicWidth = Math.floor(cvPicWidthIndex * width);

    $("#cvListTop").width((cvPicWidth + 7) * 6).css({
        "padding-top": Math.floor(listTopIndex * width) + 15,
        "margin": "auto"
    });
    $("#cvListBottom").width((cvPicWidth + 7) * 6).css({"margin": "auto"});

    $(".cv_item img").width(cvPicWidth).height(Math.floor(cvPicHeightIndex * width));
    $(".cv_item").width(cvPicWidth).height(Math.floor(cvPicHeightIndex * width));

    $(window).resize(function () {
        widthRe = $(window).width();

        var cvPicWidthRe = Math.floor(cvPicWidthIndex * widthRe);

        $("#cvListTop").width((cvPicWidthRe + 7) * 6).css({
            "padding-top": Math.floor(listTopIndex * widthRe) + 15,
            "margin": "auto"
        });
        $("#cvListBottom").width((cvPicWidthRe + 7) * 6).css({"margin": "auto"});

        $(".cv_item img").width(cvPicWidthRe).height(Math.floor(cvPicHeightIndex * widthRe));
        $(".cv_item").width(cvPicWidthRe).height(Math.floor(cvPicHeightIndex * widthRe));

        $(".cv_item.ready").dbRotate2D({'justResetCss': true});
    });

    $(".cv_item.ready").dbRotate2D({'justResetCss': false});

    $("#facebookButton, #twitterButton").click(function () {
        href = $(this).attr("href");
        var windowWidth = 550;
        var windowHeight = 450;
        var left = (width - windowWidth) / 2;
        var top = (height - windowHeight) / 2;

        window.open(href, "share window", "toolbar=no,scrollbars=yes,resizable=yes,top=" + top + ",left=" + left + ",width=" + windowWidth + ",height=" + windowHeight);
        return false;
    });

    $.each(needToPreLoad, function(i, val) {
        loadImage(val);
    });
});

function loadImage(url) {
    var img = new Image();
    img.src = url;

    if (img.complete) {
        return;
    }

    img.onload = function () {
        img.onload = null;
    }
}

;(function ($) {
    $.fn.dbRotate2D = function (options) {
        var opt = {
            rotateSpeed: 100
        }
        $.extend(opt, options);
        return this.each(function () {
            var $this = $(this);
            var $img = $this.find('img');
            var imgWidth = $img.width();
            var imgHeight = $img.height();
            var mOver = false;
            init();

            function init() {
                setCss();
                setMouseEvent();
            }

            function setCss() {
                $this.css({'width': imgWidth, 'height': imgHeight});
                $img.data({'out': $img.attr('src'), 'over': $img.attr('alt')});
            }

            function setMouseEvent() {
                $this.bind('mouseenter', function () {
                    mOver = true;
                    setAnimation();

                }).bind('mouseleave', function () {
                    mOver = false;
                    setAnimation();
                })
            }

            function setAnimation() {
                if (mOver == true) {
                    $img.clearQueue();
                    $img.stop()
                        .animate({'left': imgWidth / 2, 'width': 0}, opt.rotateSpeed, function () {
                            $(this).attr({'src': $(this).data('over')});
                        })
                        .animate({'left': 0, 'width': imgWidth}, opt.rotateSpeed)

                } else {
                    $img.clearQueue();
                    $img.stop()
                        .animate({'left': imgWidth / 2, 'width': 0}, opt.rotateSpeed, function () {
                            $(this).attr({'src': $(this).data('out')});
                        })
                        .animate({'left': 0, 'width': imgWidth}, opt.rotateSpeed)
                }
            }

        })

    }
})(jQuery);