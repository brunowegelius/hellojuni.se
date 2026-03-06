<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package YUCCA
 * @since YUCCA 1.0
 */

							do_action( 'yucca_action_page_content_end_text' );
							
							// Widgets area below the content
							yucca_create_widgets_area( 'widgets_below_content' );
						
							do_action( 'yucca_action_page_content_end' );
							?>
						</div>
						<?php
						
						do_action( 'yucca_action_after_page_content' );

						// Show main sidebar
						get_sidebar();

						do_action( 'yucca_action_content_wrap_end' );
						?>
					</div>
					<?php

					do_action( 'yucca_action_after_content_wrap' );

					// Widgets area below the page and related posts below the page
					$yucca_body_style = yucca_get_theme_option( 'body_style' );
					$yucca_widgets_name = yucca_get_theme_option( 'widgets_below_page', 'hide' );
					$yucca_show_widgets = ! yucca_is_off( $yucca_widgets_name ) && is_active_sidebar( $yucca_widgets_name );
					$yucca_show_related = yucca_is_single() && yucca_get_theme_option( 'related_position', 'below_content' ) == 'below_page';
					if ( $yucca_show_widgets || $yucca_show_related ) {
						if ( 'fullscreen' != $yucca_body_style ) {
							?>
							<div class="content_wrap">
							<?php
						}
						// Show related posts before footer
						if ( $yucca_show_related ) {
							do_action( 'yucca_action_related_posts' );
						}

						// Widgets area below page content
						if ( $yucca_show_widgets ) {
							yucca_create_widgets_area( 'widgets_below_page' );
						}
						if ( 'fullscreen' != $yucca_body_style ) {
							?>
							</div>
							<?php
						}
					}
					do_action( 'yucca_action_page_content_wrap_end' );
					?>
			</div>
			<?php
			do_action( 'yucca_action_after_page_content_wrap' );

			// Don't display the footer elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ( ! yucca_is_singular( 'post' ) && ! yucca_is_singular( 'attachment' ) ) || ! in_array ( yucca_get_value_gp( 'action' ), array( 'full_post_loading', 'prev_post_loading' ) ) ) {
				
				// Skip link anchor to fast access to the footer from keyboard
				?>
				<span id="footer_skip_link_anchor" class="yucca_skip_link_anchor"></span>
				<?php

				do_action( 'yucca_action_before_footer' );

				// Footer
				$yucca_footer_type = yucca_get_theme_option( 'footer_type' );
				if ( 'custom' == $yucca_footer_type && ! yucca_is_layouts_available() ) {
					$yucca_footer_type = 'default';
				}
				get_template_part( apply_filters( 'yucca_filter_get_template_part', "templates/footer-" . sanitize_file_name( $yucca_footer_type ) ) );

				do_action( 'yucca_action_after_footer' );

			}
			?>

			<?php do_action( 'yucca_action_page_wrap_end' ); ?>

		</div>

		<?php do_action( 'yucca_action_after_page_wrap' ); ?>

	</div>

	<?php do_action( 'yucca_action_after_body' ); ?>

	<?php wp_footer(); ?>

</body>
</html>