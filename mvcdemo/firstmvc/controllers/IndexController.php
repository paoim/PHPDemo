<?php


class IndexController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function run()
	{
		PrintUtil::display("I am inside " .__METHOD__);
		PrintUtil::display(func_get_args());
	}
}
