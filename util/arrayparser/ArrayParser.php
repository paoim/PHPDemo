<?php

class ArrayParser
{
	
	private static $_instance = NULL;
	
	public static function instance()
	{
		if (! self::$_instance)
			self::$_instance = new ArrayParser();
		return self::$_instance;
	}
	
	public function groupArrayByIdFirstStyle($dataArray)
	{
		$result = array();
		foreach ($dataArray as $data) {
			$id = $data['id'];
			if (isset($result[$id])) {
				$result[$id][] = $data;
			} else {
				$result[$id] = array($data);
			}
		}
		$data = array();
		foreach ($result as $arr) {
			$data[] = $arr;
		}
		return $data;
	}
	
	public function groupArrayByIdSecondStyle($dataArray)
	{
		$group = array();
		foreach ($dataArray as $data) {
			$group[$data['id']][] = $data;
		}
		$data = array();
		foreach ($group as $arr) {
			$data[] = $arr;
		}
		return $data;
	}
	
	public function convertAssociateArrayToObjectFirst($associateArray)
	{
		$JsonPhpObject = (object) $associateArray;
		
		return $JsonPhpObject;
	}
	
	public function convertAssociateArrayToObjectSecond($associateArray)
	{
		//Convert Associated Array to Json Object
		$JsonObject = json_encode($associateArray);
		
		// Convert Json Object to Json PHP (Object in PHP)
		$JsonPhpObject = json_decode($JsonObject);
		
		return $JsonPhpObject;
	}
	
	public function convertJsonStringToObjectFirst($JsonString)
	{
		// convert Json String into Associated Array
		$associateArray = json_decode($JsonString, true);
		
		// Convert Associate Array to Object
		$JsonPhpObject = (object) $associateArray;
		
		return $JsonPhpObject;
	}
	
	public function convertJsonStringToObjectSecond($JsonString)
	{
		// convert Json String into Associated Array
		$associateArray = json_decode($JsonString, true);
		
		// Convert Associated Array to Json Object
		$JsonObject = json_encode($associateArray);
		
		// Convert Json Object to Json PHP (Object in PHP)
		$JsonPhpObject = json_decode($JsonObject);
		
		return $JsonPhpObject;
	}
}
