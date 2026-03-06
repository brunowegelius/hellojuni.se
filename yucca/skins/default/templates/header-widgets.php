<?php
/**
 * The template to display the widgets area in the header
 *
 * @package YUCCA
 * @since YUCCA 1.0
 */

// Header sidebar
$yucca_header_name    = yucca_get_theme_option( 'header_widgets' );
$yucca_header_present = ! yucca_is_off( $yucca_header_name ) && is_active_sidebar( $yucca_header_name );
if ( $yucca_header_present ) {
	yucca_storage_set( 'current_sidebar', 'header' );
	$yucca_header_wide = yucca_get_theme_option( 'header_wide' );
	ob_start();
	if ( is_active_sidebar( $yucca_header_name ) ) {
		dynamic_sidebar( $yucca_header_name );
	}
	$yucca_widgets_output = ob_get_contents();
	ob_end_clean();
	if ( ! empty( $yucca_widgets_output ) ) {
		$yucca_widgets_output = preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $yucca_widgets_output );
		$yucca_need_columns   = strpos( $yucca_widgets_output, 'columns_wrap' ) === false;
		if ( $yucca_need_columns ) {
			$yucca_columns = max( 0, (int) yucca_get_theme_option( 'header_columns' ) );
			if ( 0 == $yucca_columns ) {
				$yucca_columns = min( 6, max( 1, yucca_tags_count( $yucca_widgets_output, 'aside' ) ) );
			}
			if ( $yucca_columns > 1 ) {
				$yucca_widgets_output = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $yucca_columns ) . ' widget', $yucca_widgets_output );
			} else {
				$yucca_need_columns = false;
			}
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo ! empty( $yucca_header_wide ) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<?php do_action( 'yucca_action_before_sidebar_wrap', 'header' ); ?>
			<div class="header_widgets_inner widget_area_inner">
				<?php
				if ( ! $yucca_header_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $yucca_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'yucca_action_before_sidebar', 'header' );
				yucca_show_layout( $yucca_widgets_output );
				do_action( 'yucca_action_after_sidebar', 'header' );
				if ( $yucca_need_columns ) {
					?>
					</div>	<!-- /.columns_wrap -->
					<?php
				}
				if ( ! $yucca_header_wide ) {
					?>
					</div>	<!-- /.content_wrap -->
					<?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
			<?php do_action( 'yucca_action_after_sidebar_wrap', 'header' ); ?>
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
