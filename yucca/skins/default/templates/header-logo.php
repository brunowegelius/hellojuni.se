<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package YUCCA
 * @since YUCCA 1.0
 */

$yucca_args = get_query_var( 'yucca_logo_args' );

// Site logo
$yucca_logo_type   = isset( $yucca_args['type'] ) ? $yucca_args['type'] : '';
$yucca_logo_image  = yucca_get_logo_image( $yucca_logo_type );
$yucca_logo_text   = yucca_is_on( yucca_get_theme_option( 'logo_text' ) ) ? get_bloginfo( 'name' ) : '';
$yucca_logo_slogan = get_bloginfo( 'description', 'display' );
if ( ! empty( $yucca_logo_image['logo'] ) || ! empty( $yucca_logo_text ) ) {
	?><a class="sc_layouts_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php
		if ( ! empty( $yucca_logo_image['logo'] ) ) {
			if ( empty( $yucca_logo_type ) && function_exists( 'the_custom_logo' ) && is_numeric($yucca_logo_image['logo']) && (int) $yucca_logo_image['logo'] > 0 ) {
				the_custom_logo();
			} else {
				$yucca_attr = yucca_getimagesize( $yucca_logo_image['logo'] );
				echo '<img src="' . esc_url( $yucca_logo_image['logo'] ) . '"'
						. ( ! empty( $yucca_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $yucca_logo_image['logo_retina'] ) . ' 2x"' : '' )
						. ' alt="' . esc_attr( $yucca_logo_text ) . '"'
						. ( ! empty( $yucca_attr[3] ) ? ' ' . wp_kses_data( $yucca_attr[3] ) : '' )
						. '>';
			}
		} else {
			yucca_show_layout( yucca_prepare_macros( $yucca_logo_text ), '<span class="logo_text">', '</span>' );
			yucca_show_layout( yucca_prepare_macros( $yucca_logo_slogan ), '<span class="logo_slogan">', '</span>' );
		}
		?>
	</a>
	<?php
}
