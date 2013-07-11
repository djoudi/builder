<?php

PL_CRM_Controller::init();

class PL_CRM_Controller {

	private static $activeCRMKey = "pl_active_CRM";
	private static $registeredCRMList = array();

	public static function init () {
		// Load CRM libs...
		include_once("models/base.php");
		include_once("models/contactually.php");
		include_once("models/followupboss.php");

		// Load any necessary non-CRM plugin libs...
		$curr_dir = trailingslashit(dirname(__FILE__));
		include_once("{$curr_dir}../../models/options.php");

		// Register main AJAX endpoint for all CRM calls...
		add_action("wp_ajax_crm_ajax_controller", array(__CLASS__, "ajaxController"));
	}

	public static function ajaxController () {
		// error_log("In ajaxController...");
		// error_log(var_export($_POST, true));
		// die();

		// TODO: A better default message...
		$response = "";

		// CRM-related AJAX calls (i.e., to the single endpoint defined in init) MUST specify a
		// field called "crm_method" that corresponds to the class function it wants to execute,
		// along with the properly labeled fields as subsequent arguments...
		if (!empty($_POST["crm_method"])) {
			// Set args array if it exists...
			$args = ( !empty($_POST["crm_args"]) && is_array($_POST["crm_args"]) ? array_values($_POST["crm_args"]) : array() );

			// Special handling for AJAX requests to populate contact "dataTable" grids...
			if (isset($_POST["sEcho"])) {
				$args = array($_POST);
			}

			// Execute primary function...
			$callback = array(__CLASS__, $_POST["crm_method"]);
			$response = call_user_func_array($callback, $args);

			// Check to see if a separate callback is specified for what is returned...
			if (!empty($_POST["return_spec"]) && is_array($_POST["return_spec"])) {
				$ret = $_POST["return_spec"];
				$ret_args = ( !empty($ret["args"]) && is_array($ret["args"]) ? array_values($ret["args"]) : array() );

				// Set response to return method's value...
				$ret_callback = array(__CLASS__, $ret["method"]);
				$response = call_user_func_array($ret_callback, $ret_args);
			}

			// Handle formatting response if set to JSON...
			if (!empty($_POST["response_format"]) && $_POST["response_format"] == "JSON") {
		 		error_log("Formatted as JSON...");
		 		$response = json_encode($response);
	 		}
 		}

		// Write payload to response...
		echo $response;

		die();
	}

	/*
	 * Utility CRM methods...
	 */

	public static function registerCRM ($crm_info) {
		// We need an id...
		if (empty($crm_info["id"])) { return; }

		// Translate logo image file into valid URL path...
		if (!empty($crm_info["logo_img"])) {
			$crm_info["logo_img"] = self::getImageURL($crm_info["logo_img"]);
		}

		self::$registeredCRMList[$crm_info["id"]] = $crm_info;
	}

	public static function getCRMInfo ($crm_id) {
		$info = array();

		if (!empty(self::$registeredCRMList[$crm_id])) {
			$info = self::$registeredCRMList[$crm_id];	
		}

		return $info;
	}

	public static function integrateCRM ($crm_id, $api_key) {
		// Try to create an instance...
		$crm_obj = self::getCRMInstance($crm_id);

		// Set (i.e., store) credentials/API key for this CRM so that it can be activated...
		return ( is_null($crm_obj) ? false : $crm_obj->setAPIkey($api_key) );
	}

	/* The opposite of integration -- remove key/credentials associated with the passed CRM... */
	public static function resetCRM ($crm_id) {
		// Try to create an instance...
		$crm_obj = self::getCRMInstance($crm_id);

		// Reset (i.e., remove) credentials/API key associated with the CRM so new ones can be entered...
		return ( is_null($crm_obj) ? false : $crm_obj->resetAPIkey() );
	}

	public static function getActiveCRM () {
		return PL_Options::get(self::$activeCRMKey, null);
	}

	public static function setActiveCRM ($crm_id) {
		return PL_Options::set(self::$activeCRMKey, $crm_id);
	}

	public static function resetActiveCRM () {
		return PL_Options::delete(self::$activeCRMKey);
	}

	/* Exposes all public CRM library methods... */
	public static function callCRMLib ($method, $args = array()) {
		$retVal = null;

		// Try to create an instance...
		$crm_id = self::getActiveCRM();
		$crm_obj = self::getCRMInstance($crm_id);

		if (!is_null($crm_obj) && method_exists($crm_obj, $method)) {
			$retVal = $crm_obj->$method($args);
		}

		return $retVal;
	}

	public static function getContactGridData ($args = array()) {
		error_log("In getGridData...");
		error_log(var_export($args, true));

		// Try to create an instance...
		$crm_id = self::getActiveCRM();
		$crm_obj = self::getCRMInstance($crm_id);
		
		$filters = array();

		// Pagination
		$filters["limit"] = $args["iDisplayLength"];
		$filters["offset"] = $args["iDisplayStart"];
		
		// Get grid data...
		$data = $crm_obj->getContacts($filters);

		// Format grid data in a form dataTables.js expects for rendering...
		$grid_rows = array();
		$ordered_field_keys = array_keys($crm_obj->contactFieldMeta());

		if (!empty($data["contacts"]) && is_array($data["contacts"])) {
			foreach ($data["contacts"] as $index => $contact) {
				foreach ($ordered_field_keys as $key) {
					$val = empty($contact[$key]) ? "" : $contact[$key];
					$grid_rows[$index][] = $val;
				}
			}
		}

		// Set total from API response -- corresponds to all possible contacts available...
		$total = empty($data["total"]) ? 0 : $data["total"];

		// Required for datatables.js grid to render and function properly...
		$grid_data["sEcho"] = $args["sEcho"];
		$grid_data["aaData"] = $grid_rows;
		$grid_data["iTotalRecords"] = $total;
		$grid_data["iTotalDisplayRecords"] = $total;

		// error_log(var_export($grid_data, true));
		return $grid_data;
	}

	/*
	 * Helpers...
	 */

	private static function getCRMInstance ($crm_id) {
		$crm_obj = null;

		// Lookup CRM info by ID to make sure it is supported...
		if (!empty(self::$registeredCRMList[$crm_id])) {
			// Get class and construct an instance...
			$crm_info = self::$registeredCRMList[$crm_id];
			$crm_class = $crm_info["class"];
			$crm_obj = new $crm_class();
		}
	
		return $crm_obj;
	}

	private static function sanitizeInput ($str_input) {
		// Removes backslashes then proceeds to remove all HTML tags...
		$sanitized = strip_tags(stripslashes($str_input));

		return $sanitized;
	}

	/*
	 * Serve up view(s)...
	 */

	public static function mainView () {
		// Check if a CRM is active...
		$active_crm = self::getActiveCRM();

		ob_start();
			if (is_null($active_crm)) {
				// Set this var for use in the login view...
				$crm_list = self::$registeredCRMList;
				include("views/login.php");
			}
			else {
				// Set this var for us in the browse view...
				$crm_info = self::$registeredCRMList[$active_crm];
				include("views/browse.php");
			}
		$html = ob_get_clean();

		return $html;
	}

	public static function getPartial ($partial, $args = array()) {
		// Establish partials dir...
		$file_path = trailingslashit(dirname(__FILE__)) . "views/partials/{$partial}.php";
		$html = "";

		// Make sure partial file exists...
		if (file_exists($file_path)) {
			// Extract args to be used by the partial...
			extract($args);

			ob_start();
				include($file_path);
			$html = ob_get_clean();
		}

		return $html;
	}

	public static function getImageURL ($img_file) {
		$img_path = trailingslashit(dirname(__FILE__)) . "views/images/{$img_file}";
		$img_url = plugin_dir_url($img_path) . $img_file;

		return $img_url;
	}
}

?>