<?php

namespace Billey_Elementor;

use Elementor\Plugin;

defined( 'ABSPATH' ) || exit;

class Widget_Init {

	private static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function initialize() {
		add_action( 'elementor/elements/categories_registered', [ $this, 'add_elementor_widget_categories' ] );

		// Registered Widgets.
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
		//add_action( 'elementor/widgets/widgets_registered', [ $this, 'remove_unwanted_widgets' ], 15 );

		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'after_register_scripts' ] );
		add_action( 'elementor/frontend/after_register_styles', [ $this, 'after_register_styles' ] );

		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'enqueue_editor_scripts' ] );

		add_filter( 'elementor/utils/get_the_archive_title', [ $this, 'change_portfolio_archive_title' ] );
		add_filter( 'elementor/utils/get_the_archive_title', [ $this, 'change_client_archive_title' ] );
		add_filter( 'elementor/utils/get_the_archive_title', [ $this, 'change_review_archive_title' ] );

		// Modify original widgets settings.
		require_once BILLEY_ELEMENTOR_DIR . '/widgets/original/modify-base.php';
		require_once BILLEY_ELEMENTOR_DIR . '/widgets/original/section.php';
		require_once BILLEY_ELEMENTOR_DIR . '/widgets/original/column.php';
		require_once BILLEY_ELEMENTOR_DIR . '/widgets/original/accordion.php';
		require_once BILLEY_ELEMENTOR_DIR . '/widgets/original/animated-headline.php';
		require_once BILLEY_ELEMENTOR_DIR . '/widgets/original/counter.php';
		require_once BILLEY_ELEMENTOR_DIR . '/widgets/original/form.php';
		require_once BILLEY_ELEMENTOR_DIR . '/widgets/original/heading.php';
		require_once BILLEY_ELEMENTOR_DIR . '/widgets/original/icon-box.php';
		require_once BILLEY_ELEMENTOR_DIR . '/widgets/original/progress.php';
	}

	/**
	 * Register scripts for widgets.
	 */
	public function after_register_scripts() {
		// Fix Wordpress old version not registered this script.
		if ( ! wp_script_is( 'imagesloaded', 'registered' ) ) {
			wp_register_script( 'imagesloaded', BILLEY_THEME_URI . '/assets/libs/imagesloaded/imagesloaded.min.js', array( 'jquery' ), null, true );
		}

		wp_register_script( 'circle-progress', BILLEY_THEME_URI . '/assets/libs/circle-progress/circle-progress.min.js', array( 'jquery' ), null, true );
		wp_register_script( 'billey-widget-circle-progress', BILLEY_ELEMENTOR_URI . '/assets/js/widgets/widget-circle-progress.js', array(
			'jquery',
			'circle-progress',
		), null, true );

		wp_register_script( 'billey-swiper-wrapper', BILLEY_THEME_URI . '/assets/js/swiper-wrapper.js', array( 'jquery' ), null, true );
		wp_register_script( 'billey-group-widget-carousel', BILLEY_ELEMENTOR_URI . '/assets/js/widgets/group-widget-carousel.js', array(
			'jquery',
			'swiper',
			'hoverIntent',
			'billey-swiper-wrapper',
		), null, true );
		$billey_swiper_js = array(
			'prevText'              => esc_html__( 'Prev', 'billey' ),
			'nextText'              => esc_html__( 'Next', 'billey' ),
			'fractionSeparatorText' => _x( 'Of', 'slider fraction separator', 'billey' ),
		);
		wp_localize_script( 'billey-swiper-wrapper', '$billeySwiper', $billey_swiper_js );

		wp_register_script( 'isotope-masonry', BILLEY_THEME_URI . '/assets/libs/isotope/js/isotope.pkgd.js', array( 'jquery' ), BILLEY_THEME_VERSION, true );
		wp_register_script( 'isotope-packery', BILLEY_THEME_URI . '/assets/libs/packery-mode/packery-mode.pkgd.js', array( 'jquery' ), BILLEY_THEME_VERSION, true );

		wp_register_script( 'billey-grid-layout', BILLEY_THEME_ASSETS_URI . '/js/grid-layout.js', array(
			'jquery',
			'imagesloaded',
			'isotope-masonry',
			'isotope-packery',
		), null, true );
		wp_register_script( 'billey-grid-query', BILLEY_ELEMENTOR_URI . '/assets/js/widgets/grid-query.js', array( 'jquery' ), null, true );

		wp_register_script( 'billey-widget-grid-post', BILLEY_ELEMENTOR_URI . '/assets/js/widgets/widget-grid-post.js', array( 'billey-grid-layout' ), null, true );
		wp_register_script( 'billey-group-widget-grid', BILLEY_ELEMENTOR_URI . '/assets/js/widgets/group-widget-grid.js', array( 'billey-grid-layout' ), null, true );

		wp_register_script( 'billey-widget-google-map', BILLEY_ELEMENTOR_URI . '/assets/js/widgets/widget-google-map.js', array( 'jquery' ), null, true );

		wp_register_script( 'vivus', BILLEY_ELEMENTOR_URI . '/assets/libs/vivus/vivus.js', array( 'jquery' ), null, true );
		wp_register_script( 'billey-widget-icon-box', BILLEY_ELEMENTOR_URI . '/assets/js/widgets/widget-icon-box.js', array(
			'jquery',
			'vivus',
		), null, true );

		wp_register_script( 'billey-widget-flip-box', BILLEY_ELEMENTOR_URI . '/assets/js/widgets/widget-flip-box.js', array(
			'jquery',
			'imagesloaded',
		), null, true );

		wp_register_script( 'billey-widget-accordion', BILLEY_ELEMENTOR_URI . '/assets/js/widgets/widget-accordion.js', array(
			'jquery',
		), null, true );

		wp_register_script( 'billey-widget-tabs', BILLEY_ELEMENTOR_URI . '/assets/js/widgets/widget-tabs.js', array(
			'jquery',
		), null, true );

		wp_register_script( 'chart', BILLEY_ELEMENTOR_URI . '/assets/libs/chart/Chart.min.js', array( 'jquery' ), null, true );
		wp_register_script( 'billey-group-widget-chart', BILLEY_ELEMENTOR_URI . '/assets/js/widgets/group-widget-chart.js', array(
			'jquery',
			'chart',
		), null, true );
	}

	/**
	 * enqueue scripts in editor mode.
	 */
	public function enqueue_editor_scripts() {
		wp_enqueue_script( 'billey-elementor-editor', BILLEY_ELEMENTOR_URI . '/assets/js/editor.js', array( 'jquery' ), null, true );
	}

	/**
	 * Register styles for widgets.
	 */
	public function after_register_styles() {

	}

	/**
	 * @param \Elementor\Elements_Manager $elements_manager
	 *
	 * Add category.
	 */
	function add_elementor_widget_categories( $elements_manager ) {
		$elements_manager->add_category( 'billey', [
			'title' => esc_html__( 'By Billey', 'billey' ),
			'icon'  => 'fa fa-plug',
		] );
	}

	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 *
	 * @since  1.0.0
	 *
	 * @access public
	 */
	public function init_widgets() {

		// Include Widget files.
		require_once BILLEY_ELEMENTOR_DIR . '/module-query.php';
		require_once BILLEY_ELEMENTOR_DIR . '/widgets/base.php';
		require_once BILLEY_ELEMENTOR_DIR . '/widgets/posts/posts-base.php';
		require_once BILLEY_ELEMENTOR_DIR . '/widgets/carousel/carousel-base.php';
		require_once BILLEY_ELEMENTOR_DIR . '/widgets/carousel/posts-carousel-base.php';

		require_once BILLEY_ELEMENTOR_DIR . '/widgets/accordion.php';
		require_once BILLEY_ELEMENTOR_DIR . '/widgets/tabs.php';
		require_once BILLEY_ELEMENTOR_DIR . '/widgets/button.php';
		
	
		require_once BILLEY_ELEMENTOR_DIR . '/widgets/posts/blog.php';		
		require_once BILLEY_ELEMENTOR_DIR . '/widgets/block-slayd.php';
		
		require_once BILLEY_ELEMENTOR_DIR . '/widgets/slide-block-1.php';
	
		require_once BILLEY_ELEMENTOR_DIR . '/widgets/block-carousel.php';
		
		require_once BILLEY_ELEMENTOR_DIR . '/widgets/nav-menu.php';
		require_once BILLEY_ELEMENTOR_DIR . '/widgets/breadcrumbs.php';
		require_once BILLEY_ELEMENTOR_DIR . '/widgets/carousel/insta-slider.php';

		require_once BILLEY_ELEMENTOR_DIR . '/widgets/bonus_main.php';
		require_once BILLEY_ELEMENTOR_DIR . '/widgets/bonus_footer.php';
		require_once BILLEY_ELEMENTOR_DIR . '/widgets/bonus-quest.php';
		require_once BILLEY_ELEMENTOR_DIR . '/widgets/carousel/modern-carousel.php';
		require_once BILLEY_ELEMENTOR_DIR . '/class-image.php';

			
		Plugin::instance()->widgets_manager->register_widget_type( new Bonus_Main() );
		Plugin::instance()->widgets_manager->register_widget_type( new Bonus_Footer() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Bonus_Quest() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Modern_Carousel() );
		Plugin::instance()->widgets_manager->register_widget_type( new Insta_Slider() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Nav_Menu() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Breadcrumbs() );		
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Block_carousel() );		
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Block_slayd() );		
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Accordion() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Tabs() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Button() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widget_Blog() );
		

		
	}

	/**
	 * @param \Elementor\Widgets_Manager $widgets_manager
	 *
	 * Remove unwanted widgets
	 */
	function remove_unwanted_widgets( $widgets_manager ) {
		$elementor_widget_blacklist = array(
			'theme-site-logo',
		);

		foreach ( $elementor_widget_blacklist as $widget_name ) {
			$widgets_manager->unregister_widget_type( $widget_name );
		}
	}

	public function change_portfolio_archive_title( $title ) {
		if ( \Billey_Portfolio::instance()->is_archive() ) {
			$title = \Billey::setting( 'title_bar_archive_portfolio_title' );
		}

		if ( '' === $title ) {
			$title = 'Archive Title';
		}

		return $title;
	}

	public function change_client_archive_title( $title ) {
		if ( \Billey_Client::instance()->is_archive() ) {
			$title = \Billey::setting( 'title_bar_archive_client_title' );
		}

		if ( '' === $title ) {
			$title = 'Archive Title';
		}

		return $title;
	}

	public function change_review_archive_title( $title ) {
		if ( \Billey_Review::instance()->is_archive() ) {
			$title = \Billey::setting( 'title_bar_archive_review_title' );
		}

		if ( '' === $title ) {
			$title = 'Archive Title';
		}

		return $title;
	}
}

Widget_Init::instance()->initialize();
