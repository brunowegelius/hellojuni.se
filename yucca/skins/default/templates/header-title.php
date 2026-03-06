<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package YUCCA
 * @since YUCCA 1.0
 */

// Page (category, tag, archive, author) title

if ( yucca_need_page_title() ) {
	yucca_sc_layouts_showed( 'title', true );
	yucca_sc_layouts_showed( 'postmeta', true );
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( is_single() ) {
							?>
							<div class="sc_layouts_title_meta">
							<?php
								yucca_show_post_meta(
									apply_filters(
										'yucca_filter_post_meta_args', array(
											'components' => join( ',', yucca_array_get_keys_by_value( yucca_get_theme_option( 'meta_parts' ) ) ),
											'counters'   => join( ',', yucca_array_get_keys_by_value( yucca_get_theme_option( 'counters' ) ) ),
											'seo'        => yucca_is_on( yucca_get_theme_option( 'seo_snippets' ) ),
										), 'header', 1
									)
								);
							?>
							</div>
							<?php
						}

						// Blog/Post title
						?>
						<div class="sc_layouts_title_title">
							<?php
							$yucca_blog_title           = yucca_get_blog_title();
							$yucca_blog_title_text      = '';
							$yucca_blog_title_class     = '';
							$yucca_blog_title_link      = '';
							$yucca_blog_title_link_text = '';
							if ( is_array( $yucca_blog_title ) ) {
								$yucca_blog_title_text      = $yucca_blog_title['text'];
								$yucca_blog_title_class     = ! empty( $yucca_blog_title['class'] ) ? ' ' . $yucca_blog_title['class'] : '';
								$yucca_blog_title_link      = ! empty( $yucca_blog_title['link'] ) ? $yucca_blog_title['link'] : '';
								$yucca_blog_title_link_text = ! empty( $yucca_blog_title['link_text'] ) ? $yucca_blog_title['link_text'] : '';
							} else {
								$yucca_blog_title_text = $yucca_blog_title;
							}
							?>
							<h1 class="sc_layouts_title_caption<?php echo esc_attr( $yucca_blog_title_class ); ?>"<?php
								if ( yucca_is_on( yucca_get_theme_option( 'seo_snippets' ) ) ) {
									?> itemprop="headline"<?php
								}
							?>>
								<?php
								$yucca_top_icon = yucca_get_term_image_small();
								if ( ! empty( $yucca_top_icon ) ) {
									$yucca_attr = yucca_getimagesize( $yucca_top_icon );
									?>
									<img src="<?php echo esc_url( $yucca_top_icon ); ?>" alt="<?php esc_attr_e( 'Site icon', 'yucca' ); ?>"
										<?php
										if ( ! empty( $yucca_attr[3] ) ) {
											yucca_show_layout( $yucca_attr[3] );
										}
										?>
									>
									<?php
								}
								echo wp_kses_data( $yucca_blog_title_text );
								?>
							</h1>
							<?php
							if ( ! empty( $yucca_blog_title_link ) && ! empty( $yucca_blog_title_link_text ) ) {
								?>
								<a href="<?php echo esc_url( $yucca_blog_title_link ); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html( $yucca_blog_title_link_text ); ?></a>
								<?php
							}

							// Category/Tag description
							if ( ! is_paged() && ( is_category() || is_tag() || is_tax() ) ) {
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
							}

							?>
						</div>
						<?php

						// Breadcrumbs
						ob_start();
						do_action( 'yucca_action_breadcrumbs' );
						$yucca_breadcrumbs = ob_get_contents();
						ob_end_clean();
						yucca_show_layout( $yucca_breadcrumbs, '<div class="sc_layouts_title_breadcrumbs">', '</div>' );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
