<?php

PL_Post_Type_Manager::init();

class PL_Post_Type_Manager {
	public static $post_types = array();
	
	public static function init() {
		// get post types from the directory (allows for drop-ins)
		self::$post_types = self::get_post_types();
		
		foreach( self::$post_types as $post_type ) {
			include_once $post_type . '.php';
		}
		
		add_action('admin_menu', array( __CLASS__, 'pl_register_posts_menu' ) );
	}
		
	public static function pl_register_posts_menu() {
		add_menu_page('PL Extensions','PL Extensions','edit_pages','pl_extensions', array('PL_Router','pl_extensions'), plugins_url('/placester/images/logo_16.png'), '3c' /* position between 3 and 4 */ );
		
		foreach( self::$post_types as $post_type ) {
			$post_type_title = self::get_post_type_title_helper( $post_type );
			add_submenu_page( 'pl_extensions', $post_type_title, $post_type_title, 'edit_pages', PL_Router::post_type_path( $post_type, 'list' ) );
		}
		
	}
	
	public static function get_post_types($folder = PL_LIB_DIR) {
		$post_types = array();
		
		if( $folder === PL_LIB_DIR ) {
			$folder = trailingslashit( PL_LIB_DIR ) . 'post_types';
		}
		
		// ignore file paths we don't use and the manager
		$ignore = array( '.', '..', 'pl_post_type_manager.php' );
		
		if ($handle = opendir( $folder ) ) {
			while (false !== ($entry = readdir($handle))) {
				// get post type names before .php beyond the ignore list
				if( ! (in_array( $entry, $ignore ) ) ) {
					$post_types[] = current( explode( ".php", $entry ) );
				}
			}

			closedir($handle);
		}
		
		return $post_types;
	}
	
	// Helper for wrapping the name based on post_type filename
	private static function get_post_type_title_helper( $post_type ) {
		$title = '';
		$type_parts = explode( '_', $post_type );
		foreach( $type_parts as $part ) {
			$title .= ucfirst( $part ) . ' ';
 		} 
		
		return trim( $title );
	}
}

