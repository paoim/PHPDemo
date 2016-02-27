<?php


require_once 'Config.php';
require_once 'PrintUtil.php';
require_once 'models/Model.php';
require_once 'controllers/Controller.php';


class Application
{
	const DEFAULT_METHOD		= 'run';
	const DEFAULT_CONTROLLER	= 'index';
	
	private static $_instance	= null;
	
	public static function instance()
	{
		if (! self::$_instance)
			self::$_instance = new Application();
		return self::$_instance;
	}
	
	public function run()
	{
		$params = $this->_getClassMethodParam();
		$className = $params['Class']. 'Controller';
		$fileClass = 'controllers/' .$className. '.php';
		if (file_exists($fileClass)) {
			require_once $fileClass;
			if (class_exists($className)) {
				$Controller = new $className; // create new Object
				if ($params['Method']) {
					if (method_exists($Controller, $params['Method'])) {
						$Controller->{$params['Method']}($params['Param']); // execute method and parameters
					} else {
						PrintUtil::close("The method [{$params['Method']}] Does not exists in class [$className].");
					}
				} else {
					PrintUtil::close("There is no method in class [$className].");
				}
			} else {
				PrintUtil::close("The class [$className] Does not exists.");
			}
		} else {
			PrintUtil::close("The file [$fileClass] Does not exists.");
		}
	}
	
	private function _getClassMethodParam()
	{
		//PrintUtil::display(">> Start ". __METHOD__);
		$className = null;
		$methodName = null;
		$parameters = array();
		$params = $this->_getParams();
		if (isset($params[0])) {
			$className = ucfirst($params[0]);
		}
		if (isset($params[1])) {
			$methodName = lcfirst($params[1]);
		}
		if (isset($params[2])) {
			for ($x = 2; $x < count($params); $x++) {
				$parameters[] = $params[$x];
			}
		}
		//make default method if class name exist
		if ($className && !$methodName) {
			$methodName = self::DEFAULT_METHOD;
		}
		$dataArray = array(
				'Class'		=> $className,
				'Method'	=> $methodName,
				'Param'		=> $parameters
		);
		//PrintUtil::display(">> End ". __METHOD__);
		return $dataArray;
	}
	
	private function _getParams()
	{
		//PrintUtil::display(">> Start ". __METHOD__);
		$param = null;
		$params = array();
		if (array_key_exists('url', $_GET)) {
			$param = $_GET['url'];
		} else if (array_key_exists('url', $_REQUEST)) {
			$param = $_REQUEST['url'];
		}
		if ($param) {
			$param = rtrim($param, '/');
			$params = explode('/', $param);
		} else {
			$params[] = self::DEFAULT_CONTROLLER;
			$params[] = self::DEFAULT_METHOD;
			//PrintUtil::close("No Class to run this application because URL provided is wrong. The right URL should be 'index/run/123'.");
		}
		//PrintUtil::display(">> End ". __METHOD__);
		return $params;
	}
}
