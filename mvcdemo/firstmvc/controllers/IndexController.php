<?php


require_once 'models/Member.php';

class IndexController extends Controller
{
	public function __construct()
	{
		//PrintUtil::display("I am inside " .__CLASS__);
		parent::__construct();
		$this->model = new Member();
	}
	
	public function run()
	{
		parent::run();
	}
}
