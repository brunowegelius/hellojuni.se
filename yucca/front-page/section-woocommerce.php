<?php
$yucca_woocommerce_sc = yucca_get_theme_option( 'front_page_woocommerce_products' );
if ( ! empty( $yucca_woocommerce_sc ) ) {
	?><div class="front_page_section front_page_section_woocommerce<?php
		$yucca_scheme = yucca_get_theme_option( 'front_page_woocommerce_scheme' );
		if ( ! empty( $yucca_scheme ) && ! yucca_is_inherit( $yucca_scheme ) ) {
			echo ' scheme_' . esc_attr( $yucca_scheme );
		}
		echo ' front_page_section_paddings_' . esc_attr( yucca_get_theme_option( 'front_page_woocommerce_paddings' ) );
		if ( yucca_get_theme_option( 'front_page_woocommerce_stack' ) ) {
			echo ' sc_stack_section_on';
		}
	?>"
			<?php
			$yucca_css      = '';
			$yucca_bg_image = yucca_get_theme_option( 'front_page_woocommerce_bg_image' );
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
		$yucca_anchor_icon = yucca_get_theme_option( 'front_page_woocommerce_anchor_icon' );
		$yucca_anchor_text = yucca_get_theme_option( 'front_page_woocommerce_anchor_text' );
		if ( ( ! empty( $yucca_anchor_icon ) || ! empty( $yucca_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
			echo do_shortcode(
				'[trx_sc_anchor id="front_page_section_woocommerce"'
											. ( ! empty( $yucca_anchor_icon ) ? ' icon="' . esc_attr( $yucca_anchor_icon ) . '"' : '' )
											. ( ! empty( $yucca_anchor_text ) ? ' title="' . esc_attr( $yucca_anchor_text ) . '"' : '' )
											. ']'
			);
		}
	?>
		<div class="front_page_section_inner front_page_section_woocommerce_inner
			<?php
			if ( yucca_get_theme_option( 'front_page_woocommerce_fullheight' ) ) {
				echo ' yucca-full-height sc_layouts_flex sc_layouts_columns_middle';
			}
			?>
				"
				<?php
				$yucca_css      = '';
				$yucca_bg_mask  = yucca_get_theme_option( 'front_page_woocommerce_bg_mask' );
				$yucca_bg_color_type = yucca_get_theme_option( 'front_page_woocommerce_bg_color_type' );
				if ( 'custom' == $yucca_bg_color_type ) {
					$yucca_bg_color = yucca_get_theme_option( 'front_page_woocommerce_bg_color' );
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
			<div class="front_page_section_content_wrap front_page_section_woocommerce_content_wrap content_wrap woocommerce">
				<?php
				// Content wrap with title and description
				$yucca_caption     = yucca_get_theme_option( 'front_page_woocommerce_caption' );
				$yucca_description = yucca_get_theme_option( 'front_page_woocommerce_description' );
				if ( ! empty( $yucca_caption ) || ! empty( $yucca_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					// Caption
					if ( ! empty( $yucca_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
						?>
						<h2 class="front_page_section_caption front_page_section_woocommerce_caption front_page_block_<?php echo ! empty( $yucca_caption ) ? 'filled' : 'empty'; ?>">
						<?php
							echo wp_kses( $yucca_caption, 'yucca_kses_content' );
						?>
						</h2>
						<?php
					}

					// Description (text)
					if ( ! empty( $yucca_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
						?>
						<div class="front_page_section_description front_page_section_woocommerce_description front_page_block_<?php echo ! empty( $yucca_description ) ? 'filled' : 'empty'; ?>">
						<?php
							echo wp_kses( wpautop( $yucca_description ), 'yucca_kses_content' );
						?>
						</div>
						<?php
					}
				}

				// Content (widgets)
				?>
				<div class="front_page_section_output front_page_section_woocommerce_output list_products shop_mode_thumbs">
					<?php
					if ( 'products' == $yucca_woocommerce_sc ) {
						$yucca_woocommerce_sc_ids      = yucca_get_theme_option( 'front_page_woocommerce_products_per_page' );
						$yucca_woocommerce_sc_per_page = count( explode( ',', $yucca_woocommerce_sc_ids ) );
					} else {
						$yucca_woocommerce_sc_per_page = max( 1, (int) yucca_get_theme_option( 'front_page_woocommerce_products_per_page' ) );
					}
					$yucca_woocommerce_sc_columns = max( 1, min( $yucca_woocommerce_sc_per_page, (int) yucca_get_theme_option( 'front_page_woocommerce_products_columns' ) ) );
					echo do_shortcode(
						"[{$yucca_woocommerce_sc}"
										. ( 'products' == $yucca_woocommerce_sc
												? ' ids="' . esc_attr( $yucca_woocommerce_sc_ids ) . '"'
												: '' )
										. ( 'product_category' == $yucca_woocommerce_sc
												? ' category="' . esc_attr( yucca_get_theme_option( 'front_page_woocommerce_products_categories' ) ) . '"'
												: '' )
										. ( 'best_selling_products' != $yucca_woocommerce_sc
												? ' orderby="' . esc_attr( yucca_get_theme_option( 'front_page_woocommerce_products_orderby' ) ) . '"'
													. ' order="' . esc_attr( yucca_get_theme_option( 'front_page_woocommerce_products_order' ) ) . '"'
												: '' )
										. ' per_page="' . esc_attr( $yucca_woocommerce_sc_per_page ) . '"'
										. ' columns="' . esc_attr( $yucca_woocommerce_sc_columns ) . '"'
						. ']'
					);
					?>
				</div>
			</div>
		</div>
	</div>
	<?php
}
