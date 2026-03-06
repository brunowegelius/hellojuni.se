<?php
/**
 * The template to display the user's avatar, bio and socials on the Author page
 *
 * @package YUCCA
 * @since YUCCA 1.71.0
 */
?>

<div class="author_page author vcard"<?php
	if ( yucca_is_on( yucca_get_theme_option( 'seo_snippets' ) ) ) {
		?> itemprop="author" itemscope="itemscope" itemtype="<?php echo esc_attr( yucca_get_protocol( true ) ); ?>//schema.org/Person"<?php
	}
?>>

	<div class="author_avatar"<?php
		if ( yucca_is_on( yucca_get_theme_option( 'seo_snippets' ) ) ) {
			?> itemprop="image"<?php
		}
	?>>
		<?php
		$yucca_mult = yucca_get_retina_multiplier();
		echo get_avatar( get_the_author_meta( 'user_email' ), 120 * $yucca_mult );
		?>
	</div>

	<h4 class="author_title"<?php
		if ( yucca_is_on( yucca_get_theme_option( 'seo_snippets' ) ) ) {
			?> itemprop="name"<?php
		}
	?>><span class="fn"><?php the_author(); ?></span></h4>

	<?php
	$yucca_author_description = get_the_author_meta( 'description' );
	if ( ! empty( $yucca_author_description ) ) {
		?>
		<div class="author_bio"<?php
			if ( yucca_is_on( yucca_get_theme_option( 'seo_snippets' ) ) ) {
				?> itemprop="description"<?php
			}
		?>><?php echo wp_kses( wpautop( $yucca_author_description ), 'yucca_kses_content' ); ?></div>
		<?php
	}
	?>

	<div class="author_details">
		<span class="author_posts_total">
			<?php
			$yucca_posts_total = count_user_posts( get_the_author_meta('ID'), 'post' );
			if ( $yucca_posts_total > 0 ) {
				// Translators: Add the author's posts number to the message
				echo wp_kses( sprintf( _n( '%s article published', '%s articles published', $yucca_posts_total, 'yucca' ),
										'<span class="author_posts_total_value">' . number_format_i18n( $yucca_posts_total ) . '</span>'
								 		),
							'yucca_kses_content'
							);
			} else {
				esc_html_e( 'No posts published.', 'yucca' );
			}
			?>
		</span><?php
			ob_start();
			do_action( 'yucca_action_user_meta', 'author-page' );
			$yucca_socials = ob_get_contents();
			ob_end_clean();
			yucca_show_layout( $yucca_socials,
				'<span class="author_socials"><span class="author_socials_caption">' . esc_html__( 'Follow:', 'yucca' ) . '</span>',
				'</span>'
			);
		?>
	</div>

</div>
