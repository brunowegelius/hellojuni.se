<?php
/**
 * The template to display single post
 *
 * @package YUCCA
 * @since YUCCA 1.0
 */

// Full post loading
$full_post_loading          = yucca_get_value_gp( 'action' ) == 'full_post_loading';

// Prev post loading
$prev_post_loading          = yucca_get_value_gp( 'action' ) == 'prev_post_loading';
$prev_post_loading_type     = yucca_get_theme_option( 'posts_navigation_scroll_which_block', 'article' );

// Position of the related posts
$yucca_related_position   = yucca_get_theme_option( 'related_position', 'below_content' );

// Type of the prev/next post navigation
$yucca_posts_navigation   = yucca_get_theme_option( 'posts_navigation' );
$yucca_prev_post          = false;
$yucca_prev_post_same_cat = (int)yucca_get_theme_option( 'posts_navigation_scroll_same_cat', 1 );

// Rewrite style of the single post if current post loading via AJAX and featured image and title is not in the content
if ( ( $full_post_loading 
		|| 
		( $prev_post_loading && 'article' == $prev_post_loading_type )
	) 
	&& 
	! in_array( yucca_get_theme_option( 'single_style' ), array( 'style-6' ) )
) {
	yucca_storage_set_array( 'options_meta', 'single_style', 'style-6' );
}

do_action( 'yucca_action_prev_post_loading', $prev_post_loading, $prev_post_loading_type );

get_header();

while ( have_posts() ) {

	the_post();

	// Type of the prev/next post navigation
	if ( 'scroll' == $yucca_posts_navigation ) {
		$yucca_prev_post = get_previous_post( $yucca_prev_post_same_cat );  // Get post from same category
		if ( ! $yucca_prev_post && $yucca_prev_post_same_cat ) {
			$yucca_prev_post = get_previous_post( false );                    // Get post from any category
		}
		if ( ! $yucca_prev_post ) {
			$yucca_posts_navigation = 'links';
		}
	}

	// Override some theme options to display featured image, title and post meta in the dynamic loaded posts
	if ( $full_post_loading || ( $prev_post_loading && $yucca_prev_post ) ) {
		yucca_sc_layouts_showed( 'featured', false );
		yucca_sc_layouts_showed( 'title', false );
		yucca_sc_layouts_showed( 'postmeta', false );
	}

	// If related posts should be inside the content
	if ( strpos( $yucca_related_position, 'inside' ) === 0 ) {
		ob_start();
	}

	// Display post's content
	get_template_part( apply_filters( 'yucca_filter_get_template_part', 'templates/content', 'single-' . yucca_get_theme_option( 'single_style' ) ), 'single-' . yucca_get_theme_option( 'single_style' ) );

	// If related posts should be inside the content
	if ( strpos( $yucca_related_position, 'inside' ) === 0 ) {
		$yucca_content = ob_get_contents();
		ob_end_clean();

		ob_start();
		do_action( 'yucca_action_related_posts' );
		$yucca_related_content = ob_get_contents();
		ob_end_clean();

		if ( ! empty( $yucca_related_content ) ) {
			$yucca_related_position_inside = max( 0, min( 9, yucca_get_theme_option( 'related_position_inside' ) ) );
			if ( 0 == $yucca_related_position_inside ) {
				$yucca_related_position_inside = mt_rand( 1, 9 );
			}

			$yucca_p_number         = 0;
			$yucca_related_inserted = false;
			$yucca_in_block         = false;
			$yucca_content_start    = strpos( $yucca_content, '<div class="post_content' );
			$yucca_content_end      = strrpos( $yucca_content, '</div>' );

			for ( $i = max( 0, $yucca_content_start ); $i < min( strlen( $yucca_content ) - 3, $yucca_content_end ); $i++ ) {
				if ( $yucca_content[ $i ] != '<' ) {
					continue;
				}
				if ( $yucca_in_block ) {
					if ( strtolower( substr( $yucca_content, $i + 1, 12 ) ) == '/blockquote>' ) {
						$yucca_in_block = false;
						$i += 12;
					}
					continue;
				} else if ( strtolower( substr( $yucca_content, $i + 1, 10 ) ) == 'blockquote' && in_array( $yucca_content[ $i + 11 ], array( '>', ' ' ) ) ) {
					$yucca_in_block = true;
					$i += 11;
					continue;
				} else if ( 'p' == $yucca_content[ $i + 1 ] && in_array( $yucca_content[ $i + 2 ], array( '>', ' ' ) ) ) {
					$yucca_p_number++;
					if ( $yucca_related_position_inside == $yucca_p_number ) {
						$yucca_related_inserted = true;
						$yucca_content = ( $i > 0 ? substr( $yucca_content, 0, $i ) : '' )
											. $yucca_related_content
											. substr( $yucca_content, $i );
					}
				}
			}
			if ( ! $yucca_related_inserted ) {
				if ( $yucca_content_end > 0 ) {
					$yucca_content = substr( $yucca_content, 0, $yucca_content_end ) . $yucca_related_content . substr( $yucca_content, $yucca_content_end );
				} else {
					$yucca_content .= $yucca_related_content;
				}
			}
		}

		yucca_show_layout( $yucca_content );
	}

	// Comments
	do_action( 'yucca_action_before_comments' );
	comments_template();
	do_action( 'yucca_action_after_comments' );

	// Related posts
	if ( 'below_content' == $yucca_related_position
		&& ( 'scroll' != $yucca_posts_navigation || (int)yucca_get_theme_option( 'posts_navigation_scroll_hide_related', 0 ) == 0 )
		&& ( ! $full_post_loading || (int)yucca_get_theme_option( 'open_full_post_hide_related', 1 ) == 0 )
	) {
		do_action( 'yucca_action_related_posts' );
	}

	// Post navigation: type 'scroll'
	if ( 'scroll' == $yucca_posts_navigation && ! $full_post_loading ) {
		?>
		<div class="nav-links-single-scroll"
			data-post-id="<?php echo esc_attr( get_the_ID( $yucca_prev_post ) ); ?>"
			data-post-link="<?php echo esc_attr( get_permalink( $yucca_prev_post ) ); ?>"
			data-post-title="<?php the_title_attribute( array( 'post' => $yucca_prev_post ) ); ?>"
			data-cur-post-link="<?php echo esc_attr( get_permalink() ); ?>"
			data-cur-post-title="<?php the_title_attribute(); ?>"
			<?php do_action( 'yucca_action_nav_links_single_scroll_data', $yucca_prev_post ); ?>
		></div>
		<?php
	}
}

get_footer();
