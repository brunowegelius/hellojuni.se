<?php
/**
 * The template to display default site header
 *
 * @package YUCCA
 * @since YUCCA 1.0
 */

$yucca_header_css   = '';
$yucca_header_image = get_header_image();
$yucca_header_video = yucca_get_header_video();
if ( ! empty( $yucca_header_image ) && yucca_trx_addons_featured_image_override( is_singular() || yucca_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$yucca_header_image = yucca_get_current_mode_image( $yucca_header_image );
}

?><header class="top_panel top_panel_default
	<?php
	echo ! empty( $yucca_header_image ) || ! empty( $yucca_header_video ) ? ' with_bg_image' : ' without_bg_image';
	if ( '' != $yucca_header_video ) {
		echo ' with_bg_video';
	}
	if ( '' != $yucca_header_image ) {
		echo ' ' . esc_attr( yucca_add_inline_css_class( 'background-image: url(' . esc_url( $yucca_header_image ) . ');' ) );
	}
	if ( is_single() && has_post_thumbnail() ) {
		echo ' with_featured_image';
	}
	if ( yucca_is_on( yucca_get_theme_option( 'header_fullheight' ) ) ) {
		echo ' header_fullheight yucca-full-height';
	}
	$yucca_header_scheme = yucca_get_theme_option( 'header_scheme' );
	if ( ! empty( $yucca_header_scheme ) && ! yucca_is_inherit( $yucca_header_scheme  ) ) {
		echo ' scheme_' . esc_attr( $yucca_header_scheme );
	}
	?>
">
	<?php

	// Background video
	if ( ! empty( $yucca_header_video ) ) {
		get_template_part( apply_filters( 'yucca_filter_get_template_part', 'templates/header-video' ) );
	}

	// Main menu
	get_template_part( apply_filters( 'yucca_filter_get_template_part', 'templates/header-navi' ) );

	// Mobile header
	if ( yucca_is_on( yucca_get_theme_option( 'header_mobile_enabled' ) ) ) {
		get_template_part( apply_filters( 'yucca_filter_get_template_part', 'templates/header-mobile' ) );
	}

	// Page title and breadcrumbs area
	if ( ! is_single() ) {
		get_template_part( apply_filters( 'yucca_filter_get_template_part', 'templates/header-title' ) );
	}

	// Header widgets area
	get_template_part( apply_filters( 'yucca_filter_get_template_part', 'templates/header-widgets' ) );
	?>
</header>
