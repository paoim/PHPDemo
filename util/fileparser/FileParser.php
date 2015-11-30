<?php

abstract class FileParser {
	
	const COMMENT_START			= '/**';
	const COMMENT_END			= '*/';
	const COMMENT_SINGLE		= '//';
	const COMMENT_STAR			= '*';
	const COMMENT_STAR_AT		= '*@';
	const AT_PARAM				= '@param';
	const AT_RETURN				= '@return';
	const AT_VAR				= '@var';
	const AT_SEE				= '@see';
	const PRIVATE_V				= 'private';
	const PUBLIC_V				= 'public';
	const PROTECTED_V			= 'protected';
	const FINAL_K				= 'final';
	const CONST_K				= 'const';
	const STATIC_K				= 'static';
	const FUNCTION_K			= 'function';
	const CLASS_K				= 'class';
	const ABSTRACT_K			= 'abstract';
	const TRAIT_K				= 'trait';
	const INTERFACE_K			= 'interface';
	const USE_K					= 'use';
	const RETURN_K				= 'return';
	const EQUAL_K				= '=';
	const CURLY_BRACE_START		= '{';
	const CURLY_BRACE_END		= '}';
	const CONSTRUCTOR			= '__construct';
	
	private $_rFilePath;
	
	public $contents = array();
	public $content_lines = array();
	
	protected $isClassComment = 0;
	
	public function __construct($rFilePath) {
		$this->_rFilePath = $rFilePath;
		
		$this->_readFile();
		$this->parseDataFile();
	}
	
	abstract public function parseDataFile();
	
	public function display() {
		$i = 0;
		foreach ($this->content_lines as $line) {
			echo "<div id='line_".strlen($line)."_".$i."'>" .$line. "</div><br>";
			$i++;
		}
	}
	
	public function writeFile($content, $fileName) {
		if (isset($this->_wFileName)) {
			$wFilePath = 'output/' .$fileName;
			$fp = fopen($wFilePath, "w") or die("Unable to open file!");
			if (isset($content)) {
				fwrite($fp, $content);
			}
			fclose($fp);
		}
	}
	
	protected function getDesc($comments, $isMethod = true) {
		$data = '';
		if (count($comments) && count($comments[0])) {
			$data = $this->cleanContent(str_replace(FileParser::COMMENT_START, '', $comments[0][0]));
			$data = $this->cleanContent(str_replace(FileParser::COMMENT_END, '', $data));
			if ($this->isValidStr($data)) {
				if (isset($comments[0][1]) && $isMethod) {
					$second = $this->cleanContent(str_replace(FileParser::COMMENT_STAR, '', $comments[0][1]));
					$second = $this->cleanContent(str_replace(FileParser::COMMENT_END, '', $second));
					if (!$this->isContainAt($second)) {
						$data = $data . ' ' . $second;
					}
				}
			} else {
				if (isset($comments[0][1])) {
					$data = $this->cleanContent(str_replace(FileParser::COMMENT_START, '', $comments[0][1]));
					$data = $this->cleanContent(str_replace(FileParser::COMMENT_STAR, '', $data));
					$data = $this->cleanContent(str_replace(FileParser::COMMENT_END, '', $data));
				}
			}
		}
		if ($this->isContainAt($data)) {
			$data = '';
		}
		return $data;
	}
	
	protected function getFinal($line) {
		$data = 'no';
		if ($this->isContain($line, FileParser::FINAL_K)) {
			$data = 'yes';
		}
		return $data;
	}
	
	protected function getAbstract($line) {
		$data = 'no';
		if ($this->isContain($line, FileParser::ABSTRACT_K)) {
			$data = 'yes';
		}
		return $data;
	}
	
	protected function getStatic($line) {
		$data = 'no';
		if ($this->isContain($line, FileParser::STATIC_K)) {
			$data = 'yes';
		}
		return $data;
	}
	
	protected function getConst($line) {
		$data = 'no';
		if ($this->isContain($line, FileParser::CONST_K)) {
			$data = 'yes';
		}
		return $data;
	}
	
	protected function getVisibility($line, $isMethod = true) {
		$data = $isMethod ? FileParser::PUBLIC_V : '';
		if ($this->isContain($line, FileParser::PRIVATE_V)) {
			$data = FileParser::PRIVATE_V;
		} else if ($this->isContain($line, FileParser::PROTECTED_V)) {
			$data = FileParser::PROTECTED_V;
		} else if ($this->isContain($line, FileParser::PUBLIC_V)) {
			$data = FileParser::PUBLIC_V;
		}
		return $data;
	}
	
	protected function getName($line) {
		$data = str_replace(FileParser::CURLY_BRACE_START, '', $line);
		$data = str_replace(';', '', $data);
		return $this->cleanContent($data);
	}
	
	protected function getPropertyName($line) {
		$data = $this->_getPropertyLine($line)['Data'];
		if ($this->isContentStartWith($data, FileParser::CONST_K)) {
			$data = str_replace(FileParser::CONST_K, '', $data);
		} else if ($this->isContentStartWith($data, FileParser::USE_K)) {
			$data = str_replace(FileParser::USE_K, '', $data);
		}
		$data = str_replace(';', '', $data);
		return $this->cleanContent($data);
	}
	
	protected function getPropertyKeyword($line) {
		$data = $this->_getPropertyLine($line)['Data'];
		if ($this->isContain($data, FileParser::CONST_K)) {
			$data = FileParser::CONST_K;
		} else if ($this->isContain($data, FileParser::USE_K)) {
			$data = FileParser::USE_K;
		} else {
			$data = '';
		}
		return $data;
	}
	
	protected function getPropertyDefaultData($line) {
		$data = $this->_getPropertyLine($line)['Default'];
		$data = str_replace(';', '', $data);
		return $this->cleanContent($data);
	}
	
	protected function getPropertyDataType($comments) {
		$data = '';
		foreach ($comments as $commentArray) {
			foreach ($commentArray as $comment) {
				if ($this->isContain($comment, FileParser::AT_VAR)) {
					$data = str_replace(FileParser::AT_VAR, '', $comment);
					$data = str_replace(FileParser::COMMENT_STAR, '', $data);
					$data = $this->cleanContent(str_replace(';', '', $data));
					break;
				}
			}
		}
	}
	
	protected function getReturn($comments) {
		$data = '';
		foreach ($comments as $commentArray) {
			foreach ($commentArray as $comment) {
				if ($this->isContain($comment, FileParser::AT_RETURN)) {
					$data = str_replace(FileParser::AT_RETURN, '', $comment);
					$data = str_replace(FileParser::COMMENT_END, '', $data);
					$data = str_replace(FileParser::COMMENT_STAR, '', $data);
					$data = $this->cleanContent(str_replace(';', '', $data));
					$dataArray = explode(' ', $data);
					if (count($dataArray)) {
						$data = $dataArray[0];
						$dataArray = explode('(', $data);
						if (count($dataArray)) {
							$data = $dataArray[0];
							unset($dataArray);
						}
					}
					break;
				}
			}
		}
		return $this->cleanContent($data);
	}
	
	protected function isContainAt($second) {
		return ($this->isContentStartWith($second, FileParser::AT_PARAM) || $this->isContentStartWith($second, FileParser::AT_RETURN) || $this->isContentStartWith($second, FileParser::AT_VAR) || $this->isContentStartWith($second, FileParser::AT_SEE));
	}
	
	protected function isStatement($line) {
		return ($this->isClass($line) || $this->isComment($line) || $this->isMethod($line) || $this->isReturn($line) || $this->isProperty($line) || $this->isStartCurlyBrace($line) || $this->isEndCurlyBrace($line));
	}
	
	protected function isStartCurlyBrace($line) {
		return ($this->isContain($line, FileParser::CURLY_BRACE_START));
	}
	
	protected function isEndCurlyBrace($line) {
		return ($this->isContain($line, FileParser::CURLY_BRACE_END));
	}
	
	protected function isClass($line) {
		return ($this->isContentStartWith($line, FileParser::CLASS_K) || $this->isContentStartWith($line, FileParser::TRAIT_K) || ($this->isContentStartWith($line, FileParser::ABSTRACT_K) && $this->isContain($line, FileParser::CLASS_K)) || $this->isContentStartWith($line, FileParser::INTERFACE_K));
	}
	
	protected function isComment($line) {
		return ($this->isContentStartWith($line, FileParser::COMMENT_START) || $this->isContentStartWith($line, FileParser::COMMENT_STAR) || $this->isContentStartWith($line, FileParser::COMMENT_END));
	}
	
	protected function isEndComment($line) {
		return ($this->isContain($line, FileParser::COMMENT_END));
	}
	
	protected function isProperty($line) {
		if (!($this->isContain($line, FileParser::FUNCTION_K))) {
			if (($this->isContentStartWith($line, FileParser::PUBLIC_V) || $this->isContentStartWith($line, FileParser::PROTECTED_V) || $this->isContentStartWith($line, FileParser::PRIVATE_V) || $this->isContentStartWith($line, FileParser::USE_K) || $this->isContentStartWith($line, FileParser::CONST_K))) {
				return true;
			}
		}
		return false;
	}
	
	protected function isMethod($line) {
		return (($this->isContain($line, FileParser::FUNCTION_K)) && ($this->isContain($line, FileParser::PUBLIC_V) || $this->isContain($line, FileParser::PROTECTED_V) || $this->isContain($line, FileParser::PRIVATE_V) || $this->isContain($line, FileParser::USE_K) || $this->isContain($line, FileParser::CONST_K)));
	}
	
	protected function isReturn($line) {
		return ($this->isContain($line, FileParser::RETURN_K));
	}
	
	protected function isContain($line, $filter) {
		return ($this->isContentStartWith($line, $filter) || $this->isContainWith($line, $filter));
	}
	
	protected function isContentStartWith($content, $filter) {
		$position = strpos($content, $filter, 0);//find from index zero

		return ($position === 0);
	}
	
	protected function isContainWith($content, $filter) {
		//preg_match("/$filter/", $content)
		return (strpos($content, $filter) > 0);
	}
	
	private function _readFile() {
		if (isset($this->_rFilePath)) {
			$fp = fopen( $this->_rFilePath , 'r' ) or die("Unable to open file!");
			$this->_readContent($fp);
		}
	}
	
	private function _readContent($fp) {
		$index = 0;
		$newContents = array();
		while(!feof($fp)) {
			$line = $this->cleanContent(fgets($fp));
			if (strlen($line) > 0) {
				$this->content_lines[] = $line;
				if ($this->isStatement($line)) {
					$newContents[] = $line;
				}
				if ($this->isClass($line)) {
					if ($index > 0) {
						$results = $this->_populateContent($newContents);
						$this->contents[] = $results['NewContents'];
						$newContents = array();
						$otherContents = $results['OtherContents'];
						for ($i = count($otherContents) - 1; $i >= 0; $i--) {
							$newContents[] = $otherContents[$i];
						}
						//echo "<pre>"; print_r($newContents); echo "</pre>";
					}
					$index++;
				}
			}
		}
		$this->contents[] = $newContents;
		$this->contents = array_filter($this->contents); //remove empty from array
		fclose($fp);
	}
	
	private function _populateContent($newContents = array()) {
		$otherArray = array();
		$isSingleClass = false;
		if (count($newContents)) {
			for ($i = count($newContents) - 1; $i >= 0; $i--) {
				if ($this->isEndCurlyBrace($newContents[$i]) && !$this->isClass($newContents[$i])) {
					break;
				} else {
					if ($this->isEndCurlyBrace($newContents[$i]) && $this->isClass($newContents[$i])) { //for single line. Ex: class RESTNoContent {}
						$isSingleClass = true;
					}
					if ($this->isClass($newContents[$i]) || $this->isComment($newContents[$i])) {
						$otherArray[] = array_pop($newContents);
					}
				}
			}
		}
		if ($isSingleClass) {
			$singleClass = array();
			for ($i = count($otherArray) - 1; $i >= 0; $i--) {
				$singleClass[] = $otherArray[$i];
			}
			$this->contents[] = $singleClass;
			$otherArray = array();
		}
		$resultArray = array(
				'NewContents'		=> $newContents,
				'OtherContents'		=> $otherArray
		);
		return $resultArray;
	}
	
	private function _getPropertyLine($line) {
		$default = '';
		$data = $line;
		if ($this->isContentStartWith($data, FileParser::PRIVATE_V)) {
			$data = str_replace(FileParser::PRIVATE_V, '', $data);
		} else if ($this->isContentStartWith($data, FileParser::PROTECTED_V)) {
			$data = str_replace(FileParser::PROTECTED_V, '', $data);
		} else if ($this->isContentStartWith($data, FileParser::PUBLIC_V)) {
			$data = str_replace(FileParser::PUBLIC_V, '', $data);
		}
		$data = $this->cleanContent($data);
		if ($this->isContentStartWith($data, FileParser::STATIC_K)) {
			$data = str_replace(FileParser::STATIC_K, '', $data);
		}
		$data = $this->cleanContent($data);
		if ($this->isContain($data, FileParser::EQUAL_K)) {
			$dataArray = explode(FileParser::EQUAL_K, $data);
			//echo "<pre>"; print_r($dataArray); echo "</pre>";
			if (count($dataArray)) {
				$data = $this->cleanContent($dataArray[0]);
				$default = $this->cleanContent($dataArray[1]);
			}
		}
		return array('Data' => $data, 'Default' => $default);
	}

	protected function cleanContent($line) {

		return ($this->isValidStr($line) ? trim($line) : "");
	}

	protected function isValidStr($str) {

		return (isset($str) && strlen($str) > 0);
	}
}
