<?php
/**
 * The template to display the site logo in the footer
 *
 * @package YUCCA
 * @since YUCCA 1.0.10
 */

// Logo
if ( yucca_is_on( yucca_get_theme_option( 'logo_in_footer' ) ) ) {
	$yucca_logo_image = yucca_get_logo_image( 'footer' );
	$yucca_logo_text  = get_bloginfo( 'name' );
	if ( ! empty( $yucca_logo_image['logo'] ) || ! empty( $yucca_logo_text ) ) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if ( ! empty( $yucca_logo_image['logo'] ) ) {
					$yucca_attr = yucca_getimagesize( $yucca_logo_image['logo'] );
					echo '<a href="' . esc_url( home_url( '/' ) ) . '">'
							. '<img src="' . esc_url( $yucca_logo_image['logo'] ) . '"'
								. ( ! empty( $yucca_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $yucca_logo_image['logo_retina'] ) . ' 2x"' : '' )
								. ' class="logo_footer_image"'
								. ' alt="' . esc_attr__( 'Site logo', 'yucca' ) . '"'
								. ( ! empty( $yucca_attr[3] ) ? ' ' . wp_kses_data( $yucca_attr[3] ) : '' )
							. '>'
						. '</a>';
				} elseif ( ! empty( $yucca_logo_text ) ) {
					echo '<h1 class="logo_footer_text">'
							. '<a href="' . esc_url( home_url( '/' ) ) . '">'
								. esc_html( $yucca_logo_text )
							. '</a>'
						. '</h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
