<?php
namespace Helpers\DB;

class Insert {
	private $table;
	private $columns = '';
	private $values = '';
	private $db;

	
	public function __construct() {
		$this->db = DB::getDB();
	}
	
	public function setTable($table) {
		$this->table = DB::escape($table);
		return $this;
	}
	public function setColumns($col=[]) {
		$this->columns .= ' (';
		foreach($col as $key=>$val) {
		$this->columns .= DB::escape($key) . ', ';
	}
		$this->columns = rtrim($this->columns,', ');
		$this->columns .= ') ';
		return $this;
	}
	public function setValues($data=[]) {
		$this->values .= ' (';
		foreach($data as $key=>$val) {
			if(!is_numeric($key)) {
				$this->values .= "'" .DB::escape($val) . "',";
			} else {
				$this->values .=  DB::escape($val) . ",";
			}
			
		}
		$this->values = rtrim($this->values,', ');
		$this->values .= ') ';
		return $this;
	}
	public function setWhere ($arr=[]) {
		foreach($arr as $key=>$val) {
			if(preg_match('/^[<>!=]/',$key)) {
				$key = preg_replace('/^[<>!=]{1,2}/','$1',$key);
				$this->where .= ' AND '.DB::escape($val) . ' ' . "'". DB::escape($key) . "'";
			} else {
				$this->where .= ' AND '. DB::escape($key) . '=' . "'". DB::escape($val) . "'";
			}
		}
		return $this;
	}
	
	public function setRow() {
		$query= mysqli_query($this->db,"INSERT INTO {$this->table} {$this->columns} VALUES {$this->values};");
		return $query;
	}
	
}


?>