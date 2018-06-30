<?php
namespace Controller\Controller_work\Pretrial;
use Controller\ Controller_base as Controller_base;
use Model\ Model_user as Model_user;
use Model\ Model_debter as Model_debter;
use Helpers\ Validators\ WorkValidator as WorkValidator;
use Helpers\DB\Insert as Insert;
use Helpers\DB\Update as Update;
use Helpers\ DB\ DB as DB;
use Controller\Controller_work\Controller_last as Controller_last;
use Controller\Controller_work\Controller_pledged as Controller_pledged;
use Model\Work\Model_work_pretrial_ent as Model_work_pretrial_ent;

class Controller_ent extends Controller_base {
	protected static $pages = ['head','header','entity','entity_next','footer'];
	private static $name = 'work';
	
	public function show($debter,$user,$stage) {
		if($debter and $user) {
			$id = $debter['id'];
			$data = ['debters_id'=>$id,'stage'=>$stage];
			$table = 'collection_stage';
			$insert = Model_work_pretrial_ent::insert($id,$stage,$data,$table);
			if($insert) {
					foreach ( self::$pages as $key ) {
			if ( $key == 'head' ) {
				self::render( self::$name, $key, [ 'css' => self::$css, 'js' => self::$js, 'favicon' => self::$favicon ] );
			} else if($key == 'entity') {
				self::render( self::$name . '/pretrial', $key );
			} else if($key == 'entity_next') {
				continue;
			} else {
				self::render( self::$name, $key );
			}
		}
			} else {
				Controller_stage::showAnswer('Проблема с сохранением данных.');
			}
		} else {
			header('Location:index.php');
		}
	}
	public static function showAnswer($debter,$user,$answer) {
		if($debter and $user) {
						foreach ( self::$pages as $key ) {
			if ( $key == 'head' ) {
				self::render( self::$name, $key, [ 'css' => self::$css, 'js' => self::$js, 'favicon' => self::$favicon ] );
			} else if($key == 'entity') {
				self::render( self::$name . '/pretrial', $key,['answer'=>$answer] );
			} else if($key=='entity_next') {
				continue;
			} else {
				self::render( self::$name, $key );
			}
		}
		} else {
			header('Location:index.php');
		}
	}
	public static function showNextAnswer($debter,$user,$analysis,$contact,$answer) {
		if($debter and $user) {
						foreach ( self::$pages as $key ) {
			if ( $key == 'head' ) {
				self::render( self::$name, $key, [ 'css' => self::$css, 'js' => self::$js, 'favicon' => self::$favicon ] );
			} else if($key == 'entity') {
				continue;
			} else if($key=='entity_next') {
				self::render( self::$name . '/pretrial', $key,['analysis'=>$analysis,'contact'=>$contact,'answer'=>$answer] );
			} else {
				self::render( self::$name, $key );
			}
		}
		} else {
			header('Location:index.php');
		}
	}
	
	public function proceedfirst($debter,$user,$post) {
		if($debter and $user) {
			$contact = WorkValidator::getRadioMult($post,'contact');
			$analysis = WorkValidator::getRadioMult($post,'finance');
			$id = $debter['id'];
			if($analysis == 'yes') {
				$data = ['debters_id'=>$id,'analysis'=>$analysis,'contact'=>$contact];
				$table = 'pretrial_stage_entity';
				$insert = Model_work_pretrial_ent::insertBroaden($id,$analysis,$contact,$data,$table);
				if($insert){
					self::proceedsecond($debter,$user,$analysis,$contact);
				} else {
					self::showAnswer($debter,$user,'Не удалось записать данные.');
				}
				
			} else {
				$data = ['debters_id'=>$id,'analysis'=>$analysis,'contact'=>$contact,'restructuring_readiness'=>'no'];
                $table = 'pretrial_stage_entity';
				$insert = Model_work_pretrial_ent::insertBroaden($id,$analysis,$contact,$data,$table);
				if($insert) {
					self::proceedsecond($debter,$user,$analysis,$contact);
				} else {
					self::showAnswer($debter,$user,'Не удалось записать данные.');
				}
			}
			
		} else {
			header('Location:index.php');
		}
	}
	public static function proceedsecond($debter,$user,$analysis,$contact) {
		if($debter and $user) {
					foreach ( self::$pages as $key ) {
			if ( $key == 'head' ) {
				self::render( self::$name, $key, [ 'css' => self::$css, 'js' => self::$js, 'favicon' => self::$favicon ] );
			} else if($key=='entity') {
				continue;
			} else if($key == 'entity_next') {
				self::render( self::$name . '/pretrial', $key,['analysis'=>$analysis,'contact'=>$contact] );
			} else  {
				self::render( self::$name, $key );
			}
		}
			
		} else {
			header('Location:index.php');
		}
	}
	public static function proceedthird($debter,$user,$post,$analysis,$contact) {
		
		$property = WorkValidator::checkNumber($post['number_elseproperty']);
		

		if($property) {
		if($debter and $user) {
			$id = $debter['id'];
			$finresult = 'no';
			$restructuring_readiness = 'no';
			if($analysis == 'yes') {
				$finresult = WorkValidator::getRadioMult($post,'result');
			}
			if($contact == 'yes') {
				$restructuring_readiness = WorkValidator::getRadioMult($post,'restruct');
			}
			$pledged_property = WorkValidator::getRadioMult($post,'property');
			$data = ['analysis'=>$finresult,'restructuring_readiness'=>$restructuring_readiness,'property'=>$property];
			$table = 'pretrial_stage_entity';
			$update = Model_work_pretrial_ent::update($id,$finresult,$restructuring_readiness,$property,$data,$table);
			if($update) {
				if($pledged_property == 'yes') {
					$controller = new Controller_pledged();
					$controller->show($debter,$user);
				} else {
					$controller = new Controller_last();
					$controller->simpleShow($debter,$user);
				}
				
			} else {
				self::showNextAnswer($debter,$user,$analysis,$contact,'Не удалось записать данные');
			}
		} else {
			header('Location:index.php');
		}
	} else {
			self::showNextAnswer($debter,$user,$analysis,$contact,'Не заполнено поле имущество должника');
		}
	}
}










?>