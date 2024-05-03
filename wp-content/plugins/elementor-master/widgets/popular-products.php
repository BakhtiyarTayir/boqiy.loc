<?php
namespace ElementorMaster\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

// Security Note: Blocks direct access to the plugin PHP files.
defined( 'ABSPATH' ) || die();


class PopularProducts extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve image box widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'popularProducts';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve image box widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Popular products', 'elementor' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve image box widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-products';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'basic' );
	}
	/**
	 * Enqueue styles.
	 */
	public function get_style_depends() {
		return array( 'master' );
	}

	/**
	 * Register image box widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 3.1.0
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_content',
			array(
				'label' => __( 'Content', 'elementor-master' ),
			)
		);

		$this->add_control(
			'title',
			array(
				'label'   => __( 'Title', 'elementor-master' ),
				'type'    => Controls_Manager::TEXT,
			)
		);


		$this->end_controls_section();
	}

	/**
	 * Render image box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_inline_editing_attributes( 'title', 'none' );
		$this->add_inline_editing_attributes( 'description', 'basic' );
		?>
			<section class="rax-view content-bottom">
                <div class="rax-view item-feed">
					<div class="rax-view item-feed-header">
						<span class="rax-text-v2 header-title"><?php echo $settings['title'] ?></span>
					</div>
					<div class="container">
						<div class="row white-bg">
							<div class="trand-carousel owl-carousel">
								<?php  
									$args = array(
										'posts_per_page' => 12,
										'post_type' => 'product',
										'post_status' => 'publish',
										'ignore_sticky_posts' => 1,
										'meta_key' => 'total_sales',
										'orderby' => 'meta_value_num',
										'order' => 'DESC',
									);

									$loop = new \WP_Query( $args );
									$i = 2;
									while ( $loop->have_posts() ) : $loop->the_post();
										global $product;
										
									?>
										<?php echo $i % 2 == 0 ? '<div class="trand-carousel-item">' : ''  ?>
											<a href="<?php the_permalink(); ?>" class="styles_container__trend">
												<div class="styles_image__6d1qy"><?php echo woocommerce_get_product_thumbnail(); ?></div>
												<div class="styles_product__172_i">
													<div class="styles_product__name__71XoP"><?php the_title(); ?></div>
												</div>
											</a>
										<?php echo $i % 2 != 0 ? '</div>' : ''?>
								<?php $i++;
									endwhile;

									wp_reset_query();
								?>
							</div>
						</div>
					</div>
				</div>				
			<section>								
<?php
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	
}

?>

<?php // echo $product->get_price(); echo ' '; echo get_woocommerce_currency_symbol(); ?>
