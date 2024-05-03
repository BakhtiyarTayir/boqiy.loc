<?php
namespace ElementorMaster\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

// Security Note: Blocks direct access to the plugin PHP files.
defined( 'ABSPATH' ) || die();


class CategoriesProduct extends Widget_Base {

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
		return 'categoriesproduct';
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
		return esc_html__( 'Товары по категориям', 'elementor' );
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
		return 'eicon-slides';
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
		return array( 'master', 'owl' );
	}

	public function get_script_depends() {
		return array( 'owl','master');
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
				'label'   => 'Заголовок',
				'type'    => Controls_Manager::TEXT,
			)
		);

		$this->add_control(
			'numbers',
			array(
				'label'   => 'Количества',
				'type'    => Controls_Manager::NUMBER,
			)
		);

		$this->add_control(
			'link_title',
			array(
				'label'   => 'Название ссылки',
				'type'    => Controls_Manager::TEXT,
			)
		);

		$this->add_control(
			'link',
			array(
				'label'   => 'Ссылка',
				'type' => \Elementor\Controls_Manager::URL,
			)
		);

		$this->add_control(
			'product_taxonomy',
			array(
				'label'       => "Выберите категорию",
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'     => $this->get_taxonomies(),
				'default' => '27',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Get Product Categories
	 *
	 * @since 1.0.0
	 * @access public
	 */
	protected function get_taxonomies() {


		$result = array();
		$categories = get_terms( array(
			'taxonomy' => 'product_cat',
			'orderby' => 'term_id',
			'hide_empty' => false,
		) );

		foreach ( $categories as $term ) {
			$key            = sprintf( '%1$s::%2$s', $term->term_id, $term->name );
			$result[ $key ] = $term->name;
		}

		return $result;
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

		?>

		<section class="rax-view content-bottom">
                <div class="rax-view item-feed">
					<div class="rax-view item-feed-header">
						<span class="rax-text-v2 header-title">
							<?php echo $settings['title'] ?> 
							<a href="<?php echo $settings['link']['url']; ?>" class="more-link">
								<span><?php echo $settings['link_title'] ?> <i class="fa-sharp fa fa-angle-right"></i></span>
							</a>
						</span>
					</div>
					<div class="container">
					
							<ul class="products 4 row white-bg">
								<?php  
									$orderby = 'date';
									$args = array(
										'posts_per_page' => $settings['numbers'],
										'post_type' => 'product',
										'post_status' => 'publish',
										'ignore_sticky_posts' => 1,
										'orderby' => $orderby,
										'order' => 'DESC',
										'tax_query' => array(
											array(
												'taxonomy' => 'product_cat',
												'field'    => 'term_id',
												'terms'    => array($settings['product_taxonomy']),
											),
										),
									);

									

									$loop = new \WP_Query( $args );								
									while ( $loop->have_posts() ) : $loop->the_post();
										global $product;
										wc_get_template_part( 'content', 'product-6' );
									endwhile;

									wp_reset_query();
								?>
							</ul>
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