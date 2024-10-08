<?php
/**
 * Adds classes to appropriate places.
 *
 * @package ColorMag
 *
 * @since   ColorMag 3.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'colormag_top_full_width_area_class' ) ) :

	/**
	 * Function to return the classname for top full width area class.
	 *
	 * @return string CSS classname.
	 */
	function colormag_top_full_width_area_class() {

		// Add the header area display type dynamic class.
		$colormag_top_full_width_area_class = get_theme_mod( 'colormag_top_full_width_container', 'boxed' );
		$class_name                         = '';

		if ( 'stretch' === $colormag_top_full_width_area_class ) {
			$class_name = 'tg-full-width';
		}

		return $class_name;
	}

endif;

if ( ! function_exists( 'colormag_top_bar_full_width_area_class' ) ) :

	/**
	 * Function to return the classname for top full width area class.
	 *
	 * @return string CSS classname.
	 */
	function colormag_top_bar_full_width_area_class() {

		// Add the header area display type dynamic class.
		$colormag_top_bar_full_width_area_class = get_theme_mod( 'colormag_top_bar_full_width', 0 );
		$class_name                             = '';

		if ( 1 === $colormag_top_bar_full_width_area_class ) {
			$class_name = 'tg-full-width';
		}

		return $class_name;
	}

endif;


if ( ! function_exists( 'colormag_footer_layout_class' ) ) :

	/**
	 * Function to return the classname for footer option layout class.
	 *
	 * @return string CSS classname.
	 */
	function colormag_footer_layout_class() {

		$colormag_footer_layout_class = get_theme_mod( 'colormag_main_footer_layout', 'layout-1' );
		$class_name                   = '';

		if ( 'layout-2' === $colormag_footer_layout_class ) {
			$class_name = 'colormag-footer--classic';
		} elseif ( 'layout-3' === $colormag_footer_layout_class ) {
			$class_name = 'colormag-footer--classic-bordered';
		}

		return $class_name;

	}

endif;


if ( ! function_exists( 'colormag_copyright_alignment_class' ) ) :

	/**
	 * Function to return the classname for footer copyright alignment class.
	 *
	 * @return string CSS classname.
	 */
	function colormag_copyright_alignment_class() {

		$colormag_copyright_alignment_class = get_theme_mod( 'colormag_footer_bar_alignment', 'left' );
		$class_name                         = 'cm-footer-bar-style-1';

		if ( 'right' === $colormag_copyright_alignment_class ) {
			$class_name = 'cm-footer-bar-style-2';
		} elseif ( 'center' === $colormag_copyright_alignment_class ) {
			$class_name = 'cm-footer-bar-style-3';
		}

		return $class_name;

	}

endif;
