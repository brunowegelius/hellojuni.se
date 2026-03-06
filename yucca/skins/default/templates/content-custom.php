<?php
/**
 * The custom template to display the content
 *
 * Used for index/archive/search.
 *
 * @package YUCCA
 * @since YUCCA 1.0.50
 */

$yucca_template_args = get_query_var( 'yucca_template_args' );
if ( is_array( $yucca_template_args ) ) {
	$yucca_columns    = empty( $yucca_template_args['columns'] ) ? 2 : max( 1, $yucca_template_args['columns'] );
	$yucca_blog_style = array( $yucca_template_args['type'], $yucca_columns );
} else {
	$yucca_template_args = array();
	$yucca_blog_style = explode( '_', yucca_get_theme_option( 'blog_style' ) );
	$yucca_columns    = empty( $yucca_blog_style[1] ) ? 2 : max( 1, $yucca_blog_style[1] );
}
$yucca_blog_id       = yucca_get_custom_blog_id( join( '_', $yucca_blog_style ) );
$yucca_blog_style[0] = str_replace( 'blog-custom-', '', $yucca_blog_style[0] );
$yucca_expanded      = ! yucca_sidebar_present() && yucca_get_theme_option( 'expand_content' ) == 'expand';
$yucca_components    = ! empty( $yucca_template_args['meta_parts'] )
							? ( is_array( $yucca_template_args['meta_parts'] )
								? join( ',', $yucca_template_args['meta_parts'] )
								: $yucca_template_args['meta_parts']
								)
							: yucca_array_get_keys_by_value( yucca_get_theme_option( 'meta_parts' ) );
$yucca_post_format   = get_post_format();
$yucca_post_format   = empty( $yucca_post_format ) ? 'standard' : str_replace( 'post-format-', '', $yucca_post_format );

$yucca_blog_meta     = yucca_get_custom_layout_meta( $yucca_blog_id );
$yucca_custom_style  = ! empty( $yucca_blog_meta['scripts_required'] ) ? $yucca_blog_meta['scripts_required'] : 'none';

if ( ! empty( $yucca_template_args['slider'] ) || $yucca_columns > 1 || ! yucca_is_off( $yucca_custom_style ) ) {
	?><div class="
		<?php
		if ( ! empty( $yucca_template_args['slider'] ) ) {
			echo 'slider-slide swiper-slide';
		} else {
			echo esc_attr( ( yucca_is_off( $yucca_custom_style ) ? 'column' : sprintf( '%1$s_item %1$s_item', $yucca_custom_style ) ) . "-1_{$yucca_columns}" );
		}
		?>
	">
	<?php
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
			'post_item post_item_container post_format_' . esc_attr( $yucca_post_format )
					. ' post_layout_custom post_layout_custom_' . esc_attr( $yucca_columns )
					. ' post_layout_' . esc_attr( $yucca_blog_style[0] )
					. ' post_layout_' . esc_attr( $yucca_blog_style[0] ) . '_' . esc_attr( $yucca_columns )
					. ( ! yucca_is_off( $yucca_custom_style )
						? ' post_layout_' . esc_attr( $yucca_custom_style )
							. ' post_layout_' . esc_attr( $yucca_custom_style ) . '_' . esc_attr( $yucca_columns )
						: ''
						)
		);
	yucca_add_blog_animation( $yucca_template_args );
	?>
>
	<?php
	// Sticky label
	if ( is_sticky() && ! is_paged() ) {
		?>
		<span class="post_label label_sticky"></span>
		<?php
	}
	// Custom layout
	do_action( 'yucca_action_show_layout', $yucca_blog_id, get_the_ID() );
	?>
</article><?php
if ( ! empty( $yucca_template_args['slider'] ) || $yucca_columns > 1 || ! yucca_is_off( $yucca_custom_style ) ) {
	?></div><?php
	// Need opening PHP-tag above just after </div>, because <div> is a inline-block element (used as column)!
}
