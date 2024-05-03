setTimeout(function () {
    var preload = document.getElementById("preloader");
    if (preload) {
        preload["classList"]["add"]("preloader-hide")
    }
}, 150);




(function($){
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
                items: 8
            },
            1024: {
                items: 7,
                margin: 20
            },
            992: {
                items: 7,
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


$('.splide__list').owlCarousel({
    items: 1,
    margin: 15,
    loop: true,
    autoplay: true,
    smartSpeed: 1000,
    autoplayTimeout: 3000,
    dots: false,
    nav: false
})
$('.collections').owlCarousel({
    nav: !0,
    dots: !1,
    margin: 30,
    loop: !0,
    touchDrag: !0,
    navText: ['<span aria-label="Previous">‹</span>', '<span aria-label="Next">›</span>'],
    responsive: {
        0: {
            items: 2,
            mouseDrag: !0,
            stagePadding: 25
        },
        500: {
            items: 2
        },
        700: {
            items: 4
        }
    }
})


$('.trand-carousel').owlCarousel({
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
            items: 5
        },
        1024: {
            items: 5,
            margin: 20
        },
        992: {
            items: 4,
            margin: 20
        },
        600: {
            margin: 25,
            items: 6
        },
        480: {
            margin: 15,
            items: 3            
        },
        320: {
            margin: 10,
            items: 3
        }
    }
})


$('.product_categories').owlCarousel({
    margin: 10,
    autoWidth: !0,
    dragEndSpeed: 600,
    nav: !1,
    dots: !1,
    slideBy: 2,
    navText: ['<span aria-label="Previous">‹</span>', '<span aria-label="Next">›</span>'],
    slideTransition: "ease",
    responsive: {
        1200: {
            margin: 20,
            items: 9
        },
        1024: {
            items: 8,
            margin: 20
        },
        992: {
            items: 7,
            margin: 20
        },
        600: {
            margin: 25,
            items: 6,
            nav: !1
        },
        480: {
            margin: 15,
            items: 3,
            autoWidth: !0,
            nav: !1
        },
        320: {
            margin: 10,
            items: 2,
            autoWidth: !0,
            nav: !1
        }
    }
})



$(window).scroll(function () {
    var scrollTop = $(window).scrollTop();
    if (scrollTop > 50) {
        $('.header-bar').removeClass('header-bar-detached');
        $('.footer-bar').removeClass('footer-bar-detached');
    } else {
        $('.header-bar').addClass('header-bar-detached');
        $('.footer-bar').addClass('footer-bar-detached');
    }
});

$(window).scroll(function () {
    var scrollTop = $(window).scrollTop();
    if($('.column_column__1Vkn8').length){
        var offtop = $('.column_column__1Vkn8').offset().top;
        if (scrollTop > offtop) {
            $('.bOkHCz').addClass('fixed-bar');
        } else {
            $('.bOkHCz').removeClass('fixed-bar');
    
        }
    }
    
});

function scrollNav() {
    $('nav a').click(function () {
        $(".active").removeClass("active");
        $(this).closest('li').addClass("active");
        var indexs = $(this).closest('.owl-item').index();
        $('.product_categories').trigger('to.owl.carousel', [indexs, 500, true]);
        $('html, body').stop().animate({
            scrollTop: $($(this).attr('href')).offset().top - 250
        }, 300);
        return false;
    });
}
scrollNav();
})(jQuery);

jQuery(document).ready(function ($) {
    
    if($('.Product_SkuValueBaseItem__item__8dc8y').length > 0){

        var price = $('.Product_SkuValueBaseItem__item__8dc8y').find('.wd-swatch').data('price'),
        id = $('.Product_SkuValueBaseItem__item__8dc8y').find('.wd-swatch').data('id');
        var x = $('.buy-now').attr('href'),
        y = x.substr(0, x.indexOf('='), x.length - x.indexOf('=')) + '=' + id;
        $('.buy-now').attr('href', y);
        
        $('input[name="variation_id"]').val(id);
        $('.price-box_new-price span').html(price);
        $('.single_add_to_cart_button').removeClass('disabled wc-variation-selection-needed');

        $('.Product_SkuValueBaseItem__item__8dc8y').click(function(e){
            e.preventDefault();
            var price = $(this).find('.wd-swatch').data('price'),
            id = $(this).find('.wd-swatch').data('id'),
            name = $(this).find('.wd-swatch').data("name");
            var x = $('.buy-now').attr('href'),
            y = x.substr(0, x.indexOf('='), x.length - x.indexOf('=')) + '=' + id;
            $('.buy-now').attr('href', y);           
            $('.Product_SkuValueBaseItem__item__8dc8y').removeClass('Product_SkuValueBaseItem__active__8dc8y');
            $(this).addClass('Product_SkuValueBaseItem__active__8dc8y');
            $('.ali-kit_Base__light__104pa1').html(name);
            $('input[name="variation_id"]').val(id);
            $('.price-box_new-price span').html(price);
            $('.single_add_to_cart_button').removeClass('disabled wc-variation-selection-needed');
        })
    }
   

});

(function($){


$(window).on("load", function () {

    // local storage theme variable presence check
    const currentThemeColor = localStorage.getItem("theme-color");
    //
    if (currentThemeColor) {
      // add class to body
      $("body").addClass(currentThemeColor);
      if (currentThemeColor === "theme-dark") {
        $(".theme-switcher").prop("checked", true);
        $(".theme-switcher-label").addClass("active");
      } else {
        // continue with default theme
      }
    }
    // switch theme
    $(".theme-switcher-label").on("change", switchColorTheme);
  });

  function switchColorTheme(e) {
    $(this).toggleClass("active");
    //  remove previous classes
    removeThemeClass();
    if (e.target.checked) {
      // it's a dark theme
      $("body").addClass("theme-dark");
      localStorage.setItem("theme-color", "theme-dark");
      $(".theme-switcher").prop("checked", true);
    } else {
      $("body").addClass("theme-light");
      localStorage.setItem("theme-color", "theme-light");
      $(".theme-switcher").prop("checked", false);
    }
  }

  function removeThemeClass() {
    $("body").removeClass(function (index, cssName) {
      return (cssName.match(/\btheme-\S+/g) || []).join(" ");
    });
  }

  var swiperNav = new Swiper(".slider-more-about-nav", {
    spaceBetween: 10,
    slidesPerView: 4,
    mousewheel: true,
    watchSlidesProgress: true,
    watchSlidesVisibility: true,

    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});

var swiperFor = new Swiper(".slider-more-about-for", {
    spaceBetween: 30,
    effect: "cube",
    cubeEffect: {
        shadow: false,
        slideShadows: false,
    },
    thumbs: {
        swiper: swiperNav,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    }
});


$().fancybox({
    selector: '.slider-more-about-for .swiper-slide',
    backFocus: false,
    thumbs: {
        autoStart: false, // Display thumbnails on opening
    },
    buttons: [
        "zoom",
        "download",
        'share',
        "slideShow",
        "thumbs",
        "close"
    ]    
});

}(jQuery));


jQuery(function ($) {
    var property_id  ;
    var user_id  ;
    const add_favorite = (property_id , user_id) => {
    $.ajax({
                url: ajaxUrl,
                type: 'POST',
                data: {
                    action: 'add_to_favorite',   
                    property_id,
                    user_id
                },
                }).done((response) => {
                    var property_id =null;
                        
                    })  
         
            
    };  
    const remove_favorite = (property_id , user_id) => {
        $.ajax({
                    url: ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'remove_favorite',   
                        property_id,
                        user_id
                    },
                    }).done((response) => {
                        var property_id =null;
                            
                        })  
             
                
        };
    $("a.favmod").click(function(e){
        var property_id =   $(this).attr("data-id");
        var  user_id =    $(this).attr("data-user");
       
        e.preventDefault();
        if(user_id !=0){
            if($(this).hasClass("active")){
                remove_favorite(property_id, user_id );
                $(this).removeClass('active');
            } else {
                add_favorite(property_id, user_id );
                $(this).addClass('active');
            }
        } else {
            window.location = myprofileUrl;
        }
    
   }); 
    $('.fvooyb').on('click', function() {
        $(this).toggleClass('active');
        $('.uZATO').toggleClass('active');       
    });
  
});
