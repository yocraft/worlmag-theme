<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package ColorMag
 *
 * @since   ColorMag 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?><?php echo colormag_schema_markup( 'entry' ); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>>
	<?php
	/**
	 * Hook: colormag_before_post_content.
	 */
	do_action( 'colormag_before_post_content' );

	/**
	 * Hook: colormag_before_single_page_loop.
	 */
	do_action( 'colormag_before_single_page_loop' );
	?>

	<?php if ( 1 == get_theme_mod( 'colormag_enable_page_featured_image', 0 ) && has_post_thumbnail() ) : ?>
		<div class="cm-featured-image"<?php echo colormag_schema_markup( 'image' ); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>>
			<?php
			the_post_thumbnail( 'colormag-featured-image' );

			if ( 1 == get_theme_mod( 'colormag_enable_schema_markup', '' ) ) :
				?>
				<meta itemprop="url" content="<?php echo esc_url( get_the_post_thumbnail_url( $post->ID, 'full' ) ); ?>">
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<?php
	if ( ( ! is_page_template( 'page-templates/page-builder.php' ) ) ) {

		$markup = is_front_page() ? 'h2' : 'h1';
		?>
		<header class="cm-entry-header">
			<<?php echo esc_attr( $markup ); ?> class="cm-entry-title"<?php echo colormag_schema_markup( 'entry_title' ); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>>
				<?php the_title(); ?>
			</<?php echo esc_attr( $markup ); ?> >
		</header>

		<?php
	}
	?>

	<div class="cm-entry-summary"<?php echo colormag_schema_markup( 'entry_content' ); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>>
		<?php
		the_content();

		wp_link_pages(
			array(
				'before'      => '<div style="clear: both;"></div><div class="link-pagination">' . esc_html__( 'Pages:', 'colormag' ),
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			)
		);
		?>
	</div>

	<div class="cm-entry-footer">

	<div class="cm-entry-footer">
		<?php
		$meta_orders = get_theme_mod( 'colormag_post_meta_structure' );
		// Edit button remove option add.
		if ( is_array( $meta_orders ) ) {
			foreach ( $meta_orders as $key => $meta_order ) {
				if ( 'edit-button' === $meta_order ) {
					edit_post_link( __( 'Edit', 'colormag' ), '<span class="cm-edit-link">' . colormag_get_icon( 'edit', false ) . ' ', '</span>' );
				}
			}
		}
		?>
	</div>

	<?php
	/**
	 * Hook: colormag_after_single_page_loop.
	 */
	do_action( 'colormag_after_single_page_loop' );

	/**
	 * Hook: colormag_after_post_content.
	 */
	do_action( 'colormag_after_post_content' );
	?>
</article>
