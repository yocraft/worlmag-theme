<?php
/**
 * Template Name: Contact Page Template
 *
 * Displays the Contact Page Template of the theme.
 *
 * @package    ThemeGrill
 * @subpackage ColorMag
 * @since      ColorMag 1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

/**
 * Hook: colormag_before_body_content.
 */
do_action( 'colormag_before_body_content' );
?>

	<div id="cm-primary">
		<div id="cm-posts" class="clearfix">
			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( '/template-parts/content', 'page' );
			endwhile;
			?>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php

/**
 * Hook: colormag_after_body_content.
 */
do_action( 'colormag_after_body_content' );

get_footer();
