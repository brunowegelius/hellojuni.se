<div class="front_page_section front_page_section_googlemap<?php
	$yucca_scheme = yucca_get_theme_option( 'front_page_googlemap_scheme' );
	if ( ! empty( $yucca_scheme ) && ! yucca_is_inherit( $yucca_scheme ) ) {
		echo ' scheme_' . esc_attr( $yucca_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( yucca_get_theme_option( 'front_page_googlemap_paddings' ) );
	if ( yucca_get_theme_option( 'front_page_googlemap_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$yucca_css      = '';
		$yucca_bg_image = yucca_get_theme_option( 'front_page_googlemap_bg_image' );
		if ( ! empty( $yucca_bg_image ) ) {
			$yucca_css .= 'background-image: url(' . esc_url( yucca_get_attachment_url( $yucca_bg_image ) ) . ');';
		}
		if ( ! empty( $yucca_css ) ) {
			echo ' style="' . esc_attr( $yucca_css ) . '"';
		}
		?>
>
<?php
	// Add anchor
	$yucca_anchor_icon = yucca_get_theme_option( 'front_page_googlemap_anchor_icon' );
	$yucca_anchor_text = yucca_get_theme_option( 'front_page_googlemap_anchor_text' );
if ( ( ! empty( $yucca_anchor_icon ) || ! empty( $yucca_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_googlemap"'
									. ( ! empty( $yucca_anchor_icon ) ? ' icon="' . esc_attr( $yucca_anchor_icon ) . '"' : '' )
									. ( ! empty( $yucca_anchor_text ) ? ' title="' . esc_attr( $yucca_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_googlemap_inner
		<?php
		$yucca_layout = yucca_get_theme_option( 'front_page_googlemap_layout' );
		echo ' front_page_section_layout_' . esc_attr( $yucca_layout );
		if ( yucca_get_theme_option( 'front_page_googlemap_fullheight' ) ) {
			echo ' yucca-full-height sc_layouts_flex sc_layouts_columns_middle';
		}
		?>
		"
			<?php
			$yucca_css      = '';
			$yucca_bg_mask  = yucca_get_theme_option( 'front_page_googlemap_bg_mask' );
			$yucca_bg_color_type = yucca_get_theme_option( 'front_page_googlemap_bg_color_type' );
			if ( 'custom' == $yucca_bg_color_type ) {
				$yucca_bg_color = yucca_get_theme_option( 'front_page_googlemap_bg_color' );
			} elseif ( 'scheme_bg_color' == $yucca_bg_color_type ) {
				$yucca_bg_color = yucca_get_scheme_color( 'bg_color', $yucca_scheme );
			} else {
				$yucca_bg_color = '';
			}
			if ( ! empty( $yucca_bg_color ) && $yucca_bg_mask > 0 ) {
				$yucca_css .= 'background-color: ' . esc_attr(
					1 == $yucca_bg_mask ? $yucca_bg_color : yucca_hex2rgba( $yucca_bg_color, $yucca_bg_mask )
				) . ';';
			}
			if ( ! empty( $yucca_css ) ) {
				echo ' style="' . esc_attr( $yucca_css ) . '"';
			}
			?>
	>
		<div class="front_page_section_content_wrap front_page_section_googlemap_content_wrap
		<?php
		if ( 'fullwidth' != $yucca_layout ) {
			echo ' content_wrap';
		}
		?>
		">
			<?php
			// Content wrap with title and description
			$yucca_caption     = yucca_get_theme_option( 'front_page_googlemap_caption' );
			$yucca_description = yucca_get_theme_option( 'front_page_googlemap_description' );
			if ( ! empty( $yucca_caption ) || ! empty( $yucca_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				if ( 'fullwidth' == $yucca_layout ) {
					?>
					<div class="content_wrap">
					<?php
				}
					// Caption
				if ( ! empty( $yucca_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<h2 class="front_page_section_caption front_page_section_googlemap_caption front_page_block_<?php echo ! empty( $yucca_caption ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( $yucca_caption, 'yucca_kses_content' );
					?>
					</h2>
					<?php
				}

					// Description (text)
				if ( ! empty( $yucca_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<div class="front_page_section_description front_page_section_googlemap_description front_page_block_<?php echo ! empty( $yucca_description ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( wpautop( $yucca_description ), 'yucca_kses_content' );
					?>
					</div>
					<?php
				}
				if ( 'fullwidth' == $yucca_layout ) {
					?>
					</div>
					<?php
				}
			}

			// Content (text)
			$yucca_content = yucca_get_theme_option( 'front_page_googlemap_content' );
			if ( ! empty( $yucca_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				if ( 'columns' == $yucca_layout ) {
					?>
					<div class="front_page_section_columns front_page_section_googlemap_columns columns_wrap">
						<div class="column-1_3">
					<?php
				} elseif ( 'fullwidth' == $yucca_layout ) {
					?>
					<div class="content_wrap">
					<?php
				}

				?>
				<div class="front_page_section_content front_page_section_googlemap_content front_page_block_<?php echo ! empty( $yucca_content ) ? 'filled' : 'empty'; ?>">
				<?php
					echo wp_kses( $yucca_content, 'yucca_kses_content' );
				?>
				</div>
				<?php

				if ( 'columns' == $yucca_layout ) {
					?>
					</div><div class="column-2_3">
					<?php
				} elseif ( 'fullwidth' == $yucca_layout ) {
					?>
					</div>
					<?php
				}
			}

			// Widgets output
			?>
			<div class="front_page_section_output front_page_section_googlemap_output">
				<?php
				if ( is_active_sidebar( 'front_page_googlemap_widgets' ) ) {
					dynamic_sidebar( 'front_page_googlemap_widgets' );
				} elseif ( current_user_can( 'edit_theme_options' ) ) {
					if ( ! yucca_exists_trx_addons() ) {
						yucca_customizer_need_trx_addons_message();
					} else {
						yucca_customizer_need_widgets_message( 'front_page_googlemap_caption', 'ThemeREX Addons - Google map' );
					}
				}
				?>
			</div>
			<?php

			if ( 'columns' == $yucca_layout && ( ! empty( $yucca_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div></div>
				<?php
			}
			?>
		</div>
	</div>
</div>
