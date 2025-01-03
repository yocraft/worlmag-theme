<?php
/**
 * Class to include Footer General customize options.
 *
 * Class ColorMag_Customize_Footer_General_Options
 *
 * @package    ThemeGrill
 * @subpackage ColorMag
 * @since      ColorMag 3.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class to include Footer General customize options.
 *
 * Class ColorMag_Customize_Footer_General_Options
 */
class ColorMag_Customize_Footer_General_Options extends ColorMag_Customize_Base_Option {

	/**
	 * Include customize options.
	 *
	 * @param array                 $options      Customize options provided via the theme.
	 * @param \WP_Customize_Manager $wp_customize Theme Customizer object.
	 *
	 * @return mixed|void Customizer options for registering panels, sections as well as controls.
	 */
	public function register_options( $options, $wp_customize ) {

		$configs = array(

			array(
				'name'     => 'colormag_footer_column_heading',
				'type'     => 'control',
				'control'  => 'colormag-title',
				'label'    => esc_html__( 'Footer Column', 'colormag' ),
				'section'  => 'colormag_footer_column_section',
				'priority' => 10,
			),

			array(
				'name'     => 'colormag_footer_general_subtitle',
				'type'     => 'control',
				'control'  => 'colormag-subtitle',
				'label'    => esc_html__( 'General', 'colormag' ),
				'section'  => 'colormag_footer_column_section',
				'priority' => 20,
			),

			// Main total footer area display type option.
			array(
				'name'      => 'colormag_main_footer_layout',
				'default'   => 'layout-1',
				'type'      => 'control',
				'control'   => 'select',
				'label'     => esc_html__( 'Layout', 'colormag' ),
				'section'   => 'colormag_footer_column_section',
				'choices'   => array(
					'layout-1' => esc_html__( 'Layout 1', 'colormag' ),
					'layout-2' => esc_html__( 'Layout 2', 'colormag' ),
					'layout-3' => esc_html__( 'Layout 3', 'colormag' ),
				),
				'transport' => 'postMessage',
				'priority'  => 30,
			),

			array(
				'name'     => 'colormag_footer_style_divider',
				'type'     => 'control',
				'control'  => 'colormag-divider',
				'style'    => 'dashed',
				'section'  => 'colormag_footer_column_section',
				'priority' => 40,
			),

			array(
				'name'     => 'colormag_footer_style_subtitle',
				'type'     => 'control',
				'control'  => 'colormag-subtitle',
				'label'    => esc_html__( 'Style', 'colormag' ),
				'section'  => 'colormag_footer_column_section',
				'priority' => 50,
			),

			array(
				'name'     => 'colormag_footer_background_group',
				'label'    => esc_html__( 'Background', 'colormag' ),
				'default'  => '',
				'type'     => 'control',
				'control'  => 'colormag-group',
				'section'  => 'colormag_footer_column_section',
				'priority' => 60,
			),

			// Footer background option.
			array(
				'name'     => 'colormag_footer_background',
				'default'  => array(
					'background-color'      => '',
					'background-image'      => '',
					'background-position'   => 'center center',
					'background-size'       => 'auto',
					'background-attachment' => 'scroll',
					'background-repeat'     => 'repeat',
				),
				'type'     => 'sub-control',
				'control'  => 'colormag-background',
				'parent'   => 'colormag_footer_background_group',
				'section'  => 'colormag_footer_column_section',
				'priority' => 70,
			),

			array(
				'name'     => 'colormag_upper_footer_heading',
				'type'     => 'control',
				'control'  => 'colormag-title',
				'label'    => esc_html__( 'Upper Footer', 'colormag' ),
				'section'  => 'colormag_footer_column_section',
				'priority' => 80,
			),

			array(
				'name'     => 'colormag_upper_footer_background_group',
				'label'    => esc_html__( 'Background', 'colormag' ),
				'default'  => '',
				'type'     => 'control',
				'control'  => 'colormag-group',
				'section'  => 'colormag_footer_column_section',
				'priority' => 90,
			),

			// Footer background option.
			array(
				'name'     => 'colormag_upper_footer_background',
				'default'  => array(
					'background-color'      => '',
					'background-image'      => '',
					'background-position'   => 'center center',
					'background-size'       => 'auto',
					'background-attachment' => 'scroll',
					'background-repeat'     => 'repeat',
				),
				'type'     => 'sub-control',
				'control'  => 'colormag-background',
				'parent'   => 'colormag_upper_footer_background_group',
				'section'  => 'colormag_footer_column_section',
				'priority' => 100,
			),

			// Upper Footer color option.
			array(
				'name'     => 'colormag_upper_footer_color_group',
				'default'  => '#ffffff',
				'type'     => 'control',
				'control'  => 'colormag-group',
				'label'    => esc_html__( 'Color', 'colormag' ),
				'section'  => 'colormag_footer_column_section',
				'priority' => 110,
			),

			array(
				'name'     => 'colormag_upper_footer_color',
				'label'    => esc_html__( 'Color', 'colormag' ),
				'default'  => '#ffffff',
				'type'     => 'sub-control',
				'control'  => 'colormag-color',
				'parent'   => 'colormag_upper_footer_color_group',
				'section'  => 'colormag_footer_column_section',
				'priority' => 120,
			),

			array(
				'name'     => 'colormag_widget_title_title',
				'type'     => 'control',
				'control'  => 'colormag-title',
				'label'    => esc_html__( 'Widget Title', 'colormag' ),
				'section'  => 'colormag_footer_column_section',
				'priority' => 130,
			),

			array(
				'name'     => 'colormag_footer_widget_title_color_group',
				'default'  => '#ffffff',
				'type'     => 'control',
				'control'  => 'colormag-group',
				'label'    => esc_html__( 'Color', 'colormag' ),
				'section'  => 'colormag_footer_column_section',
				'priority' => 150,
			),

			array(
				'name'     => 'colormag_footer_widget_title_color',
				'label'    => esc_html__( 'Widget title color.', 'colormag' ),
				'default'  => '#ffffff',
				'type'     => 'sub-control',
				'control'  => 'colormag-color',
				'parent'   => 'colormag_footer_widget_title_color_group',
				'section'  => 'colormag_footer_column_section',
				'priority' => 160,
			),

			array(
				'name'     => 'colormag_footer_widget_title_typography_group',
				'label'    => esc_html__( 'Typography', 'colormag' ),
				'default'  => '',
				'type'     => 'control',
				'control'  => 'colormag-group',
				'section'  => 'colormag_footer_column_section',
				'priority' => 170,
			),

			// Widget title typography option.
			array(
				'name'      => 'colormag_footer_widget_title_typography',
				'default'   => array(
					'font-size' => array(
						'desktop' => array(
							'size' => '18',
							'unit' => 'px',
						),
						'tablet'  => array(
							'size' => '',
							'unit' => '',
						),
						'mobile'  => array(
							'size' => '',
							'unit' => '',
						),
					),
				),
				'type'      => 'sub-control',
				'control'   => 'colormag-typography',
				'parent'    => 'colormag_footer_widget_title_typography_group',
				'section'   => 'colormag_footer_column_section',
				'transport' => 'postMessage',
				'priority'  => 180,
			),

			array(
				'name'     => 'colormag_widget_content_title',
				'type'     => 'control',
				'control'  => 'colormag-title',
				'label'    => esc_html__( 'Widget Content', 'colormag' ),
				'section'  => 'colormag_footer_column_section',
				'priority' => 190,
			),

			array(
				'name'     => 'colormag_footer_widget_content_color_group',
				'default'  => '#ffffff',
				'type'     => 'control',
				'control'  => 'colormag-group',
				'label'    => esc_html__( 'Color', 'colormag' ),
				'section'  => 'colormag_footer_column_section',
				'priority' => 200,
			),

			array(
				'name'     => 'colormag_footer_widget_content_color',
				'default'  => '#ffffff',
				'type'     => 'sub-control',
				'control'  => 'colormag-color',
				'parent'   => 'colormag_footer_widget_content_color_group',
				'section'  => 'colormag_footer_column_section',
				'priority' => 210,
			),

			// Widget content typography group.
			array(
				'name'     => 'colormag_footer_widget_content_typography_group',
				'label'    => esc_html__( 'Typography', 'colormag' ),
				'default'  => '',
				'type'     => 'control',
				'control'  => 'colormag-group',
				'section'  => 'colormag_footer_column_section',
				'priority' => 220,
			),

			// Widget content typography option.
			array(
				'name'      => 'colormag_footer_widget_content_typography',
				'default'   => array(
					'font-size' => array(
						'desktop' => array(
							'size' => '14',
							'unit' => 'px',
						),
						'tablet'  => array(
							'size' => '',
							'unit' => '',
						),
						'mobile'  => array(
							'size' => '',
							'unit' => '',
						),
					),
				),
				'type'      => 'sub-control',
				'control'   => 'colormag-typography',
				'parent'    => 'colormag_footer_widget_content_typography_group',
				'section'   => 'colormag_footer_column_section',
				'transport' => 'postMessage',
				'priority'  => 230,
			),

			array(
				'name'     => 'colormag_widget_link_title',
				'type'     => 'control',
				'control'  => 'colormag-title',
				'label'    => esc_html__( 'Widget Link', 'colormag' ),
				'section'  => 'colormag_footer_column_section',
				'priority' => 240,
			),

			// Widget content typography group.
			array(
				'name'     => 'colormag_footer_widget_link_color_group',
				'label'    => esc_html__( 'Color', 'colormag' ),
				'default'  => '',
				'type'     => 'control',
				'control'  => 'colormag-group',
				'section'  => 'colormag_footer_column_section',
				'priority' => 250,
			),

			// Widget content link text color option.
			array(
				'name'     => 'colormag_footer_widget_content_link_text_color',
				'default'  => '#ffffff',
				'type'     => 'sub-control',
				'control'  => 'colormag-color',
				'parent'   => 'colormag_footer_widget_link_color_group',
				'tab'      => esc_html__( 'Normal', 'colormag' ),
				'section'  => 'colormag_footer_column_section',
				'priority' => 260,
			),

			// Widget content link text hover color option.
			array(
				'name'     => 'colormag_footer_widget_content_link_text_hover_color',
				'default'  => '#207daf',
				'type'     => 'sub-control',
				'control'  => 'colormag-color',
				'parent'   => 'colormag_footer_widget_link_color_group',
				'tab'      => esc_html__( 'Hover', 'colormag' ),
				'section'  => 'colormag_footer_column_section',
				'priority' => 270,
			),
		);

		$options = array_merge( $options, $configs );

		return $options;
	}
}

return new ColorMag_Customize_Footer_General_Options();
