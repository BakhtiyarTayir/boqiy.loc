
 class WidgetHandlerClass extends elementorModules.frontend.handlers.Base {
    getDefaultSettings() {
        return {
            selectors: {
                firstSelector: '#button',
                secondSelector: '.splide__list',
            },
        };
    }

    getDefaultElements() {
        const selectors = this.getSettings( 'selectors' );
        return {
            $firstSelector: this.$element.find( selectors.firstSelector ),
            $secondSelector: this.$element.find( selectors.secondSelector ),
        };
    }

    bindEvents() {
        this.elements.$firstSelector.on( 'click', this.onFirstSelectorClick.bind( this ) );
    }

    onFirstSelectorClick( event ) {
        event.preventDefault();
        console.log(elements); 
        this.elements.$secondSelector.show();
   } 
}

jQuery( window ).on( 'elementor/frontend/init', () => {
   const addHandler = ( $element ) => {
       elementorFrontend.elementsHandler.addHandler( WidgetHandlerClass, {
           $element,
       } ); 
   };

   elementorFrontend.hooks.addAction( 'frontend/element_ready/homeSlider.default', addHandler );

} );

jQuery('.splide__list').owlCarousel({  
    items: 1,
    margin: 15,
    loop: true,
    autoplay: true,
    smartSpeed: 1000,
    autoplayTimeout: 3000,
    dots: false,
    nav: false
})

jQuery('.collections').owlCarousel({
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

