<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package YUCCA
 * @since YUCCA 1.0
 */

if ( yucca_sidebar_present() ) {
	
	$yucca_sidebar_type = yucca_get_theme_option( 'sidebar_type' );
	if ( 'custom' == $yucca_sidebar_type && ! yucca_is_layouts_available() ) {
		$yucca_sidebar_type = 'default';
	}
	
	// Catch output to the buffer
	ob_start();
	if ( 'default' == $yucca_sidebar_type ) {
		// Default sidebar with widgets
		$yucca_sidebar_name = yucca_get_theme_option( 'sidebar_widgets' );
		yucca_storage_set( 'current_sidebar', 'sidebar' );
		if ( is_active_sidebar( $yucca_sidebar_name ) ) {
			dynamic_sidebar( $yucca_sidebar_name );
		}
	} else {
		// Custom sidebar from Layouts Builder
		$yucca_sidebar_id = yucca_get_custom_sidebar_id();
		do_action( 'yucca_action_show_layout', $yucca_sidebar_id );
	}
	$yucca_out = trim( ob_get_contents() );
	ob_end_clean();
	
	// If any html is present - display it
	if ( ! empty( $yucca_out ) ) {
		$yucca_sidebar_position    = yucca_get_theme_option( 'sidebar_position' );
		$yucca_sidebar_position_ss = yucca_get_theme_option( 'sidebar_position_ss', 'below' );
		?>
		<div class="sidebar widget_area
			<?php
			echo ' ' . esc_attr( $yucca_sidebar_position );
			echo ' sidebar_' . esc_attr( $yucca_sidebar_position_ss );
			echo ' sidebar_' . esc_attr( $yucca_sidebar_type );

			$yucca_sidebar_scheme = apply_filters( 'yucca_filter_sidebar_scheme', yucca_get_theme_option( 'sidebar_scheme', 'inherit' ) );
			if ( ! empty( $yucca_sidebar_scheme ) && ! yucca_is_inherit( $yucca_sidebar_scheme ) && 'custom' != $yucca_sidebar_type ) {
				echo ' scheme_' . esc_attr( $yucca_sidebar_scheme );
			}
			?>
		" role="complementary">
			<?php

			// Skip link anchor to fast access to the sidebar from keyboard
			?>
			<span id="sidebar_skip_link_anchor" class="yucca_skip_link_anchor"></span>
			<?php

			do_action( 'yucca_action_before_sidebar_wrap', 'sidebar' );

			// Button to show/hide sidebar on mobile
			if ( in_array( $yucca_sidebar_position_ss, array( 'above', 'float' ) ) ) {
				$yucca_title = apply_filters( 'yucca_filter_sidebar_control_title', 'float' == $yucca_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'yucca' ) : '' );
				$yucca_text  = apply_filters( 'yucca_filter_sidebar_control_text', 'above' == $yucca_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'yucca' ) : '' );
				?>
				<a href="#" role="button" class="sidebar_control" title="<?php echo esc_attr( $yucca_title ); ?>"><?php echo esc_html( $yucca_text ); ?></a>
				<?php
			}
			?>
			<div class="sidebar_inner">
				<?php
				do_action( 'yucca_action_before_sidebar', 'sidebar' );
				yucca_show_layout( preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $yucca_out ) );
				do_action( 'yucca_action_after_sidebar', 'sidebar' );
				?>
			</div>
			<?php

			do_action( 'yucca_action_after_sidebar_wrap', 'sidebar' );

			?>
		</div>
		<div class="clearfix"></div>
		<?php
	}
}
