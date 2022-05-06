(function ( $ ) {
    var idenxShop = {
        featureProducts: function() {
            $('#featured-product ul.products li.product h2.woocommerce-loop-product__title').addClass('text-center');
            $('#featured-product ul.products li.product .price').addClass('text-center');

            $('#featured-product ul.products').addClass('owl-carousel');
            $('#featured-product ul.products').addClass('owl-theme');
            $('#featured-product ul.products').owlCarousel({
                loop:false,
                margin:10,
                nav:true,
                dots:false,
                responsive:{
                    0:{
                        items:1
                    },
                    600:{
                        items:3
                    },
                    1000:{
                        items:4
                    }
                }
            });
        },
    };
    $(document).ready(function($) {

        idenxShop.featureProducts();

    })
} ( jQuery ));