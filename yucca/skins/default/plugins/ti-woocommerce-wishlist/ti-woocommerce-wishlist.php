<?php
/* TI WooCommerce Wishlist support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('yucca_wishlist_theme_setup9')) {
	add_action( 'after_setup_theme', 'yucca_wishlist_theme_setup9', 9 );
	function yucca_wishlist_theme_setup9() {
		if (is_admin()) {
			add_filter( 'yucca_filter_tgmpa_required_plugins',		'yucca_wishlist_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'yucca_wishlist_tgmpa_required_plugins' ) ) {
	function yucca_wishlist_tgmpa_required_plugins($list=array()) {
		if (yucca_storage_isset('required_plugins', 'ti-woocommerce-wishlist') && yucca_storage_get_array( 'required_plugins', 'ti-woocommerce-wishlist', 'install' ) !== false) {
			$list[] = array(
				'name' 		=> yucca_storage_get_array('required_plugins', 'ti-woocommerce-wishlist', 'title'),
				'slug' 		=> 'ti-woocommerce-wishlist',
				'required' 	=> false
			);
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'yucca_exists_wishlist' ) ) {
	function yucca_exists_wishlist() {
		return function_exists('activation_tinv_wishlist');
	}
}


// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'yucca_wishlist_importer_required_plugins' ) ) {
    if (is_admin()) add_filter( 'trx_addons_filter_importer_required_plugins',	'yucca_wishlist_importer_required_plugins', 10, 2 );
    function yucca_wishlist_importer_required_plugins($not_installed='', $list='') {
        if (strpos($list, 'ti-woocommerce-wishlist')!==false && !yucca_exists_wishlist() )
            $not_installed .= '<br>' . esc_html__('WooCommerce Wishlist', 'yucca');
        return $not_installed;
    }
}

// Set plugin's specific importer options
if ( !function_exists( 'yucca_wishlist_importer_set_options' ) ) {
    if (is_admin()) add_filter( 'trx_addons_filter_importer_options',	'yucca_wishlist_importer_set_options' );
    function yucca_wishlist_importer_set_options($options=array()) {
        if ( yucca_exists_wishlist() && in_array('ti-woocommerce-wishlist', $options['required_plugins']) ) {
            $options['additional_options'][] = 'tinvwl-%';
        }
        return $options;
    }
}


?>