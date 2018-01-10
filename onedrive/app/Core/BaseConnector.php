<?php

class BaseConnector
{
	protected $providerApiHost;
	protected $providerApiBaseUrl;
	protected $tenant;
	protected $clientId;
	protected $redirectUri;
	protected $scope;
	
	protected function __construct() {
		
	}
	
	protected function _getFailMessage($description) {
		$messageJson = json_encode(array(
				'Result' => array(
						'Results' => 'False',
						'ResultsMessageCount' => 1,
						'ResultsMessage' => array(array(
								'ResultsMessageCode' => 0,
								'ResultsMessageDescription' => $description)))));
		$resultArray = $this->_getJsonDecode($messageJson);
		return $resultArray;
	}
	
	protected function _getJsonDecode($result) {
		$data = (is_array($result)) ? json_decode($result) : $result;
		return $data;
	}
}
