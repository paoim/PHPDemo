<?php

class Database
{
	private $_host;
	private $_user;
	private $_pass;
	private $_dbname;
	private $_charset;
	
	private $_table;
	private $_filters = array();
	
	protected $dbHandler;
	public $errorMessages = array();
	
	public function __construct($dbname, $user, $pass, $host = 'localhost', $charset = 'utf8')
	{
		$this->_host = $host;
		$this->_user = $user;
		$this->_pass = $pass;
		$this->_dbname = $dbname;
		$this->_charset = $charset;
		//Connect to Database by using PDO
		$this->_connectDb();
	}
	
	public function create($table, $data)
	{
		$fields = array();
		$bindParams = array();
		$valueFields = array();
		if (empty($table) || !count($data)) {
			if (empty($table)) {
				$this->errorMessages[]['Message'] = "Error - there is no table to insert, please input it.";
			}
			$this->errorMessages[]['Message'] = "Error - cannot insert new data into $table because there is no fields to insert.";
			die();
		}
		foreach ($data as $key => $value) {
			$fields[] = $key;
			$valueFields[] = ":$key";
			$bindParams[$key] = $value;
		}
		$fieldList = implode(',', $fields);
		$valueFieldList = implode(',', $valueFields);
		$sql = "insert into $table ($fieldList) values($valueFieldList)";
		$this->prepare($sql, $bindParams, false);
			
		// clear
		unset($sql);
		unset($fields);
		unset($fieldList);
		unset($bindParams);
		unset($valueFields);
		unset($valueFieldList);
			
		// keep for query data as chain of method
		$this->_table = $table;
			
		return $this;
	}
	
	public function update($table, $data, $filters)
	{
		$criteria = array();
		$bindParams = array();
		$colunmPairs = array();
		if (empty($table) || (!count($filters) && !count($data))) {
			if (empty($table)) {
				$this->errorMessages[]['Message'] = "Error - there is no table to update, please input it.";
			}
			$this->errorMessages[]['Message'] = "Error - cannot update $table because there is no fields and criteria to update.";
			die();
		}
		foreach ($filters as $key => $value) {
			$criteria[] = "$key = :$key";
			$bindParams[$key] = $value;
		}
		foreach ($data as $key => $value) {
			$colunmPairs[] = "$key = $value";
		}
		$filterWhere = implode(' and ', $criteria);
		$colunmField = implode(',', $colunmPairs);
		$sql = "update $table set $colunmField where $filterWhere";
		$this->prepare($sql, $bindParams, false);
			
		// clear
		unset($sql);
		unset($criteria);
		unset($bindParams);
		unset($filterWhere);
		unset($colunmField);
		unset($colunmPairs);
			
		// keep for query data as chain of method
		$this->_table = $table;
		$this->_filters = $filters;
			
		return $this;
	}
	
	public function delete($table, $filters)
	{
		$criteria = array();
		$bindParams = array();
		if (empty($table) || !count($filters)) {
			if (empty($table)) {
				$this->errorMessages[]['Message'] = "Error - there is no table to delete, please input it.";
			}
			$this->errorMessages[]['Message'] = "Error - cannot delete from $table because there is no criteria to delete.";
			die();
		}
		foreach ($filters as $key => $value) {
			$criteria[] = "$key = :$key";
			$bindParams[$key] = $value;
		}
		$filterWhere = implode(' and ', $criteria);
		$sql = "delete from $table where $filterWhere";
		$this->prepare($sql, $bindParams, false);
			
		// clear
		unset($sql);
		unset($criteria);
		unset($bindParams);
		unset($filterWhere);
			
		// keep for query data as chain of method
		$this->_table = $table;
		$this->_filters = $filters;
			
		return $this;
	}
	
	public function getCurrentData($fetchMode = PDO::FETCH_OBJ)
	{
		$result = $this->get($this->_table, $this->_filters, $fetchMode);
		return $result;
	}
	
	public function getAllData($fetchMode = PDO::FETCH_OBJ)
	{
		$results = $this->getAll($this->_table, $fetchMode);
		return $results;
	}
	
	/**
	 *
	 * @param string $table
	 * @param array $filters
	 * @param const $fetchMode
	 */
	public function get($table, $filters, $fetchMode = PDO::FETCH_OBJ)
	{
		$data = null;
		$criteria = array();
		$bindParams = array();
		$table = empty($table) ? $this->_table : $table;
		$filters = !count($filters) ? $this->_filters : $filters;
			
		if (empty($table)|| !count($filters)) {
			if (empty($table)) {
				$this->errorMessages[]['Message'] = "Error - there is no table to query, please input it.";
			}
			$this->errorMessages[]['Message'] = "Error - cannot query from $table because there is no criteria to query.";
			die();
		}
		foreach ($filters as $key => $value) {
			$criteria[] = "$key = :$key";
			$bindParams[$key] = $value;
		}
		$filterWhere = implode(' and ', $criteria);
		$sql = "select * from $table where $filterWhere limit 1";
		$rowList = $this->prepare($sql, $bindParams, true, $fetchMode);
		$data = (isset($rowList[0])) ? $rowList[0] : null;
			
		// clear
		unset($sql);
		unset($rowList);
		unset($criteria);
		unset($bindParams);
		unset($filterWhere);
			
		return $data;
	}
	
	public function getAll($table, $fetchMode = PDO::FETCH_OBJ)
	{
		$bindParams = array();
		$table = empty($table) ? $this->_table : $table;
		if (empty($table)) {
			$this->errorMessages[]['Message'] = "Error - there is no table to query, please input it.";
			die();
		}
		$rowList = $this->prepare("select * from $table", $bindParams, true, $fetchMode);
		return $rowList;
	}
	
	/**
	 * Using prepared statements will help protect you from SQL injection.
	 * @param string $sql
	 * @param array $bindParams
	 * @param boolean $isSelected
	 * @param const $fetchMode
	 */
	public function prepare($sql, $bindParams = array(), $isSelected = true, $fetchMode = PDO::FETCH_OBJ)
	{
		$rowList = array();
		if (empty($sql)) {
			$this->errorMessages[]['Message'] = "Error - there is no sql query, please input it.";
			die();
		}
		
		//PrintUtil::display($sql);
		//PrintUtil::display($bindParams);
		
		try {
			// Use PDO Prepare Statement
			$query = $this->dbHandler->prepare($sql);
			$query->execute($bindParams);
		} catch (Exception $e) {
			$this->errorMessages[] = array(
					'Code'		=> $e->getCode(),
					'Line'		=> $e->getLine(),
					'Message'	=> $e->getMessage()
			);
		}
			
		//Fetch Results
		if ($isSelected) { //only for select sql query
			$query->setFetchMode($fetchMode);
			while($row = $query->fetch()) {
				$rowList[] = $row;
			}
		}
		return $rowList;
	}
	
	/**
	 * PDO - PHP Data Objects - is a database access layer providing a uniform method of access to multiple databases.
	 */
	private function _connectDb()
	{
		try {
			$dsn = "mysql:host={$this->_host};dbname={$this->_dbname};charset={$this->_charset}";
			$this->dbHandler = new PDO($dsn, $this->_user, $this->_pass);
		} catch (PDOException $e) {
			$this->errorMessages[] = array(
					'Code'		=> $e->getCode(),
					'Line'		=> $e->getLine(),
					'Message'	=> $e->getMessage()
			);
		}
	}
}
