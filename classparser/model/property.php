<?php

class Property {
	
	private $_name;
	private $_keyword;
	private $_isStatic;
	private $_dataType;
	private $_visibility;
	private $_isConstant;
	private $_description;
	private $_defaultData;
	private $_comments = array();
	
	public function __construct() {
		
	}
	
	public function getName() {
		return $this->_name;
	}
	
	public function getKeyword() {
		return $this->_keyword;
	}
	
	public function getStatic() {
		return $this->_isStatic;
	}
	
	public function getDataType() {
		return $this->_dataType;
	}
	
	public function getVisibility() {
		return $this->_visibility;
	}
	
	public function getConstant() {
		return $this->_isConstant;
	}
	
	public function getDescription() {
		return $this->_description;
	}
	
	public function getDefaultData() {
		return $this->_defaultData;
	}
	
	public function getComments() {
		return $this->_comments;
	}
	
	public function setName($name) {
		$this->_name = $name;
	}
	
	public function setKeyword($keyword) {
		$this->_keyword = $keyword;
	}
	
	public function setStatic($isStatic) {
		$this->_isStatic = $isStatic;
	}
	
	public function setDataType($dataType) {
		$this->_dataType = $dataType;
	}
	
	public function setVisibility($visibility) {
		$this->_visibility = $visibility;
	}
	
	public function setConstant($isConstant) {
		$this->_isConstant = $isConstant;
	}
	
	public function setDescription($description) {
		$this->_description = $description;
	}
	
	public function setDefaultData($defaultData) {
		$this->_defaultData = $defaultData;
	}
	
	public function setComments($comments = array()) {
		$this->_comments = $comments;
	}
}
