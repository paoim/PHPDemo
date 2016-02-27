<?php


class Controller
{
	protected $model;
	
	public function __construct()
	{
		//PrintUtil::display("I am inside " .__CLASS__);
		$this->model = new Model('member');
	}
	
	public function run()
	{
		//$this->_createNewMember();
		
		//$this->_updateMember();
		
		$Query = $this->model->query->select('first_name', 'last_name');
		//$Query->whereEQ('id', 1); // work
		$Query->whereEQ('first_name', 'Pao'); // work
		$Query->whereEQ('last_name', 'IM', 'or'); // work
		$Query->whereNEQ('id', 3); // work
		//$Query->whereNULL('first_name'); // need to test
		//$Query->whereNNULL('first_name'); //not work
		//$Query->whereNNULL('id'); // ot work
		$Query->orderBy(array('last_name' => 'Desc', 'first_name' => 'Asc'));
		//$Query->groupBy('FieldA', 'FieldB');
		//$Query->limit();
		$DataList = $Query->run();
		PrintUtil::display($DataList);
	}
	
	private function _createNewMember()
	{
		$data = array(
				'first_name'	=> 'Pao',
				'last_name'		=> 'IM',
				'user_name'		=> 'ip1234',
				'password'		=> '1234'
		);
		$this->model->query->insert($data);
	}
	
	private function _updateMember()
	{
		$data = array(
				'first_name'		=> "'Monneadam'",
				'last_name'			=> "'Sorn Im'"
		);
		$filters = array(
				'id'			=> 1,
				'user_name'		=> 'test1234'
		);
		$this->model->query->update($data, $filters);
	}
}
