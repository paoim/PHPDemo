<?php

namespace {
	class Database
	{
		private $_host;
		private $_user;
		private $_pass;
		private $_dbname;
		private $_charset;
		
		private $_entity;
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
		
		public function create($entity, $data)
		{
			$fields = array();
			$bindParams = array();
			$valueFields = array();
			if (empty($entity) || !count($data)) {
				if (empty($entity)) {
					$this->errorMessages[]['Message'] = "Error - there is no table to insert, please input it.";
				}
				$this->errorMessages[]['Message'] = "Error - cannot insert new data into $entity because there is no fields to insert.";
				die();
			}
			foreach ($data as $key => $value) {
				$fields[] = $key;
				$valueFields[] = ":$key";
				$bindParams[$key] = $value;
			}
			$fieldList = implode(',', $fields);
			$valueFieldList = implode(',', $valueFields);
			$sql = "insert into $entity ($fieldList) values($valueFieldList)";
			$this->_prepare($sql, $bindParams, false);
			
			// clear
			unset($sql);
			unset($fields);
			unset($fieldList);
			unset($bindParams);
			unset($valueFields);
			unset($valueFieldList);
			
			// keep for query data as chain of method
			$this->_entity = $entity;
			
			return $this;
		}
		
		public function update($entity, $data, $filters)
		{
			$criteria = array();
			$bindParams = array();
			$colunmPairs = array();
			if (empty($entity) || (!count($filters) && !count($data))) {
				if (empty($entity)) {
					$this->errorMessages[]['Message'] = "Error - there is no table to update, please input it.";
				}
				$this->errorMessages[]['Message'] = "Error - cannot update $entity because there is no fields and criteria to update.";
				die();
			}
			foreach ($filters as $key => $value) {
				$criteria[] = "$key = :$key";
				$bindParams[$key] = $value;
			}
			foreach ($data as $key => $value) {
				$colunmPairs[] = "$key = $value";
			}
			$filterWhere = implode(',', $criteria);
			$colunmField = implode(',', $colunmPairs);
			$sql = "update $entity set $colunmField where $filterWhere";
			$this->_prepare($sql, $bindParams, false);
			
			// clear
			unset($sql);
			unset($criteria);
			unset($bindParams);
			unset($filterWhere);
			unset($colunmField);
			unset($colunmPairs);
			
			// keep for query data as chain of method
			$this->_entity = $entity;
			$this->_filters = $filters;
			
			return $this;
		}
		
		public function delete($entity, $filters)
		{
			$criteria = array();
			$bindParams = array();
			if (empty($entity) || !count($filters)) {
				if (empty($entity)) {
					$this->errorMessages[]['Message'] = "Error - there is no table to delete, please input it.";
				}
				$this->errorMessages[]['Message'] = "Error - cannot delete from $entity because there is no criteria to delete.";
				die();
			}
			foreach ($filters as $key => $value) {
				$criteria[] = "$key = :$key";
				$bindParams[$key] = $value;
			}
			$filterWhere = implode(',', $criteria);
			$sql = "delete from $entity where $filterWhere";
			$this->_prepare($sql, $bindParams, false);
			
			// clear
			unset($sql);
			unset($criteria);
			unset($bindParams);
			unset($filterWhere);
			
			// keep for query data as chain of method
			$this->_entity = $entity;
			$this->_filters = $filters;
			
			return $this;
		}
		
		public function getCurrentData($fetchMode = PDO::FETCH_OBJ)
		{
			$result = $this->get($this->_entity, $this->_filters, $fetchMode);
			return $result;
		}
		
		public function getAllData($fetchMode = PDO::FETCH_OBJ)
		{
			$results = $this->getAll($this->_entity, $fetchMode);
			return $results;
		}
		
		/**
		 * 
		 * @param string $entity
		 * @param array $filters
		 * @param const $fetchMode
		 */
		public function get($entity, $filters, $fetchMode = PDO::FETCH_OBJ)
		{
			$data = null;
			$criteria = array();
			$bindParams = array();
			$entity = empty($entity) ? $this->_entity : $entity;
			$filters = !count($filters) ? $this->_filters : $filters;
			
			if (empty($entity)|| !count($filters)) {
				if (empty($entity)) {
					$this->errorMessages[]['Message'] = "Error - there is no table to query, please input it.";
				}
				$this->errorMessages[]['Message'] = "Error - cannot query from $entity because there is no criteria to query.";
				die();
			}
			foreach ($filters as $key => $value) {
				$criteria[] = "$key = :$key";
				$bindParams[$key] = $value;
			}
			$filterWhere = implode(',', $criteria);
			$sql = "select * from $entity where $filterWhere limit 1";
			$rowList = $this->_prepare($sql, $bindParams, true, $fetchMode);
			$data = (isset($rowList[0])) ? $rowList[0] : null;
			
			// clear
			unset($sql);
			unset($rowList);
			unset($criteria);
			unset($bindParams);
			unset($filterWhere);
			
			return $data;
		}
		
		public function getAll($entity, $fetchMode = PDO::FETCH_OBJ)
		{
			$bindParams = array();
			$entity = empty($entity) ? $this->_entity : $entity;
			if (empty($entity)) {
				$this->errorMessages[]['Message'] = "Error - there is no table to query, please input it.";
				die();
			}
			$rowList = $this->_prepare("select * from $entity", $bindParams, true, $fetchMode);
			return $rowList;
		}
		
		/**
		 * Using prepared statements will help protect you from SQL injection.
		 * @param string $sql
		 * @param array $bindParams
		 * @param boolean $isSelected
		 * @param const $fetchMode
		 */
		private function _prepare($sql, $bindParams = array(), $isSelected = true, $fetchMode = PDO::FETCH_OBJ)
		{
			$rowList = array();
			if (empty($sql)) {
				$this->errorMessages[]['Message'] = "Error - there is no sql query, please input it.";
				die();
			}
			
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
}
