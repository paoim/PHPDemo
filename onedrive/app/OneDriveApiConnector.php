<?php

require_once 'Core/ApiConnector.php';

class OneDriveApiConnector extends ApiConnector
{
	private $_providerApiTokenUrl;
	private $_providerApiAuthorizeUrl;
	
	private static $_instance = null;
	
	protected function __construct() {
		parent::__construct();
		$this->tenant = "common"; //FIXME - will get from Config
		$this->providerApiBaseUrl = "https://login.live.com/"; //FIXME - will get from Config
		$this->providerApiHost = "login.live.com"; //FIXME - will get from Config
		//$this->clientId = "c6a7c390-7c81-4814-b643-86e947507d8b"; //FIXME - will get from Config
		$this->clientId = "29a2b52e-8d0f-463f-aeb1-3f55acd512ca"; //FIXME - will get from Config
		//$this->clientSecret = "fantKCV697/wfjDBCT43}-}"; //FIXME - will get from Config
		$this->clientSecret = "vymFHLJ657%(dfaeETY97/>"; //FIXME - will get from Config
		$this->redirectUri = "http://www.phpdemo.dev/onedrive/app/callback.php"; //FIXME - will get from Config
		//$this->redirectUri = "https://paoim.netsirv.com/demo/index.php";
		
		//$this->_providerApiTokenUrl = $this->providerApiBaseUrl . $this->tenant . "/oauth2/v2.0/token";
		//$this->_providerApiAuthorizeUrl = $this->providerApiBaseUrl . $this->tenant . "/oauth2/v2.0/authorize";
		
		$this->_providerApiTokenUrl = $this->providerApiBaseUrl . "/oauth2/v2.0/token";
		$this->_providerApiAuthorizeUrl = $this->providerApiBaseUrl . "oauth20_authorize.srf";
	}

	public static function instance() {
		if (!self::$_instance)
			self::$_instance = new OneDriveApiConnector();
		return self::$_instance;
	}
	
	public function getAuthorizationCode() {
		$queryParam = "?client_id=" . $this->clientId .
						"&redirect_uri=" . $this->redirectUri .
						"&response_type=code&state=1234&scope=mail.read";
		$header = array(
				"Content-type: application/x-www-form-urlencoded",
				"Cache-Control: no-cache",
				"Pragma: no-cache",
				'Host: ' . $this->providerApiHost
		);
		$url = $this->_providerApiAuthorizeUrl . $queryParam;
		$result = $this->_get($header, $url);
		$resultArray = $this->_getJsonDecode($result);
		return $resultArray;
	}
	
	public function getAccessToken() {
		$content = "grant_type=authorization_code" .
				"&code=123456789" .
				"&redirect_uri=" . $this->redirectUri .
				"&scope=Directory.ReadWrite.All" .
				"&client_id=" . $this->clientId .
				"&client_secret=" . $this->clientSecret;
		//$content = "";
		$header = array(
				"Content-type: application/x-www-form-urlencoded",
				"Cache-Control: no-cache",
				"Pragma: no-cache",
				'Host: ' . $this->providerApiHost,
				'Content-Length: ' . strlen($content)
		);
		$queryParam = "?client_id=" . $this->clientId .
						"&client_secret=" . $this->clientSecret .
						"&redirect_uri=" . $this->redirectUri .
						"&resource=" . $this->redirectUri .
						"&grant_type=authorization_code" .
						"&scope=mail.read";
		$url = $this->_providerApiTokenUrl . $queryParam;
		$result = $this->_post($header, $url, $content);
		$resultArray = $this->_getJsonDecode($result);
		return $resultArray;
	}
}
