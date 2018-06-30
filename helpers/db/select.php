<?php
namespace Helpers\DB;

class Select {
	private $col = '*';
	private $table = '';
	private $where = '';
	private $innerjoin = '';
	private $groupBy= '';
	private $having='';
	private $order = '';
	private $limits = '';
	private $db;
	private $leftjoin = '';
	
	public function __construct() {
		$this->db = DB::getDB();
	}
	
	public function setCol($arr=[]) {
		$this->col='';
		foreach($arr as $key=>$val) {
			$this->col .= DB::escape($val); 
			if(!is_numeric($key)) {
				$this->col .= ' AS '. DB::escape($key);
			}
			$this->col .= ', ';
		}
		$this->col = rtrim($this->col,', ');
		return $this;
	}
	
	public function setTable($table) {
	$this->table = DB::escape($table);
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
	public function setInnerJoin($cond=[],$tables=[]) {
		$this->innerjoin .='INNER JOIN ';
		for($i = 0; $i < sizeof($tables);$i++) {
			$this->innerjoin .= $tables[$i];
			foreach($cond as $key=>$val) {
				if($key == $tables[$i]) {
					$this->innerjoin .= ' ON '. DB::escape($val) . ' INNER JOIN ';
				}
			}
		}
		$this->innerjoin = rtrim($this->innerjoin, ' INNER JOIN ');
		return $this;
	}
	public function setLeftJoin($cond=[],$tables=[]) {
		$this->leftjoin .='LEFT JOIN ';
		for($i = 0; $i < sizeof($tables);$i++) {
			$this->leftjoin .= $tables[$i];
			foreach($cond as $key=>$val) {
				if($key == $tables[$i]) {
					$this->leftjoin .= ' ON '. DB::escape($val) . ' LEFT JOIN ';
				}
			}
		}
		$this->leftjoin = rtrim($this->leftjoin, ' LEFT JOIN ');
		return $this;
	}
	public function setGroupBy($col) {
		$col = DB::escape($col);
		$this->groupBy .= ' GROUP BY '.$col;
		return $this;
	}
	public function setHaving($func,$col,$cond=[]) {
		$col = DB::escape($col);
		$this->having .= ' HAVING '.$func . '('. $col . ') ';
		for($i = 0; $i < sizeof($cond);$i++) {
			$this->having .= $cond[$i]. ' ';
		}
		return $this;
	}
	public function setOrderBy($col,$sort){
		$col = DB::escape($col);
		$this->order .= ' ORDER BY '.$col . ' '.$sort;
		return $this;
	}
	public function setLimits($num,$offset) {
		if($offset !== 0) {
			$this->limits .= ' LIMIT ' .$num . ' OFFSET ' . $offset;
		} else {
			$this->limits .= ' LIMIT '. $num;
		}
		return $this;
	}
	
	public function setRow() {
		$query = mysqli_query($this->db, "SELECT {$this->col} FROM {$this->table} {$this->leftjoin} {$this->innerjoin}
		WHERE 1 {$this->where} {$this->groupBy} {$this->having} {$this->order} {$this->limits}");
		if($query) {
		$query = mysqli_fetch_assoc($query);
		return $query;
		} else {
			return false;
		}
	}
    public function setRowAll() {
        $query = mysqli_query($this->db, "SELECT {$this->col} FROM {$this->table} {$this->innerjoin}
		{$this->leftjoin} WHERE 1 {$this->where} {$this->groupBy} {$this->having} {$this->order} {$this->limits}");
        if($query) {
            $query = mysqli_fetch_all($query,MYSQLI_ASSOC);
            return $query;
        } else {
            return false;
        }
    }
}

















?>