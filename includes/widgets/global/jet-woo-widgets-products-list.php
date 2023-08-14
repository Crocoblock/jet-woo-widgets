<?php
/**
 * Class: Jet_Woo_Widgets_Products_List
 * Name: Products List
 * Slug: jet-woo-products-list
 */

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Jet_Woo_Widgets_Products_List extends Jet_Woo_Widgets_Base {

	public function get_name() {
		return 'jet-woo-widgets-products-list';
	}

	public function get_title() {
		return esc_html__( 'Woo Products List', 'jetwoo-widgets-for-elementor' );
	}

	public function get_icon() {
		return 'jetwoowidgets-icon-91';
	}

	public function get_categories() {
		return array( 'jetwoo-widgets-for-elementor' );
	}

	public function __shortcode() {
		return jet_woo_widgets_shortocdes()->get_shortcode( $this->get_name() );
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
			'jet-woo-widgets/jet-woo-products-list/css-scheme',
			array(
				'wrap'        => '.jet-woo-products-list',
				'item'        => '.jet-woo-products-list .jet-woo-products-list__item',
				'inner-box'   => '.jet-woo-products-list .jet-woo-products-list__inner-box',
				'thumb'       => '.jet-woo-products-list .jet-woo-products-list__item-img',
				'content'     => '.jet-woo-products-list .jet-woo-products-list__item-content',
				'cats'        => '.jet-woo-products-list .jet-woo-product-categories a',
				'cats-wrap'   => '.jet-woo-products-list .jet-woo-product-categories',
				'title'       => '.jet-woo-products-list .jet-woo-product-title a',
				'title-wrap'  => '.jet-woo-products-list .jet-woo-product-title',
				'price'       => '.jet-woo-products-list .jet-woo-product-price',
				'rating'      => '.jet-woo-products-list .jet-woo-product-rating',
				'currency'    => '.jet-woo-products-list .jet-woo-product-price .woocommerce-Price-currencySymbol',
				'button-wrap' => '.jet-woo-products-list .jet-woo-product-button',
				'button'      => '.jet-woo-products-list .jet-woo-product-button .button',
				'view_cart'   => '.jet-woo-products-list .jet-woo-product-button .added_to_cart',
			)
		);

		$this->start_controls_section(
			'section_item_style',
			array(
				'label'      => esc_html__( 'Product Item', 'jetwoo-widgets-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->controls_section_item( $css_scheme );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_thumb_style',
			array(
				'label'      => esc_html__( 'Product Thumbnail', 'jetwoo-widgets-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->controls_section_thumb( $css_scheme );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_style',
			array(
				'label'      => esc_html__( 'Content', 'jetwoo-widgets-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->controls_section_content( $css_scheme );

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
			'section_cats_style',
			array(
				'label'      => esc_html__( 'Categories', 'jetwoo-widgets-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->controls_section_cats( $css_scheme );

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
			'section_button_style',
			array(
				'label'      => esc_html__( 'Button', 'jetwoo-widgets-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->controls_section_button( $css_scheme );

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

		echo wp_kses_post( $shortcode_obj->do_shortcode( $attributes ) );

		$this->__close_wrap();
	}

	protected function controls_section_item( $css_scheme ) {

		$this->add_control(
			'item_content_vertical_alignment',
			array(
				'label'     => esc_html__( 'Vertical Alignment', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'center',
				'options'   => array(
					'flex-start' => esc_html__( 'Top', 'jetwoo-widgets-for-elementor' ),
					'center'     => esc_html__( 'Center', 'jetwoo-widgets-for-elementor' ),
					'flex-end'   => esc_html__( 'Bottom', 'jetwoo-widgets-for-elementor' ),
					'stretch'    => esc_html__( 'Stretch', 'jetwoo-widgets-for-elementor' ),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['inner-box'] => 'align-items: {{VALUE}};',
				),
				'condition' => array(
					'products_layout!' => array( 'top' )
				)
			)
		);

		$this->add_control(
			'item_content_horizontal_alignment',
			array(
				'label'     => esc_html__( 'Horizontal Alignment', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'center',
				'options'   => array(
					'flex-start' => esc_html__( 'Left', 'jetwoo-widgets-for-elementor' ),
					'center'     => esc_html__( 'Center', 'jetwoo-widgets-for-elementor' ),
					'flex-end'   => esc_html__( 'Right', 'jetwoo-widgets-for-elementor' ),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['inner-box'] => 'align-items: {{VALUE}};',
				),
				'condition' => array(
					'products_layout' => array( 'top' )
				)
			)
		);

		$this->add_responsive_control(
			'item_space_between',
			array(
				'label'      => esc_html__( 'Space Between Items', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 1000,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 20,
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ' + .jet-woo-products-list__item' => 'margin-top: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'item_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] => 'background-color: {{VALUE}}',
				),
				'separator' => 'before'
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'item_border',
				'label'       => esc_html__( 'Border', 'jetwoo-widgets-for-elementor' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['item'],
			)
		);

		$this->add_responsive_control(
			'item_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['item'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'inner_item_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['item'],
			)
		);

		$this->add_responsive_control(
			'item_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['item'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before'
			)
		);

	}

	protected function controls_section_thumb( $css_scheme ) {

		$this->add_responsive_control(
			'thumb_width',
			array(
				'label'      => esc_html__( 'Image Width', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min' => 40,
						'max' => 400,
					),
					'%'  => array(
						'min' => 0,
						'max' => 80,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 150,
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['thumb']   => 'max-width: {{SIZE}}{{UNIT}}; flex: 0 1 {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} ' . $css_scheme['content'] => 'width:100%; max-width: calc(100% - {{SIZE}}{{UNIT}});',
				),
				'condition'  => array(
					'products_layout!' => array( 'top' )
				)
			)
		);

		$this->add_responsive_control(
			'thumb_horizontal_width',
			array(
				'label'      => esc_html__( 'Image Width', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min' => 40,
						'max' => 1000,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 150,
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['thumb'] => 'max-width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'products_layout' => array( 'top' )
				)
			)
		);

		$this->add_control(
			'thumb_background',
			array(
				'label'     => esc_html__( 'Background Color', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['thumb'] => 'background-color: {{VALUE}}',
				),
				'separator' => 'before'
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
			'thumb_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['thumb'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before'
			)
		);

	}

	protected function controls_section_content( $css_scheme ) {

		$this->add_control(
			'content_background',
			array(
				'label'     => esc_html__( 'Background Color', 'jetwoo-widgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['content'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'content_border',
				'label'       => esc_html__( 'Border', 'jetwoo-widgets-for-elementor' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['content'],
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'content_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['content'],
			)
		);

		$this->add_responsive_control(
			'content_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['content'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'content_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jetwoo-widgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['content'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before'
			)
		);

		$this->add_responsive_control(
			'content_alignment',
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
					'{{WRAPPER}} ' . $css_scheme['content'] => 'align-items: {{VALUE}};',
				),
				'separator' => 'before',
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
			)
		);

	}

	protected function controls_section_cats( $css_scheme ) {

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'cats_typography',
				'global' => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
				'selector' => '{{WRAPPER}} ' . $css_scheme['cats'],
				'exclude' => array( 'text_decoration' ),
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
					'{{WRAPPER}} ' . $css_scheme['cats'] . ' a' => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['cats']        => 'color: {{VALUE}}',
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
					'{{WRAPPER}} ' . $css_scheme['cats'] . ':hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

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
			)
		);

	}

	protected function controls_section_button( $css_scheme ) {
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
					'{{WRAPPER}} ' . $css_scheme['button']         => 'text-decoration: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['button'] . '> *' => 'text-decoration: {{VALUE}}',
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
					'{{WRAPPER}} ' . $css_scheme['button'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} ' . $css_scheme['button-wrap'] => 'order: {{VALUE}}',
				),
			)
		);

	}

	protected function _content_template() {
	}
}
