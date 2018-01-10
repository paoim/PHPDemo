<?php

require_once 'BaseConnector.php';

class ApiConnector extends BaseConnector
{

	protected $clientSecret;
	protected $code;
	protected $grantType;
	protected $scope;

	protected function __construct() {
		parent::__construct();
	}

	protected function _get($header, $url) {
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$result = curl_exec($ch);
		if ($result === false) {
			$result = $this->_getFailMessage('Curl error: ' . curl_error($ch));
			curl_close($ch);
			var_dump($result);
		}
		curl_close($ch);
		return $result;
	}

	protected function _post($header, $url, $content) {
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true );
		curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

		$result = curl_exec($ch);
		if ($result === false) {
			$result = $this->_getFailMessage('Curl error: ' . curl_error($ch));
			curl_close($ch);
			var_dump($result);
		}

		//$info = curl_getinfo($ch);
		//foreach ($info as $data) {
		//$result = $this->_getFailMessage('Curl error: ' . $data);
		//var_dump($data);
		//}

		curl_close($ch);
		return $result;
	}
}
