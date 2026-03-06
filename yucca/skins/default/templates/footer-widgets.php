<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package YUCCA
 * @since YUCCA 1.0.10
 */

// Footer sidebar
$yucca_footer_name    = yucca_get_theme_option( 'footer_widgets' );
$yucca_footer_present = ! yucca_is_off( $yucca_footer_name ) && is_active_sidebar( $yucca_footer_name );
if ( $yucca_footer_present ) {
	yucca_storage_set( 'current_sidebar', 'footer' );
	$yucca_footer_wide = yucca_get_theme_option( 'footer_wide' );
	ob_start();
	if ( is_active_sidebar( $yucca_footer_name ) ) {
		dynamic_sidebar( $yucca_footer_name );
	}
	$yucca_out = trim( ob_get_contents() );
	ob_end_clean();
	if ( ! empty( $yucca_out ) ) {
		$yucca_out          = preg_replace( "/<\\/aside>[\r\n\s]*<aside/", '</aside><aside', $yucca_out );
		$yucca_need_columns = true;   //or check: strpos($yucca_out, 'columns_wrap')===false;
		if ( $yucca_need_columns ) {
			$yucca_columns = max( 0, (int) yucca_get_theme_option( 'footer_columns' ) );			
			if ( 0 == $yucca_columns ) {
				$yucca_columns = min( 4, max( 1, yucca_tags_count( $yucca_out, 'aside' ) ) );
			}
			if ( $yucca_columns > 1 ) {
				$yucca_out = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $yucca_columns ) . ' widget', $yucca_out );
			} else {
				$yucca_need_columns = false;
			}
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo ! empty( $yucca_footer_wide ) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<?php do_action( 'yucca_action_before_sidebar_wrap', 'footer' ); ?>
			<div class="footer_widgets_inner widget_area_inner">
				<?php
				if ( ! $yucca_footer_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $yucca_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'yucca_action_before_sidebar', 'footer' );
				yucca_show_layout( $yucca_out );
				do_action( 'yucca_action_after_sidebar', 'footer' );
				if ( $yucca_need_columns ) {
					?>
					</div><!-- /.columns_wrap -->
					<?php
				}
				if ( ! $yucca_footer_wide ) {
					?>
					</div><!-- /.content_wrap -->
					<?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
			<?php do_action( 'yucca_action_after_sidebar_wrap', 'footer' ); ?>
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
