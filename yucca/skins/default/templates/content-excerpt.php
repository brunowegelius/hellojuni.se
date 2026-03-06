<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package YUCCA
 * @since YUCCA 1.0
 */

$yucca_template_args = get_query_var( 'yucca_template_args' );
$yucca_columns = 1;
if ( is_array( $yucca_template_args ) ) {
	$yucca_columns    = empty( $yucca_template_args['columns'] ) ? 1 : max( 1, $yucca_template_args['columns'] );
	$yucca_blog_style = array( $yucca_template_args['type'], $yucca_columns );
	if ( ! empty( $yucca_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $yucca_columns > 1 ) {
	    $yucca_columns_class = yucca_get_column_class( 1, $yucca_columns, ! empty( $yucca_template_args['columns_tablet']) ? $yucca_template_args['columns_tablet'] : '', ! empty($yucca_template_args['columns_mobile']) ? $yucca_template_args['columns_mobile'] : '' );
		?>
		<div class="<?php echo esc_attr( $yucca_columns_class ); ?>">
		<?php
	}
} else {
	$yucca_template_args = array();
}
$yucca_expanded    = ! yucca_sidebar_present() && yucca_get_theme_option( 'expand_content' ) == 'expand';
$yucca_post_format = get_post_format();
$yucca_post_format = empty( $yucca_post_format ) ? 'standard' : str_replace( 'post-format-', '', $yucca_post_format );
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_item_container post_layout_excerpt post_format_' . esc_attr( $yucca_post_format ) );
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
								: array_map( 'trim', explode( ',', $yucca_template_args['meta_parts'] ) )
								)
							: yucca_array_get_keys_by_value( yucca_get_theme_option( 'meta_parts' ) );
	yucca_show_post_featured( apply_filters( 'yucca_filter_args_featured',
		array(
			'no_links'   => ! empty( $yucca_template_args['no_links'] ),
			'hover'      => $yucca_hover,
			'meta_parts' => $yucca_components,
			'thumb_size' => ! empty( $yucca_template_args['thumb_size'] )
							? $yucca_template_args['thumb_size']
							: yucca_get_thumb_size( strpos( yucca_get_theme_option( 'body_style' ), 'full' ) !== false
								? 'full'
								: ( $yucca_expanded 
									? 'huge' 
									: 'big' 
									)
								),
		),
		'content-excerpt',
		$yucca_template_args
	) );

	// Title and post meta
	$yucca_show_title = get_the_title() != '';
	$yucca_show_meta  = count( $yucca_components ) > 0 && ! in_array( $yucca_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $yucca_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			if ( apply_filters( 'yucca_filter_show_blog_title', true, 'excerpt' ) ) {
				do_action( 'yucca_action_before_post_title' );
				if ( empty( $yucca_template_args['no_links'] ) ) {
					the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
				} else {
					the_title( '<h3 class="post_title entry-title">', '</h3>' );
				}
				do_action( 'yucca_action_after_post_title' );
			}
			?>
		</div><!-- .post_header -->
		<?php
	}

	// Post content
	if ( apply_filters( 'yucca_filter_show_blog_excerpt', empty( $yucca_template_args['hide_excerpt'] ) && yucca_get_theme_option( 'excerpt_length' ) > 0, 'excerpt' ) ) {
		?>
		<div class="post_content entry-content">
			<?php

			// Post meta
			if ( apply_filters( 'yucca_filter_show_blog_meta', $yucca_show_meta, $yucca_components, 'excerpt' ) ) {
				if ( count( $yucca_components ) > 0 ) {
					do_action( 'yucca_action_before_post_meta' );
					yucca_show_post_meta(
						apply_filters(
							'yucca_filter_post_meta_args', array(
								'components' => join( ',', $yucca_components ),
								'seo'        => false,
								'echo'       => true,
							), 'excerpt', 1
						)
					);
					do_action( 'yucca_action_after_post_meta' );
				}
			}

			if ( yucca_get_theme_option( 'blog_content' ) == 'fullpost' ) {
				// Post content area
				?>
				<div class="post_content_inner">
					<?php
					do_action( 'yucca_action_before_full_post_content' );
					the_content( '' );
					do_action( 'yucca_action_after_full_post_content' );
					?>
				</div>
				<?php
				// Inner pages
				wp_link_pages(
					array(
						'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'yucca' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'yucca' ) . ' </span>%',
						'separator'   => '<span class="screen-reader-text">, </span>',
					)
				);
			} else {
				// Post content area
				yucca_show_post_content( $yucca_template_args, '<div class="post_content_inner">', '</div>' );
			}

			// More button
			if ( apply_filters( 'yucca_filter_show_blog_readmore',  ! isset( $yucca_template_args['more_button'] ) || ! empty( $yucca_template_args['more_button'] ), 'excerpt' ) ) {
				if ( empty( $yucca_template_args['no_links'] ) ) {
					do_action( 'yucca_action_before_post_readmore' );
					if ( yucca_get_theme_option( 'blog_content' ) != 'fullpost' ) {
						yucca_show_post_more_link( $yucca_template_args, '<p>', '</p>' );
					} else {
						yucca_show_post_comments_link( $yucca_template_args, '<p>', '</p>' );
					}
					do_action( 'yucca_action_after_post_readmore' );
				}
			}

			?>
		</div><!-- .entry-content -->
		<?php
	}
	?>
</article>
<?php

if ( is_array( $yucca_template_args ) ) {
	if ( ! empty( $yucca_template_args['slider'] ) || $yucca_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
