<?php
/**
 * Class: Jet_Woo_Widgets_Products
 * Name: Products Grid
 * Slug: jet-woo-products
 */

namespace Elementor;

use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Jet_Woo_Widgets_Products extends Jet_Woo_Widgets_Base {

	public function get_name() {
		return 'jet-woo-widgets-products';
	}

	public function get_title() {
		return esc_html__( 'Woo Products Grid', 'jetwoo-widgets-for-elementor' );
	}

	public function get_icon() {
		return 'jetwoowidgets-icon-89';
	}

	public function get_categories() {
		return array( 'jetwoo-widgets-for-elementor' );
	}

	public function __shortcode() {
		return jet_woo_widgets_shortocdes()->get_shortcode( $this->get_name() );
	}

	public function get_script_depends() {
		return array( 'jquery-slick' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_general',
			array(
				'label' => esc_html__( 'General', 'jetwoo-widgets-for-elementor' ),
			)
		);

		$attributes = $this->__shortcode()->get_atts();

		foreach ( $attributes as $attr => $settings ) {

			if ( empty( $settings['type'] ) ) {
				continue;
			}

			if ( ! empty( $settings['responsive'] ) ) {
				$this->add_responsive_control( $attr, $settings );
			} else {
				$this->add_control( $attr, $settings );
			}

		}

		$this->end_controls_section();

		$css_scheme = apply_filters(
			'jet-woo-widgets/jet-woo-products/css-scheme',
			array(
				'wrap'        => '.jet-woo-products',
				'column'      => '.jet-woo-products .jet-woo-products__item',
				'inner-box'   => '.jet-woo-products .jet-woo-products__inner-box',
				'thumb'       => '.jet-woo-products .jet-woo-product-thumbnail',
				'title'       => '.jet-woo-products .jet-woo-product-title a',
				'title-wrap'  => '.jet-woo-products .jet-woo-product-title',
				'categories'  => '.jet-woo-products .jet-woo-product-categories a',
				'cats-wrap'   => '.jet-woo-products .jet-woo-product-categories',
				'tags'        => '.jet-woo-products .jet-woo-product-tags a',
				'tags-wrap'   => '.jet-woo-products .jet-woo-product-tags',
				'excerpt'     => '.jet-woo-products .jet-woo-product-excerpt',
				'rating'      => '.jet-woo-products .jet-woo-product-rating',
				'price'       => '.jet-woo-products .jet-woo-product-price',
				'currency'    => '.jet-woo-products .jet-woo-product-price .woocommerce-Price-currencySymbol',
				'button-wrap' => '.jet-woo-products .jet-woo-product-button',
				'button'      => '.jet-woo-products .jet-woo-product-button .button',
				'overlay'     => '.jet-woo-products .jet-woo-product-img-overlay',
				'badges'      => '.jet-woo-products .jet-woo-product-badges',
				'badge'       => '.jet-woo-products .jet-woo-product-badge',
			)
		);

		$this->start_controls_section(
			'section_carousel',
			array(
				'label' => esc_html__( 'Carousel', 'jetwoo-widgets-for-elementor' ),
			)
		);

		$this->add_control(
			'carousel_enabled',
			array(
				'label'        => esc_html__( 'Enable Carousel', 'jetwoo-widgets-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jetwoo-widgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwoo-widgets-for-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->add_responsive_control(
			'slides_min_height',
			array(
				'label'       => esc_html__( 'Slides Minimal Height', 'jetwoo-widgets-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => '',
				'selectors'   => array(
					'{{WRAPPER}} ' . $css_scheme['inner-box'] => 'min-height: {{VALUE}}px;',
				),
				'condition' => array(
					'carousel_enabled!' => '',
				),
			)
		);

		$this->add_control(
			'slides_to_scroll',
			array(
				'label'     => esc_html__( 'Slides to Scroll', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '1',
				'options'   => jet_woo_widgets_tools()->get_select_range( 4 ),
				'condition' => array(
					'carousel_enabled!' => '',
					'columns!' => '1',
				),
			)
		);

		$this->add_control(
			'arrows',
			array(
				'label'        => esc_html__( 'Show Arrows Navigation', 'jetwoo-widgets-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jetwoo-widgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwoo-widgets-for-elementor' ),
				'return_value' => 'true',
				'default'      => 'true',
				'condition' => array(
					'carousel_enabled!' => '',
				),
			)
		);

		$this->add_control(
			'prev_arrow',
			array(
				'label'     => esc_html__( 'Prev Arrow Icon', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'fa fa-angle-left',
				'options'   => jet_woo_widgets_tools()->get_available_prev_arrows_list(),
				'condition' => array(
					'carousel_enabled!' => '',
					'arrows' => 'true',
				),
			)
		);

		$this->add_control(
			'next_arrow',
			array(
				'label'     => esc_html__( 'Next Arrow Icon', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'fa fa-angle-right',
				'options'   => jet_woo_widgets_tools()->get_available_next_arrows_list(),
				'condition' => array(
					'carousel_enabled!' => '',
					'arrows' => 'true',
				),
			)
		);

		$this->add_control(
			'dots',
			array(
				'label'        => esc_html__( 'Show Dots Navigation', 'jetwoo-widgets-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jetwoo-widgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwoo-widgets-for-elementor' ),
				'return_value' => 'true',
				'default'      => '',
				'condition' => array(
					'carousel_enabled!' => '',
				),
			)
		);

		$this->add_control(
			'pause_on_hover',
			array(
				'label'        => esc_html__( 'Pause on Hover', 'jetwoo-widgets-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jetwoo-widgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwoo-widgets-for-elementor' ),
				'return_value' => 'true',
				'default'      => '',
				'condition' => array(
					'carousel_enabled!' => '',
				),
			)
		);

		$this->add_control(
			'autoplay',
			array(
				'label'        => esc_html__( 'Autoplay', 'jetwoo-widgets-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jetwoo-widgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwoo-widgets-for-elementor' ),
				'return_value' => 'true',
				'default'      => 'true',
				'condition' => array(
					'carousel_enabled!' => '',
				),
			)
		);

		$this->add_control(
			'autoplay_speed',
			array(
				'label'     => esc_html__( 'Autoplay Speed', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'condition' => array(
					'carousel_enabled!' => '',
					'autoplay' => 'true',
				),
			)
		);

		$this->add_control(
			'infinite',
			array(
				'label'        => esc_html__( 'Infinite Loop', 'jetwoo-widgets-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jetwoo-widgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwoo-widgets-for-elementor' ),
				'return_value' => 'true',
				'default'      => 'true',
				'condition' => array(
					'carousel_enabled!' => '',
				),
			)
		);

		$this->add_control(
			'effect',
			array(
				'label'     => esc_html__( 'Effect', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'slide',
				'options'   => array(
					'slide' => esc_html__( 'Slide', 'jetwoo-widgets-for-elementor' ),
					'fade'  => esc_html__( 'Fade', 'jetwoo-widgets-for-elementor' ),
				),
				'condition' => array(
					'carousel_enabled!' => '',
					'columns' => '1',
				),
			)
		);

		$this->add_control(
			'speed',
			array(
				'label'   => esc_html__( 'Animation Speed', 'jetwoo-widgets-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 500,
				'condition' => array(
					'carousel_enabled!' => '',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_column_style',
			array(
				'label'      => esc_html__( 'Column', 'jetwoo-widgets-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'column_padding',
			array(
				'label'       => esc_html__( 'Column Padding', 'jetwoo-widgets-for-elementor' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array( 'px' ),
				'render_type' => 'template',
				'selectors'   => array(
					'{{WRAPPER}} ' . $css_scheme['column'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} ' . $css_scheme['wrap']   => 'margin-right: -{{RIGHT}}{{UNIT}}; margin-left: -{{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_style',
			array(
				'label'      => esc_html__( 'Product Item', 'jetwoo-widgets-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->controls_section_box( $css_scheme );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_thumb_style',
			array(
				'label'      => esc_html__( 'Product Thumbnail', 'jetwoo-widgets-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->controls_section_thumbnail( $css_scheme );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_style',
			array(
				'label'      => esc_html__( 'Title', 'jetwoo-widgets-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->controls_section_title( $css_scheme );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_excerpt_style',
			array(
				'label'      => esc_html__( 'Excerpt', 'jetwoo-widgets-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->controls_section_excerpt( $css_scheme );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button_style',
			array(
				'label'      => esc_html__( 'Button', 'jetwoo-widgets-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->controls_section_button( $css_scheme );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_price_style',
			array(
				'label'      => esc_html__( 'Price', 'jetwoo-widgets-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->controls_section_price( $css_scheme );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_rating_styles',
			array(
				'label'      => esc_html__( 'Rating', 'jetwoo-widgets-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->controls_section_rating( $css_scheme );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_cats_style',
			array(
				'label'      => esc_html__( 'Categories', 'jetwoo-widgets-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->controls_section_categories( $css_scheme );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_tags_style',
			array(
				'label'      => esc_html__( 'Tags', 'jetwoo-widgets-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->controls_section_tags( $css_scheme );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_badges_style',
			array(
				'label'      => esc_html__( 'Badges', 'jetwoo-widgets-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->controls_section_badges( $css_scheme );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_overlay_style',
			array(
				'label'      => esc_html__( 'Overlay', 'jetwoo-widgets-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->controls_section_overlay( $css_scheme );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_arrows_style',
			array(
				'label'      => esc_html__( 'Carousel Arrows', 'jetwoo-widgets-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
				'condition'  => array(
					'carousel_enabled' => 'yes'
				)
			)
		);

		$this->controls_section_carousel_arrows();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_dots_style',
			array(
				'label'      => esc_html__( 'Carousel Dots', 'jetwoo-widgets-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
				'condition'  => array(
					'carousel_enabled' => 'yes'
				)
			)
		);

		$this->controls_section_carousel_dots();

		$this->end_controls_section();

	}

	protected function render() {
		$this->__context = 'render';

		$this->__open_wrap();

		$attributes    = array();
		$tag           = $this->get_name();
		$settings      = $this->get_settings();
		$shortcode_obj = $this->__shortcode();

		foreach ( $shortcode_obj->get_atts() as $attr => $data ) {
			$attr_val            = $settings[ $attr ];
			$attr_val            = ! is_array( $attr_val ) ? $attr_val : implode( ',', $attr_val );
			$attributes[ $attr ] = $attr_val;
		}

		echo jet_woo_widgets_tools()->get_carousel_wrapper_atts( $shortcode_obj->do_shortcode( $attributes ), $settings );

		$this->__close_wrap();
	}

	protected function controls_section_box( $css_scheme ) {

		$this->add_control(
			'box_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['inner-box'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'box_border',
				'label'       => esc_html__( 'Border', 'jetwoo-widgets-for-elementor' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['inner-box'],
			)
		);

		$this->add_responsive_control(
			'box_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['inner-box'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'inner_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['inner-box'],
			)
		);

		$this->add_responsive_control(
			'box_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['inner-box'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before'
			)
		);

	}

	protected function controls_section_overlay( $css_scheme ) {

		$this->start_controls_tabs( 'tabs_overlay_style' );

		$this->start_controls_tab(
			'tab_overlay_normal',
			array(
				'label' => esc_html__( 'Normal', 'jetwoo-widgets-for-elementor' ),
			)
		);

		$this->add_control(
			'overlay_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['overlay'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_overlay_hover',
			array(
				'label' => esc_html__( 'Hover', 'jetwoo-widgets-for-elementor' ),
			)
		);

		$this->add_control(
			'overlay_bg_hover',
			array(
				'label'     => esc_html__( 'Background Color', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['column'] . ':hover .jet-woo-product-img-overlay' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

	}

	protected function controls_section_tags( $css_scheme ) {

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'tags_typography',
				'global' => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector' => '{{WRAPPER}} ' . $css_scheme['tags'],
				'exclude' => array( 'text_decoration' ),
			)
		);

		$this->add_control(
			'tags_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['tags'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_tags_color' );

		$this->start_controls_tab(
			'tab_tags_color_normal',
			array(
				'label' => esc_html__( 'Normal', 'jetwoo-widgets-for-elementor' ),
			)
		);

		$this->add_control(
			'tags_color',
			array(
				'label'     => esc_html__( 'Color', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global' => array(
					'default' => Global_Colors::COLOR_SECONDARY,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['tags'] . ' a' => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['tags']        => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_tags_color_hover',
			array(
				'label' => esc_html__( 'Hover', 'jetwoo-widgets-for-elementor' ),
			)
		);

		$this->add_control(
			'tags_color_hover',
			array(
				'label'     => esc_html__( 'Color', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global' => array(
					'default' => Global_Colors::COLOR_SECONDARY,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['tags'] . ':hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'tags_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'jetwoo-widgets-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'jetwoo-widgets-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'jetwoo-widgets-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'classes'   => 'elementor-control-align',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['tags-wrap'] => 'text-align: {{VALUE}};',
				),
				'separator' => 'before'
			)
		);

		$this->add_responsive_control(
			'tags_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['tags-wrap'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'tags_margin',
			array(
				'label'      => esc_html__( 'Margin', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['tags-wrap'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'tags_order',
			array(
				'type'      => Controls_Manager::NUMBER,
				'label'     => esc_html__( 'Order', 'jetwoo-widgets-for-elementor' ),
				'default'   => 1,
				'min'       => 1,
				'max'       => 10,
				'step'      => 1,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['tags-wrap'] => 'order: {{VALUE}}',
				),
				'condition' => array(
					'presets' => array( 'preset-1' )
				)
			)
		);

	}

	protected function controls_section_categories( $css_scheme ) {

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'cats_typography',
				'global' => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector' => '{{WRAPPER}} ' . $css_scheme['categories'],
				'exclude' => array( 'text_decoration' ),
			)
		);

		$this->add_control(
			'cats_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['categories'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_cats_color' );

		$this->start_controls_tab(
			'tab_cats_color_normal',
			array(
				'label' => esc_html__( 'Normal', 'jetwoo-widgets-for-elementor' ),
			)
		);

		$this->add_control(
			'cats_color',
			array(
				'label'     => esc_html__( 'Color', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global' => array(
					'default' => Global_Colors::COLOR_SECONDARY,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['categories'] . ' a' => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['categories']        => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_cats_color_hover',
			array(
				'label' => esc_html__( 'Hover', 'jetwoo-widgets-for-elementor' ),
			)
		);

		$this->add_control(
			'cats_color_hover',
			array(
				'label'     => esc_html__( 'Color', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global' => array(
					'default' => Global_Colors::COLOR_SECONDARY,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['categories'] . ':hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'cats_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'jetwoo-widgets-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'jetwoo-widgets-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'jetwoo-widgets-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'classes'   => 'elementor-control-align',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['cats-wrap'] => 'text-align: {{VALUE}};',
				),
				'separator' => 'before'
			)
		);

		$this->add_responsive_control(
			'cats_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['cats-wrap'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'cats_margin',
			array(
				'label'      => esc_html__( 'Margin', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['cats-wrap'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'cats_order',
			array(
				'type'      => Controls_Manager::NUMBER,
				'label'     => esc_html__( 'Order', 'jetwoo-widgets-for-elementor' ),
				'default'   => 1,
				'min'       => 1,
				'max'       => 10,
				'step'      => 1,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['cats-wrap'] => 'order: {{VALUE}}',
				),
				'condition' => array(
					'presets' => array( 'preset-1' )
				)
			)
		);

	}

	protected function controls_section_price( $css_scheme ) {

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'price_typography',
				'selector' => '{{WRAPPER}} ' . $css_scheme['price'],
			)
		);

		$this->add_control(
			'price_color',
			array(
				'label'     => esc_html__( 'Color', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'price_space_between',
			array(
				'label'     => esc_html__( 'Space Between Prices', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 200,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' del+ins' => 'margin-left: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_price_style' );

		$this->start_controls_tab(
			'tab_price_regular',
			array(
				'label' => esc_html__( 'Regular', 'jetwoo-widgets-for-elementor' ),
			)
		);

		$this->add_control(
			'price_regular_color',
			array(
				'label'     => esc_html__( 'Color', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' del' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'price_regular_decoration',
			array(
				'label'     => esc_html__( 'Text Decoration', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'line-through',
				'options'   => array(
					'none'         => esc_html__( 'None', 'jetwoo-widgets-for-elementor' ),
					'line-through' => esc_html__( 'Line Through', 'jetwoo-widgets-for-elementor' ),
					'underline'    => esc_html__( 'Underline', 'jetwoo-widgets-for-elementor' ),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' del' => 'text-decoration: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'price_regular_size',
			array(
				'label'     => esc_html__( 'Size', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 6,
						'max' => 90,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' del' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'price_regular_weight',
			array(
				'label'     => esc_html__( 'Font Weight', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '400',
				'options'   => array(
					'100' => esc_html__( '100', 'jetwoo-widgets-for-elementor' ),
					'200' => esc_html__( '200', 'jetwoo-widgets-for-elementor' ),
					'300' => esc_html__( '300', 'jetwoo-widgets-for-elementor' ),
					'400' => esc_html__( '400', 'jetwoo-widgets-for-elementor' ),
					'500' => esc_html__( '500', 'jetwoo-widgets-for-elementor' ),
					'600' => esc_html__( '600', 'jetwoo-widgets-for-elementor' ),
					'700' => esc_html__( '700', 'jetwoo-widgets-for-elementor' ),
					'800' => esc_html__( '800', 'jetwoo-widgets-for-elementor' ),
					'900' => esc_html__( '900', 'jetwoo-widgets-for-elementor' ),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' del' => 'font-weight: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_price_sale',
			array(
				'label' => esc_html__( 'Sale', 'jetwoo-widgets-for-elementor' ),
			)
		);

		$this->add_control(
			'price_sale_color',
			array(
				'label'     => esc_html__( 'Color', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' ins' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'price_sale_decoration',
			array(
				'label'     => esc_html__( 'Text Decoration', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'none',
				'options'   => array(
					'none'         => esc_html__( 'None', 'jetwoo-widgets-for-elementor' ),
					'line-through' => esc_html__( 'Line Through', 'jetwoo-widgets-for-elementor' ),
					'underline'    => esc_html__( 'Underline', 'jetwoo-widgets-for-elementor' ),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' ins' => 'text-decoration: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'price_sale_size',
			array(
				'label'     => esc_html__( 'Size', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 6,
						'max' => 90,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' ins' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'price_sale_weight',
			array(
				'label'     => esc_html__( 'Font Weight', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '400',
				'options'   => array(
					'100' => esc_html__( '100', 'jetwoo-widgets-for-elementor' ),
					'200' => esc_html__( '200', 'jetwoo-widgets-for-elementor' ),
					'300' => esc_html__( '300', 'jetwoo-widgets-for-elementor' ),
					'400' => esc_html__( '400', 'jetwoo-widgets-for-elementor' ),
					'500' => esc_html__( '500', 'jetwoo-widgets-for-elementor' ),
					'600' => esc_html__( '600', 'jetwoo-widgets-for-elementor' ),
					'700' => esc_html__( '700', 'jetwoo-widgets-for-elementor' ),
					'800' => esc_html__( '800', 'jetwoo-widgets-for-elementor' ),
					'900' => esc_html__( '900', 'jetwoo-widgets-for-elementor' ),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' ins' => 'font-weight: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'price_item_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'jetwoo-widgets-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'jetwoo-widgets-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'jetwoo-widgets-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'classes'   => 'elementor-control-align',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] => 'text-align: {{VALUE}};',
				),
				'separator' => 'before'
			)
		);

		$this->add_responsive_control(
			'price_margin',
			array(
				'label'      => esc_html__( 'Margin', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['price'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'price_order',
			array(
				'type'      => Controls_Manager::NUMBER,
				'label'     => esc_html__( 'Order', 'jetwoo-widgets-for-elementor' ),
				'default'   => 1,
				'min'       => 1,
				'max'       => 10,
				'step'      => 1,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] => 'order: {{VALUE}}',
				),
				'condition' => array(
					'presets' => array( 'preset-1' )
				)
			)
		);

		$this->add_control(
			'currency_sign_style',
			array(
				'label'     => esc_html__( 'Currency Sign', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'currency_sign_color',
			array(
				'label'     => esc_html__( 'Color', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['currency'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'currency_sign_size',
			array(
				'label'     => esc_html__( 'Size', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 6,
						'max' => 90,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['currency'] => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'currency_sign_vertical_align',
			array(
				'label'     => esc_html__( 'Vertical Alignment', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'baseline'    => esc_html__( 'Baseline', 'jetwoo-widgets-for-elementor' ),
					'top'         => esc_html__( 'Top', 'jetwoo-widgets-for-elementor' ),
					'middle'      => esc_html__( 'Middle', 'jetwoo-widgets-for-elementor' ),
					'bottom'      => esc_html__( 'Bottom', 'jetwoo-widgets-for-elementor' ),
					'sub'         => esc_html__( 'Sub', 'jetwoo-widgets-for-elementor' ),
					'super'       => esc_html__( 'Super', 'jetwoo-widgets-for-elementor' ),
					'text-top'    => esc_html__( 'Text Top', 'jetwoo-widgets-for-elementor' ),
					'text-bottom' => esc_html__( 'Text Bottom', 'jetwoo-widgets-for-elementor' ),
				),
				'default'   => 'baseline',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['currency'] => 'vertical-align: {{VALUE}};',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_currency_sign_style' );

		$this->start_controls_tab(
			'tab_currency_sign_regular',
			array(
				'label' => esc_html__( 'Regular', 'jetwoo-widgets-for-elementor' ),
			)
		);

		$this->add_control(
			'currency_sign_color_regular',
			array(
				'label'     => esc_html__( 'Color', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' del .woocommerce-Price-currencySymbol' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'currency_sign_size_regular',
			array(
				'label'     => esc_html__( 'Size', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 6,
						'max' => 90,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' del .woocommerce-Price-currencySymbol' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_currency_sign_sale',
			array(
				'label' => esc_html__( 'Sale', 'jetwoo-widgets-for-elementor' ),
			)
		);

		$this->add_control(
			'currency_sign_color_sale',
			array(
				'label'     => esc_html__( 'Color', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' ins .woocommerce-Price-currencySymbol' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'currency_sign_size_sale',
			array(
				'label'     => esc_html__( 'Size', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 6,
						'max' => 90,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] . ' ins .woocommerce-Price-currencySymbol' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

	}

	protected function controls_section_badges( $css_scheme ) {

		$this->add_control(
			'badges_display',
			array(
				'label'     => esc_html__( 'Badges Display', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'inline-block' => esc_html__( 'Inline', 'jetwoo-widgets-for-elementor' ),
					'block'        => esc_html__( 'Block', 'jetwoo-widgets-for-elementor' ),
				),
				'default'   => 'inline-block',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['badge'] => 'display: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'badges_min_width',
			array(
				'label'       => esc_html__( 'Min Width', 'jetwoo-widgets-for-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px' ),
				'range'       => array(
					'px' => array(
						'min' => 0,
						'max' => 300,
					),
				),
				'selectors'   => array(
					'{{WRAPPER}} ' . $css_scheme['badge'] => 'min-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'badges_min_height',
			array(
				'label'       => esc_html__( 'Min Height', 'jetwoo-widgets-for-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px' ),
				'range'       => array(
					'px' => array(
						'min' => 0,
						'max' => 300,
					),
				),
				'selectors'   => array(
					'{{WRAPPER}} ' . $css_scheme['badge'] => 'min-height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'badge_typography',
				'global' => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector' => '{{WRAPPER}}  ' . $css_scheme['badge'],
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'badge_on_sale_border',
				'label'       => esc_html__( 'Border', 'jetwoo-widgets-for-elementor' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['badge'],
				'separator'   => 'before'
			)
		);

		$this->add_responsive_control(
			'badge_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['badge'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'badge_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['badge'],
			)
		);

		$this->add_control(
			'badge_on_sale_color',
			array(
				'label'     => esc_html__( 'Badge Color', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['badge'] => 'color: {{VALUE}}',
				),
				'separator' => 'before'
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'           => 'badge_on_sale_background',
				'fields_options' => array(
					'attachment' => array(
						'condition' => array()
					)
				),
				'selector'       => '{{WRAPPER}} ' . $css_scheme['badge'],
			)
		);

		$this->add_responsive_control(
			'badge_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'left',
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'jetwoo-widgets-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'jetwoo-widgets-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'jetwoo-widgets-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'classes'   => 'elementor-control-align',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['badges'] => 'text-align: {{VALUE}};',
				),
				'separator' => 'before'
			)
		);

		$this->add_responsive_control(
			'badge_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['badge'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'badge_margin',
			array(
				'label'      => esc_html__( 'Margin', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['badge'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

	}

	protected function controls_section_button( $css_scheme ) {
		$this->add_control(
			'button_display',
			array(
				'label'     => esc_html__( 'Button Display', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'inline-block' => esc_html__( 'Inline', 'jetwoo-widgets-for-elementor' ),
					'block'        => esc_html__( 'Block', 'jetwoo-widgets-for-elementor' ),
				),
				'default'   => 'inline-block',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'display: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'global' => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector' => '{{WRAPPER}}  ' . $css_scheme['button'],
			)
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			array(
				'label' => esc_html__( 'Normal', 'jetwoo-widgets-for-elementor' ),
			)
		);

		$this->add_control(
			'button_bg',
			array(
				'label'       => _x( 'Background Type', 'Background Control', 'jetwoo-widgets-for-elementor' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => array(
					'color'    => array(
						'title' => _x( 'Classic', 'Background Control', 'jetwoo-widgets-for-elementor' ),
						'icon'  => 'eicon-paint-brush',
					),
					'gradient' => array(
						'title' => _x( 'Gradient', 'Background Control', 'jetwoo-widgets-for-elementor' ),
						'icon'  => 'eicon-barcode',
					),
				),
				'default'     => 'color',
				'label_block' => false,
				'render_type' => 'ui',
			)
		);

		$this->add_control(
			'button_bg_color',
			array(
				'label'     => _x( 'Color', 'Background Control', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'global' => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'title'     => _x( 'Background Color', 'Background Control', 'jetwoo-widgets-for-elementor' ),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_bg_color_stop',
			array(
				'label'       => _x( 'Location', 'Background Control', 'jetwoo-widgets-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( '%' ),
				'default'     => array(
					'unit' => '%',
					'size' => 0,
				),
				'render_type' => 'ui',
				'condition'   => array(
					'button_bg' => array( 'gradient' ),
				),
				'of_type'     => 'gradient',
			)
		);

		$this->add_control(
			'button_bg_color_b',
			array(
				'label'       => _x( 'Second Color', 'Background Control', 'jetwoo-widgets-for-elementor' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#f2295b',
				'render_type' => 'ui',
				'condition'   => array(
					'button_bg' => array( 'gradient' ),
				),
				'of_type'     => 'gradient',
			)
		);

		$this->add_control(
			'button_bg_color_b_stop',
			array(
				'label'       => _x( 'Location', 'Background Control', 'jetwoo-widgets-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( '%' ),
				'default'     => array(
					'unit' => '%',
					'size' => 100,
				),
				'render_type' => 'ui',
				'condition'   => array(
					'button_bg' => array( 'gradient' ),
				),
				'of_type'     => 'gradient',
			)
		);

		$this->add_control(
			'button_bg_gradient_type',
			array(
				'label'       => _x( 'Type', 'Background Control', 'jetwoo-widgets-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'linear' => _x( 'Linear', 'Background Control', 'jetwoo-widgets-for-elementor' ),
					'radial' => _x( 'Radial', 'Background Control', 'jetwoo-widgets-for-elementor' ),
				),
				'default'     => 'linear',
				'render_type' => 'ui',
				'condition'   => array(
					'button_bg' => array( 'gradient' ),
				),
				'of_type'     => 'gradient',
			)
		);

		$this->add_control(
			'button_bg_gradient_angle',
			array(
				'label'      => _x( 'Angle', 'Background Control', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'deg' ),
				'default'    => array(
					'unit' => 'deg',
					'size' => 180,
				),
				'range'      => array(
					'deg' => array(
						'step' => 10,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{button_bg_color.VALUE}} {{button_bg_color_stop.SIZE}}{{button_bg_color_stop.UNIT}}, {{button_bg_color_b.VALUE}} {{button_bg_color_b_stop.SIZE}}{{button_bg_color_b_stop.UNIT}})',
				),
				'condition'  => array(
					'button_bg'               => array( 'gradient' ),
					'button_bg_gradient_type' => 'linear',
				),
				'of_type'    => 'gradient',
			)
		);

		$this->add_control(
			'button_bg_gradient_position',
			array(
				'label'     => _x( 'Position', 'Background Control', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'center center' => _x( 'Center Center', 'Background Control', 'jetwoo-widgets-for-elementor' ),
					'center left'   => _x( 'Center Left', 'Background Control', 'jetwoo-widgets-for-elementor' ),
					'center right'  => _x( 'Center Right', 'Background Control', 'jetwoo-widgets-for-elementor' ),
					'top center'    => _x( 'Top Center', 'Background Control', 'jetwoo-widgets-for-elementor' ),
					'top left'      => _x( 'Top Left', 'Background Control', 'jetwoo-widgets-for-elementor' ),
					'top right'     => _x( 'Top Right', 'Background Control', 'jetwoo-widgets-for-elementor' ),
					'bottom center' => _x( 'Bottom Center', 'Background Control', 'jetwoo-widgets-for-elementor' ),
					'bottom left'   => _x( 'Bottom Left', 'Background Control', 'jetwoo-widgets-for-elementor' ),
					'bottom right'  => _x( 'Bottom Right', 'Background Control', 'jetwoo-widgets-for-elementor' ),
				),
				'default'   => 'center center',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{button_bg_color.VALUE}} {{button_bg_color_stop.SIZE}}{{button_bg_color_stop.UNIT}}, {{button_bg_color_b.VALUE}} {{button_bg_color_b_stop.SIZE}}{{button_bg_color_b_stop.UNIT}})',
				),
				'condition' => array(
					'button_bg'               => array( 'gradient' ),
					'button_bg_gradient_type' => 'radial',
				),
				'of_type'   => 'gradient',
			)
		);

		$this->add_control(
			'button_color',
			array(
				'label'     => esc_html__( 'Text Color', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'button_text_decor',
			array(
				'label'     => esc_html__( 'Text Decoration', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'none'      => esc_html__( 'None', 'jetwoo-widgets-for-elementor' ),
					'underline' => esc_html__( 'Underline', 'jetwoo-widgets-for-elementor' ),
				),
				'default'   => 'none',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button']        => 'text-decoration: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['button'] . '>*' => 'text-decoration: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'button_border',
				'label'       => esc_html__( 'Border', 'jetwoo-widgets-for-elementor' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['button'],
				'separator'   => 'before'
			)
		);

		$this->add_responsive_control(
			'button_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'],
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			array(
				'label' => esc_html__( 'Hover', 'jetwoo-widgets-for-elementor' ),
			)
		);

		$this->add_control(
			'button_hover_bg',
			array(
				'label'       => _x( 'Background Type', 'Background Control', 'jetwoo-widgets-for-elementor' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => array(
					'color'    => array(
						'title' => _x( 'Classic', 'Background Control', 'jetwoo-widgets-for-elementor' ),
						'icon'  => 'eicon-paint-brush',
					),
					'gradient' => array(
						'title' => _x( 'Gradient', 'Background Control', 'jetwoo-widgets-for-elementor' ),
						'icon'  => 'eicon-barcode',
					),
				),
				'default'     => 'color',
				'label_block' => false,
				'render_type' => 'ui',
			)
		);

		$this->add_control(
			'button_hover_bg_color',
			array(
				'label'     => _x( 'Color', 'Background Control', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'global' => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'title'     => _x( 'Background Color', 'Background Control', 'jetwoo-widgets-for-elementor' ),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_hover_bg_color_stop',
			array(
				'label'       => _x( 'Location', 'Background Control', 'jetwoo-widgets-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( '%' ),
				'default'     => array(
					'unit' => '%',
					'size' => 0,
				),
				'render_type' => 'ui',
				'condition'   => array(
					'button_hover_bg' => array( 'gradient' ),
				),
				'of_type'     => 'gradient',
			)
		);

		$this->add_control(
			'button_hover_bg_color_b',
			array(
				'label'       => _x( 'Second Color', 'Background Control', 'jetwoo-widgets-for-elementor' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#f2295b',
				'render_type' => 'ui',
				'condition'   => array(
					'button_hover_bg' => array( 'gradient' ),
				),
				'of_type'     => 'gradient',
			)
		);

		$this->add_control(
			'button_hover_bg_color_b_stop',
			array(
				'label'       => _x( 'Location', 'Background Control', 'jetwoo-widgets-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( '%' ),
				'default'     => array(
					'unit' => '%',
					'size' => 100,
				),
				'render_type' => 'ui',
				'condition'   => array(
					'button_hover_bg' => array( 'gradient' ),
				),
				'of_type'     => 'gradient',
			)
		);

		$this->add_control(
			'button_hover_bg_gradient_type',
			array(
				'label'       => _x( 'Type', 'Background Control', 'jetwoo-widgets-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'linear' => _x( 'Linear', 'Background Control', 'jetwoo-widgets-for-elementor' ),
					'radial' => _x( 'Radial', 'Background Control', 'jetwoo-widgets-for-elementor' ),
				),
				'default'     => 'linear',
				'render_type' => 'ui',
				'condition'   => array(
					'button_hover_bg' => array( 'gradient' ),
				),
				'of_type'     => 'gradient',
			)
		);

		$this->add_control(
			'button_hover_bg_gradient_angle',
			array(
				'label'      => _x( 'Angle', 'Background Control', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'deg' ),
				'default'    => array(
					'unit' => 'deg',
					'size' => 180,
				),
				'range'      => array(
					'deg' => array(
						'step' => 10,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{button_hover_bg_color.VALUE}} {{button_hover_bg_color_stop.SIZE}}{{button_hover_bg_color_stop.UNIT}}, {{button_hover_bg_color_b.VALUE}} {{button_hover_bg_color_b_stop.SIZE}}{{button_hover_bg_color_b_stop.UNIT}})',
				),
				'condition'  => array(
					'button_hover_bg'               => array( 'gradient' ),
					'button_hover_bg_gradient_type' => 'linear',
				),
				'of_type'    => 'gradient',
			)
		);

		$this->add_control(
			'button_hover_bg_gradient_position',
			array(
				'label'     => _x( 'Position', 'Background Control', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'center center' => _x( 'Center Center', 'Background Control', 'jetwoo-widgets-for-elementor' ),
					'center left'   => _x( 'Center Left', 'Background Control', 'jetwoo-widgets-for-elementor' ),
					'center right'  => _x( 'Center Right', 'Background Control', 'jetwoo-widgets-for-elementor' ),
					'top center'    => _x( 'Top Center', 'Background Control', 'jetwoo-widgets-for-elementor' ),
					'top left'      => _x( 'Top Left', 'Background Control', 'jetwoo-widgets-for-elementor' ),
					'top right'     => _x( 'Top Right', 'Background Control', 'jetwoo-widgets-for-elementor' ),
					'bottom center' => _x( 'Bottom Center', 'Background Control', 'jetwoo-widgets-for-elementor' ),
					'bottom left'   => _x( 'Bottom Left', 'Background Control', 'jetwoo-widgets-for-elementor' ),
					'bottom right'  => _x( 'Bottom Right', 'Background Control', 'jetwoo-widgets-for-elementor' ),
				),
				'default'   => 'center center',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{button_hover_bg_color.VALUE}} {{button_hover_bg_color_stop.SIZE}}{{button_hover_bg_color_stop.UNIT}}, {{button_hover_bg_color_b.VALUE}} {{button_hover_bg_color_b_stop.SIZE}}{{button_hover_bg_color_b_stop.UNIT}})',
				),
				'condition' => array(
					'button_hover_bg'               => array( 'gradient' ),
					'button_hover_bg_gradient_type' => 'radial',
				),
				'of_type'   => 'gradient',
			)
		);

		$this->add_control(
			'button_hover_color',
			array(
				'label'     => esc_html__( 'Text Color', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'button_hover_text_decor',
			array(
				'label'     => esc_html__( 'Text Decoration', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'none'      => esc_html__( 'None', 'jetwoo-widgets-for-elementor' ),
					'underline' => esc_html__( 'Underline', 'jetwoo-widgets-for-elementor' ),
				),
				'default'   => 'none',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover'     => 'text-decoration: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover > *' => 'text-decoration: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'button_hover_border',
				'label'       => esc_html__( 'Border', 'jetwoo-widgets-for-elementor' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['button'] . ':hover',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'button_hover_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'] . ':hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'button_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'jetwoo-widgets-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'jetwoo-widgets-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'jetwoo-widgets-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'classes'   => 'elementor-control-align',
				'selectors' => array(
					'{{WRAPPER}} ' . ' .jet-woo-product-button' => 'text-align: {{VALUE}};',
				),
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'button_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_margin',
			array(
				'label'      => esc_html__( 'Margin', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button-wrap'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_order',
			array(
				'type'      => Controls_Manager::NUMBER,
				'label'     => esc_html__( 'Order', 'jetwoo-widgets-for-elementor' ),
				'default'   => 1,
				'min'       => 1,
				'max'       => 10,
				'step'      => 1,
				'selectors' => array(
					'{{WRAPPER}} ' . ' .jet-woo-product-button' => 'order: {{VALUE}}',
				),
				'condition' => array(
					'presets' => array( 'preset-1' )
				)
			)
		);

	}

	protected function controls_section_excerpt( $css_scheme ) {

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'excerpt_typography',
				'global' => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector' => '{{WRAPPER}} ' . $css_scheme['excerpt'],
			)
		);

		$this->add_control(
			'excerpt_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['excerpt'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'excerpt_color',
			array(
				'label'     => esc_html__( 'Color', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['excerpt'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'excerpt_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'jetwoo-widgets-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'jetwoo-widgets-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'jetwoo-widgets-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'classes'   => 'elementor-control-align',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['excerpt'] => 'text-align: {{VALUE}};',
				),
				'separator' => 'before'
			)
		);

		$this->add_responsive_control(
			'excerpt_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['excerpt'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'excerpt_margin',
			array(
				'label'      => esc_html__( 'Margin', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['excerpt'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'excerpt_order',
			array(
				'type'      => Controls_Manager::NUMBER,
				'label'     => esc_html__( 'Order', 'jetwoo-widgets-for-elementor' ),
				'default'   => 1,
				'min'       => 1,
				'max'       => 10,
				'step'      => 1,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['excerpt'] => 'order: {{VALUE}}',
				),
				'condition' => array(
					'presets' => array( 'preset-1' )
				)
			)
		);

	}

	protected function controls_section_title( $css_scheme ) {

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'global' => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector' => '{{WRAPPER}} ' . $css_scheme['title'],
			)
		);

		$this->add_control(
			'title_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['title-wrap'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_title_color' );

		$this->start_controls_tab(
			'tab_title_color_normal',
			array(
				'label' => esc_html__( 'Normal', 'jetwoo-widgets-for-elementor' ),
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Color', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global' => array(
					'default' => Global_Colors::COLOR_SECONDARY,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['title'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_title_color_hover',
			array(
				'label' => esc_html__( 'Hover', 'jetwoo-widgets-for-elementor' ),
			)
		);

		$this->add_control(
			'title_color_hover',
			array(
				'label'     => esc_html__( 'Color', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global' => array(
					'default' => Global_Colors::COLOR_SECONDARY,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['title'] . ':hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'title_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'jetwoo-widgets-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'jetwoo-widgets-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'jetwoo-widgets-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'classes'   => 'elementor-control-align',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['title-wrap'] => 'text-align: {{VALUE}};',
				),
				'separator' => 'before'
			)
		);

		$this->add_responsive_control(
			'title_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['title-wrap'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'title_margin',
			array(
				'label'      => esc_html__( 'Margin', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['title-wrap'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'title_order',
			array(
				'type'      => Controls_Manager::NUMBER,
				'label'     => esc_html__( 'Order', 'jetwoo-widgets-for-elementor' ),
				'default'   => 1,
				'min'       => 1,
				'max'       => 10,
				'step'      => 1,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['title-wrap'] => 'order: {{VALUE}}',
				),
				'condition' => array(
					'presets' => array( 'preset-1' )
				)
			)
		);

	}

	protected function controls_section_thumbnail( $css_scheme ) {

		$this->add_control(
			'thumb_background',
			array(
				'label'     => esc_html__( 'Background Color', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['thumb'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'thumb_border',
				'label'       => esc_html__( 'Border', 'jetwoo-widgets-for-elementor' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['thumb'],
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'thumb_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['thumb'],
			)
		);

		$this->add_responsive_control(
			'thumb_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['thumb'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'thumb_margin',
			array(
				'label'      => esc_html__( 'Margin', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['thumb'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before'
			)
		);

		$this->add_responsive_control(
			'thumb_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['thumb'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'thumb_order',
			array(
				'type'      => Controls_Manager::NUMBER,
				'label'     => esc_html__( 'Order', 'jetwoo-widgets-for-elementor' ),
				'default'   => 1,
				'min'       => 1,
				'max'       => 10,
				'step'      => 1,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['thumb'] => 'order: {{VALUE}}',
				),
				'condition' => array(
					'presets' => array( 'preset-1' )
				)
			)
		);

	}

	protected function controls_section_rating( $css_scheme ) {

		$this->start_controls_tabs( 'tabs_rating_styles' );

		$this->start_controls_tab(
			'tab_rating_all',
			array(
				'label' => esc_html__( 'All', 'jetwoo-widgets-for-elementor' ),
			)
		);

		$this->add_control(
			'rating_color_all',
			array(
				'label'     => esc_html__( 'Color', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['rating'] . ' .product-rating__stars'        => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['rating'] . ' .product-rating__stars:before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_rating_rated',
			array(
				'label' => esc_html__( 'Rated', 'jetwoo-widgets-for-elementor' ),
			)
		);

		$this->add_control(
			'rating_color_rated',
			array(
				'label'     => esc_html__( 'Color', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['rating'] . ' .product-rating__stars > span:before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'rating_font_size',
			array(
				'label'      => esc_html__( 'Font Size (px)', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 60,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 16,
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['rating'] . ' .product-rating__stars' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'rating_margin',
			array(
				'label'      => esc_html__( 'Margin', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['rating'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before'
			)
		);

		$this->add_responsive_control(
			'rating_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'jetwoo-widgets-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'jetwoo-widgets-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'jetwoo-widgets-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'classes'   => 'elementor-control-align',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['rating'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'rating_order',
			array(
				'type'      => Controls_Manager::NUMBER,
				'label'     => esc_html__( 'Order', 'jetwoo-widgets-for-elementor' ),
				'default'   => 1,
				'min'       => 1,
				'max'       => 10,
				'step'      => 1,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['rating'] => 'order: {{VALUE}}',
				),
				'condition' => array(
					'presets' => array( 'preset-1' )
				)
			)
		);

	}

	protected function controls_section_carousel_arrows() {

		$this->start_controls_tabs( 'tabs_arrows_style' );

		$this->start_controls_tab(
			'tab_prev',
			array(
				'label' => esc_html__( 'Normal', 'jetwoo-widgets-for-elementor' ),
			)
		);

		$this->add_group_control(
			\Jet_Woo_Widgets_Group_Control_Box_Style::get_type(),
			array(
				'name'           => 'arrows_style',
				'selector'       => '{{WRAPPER}} .jet-woo-products .jet-arrow',
				'fields_options' => array(
					'color' => array(
						'global' => array(
							'default' => Global_Colors::COLOR_PRIMARY,
						),
					),
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_next_hover',
			array(
				'label' => esc_html__( 'Hover', 'jetwoo-widgets-for-elementor' ),
			)
		);

		$this->add_group_control(
			\Jet_Woo_Widgets_Group_Control_Box_Style::get_type(),
			array(
				'name'           => 'arrows_hover_style',
				'selector'       => '{{WRAPPER}} .jet-woo-products .jet-arrow:hover',
				'fields_options' => array(
					'color' => array(
						'global' => array(
							'default' => Global_Colors::COLOR_PRIMARY,
						),
					),
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'prev_arrow_position',
			array(
				'label'     => esc_html__( 'Prev Arrow Position', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'prev_vert_position',
			array(
				'label'   => esc_html__( 'Vertical Postition by', 'jetwoo-widgets-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'top',
				'options' => array(
					'top'    => esc_html__( 'Top', 'jetwoo-widgets-for-elementor' ),
					'bottom' => esc_html__( 'Bottom', 'jetwoo-widgets-for-elementor' ),
				),
			)
		);

		$this->add_responsive_control(
			'prev_top_position',
			array(
				'label'      => esc_html__( 'Top Indent', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => - 400,
						'max' => 400,
					),
					'%'  => array(
						'min' => - 100,
						'max' => 100,
					),
					'em' => array(
						'min' => - 50,
						'max' => 50,
					),
				),
				'condition'  => array(
					'prev_vert_position' => 'top',
				),
				'selectors'  => array(
					'{{WRAPPER}} .jet-woo-products .jet-arrow.prev-arrow' => 'top: {{SIZE}}{{UNIT}}; bottom: auto;',
				),
			)
		);

		$this->add_responsive_control(
			'prev_bottom_position',
			array(
				'label'      => esc_html__( 'Bottom Indent', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => - 400,
						'max' => 400,
					),
					'%'  => array(
						'min' => - 100,
						'max' => 100,
					),
					'em' => array(
						'min' => - 50,
						'max' => 50,
					),
				),
				'condition'  => array(
					'prev_vert_position' => 'bottom',
				),
				'selectors'  => array(
					'{{WRAPPER}} .jet-woo-products .jet-arrow.prev-arrow' => 'bottom: {{SIZE}}{{UNIT}}; top: auto;',
				),
			)
		);

		$this->add_control(
			'prev_hor_position',
			array(
				'label'   => esc_html__( 'Horizontal Position by', 'jetwoo-widgets-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => array(
					'left'  => esc_html__( 'Left', 'jetwoo-widgets-for-elementor' ),
					'right' => esc_html__( 'Right', 'jetwoo-widgets-for-elementor' ),
				),
			)
		);

		$this->add_responsive_control(
			'prev_left_position',
			array(
				'label'      => esc_html__( 'Left Indent', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => - 400,
						'max' => 400,
					),
					'%'  => array(
						'min' => - 100,
						'max' => 100,
					),
					'em' => array(
						'min' => - 50,
						'max' => 50,
					),
				),
				'condition'  => array(
					'prev_hor_position' => 'left',
				),
				'selectors'  => array(
					'{{WRAPPER}} .jet-woo-products .jet-arrow.prev-arrow' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
				),
			)
		);

		$this->add_responsive_control(
			'prev_right_position',
			array(
				'label'      => esc_html__( 'Right Indent', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => - 400,
						'max' => 400,
					),
					'%'  => array(
						'min' => - 100,
						'max' => 100,
					),
					'em' => array(
						'min' => - 50,
						'max' => 50,
					),
				),
				'condition'  => array(
					'prev_hor_position' => 'right',
				),
				'selectors'  => array(
					'{{WRAPPER}} .jet-woo-products .jet-arrow.prev-arrow' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
				),
			)
		);

		$this->add_control(
			'next_arrow_position',
			array(
				'label'     => esc_html__( 'Next Arrow Position', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'next_vert_position',
			array(
				'label'   => esc_html__( 'Vertical Position by', 'jetwoo-widgets-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'top',
				'options' => array(
					'top'    => esc_html__( 'Top', 'jetwoo-widgets-for-elementor' ),
					'bottom' => esc_html__( 'Bottom', 'jetwoo-widgets-for-elementor' ),
				),
			)
		);

		$this->add_responsive_control(
			'next_top_position',
			array(
				'label'      => esc_html__( 'Top Indent', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => - 400,
						'max' => 400,
					),
					'%'  => array(
						'min' => - 100,
						'max' => 100,
					),
					'em' => array(
						'min' => - 50,
						'max' => 50,
					),
				),
				'condition'  => array(
					'next_vert_position' => 'top',
				),
				'selectors'  => array(
					'{{WRAPPER}} .jet-woo-products .jet-arrow.next-arrow' => 'top: {{SIZE}}{{UNIT}}; bottom: auto;',
				),
			)
		);

		$this->add_responsive_control(
			'next_bottom_position',
			array(
				'label'      => esc_html__( 'Bottom Indent', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => - 400,
						'max' => 400,
					),
					'%'  => array(
						'min' => - 100,
						'max' => 100,
					),
					'em' => array(
						'min' => - 50,
						'max' => 50,
					),
				),
				'condition'  => array(
					'next_vert_position' => 'bottom',
				),
				'selectors'  => array(
					'{{WRAPPER}} .jet-woo-products .jet-arrow.next-arrow' => 'bottom: {{SIZE}}{{UNIT}}; top: auto;',
				),
			)
		);

		$this->add_control(
			'next_hor_position',
			array(
				'label'   => esc_html__( 'Horizontal Postition by', 'jetwoo-widgets-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => array(
					'left'  => esc_html__( 'Left', 'jetwoo-widgets-for-elementor' ),
					'right' => esc_html__( 'Right', 'jetwoo-widgets-for-elementor' ),
				),
			)
		);

		$this->add_responsive_control(
			'next_left_position',
			array(
				'label'      => esc_html__( 'Left Indent', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => - 400,
						'max' => 400,
					),
					'%'  => array(
						'min' => - 100,
						'max' => 100,
					),
					'em' => array(
						'min' => - 50,
						'max' => 50,
					),
				),
				'condition'  => array(
					'next_hor_position' => 'left',
				),
				'selectors'  => array(
					'{{WRAPPER}} .jet-woo-products .jet-arrow.next-arrow' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
				),
			)
		);

		$this->add_responsive_control(
			'next_right_position',
			array(
				'label'      => esc_html__( 'Right Indent', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => - 400,
						'max' => 400,
					),
					'%'  => array(
						'min' => - 100,
						'max' => 100,
					),
					'em' => array(
						'min' => - 50,
						'max' => 50,
					),
				),
				'condition'  => array(
					'next_hor_position' => 'right',
				),
				'selectors'  => array(
					'{{WRAPPER}} .jet-woo-products .jet-arrow.next-arrow' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
				),
			)
		);

	}

	protected function controls_section_carousel_dots() {

		$this->start_controls_tabs( 'tabs_dots_style' );

		$this->start_controls_tab(
			'tab_dots_normal',
			array(
				'label' => esc_html__( 'Normal', 'jetwoo-widgets-for-elementor' ),
			)
		);

		$this->add_group_control(
			\Jet_Woo_Widgets_Group_Control_Box_Style::get_type(),
			array(
				'name'           => 'dots_style',
				'selector'       => '{{WRAPPER}} .jet-woo-carousel .jet-slick-dots li',
				'fields_options' => array(
					'color' => array(
						'global' => array(
							'default' => Global_Colors::COLOR_TEXT,
						),
					),
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dots_hover',
			array(
				'label' => esc_html__( 'Hover', 'jetwoo-widgets-for-elementor' ),
			)
		);

		$this->add_group_control(
			\Jet_Woo_Widgets_Group_Control_Box_Style::get_type(),
			array(
				'name'           => 'dots_style_hover',
				'selector'       => '{{WRAPPER}} .jet-woo-carousel .jet-slick-dots li:hover',
				'fields_options' => array(
					'color' => array(
						'global' => array(
							'default' => Global_Colors::COLOR_PRIMARY,
						),
					),
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dots_active',
			array(
				'label' => esc_html__( 'Active', 'jetwoo-widgets-for-elementor' ),
			)
		);

		$this->add_group_control(
			\Jet_Woo_Widgets_Group_Control_Box_Style::get_type(),
			array(
				'name'           => 'dots_style_active',
				'selector'       => '{{WRAPPER}} .jet-woo-carousel .jet-slick-dots li.slick-active',
				'fields_options' => array(
					'color' => array(
						'global' => array(
							'default' => Global_Colors::COLOR_ACCENT,
						),
					),
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'dots_gap',
			array(
				'label'     => esc_html__( 'Gap', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 5,
					'unit' => 'px',
				),
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .jet-woo-carousel .jet-slick-dots li' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
				),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'dots_margin',
			array(
				'label'      => esc_html__( 'Dots Box Margin', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .jet-woo-carousel .jet-slick-dots' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'dots_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
				'options'   => array(
					'flex-start' => array(
						'title' => esc_html__( 'Left', 'jetwoo-widgets-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'     => array(
						'title' => esc_html__( 'Center', 'jetwoo-widgets-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'flex-end'   => array(
						'title' => esc_html__( 'Right', 'jetwoo-widgets-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'classes'   => 'elementor-control-align',
				'selectors' => array(
					'{{WRAPPER}} .jet-woo-carousel .jet-slick-dots' => 'justify-content: {{VALUE}};',
				),
			)
		);

	}

	protected function _content_template() {
	}

}
