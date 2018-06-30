<?php
namespace Helpers\DB;

class Update {
	
	private $table;
	private $values = '';
	private $where ='';
	private $db;
	
		public function __construct() {
		$this->db = DB::getDB();
	}
	
	public function setTable($table) {
	$this->table = DB::escape($table);
		return $this;
	}
	
	public function setWhere ($arr=[]) {
		foreach($arr as $key=>$val) {
			if(preg_match('/^[<>!=]/',$key)) {
				$key = preg_replace('/^[<>!=]{1,2}/','$1',$key);
				$this->where .= ' AND '.$val . ' ' . $key;
			} else {
				$this->where .= ' AND '. DB::escape($key) . '=' . "'" .DB::escape($val) . "'";
			}
		}
		return $this;
	}
	public function setValues($values=[]) {
		foreach($values as $key=>$val) {
		$this->values .= DB::escape($key) . "='" . DB::escape($val) . "',";
		//$this->values .= "$key = '$val', ";	
		}
		$this->values = rtrim($this->values,', ');
		return $this;
	}
	
	public function setRow(){
		
		$query = mysqli_query($this->db,"UPDATE {$this->table} SET {$this->values} WHERE 1 {$this->where}");
		return $query;
	}
}





?>