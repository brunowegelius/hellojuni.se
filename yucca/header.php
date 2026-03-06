<?php
/**
 * The Header: Logo and main menu
 *
 * @package YUCCA
 * @since YUCCA 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js<?php
	// Class scheme_xxx need in the <html> as context for the <body>!
	echo ' scheme_' . esc_attr( yucca_get_theme_option( 'color_scheme' ) );
?>">

<head>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' );
	}
	do_action( 'yucca_action_before_body' );
	?>

	<div class="<?php echo esc_attr( apply_filters( 'yucca_filter_body_wrap_class', 'body_wrap' ) ); ?>" <?php do_action('yucca_action_body_wrap_attributes'); ?>>

		<?php do_action( 'yucca_action_before_page_wrap' ); ?>

		<div class="<?php echo esc_attr( apply_filters( 'yucca_filter_page_wrap_class', 'page_wrap' ) ); ?>" <?php do_action('yucca_action_page_wrap_attributes'); ?>>

			<?php do_action( 'yucca_action_page_wrap_start' ); ?>

			<?php
			$yucca_full_post_loading = ( yucca_is_singular( 'post' ) || yucca_is_singular( 'attachment' ) ) && yucca_get_value_gp( 'action' ) == 'full_post_loading';
			$yucca_prev_post_loading = ( yucca_is_singular( 'post' ) || yucca_is_singular( 'attachment' ) ) && yucca_get_value_gp( 'action' ) == 'prev_post_loading';

			// Don't display the header elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ! $yucca_full_post_loading && ! $yucca_prev_post_loading ) {

				// Short links to fast access to the content, sidebar and footer from the keyboard
				?>
				<a class="yucca_skip_link skip_to_content_link" href="#content_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'yucca_filter_skip_links_tabindex', 0 ) ); ?>"><?php esc_html_e( "Skip to content", 'yucca' ); ?></a>
				<?php if ( yucca_sidebar_present() ) { ?>
				<a class="yucca_skip_link skip_to_sidebar_link" href="#sidebar_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'yucca_filter_skip_links_tabindex', 0 ) ); ?>"><?php esc_html_e( "Skip to sidebar", 'yucca' ); ?></a>
				<?php } ?>
				<a class="yucca_skip_link skip_to_footer_link" href="#footer_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'yucca_filter_skip_links_tabindex', 0 ) ); ?>"><?php esc_html_e( "Skip to footer", 'yucca' ); ?></a>

				<?php
				do_action( 'yucca_action_before_header' );

				// Header
				$yucca_header_type = yucca_get_theme_option( 'header_type' );
				if ( 'custom' == $yucca_header_type && ! yucca_is_layouts_available() ) {
					$yucca_header_type = 'default';
				}
				get_template_part( apply_filters( 'yucca_filter_get_template_part', "templates/header-" . sanitize_file_name( $yucca_header_type ) ) );

				// Side menu
				if ( in_array( yucca_get_theme_option( 'menu_side', 'none' ), array( 'left', 'right' ) ) ) {
					get_template_part( apply_filters( 'yucca_filter_get_template_part', 'templates/header-navi-side' ) );
				}

				// Mobile menu
				if ( apply_filters( 'yucca_filter_use_navi_mobile', yucca_sc_layouts_showed( 'menu_button' ) || $yucca_header_type == 'default' ) ) {
					get_template_part( apply_filters( 'yucca_filter_get_template_part', 'templates/header-navi-mobile' ) );
				}

				do_action( 'yucca_action_after_header' );

			}
			?>

			<?php do_action( 'yucca_action_before_page_content_wrap' ); ?>

			<div class="page_content_wrap<?php
				if ( yucca_is_off( yucca_get_theme_option( 'remove_margins' ) ) ) {
					if ( empty( $yucca_header_type ) ) {
						$yucca_header_type = yucca_get_theme_option( 'header_type' );
					}
					if ( 'custom' == $yucca_header_type && yucca_is_layouts_available() ) {
						$yucca_header_id = yucca_get_custom_header_id();
						if ( $yucca_header_id > 0 ) {
							$yucca_header_meta = yucca_get_custom_layout_meta( $yucca_header_id );
							if ( ! empty( $yucca_header_meta['margin'] ) ) {
								?> page_content_wrap_custom_header_margin<?php
							}
						}
					}
					$yucca_footer_type = yucca_get_theme_option( 'footer_type' );
					if ( 'custom' == $yucca_footer_type && yucca_is_layouts_available() ) {
						$yucca_footer_id = yucca_get_custom_footer_id();
						if ( $yucca_footer_id ) {
							$yucca_footer_meta = yucca_get_custom_layout_meta( $yucca_footer_id );
							if ( ! empty( $yucca_footer_meta['margin'] ) ) {
								?> page_content_wrap_custom_footer_margin<?php
							}
						}
					}
				}
				do_action( 'yucca_action_page_content_wrap_class', $yucca_prev_post_loading );
				?>"<?php
				if ( apply_filters( 'yucca_filter_is_prev_post_loading', $yucca_prev_post_loading ) ) {
					?> data-single-style="<?php echo esc_attr( yucca_get_theme_option( 'single_style' ) ); ?>"<?php
				}
				do_action( 'yucca_action_page_content_wrap_data', $yucca_prev_post_loading );
			?>>
				<?php
				do_action( 'yucca_action_page_content_wrap', $yucca_full_post_loading || $yucca_prev_post_loading );

				// Single posts banner
				if ( apply_filters( 'yucca_filter_single_post_header', yucca_is_singular( 'post' ) || yucca_is_singular( 'attachment' ) ) ) {
					if ( $yucca_prev_post_loading ) {
						if ( yucca_get_theme_option( 'posts_navigation_scroll_which_block', 'article' ) != 'article' ) {
							do_action( 'yucca_action_between_posts' );
						}
					}
					// Single post thumbnail and title
					$yucca_path = apply_filters( 'yucca_filter_get_template_part', 'templates/single-styles/' . yucca_get_theme_option( 'single_style' ) );
					if ( yucca_get_file_dir( $yucca_path . '.php' ) != '' ) {
						get_template_part( $yucca_path );
					}
				}

				// Widgets area above page
				$yucca_body_style   = yucca_get_theme_option( 'body_style' );
				$yucca_widgets_name = yucca_get_theme_option( 'widgets_above_page', 'hide' );
				$yucca_show_widgets = ! yucca_is_off( $yucca_widgets_name ) && is_active_sidebar( $yucca_widgets_name );
				if ( $yucca_show_widgets ) {
					if ( 'fullscreen' != $yucca_body_style ) {
						?>
						<div class="content_wrap">
							<?php
					}
					yucca_create_widgets_area( 'widgets_above_page' );
					if ( 'fullscreen' != $yucca_body_style ) {
						?>
						</div>
						<?php
					}
				}

				// Content area
				do_action( 'yucca_action_before_content_wrap' );
				?>
				<div class="content_wrap<?php echo 'fullscreen' == $yucca_body_style ? '_fullscreen' : ''; ?>">

					<?php do_action( 'yucca_action_content_wrap_start' ); ?>

					<div class="content">
						<?php
						do_action( 'yucca_action_page_content_start' );

						// Skip link anchor to fast access to the content from keyboard
						?>
						<span id="content_skip_link_anchor" class="yucca_skip_link_anchor"></span>
						<?php
						// Single posts banner between prev/next posts
						if ( ( yucca_is_singular( 'post' ) || yucca_is_singular( 'attachment' ) )
							&& $yucca_prev_post_loading 
							&& yucca_get_theme_option( 'posts_navigation_scroll_which_block', 'article' ) == 'article'
						) {
							do_action( 'yucca_action_between_posts' );
						}

						// Widgets area above content
						yucca_create_widgets_area( 'widgets_above_content' );

						do_action( 'yucca_action_page_content_start_text' );
