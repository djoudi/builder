<?php 
class PL_Router {

	private static function router($template, $params, $wrap = false, $directory = PL_VIEWS_ADMIN_DIR) {
		ob_start();
		self::load_builder_view('header.php');
		self::load_builder_view($template, $directory, $params);
		self::load_builder_view('footer.php');
		echo ob_get_clean();

	}

	public static function load_builder_partial($template, $params = array(), $return = false) {
		ob_start();
		if (!empty($params)) {
			extract($params);
		}
		include(trailingslashit(PL_VIEWS_PART_DIR) . $template);
		if ($return) {
			return ob_get_clean();
		} else {
			echo ob_get_clean();
		}
	}

	public static function load_builder_library ($template, $directory = PL_JS_LIB_DIR) {
		include_once(trailingslashit($directory) . $template);
	}

	public static function load_builder_helper ($template, $directory = PL_HLP_DIR) {
		include_once(trailingslashit($directory) . $template);
	}

	private static function load_builder_view($template, $directory = PL_VIEWS_ADMIN_DIR, $params = array()) {
		ob_start();
		if (!empty($params)) {
			extract($params);
		}
		include_once(trailingslashit($directory) . $template);
		echo ob_get_clean();
	}

	public static function pl_extensions() {
		return '';
	}

	/**
	 * List post type view paths (post types are hidden not to overlap admin dashboard)
	 *
	 * @param string $post_type the post type in use
	 * @param enum $page_type list or add
	 */
	public static function post_type_path($post_type, $page_type = 'list') {
		if( $page_type == 'list' ) {
			return 'edit.php?post_type=' . $post_type;
		}
		else if( $page_type == 'add' ) {
			return 'post-new.php?post_type=' . $post_type;
		}
			
		return '';
	}

	public static function my_listings() {
		self::router('my-listings.php', array(), false);
	}

	public static function add_listings() {
		if (isset($_GET['id'])) {
			// Fetch listing and store it in the POST global...
			$_POST = PL_Listing_Helper::single_listing($_GET['id']);
		}

		self::router('add-listing.php', array(), false);
	}

	public static function theme_gallery() {
		if (isset($_GET['theme_url'])) {
			self::router('install-theme.php', array(), false);
		} else {
			self::router('theme-gallery.php', array(), false);
		}
	}

	public static function settings() {
		self::router('settings/general.php', array(), false);
	}
	
	public static function settings_polygons() {
		self::router('settings/polygons.php', array(), false);
	}
	
	public static function settings_property_pages() {
		self::router('settings/property.php', array(), false);
	}
	
	public static function settings_international() {
		self::router('settings/international.php', array(), false);
	}
	
	public static function settings_neighborhood() {
		self::router('settings/neighborhood.php', array(), false);
	}
	
	public static function settings_filtering() {
		self::router('settings/filtering.php', array(), false);
	}

	public static function settings_client() {
		self::load_builder_helper('membership.php');
		self::router('settings/client.php', PL_Membership_Helper::get_client_settings(), false);
	}

	public static function lead_capture() {
		self::router('lead-capture/general.php', array(), false);
	}

	public static function support() {
		self::router('support.php', array(), false);
	}

	public static function integrations() {
		self::router('integrations.php', array(), false);
	}

	public static function shortcodes() {
		self::router('shortcodes/shortcodes.php', array(), false);
	}
	
	public static function shortcodes_shortcode_edit() {
		if (isset($_REQUEST['trashed'])) {
			wp_redirect(admin_url('admin.php?page=placester_shortcodes'));
			exit;
		}
		self::router('shortcodes/shortcode-edit.php', array(), false);
	}
	
	public static function shortcodes_templates() {
		self::router('shortcodes/templates.php', array(), false);
	}
	
	public static function shortcodes_template_edit() {
		self::router('shortcodes/template-edit.php', array(), false);
	}
	
	public static function shortcodes_property_details() {
		self::router('shortcodes/property-details.php', array(), false);
	}
	
	public static function shortcodes_options() {
		self::router('shortcodes/options.php', array(), false);
	}

	//end of class
}