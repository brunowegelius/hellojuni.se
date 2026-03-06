<?php
/**
 * The template to display default site footer
 *
 * @package YUCCA
 * @since YUCCA 1.0.10
 */

$yucca_footer_id = yucca_get_custom_footer_id();
$yucca_footer_meta = get_post_meta( $yucca_footer_id, 'trx_addons_options', true );
if ( ! empty( $yucca_footer_meta['margin'] ) ) {
	yucca_add_inline_css( sprintf( '.page_content_wrap{padding-bottom:%s}', esc_attr( yucca_prepare_css_value( $yucca_footer_meta['margin'] ) ) ) );
}
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr( $yucca_footer_id ); ?> footer_custom_<?php echo esc_attr( sanitize_title( get_the_title( $yucca_footer_id ) ) ); ?>
						<?php
						$yucca_footer_scheme = yucca_get_theme_option( 'footer_scheme' );
						if ( ! empty( $yucca_footer_scheme ) && ! yucca_is_inherit( $yucca_footer_scheme  ) ) {
							echo ' scheme_' . esc_attr( $yucca_footer_scheme );
						}
						?>
						">
	<?php
	// Custom footer's layout
	do_action( 'yucca_action_show_layout', $yucca_footer_id );
	?>
</footer><!-- /.footer_wrap -->
