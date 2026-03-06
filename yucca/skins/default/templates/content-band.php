<?php
/**
 * 'Band' template to display the content
 *
 * Used for index/archive/search.
 *
 * @package YUCCA
 * @since YUCCA 1.71.0
 */

$yucca_template_args = get_query_var( 'yucca_template_args' );
if ( ! is_array( $yucca_template_args ) ) {
	$yucca_template_args = array(
								'type'    => 'band',
								'columns' => 1
								);
}

$yucca_columns       = 1;

$yucca_expanded      = ! yucca_sidebar_present() && yucca_get_theme_option( 'expand_content' ) == 'expand';

$yucca_post_format   = get_post_format();
$yucca_post_format   = empty( $yucca_post_format ) ? 'standard' : str_replace( 'post-format-', '', $yucca_post_format );

if ( is_array( $yucca_template_args ) ) {
	$yucca_columns    = empty( $yucca_template_args['columns'] ) ? 1 : max( 1, $yucca_template_args['columns'] );
	$yucca_blog_style = array( $yucca_template_args['type'], $yucca_columns );
	if ( ! empty( $yucca_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $yucca_columns > 1 ) {
	    $yucca_columns_class = yucca_get_column_class( 1, $yucca_columns, ! empty( $yucca_template_args['columns_tablet']) ? $yucca_template_args['columns_tablet'] : '', ! empty($yucca_template_args['columns_mobile']) ? $yucca_template_args['columns_mobile'] : '' );
				?><div class="<?php echo esc_attr( $yucca_columns_class ); ?>"><?php
	}
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_item_container post_layout_band post_format_' . esc_attr( $yucca_post_format ) );
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
			'thumb_bg'   => true,
			'thumb_ratio'   => '1:1',
			'thumb_size' => ! empty( $yucca_template_args['thumb_size'] )
								? $yucca_template_args['thumb_size']
								: yucca_get_thumb_size( 
								in_array( $yucca_post_format, array( 'gallery', 'audio', 'video' ) )
									? ( strpos( yucca_get_theme_option( 'body_style' ), 'full' ) !== false
										? 'full'
										: ( $yucca_expanded 
											? 'big' 
											: 'medium-square'
											)
										)
									: 'masonry-big'
								)
		),
		'content-band',
		$yucca_template_args
	) );

	?><div class="post_content_wrap"><?php

		// Title and post meta
		$yucca_show_title = get_the_title() != '';
		$yucca_show_meta  = count( $yucca_components ) > 0 && ! in_array( $yucca_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );
		if ( $yucca_show_title ) {
			?>
			<div class="post_header entry-header">
				<?php
				// Categories
				if ( apply_filters( 'yucca_filter_show_blog_categories', $yucca_show_meta && in_array( 'categories', $yucca_components ), array( 'categories' ), 'band' ) ) {
					do_action( 'yucca_action_before_post_category' );
					?>
					<div class="post_category">
						<?php
						yucca_show_post_meta( apply_filters(
															'yucca_filter_post_meta_args',
															array(
																'components' => 'categories',
																'seo'        => false,
																'echo'       => true,
																'cat_sep'    => false,
																),
															'hover_' . $yucca_hover, 1
															)
											);
						?>
					</div>
					<?php
					$yucca_components = yucca_array_delete_by_value( $yucca_components, 'categories' );
					do_action( 'yucca_action_after_post_category' );
				}
				// Post title
				if ( apply_filters( 'yucca_filter_show_blog_title', true, 'band' ) ) {
					do_action( 'yucca_action_before_post_title' );
					if ( empty( $yucca_template_args['no_links'] ) ) {
						the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
					} else {
						the_title( '<h4 class="post_title entry-title">', '</h4>' );
					}
					do_action( 'yucca_action_after_post_title' );
				}
				?>
			</div><!-- .post_header -->
			<?php
		}

		// Post content
		if ( ! isset( $yucca_template_args['excerpt_length'] ) && ! in_array( $yucca_post_format, array( 'gallery', 'audio', 'video' ) ) ) {
			$yucca_template_args['excerpt_length'] = 13;
		}
		if ( apply_filters( 'yucca_filter_show_blog_excerpt', empty( $yucca_template_args['hide_excerpt'] ) && yucca_get_theme_option( 'excerpt_length' ) > 0, 'band' ) ) {
			?>
			<div class="post_content entry-content">
				<?php
				// Post content area
				yucca_show_post_content( $yucca_template_args, '<div class="post_content_inner">', '</div>' );
				?>
			</div><!-- .entry-content -->
			<?php
		}
		// Post meta
		if ( apply_filters( 'yucca_filter_show_blog_meta', $yucca_show_meta, $yucca_components, 'band' ) ) {
			if ( count( $yucca_components ) > 0 ) {
				do_action( 'yucca_action_before_post_meta' );
				yucca_show_post_meta(
					apply_filters(
						'yucca_filter_post_meta_args', array(
							'components' => join( ',', $yucca_components ),
							'seo'        => false,
							'echo'       => true,
						), 'band', 1
					)
				);
				do_action( 'yucca_action_after_post_meta' );
			}
		}
		// More button
		if ( apply_filters( 'yucca_filter_show_blog_readmore', ! $yucca_show_title || ! empty( $yucca_template_args['more_button'] ), 'band' ) ) {
			if ( empty( $yucca_template_args['no_links'] ) ) {
				do_action( 'yucca_action_before_post_readmore' );
				yucca_show_post_more_link( $yucca_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'yucca_action_after_post_readmore' );
			}
		}
		?>
	</div>
</article>
<?php

if ( is_array( $yucca_template_args ) ) {
	if ( ! empty( $yucca_template_args['slider'] ) || $yucca_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
