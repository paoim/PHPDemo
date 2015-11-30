<?php

class UploadParser {
	
	private $_files;
	private $_extAllowed;
	private $_destination;
	private $_sizeAllowed;
	private $_isNewFileName;
	private $_failed = array();
	private $_uploaded = array();
	
	public function __construct($files, $destination, $extAllowed, $sizeAllowed, $isNewFileName) {
		$this->_files = $files;
		$this->_extAllowed = $extAllowed;
		$this->_destination = $destination;
		$this->_sizeAllowed = $sizeAllowed;
		$this->_isNewFileName = $isNewFileName;
	}
	
	public function getFails() {
		return $this->_failed;
	}
	
	public function getUploads() {
		return $this->_uploaded;
	}
	
	public function upload() {
		//echo "<pre>"; print_r(">>Start on upload..."); echo "</pre>";
		if (!count($this->_files)) {
			$this->_failed[] = "No files to upload, please click to upload!";
			exit();
		}
		
		foreach ($this->_files['name'] as $index => $fileName) {
			$file_tmp = $this->_files['tmp_name'][$index];
			$file_size = $this->_files['size'][$index];
			$file_error = $this->_files['error'][$index];
			
			$file_ext = explode('.', $fileName);
			$file_ext = strtolower(end($file_ext));
			
			// check file's extension
			if (in_array($file_ext, $this->_extAllowed)) {
				
				// check file uploaded fail or successfully
				if ($file_error === 0) {
					
					// check file's size
					if ($file_size >= $this->_sizeAllowed[0] && $file_size <= $this->_sizeAllowed[1]) {
						
						// check to create new file's name or keep old one
						$newFileName = str_replace('.', '_', uniqid('', true));
						$newFileName = ($this->_isNewFileName) ? ($newFileName .'.'. $file_ext) : $fileName;
						$fileDestination = $this->_destination .'/'. $newFileName;
						
						// check directory
						if (!is_dir($this->_destination .'/')) {
							mkdir($this->_destination .'/');
						}
						
						if (move_uploaded_file($file_tmp, $fileDestination)) {
							$this->_uploaded[$index] = $fileDestination;
						} else {
							$this->_failed[$index] = "[{$fileName}] failed to upload.";
						}
					} else {
						$this->_failed[$index] = "[{$fileName}] is not between [{$this->_sizeAllowed}].";
					}
				} else {
					$this->_failed[$index] = "[{$fileName}] errored with code {$file_error}.";
				}
			} else {
				$this->_failed[$index] = "[{$fileName}] file extension '{$file_ext}' not allowed.";
			}
		}
		//echo "<pre>"; print_r(">>End on upload..."); echo "</pre>";
	}
}
