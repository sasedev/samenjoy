$(document).ready(function() {
    $("#productslider").owlCarousel({
        nav: true,
        loop: true,
        navRewind: false,
        autoplay: true,
        autoplayTimeout: 3000,
        items: 4,
        itemsTablet: [768, 2]
    });
    $(".brand-carousel").owlCarousel({
        nav: false,
        dots: false,
        loop: true,
        navRewind: false,
        autoplay: true,
        items: 4,
        itemsTablet: [768, 4],
        itemsMobile: [400, 2]
    });
    $("#SimilarProductSlider").owlCarousel({
        navigation: true
    });
    $(".collapseWill").on("click", function(evt) {
        $(this).toggleClass("pressed");
        evt.preventDefault();
    });
    $(".search-box .btn").on("click", function(evt) {
        $(".search-full").addClass("active");
        evt.preventDefault();
    });
    $(".search-close").on("click", function(evt) {
        $(".search-full").removeClass("active");
        evt.preventDefault();
    });
    $(".dropdown-tree-a").click(function() {
        $(this).parent(".dropdown-tree").toggleClass("open-tree active");
    });
    $(".dropdown-treex").bind("click", function() {
        $(this).find("a:first-child").css("color", "red");
    });
    $(".list-view").click(function(evt) {
        evt.preventDefault();
        $(".item").addClass("list-view");
    });
    $(".grid-view").click(function(evt) {
        evt.preventDefault();
        $(".item").removeClass("list-view");
    });
    $(".swatches li").click(function() {
        $(".swatches li.selected").removeClass("selected");
        $(this).addClass("selected");
    });
    if (/IEMobile/i ["test"](navigator.userAgent)) {
        $(".navbar-brand").addClass("windowsphone");
    };
    
    var detectBrowser = function() {
        return /(iphone|ipod|ipad|android|blackberry|windows ce|palm|symbian)/i ["test"](navigator.userAgent);
    };
    
    /*
    if (!detectBrowser()) {
        if ($.browser.msie && parseInt($.browser.version, 10) === 8) {} else {
            $(function() {
                var _0xb4ecx4 = 0;
                $(window).scroll(function(_0xb4ecx5) {
                    var _0xb4ecx6 = $(this).scrollTop();
                    if (_0xb4ecx6 > _0xb4ecx4) {
                        $(".navbar").addClass("stuck");
                    } else {
                        $(".navbar").removeClass("stuck");
                    };
                    _0xb4ecx4 = _0xb4ecx6;
                });
            });
        };
    }; //*/
    
    if (/iPhone|iPad|iPod/i ["test"](navigator.userAgent)) {
        $(".parallax-section").addClass("isios");
        $(".navbar-header").addClass("isios");
    };
    
    if (/Android|IEMobile|Opera Mini/i ["test"](navigator.userAgent)) {
        $(".parallax-section").addClass("isandroid");
    };
    
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i ["test"](navigator.userAgent)) {
        $(".parallax-section").addClass("ismobile");
        $(".parallaximg").addClass("ismobile");
    } else {
        $(window).bind("scroll", function(evt) {
            parallaxMove();
        });

        function parallaxMove() {
            var scrollToTop = $(window).scrollTop();
            $(".parallaximg").css("marginTop", "" + ((scrollToTop * 0.3)) + "px");
        };
        if ($(window).width() < 600) {} else {
            $(".parallax-image-aboutus").parallax("50%", 0, 0.2, true);
        };
    };
    
    $(".scroll-pane").mCustomScrollbar({
        advanced: {
            updateOnContentResize: true
        },
        scrollButtons: {
            enable: false
        },
        mouseWheelPixels: "200",
        theme: "dark-2"
    });
    
    $(".smoothscroll").mCustomScrollbar({
        advanced: {
            updateOnContentResize: true
        },
        scrollButtons: {
            enable: false
        },
        mouseWheelPixels: "100",
        theme: "dark-2"
    });
    
    window.onload = (function() {
        $(window).scroll(function() {
            if ($(window).scrollTop() > 86) {
                $(".parallax-image-aboutus .animated").removeClass("fadeInDown");
                $(".parallax-image-aboutus .animated").addClass("fadeOutUp");
            } else {
                $(".parallax-image-aboutus .animated").addClass("fadeInDown");
                $(".parallax-image-aboutus .animated").removeClass("fadeOutUp");
            }; if ($(window).scrollTop() > 250) {} else {};
        });
    });
    
    $(function() {
        $(".thumbnail.equalheight").responsiveEqualHeightGrid();
    });
    if ($(window).width() < 989) {
        $(".collapseWill").trigger("click");
    } else {};
    
    $(".tbtn").click(function() {
        $(".themeControll").toggleClass("active");
    });
    
    $(".tooltipHere").tooltip();
    
    //$("select").minimalect();
    
    $("input[name='quanitySniper']").TouchSpin({
        buttondown_class: "btn btn-link",
        buttonup_class: "btn btn-link"
    });
});