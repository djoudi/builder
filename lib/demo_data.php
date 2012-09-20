<?php

PL_Demo_Data::init();
class PL_Demo_Data {

	public function init() {
		add_action('wp_ajax_demo_data_on', array(__CLASS__, 'toggle_on' ) );
		add_action('wp_ajax_demo_data_off', array(__CLASS__, 'toggle_off' ) );
	}

	public function toggle_on() {
		self::toggle(true);
		echo json_encode(array('message' => 'You\'re site is now set to use demo data'));
		die();
	}

	public function toggle_off() {
		self::toggle(false);
		echo json_encode(array('message' => 'Demo data successfully turned off'));
		die();
	}

	private function toggle($state = false) {
		PL_Option_Helper::set_demo_data_flag($state);

		// Clear cache to get rid of all remnants of existing listings...
		PL_Cache::clear();
	}
}

?>