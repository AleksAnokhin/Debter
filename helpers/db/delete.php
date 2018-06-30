<?php
namespace Helpers\DB;

class Delete {
	
	private $table;
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
				$this->where .= ' AND '. DB::escape($val) . ' ' . "'" . DB::escape($key) . "'";
			} else {
				$this->where .= ' AND '. DB::escape($key) . '=' . "'" .$val . "'";
			}
		}
		return $this;
	}
	
	public function setRow() {
		$query = mysqli_query($this->db,"DELETE FROM {$this->table} WHERE 1 {$this->where}");
		return $query;
	}
	
	
}







?>