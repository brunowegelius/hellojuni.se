<?php
/**
 * The template to display the background video in the header
 *
 * @package YUCCA
 * @since YUCCA 1.0.14
 */
$yucca_header_video = yucca_get_header_video();
$yucca_embed_video  = '';
if ( ! empty( $yucca_header_video ) && ! yucca_is_from_uploads( $yucca_header_video ) ) {
	if ( yucca_is_youtube_url( $yucca_header_video ) && preg_match( '/[=\/]([^=\/]*)$/', $yucca_header_video, $matches ) && ! empty( $matches[1] ) ) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr( $matches[1] ); ?>"></div>
		<?php
	} else {
		?>
		<div id="background_video"><?php yucca_show_layout( yucca_get_embed_video( $yucca_header_video ) ); ?></div>
		<?php
	}
}
