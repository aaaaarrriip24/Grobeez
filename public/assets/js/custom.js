$(document).ready(function () {

    /*------------------------------------- testimonial Section Start-------------------------------------*/
    $('.testimonial_slider').slick({
        dots: false,
        arrows: true,
        infinite: true,
        autoplay: false,
        speed: 300,
        slidesToShow: 1,
        slidesToScroll: 1,
        nextArrow: '<div class="slick-custom-arrow slick-custom-arrow-right"><i class="fas fa-angle-right"></i></div>',
        prevArrow: '<div class="slick-custom-arrow slick-custom-arrow-left"><i class="fa fa-angle-left"></i></div>',
    });

    /*------------------------------------- Logo Section Start-------------------------------------*/
    $('.logo_slider').slick({
        dots: false,
        arrows: false,
        infinite: true,
        autoplay: true,
        speed: 300,
        slidesToShow: 5,
        slidesToScroll: 1,
        responsive: [{
                breakpoint: 1440,
                settings: {
                    slidesToShow: 5,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 1280,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

    /*-------------------------------------  Scroll Bottom to top Event-------------------------------------*/
    $(window).scroll(function () {
        if ($(this).scrollTop() >= 50) {
            $('.scroll-top').fadeIn(200);
        } else {
            $('.scroll-top').fadeOut(200);
        }
    });
    $('.scroll-top').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 500);
    });

    /*-------------------------------------  Sticky Header-------------------------------------*/
    $(window).scroll(function () {
        if ($(window).scrollTop() >= 20) {
            $('#header_sec').addClass('fixed');
        } else {
            $('#header_sec').removeClass('fixed');
        }
    });
});

/*-------------------------------------  AOS Animation-------------------------------------*/
// Animate On Scroll 
AOS.init({
    duration: 1000,
    delay: 400
});

AOS.init();

$(window).on('load', function () {
    AOS.refresh();
});

// Disable AOS Library Below 800 Pixel Screen Size
AOS.init({
    disable: function () {
        var maxWidth = 1440;
        return window.innerWidth < maxWidth;
    }
});

// To Work Only One Time At A Screen Scroll
AOS.init({
    once: true
});

/*------------------------------------- Tilt Animation -------------------------------------*/
$('.tilt-img').tilt({
    glare: true,
    maxGlare: .5
})

/*------------------------------------- Progress Bar Section Start-------------------------------------*/
$(function () {
    function isScrolledIntoView($elem) {
        var docViewTop = $(window).scrollTop();
        var docViewBottom = docViewTop + $(window).height();
        var elemTop = $elem.offset().top;
        var elemBottom = elemTop + $elem.height();
        return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
    }

    function count($this) {
        var current = parseInt($this.html(), 10);
        if (isScrolledIntoView($this) && !$this.data("isCounting") && current < $this.data('count')) {
            $this.html(++current);
            $this.data("isCounting", true);
            setTimeout(function () {
                $this.data("isCounting", false);
                count($this);
            }, 20);
        }
    }
    $(".c-counter").each(function () {
        $(this).data('count', parseInt($(this).html(), 10));
        $(this).html('0');
        $(this).data("isCounting", false);
    });

    function startCount() {
        $(".c-counter").each(function () {
            count($(this));
        });
    };
    $(window).scroll(function () {
        startCount();
    });
    startCount();
});

/*-------------------------------------Counter Section-------------------------------------*/
$.fn.jQuerySimpleCounter = function (options) {
    var settings = $.extend({
        start: 0,
        end: 100,
        easing: 'swing',
        duration: 400,
        complete: ''
    }, options);

    var thisElement = $(this);

    $({
        count: settings.start
    }).animate({
        count: settings.end
    }, {
        duration: settings.duration,
        easing: settings.easing,
        step: function () {
            var mathCount = Math.ceil(this.count);
            thisElement.text(mathCount);
        },
        complete: settings.complete
    });
};

$('#number1').jQuerySimpleCounter({
    end: 5,
    duration: 2500
});
$('#number2').jQuerySimpleCounter({
    end: 504,
    duration: 2000
});
$('#number3').jQuerySimpleCounter({
    end: 200,
    duration: 2000
});
$('#number4').jQuerySimpleCounter({
    end: 80,
    duration: 2000
});

/*-------------------------------------Specific Function-------------------------------------*/
function reveal() {
    var reveals = document.querySelectorAll(".reveal");

    for (var i = 0; i < reveals.length; i++) {
        var windowHeight = window.innerHeight;
        var elementTop = reveals[i].getBoundingClientRect().top;
        var elementVisible = 150;
        if (elementTop < windowHeight - elementVisible) {
            reveals[i].classList.add("active");
        } else {
            reveals[i].classList.remove("active");
        }
    }
}
window.addEventListener("scroll", reveal);

/*-------------------------------------WOW Animation-------------------------------------*/
new WOW().init();


/*-------------------------------------Scroll on active section-------------------------------------*/
$(document).ready(function () {
    $(document).on("scroll", onScroll);

    //smoothscroll
    $('a[href^="#"]').on('click', function (e) {
        e.preventDefault();
        $(document).off("scroll");

        $('.nav-link').each(function () {
            $(this).removeClass('active');
        })
        $(this).addClass('active');

        var target = this.hash,
            menu = target;
        $target = $(target);
        $('html, body').stop().animate({
            'scrollTop': $target.offset().top + 2
        }, 500, 'swing', function () {
            window.location.hash = target;
            $(document).on("scroll", onScroll);
        });
    });
});

function onScroll(event) {
    var scrollPos = $(document).scrollTop();
    $('.nav-link').each(function () {
        var currLink = $(this);
        var refElement = $(currLink.attr("href"));
        if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
            $('.nav-link').removeClass("active");
            currLink.addClass("active");
        } else {
            currLink.removeClass("active");
        }
    });
}
