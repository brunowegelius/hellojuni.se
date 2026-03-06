<?php
/**
 * The Portfolio template to display the content
 *
 * Used for index/archive/search.
 *
 * @package YUCCA
 * @since YUCCA 1.0
 */

$yucca_template_args = get_query_var( 'yucca_template_args' );
if ( is_array( $yucca_template_args ) ) {
	$yucca_columns    = empty( $yucca_template_args['columns'] ) ? 2 : max( 1, $yucca_template_args['columns'] );
	$yucca_blog_style = array( $yucca_template_args['type'], $yucca_columns );
    $yucca_columns_class = yucca_get_column_class( 1, $yucca_columns, ! empty( $yucca_template_args['columns_tablet']) ? $yucca_template_args['columns_tablet'] : '', ! empty($yucca_template_args['columns_mobile']) ? $yucca_template_args['columns_mobile'] : '' );
} else {
	$yucca_template_args = array();
	$yucca_blog_style = explode( '_', yucca_get_theme_option( 'blog_style' ) );
	$yucca_columns    = empty( $yucca_blog_style[1] ) ? 2 : max( 1, $yucca_blog_style[1] );
    $yucca_columns_class = yucca_get_column_class( 1, $yucca_columns );
}

$yucca_post_format = get_post_format();
$yucca_post_format = empty( $yucca_post_format ) ? 'standard' : str_replace( 'post-format-', '', $yucca_post_format );

?><div class="
<?php
if ( ! empty( $yucca_template_args['slider'] ) ) {
	echo ' slider-slide swiper-slide';
} else {
	echo ( yucca_is_blog_style_use_masonry( $yucca_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $yucca_columns ) : esc_attr( $yucca_columns_class ));
}
?>
"><article id="post-<?php the_ID(); ?>" 
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $yucca_post_format )
		. ' post_layout_portfolio'
		. ' post_layout_portfolio_' . esc_attr( $yucca_columns )
		. ( 'portfolio' != $yucca_blog_style[0] ? ' ' . esc_attr( $yucca_blog_style[0] )  . '_' . esc_attr( $yucca_columns ) : '' )
	);
	yucca_add_blog_animation( $yucca_template_args );
	?>
>
<?php

	// Sticky label
	if ( is_sticky() && ! is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	$yucca_hover   = ! empty( $yucca_template_args['hover'] ) && ! yucca_is_inherit( $yucca_template_args['hover'] )
								? $yucca_template_args['hover']
								: yucca_get_theme_option( 'image_hover' );

	if ( 'dots' == $yucca_hover ) {
		$yucca_post_link = empty( $yucca_template_args['no_links'] )
								? ( ! empty( $yucca_template_args['link'] )
									? $yucca_template_args['link']
									: get_permalink()
									)
								: '';
		$yucca_target    = ! empty( $yucca_post_link ) && yucca_is_external_url( $yucca_post_link ) && function_exists( 'yucca_external_links_target' )
								? yucca_external_links_target()
								: '';
	}
	
	// Meta parts
	$yucca_components = ! empty( $yucca_template_args['meta_parts'] )
							? ( is_array( $yucca_template_args['meta_parts'] )
								? $yucca_template_args['meta_parts']
								: explode( ',', $yucca_template_args['meta_parts'] )
								)
							: yucca_array_get_keys_by_value( yucca_get_theme_option( 'meta_parts' ) );

	// Featured image
	yucca_show_post_featured( apply_filters( 'yucca_filter_args_featured', 
        array(
			'hover'         => $yucca_hover,
			'no_links'      => ! empty( $yucca_template_args['no_links'] ),
			'thumb_size'    => ! empty( $yucca_template_args['thumb_size'] )
								? $yucca_template_args['thumb_size']
								: yucca_get_thumb_size(
									yucca_is_blog_style_use_masonry( $yucca_blog_style[0] )
										? (	strpos( yucca_get_theme_option( 'body_style' ), 'full' ) !== false || $yucca_columns < 3
											? 'masonry-big'
											: 'masonry'
											)
										: (	strpos( yucca_get_theme_option( 'body_style' ), 'full' ) !== false || $yucca_columns < 3
											? 'square'
											: 'square'
											)
								),
			'thumb_bg' => yucca_is_blog_style_use_masonry( $yucca_blog_style[0] ) ? false : true,
			'show_no_image' => true,
			'meta_parts'    => $yucca_components,
			'class'         => 'dots' == $yucca_hover ? 'hover_with_info' : '',
			'post_info'     => 'dots' == $yucca_hover
										? '<div class="post_info"><h5 class="post_title">'
											. ( ! empty( $yucca_post_link )
												? '<a href="' . esc_url( $yucca_post_link ) . '"' . ( ! empty( $target ) ? $target : '' ) . '>'
												: ''
												)
												. esc_html( get_the_title() ) 
											. ( ! empty( $yucca_post_link )
												? '</a>'
												: ''
												)
											. '</h5></div>'
										: '',
            'thumb_ratio'   => 'info' == $yucca_hover ?  '100:102' : '',
        ),
        'content-portfolio',
        $yucca_template_args
    ) );
	?>
</article></div><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!