<?php
/**
 * Class to include Widget General customize options.
 *
 * Class ColorMag_Customize_Widget_Options
 *
 * @package    ThemeGrill
 * @subpackage ColorMag
 * @since      ColorMag 3.1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class to include Widget General customize options.
 *
 * Class ColorMag_Customize_Widget_Options
 */
class ColorMag_Customize_Widget_Options extends ColorMag_Customize_Base_Option {

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
				'name'     => 'colormag_widget_heading',
				'type'     => 'control',
				'control'  => 'colormag-title',
				'label'    => esc_html__( 'Widget Title', 'colormag' ),
				'section'  => 'colormag_widget_section',
				'priority' => 5,
			),

			array(
				'name'     => 'colormag_widget_markup',
				'default'  => 'h3',
				'type'     => 'control',
				'control'  => 'select',
				'label'    => esc_html__( 'Markup', 'colormag' ),
				'section'  => 'colormag_widget_section',
				'priority' => 10,
				'choices'  => array(
					'h2' => esc_html__( 'Heading 2', 'colormag' ),
					'h3' => esc_html__( 'Heading 3', 'colormag' ),
				),
			),

			/**
			 * Widget Typography.
			 */
			array(
				'name'     => 'colormag_content_widget_title_typography_group',
				'label'    => esc_html__( 'Typography', 'colormag' ),
				'default'  => '',
				'type'     => 'control',
				'control'  => 'colormag-group',
				'section'  => 'colormag_widget_section',
				'priority' => 10,
			),

			array(
				'name'      => 'colormag_content_widget_title_typography',
				'default'   => array(
					'font-family'    => 'default',
					'font-weight'    => 'regular',
					'subsets'        => array( 'latin' ),
					'font-size'      => array(
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
					'line-height'    => array(
						'desktop' => array(
							'size' => '1.2',
							'unit' => '-',
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
					'font-style'     => 'normal',
					'text-transform' => 'none',
				),
				'type'      => 'sub-control',
				'control'   => 'colormag-typography',
				'parent'    => 'colormag_content_widget_title_typography_group',
				'section'   => 'colormag_widget_section',
				'transport' => 'postMessage',
				'priority'  => 10,
			),
		);

		$options = array_merge( $options, $configs );

		return $options;
	}
}

return new ColorMag_Customize_Widget_Options();
