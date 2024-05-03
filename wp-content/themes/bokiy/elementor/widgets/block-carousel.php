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

class Widget_Block_Carousel extends Base {

	public function get_name() {
		return 'tm-block_carousel';
	}

	public function get_title() {
		return esc_html__( 'Block Carousel', 'billey' );
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

		
		$this->add_control( 'left_text', [
			'label'     => esc_html__( 'Left content', 'billey' ),
			'type'      => Controls_Manager::WYSIWYG,
			'dynamic' => [
				'active' => true,
			],
		] );

		$this->add_control( 'right_text', [
			'label'     => esc_html__( 'Right content', 'billey' ),
			'type'      => Controls_Manager::WYSIWYG,
			'dynamic' => [
				'active' => true,
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

      <div class="twitter-box">
        <div class="twitter-box-wrapper">
          <div class="firstgen__twitter-carousel">
                <div class="slick-slide">
                  <div>
                    <div style="width: 100%; display: inline-block;">
                      <a href="https://twitter.com/PASantana12" target="_blank" rel="nofollow" tabindex="0">@PASantana12</a>: So excited to see this news, as a <a href="https://twitter.com/hashtag/firstgen?src=hash" target="_blank" rel="nofollow" tabindex="0">#firstgen</a> <a href="https://twitter.com/hashtag/comm_college?src=hash" target="_blank" rel="nofollow" tabindex="0">#comm_college</a> transfer student to UC many years ago! Thanks to a great education at <a href="https://twitter.com/GCCPIO" target="_blank" rel="nofollow" tabindex="0">@GCCPIO</a>, I felt very prepared to succeed at <a href="https://twitter.com/UCBerkeley" target="_blank" rel="nofollow" tabindex="0">@UCBerkeley</a>! <i class="e-blue-heart"></i> <i class="e-yellow-heart"></i>
                      <div class="twitter-details">
                        <a class="time" href="https://twitter.com/PASantana12/status/984246401608462337" target="_blank" tabindex="0">April 2018</a>
                        <a href="https://twitter.com/intent/tweet?in_reply_to=984246401608462337" data-lang="en" class="in-reply-to" title="Reply to @PASantana12" target="_blank" tabindex="0"><span>Reply<span class="sr-only"> to @PASantana12</span></span></a>
                        <a href="https://twitter.com/intent/retweet?tweet_id=984246401608462337" data-lang="en" class="retweet" title="Retweet @PASantana12" target="_blank" tabindex="0"><span>Retweet<span class="sr-only"> @PASantana12</span></span></a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="slick-slide">
                  <div>
                    <div class="slick-slide__longer-tweet" style="width: 100%; display: inline-block;">
                      <a href="https://twitter.com/UCBerkeley" target="_blank" rel="nofollow" tabindex="-1">@UCBerkeley</a>: For <a href="https://twitter.com/hashtag/LGBTSTEMDay?src=hash" target="_blank" rel="nofollow" tabindex="-1">#LGBTSTEMDay</a> - Biology prof Noah Whiteman on growing up <a href="https://twitter.com/hashtag/LGBTQ?src=hash" target="_blank" rel="nofollow" tabindex="-1">#LGBTQ</a> in rural MN: "I try to provide an environment for students where they know they are valued &amp; that who they are on a personal level is ok &amp; that they’re going to be ok." <a href="https://twitter.com/hashtag/FirstGen?src=hash" target="_blank" rel="nofollow" tabindex="-1">#FirstGen</a> <a href="https://twitter.com/hashtag/Pride?src=hash" target="_blank" rel="nofollow" tabindex="-1">#Pride</a> <a href="https://t.co/bBBDqG8unB" target="_blank" tabindex="-1">bit.ly/2IOAGaH</a>
                      <div class="twitter-details">
                        <a class="time" href="https://twitter.com/UCBerkeley/status/1014933773966856192" target="_blank" tabindex="-1">July 2018</a>
                        <a href="https://twitter.com/intent/tweet?in_reply_to=1014933773966856192" data-lang="en" class="in-reply-to" title="Reply to @UCBerkeley" target="_blank" tabindex="-1"><span>Reply<span class="sr-only"> to @UCBerkeley</span></span></a>
                        <a href="https://twitter.com/intent/retweet?tweet_id=1014933773966856192" data-lang="en" class="retweet" title="Retweet @UCBerkeley" target="_blank" tabindex="-1"><span>Retweet<span class="sr-only"> @UCBerkeley</span></span></a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="slick-slide">
                  <div>
                    <div style="width: 100%; display: inline-block;">
                      <a href="https://twitter.com/_lavere3" target="_blank" rel="nofollow" tabindex="-1">@_lavere3</a>: Proud of my alma mater, <a href="https://twitter.com/UCLA" target="_blank" rel="nofollow" tabindex="-1">@UCLA</a>, and the rest of the UC system for showcasing how representative mentorship is key to retention and completion for <a href="https://twitter.com/hashtag/firstgen?src=hash" target="_blank" rel="nofollow" tabindex="-1">#firstgen</a> students. Impostor syndrome is a real thing.
                      <div class="twitter-details">
                        <a class="time" href="https://twitter.com/_lavere3/status/996582338673823744" target="_blank" tabindex="-1">May 2018</a>
                        <a href="https://twitter.com/intent/tweet?in_reply_to=996582338673823744" data-lang="en" class="in-reply-to" title="Reply to @_lavere3" target="_blank" tabindex="-1"><span>Reply<span class="sr-only"> to @_lavere3</span></span></a>
                        <a href="https://twitter.com/intent/retweet?tweet_id=996582338673823744" data-lang="en" class="retweet" title="Retweet @_lavere3" target="_blank" tabindex="-1"><span>Retweet<span class="sr-only"> @_lavere3</span></span></a>
                      </div>
                    </div>
                  </div>
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



