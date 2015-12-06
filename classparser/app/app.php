<?php

require_once 'controller/ClassController.php';

class App
{
	
	private $_rFilePaths;
	private static $_instance = NULL;
	
	private function __construct()
	{
		//FIXME - will change
		$this->_rFilePaths = array(
				'/home/pao/netsirv_ws/nodesirv/phplib/Core/Common/Accept.php',
				'/home/pao/netsirv_ws/nodesirv/phplib/Core/Controller/Controller.php',
				'/home/pao/netsirv_ws/nodesirv/phplib/Core/Controller/REST.php',
				'/home/pao/netsirv_ws/nodesirv/phplib/Core/Controller/App.php',
				'/home/pao/netsirv_ws/nodesirv/phplib/Core/Controller/InputType.php',
				'/home/pao/netsirv_ws/nodesirv/phplib/Core/Controller/Module.php',
				'/home/pao/netsirv_ws/nodesirv/phplib/Core/Controller/API.php',
				'/home/pao/netsirv_ws/nodesirv/phplib/Core/Controller/User.php'
		);
	}
	
	public static function instance()
	{
		if (! self::$_instance)
			self::$_instance = new App();
		return self::$_instance;
	}
	
	public function run()
	{
		foreach ($this->_rFilePaths as $rFilePath) {
			$file = new ClassController($rFilePath);
			//$file->printData();
			//$file->printHtml();
			$file->printGithub();
			
			//echo $file->display();
		}
	}
}
