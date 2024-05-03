<?php

namespace Billey_Elementor;

use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes;

defined( 'ABSPATH' ) || exit;

class Widget_Block_slayd extends Base {

	public function get_name() {
		return 'tm-block_slayd';
	}

	public function get_title() {
		return esc_html__( 'Block slayd', 'billey' );
	}

	public function get_icon_part() {
		return 'eicon-image-box';
	}

	public function get_keywords() {
		return [ 'image', 'photo', 'visual', 'box' ];
	}

	protected function _register_controls() {
		$this->add_image_box_section();

		$this->add_box_style_section();

		$this->add_image_style_section();

		$this->add_content_style_section();

		$this->add_button_style_section();
	}

	private function add_image_box_section() {
		$this->start_controls_section( 'image_section', [
			'label' => esc_html__( 'Image Box', 'billey' ),
		] );
		$this->add_control( 'slide_background_video', [
			'label'   => esc_html__( 'Choose media', 'billey' ),
			'type'    => Controls_Manager::MEDIA,
			'dynamic' => [
				'active' => true,
			],
			'default' => [
				'url' => Utils::get_placeholder_image_src(),
			],
		] );
		$this->add_control( 'slide_title_1', [
			'label'     => esc_html__( 'Text', 'billey' ),
			'type'      => Controls_Manager::WYSIWYG,
			'dynamic' => [
				'active' => true,
			],
		] );
		$this->add_control( 'slide_text_1', [
			'label'     => esc_html__( 'Text', 'billey' ),
			'type'      => Controls_Manager::WYSIWYG,
			'dynamic' => [
				'active' => true,
			],
		] );
		$this->add_control( 'slide_price_1', [
			'label'     => esc_html__( 'Text', 'billey' ),
			'type'      => Controls_Manager::WYSIWYG,
			'dynamic' => [
				'active' => true,
			],
		] );
		$this->add_control( 'slide_button_text', [
			'label'       => esc_html__( 'Text', 'billey' ),
			'type'        => Controls_Manager::TEXT,
			'dynamic'     => [
				'active' => true,
			],
			] );
		$this->add_control( 'slide_button_link', [
			'label'       => esc_html__( 'Button link', 'billey' ),
			'type'        => Controls_Manager::URL,
			'dynamic'     => [
				'active' => true,
			],
			'placeholder' => esc_attr__( 'https://your-link.com', 'billey' ),
			'default'     => [
				'url' => '#',
			],
		] );

		$this->add_control( 'view', [
			'label'   => esc_html__( 'View', 'billey' ),
			'type'    => Controls_Manager::HIDDEN,
			'default' => 'traditional',
		] );

		$this->end_controls_section();
	}

	private function add_box_style_section() {
		$this->start_controls_section( 'box_style_section', [
			'label' => esc_html__( 'Box', 'billey' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'text_align', [
			'label'     => esc_html__( 'Alignment', 'billey' ),
			'type'      => Controls_Manager::CHOOSE,
			'options'   => Widget_Utils::get_control_options_text_align_full(),
			'selectors' => [
				'{{WRAPPER}} .billey-box' => 'text-align: {{VALUE}};',
			],
		] );

		$this->add_responsive_control( 'box_padding', [
			'label'      => esc_html__( 'Padding', 'billey' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [
				'{{WRAPPER}} .billey-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'box_max_width', [
			'label'      => esc_html__( 'Max Width', 'billey' ),
			'type'       => Controls_Manager::SLIDER,
			'default'    => [
				'unit' => 'px',
			],
			'size_units' => [ 'px', '%' ],
			'range'      => [
				'%'  => [
					'min' => 1,
					'max' => 100,
				],
				'px' => [
					'min' => 1,
					'max' => 1600,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} .billey-box' => 'max-width: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'box_horizontal_alignment', [
			'label'                => esc_html__( 'Horizontal Alignment', 'billey' ),
			'label_block'          => true,
			'type'                 => Controls_Manager::CHOOSE,
			'options'              => Widget_Utils::get_control_options_horizontal_alignment(),
			'default'              => 'center',
			'toggle'               => false,
			'selectors_dictionary' => [
				'left'  => 'flex-start',
				'right' => 'flex-end',
			],
			'selectors'            => [
				'{{WRAPPER}} .elementor-widget-container' => 'display: flex; justify-content: {{VALUE}}',
			],
		] );

		$this->start_controls_tabs( 'box_colors' );

		$this->start_controls_tab( 'box_colors_normal', [
			'label' => esc_html__( 'Normal', 'billey' ),
		] );

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'box',
			'selector' => '{{WRAPPER}} .billey-box',
		] );

		$this->add_group_control( Group_Control_Advanced_Border::get_type(), [
			'name'     => 'box_border',
			'selector' => '{{WRAPPER}} .billey-box',
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'box',
			'selector' => '{{WRAPPER}} .billey-box',
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'box_colors_hover', [
			'label' => esc_html__( 'Hover', 'billey' ),
		] );

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'box_hover',
			'selector' => '{{WRAPPER}} .billey-box:before',
		] );

		$this->add_group_control( Group_Control_Advanced_Border::get_type(), [
			'name'     => 'box_hover_border',
			'selector' => '{{WRAPPER}} .billey-box:hover',
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'box_hover',
			'selector' => '{{WRAPPER}} .billey-box:hover',
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control( 'box_line_heading', [
			'label'     => esc_html__( 'Special Line', 'billey' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'condition' => [
				'style' => [ '03' ],
			],
		] );

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'      => 'box_line',
			'selector'  => '{{WRAPPER}} .tm-image-box:after',
			'condition' => [
				'style' => [ '03' ],
			],
		] );

		$this->end_controls_section();
	}

	private function add_image_style_section() {
		$this->start_controls_section( 'image_style_section', [
			'label' => esc_html__( 'Image', 'billey' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'image_wrap_height', [
			'label'     => esc_html__( 'Wrap Height', 'billey' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 0,
					'max' => 200,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .billey-image' => 'min-height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'image_space_top', [
			'label'     => esc_html__( 'Offset Top', 'billey' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 0,
					'max' => 200,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .image' => 'margin-top: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'image_space', [
			'label'     => esc_html__( 'Spacing', 'billey' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 0,
					'max' => 200,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .image-position-right .image' => 'margin-left: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .image-position-left .image'  => 'margin-right: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .image-position-top .image'   => 'margin-bottom: {{SIZE}}{{UNIT}};',
				'(mobile){{WRAPPER}} .image'               => 'margin-bottom: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'image_width', [
			'label'          => esc_html__( 'Width', 'billey' ),
			'type'           => Controls_Manager::SLIDER,
			'default'        => [
				'unit' => '%',
			],
			'tablet_default' => [
				'unit' => '%',
			],
			'mobile_default' => [
				'unit' => '%',
			],
			'size_units'     => [ '%', 'px' ],
			'range'          => [
				'%'  => [
					'min' => 5,
					'max' => 50,
				],
				'px' => [
					'min' => 1,
					'max' => 1600,
				],
			],
			'selectors'      => [
				'{{WRAPPER}} .image' => 'width: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_group_control( Group_Control_Border::get_type(), [
			'name'      => 'image_border',
			'selector'  => '{{WRAPPER}} .image img',
			'separator' => 'before',
			'exclude'   => [
				'color',
			],
		] );

		$this->add_responsive_control( 'image_border_radius', [
			'label'      => esc_html__( 'Border Radius', 'billey' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->start_controls_tabs( 'image_effects' );

		$this->start_controls_tab( 'normal', [
			'label' => esc_html__( 'Normal', 'billey' ),
		] );

		$this->add_control( 'image_border_color', [
			'label'     => esc_html__( 'Border Color', 'billey' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .image img' => 'border-color: {{VALUE}};',
			],
			'condition' => [
				'image_border_border!' => '',
			],
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'image_box_shadow',
			'selector' => '{{WRAPPER}} .image img',
		] );

		$this->add_group_control( Group_Control_Css_Filter::get_type(), [
			'name'     => 'css_filters',
			'selector' => '{{WRAPPER}} .image img',
		] );

		$this->add_control( 'image_opacity', [
			'label'     => esc_html__( 'Opacity', 'billey' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'max'  => 1,
					'min'  => 0.10,
					'step' => 0.01,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .image img' => 'opacity: {{SIZE}};',
			],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover', [
			'label' => esc_html__( 'Hover', 'billey' ),
		] );

		$this->add_control( 'hover_image_border_color', [
			'label'     => esc_html__( 'Border Color', 'billey' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}}:hover .image img' => 'border-color: {{VALUE}};',
			],
			'condition' => [
				'image_border_border!' => '',
			],
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'hover_image_box_shadow',
			'selector' => '{{WRAPPER}}:hover  .image img',
		] );

		$this->add_group_control( Group_Control_Css_Filter::get_type(), [
			'name'     => 'css_filters_hover',
			'selector' => '{{WRAPPER}}:hover .image img',
		] );

		$this->add_control( 'image_opacity_hover', [
			'label'     => esc_html__( 'Opacity', 'billey' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'max'  => 1,
					'min'  => 0.10,
					'step' => 0.01,
				],
			],
			'selectors' => [
				'{{WRAPPER}}:hover .image img' => 'opacity: {{SIZE}};',
			],
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	private function add_content_style_section() {
		$this->start_controls_section( 'content_style_section', [
			'label' => esc_html__( 'Content', 'billey' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'heading_title', [
			'label'     => esc_html__( 'Title', 'billey' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'title_color', [
			'label'     => esc_html__( 'Color', 'billey' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .title' => 'color: {{VALUE}};',
			],
			'scheme'    => [
				'type'  => Schemes\Color::get_type(),
				'value' => Schemes\Color::COLOR_1,
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'title_typography',
			'selector' => '{{WRAPPER}} .title',
			'scheme'   => Schemes\Typography::TYPOGRAPHY_1,
		] );

		$this->add_control( 'heading_description', [
			'label'     => esc_html__( 'Description', 'billey' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_responsive_control( 'description_top_space', [
			'label'     => esc_html__( 'Spacing', 'billey' ),
			'type'      => Controls_Manager::SLIDER,
			'range'     => [
				'px' => [
					'min' => 0,
					'max' => 100,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .description' => 'margin-top: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_control( 'description_color', [
			'label'     => esc_html__( 'Color', 'billey' ),
			'type'      => Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .description' => 'color: {{VALUE}};',
			],
			'scheme'    => [
				'type'  => Schemes\Color::get_type(),
				'value' => Schemes\Color::COLOR_3,
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'description_typography',
			'selector' => '{{WRAPPER}} .description',
			'scheme'   => Schemes\Typography::TYPOGRAPHY_3,
		] );

		$this->end_controls_section();
	}

	private function add_button_style_section() {
		$this->start_controls_section( 'button_style_section', [
			'label'     => esc_html__( 'Button', 'billey' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'button_text!' => '',
			],
		] );

		$this->add_control( 'button_margin', [
			'label'      => esc_html__( 'Margin', 'billey' ),
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .tm-button-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'button_typography',
			'selector' => '{{WRAPPER}} .tm-button',
			'scheme'   => Schemes\Typography::TYPOGRAPHY_1,
		] );

		$this->start_controls_tabs( 'button_style_tabs' );

		$this->start_controls_tab( 'button_style_normal_tab', [
			'label' => esc_html__( 'Normal', 'billey' ),
		] );

		$this->add_group_control( Group_Control_Text_Gradient::get_type(), [
			'name'     => 'button',
			'selector' => '{{WRAPPER}} .tm-button .button-content-wrapper',
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'button_style_hover_tab', [
			'label' => esc_html__( 'Hover', 'billey' ),
		] );

		$this->add_group_control( Group_Control_Text_Gradient::get_type(), [
			'name'     => 'hover_text',
			'selector' => '{{WRAPPER}} .tm-button:hover .button-content-wrapper',
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control( 'special_line_heading', [
			'label'     => esc_html__( 'Line', 'billey' ),
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'special_line_height', [
			'label'      => esc_html__( 'Height', 'billey' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [
				'px' => [
					'min'  => 1,
					'max'  => 5,
					'step' => 1,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} .button-text:before, {{WRAPPER}} .button-text:after' => 'height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->start_controls_tabs( 'special_line_style_tabs' );

		$this->start_controls_tab( 'special_line_style_normal_tab', [
			'label' => esc_html__( 'Normal', 'billey' ),
		] );

		$this->add_control( 'special_line_color', [
			'label'     => esc_html__( 'Color', 'billey' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .button-text:before' => 'background: {{VALUE}};',
			],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'special_line_style_hover_tab', [
			'label' => esc_html__( 'Hover', 'billey' ),
		] );

		$this->add_control( 'hover_special_line_color', [
			'label'     => esc_html__( 'Color', 'billey' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .button-text:after' => 'background: {{VALUE}};',
			],
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'servicescur__top is--site' );


		$box_tag = 'div';
		if ( 'box' === $settings['link_click'] && ! empty( $settings['link']['url'] ) ) {
			$box_tag = 'a';
			$this->add_render_attribute( 'wrapper', 'class', 'link-secret' );
			$this->add_link_attributes( 'wrapper', $settings['link'] );
		}
		?>
		<div class="container-hybrid main" id="main-content">

<div class="hero hero-2 ov-slashes-combo-blue-hero bg-image-cover bg-overlay-repeat text-white d-none d-sm-block section-tuition-hero" style="background-image: url(../_assets/images/video-img/tuition-noblur.jpg);background-position-y: 0;background-position-x: 0;">
	<a aria-labelledby="playback-controls-label" class="playback-controls loaded playing" href="https://admission.universityofcalifornia.edu/tuition-financial-aid/#" role="button">
		<title id="playback-controls-label">Pause video playback</title>
		<span class="pause-icon"></span>
		<span class="play-icon"></span>
	</a>
	<div class="video-container">
			<video autoplay="autoplay" id="videoplayer" loop="loop" muted="muted" preload="auto" width="1507" height="848" class="loaded">
							<source data-src="./videos/tuition-noblur.mp4" src="./videos/tuition-noblur.mp4">
						</video>
	</div>
	<div class="hero-body container">
		<nav aria-label="breadcrumb" id="">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="https://admission.universityofcalifornia.edu/index.html">Home</a>
				</li>
				<li aria-current="page" class="breadcrumb-item active">Tuition &amp; financial aid</li>
			</ol>
		</nav>
		<div class="row">
			<div class="col" id="tuition-main-content">
				<h1 class="h5 mb-0"><?php echo $settings['slide_title_1']?></h1>
			</div>
		</div>
		<div class="row section-tuition-hero-stats">
			<div class="col">
				<div>
					<div class="section-tuition-hero-stats-amount">
						<p class="body-1"><?php echo $settings['slide_text_1']?></p>
						<p class="stat stat-1 stat-dollar text-gold">
							<span>$</span><?php echo $settings['slide_price_1']?>

						</p>
					</div>
					<div class="section-tuition-hero-stats-income">
						<p class="body-3">Californians, if your family's income is in this range and you qualify
							for financial aid, you won't pay any systemwide tuition and fees</p>
						<p class="stat stat-4 stat-dollar text-gold">
							<span>$</span>0–80,000

						</p>
					</div>
					<hr class="hr-3 bg-light">
					<div class="section-tuition-hero-stats-tuition">
						<p class="body-3">Tuition &amp; fees for the 2020-21 academic year:</p>
						<p class="stat stat-5 stat-dollar text-gold small-number">
							<span>$</span>14,100

						</p>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="row">
					<div class="col section-tuition-hero-stats-doughnut-1">
						<div class="doughnut size-md">
							<div class="circle text-gold front-stroke-light-teal back-stroke-light" id="exampleDoughnut6"><div class="circles-wrp"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 256 256"><path version="1.1" fill="transparent" d="M 127.97637390837136 12.000002406000917 A 116 116 0 1 1 127.83887832718369 12.000111897439524 Z" class="circles-maxValueStroke"></path><path version="1.1" fill="transparent" d="M 127.97637390837136 12.000002406000917 A 116 116 0 1 1 12.000020371819488 128.06874781239154 " class="circles-valueStroke"></path></svg><div class="circles-text-wrp"><div class="circles-text">75%</div><div class="circles-text-secondary"></div></div></div></div>
							<p class="circle-below-text">56% of CA undergrads pay
								<br>
								<strong>no tuition</strong>
							</p>
						</div>
					</div>
					<div class="col section-tuition-hero-stats-doughnut-2">
						<div class="doughnut size-xs">
							<div class="circle text-gold front-stroke-light-teal back-stroke-light" id="exampleDoughnut7"><div class="circles-wrp"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 114 114"><path version="1.1" fill="transparent" d="M 56.99042735942633 10.0000009748452 A 47 47 0 1 1 56.93471794291064 10.000045337755672 Z" class="circles-maxValueStroke"></path><path version="1.1" fill="transparent" d="M 56.99042735942633 10.0000009748452 A 47 47 0 1 1 11.491416538438024 68.74601342252119 " class="circles-valueStroke"></path></svg><div class="circles-text-wrp"><div class="circles-text">71%</div><div class="circles-text-secondary"></div></div></div></div>
							<p class="circle-below-text">71% of CA undergrads receive grants &amp; scholarships
							</p>
						</div>
						<div class="doughnut size-xs">
							<div class="circle text-gold front-stroke-light-teal back-stroke-light" id="exampleDoughnut8"><div class="circles-wrp"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 114 114"><path version="1.1" fill="transparent" d="M 56.99042735942633 10.0000009748452 A 47 47 0 1 1 56.93471794291064 10.000045337755672 Z" class="circles-maxValueStroke"></path><path version="1.1" fill="transparent" d="M 56.99042735942633 10.0000009748452 A 47 47 0 0 1 68.75528205788183 102.50619016946641 " class="circles-valueStroke"></path></svg><div class="circles-text-wrp"><div class="circles-text">46%</div><div class="circles-text-secondary"></div></div></div></div>
							<p class="circle-below-text">46% of CA students graduate with no student loan debt
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<a class="btn btn-primary btn-light-teal btn-apply-financial-aid-main" href="href="<?php echo $settings['slide_Button_link']?>><?php echo $settings['slide_button_text']?></a>
			</div>
		</div>
	</div>
</div>
<div aria-describedby="id_desc" aria-labelledby="id_title" class="carousel slide section-tuition-hero-carousel d-sm-none ov-slashes-combo-blue-hero bg-image-cover text-white" data-ride="carousel" id="tuitionCarousel" role="complementary" style="background-image: url(../_assets/images/video-img/tuition-noblur.jpg)" tabindex="0">
	<h2 class="sr-only" id="id_title">Carousel content with 3 slides.</h2>
	<p class="sr-only" id="id_desc">A carousel is a rotating set of images, rotation stops on keyboard focus on
		carousel tab controls or hovering the mouse pointer over images. Use the tabs to change the displayed
		slide.</p>
	<div class="hero-carousel-title container">
		<div class="row">
			<div class="col">
				<h4>Tuition &amp; financial aid</h4>
			</div>
		</div>
	</div>
	<div class="hero-carousel-indicators">
		<ol class="carousel-indicators" role="tablist" tabindex="0">
			<li aria-controls="tabpanel-0-0" class="active" data-slide-to="0" data-target="#tuitionCarousel" id="tab-0-0" role="tab" tabindex="0">
				<span class="sr-only">Slide 1: 56% of CA undergrads pay no tuition</span>
				<span class="sr-only">Slide 1:








					56%




					56% of CA undergrads pay
					no tuition



				</span><span class="sr-only">Slide 1: 
			
				
					
							
							
						
						
							56%
							
						
					
				
				56% of CA undergrads pay
					no tuition
				
			

		</span></li>
			<li aria-controls="tabpanel-0-1" class="" data-slide-to="1" data-target="#tuitionCarousel" id="tab-0-1" role="tab" tabindex="0">
				<span class="sr-only">Slide 2: 71% of CA undergrads receive grants &amp; scholarships</span>
				<span class="sr-only">Slide 2:








					71%




					71% of CA undergrads receive grants &amp; scholarships


				</span><span class="sr-only">Slide 2: 
			
				
					
							
							
						
						
							71%
							
						
					
				
				71% of CA undergrads receive grants &amp; scholarships
			

		</span></li>
			<li aria-controls="tabpanel-0-2" class="" data-slide-to="2" data-target="#tuitionCarousel" id="tab-0-2" role="tab" tabindex="0">
				<span class="sr-only">Slide 3: 46% of CA students graduate with no student loan debt</span>
				<span class="sr-only">Slide 3:








					46%




					46% of CA students graduate with no student loan debt

				</span><span class="sr-only">Slide 3: 
			
				
					
							
							
						
						
							46%
							
						
					
				
				46% of CA students graduate with no student loan debt
			
		</span></li>
		</ol>
	</div>
	<div aria-live="polite" class="carousel-inner">
		<div aria-labelledby="tab-0-0" class="carousel-item active" id="tabpanel-0-0" role="tabpanel">
			<div class="doughnut size-sp">
				<div class="circle text-gold front-stroke-light-teal back-stroke-light" id="exampleDoughnut9"><div class="circles-wrp"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 170 170"><path version="1.1" fill="transparent" d="M 84.98452083651917 9.000001576345426 A 76 76 0 1 1 84.89443752470656 9.00007331211556 Z" class="circles-maxValueStroke"></path><path version="1.1" fill="transparent" d="M 84.98452083651917 9.000001576345426 A 76 76 0 1 1 57.07818591636836 155.68502173925611 " class="circles-valueStroke"></path></svg><div class="circles-text-wrp"><div class="circles-text">56%</div><div class="circles-text-secondary"></div></div></div></div>
				<p class="circle-below-text">56% of CA undergrads pay
					<strong>no tuition</strong>
				</p>
			</div>

		</div>
		<div aria-labelledby="tab-0-1" class="carousel-item" id="tabpanel-0-1" role="tabpanel">
			<div class="doughnut size-sp">
				<div class="circle text-gold front-stroke-light-teal back-stroke-light" id="exampleDoughnut10"><div class="circles-wrp"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 170 170"><path version="1.1" fill="transparent" d="M 84.98452083651917 9.000001576345426 A 76 76 0 1 1 84.89443752470656 9.00007331211556 Z" class="circles-maxValueStroke"></path><path version="1.1" fill="transparent" d="M 84.98452083651917 9.000001576345426 A 76 76 0 1 1 11.411652274921053 103.99355361939595 " class="circles-valueStroke"></path></svg><div class="circles-text-wrp"><div class="circles-text">71%</div><div class="circles-text-secondary"></div></div></div></div>
				<p class="circle-below-text">71% of CA undergrads receive grants &amp; scholarships</p>
			</div>

		</div>
		<div aria-labelledby="tab-0-2" class="carousel-item" id="tabpanel-0-2" role="tabpanel">
			<div class="doughnut size-sp">
				<div class="circle text-gold front-stroke-light-teal back-stroke-light" id="exampleDoughnut11"><div class="circles-wrp"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 170 170"><path version="1.1" fill="transparent" d="M 84.98452083651917 9.000001576345426 A 76 76 0 1 1 84.89443752470656 9.00007331211556 Z" class="circles-maxValueStroke"></path><path version="1.1" fill="transparent" d="M 84.98452083651917 9.000001576345426 A 76 76 0 0 1 104.00854119997913 158.5844777208393 " class="circles-valueStroke"></path></svg><div class="circles-text-wrp"><div class="circles-text">46%</div><div class="circles-text-secondary"></div></div></div></div>
				<p class="circle-below-text">46% of CA students graduate with no student loan debt</p>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<a class="btn btn-primary btn-light-teal m-3 d-block" href="https://admission.universityofcalifornia.edu/tuition-financial-aid/apply-for-financial-aid/index.html">Apply
				for financial aid</a>
		</div>
	</div>
</div>

</div>
		<?php
	}

	private function print_title(array $settings) {
		if( empty( $settings['title_text'] ) ) {
			return;
		}

		$this->add_render_attribute( 'title_text', 'class', 'title' );

		$this->add_inline_editing_attributes( 'title_text', 'none' );

		$title_html = $settings['title_text'];

		printf( '<%1$s %2$s>%3$s</%1$s>', $settings['title_size'], $this->get_render_attribute_string( 'title_text' ), $title_html );
	}

	private function print_description (array $settings) {
		if (empty( $settings['description_text'] ) ) {
			return;
		}

		$this->add_render_attribute( 'description_text', 'class', 'description' );
		$this->add_inline_editing_attributes( 'description_text' );
		?>
		<div <?php $this->print_render_attribute_string('description_text'); ?>>
			<?php echo wp_kses($settings['description_text'], 'billey-default'); ?>
		</div>
		<?php
	}

	private function print_button (array $settings ) {
		if ( empty( $settings['button_text'] ) ) {
			return;
		}

		$button_tag = 'div';
		$this->add_render_attribute( 'button', 'class', 'tm-button style-text' );

		if ( 'button' === $settings['link_click'] && ! empty( $settings['link']['url'] ) ) {
			$button_tag = 'a';
			$this->add_link_attributes( 'button', $settings['link'] );
		}
		?>
		<div class="tm-button-wrapper">
			<?php printf('<%1$s %2$s>', $button_tag, $this->get_render_attribute_string( 'button' )); ?>
				<div class="button-content-wrapper">
					<span class="button-text"><?php echo esc_html($settings['button_text']); ?></span>
				</div>
			<?php printf('</%1$s>', $button_tag); ?>
		</div>
	<?php
	}
}
