<?php

require_once 'OneDriveApiConnector.php';

//api/OneDrive/api.php
class ApiController
{
	private static $_instance = null;
	
	private function __construct() {
		
	}
	
	public static function instance() {
		if (!self::$_instance) {
			self::$_instance = new ApiController();
		}
		return self::$_instance;
	}
	
	public function run() {
		$OneDriveApiConnector = OneDriveApiConnector::instance();
		//$result = $OneDriveApiConnector->getAccessToken();
		$result = $OneDriveApiConnector->getAuthorizationCode();
		var_dump($result);
		//echo "<pre>"; print_r($result); echo "</pre>";
	}
}
