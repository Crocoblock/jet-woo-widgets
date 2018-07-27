( function( $, elementorFrontend ) {

	"use strict";

	var JetWooWidgets = {

		init: function() {


			var widgets = {
				'jet-woo-widgets-products.default' : JetWooWidgets.widgetProducts,
				'jet-woo-widgets-categories.default' : JetWooWidgets.widgetCategories,
			};

			$.each( widgets, function( widget, callback ) {
				elementorFrontend.hooks.addAction( 'frontend/element_ready/' + widget, callback );
			});

		},

		widgetProducts: function ( $scope ) {

			var $target = $scope.find( '.jet-woo-carousel' );

			if ( ! $target.length ) {
				return;
			}

			JetWooWidgets.initCarousel( $target.find( '.jet-woo-products' ), $target.data( 'slider_options' ) );

		},

		widgetCategories: function ( $scope ) {

			var $target = $scope.find( '.jet-woo-carousel' );

			if ( ! $target.length ) {
				return;
			}

			JetWooWidgets.initCarousel( $target.find( '.jet-woo-categories' ), $target.data( 'slider_options' ) );

		},

		initCarousel: function( $target, options ) {

			var tabletSlides, mobileSlides, defaultOptions, slickOptions;

			if ( options.slidesToShow.tablet ) {
				tabletSlides = options.slidesToShow.tablet;
			} else {
				tabletSlides = 1 === options.slidesToShow.desktop ? 1 : 2;
			}

			if ( options.slidesToShow.mobile ) {
				mobileSlides = options.slidesToShow.mobile;
			} else {
				mobileSlides = 1;
			}

			options.slidesToShow = options.slidesToShow.desktop;

			defaultOptions = {
				customPaging: function(slider, i) {
					return $( '<span />' ).text( i + 1 );
				},
				dotsClass: 'jet-slick-dots',
				responsive: [
					{
						breakpoint: 1025,
						settings: {
							slidesToShow: tabletSlides,
						}
					},
					{
						breakpoint: 768,
						settings: {
							slidesToShow: mobileSlides,
							slidesToScroll: 1
						}
					}
				]
			};

			slickOptions = $.extend( {}, defaultOptions, options );

			$target.slick( slickOptions );
		},

	};

	$( window ).on( 'elementor/frontend/init', JetWooWidgets.init );

}( jQuery, window.elementorFrontend ) );