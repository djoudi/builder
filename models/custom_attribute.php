<?php

class PL_Custom_Attributes {

	public static function get($args = array()) {
		$config = PL_Config::PL_API_CUST_ATTR('get');
		$request = array_merge(array( "api_key" => PL_Option_Helper::api_key()), PL_Validate::request($args, $config['args']));
		$response = PL_HTTP::send_request($config['request']['url'], $request);
		if ($response) {
			foreach ($response as $attribute => $value) {
		 		$response[$attribute] = PL_Validate::attributes($value, $config['returns']);
		 	}
		 	return $response;
		}
		return array();
	}

	public static function create() {

	}

	public static function update() {

	}

	public static function details() {

	}

	public static function keys_for_options ($args = array()) {
		$options = array();
		$attributes = self::get($args);
		foreach ($attributes as $attribute => $value) {
			$options[$value['id']] = (string) $value['cat'] . ': ' . $value['name'];
		}
		return $options;
	}

//end class
}