<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package YUCCA
 * @since YUCCA 1.0.10
 */

// Copyright area
?> 
<div class="footer_copyright_wrap
<?php
$yucca_copyright_scheme = yucca_get_theme_option( 'copyright_scheme' );
if ( ! empty( $yucca_copyright_scheme ) && ! yucca_is_inherit( $yucca_copyright_scheme  ) ) {
	echo ' scheme_' . esc_attr( $yucca_copyright_scheme );
}
?>
				">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text">
			<?php
				$yucca_copyright = yucca_get_theme_option( 'copyright' );
			if ( ! empty( $yucca_copyright ) ) {
				// Replace {{Y}} or {Y} with the current year
				$yucca_copyright = str_replace( array( '{{Y}}', '{Y}' ), date( 'Y' ), $yucca_copyright );
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$yucca_copyright = yucca_prepare_macros( $yucca_copyright );
				// Display copyright
				echo wp_kses( nl2br( $yucca_copyright ), 'yucca_kses_content' );
			}
			?>
			</div>
		</div>
	</div>
</div>
