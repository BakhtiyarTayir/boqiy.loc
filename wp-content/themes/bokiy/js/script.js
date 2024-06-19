
// Cart page
jQuery(document).ready(function ($) {
    $('body').on('click', '.quantity .quantity-plus', function (e) {
        var _this = $(this).closest('.quantity').find('input.qty'),
            _value = parseInt(_this.val()),
            _max = parseInt(_this.attr('max')),
            _step = 1,
            _value = _value +  1;
        if (_max && _value > _max) {
            _value = _max;
        }
        _this.val(_value);
        _this.trigger("change");
        e.preventDefault();
    });

    $('body').on('click', '.quantity .quantity-minus', function (e) {
        var _this = $(this).closest('.quantity').find('input.qty'),
            _value = parseInt(_this.val()),
            _min = parseInt(_this.attr('min')),
            _step = parseInt(_this.data('step')),
            _value = _value - 1;
        if (_min && _value < _min) {
            _value = _min;
        }
        if (!_min && _value < 0) {
            _value = 0;
        }
        _this.val(_value);
        _this.trigger("change");
        e.preventDefault();
    });
    $(document).on('change', function () {
        $('.quantity').each(function () {
            var _this = $(this).find('input.qty'),
                _value = _this.val(),
                _max = parseInt(_this.attr('max'));
            if (_value > _max) {
                $(this).find('.quantity-plus').css('pointer-events', 'none')
            } else {
                $(this).find('.quantity-plus').css('pointer-events', 'auto')
            }
        })
    });

});

var timeout;

jQuery(function ($) {
    $('.woocommerce').on('change', 'input.qty', function () {

        if (timeout !== undefined) {
            clearTimeout(timeout);
        }

        timeout = setTimeout(function () {
            $("[name='update_cart']").trigger("click");
        }, 1000); // 1 second delay, half a second (500) seems comfortable too

    });
});

(function ($) {

    $('.cat-slider').owlCarousel({
        margin: 10,
        autoWidth: !1,
        dragEndSpeed: 600,
        nav: !0,
        dots: !1,
        slideBy: 2,
        navText: ['<span aria-label="Previous">‹</span>', '<span aria-label="Next">›</span>'],
        slideTransition: "ease",
        responsive: {
            1200: {
                margin: 20,
                items: 7
            },
            1024: {
                items: 6,
                margin: 20
            },
            992: {
                items: 6,
                margin: 20
            },
            600: {
                margin: 25,
                items: 6,
                nav: !1
            },
            480: {
                margin: 15,
                items: 3            
            },
            320: {
                margin: 10,
                items: 3,
                autoWidth: !1
            }
        }
    })

$(".logmod__tabs a").on("click", function(e) {
    e.preventDefault;
    $(".logmod__tab").removeClass("show");
    $(".logmod__tabs li").removeClass("current");
    $(this).closest('li').addClass("current");
    $('.' + $(this).closest('li').data("tabtar") + '').addClass("show");
})

$('input[name="field_1"]').change(function() {
    $('input[name="signup_email"]').val($(this).val() + '@' + $(this).val() + '.com');
    $('input[name="signup_username"]').val($(this).val());
});
})(jQuery, window, document);
!function(o){!function(){var i=o(".longform__header-container").outerHeight(),e=o(".longform__video-backer video");o(window).scrollTop()>i&&o(".longform__header-container, .longform-navbar").hide();o(window).scrollTop()<10?o(".longform-footer").hide():o(".longform-footer").show();o(window).scroll(function(){o(window).scrollTop()>i?(e.length&&e.get(0).pause(),o(".longform__header-container, .longform-navbar").hide()):(o(".longform__header-container, .longform-navbar").show(),e.length&&e.filter(":visible").length&&e.filter(":visible").get(0).play())})}(),function(){var i=o(".sticker"),e=o(".sticker-stopper");if(o(".sticker-stopper").length>0)var n=i.offset().top;var t=function(){if(i.offset()&&o(window).width()>880){var t=i.innerHeight(),r=i.offset().top;e.offset().top;o(window).scroll(function(){if(o(window).width()>880){var e=o(".content-column"),l=e.innerHeight(),s=e.offset().top,c=s+l,a=c-(t+40),f=o(window).scrollTop();a<f?i.css({position:"absolute",top:a-s,opacity:1}):r<f+0?i.css({position:"fixed",top:0,opacity:1}):f<n&&i.css({position:"absolute",top:"auto",opacity:1})}})}};t(),o(window).resize(function(){o(window).width()>880&&t()})}(),o(".tm-swiper").each(function(){if(o(this).hasClass("billey-swiper-linked-yes")){var i=o(this).children(".billey-main-swiper").BilleySwiper(),e=o(this).children(".billey-thumbs-swiper").BilleySwiper();i.controller.control=e,e.controller.control=i}else o(this).BilleySwiper()}),o(".drawer-trigger").click(function(){o(".share-group.drawer").toggleClass("open")}),o("figure img").each(function(){var i=o(this),e=(o("figcaption"),i.attr("alt"));i.closest("figure").find("figcaption").prepend("<p>"+e+"</p>")})}(jQuery);


let categories = document.querySelector(".category-left")
if(categories){
let categoryList = categories.getElementsByTagName('a')

for(let i = 0; i < categoryList.length; i++){
    categoryList[i].addEventListener('mouseenter', () => {
        console.log("ok");
    })
}
}
jQuery(document).ready(function($) {
    $('.acomment-reply').on('click', function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        var hash = url.substring(url.indexOf("#")+1);  
        $('html, body').stop(); 
        $('#'+hash).show();   
        // e.preventDefault();
        return false;
    })
});

(function ($) { 



    $(".category-left > a").hover(function () {
        if (!$(this).hasClass('active')) {
            var link_url = $(this).data("menu-id");
            $("#" + "dropDown" + link_url).addClass('active');
            $("#" + "dropDown" + link_url).siblings().removeClass('active');
            console.log($("#" + "dropDown" + link_url));
            $(this).addClass('active');
            $(this).closest('li').siblings().find('a').removeClass('active');
        } else {
            $(this).removeClass('active');
            var link_url = $(this).data("menu-id");
            $("#" + "dropDown" + link_url).removeClass('active');
        }
    });
    $("#shipping_method_0_per_product").attr('checked', true);



    $(window).scroll(function () {
        console.log('scrolling');
        var scrollTop = $(window).scrollTop();
        if (scrollTop > 50) {
            $('.header-bar').removeClass('header-bar-detached');
            $('.footer-bar').removeClass('footer-bar-detached');
        } else {
            $('.header-bar').addClass('header-bar-detached');
            $('.footer-bar').addClass('footer-bar-detached');
        }
    });


})(jQuery, window, document);


if (window.innerWidth < 600) {
    document.querySelectorAll('a.button.fav.bp-secondary-action').forEach(function(elem) {
        elem.childNodes.forEach(function(child) {
            if (child.nodeType === Node.TEXT_NODE) {
                child.remove();
            }
        });
    });

    
    document.querySelectorAll('.button.acomment-reply.bp-primary-action').forEach(function(elem) {
        elem.childNodes.forEach(function(child) {
            if (child.nodeType === Node.TEXT_NODE) {
                child.remove();
            }
        });
    });

    document.querySelectorAll('.button.bp-secondary-action.unfav').forEach(function(elem) {
        elem.childNodes.forEach(function(child) {
            if (child.nodeType === Node.TEXT_NODE) {
                child.remove();
            }
        });
    });

}
  