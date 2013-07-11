<?php

PL_CRM_Followupboss::init();

class PL_CRM_Followupboss extends PL_CRM_Base {
	
	private static $apiOptionKey = "pl_followupboss_api_key";
	private static $apiURL = "https://api.followupboss.com";
	private static $version = "v1";

	private static $contactFieldsMeta = array();

	public static function init () {
		// Register this CRM implementation with the controller...
		if (class_exists("PL_CRM_Controller")) {
			$crm_info = array(
				"id" => "followupboss",
				"class" => "PL_CRM_Followupboss",
				"display_name" => "Follow Up Boss",
				"referral_url" => "app.followupboss.com/signup?p=placester",
				"cred_lookup_url" => "https://app.followupboss.com/settings/user",
				"logo_img" => "follow-up-boss-color.png"
			);

			PL_CRM_Controller::registerCRM($crm_info);
		}

		// Initialize contact field -- NOTE: Specific to this CRM's API!!!
		self::$contactFieldsMeta = array(
			"id" => "ID",
			"firstName" => "First Name",
			"lastName" => "Last Name",
			"emails" => "E-mail(s)",
			"phones" => "Phone(s)",
			"stage" => "Stage",
			"source" => "Source",
			"lastActivity" => "Last Activity",
			"contacted" => "Contacted"
		);

		// $contactFields = array(
		// 	"id" => array(
		// 		"display" => "ID",
		// 		"searchable" => true
		// 	),
		// 	"firstName" => "First Name",
		// 	"lastName" => "Last Name",
		// 	"emails" => "E-mail(s)",
		// 	"phones" => "Phone(s)",
		// 	"stage" => "Stage",
		// 	"source" => "Source",
		// 	"lastActivity" => "Last Activity",
		// 	"contacted" => "Contacted"
		// );
	}

	public function __construct () {
		// Nothing yet...
	}

	protected function getAPIOptionKey () {
		return self::$apiOptionKey;
	}

	protected function setCredentials (&$handle, &$args) {
		$api_key = $this->getAPIKey();

		// HTTP authentication using the API key as user name with no password...
		curl_setopt($handle, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($handle, CURLOPT_USERPWD, $api_key . ":");
	}

	public function constructURL ($endpoint) {
		$url = self::$apiURL;
		$version = self::$version;

		return "{$url}/{$version}/{$endpoint}";
	}

	/*
	 * Contacts
	 */

	public function getContactFieldsMeta () {
		return self::$contactFieldsMeta;
	}

	public function getContacts ($filters = array()) {
		// This is a GET request, so mark all filters as query string params...
		$args = array("query_params" => $filters);

		// Make API Call...
		$response = $this->callAPI("people", "GET", $args);

		error_log(var_export($response, true));

		// Translate API specific response into standard contacts collection...
		$data = array();
		$data["total"] = empty($response["_metadata"]["total"]) ? 0 : $response["_metadata"]["total"];
		$data["contacts"] = (empty($response["people"]) || !is_array($response["people"])) ? array() : $response["people"];

		return $data;
	}

	public function createContact ($args) {
		// NOTE: Use events endpoint for this!!!
	}
}

?>