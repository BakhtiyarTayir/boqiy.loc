<?php

namespace Billey_Elementor;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Utils;

use Elementor\Core\Base\Document;
use ElementorPro\Modules\QueryControl\Module as QueryControlModule;
use ElementorPro\Plugin;

defined( 'ABSPATH' ) || exit;

class Widget_Bonus_Quest extends Base {

	public function get_name() {
		return 'tm-bonus-quest';
	}

	public function get_title() {
		return esc_html__( 'Bonus Quest', 'billey' );
	}

	public function get_icon_part() {
		return 'eicon-image-rollover';
	}

	public function get_keywords() {
		return [ 'client', 'details' ];
	}

	protected function _register_controls() {
		$this->add_content_section();
	}

	private function add_content_section() {
		$this->start_controls_section( 'content_section', [
			'label' => esc_html__( 'Items', 'billey' ),
		] );

		$this->add_control( 'maintitle', [
			'label'     => esc_html__( 'Title', 'billey' ),
			'type'      => Controls_Manager::TEXT,
			'dynamic'   => [
				'active' => true,
			],
			'separator' => 'before',
		] );
		

		$repeater = new Repeater();

		$repeater->add_control( 'title', [
			'label'   => esc_html__( 'Title', 'billey' ),
			'type'    => Controls_Manager::TEXT,
			'default' => esc_html__( 'Web developer', 'billey' ),
			'label_block' => true,
			'dynamic'     => [
				'active' => false,
			],
		] );	
		$repeater->add_control( 'description', [
			'label'   => esc_html__( 'Description', 'billey' ),
			'type'    => Controls_Manager::TEXT,			
			'label_block' => true,
			
		] );	
		$repeater->add_control( 'ball', [
			'label'   => esc_html__( 'Bal', 'billey' ),
			'type'    => Controls_Manager::TEXT,			
			'label_block' => true,
			
		] );

		$this->add_control( 'items', [
			'label'       => esc_html__( 'Items', 'billey' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => [
				[
					'title'   => 'Стратегия',
				],
				[
					'title'   => 'Дизайн',
				],
				[
					'title'   => 'Клиент',
				],			
			],
			'title_field' => '{{{ title }}}',
		] );

		$this->add_control( 'view', [
			'label'   => esc_html__( 'View', 'billey' ),
			'type'    => Controls_Manager::HIDDEN,
			'default' => 'traditional',
		] );
		
		$this->add_control( 'type', [
			'label'        => esc_html__( 'Type', 'billey' ),
			'type'         => Controls_Manager::SELECT,
			'default'      => 'horizontal',
			'options'      => [
				'horizontal' => esc_html__( 'Horizontal', 'billey' ),
				'vertical'   => esc_html__( 'Vertical', 'billey' ),
			],
			'prefix_class' => 'billey-tabs-view-',
			'separator'    => 'before',
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		// Do nothing if there is not any items.
		if ( empty( $settings['items'] ) || count( $settings['items'] ) <= 0 ) {
			return;
		}

		$tabs = $settings['items'];
		$this->add_render_attribute( 'wrapper', 'class', 'billey-tabs' );
		$this->add_render_attribute( 'wrapper', 'role', 'tablist' );
		$id_int = substr( $this->get_id_int(), 0, 3 );

	
		?>
		<div class="client_detail_page">
			<div class="project-task" id="project-task">
				<h2 class="heading-sm"><?php echo $settings['maintitle'];?></h2>			
			</div>
			<div class="b-about-quests__sublist">
				<?php foreach ( $tabs as $index => $item ) :?>					
					<div class="b-about-quest js-about-quest">
					<div class="b-about-quest__value">
						<?php echo $item['ball']; ?>
						<span class="b-currency-icon_bonus"></span>
						
					</div>						
						<div class="b-about-quest__content">
							<div class="b-about-quest__name "><?php echo $item['title']; ?></div>
							<div class="b-about-quest__descr "><?php echo $item['description']; ?></div>
						</div>
    				</div>
				<?php endforeach; ?>
				
								
			</div>
			
			
		</div>
          
		<?php
	}
}
