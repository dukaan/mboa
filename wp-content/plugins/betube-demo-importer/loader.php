<?php

// Replace {$redux_opt_name} with your opt_name.
// Also be sure to change this function name!

if(!function_exists('betube_register_custom_extension_loader')) :
    function betube_register_custom_extension_loader($ReduxFramework) {
        $path    = dirname( __FILE__ ) . '/extensions/';
            $folders = scandir( $path, 1 );
            foreach ( $folders as $folder ) {
                if ( $folder === '.' or $folder === '..' or ! is_dir( $path . $folder ) ) {
                    continue;
                }
                $extension_class = 'ReduxFramework_Extension_' . $folder;
                if ( ! class_exists( $extension_class ) ) {
                    // In case you wanted override your override, hah.
                    $class_file = $path . $folder . '/extension_' . $folder . '.php';
                    $class_file = apply_filters( 'redux/extension/' . $ReduxFramework->args['opt_name'] . '/' . $folder, $class_file );
                    if ( $class_file ) {
                        require_once( $class_file );
                    }
                }
                if ( ! isset( $ReduxFramework->extensions[ $folder ] ) ) {
                    $ReduxFramework->extensions[ $folder ] = new $extension_class( $ReduxFramework );
                }
            }
    }
    // Modify {$redux_opt_name} to match your opt_name
    add_action("redux/extensions/redux_demo/before", 'betube_register_custom_extension_loader', 0);
endif;
//Demo Setup//
if ( !function_exists( 'betube_demo_setup_content' ) ) {
	function betube_demo_setup_content( $demo_active_import , $demo_directory_path ) {

		reset( $demo_active_import );
		$current_key = key( $demo_active_import );
		
		$wbc_menu_array = array( 'light', 'arabic', 'dark', 'magazine');

		if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && in_array( $demo_active_import[$current_key]['directory'], $wbc_menu_array ) ) {
			$primary = get_term_by( 'name', 'Top Menu', 'nav_menu' );
			$topbar = get_term_by( 'name', 'Top bar', 'nav_menu' );
			
			set_theme_mod( 'nav_menu_locations', array(
					'main-nav' => $primary->term_id,
					'mobile-nav'  => $primary->term_id,
					'header' => $topbar->term_id,
				)
			);
		}

		$wbc_home_pages = array(
			'light' => 'Home Page V1',
			'arabic' => 'Home Page V1',
			'dark' => 'Home Page V1',
			'magazine' => 'Home',			
		);

		if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_home_pages ) ) {
			$page = get_page_by_title( $wbc_home_pages[$demo_active_import[$current_key]['directory']] );
			if ( isset( $page->ID ) ) {
				update_option( 'page_on_front', $page->ID );
				update_option( 'show_on_front', 'page' );
			}
		}

	}
	add_action( 'wbc_importer_after_content_import', 'betube_demo_setup_content', 10, 2 );
}