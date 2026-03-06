<?php
/**
 * The template to display default site footer
 *
 * @package YUCCA
 * @since YUCCA 1.0.10
 */

?>
<footer class="footer_wrap footer_default
<?php
$yucca_footer_scheme = yucca_get_theme_option( 'footer_scheme' );
if ( ! empty( $yucca_footer_scheme ) && ! yucca_is_inherit( $yucca_footer_scheme  ) ) {
	echo ' scheme_' . esc_attr( $yucca_footer_scheme );
}
?>
				">
	<?php

	// Footer widgets area
	get_template_part( apply_filters( 'yucca_filter_get_template_part', 'templates/footer-widgets' ) );

	// Logo
	get_template_part( apply_filters( 'yucca_filter_get_template_part', 'templates/footer-logo' ) );

	// Socials
	get_template_part( apply_filters( 'yucca_filter_get_template_part', 'templates/footer-socials' ) );

	// Copyright area
	get_template_part( apply_filters( 'yucca_filter_get_template_part', 'templates/footer-copyright' ) );

	?>
</footer><!-- /.footer_wrap -->
