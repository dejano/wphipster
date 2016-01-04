var $body = $('body');
var ajaxUrl = '/wp-admin/admin-ajax.php';

//$.ajax({
//    url: ajaxUrl,
//    type: "GET",
//    dataType: "json",
//    cache: false,
//    data: {
//        action: 'wphipster_is_logged_in'
//    },
//    success: function (json) {
//        if (json.isLoggedIn) {
//            fireIfLoggedIn();
//        }
//    }
//});
//
//function fireIfLoggedIn() {
//    $('.nav-shadow').addClass('logged-in');
//    if ($nav.parent('div.preloader.sticky').length > 0) {
//        $html.animate({scrollTop: 0}, 1);
//        $body.animate({scrollTop: 0}, 1);
//    }
//}

var Preloader = function () {
    var preloaderClass = '.nav-bar--loader';
    return {
        init: initialize
    };


    function initialize() {
        $(document).ready(function () {
            if ($(preloaderClass).length > 0) {
                $('html').animate({scrollTop: 0}, 1);
                $body.animate({scrollTop: 0}, 1);
                $body.css({'overflow-y': 'scroll', 'position': 'fixed'});
                setTimeout(function () {
                    $navHeader.animate({
                        'height': '200px'
                    }, 500, null, function () {
                        $(preloaderClass).removeClass("nav-bar--loader");
                        //$body.css({'overflow-x': 'hidden'});
                        $body.css({'overflow-y': 'auto', 'position': 'static'});
                    });


                    //$navHeader.css({'max-height': '220px'});

                }, 1500);

                var $navHeader = $('.nav-bar--long');

                var minHeight = parseInt($navHeader.css('min-height'));
                var height = parseInt($navHeader.css('height')) * (30 / 100);
                height = height < minHeight ? minHeight : height;
                //$('main#section').css({'margin-top': (height ) + 'px'});
            }
        });

        //////////////////////////////////
        //    Scroll To show Shadow
        ///////////////////////////////////
        $(window).scroll(function () {
            if ($('.nav-bar--has-shadow-element').length == 0) {
                return;
            }

            var y = $(window).scrollTop();
            var $navShadow = $(".nav-bar__nav-shadow");
            var opacity = y / 100 > 1 ? 1 : y / 100;
            if (y > 0) {
                $navShadow.css({
                    'display': 'block',
                    'opacity': opacity
                });
            } else {
                $navShadow.css({
                    'display': 'block',
                    'opacity': opacity
                });
            }


        });

        $(window).scroll(function () {
            if ($('.logo--hidden').length == 0) {
                return;
            }
            var y = $(window).scrollTop();
            var opacity = y / 100 > 1 ? 1 : y / 100;
            if (y > 0) {
                $(".logo").css({
                    'display': 'block',
                    'opacity': opacity
                });
            } else {
                $(".logo").css({
                    'display': 'block',
                    'opacity': opacity
                });
            }
        });
        //////////////////////////////////
        //    Scroll to fade out
        ///////////////////////////////////
        var fadeStart = 0; // 100px scroll or less will equiv to 1 opacity
        var fadeUntil = 100; // 200px scroll or more will equiv to 0 opacity
        var fading = $('.nav-bar__title');

        $(window).bind('scroll', function () {
            if ($('.nav-bar--long').length == 0) {
                return;
            }
            var offset = $(document).scrollTop();
            var opacity = 0;

            if (offset <= fadeStart) {
                opacity = 1;
            } else if (offset <= fadeUntil) {
                opacity = 1 - offset / fadeUntil;
            }
            fading.css('opacity', opacity);
        });

    }

};
var Widget = function () {
    return {
        init: initialize
    };

    function initialize() {
        var $widget = $('.widget:not(.widget-active):not(.widget-slider .nav-left)');
        var $ripple = $('.sidebar-animation .ripple');
        var $activeWidget = $('.widget-active');
        var $widgetSlider = $('.widget-slider');
        var $closeButton = $('.widget-active .btn-close');
        var inProgress = false;

        $widget.each(function (index) {
            $(this).attr('id', (index + 1) + 'widget');
        });


        $widgetSlider.find('.nav-left').on('click', function (e) {
            e.preventDefault();
            var currentIndex = parseInt($widgetSlider.attr('id'));

            var previousIndex = currentIndex - 1;

            if (previousIndex < 0) {
                previousIndex = $widget.length;
            }
            var $previous = $('#' + previousIndex + 'widget');
            $widgetSlider.attr('id', previousIndex + 'widgetslider');
            $widgetSlider.find('.title').first().html($previous.find('.title').first().html());
            $widgetSlider.find('.widget-content').first().html($previous.find('.widget-content').first().html());
        });

        $widgetSlider.find('.nav-right').on('click', function (e) {
            e.preventDefault();
            var currentIndex = parseInt($widgetSlider.attr('id'));
            var nextIndex = currentIndex + 1;
            if (nextIndex >= $widget.length - 1) {
                nextIndex = 0;
            }
            var $next = $('#' + nextIndex + 'widget');

            $widgetSlider.attr('id', nextIndex + 'widgetslider');
            $widgetSlider.find('.title').first().html($next.find('.title').first().html());
            $widgetSlider.find('.widget-content').first().html($next.find('.widget-content').first().html());
        });


        $widget.on('click', function (e) {
            e.preventDefault();
            var $clicked = $(this);
            var currentIndex = parseInt($clicked.attr('id'));
            var nextIndex = currentIndex + 1;

            if (nextIndex >= $widget.length - 1) {
                nextIndex = 0;
            }

            var $next = $('#' + nextIndex + 'widget');
            $widgetSlider.attr('id', nextIndex + 'widgetslider');
            $activeWidget.attr('id', nextIndex + 'widgetactive');

            if (inProgress) {
                return;
            }

            var posX = $(this).parent().offset().left,
                posY = $(this).parent().offset().top;
            var clickedPoint = {x: e.pageX - posX, y: e.pageY - posY};

            $ripple.eq(1).css({'background': $(this).css('background-color')});
            $ripple.css({
                'top': clickedPoint.y - ($ripple.innerWidth() / 2) + 15 + 'px',
                'left': clickedPoint.x - ($ripple.innerWidth() / 2) + 15 + 'px'
            });
            $ripple.addClass('z-5');
            $activeWidget.css({'background': $(this).css('background-color')});

            var sequence = [];
            var s1 = {
                e: $ripple[0],
                p: {
                    opacity: 1,
                    scale: 30
                },
                o: {
                    begin: function (elements) {
                        $(elements).css({'opacity': .5})
                    }
                }
            };

            var s2 = {
                e: $ripple[1],
                p: {
                    opacity: 1,
                    scale: 30
                },
                o: {
                    sequenceQueue: false,
                    delay: 100,
                    begin: function (elements) {
                        $(elements).css({'opacity': .5})
                    },
                    complete: function (elements) {
                        $widget.hide();
                        //$activeWidget.show();
                        $widgetSlider.show();
                    },
                    easing: "easeInSine",
                    duration: 600
                }
            };

            var widgetActive = {
                e: $activeWidget,
                //'transition.slideDownIn'
                p: {opacity: 1},
                o: {
                    easing: "ease", display: 'block',
                    complete: function (elements) {
                        // setup active widget
                        $activeWidget.find('.title').first().html($clicked.find('.title').first().html());
                        $activeWidget.find('.content .description').first().html($clicked.find('.widget-content').first().html());

                        // setup widget slider
                        $widgetSlider.find('.title').first().html($next.find('.title').first().html());
                        $widgetSlider.find('.widget-content').first().html($next.find('.widget-content').first().html());
                        $widgetSlider.css({'background': $next.css('background-color')});
                    }
                }
            };

            var sReverse = {
                e: $ripple,
                p: {opacity: 0},
                o: {
                    delay: 200,
                    easing: "easeInSine",
                    complete: function (elements) {
                        $(elements).removeClass('z-5');
                        $(elements).removeAttr('style');
                    }
                }
            };

            var after = {
                e: $closeButton,
                p: {bottom: 0},
                o: {easing: "ease"}
            };

            var after1 = {
                e: $closeButton,
                p: {rotateZ: 0},
                o: {easing: "ease", delay: 200}
            };

            sequence.push(s1);
            sequence.push(s2);
            sequence.push(widgetActive);
            sequence.push(sReverse);
            sequence.push(after);
            sequence.push(after1);
            $.Velocity.RunSequence(sequence);
        });

    }
};
var Common = function () {

    return {
        flowText: flowText,
        scrollUp: scrollUp
    };

    function flowText(elementClass, length) {
        elementClass = elementClass || 'flow-text';
        length = length || 45;
        $('.' + elementClass).each(function (index) {
            var text = $(this).text();
            var len = text.length;
            if (len > length) {
                text = text.substr(0, length) + '...';
            }
            $(this).text(text);
        });
    }

    function scrollUp(elementClass, trashold, fadeInSpeed, scrollSpeed) {
        elementClass = elementClass || 'scroll-up';
        fadeInSpeed = fadeInSpeed || 300;
        trashold = parseInt(trashold) || 300;
        scrollSpeed = parseInt(scrollSpeed) || 400;

        var $element = $('.' + elementClass);
        $element.click(function (e) {
            e.preventDefault();
            $('html, body').animate({scrollTop: 0}, scrollSpeed);
            return false;
        });

        $(window).scroll(function () {
            if ($(this).scrollTop() > trashold) {
                $element.stop(true).fadeIn(fadeInSpeed);
            } else {
                $element.stop(true).fadeOut(fadeInSpeed);
            }
        });
    }
};
var Util = function () {
    return {
        waveLink: waveLink
    };

    function waveLink() {
        $('.wave-link').each(function () {
            var $element = $(this);
            $element.on('click', function (e) {
                e.preventDefault();
                setTimeout(function () {
                    var href = $element.find('a.wave-href').attr('href')
                        || $element.parent().find('a.wave-href').attr('href') || $element.parent()
                            .parent().find('a.wave-href').attr('href');

                    console.log(href);
                    location.href = href;
                }, 100);
            })
        });
    }
};

var preloader = new Preloader();
var widget = new Widget();
var common = new Common();
var util = new Util();
var colorThief = new ColorThief();

function relatedPostColor() {
    var cards = $('.related-wrapper .card');
    if (cards.length == 2) {
        var images = [];
        var sourceImage = null;
        var color;
        var $card;

        images[0] = $(cards[0]).css('background-image').replace('url(', '').replace(')', '');

        images[1] = $(cards[1]).css('background-image').replace('url(', '').replace(')', '');


        if (images[0] == 'none' && images[1] != 'none') {
            sourceImage = images[1];
            $card = cards.eq(0);
        } else if (images[1] == 'none' && images[0] != 'none') {
            sourceImage = images[0];
            $card = cards.eq(1);
        }

        if (sourceImage != null) {
            var img = document.createElement('img');
            img.onload = function () {
                var color = 'rgba(' + colorThief.getColor(img) + ',.9)';
                console.log(color);
                $card.css({'background-color': color})
            };
            img.src = sourceImage.replace(/["']/g, "");
        } else {
            //cards.eq(0).css({'background-color': 'rgb(96, 125, 139)'});
            //cards.eq(1).css({'background-color': 'rgb(96, 125, 139)'});
        }
    }
}

function imagePostColor() {
    $imageArticle = $('article.post-single.format-image');
    $imageArticleImage = $imageArticle.find('img').first();

    if ($imageArticle.length == 1) {
        sourceImage = $imageArticleImage.attr('src');
        img = document.createElement('img');
        img.onload = function () {
            var color = colorThief.getColor(img);
            console.log(color);
            $imageArticle.css({'background-color': 'rgba(' + color + ',.9)'});
            var border = '1px solid rgba(' + (color[0] + 1) + ',' + (color[1] + 1) + ',' + (color[2] + 1) + ', .3)';
            $imageArticleImage.css({'border': border});
        };
        img.src = sourceImage.replace(/["']/g, "");
    }
}

relatedPostColor();
imagePostColor();

$('.parallax').parallax();
$('.button--mobile-menu').sideNav();

$('.comment-reply-link').on('click', function (e) {
    $('#cancel-comment-reply-link').addClass('waves-effect waves-light btn btn-small right');
});

$('#cancel-comment-reply-link').on('click', function (e) {
    $(this).removeClass('waves-effect waves-light btn btn-small right');
    //$('.comment__form .card-panel').last().fadeIn();
});

window.onload = function () {
    // Intensify all images with the 'intense' classname.
    //var elements = document.querySelectorAll('.intense');
    //var element = document.querySelector('img');
    //Intense(element);
    $(".menu-item-has-children").dropdown();
};

$('.menu-item-has-children').on('click', function () {
    $(this).addClass('open');
});

$(document).ready(function () {
    //$('.magnific-gallery').each(function (index, value) {
    var $gallery = $('.magnific-gallery');

    $gallery.magnificPopup({
        mainClass: 'mfp-with-zoom',
        delegate: "a",
        type: "image",
        fixedContentPos: true,
        fixedBgPos: true,
        tLoading: "Loading image #%curr%...",
        removalDelay: 400,
        closeBtnInside: true,
        zoom: {
            enabled: true,
            duration: 500
        },
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0, 1]
        },
        image: {
            titleSrc: function (item) {
                var id = $(item.el).find('img').first().attr('aria-describedby');

                return id !== undefined ? $('figurecaption#' + id).text() : '';
                //return item.el.attr('title') + '<small>by Marsel Van Oosten</small>';
            },
            tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
        }
    });
    //});
});

common.scrollUp();
preloader.init();
//widget.init();
util.waveLink();

$(document).ready(function () {
    var $card = $('.card--3d'),
        cardWidth = $card.innerWidth(),
        cardHeight = $card.innerHeight();

    $card.mouseleave(function (event) {
        //$(this).removeAttr('style');
        $(this).css({
            "transform": ""
        });
        //$(this).css({
        //    "transform": "rotateY(0deg) rotateX(0deg) translateZ(1px)"
        //    // 'background-position': (120 + (mouseFromCenter.x / degreesW)) + '%' + ' 50%'
        //});
    });

    $card.mousemove(function (event) {
        var sensitivity = 10,
            degreesW = cardWidth / sensitivity,
            degreesH = cardHeight / sensitivity,
            mousePos = {
                x: 0,
                y: 0
            },
            mouseFromCenter = {
                x: 0,
                y: 0
            };

        mousePos.x = event.pageX - $(this).offset().left;
        mouseFromCenter.x = mousePos.x - (cardWidth / 2);
        mousePos.y = event.pageY - $(this).offset().top;
        mouseFromCenter.y = mousePos.y - (cardHeight / 2);
        // background image movement
        $(this).css({
            "transform": "rotateY(" + (mouseFromCenter.x / degreesW) + "deg) rotateX(" + ((mouseFromCenter.y / degreesH) * -1) + "deg) translateZ(50px)",
            "transform-style": "preserve-3d"
            // 'background-position': (120 + (mouseFromCenter.x / degreesW)) + '%' + ' 50%'
        });

    });
})
;