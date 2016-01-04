define(['jquery'], function ($) {

    var initialize = function () {
        var $widget = $('.widget:not(.widget-active):not(.widget-slider .nav-left)');
        var $ripple = $('.sidebar-animation .ripple');
        var $activeWidget = $('.widget-active');
        var $widgetSlider = $('.widget-slider');
        var $closeButton = $('.widget-active .btn-close');
        var inProgress = false;

        $widget.each(function (index) {
            $(this).attr('id', (index) + 'widget');
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

    };

    return {
        initialize: initialize
    }
});