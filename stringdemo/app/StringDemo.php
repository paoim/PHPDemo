<?php

class StringDemo
{
	public function __construct() {
		$this->display();
	}
	
	private function display() {
		echo "<pre>"; print_r(substr('Welcome', 0, 1)); echo "</pre>";
		echo "<pre>"; print_r($this->_getXXXSSN('0487')); echo "</pre>";
		echo "<pre>"; print_r($this->_getXXXSSN('72-0487')); echo "</pre>";
		echo "<pre>"; print_r($this->_getXXXSSN('536-72-0487')); echo "</pre>";
		echo "<pre>"; print_r(($this->makeMd5('LMD0ma!n') == '369c5a2b79b61284f7574828a3141327') ? 'Yes' : 'No'); echo "</pre>";
		echo "<pre>"; print_r($this->getSirvaShipmentID('REG 123456')); echo "</pre>";
	}
	
	private function makeMd5($password) {
		return md5($password);
	}
	
	private function getSirvaShipmentID($description) {
		$description = $this->cleanContent($description);
		$description = strtoupper($description);
		if ($this->isContentStartWith($description, 'REG')) {
			$description = $this->replace($description, 'REG');
		}
		return $description;
	}
	
	private function replace($content, $filter) {
		$content = str_replace($filter, '', $content);
		$content = $this->cleanContent($content);
		return $content;
	}
	
	private function isContentStartWith($content, $filter) {
		$position = strpos($content, $filter, 0);//find from index zero

		return ($position === 0);
	}
	
	private function cleanContent($line) {

		return ($this->isValidStr($line) ? trim($line) : "");
	}
	
	private function isValidStr($str) {

		return (isset($str) && strlen($str) > 0);
	}
	
	private function _getXXXSSN($input) {
		$strSSN = "XXX-XXX-$input";
		$strArray = explode('-', $input);
		if (!count($strArray)) {
			return $input;
		}
		if (count($strArray) == 3) {
			$strSSN = "XXX-XXX-" . $strArray[2];
		} else if (count($strArray) == 2) {
			$strSSN = "XXX-XXX-" . $strArray[1];
		}
		return $strSSN;
	}
}
