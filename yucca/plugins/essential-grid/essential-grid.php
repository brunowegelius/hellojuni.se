<?php
/* Essential Grid support functions
------------------------------------------------------------------------------- */


// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'yucca_essential_grid_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'yucca_essential_grid_theme_setup9', 9 );
	function yucca_essential_grid_theme_setup9() {
		if ( yucca_exists_essential_grid() ) {
			add_action( 'wp_enqueue_scripts', 'yucca_essential_grid_frontend_scripts', 1100 );
			add_action( 'trx_addons_action_load_scripts_front_essential_grid', 'yucca_essential_grid_frontend_scripts', 10, 1 );
			add_filter( 'yucca_filter_merge_styles', 'yucca_essential_grid_merge_styles' );
		}
		if ( is_admin() ) {
			add_filter( 'yucca_filter_tgmpa_required_plugins', 'yucca_essential_grid_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'yucca_essential_grid_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('yucca_filter_tgmpa_required_plugins',	'yucca_essential_grid_tgmpa_required_plugins');
	function yucca_essential_grid_tgmpa_required_plugins( $list = array() ) {
		if ( yucca_storage_isset( 'required_plugins', 'essential-grid' ) && yucca_storage_get_array( 'required_plugins', 'essential-grid', 'install' ) !== false && yucca_is_theme_activated() ) {
			$path = yucca_get_plugin_source_path( 'plugins/essential-grid/essential-grid.zip' );
			if ( ! empty( $path ) || yucca_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => yucca_storage_get_array( 'required_plugins', 'essential-grid', 'title' ),
					'slug'     => 'essential-grid',
					'source'   => ! empty( $path ) ? $path : 'upload://essential-grid.zip',
					'version'  => '2.2.4.2',
					'required' => false,
				);
			}
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( ! function_exists( 'yucca_exists_essential_grid' ) ) {
	function yucca_exists_essential_grid() {
		return defined( 'EG_PLUGIN_PATH' ) || defined( 'ESG_PLUGIN_PATH' );
	}
}

// Enqueue styles for frontend
if ( ! function_exists( 'yucca_essential_grid_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'yucca_essential_grid_frontend_scripts', 1100 );
	//Handler of the add_action( 'trx_addons_action_load_scripts_front_essential_grid', 'yucca_essential_grid_frontend_scripts', 10, 1 );
	function yucca_essential_grid_frontend_scripts( $force = false ) {
		yucca_enqueue_optimized( 'essential_grid', $force, array(
			'css' => array(
				'yucca-essential-grid' => array( 'src' => 'plugins/essential-grid/essential-grid.css' ),
			)
		) );
	}
}

// Merge custom styles
if ( ! function_exists( 'yucca_essential_grid_merge_styles' ) ) {
	//Handler of the add_filter('yucca_filter_merge_styles', 'yucca_essential_grid_merge_styles');
	function yucca_essential_grid_merge_styles( $list ) {
		$list[ 'plugins/essential-grid/essential-grid.css' ] = false;
		return $list;
	}
}
