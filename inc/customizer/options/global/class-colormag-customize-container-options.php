<?php
/**
 * Class to include Layout customize options.
 *
 * Class ColorMag_Customize_Layout_Options
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
 * Class to include Layout customize options.
 *
 * Class ColorMag_Customize_Layout_Options
 */
class ColorMag_Customize_Layout_Options extends ColorMag_Customize_Base_Option {

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

			// Site layout heading.
			array(
				'name'     => 'colormag_container_heading',
				'type'     => 'control',
				'control'  => 'colormag-title',
				'label'    => esc_html__( 'Container', 'colormag' ),
				'section'  => 'colormag_global_container_section',
				'priority' => 10,
			),

			// Site layout heading.
			array(
				'name'     => 'colormag_container_general_subtitle',
				'type'     => 'control',
				'control'  => 'colormag-subtitle',
				'label'    => esc_html__( 'General', 'colormag' ),
				'section'  => 'colormag_global_container_section',
				'priority' => 20,
			),

			// Site layout option.
			array(
				'name'      => 'colormag_container_layout',
				'default'   => 'wide',
				'type'      => 'control',
				'control'   => 'colormag-radio-image',
				'section'   => 'colormag_global_container_section',
				'choices'   => array(
					'wide'  => array(
						'label' => 'Wide',
						'url'   => COLORMAG_PARENT_URL . '/assets/img/container-layout/wide.svg',
					),
					'boxed' => array(
						'label' => 'Boxed',
						'url'   => COLORMAG_PARENT_URL . '/assets/img/container-layout/box.svg',
					),
				),
				'image_col' => 2,
				'priority'  => 30,
			),

			array(
				'name'        => 'colormag_container_width',
				'default'     => array(
					'size' => '1140',
					'unit' => 'px',
				),
				'suffix'      => array( 'px' ),
				'type'        => 'control',
				'control'     => 'colormag-slider',
				'label'       => esc_html__( 'Width', 'colormag' ),
				'section'     => 'colormag_global_container_section',
				'priority'    => 40,
				'transport'   => 'postMessage',
				'input_attrs' => array(
					'px' => array(
						'min'  => 768,
						'max'  => 1920,
						'step' => 1,
					),
				),
			),

			array(
				'name'     => 'colormag_container_inside_background_divider',
				'type'     => 'control',
				'control'  => 'colormag-divider',
				'style'    => 'dashed',
				'section'  => 'colormag_global_container_section',
				'priority' => 50,
			),

			// Site layout heading.
			array(
				'name'     => 'colormag_container_inside_subtitle',
				'type'     => 'control',
				'control'  => 'colormag-subtitle',
				'label'    => esc_html__( 'Inside', 'colormag' ),
				'section'  => 'colormag_global_container_section',
				'priority' => 60,
			),

			array(
				'name'      => 'colormag_inside_container_background',
				'default'   => array(
					'background-color'      => '#ffffff',
					'background-image'      => '',
					'background-position'   => 'center center',
					'background-size'       => 'auto',
					'background-attachment' => 'scroll',
					'background-repeat'     => 'repeat',
				),
				'type'      => 'control',
				'control'   => 'colormag-background',
				'section'   => 'colormag_global_container_section',
				'transport' => 'postMessage',
				'priority'  => 70,
			),

			array(
				'name'       => 'colormag_container_outside_background_divider',
				'type'       => 'control',
				'control'    => 'colormag-divider',
				'style'      => 'dashed',
				'section'    => 'colormag_global_container_section',
				'dependency' => array(
					'colormag_container_layout',
					'==',
					'boxed',
				),
				'priority'   => 80,
			),
		);

		$options = array_merge( $options, $configs );

		return $options;
	}

}

return new ColorMag_Customize_Layout_Options();
