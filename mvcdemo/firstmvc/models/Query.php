<?php

require_once 'Database.php';

class Query
{
	public $sql;
	private $_table;
	private $_handler;
	private $_limitData;
	private $_havingData;
	private $_bindParams = array();
	private $_fieldParams = array();
	private $_groupFieldParams = array();
	private $_orderFieldParams = array();
	private $_filterWhereParams = array();
	
	public function __construct($table)
	{
		$this->_table = $table;
		$this->_handler = new Database(Config::DATABASE_SCHEMA, Config::DATABASE_USER_NAME, Config::DATABASE_PASSWORD);
		//PrintUtil::display($this->_handler->errorMessages);
	}
	
	public function insert(array $data)
	{
		if (isset($this->_table)) {
			$this->_handler->create($this->_table, $data);
		}
		return $this;
	}
	
	public function update(array $data, array $filters)
	{
		if (isset($this->_table)) {
			$this->_handler->update($this->_table, $data, $filters);
		}
		return $this;
	}
	
	public function delete(array $filters)
	{
		if (isset($this->_table)) {
			$this->_handler->delete($this->_table, $filters);
		}
		return $this;
	}
	
	public function run()
	{
		$resultData = null;
		if (isset($this->_table)) {
			$fieldData = '*';
			if (count($this->_fieldParams)) {
				$fieldData = implode(',', $this->_fieldParams);
			}
			$whereData = '';
			if (count($this->_filterWhereParams)) {
				$whereData = implode(' ', $this->_filterWhereParams);
				$whereData = substr($whereData, 3);
				$whereData = 'where '. trim($whereData);
			}
			$groupData = '';
			if (count($this->_groupFieldParams)) {
				$groupData = 'group by '. implode(',', $this->_groupFieldParams);
			}
			$orderByData = '';
			if (count($this->_orderFieldParams)) {
				$orderByData = 'order by '. implode(',', $this->_orderFieldParams);
			}
			$limit = (isset($this->_limitData)) ? $this->_limitData : '';
			$this->sql = "select $fieldData from {$this->_table} $whereData $groupData {$this->_havingData} $orderByData $limit";
			
			$bindDataParams = count($this->_bindParams) ? $this->_bindParams : array();
			$resultData = $this->_handler->prepare($this->sql, $bindDataParams);
			
			//PrintUtil::display($whereData);
			//PrintUtil::display($this->sql);
			//PrintUtil::display($resultData);
		}
		return $resultData;
	}
	
	public function select()
	{
		$params = func_get_args();
		if (count($params)) {
			foreach ($params as $param) {
				$data = trim($param);
				if (strlen($data))
					$this->_fieldParams[] = strtolower($data);
			}
		}
		return $this;
	}
	
	public function whereNULL($field, $operator = 'and')
	{
		$this->_bindParams[$field] = 'NULL';
		$this->_filterWhereParams[] = "$operator $field is :$field";
		return $this;
	}
	
	public function whereNNULL($field, $operator = 'and')
	{
		$this->_bindParams[$field] = 'NULL';
		$this->_filterWhereParams[] = "$operator $field is not :$field";
		return $this;
	}
	
	public function whereEQ($field, $value, $operator = 'and')
	{
		$this->_bindParams[$field] = $value;
		$this->_filterWhereParams[] = "$operator $field = :$field";
		return $this;
	}
	
	public function whereNEQ($field, $value, $operator = 'and')
	{
		$this->_bindParams[$field] = $value;
		$this->_filterWhereParams[] = "$operator $field != :$field";
		return $this;
	}
	
	public function whereLT($field, $value, $operator = 'and')
	{
		$this->_bindParams[$field] = $value;
		$this->_filterWhereParams[] = "$operator $field < :$field";
		return $this;
	}
	
	public function whereLE($field, $value, $operator = 'and')
	{
		$this->_bindParams[$field] = $value;
		$this->_filterWhereParams[] = "$operator $field <= :$field";
		return $this;
	}
	
	public function whereGT($field, $value, $operator = 'and')
	{
		$this->_bindParams[$field] = $value;
		$this->_filterWhereParams[] = "$operator $field > :$field";
		return $this;
	}
	
	public function whereGE($field, $value, $operator = 'and')
	{
		$this->_bindParams[$field] = $value;
		$this->_filterWhereParams[] = "$operator $field >= :$field";
		return $this;
	}
	
	public function groupBy()
	{
		$params = func_get_args();
		if (count($params)) {
			foreach ($params as $param) {
				$data = trim($param);
				if (strlen($data))
					$this->_groupFieldParams[] = strtolower($data);
			}
		}
		return $this;
	}
	
	public function having(array $filters)
	{
		$this->_havingData = '';
		if (count($filters)) {
			$havingFieldParams = array();
			foreach ($filters as $values) {
				foreach ($values as $data) {
					$havingFieldParams[] = $data['Field'] . ' ' . $data['Operator'] . ' ' . $data['Value']; // count(id) > 10
				}
			}
			if (count($havingFieldParams)) {
				$this->_havingData = 'having ' .implode(',', $havingFieldParams);
			}
		}
		return $this;
	}
	
	public function orderBy(array $filters)
	{
		if (count($filters)) {
			foreach ($filters as $field => $filter) { // $filter should be ASC|DESC
				$this->_orderFieldParams[] = strtolower($field) . ' ' . strtolower($filter);
			}
		} else {
			//Order by ID desc
			$this->_orderFieldParams[] = 'id desc';
		}
		return $this;
	}
	
	public function limit($number = 1)
	{
		$this->_limitData = "limit $number";
		return $this;
	}
}
