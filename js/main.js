/* -------------------------------------------

Name: 		ABSoftz_BoardStory
Version:    1.0
Developer:	Akshay Bankapure(ABSoftz)
Portfolio:  https://absoftz.in

p.s. I am available for Freelance hire (UI design, web development). email: akshay.bankapure@gmail.com

------------------------------------------- */

$(function () {

    "use strict";

    /***************************

    swup

    ***************************/
    const options = {
        containers: ['#swupMain'],
        animateHistoryBrowsing: true,
        linkSelector: 'a:not([data-no-swup])',
        animationSelector: '[class="absoftz-main-transition"]',
        cache: true
    };
    // const options = {
    //     containers: ['#swupMain', '#swupMenu'],
    //     animateHistoryBrowsing: true,
    //     linkSelector: 'a:not([data-no-swup])',
    //     animationSelector: '[class="absoftz-main-transition"]'
    // };
    const swup = new Swup(options);

    

    /***************************

    register gsap plugins

    ***************************/
    gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);
    /***************************

    color variables

    ***************************/

    var accent = 'rgba(255, 152, 0, 1)';
    var dark = '#000';
    var light = '#fff';

    /***************************

    preloader
    
    ***************************/

    var timeline = gsap.timeline();

    timeline.to(".absoftz-preloader-animation", {
        opacity: 1,
    });

    timeline.fromTo(
        ".absoftz-animation-1 .absoftz-h3", {
            y: "30px",
            opacity: 0
        }, {
            y: "0px",
            opacity: 1,
            stagger: 0.4
        },
    );

    timeline.to(".absoftz-animation-1 .absoftz-h3", {
        opacity: 0,
        y: '-30',
    }, "+=.3");

    timeline.fromTo(".absoftz-reveal-box", 0.1, {
        opacity: 0,
    }, {
        opacity: 1,
        x: '-30',
    });

    timeline.to(".absoftz-reveal-box", 0.45, {
        width: "100%",
        x: 0,
    }, "+=.1");
    timeline.to(".absoftz-reveal-box", {
        right: "0"
    });
    timeline.to(".absoftz-reveal-box", 0.3, {
        width: "0%"
    });
    timeline.fromTo(".absoftz-animation-2 .absoftz-h3", {
        opacity: 0,
    }, {
        opacity: 1,
    }, "-=.5");
    timeline.to(".absoftz-animation-2 .absoftz-h3", 0.6, {
        opacity: 0,
        y: '-30'
    }, "+=.5");
    timeline.to(".absoftz-preloader", 0.8, {
        opacity: 0,
        ease: 'sine',
    }, "+=.2");
    timeline.fromTo(".absoftz-up", 0.8, {
        opacity: 0,
        y: 40,
        scale: .98,
        ease: 'sine',

    }, {
        y: 0,
        opacity: 1,
        scale: 1,
        onComplete: function () {
            $('.absoftz-preloader').addClass("absoftz-hidden");
        },
    }, "-=1");



    /***************************

    anchor scroll

    ***************************/
    $(document).on('click', 'a[href^="#"]', function (event) {
        event.preventDefault();

        var target = $($.attr(this, 'href'));
        var offset = 0;

        if ($(window).width() < 1200) {
            offset = 90;
        }

        $('html, body').animate({
            scrollTop: target.offset().top - offset
        }, 400);
    });
    /***************************

    append

    ***************************/
    $(document).ready(function () {
        $(".absoftz-arrow").clone().appendTo(".absoftz-arrow-place");
        $(".absoftz-dodecahedron").clone().appendTo(".absoftz-animation");
        $(".absoftz-lines").clone().appendTo(".absoftz-lines-place");
        $(".absoftz-main-menu ul li.absoftz-active > a").clone().appendTo(".absoftz-current-page");
    });
    /***************************

    accordion

    ***************************/

    let groups = gsap.utils.toArray(".absoftz-accordion-group");
    let menus = gsap.utils.toArray(".absoftz-accordion-menu");
    let menuToggles = groups.map(createAnimation);

    menus.forEach((menu) => {
        menu.addEventListener("click", () => toggleMenu(menu));
    });

    function toggleMenu(clickedMenu) {
        menuToggles.forEach((toggleFn) => toggleFn(clickedMenu));
    }

    function createAnimation(element) {
        let menu = element.querySelector(".absoftz-accordion-menu");
        let box = element.querySelector(".absoftz-accordion-content");
        let symbol = element.querySelector(".absoftz-symbol");
        let minusElement = element.querySelector(".absoftz-minus");
        let plusElement = element.querySelector(".absoftz-plus");

        gsap.set(box, {
            height: "auto",
        });

        let animation = gsap
            .timeline()
            .from(box, {
                height: 0,
                duration: 0.4,
                ease: "sine"
            })
            .from(minusElement, {
                duration: 0.4,
                autoAlpha: 0,
                ease: "none",
            }, 0)
            .to(plusElement, {
                duration: 0.4,
                autoAlpha: 0,
                ease: "none",
            }, 0)
            .to(symbol, {
                background: accent,
                ease: "none",
            }, 0)
            .reverse();

        return function (clickedMenu) {
            if (clickedMenu === menu) {
                animation.reversed(!animation.reversed());
            } else {
                animation.reverse();
            }
        };
    }
    /***************************

    back to top

    ***************************/
    const btt = document.querySelector(".absoftz-back-to-top .absoftz-link");

    gsap.set(btt, {
        x: -30,
        opacity: 0,
    });

    gsap.to(btt, {
        x: 0,
        opacity: 1,
        ease: 'sine',
        scrollTrigger: {
            trigger: "body",
            start: "top -40%",
            end: "top -40%",
            toggleActions: "play none reverse none"
        }
    });
    /***************************

    cursor

    ***************************/
    const cursor = document.querySelector('.absoftz-ball');

    gsap.set(cursor, {
        xPercent: -50,
        yPercent: -50,
    });

    document.addEventListener('pointermove', movecursor);

    function movecursor(e) {
        gsap.to(cursor, {
            duration: 0.6,
            ease: 'sine',
            x: e.clientX,
            y: e.clientY,
        });
    }

    $('.absoftz-drag, .absoftz-more, .absoftz-choose').mouseover(function () {
        gsap.to($(cursor), .2, {
            width: 90,
            height: 90,
            opacity: 1,
            ease: 'sine',
        });
    });

    $('.absoftz-drag, .absoftz-more, .absoftz-choose').mouseleave(function () {
        gsap.to($(cursor), .2, {
            width: 20,
            height: 20,
            opacity: .1,
            ease: 'sine',
        });
    });

    $('.absoftz-accent-cursor').mouseover(function () {
        gsap.to($(cursor), .2, {
            background: accent,
            ease: 'sine',
        });
        $(cursor).addClass('absoftz-accent');
    });

    $('.absoftz-accent-cursor').mouseleave(function () {
        gsap.to($(cursor), .2, {
            background: dark,
            ease: 'sine',
        });
        $(cursor).removeClass('absoftz-accent');
    });

    $('.absoftz-drag').mouseover(function () {
        gsap.to($('.absoftz-ball .absoftz-icon-1'), .2, {
            scale: '1',
            ease: 'sine',
        });
    });

    $('.absoftz-drag').mouseleave(function () {
        gsap.to($('.absoftz-ball .absoftz-icon-1'), .2, {
            scale: '0',
            ease: 'sine',
        });
    });

    $('.absoftz-more').mouseover(function () {
        gsap.to($('.absoftz-ball .absoftz-more-text'), .2, {
            scale: '1',
            ease: 'sine',
        });
    });

    $('.absoftz-more').mouseleave(function () {
        gsap.to($('.absoftz-ball .absoftz-more-text'), .2, {
            scale: '0',
            ease: 'sine',
        });
    });

    $('.absoftz-choose').mouseover(function () {
        gsap.to($('.absoftz-ball .absoftz-choose-text'), .2, {
            scale: '1',
            ease: 'sine',
        });
    });

    $('.absoftz-choose').mouseleave(function () {
        gsap.to($('.absoftz-ball .absoftz-choose-text'), .2, {
            scale: '0',
            ease: 'sine',
        });
    });

    $('a:not(".absoftz-choose , .absoftz-more , .absoftz-drag , .absoftz-accent-cursor"), input , textarea, .absoftz-accordion-menu').mouseover(function () {
        gsap.to($(cursor), .2, {
            scale: 0,
            ease: 'sine',
        });
        gsap.to($('.absoftz-ball svg'), .2, {
            scale: 0,
        });
    });

    $('a:not(".absoftz-choose , .absoftz-more , .absoftz-drag , .absoftz-accent-cursor"), input, textarea, .absoftz-accordion-menu').mouseleave(function () {
        gsap.to($(cursor), .2, {
            scale: 1,
            ease: 'sine',
        });

        gsap.to($('.absoftz-ball svg'), .2, {
            scale: 1,
        });
    });

    $('body').mousedown(function () {
        gsap.to($(cursor), .2, {
            scale: .1,
            ease: 'sine',
        });
    });
    $('body').mouseup(function () {
        gsap.to($(cursor), .2, {
            scale: 1,
            ease: 'sine',
        });
    });
    /***************************

     menu

    ***************************/
    $('.absoftz-menu-btn').on("click", function () {
        $('.absoftz-menu-btn').toggleClass('absoftz-active');
        $('.absoftz-menu').toggleClass('absoftz-active');
        $('.absoftz-menu-frame').toggleClass('absoftz-active');
    });
    /***************************

    main menu

    ***************************/
    $('.absoftz-has-children a').on('click', function () {
        $('.absoftz-has-children ul').removeClass('absoftz-active');
        $('.absoftz-has-children a').removeClass('absoftz-active');
        $(this).toggleClass('absoftz-active');
        $(this).next().toggleClass('absoftz-active');
    });
    /***************************

    progressbar

    ***************************/
    gsap.to('.absoftz-progress', {
        height: '100%',
        ease: 'sine',
        scrollTrigger: {
            scrub: 0.3
        }
    });
    /***************************

    scroll animations

    ***************************/

    const appearance = document.querySelectorAll(".absoftz-up");

    appearance.forEach((section) => {
        gsap.fromTo(section, {
            opacity: 0,
            y: 40,
            scale: .98,
            ease: 'sine',

        }, {
            y: 0,
            opacity: 1,
            scale: 1,
            duration: .4,
            scrollTrigger: {
                trigger: section,
                toggleActions: 'play none none reverse',
            }
        });
    });

    const scaleImage = document.querySelectorAll(".absoftz-scale");

    scaleImage.forEach((section) => {
        var value1 = $(section).data("value-1");
        var value2 = $(section).data("value-2");
        gsap.fromTo(section, {
            ease: 'sine',
            scale: value1,

        }, {
            scale: value2,
            scrollTrigger: {
                trigger: section,
                scrub: true,
                toggleActions: 'play none none reverse',
            }
        });
    });

    const parallaxImage = document.querySelectorAll(".absoftz-parallax");


    if ($(window).width() > 960) {
        parallaxImage.forEach((section) => {
            var value1 = $(section).data("value-1");
            var value2 = $(section).data("value-2");
            gsap.fromTo(section, {
                ease: 'sine',
                y: value1,

            }, {
                y: value2,
                scrollTrigger: {
                    trigger: section,
                    scrub: true,
                    toggleActions: 'play none none reverse',
                }
            });
        });
    }

    const rotate = document.querySelectorAll(".absoftz-rotate");

    rotate.forEach((section) => {
        var value = $(section).data("value");
        gsap.fromTo(section, {
            ease: 'sine',
            rotate: 0,

        }, {
            rotate: value,
            scrollTrigger: {
                trigger: section,
                scrub: true,
                toggleActions: 'play none none reverse',
            }
        });
    });
    /***************************

    fancybox

    ***************************/
    $('[data-fancybox="gallery"]').fancybox({
        buttons: [
            "slideShow",
            "zoom",
            "fullScreen",
            "close"
          ],
        loop: false,
        protect: true
    });
    $.fancybox.defaults.hash = false;
    /***************************

    reviews slider

    ***************************/

    var menu = ['<div class="absoftz-custom-dot absoftz-slide-1"></div>', '<div class="absoftz-custom-dot absoftz-slide-2"></div>', '<div class="absoftz-custom-dot absoftz-slide-3"></div>', '<div class="absoftz-custom-dot absoftz-slide-4"></div>', '<div class="absoftz-custom-dot absoftz-slide-5"></div>', '<div class="absoftz-custom-dot absoftz-slide-6"></div>', '<div class="absoftz-custom-dot absoftz-slide-7"></div>']
    var mySwiper = new Swiper('.absoftz-reviews-slider', {
        // If we need pagination
        pagination: {
            el: '.absoftz-revi-pagination',
            clickable: true,
            renderBullet: function (index, className) {
                return '<span class="' + className + '">' + (menu[index]) + '</span>';
            },
        },
        speed: 800,
        effect: 'fade',
        parallax: true,
        navigation: {
            nextEl: '.absoftz-revi-next',
            prevEl: '.absoftz-revi-prev',
        },
    })

    /***************************

    infinite slider

    ***************************/
    var swiper = new Swiper('.absoftz-infinite-show', {
        slidesPerView: 2,
        spaceBetween: 30,
        speed: 5000,
        autoplay: true,
        autoplay: {
            delay: 0,
        },
        loop: true,
        freeMode: true,
        breakpoints: {
            992: {
                slidesPerView: 4,
            },
        },
    });
    

    /***************************

    portfolio slider

    ***************************/
    var swiper = new Swiper('.absoftz-portfolio-slider', {
        slidesPerView: 1,
        spaceBetween: 0,
        speed: 800,
        parallax: true,
        mousewheel: {
            enable: true
        },
        navigation: {
            nextEl: '.absoftz-portfolio-next',
            prevEl: '.absoftz-portfolio-prev',
        },
        pagination: {
            el: '.swiper-portfolio-pagination',
            type: 'fraction',
        },
    });
    /***************************

    1 item slider

    ***************************/
    var swiper = new Swiper('.absoftz-1-slider', {
        slidesPerView: 1,
        spaceBetween: 30,
        speed: 800,
        parallax: true,
        navigation: {
            nextEl: '.absoftz-portfolio-next',
            prevEl: '.absoftz-portfolio-prev',
        },
        pagination: {
            el: '.swiper-portfolio-pagination',
            type: 'fraction',
        },
    });
    /***************************

    2 item slider

    ***************************/
    var swiper = new Swiper('.absoftz-2-slider', {
        slidesPerView: 1,
        spaceBetween: 30,
        speed: 800,
        parallax: true,
        navigation: {
            nextEl: '.absoftz-portfolio-next',
            prevEl: '.absoftz-portfolio-prev',
        },
        pagination: {
            el: '.swiper-portfolio-pagination',
            type: 'fraction',
        },
        breakpoints: {
            992: {
                slidesPerView: 2,
            },
        },
    });

    /*----------------------------------------------------------
    ------------------------------------------------------------

    REINIT

    ------------------------------------------------------------
    ----------------------------------------------------------*/

    
    document.addEventListener("swup:contentReplaced", function () {
        if (!sessionStorage.getItem("menuLoaded")) {
            loadHTML("menu.html", "dynamicMenu");
            sessionStorage.setItem("menuLoaded", "true");
        }
        $('html, body').animate({
            scrollTop: 0,
        }, 0);

        gsap.to('.absoftz-progress', {
            height: 0,
            ease: 'sine',
            onComplete: () => {
                ScrollTrigger.refresh()
            },
        });
        /***************************

         menu

        ***************************/
        $('.absoftz-menu-btn').removeClass('absoftz-active');
        $('.absoftz-menu').removeClass('absoftz-active');
        $('.absoftz-menu-frame').removeClass('absoftz-active');
        /***************************

        append

        ***************************/
        $(document).ready(function () {
            $(".absoftz-arrow-place .absoftz-arrow, .absoftz-animation .absoftz-dodecahedron, .absoftz-current-page a").remove();
            $(".absoftz-arrow").clone().appendTo(".absoftz-arrow-place");
            $(".absoftz-dodecahedron").clone().appendTo(".absoftz-animation");
            $(".absoftz-lines").clone().appendTo(".absoftz-lines-place");
            $(".absoftz-main-menu ul li.absoftz-active > a").clone().appendTo(".absoftz-current-page");
        });
        /***************************

        accordion

        ***************************/

        let groups = gsap.utils.toArray(".absoftz-accordion-group");
        let menus = gsap.utils.toArray(".absoftz-accordion-menu");
        let menuToggles = groups.map(createAnimation);

        menus.forEach((menu) => {
            menu.addEventListener("click", () => toggleMenu(menu));
        });

        function toggleMenu(clickedMenu) {
            menuToggles.forEach((toggleFn) => toggleFn(clickedMenu));
        }

        function createAnimation(element) {
            let menu = element.querySelector(".absoftz-accordion-menu");
            let box = element.querySelector(".absoftz-accordion-content");
            let symbol = element.querySelector(".absoftz-symbol");
            let minusElement = element.querySelector(".absoftz-minus");
            let plusElement = element.querySelector(".absoftz-plus");

            gsap.set(box, {
                height: "auto",
            });

            let animation = gsap
                .timeline()
                .from(box, {
                    height: 0,
                    duration: 0.4,
                    ease: "sine"
                })
                .from(minusElement, {
                    duration: 0.4,
                    autoAlpha: 0,
                    ease: "none",
                }, 0)
                .to(plusElement, {
                    duration: 0.4,
                    autoAlpha: 0,
                    ease: "none",
                }, 0)
                .to(symbol, {
                    background: accent,
                    ease: "none",
                }, 0)
                .reverse();

            return function (clickedMenu) {
                if (clickedMenu === menu) {
                    animation.reversed(!animation.reversed());
                } else {
                    animation.reverse();
                }
            };
        }

        /***************************

        cursor

        ***************************/

        $('.absoftz-drag, .absoftz-more, .absoftz-choose').mouseover(function () {
            gsap.to($(cursor), .2, {
                width: 90,
                height: 90,
                opacity: 1,
                ease: 'sine',
            });
        });

        $('.absoftz-drag, .absoftz-more, .absoftz-choose').mouseleave(function () {
            gsap.to($(cursor), .2, {
                width: 20,
                height: 20,
                opacity: .1,
                ease: 'sine',
            });
        });

        $('.absoftz-accent-cursor').mouseover(function () {
            gsap.to($(cursor), .2, {
                background: accent,
                ease: 'sine',
            });
            $(cursor).addClass('absoftz-accent');
        });

        $('.absoftz-accent-cursor').mouseleave(function () {
            gsap.to($(cursor), .2, {
                background: dark,
                ease: 'sine',
            });
            $(cursor).removeClass('absoftz-accent');
        });

        $('.absoftz-drag').mouseover(function () {
            gsap.to($('.absoftz-ball .absoftz-icon-1'), .2, {
                scale: '1',
                ease: 'sine',
            });
        });

        $('.absoftz-drag').mouseleave(function () {
            gsap.to($('.absoftz-ball .absoftz-icon-1'), .2, {
                scale: '0',
                ease: 'sine',
            });
        });

        $('.absoftz-more').mouseover(function () {
            gsap.to($('.absoftz-ball .absoftz-more-text'), .2, {
                scale: '1',
                ease: 'sine',
            });
        });

        $('.absoftz-more').mouseleave(function () {
            gsap.to($('.absoftz-ball .absoftz-more-text'), .2, {
                scale: '0',
                ease: 'sine',
            });
        });

        $('.absoftz-choose').mouseover(function () {
            gsap.to($('.absoftz-ball .absoftz-choose-text'), .2, {
                scale: '1',
                ease: 'sine',
            });
        });

        $('.absoftz-choose').mouseleave(function () {
            gsap.to($('.absoftz-ball .absoftz-choose-text'), .2, {
                scale: '0',
                ease: 'sine',
            });
        });

        $('a:not(".absoftz-choose , .absoftz-more , .absoftz-drag , .absoftz-accent-cursor"), input , textarea, .absoftz-accordion-menu').mouseover(function () {
            gsap.to($(cursor), .2, {
                scale: 0,
                ease: 'sine',
            });
            gsap.to($('.absoftz-ball svg'), .2, {
                scale: 0,
            });
        });

        $('a:not(".absoftz-choose , .absoftz-more , .absoftz-drag , .absoftz-accent-cursor"), input, textarea, .absoftz-accordion-menu').mouseleave(function () {
            gsap.to($(cursor), .2, {
                scale: 1,
                ease: 'sine',
            });

            gsap.to($('.absoftz-ball svg'), .2, {
                scale: 1,
            });
        });

        $('body').mousedown(function () {
            gsap.to($(cursor), .2, {
                scale: .1,
                ease: 'sine',
            });
        });
        $('body').mouseup(function () {
            gsap.to($(cursor), .2, {
                scale: 1,
                ease: 'sine',
            });
        });
        /***************************

        main menu

        ***************************/
        $('.absoftz-has-children a').on('click', function () {
            $('.absoftz-has-children ul').removeClass('absoftz-active');
            $('.absoftz-has-children a').removeClass('absoftz-active');
            $(this).toggleClass('absoftz-active');
            $(this).next().toggleClass('absoftz-active');
        });
        /***************************

        scroll animations

        ***************************/

        const appearance = document.querySelectorAll(".absoftz-up");

        appearance.forEach((section) => {
            gsap.fromTo(section, {
                opacity: 0,
                y: 40,
                scale: .98,
                ease: 'sine',

            }, {
                y: 0,
                opacity: 1,
                scale: 1,
                duration: .4,
                scrollTrigger: {
                    trigger: section,
                    toggleActions: 'play none none reverse',
                }
            });
        });

        const scaleImage = document.querySelectorAll(".absoftz-scale");

        scaleImage.forEach((section) => {
            var value1 = $(section).data("value-1");
            var value2 = $(section).data("value-2");
            gsap.fromTo(section, {
                ease: 'sine',
                scale: value1,

            }, {
                scale: value2,
                scrollTrigger: {
                    trigger: section,
                    scrub: true,
                    toggleActions: 'play none none reverse',
                }
            });
        });

        const parallaxImage = document.querySelectorAll(".absoftz-parallax");


        if ($(window).width() > 960) {
            parallaxImage.forEach((section) => {
                var value1 = $(section).data("value-1");
                var value2 = $(section).data("value-2");
                gsap.fromTo(section, {
                    ease: 'sine',
                    y: value1,

                }, {
                    y: value2,
                    scrollTrigger: {
                        trigger: section,
                        scrub: true,
                        toggleActions: 'play none none reverse',
                    }
                });
            });
        }

        const rotate = document.querySelectorAll(".absoftz-rotate");

        rotate.forEach((section) => {
            var value = $(section).data("value");
            gsap.fromTo(section, {
                ease: 'sine',
                rotate: 0,

            }, {
                rotate: value,
                scrollTrigger: {
                    trigger: section,
                    scrub: true,
                    toggleActions: 'play none none reverse',
                }
            });
        });
        /***************************

        fancybox

        ***************************/
        $('[data-fancybox="gallery"]').fancybox({
            buttons: [
            "slideShow",
            "zoom",
            "fullScreen",
            "close"
          ],
            loop: false,
            protect: true
        });
        $.fancybox.defaults.hash = false;
        /***************************

        reviews slider

        ***************************/

        var menu = ['<div class="absoftz-custom-dot absoftz-slide-1"></div>', '<div class="absoftz-custom-dot absoftz-slide-2"></div>', '<div class="absoftz-custom-dot absoftz-slide-3"></div>', '<div class="absoftz-custom-dot absoftz-slide-4"></div>', '<div class="absoftz-custom-dot absoftz-slide-5"></div>', '<div class="absoftz-custom-dot absoftz-slide-6"></div>', '<div class="absoftz-custom-dot absoftz-slide-7"></div>']
        var mySwiper = new Swiper('.absoftz-reviews-slider', {
            // If we need pagination
            pagination: {
                el: '.absoftz-revi-pagination',
                clickable: true,
                renderBullet: function (index, className) {
                    return '<span class="' + className + '">' + (menu[index]) + '</span>';
                },
            },
            speed: 800,
            effect: 'fade',
            parallax: true,
            navigation: {
                nextEl: '.absoftz-revi-next',
                prevEl: '.absoftz-revi-prev',
            },
        })

        /***************************

        infinite slider

        ***************************/
        var swiper = new Swiper('.absoftz-infinite-show', {
            slidesPerView: 2,
            spaceBetween: 30,
            speed: 5000,
            autoplay: true,
            autoplay: {
                delay: 0,
            },
            loop: true,
            freeMode: true,
            breakpoints: {
                992: {
                    slidesPerView: 4,
                },
            },
        });

        /***************************

        portfolio slider

        ***************************/
        var swiper = new Swiper('.absoftz-portfolio-slider', {
            slidesPerView: 1,
            spaceBetween: 0,
            speed: 800,
            parallax: true,
            mousewheel: {
                enable: true
            },
            navigation: {
                nextEl: '.absoftz-portfolio-next',
                prevEl: '.absoftz-portfolio-prev',
            },
            pagination: {
                el: '.swiper-portfolio-pagination',
                type: 'fraction',
            },
        });
        /***************************

        1 item slider

        ***************************/
        var swiper = new Swiper('.absoftz-1-slider', {
            slidesPerView: 1,
            spaceBetween: 30,
            speed: 800,
            parallax: true,
            navigation: {
                nextEl: '.absoftz-portfolio-next',
                prevEl: '.absoftz-portfolio-prev',
            },
            pagination: {
                el: '.swiper-portfolio-pagination',
                type: 'fraction',
            },
        });
        /***************************

        2 item slider

        ***************************/
        var swiper = new Swiper('.absoftz-2-slider', {
            slidesPerView: 1,
            spaceBetween: 30,
            speed: 800,
            parallax: true,
            navigation: {
                nextEl: '.absoftz-portfolio-next',
                prevEl: '.absoftz-portfolio-prev',
            },
            pagination: {
                el: '.swiper-portfolio-pagination',
                type: 'fraction',
            },
            breakpoints: {
                992: {
                    slidesPerView: 2,
                },
            },
        });

    });

});
