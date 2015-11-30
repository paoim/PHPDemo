<?php

require_once 'UploadParser.php';

class UploadUtil {
	
	private $_config;
	private $_parser;
	
	public function __construct($config = array()) {
		$this->_config = $config;
		$this->_configUploadParser();
	}
	
	public function run() {
		//echo "<pre>"; print_r(">>Start on Run..."); echo "</pre>";
		if (empty($this->_parser)) {
			echo "<pre>"; print_r("Invalid Upload Parser!"); echo "</pre>";
			die();
		}
		
		$this->_parser->upload();
		//$this->display();
		//echo "<pre>"; print_r(">>End on Run..."); echo "</pre>";
	}
	
	public function getUploads() {
		return $this->_parser->getUploads();
	}
	
	public function getFails() {
		return $this->_parser->getFails();
	}
	
	protected function display() {
		if (!empty($this->_parser)) {
			echo "<pre>"; print_r($this->_parser->getUploads()); echo "</pre>";
			echo "<pre>"; print_r($this->_parser->getFails()); echo "</pre>";
		}
	}
	
	private function _configUploadParser() {
		//echo "<pre>"; print_r(">>Start on _configUploadParser..."); echo "</pre>";
		$files = array();
		if (!array_key_exists('Files', $this->_config)) {
			if (!empty($_FILES['files']['name'][0])) {
				$files = $_FILES['files'];
			}
		} else {
			$files = $this->_config['Files'];
		}
		
		$destination = (!array_key_exists('Destination', $this->_config)) ? UPLOAD_DIR.'/asset/output' : $this->_config['Destination'];
		$isNewFileName = (!array_key_exists('IsNewFileName', $this->_config)) ? true : $this->_config['IsNewFileName'];
		$sizeAllowed = (!array_key_exists('SizeAllowed', $this->_config)) ? array(10, 2097152) : $this->_config['SizeAllowed'];
		$extAllowed = (!array_key_exists('ExtAllowed', $this->_config)) ? array('txt', 'csv', 'jpg') : $this->_config['ExtAllowed'];
		
		$this->_parser = new UploadParser($files, $destination, $extAllowed, $sizeAllowed, $isNewFileName);
		//echo "<pre>"; print_r(">>End on _configUploadParser..."); echo "</pre>";
	}
}
