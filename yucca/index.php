<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: //codex.wordpress.org/Template_Hierarchy
 *
 * @package YUCCA
 * @since YUCCA 1.0
 */

$yucca_template = apply_filters( 'yucca_filter_get_template_part', yucca_blog_archive_get_template() );

if ( ! empty( $yucca_template ) && 'index' != $yucca_template ) {

	get_template_part( $yucca_template );

} else {

	yucca_storage_set( 'blog_archive', true );

	get_header();

	if ( have_posts() ) {

		// Query params
		$yucca_stickies   = is_home()
								|| ( in_array( yucca_get_theme_option( 'post_type' ), array( '', 'post' ) )
									&& (int) yucca_get_theme_option( 'parent_cat' ) == 0
									)
										? get_option( 'sticky_posts' )
										: false;
		$yucca_post_type  = yucca_get_theme_option( 'post_type' );
		$yucca_args       = array(
								'blog_style'     => yucca_get_theme_option( 'blog_style' ),
								'post_type'      => $yucca_post_type,
								'taxonomy'       => yucca_get_post_type_taxonomy( $yucca_post_type ),
								'parent_cat'     => yucca_get_theme_option( 'parent_cat' ),
								'posts_per_page' => yucca_get_theme_option( 'posts_per_page' ),
								'sticky'         => yucca_get_theme_option( 'sticky_style', 'inherit' ) == 'columns'
															&& is_array( $yucca_stickies )
															&& count( $yucca_stickies ) > 0
															&& get_query_var( 'paged' ) < 1
								);

		yucca_blog_archive_start();

		do_action( 'yucca_action_blog_archive_start' );

		if ( is_author() ) {
			do_action( 'yucca_action_before_page_author' );
			get_template_part( apply_filters( 'yucca_filter_get_template_part', 'templates/author-page' ) );
			do_action( 'yucca_action_after_page_author' );
		}

		if ( yucca_get_theme_option( 'show_filters', 0 ) ) {
			do_action( 'yucca_action_before_page_filters' );
			yucca_show_filters( $yucca_args );
			do_action( 'yucca_action_after_page_filters' );
		} else {
			do_action( 'yucca_action_before_page_posts' );
			yucca_show_posts( array_merge( $yucca_args, array( 'cat' => $yucca_args['parent_cat'] ) ) );
			do_action( 'yucca_action_after_page_posts' );
		}

		do_action( 'yucca_action_blog_archive_end' );

		yucca_blog_archive_end();

	} else {

		if ( is_search() ) {
			get_template_part( apply_filters( 'yucca_filter_get_template_part', 'templates/content', 'none-search' ), 'none-search' );
		} else {
			get_template_part( apply_filters( 'yucca_filter_get_template_part', 'templates/content', 'none-archive' ), 'none-archive' );
		}
	}

	get_footer();
}
