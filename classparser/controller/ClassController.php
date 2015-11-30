<?php

require_once 'model/core.php';
require_once '../util/fileparser/FileParser.php';

class ClassController extends FileParser {
	
	protected $dataArray = array();
	
	private $_data;
	private $_method;
	private $_property;
	private $_methods = array();
	private $_properties = array();
	
	private $_isClassComment = 0;
	private $_classComments = array();
	private $_classCommentLines = array();
	
	private $_otherComments = array();
	private $_otherCommentLines = array();
	
	public function __construct($rFilePath) {
		parent::__construct($rFilePath);
	}
	
	public function parseDataFile() {
		$this->_data = new Data();
		foreach ($this->contents as $contents) {
			foreach ($contents as $line) {
				$this->_scanClass($line);
			}
			if ($this->_isClassComment) {
				$this->_data->setComments($this->_classComments);
				$this->_data->setMethods($this->_methods);
				$this->_data->setProperties($this->_properties);
				$this->_data->setDescription($this->getDesc($this->_classComments, false));
				$this->dataArray[] = $this->_data;
					
				//Re-set new Object
				$this->_data = new Data();
				$this->_methods = array();
				$this->_isClassComment = 0;
				$this->_properties = array();
				$this->_classComments = array();
			}
		}
	}
	
	public function printData() {
		echo "<pre>"; print_r($this->dataArray); echo "</pre>";
		echo "<pre>"; print_r($this->contents); echo "</pre>";
	}
	
	public function printHtml() {
		foreach ($this->dataArray as $data) {
			echo "<h1>" .$data->getName(). "</h1>";
			echo "<p>" .$data->getDescription(). "</p>";
			
			echo "<h2>Properties</h2>";
			foreach ($data->getProperties() as $property) {
				echo "<h4>" .$property->getName(). "</h4>";
				echo "<p>" .$property->getDescription(). "</p>";
				echo "<ul>";
				echo "<li>Visibility Property: " .$property->getVisibility(). "</li>";
				echo "<li>Static Property: " .$property->getStatic(). "</li>";
				echo "<li>Constant Property: " .$property->getConstant(). "</li>";
				echo "<li>Keyword: " .$property->getKeyword(). "</li>";
				echo "</ul>";
			}
			
			echo "<h2>Methods</h2>";
			foreach ($data->getMethods() as $method) {
				echo "<h3>" .$method->getName(). "</h3>";
				echo "<p>" .$method->getDescription(). "</p>";
				echo "<ul>";
				echo "<li>Visibility Method: " .$method->getVisibility(). "</li>";
				echo "<li>Static Method: " .$method->getStatic(). "</li>";
				echo "<li>Final Method: " .$method->getFinal(). "</li>";
				echo "<li>Abstract Method: " .$method->getAbstract(). "</li>";
				echo "<li>Return: " .$method->getReturn(). "</li>";
				echo "</ul>";
			}
			echo "<hr>";
		}
	}
	
	public function printGithub() {
		foreach ($this->dataArray as $data) {
			echo "<pre>";
			echo "#[" .$data->getName(). "]()<br>";
			echo "> " .$data->getDescription(). "<br><br>";
			
			echo "##Properties<br><br>";
			foreach ($data->getProperties() as $property) {
				echo "###`" .$property->getName(). "`<br>";
				$description = (strlen($property->getDescription()) > 0) ? $property->getDescription() : 'is the ' .$property->getName(). '.';
				echo "> " .$description. "<br><br>";
				$visibility = (strlen($property->getVisibility()) > 0) ? "`" .$property->getVisibility(). "`": '';
				echo "+ **Visibility Property** -- " .$visibility. "<br>";
				echo "+ **Static Property** -- " .$property->getStatic(). "<br>";
				echo "+ **Constant Property** -- " .$property->getConstant(). "<br>";
				$keyword = (strlen($property->getKeyword()) > 0) ? "`" .$property->getKeyword(). "`": '';
				echo "+ **Keyword** -- " .$keyword. "<br>";
				$dataType = (strlen($property->getDataType()) > 0) ? "`" .$property->getDataType(). "`": '';
				echo "+ **Data Type** -- " .$dataType. "<br>";
				$defaultData = (strlen($property->getDefaultData()) > 0) ? "`" .$property->getDefaultData(). "`": '';
				echo "+ **Default Data** -- " .$defaultData. "<br><br>";
			}
			
			echo "##Methods<br>";
			foreach ($data->getMethods() as $method) {
				echo "###`" .$method->getName(). "`<br>";
				$name = $method->getName();
				if ($this->isContain($name, FileParser::CONSTRUCTOR)) {
					$name = 'Constructor';
				}
				$description = (strlen($method->getDescription()) > 0) ? $method->getDescription() : 'is the ' .$name. '.';
				echo "> " .$description. "<br><br>";
				$visibility = (strlen($method->getVisibility()) > 0) ? "`" .$method->getVisibility(). "`": '';
				echo "+ **Visibility Method** -- " .$visibility. "<br>";
				echo "+ **Static Method** -- " .$method->getStatic(). "<br>";
				echo "+ **Final Method** -- " .$method->getFinal(). "<br>";
				echo "+ **Abstract Method** -- " .$method->getAbstract(). "<br>";
				$return = (strlen($method->getReturn()) > 0) ? "`" .$method->getReturn(). "`": '';
				echo "+ **Return** -- " .$return. "<br><br>";
			}
			echo "</pre>";
			echo "<hr>";
		}
	}
	
	private function _scanClass($line) {
		if (!$this->_isClassComment && $this->isComment($line)) {
			$this->_classCommentLines[] = $line;
			
			if ($this->isEndComment($line) && count($this->_classCommentLines)) {
				$this->_classComments[] = $this->_classCommentLines;
				$this->_classCommentLines = array();
			}
		} else {
			if ($this->isClass($line)) {
				$this->_isClassComment = 1;
				$this->_data->setName($line);
			} else {
				//echo "<pre>"; print_r('------------------Not Class-------------------'); echo "</pre>";
				if ($this->isComment($line)) {
					//echo "<pre>"; print_r('------------------Other Comments-------------------'); echo "</pre>";
					$this->_otherCommentLines[] = $line;
					
					if ($this->isEndComment($line) && count($this->_otherCommentLines)) {
						$this->_otherComments[] = $this->_otherCommentLines;
						$this->_otherCommentLines = array();
					}
				} else {
					//echo "<pre>"; print_r('------------------Not Other Comments-------------------'); echo "</pre>";
					if ($this->isMethod($line) || $this->isReturn($line)) {
						if ($this->isMethod($line)) {
							//echo "<pre>"; print_r('------------------Method-------------------'); echo "</pre>";
							$methodData = explode(FileParser::FUNCTION_K, $line);
							$this->_method = new Method();
							$this->_method->setName($this->getName($methodData[1]));
							$this->_method->setComments($this->_otherComments);
							$this->_method->setDescription($this->getDesc($this->_otherComments));
							$this->_method->setAbstract($this->getAbstract($methodData[0]));
							$this->_method->setStatic($this->getStatic($methodData[0]));
							$this->_method->setFinal($this->getFinal($methodData[0]));
							$this->_method->setVisibility($this->getVisibility($methodData[0]));
							$this->_otherComments = array();
							$this->_methods[] = $this->_method;
						} else {
							if ($this->isReturn($line)) {
								$this->_method->setReturn($this->getReturn($this->_method->getComments()));
								$this->_method = new Method();
								//$this->_methods[] = $this->_method;
							}
						}
					} else {
						//echo "<pre>"; print_r('------------------Not Method-------------------'); echo "</pre>";
						if ($this->isProperty($line)) {
							//echo "<pre>"; print_r('------------------Property-------------------'); echo "</pre>";
							//echo "<div>" .$line. "</div><br>";
							
							$this->_property = new Property();
							$this->_property->setComments($this->_otherComments);
							$this->_property->setVisibility($this->getVisibility($line, false));
							$this->_property->setKeyword($this->getPropertyKeyword($line));
							$this->_property->setName($this->getPropertyName($line));
							$this->_property->setDescription($this->getDesc($this->_otherComments, false));
							$this->_property->setStatic($this->getStatic($line));
							$this->_property->setConstant($this->getConst($line));
							$this->_property->setDataType($this->getPropertyDataType($this->_otherComments));
							$this->_property->setDefaultData($this->getPropertyDefaultData($line));
							$this->_properties[] = $this->_property;
							$this->_otherComments = array();
						}
					}
				}
			}
			
			
		}
	}
	
	private function _scanProperty($line) {
		if ($this->_isClassComment) {
			if ($this->isComment($line)) {
				//echo "<div>" .$line. "</div><br>";
				//$this->_otherCommentLines[] = $line;
				
				if ($this->isEndComment($line) && count($this->_otherCommentLines)) {
					//$this->_otherComments[] = $this->_otherCommentLines;
					//$this->_otherCommentLines = array();
				}
			}
		}
	}
	
	private function _scanMethod($line) {
		if ($this->isMethod($line)) {
			//echo "<div>" .$line. "</div><br>";
		}
	}
}
