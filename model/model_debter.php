<?php
namespace model;
use Helpers\DB\Select as Select;
use Helpers\DB\Insert as Insert;
use Helpers\DB\Delete as Delete;
use Helpers\DB\Update as Update;
use Helpers\DB\DB as DB;
use Controller\Controller_work\Controller_type as Controller_type;

class Model_debter {
	protected $type;
	protected $token;
	protected $user;
	protected $name;
	protected $main_debt;
	protected $persentage;
	protected $forfeit;
	protected $reserves;
	protected $days_of_delay;
	protected $fullexpiration;
	protected $reason_of_delay;
	protected $stage;
	protected $contact;
	protected $property;
	protected $pledged_price;
	protected $pledged_liquidity;
	protected $pledged_will_to_sell;
	protected $finantial_analysis;
	protected $restructuring_readiness;
	protected $trial_prospects;
	protected $trial_term;
	
	public function getToken() {
		return $this->token;
	}
	public function __construct() {
		$this->token = getHash();
		return $this;
	}
	public function setUser($user_id) {
		if(is_numeric($user_id)) {
			$this->user = $user_id;
			return $this;
		}
	}
	public function setType($type) {
		if(strlen($type) > 1) {
			$this->type = htmlspecialchars($type);
			return $this;
		}
	}
	public function setName($name) {
		if(strlen($name) > 1) {
			$this->name = htmlspecialchars($name);
			return $this;
		}
	}
	public function create($obj) {
		$data = ['user_id'=>$this->user,'name'=>$this->name,'token'=>$this->token];
		$insert = (new Insert())->setTable('debters')->setColumns($data)->setValues($data)->setRow();
		if($insert) {
			$id = mysqli_insert_id(DB::getDB());
			$data = ['type'=>$this->type,'debters_id'=>$id];
			$insert = (new Insert())->setTable('type_of_debter')->setColumns($data)->setValues($data)->setRow();
			if($insert) {
				return true;
			} else {
				Controller_type::showAnswer('Не удалось сохранить данные!');
			}
		} else {
			Controller_type::showAnswer('Не удалось сохранить данные!');
		}
		
	}
	public static function getByToken($token) {
		$debter = (new Select())->setTable('debters')->setWhere(['token'=>$token])->setRow();
		if($debter) {
			return $debter;
		} else {
			return false;
		}
	}
	public static function insert($table,$data=[]) {
		$insert = (new Insert())->setTable($table)->setColumns($data)->setValues($data)->setRow();
		if($insert) {
			return true;
		} else {
			return false;
		}
	}
	public static function getType($id) {
		$type = (new Select())->setCol(['type'])->setTable('type_of_debter')->setWhere(['debters_id'=>$id])->setRow();
		if($type) {
			return $type['type'];
		}
	}
	public static function getStage($id) {
		$stage = (new Select())->setCol(['stage'])->setTable('collection_stage')->setWhere(['debters_id'=>$id])->setRow();
		if($stage) {
			return $stage['stage'];
		}
	}
	public static function getAnalysis($id) {
		$analysis = (new Select())->setCol(['analysis'])->setTable('pretrial_stage_entity')->setWhere(['debters_id'=>$id])->setRow();
		if($analysis) {
			return $analysis['analysis'];
		}
	}
	public static function getContact($id) {
		$contact = (new Select())->setCol(['contact'])->setTable('pretrial_stage_entity')->setWhere(['debters_id'=>$id])->setRow();
		if($contact) {
			return $contact['contact'];
		}
	}
	public static function deleteDebter($id) {
		$delete = (new Delete())->setTable('debters')->setWhere(['id'=>$id])->setRow();
		if($delete) {
			unset($_SESSION['debter']);
			return true;
		} else {
			return false;
		}
	}
	
}








?>