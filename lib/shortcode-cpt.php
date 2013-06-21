<?php
/**
 * The customized shortcodes are stored as a custom post type of pl_general_widget.
 * Each references a shortcode template/layout that controls how its drawn.
 * The templates come from a file in the (Placester aware) theme or are user defined.
 */

class PL_Shortcode_CPT {

	// holds the shortcodes we have installed
	protected static $shortcodes = array();
	// holds the shortcode classes we have installed
	protected static $shortcode_config = array();

	protected $preview_tpl;


	public static function register_shortcode($shortcode, $instance) {
		self::$shortcodes[$shortcode] = $instance;
	}

	public function __construct() {

		// get list of shortcodes that can be widgetized:
		$path = trailingslashit( PL_LIB_DIR ) . 'shortcodes/';
		$ignore = array('sc_base.php', 'pl_neighborhood.php');
		include_once($path . 'sc_base.php');
		if ($handle = opendir($path)) {
			while (false !== ($file = readdir($handle))) {
				if (pathinfo($file, PATHINFO_EXTENSION) == 'php' && !(in_array($file, $ignore))) {
					include($path . $file);
				}
			}
			closedir($handle);
		}

		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'wp_ajax_pl_sc_preview', array( $this, 'shortcode_preview') );
		add_action( 'wp_ajax_pl_sc_template_preview', array( $this, 'template_preview') );
	}

	/**
	 * Register the CPT used to create customized shortcodes
	 */
	public function register_post_type() {

		// custom post type to hold a customized shortcode
		$args = array(
			'labels' => array(
				'name' => __( 'Placester Widget', 'pls' ),
				'singular_name' => __( 'pl_map', 'pls' ),
				'add_new_item' => __('Add New Placester Widget', 'pls'),
				'edit_item' => __('Edit Placester Widget', 'pls'),
				'new_item' => __('New Placester Widget', 'pls'),
				'all_items' => __('All Placester Widgets', 'pls'),
				'view_item' => __('View Placester Widgets', 'pls'),
				'search_items' => __('Search Placester Widgets', 'pls'),
				'not_found' =>  __('No widgets found', 'pls'),
				'not_found_in_trash' => __('No widgets found in Trash', 'pls')),
			'menu_icon' => trailingslashit(PL_IMG_URL) . 'logo_16.png',
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => false,
			'query_var' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array('title'),
		);

		register_post_type('pl_general_widget', $args );
	}


	/**
	 * Return a list of available shortcodes
	 * @return array	: array of shortcode types
	 */
	public static function get_shortcode_list() {
		return self::$shortcodes;
	}

	/**
	 * Return an array of shortcodes with their respective arguments that can be used to
	 * construct admin pages for creating a custom instance of a shortcode
	 * @return array	: array of shortcode type arrays
	 */
	public static function get_shortcodes() {
		if (empty(self::$shortcode_config)) {
			foreach(self::$shortcodes as $shortcode => $instance){
				self::$shortcode_config[$shortcode] = $instance->get_args();
			}
		}
		return self::$shortcode_config;
	}


	/***************************************************
	 * Admin pages
	 ***************************************************/


	/**
	 * Helper function to generate a shortcode string from a set of arguments
	 */
	public function generate_shortcode_str($shortcode, $args) {
		if (empty($shortcode) || empty(self::$shortcodes[$shortcode])) {
			return '';
		}
		return self::$shortcodes[$shortcode]->generate_shortcode_str($args);
	}

	/**
	 * We have to save settings as a template in order for ajax driven forms such as search listings
	 * to work. We always use the same name '_preview' for the tmplate name.
	 */
	public function shortcode_preview() {

		$shortcode = (!empty($_GET['shortcode']) ? stripslashes($_GET['shortcode']) : '');
		$shortcode_args = $this->get_shortcodes();
		if (!$shortcode || empty($shortcode_args[$shortcode]) || empty($_GET[$shortcode])) {
			die;
		}
		// set the defaults
		$args = array_merge($_GET[$shortcode], $_GET);
		$sc_str = $this->generate_shortcode_str($shortcode, $args);

		include(PL_VIEWS_ADMIN_DIR . 'shortcodes/preview.php');
		die;
	}

	/**
	 * We have to save settings as a template in order for ajax driven forms such as search listings
	 * to work. We always use the same name '_preview' for the tmplate name.
	 */
	public function template_preview() {

		$shortcode = (!empty($_GET['shortcode']) ? stripslashes($_GET['shortcode']) : '');
		$shortcode_args = $this->get_shortcodes();
		if (!$shortcode || empty($shortcode_args[$shortcode]) || empty($_GET[$shortcode])) {
			die;
		}
		// set the defaults
		$template_id = 'pls_'.$shortcode.'___preview';
		$args = wp_parse_args($_GET, array('context'=>$template_id, 'width'=>'250', 'height'=>'250'));
		$sc_str = $this->generate_shortcode_str($shortcode, $args);
		$args = wp_parse_args($_GET[$shortcode], array('shortcode'=>$shortcode, 'title'=>'_preview'));
		$this->save_shortcode_template($template_id, $args);

		include(PL_VIEWS_ADMIN_DIR . 'shortcodes/preview.php');
		die;
	}



	/***************************************************
	 * Custom Shortcode helpers
	 ***************************************************/

	/**
	 * Checks if the given template is being used and returns the number of custom shortcodes using it
	 * @param string $id
	 * @return int
	 */
	public static function template_in_use($id) {
		global $wpdb;

		return $wpdb->get_var($wpdb->prepare("
			SELECT COUNT(*)
			FROM $wpdb->posts, $wpdb->postmeta
			WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id
			AND $wpdb->postmeta.meta_key = 'context'
			AND $wpdb->postmeta.meta_value = '%s'
			AND $wpdb->posts.post_type = 'pl_general_widget'", $id));
	}


	/***************************************************
	 * Shortcode Template storage functions
	 ***************************************************/

	/**
	 * Save a shortcode template
	 * We save it in the options table using the name:
	 * pls_<shortcode_type>__<unique identifier>
	 * and also track it in a list stored in the option table using the shortcode:
	 * pls_<shortcode_type>_list
	 * @param string $id		: template id
	 * @param string $shortcode	: shortcode name
	 * @param string $title		: user name for the shortcode template
	 * @param array $data		:
	 * @return string			: unique id used to reference the template
	 */
	public static function save_shortcode_template($id, $atts) {
		$atts = (array)$atts;
		// sanity check
		$shortcode = empty($atts['shortcode'])?'':$atts['shortcode'];
		if (!$shortcode || empty(self::$shortcodes[$shortcode]) || empty($atts['title'])) {
			return '';
		}
		// if we change the shortcode of an existing record create a new one with new shortcode
		if (empty($id) || strpos($id, 'pls_'.$shortcode.'__')!==0) {
			$id = ('pls_' . $shortcode . '__' . time() . rand(10,99));
		}
		$sc_args = self::get_shortcodes();
		$data = $sc_args[$shortcode]['template'] + array('shortcode'=>'', 'title'=>'');
		foreach($data as $key => &$val) {
			if (isset($atts[$key])) {
				$val = stripslashes($atts[$key]);
			}
		}
		update_option($id, $data);

		// Add to the list of custom snippet IDs for this shortcode...
		$tpl_list_DB_key = ('pls_' . $shortcode . '_list');
		$tpl_list = get_option($tpl_list_DB_key, array()); // If it doesn't exist, create a blank array to append...
		$tpl_list[$id] = $data['title'];

		// sort alphabetically
		uasort($tpl_list, array(__CLASS__, '_tpl_list_sort'));
		update_option($tpl_list_DB_key, $tpl_list);
		self::_build_tpl_list($shortcode);
		return $id;
	}

	/**
	 * Delete a template
	 * @param string $id
	 * @return void
	 */
	public static function delete_shortcode_template($id) {
		// sanity check
		$parts = explode('_', $id);
		if (count($parts) < 4 || $parts[0]!=='pls') {die;
			return;
		}
		$shortcode = implode('_', array_slice($parts, 1, -2));
		if (empty(self::$shortcodes[$shortcode])) {die;
			return;
		}

		delete_option($id);

		// Remove from the list of custom template IDs for this shortcode...
		$tpl_list_DB_key = ('pls_' . $shortcode . '_list');
		$tpl_list = get_option($tpl_list_DB_key, array()); // If it doesn't exist, create a blank array to append...
		unset($tpl_list[$id]);
		update_option($tpl_list_DB_key, $tpl_list);
	}

	/**
	 * Load a template
	 * @param string $id
	 * @return array
	 */
	public static function load_shortcode_template($id) {
		$default = array('shortcode'=>'', 'title'=>'');
		if (strpos($id, 'pls_') !== 0) {
			return $default;
		}
		$data = get_option($id, $default);
		if (!is_array($data) || empty($data['shortcode']) || empty($data['title'])) {
			return $default;
		}
		return $data;
	}

	/**
	 * Return the list of available templates for the given shortcode.
	 * List includes default templates and user created ones
	 * @param string $shortcode
	 * @param bool $all			: true to include hidden templates like the preview one
	 * @return array
	 */
	public static function template_list($shortcode, $all = false) {
		// sanity check
		if (empty(self::$shortcodes[$shortcode])) {
			return array();
		}

		$tpl_type_map = array();

		$sc_args = self::get_shortcodes();

		// add default templates
		$default_tpls = !empty($sc_args[$shortcode]['default_tpl']) ? $sc_args[$shortcode]['default_tpl'] : array();
		foreach ($default_tpls as $name) {
			$tpl_type_map[$name] = array('type'=>'default', 'title'=>$name, 'id'=>$name);
		}

		// get custom templates
		$snippet_list_DB_key = ('pls_' . $shortcode . '_list');
		$tpl_list = get_option($snippet_list_DB_key, array());
		foreach ($tpl_list as $id => $name) {
			if ($id == 'pls_' . $shortcode . '___preview' && !$all) continue;
			$tpl_type_map[$id] = array('type'=>'custom', 'title'=>$name, 'id'=>$id);
		}
		return $tpl_type_map;
	}

	/**
	 * Comparator to sort template list in alphabetical order
	 */
	public static function _tpl_list_sort($a, $b) {
		return strcasecmp($a, $b);
	}

	/**
	 * Rebuild template list for the given shortcode
	 * @param string $shortcode	:
	 * @return array			: updated template list
	 */
	private static function _build_tpl_list($shortcode) {
		global $wpdb;
		// sanity check
		if (empty(self::$shortcodes[$shortcode])) {
			return array();
		}
		$tpls = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->options WHERE option_name LIKE %s", 'pls\_'.$shortcode.'\_\__%'));
		$tpl_list = array();
		foreach($tpls as $tpl){
			$tpl_data = get_option($tpl->option_name, array());
			if(empty($tpl_data['title'])) {
				$tpl_data['title'] = '';
			}
			$tpl_list[$tpl->option_name] = $tpl_data['title'];
		}

		uasort($tpl_list, array(__CLASS__, '_tpl_list_sort'));
		$tpl_list_DB_key = ('pls_' . $shortcode . '_list');
		update_option($tpl_list_DB_key, $tpl_list);
		return $tpl_list;
	}
}

new PL_Shortcode_CPT();
