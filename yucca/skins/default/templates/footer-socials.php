<?php
/**
 * The template to display the socials in the footer
 *
 * @package YUCCA
 * @since YUCCA 1.0.10
 */


// Socials
if ( yucca_is_on( yucca_get_theme_option( 'socials_in_footer' ) ) ) {
	$yucca_output = yucca_get_socials_links();
	if ( '' != $yucca_output ) {
		?>
		<div class="footer_socials_wrap socials_wrap">
			<div class="footer_socials_inner">
				<?php yucca_show_layout( $yucca_output ); ?>
			</div>
		</div>
		<?php
	}
}
