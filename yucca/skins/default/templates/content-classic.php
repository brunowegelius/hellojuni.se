<?php
/**
 * The Classic template to display the content
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
$yucca_expanded   = ! yucca_sidebar_present() && yucca_get_theme_option( 'expand_content' ) == 'expand';

$yucca_post_format = get_post_format();
$yucca_post_format = empty( $yucca_post_format ) ? 'standard' : str_replace( 'post-format-', '', $yucca_post_format );

?><div class="<?php
	if ( ! empty( $yucca_template_args['slider'] ) ) {
		echo ' slider-slide swiper-slide';
	} else {
		echo ( yucca_is_blog_style_use_masonry( $yucca_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $yucca_columns ) : esc_attr( $yucca_columns_class ) );
	}
?>"><article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $yucca_post_format )
				. ' post_layout_classic post_layout_classic_' . esc_attr( $yucca_columns )
				. ' post_layout_' . esc_attr( $yucca_blog_style[0] )
				. ' post_layout_' . esc_attr( $yucca_blog_style[0] ) . '_' . esc_attr( $yucca_columns )
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

	// Featured image
	$yucca_hover      = ! empty( $yucca_template_args['hover'] ) && ! yucca_is_inherit( $yucca_template_args['hover'] )
							? $yucca_template_args['hover']
							: yucca_get_theme_option( 'image_hover' );

	$yucca_components = ! empty( $yucca_template_args['meta_parts'] )
							? ( is_array( $yucca_template_args['meta_parts'] )
								? $yucca_template_args['meta_parts']
								: explode( ',', $yucca_template_args['meta_parts'] )
								)
							: yucca_array_get_keys_by_value( yucca_get_theme_option( 'meta_parts' ) );

	yucca_show_post_featured( apply_filters( 'yucca_filter_args_featured',
		array(
			'thumb_size' => ! empty( $yucca_template_args['thumb_size'] )
				? $yucca_template_args['thumb_size']
				: yucca_get_thumb_size(
					'classic' == $yucca_blog_style[0]
						? ( strpos( yucca_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $yucca_columns > 2 ? 'big' : 'huge' )
								: ( $yucca_columns > 2
									? ( $yucca_expanded ? 'square' : 'square' )
									: ($yucca_columns > 1 ? 'square' : ( $yucca_expanded ? 'huge' : 'big' ))
									)
							)
						: ( strpos( yucca_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $yucca_columns > 2 ? 'masonry-big' : 'full' )
								: ($yucca_columns === 1 ? ( $yucca_expanded ? 'huge' : 'big' ) : ( $yucca_columns <= 2 && $yucca_expanded ? 'masonry-big' : 'masonry' ))
							)
			),
			'hover'      => $yucca_hover,
			'meta_parts' => $yucca_components,
			'no_links'   => ! empty( $yucca_template_args['no_links'] ),
        ),
        'content-classic',
        $yucca_template_args
    ) );

	// Title and post meta
	$yucca_show_title = get_the_title() != '';
	$yucca_show_meta  = count( $yucca_components ) > 0 && ! in_array( $yucca_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $yucca_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php

			// Post meta
			if ( apply_filters( 'yucca_filter_show_blog_meta', $yucca_show_meta, $yucca_components, 'classic' ) ) {
				if ( count( $yucca_components ) > 0 ) {
					do_action( 'yucca_action_before_post_meta' );
					yucca_show_post_meta(
						apply_filters(
							'yucca_filter_post_meta_args', array(
							'components' => join( ',', $yucca_components ),
							'seo'        => false,
							'echo'       => true,
						), $yucca_blog_style[0], $yucca_columns
						)
					);
					do_action( 'yucca_action_after_post_meta' );
				}
			}

			// Post title
			if ( apply_filters( 'yucca_filter_show_blog_title', true, 'classic' ) ) {
				do_action( 'yucca_action_before_post_title' );
				if ( empty( $yucca_template_args['no_links'] ) ) {
					the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
				} else {
					the_title( '<h4 class="post_title entry-title">', '</h4>' );
				}
				do_action( 'yucca_action_after_post_title' );
			}

			if( !in_array( $yucca_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
				// More button
				if ( apply_filters( 'yucca_filter_show_blog_readmore', ! $yucca_show_title || ! empty( $yucca_template_args['more_button'] ), 'classic' ) ) {
					if ( empty( $yucca_template_args['no_links'] ) ) {
						do_action( 'yucca_action_before_post_readmore' );
						yucca_show_post_more_link( $yucca_template_args, '<div class="more-wrap">', '</div>' );
						do_action( 'yucca_action_after_post_readmore' );
					}
				}
			}
			?>
		</div><!-- .entry-header -->
		<?php
	}

	// Post content
	if( in_array( $yucca_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
		ob_start();
		if (apply_filters('yucca_filter_show_blog_excerpt', empty($yucca_template_args['hide_excerpt']) && yucca_get_theme_option('excerpt_length') > 0, 'classic')) {
			yucca_show_post_content($yucca_template_args, '<div class="post_content_inner">', '</div>');
		}
		// More button
		if(! empty( $yucca_template_args['more_button'] )) {
			if ( empty( $yucca_template_args['no_links'] ) ) {
				do_action( 'yucca_action_before_post_readmore' );
				yucca_show_post_more_link( $yucca_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'yucca_action_after_post_readmore' );
			}
		}
		$yucca_content = ob_get_contents();
		ob_end_clean();
		yucca_show_layout($yucca_content, '<div class="post_content entry-content">', '</div><!-- .entry-content -->');
	}
	?>

</article></div><?php
// Need opening PHP-tag above, because <div> is a inline-block element (used as column)!
