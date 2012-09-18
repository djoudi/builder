<?php 

class PL_Integration {
	
	public function get($args = array()) {
		$request = array_merge(array("api_key" => PL_Option_Helper::api_key()), PL_Validate::request($args, PL_Config::PL_API_INTEGRATION('get', 'args')));
		$response = PL_HTTP::send_request(trailingslashit(PL_Config::PL_API_INTEGRATION('get', 'request', 'url')), $request, PL_Config::PL_API_INTEGRATION('get', 'request', 'type'), false);
		if (!empty($response)) {
			foreach ($response as $key => $value) {
				$response[$key] = PL_Validate::attributes($value, PL_Config::PL_API_INTEGRATION('get', 'returns'));
			}
		} else {
			$response = array( PL_Validate::attributes($response, PL_Config::PL_API_INTEGRATION('get', 'returns')) );
		}

		return $response;
	}

	public function create($args = array()) {
		$request = PL_Validate::request($args, PL_Config::PL_API_INTEGRATION('create', 'args') );
		$request = array_merge($request, array("api_key" => PL_Option_Helper::api_key() ) );
		$response = PL_HTTP::send_request(PL_Config::PL_API_INTEGRATION('create', 'request', 'url'), $request, PL_Config::PL_API_INTEGRATION('create', 'request', 'type'));
		//error_log(serialize($response));
		return $response;
	}

	public function mls_list($args = array()) {
		$request = PL_Validate::request($args, PL_Config::PL_API_INTEGRATION('mls_list', 'args'));
		$request = array_merge($request, array("api_key" => PL_Option_Helper::api_key()));

		$response = PL_HTTP::send_request(PL_Config::PL_API_INTEGRATION('mls_list', 'request', 'url'), $request, PL_Config::PL_API_INTEGRATION('mls_list', 'request', 'type'));
		return $response;
	}
}