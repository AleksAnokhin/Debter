<?php
namespace Controller\Controller_work\Trial;
use Controller\ Controller_base as Controller_base;
use Model\ Model_user as Model_user;
use Model\ Model_debter as Model_debter;
use Helpers\ Validators\ WorkValidator as WorkValidator;
use Helpers\ DB\ DB as DB;
use Helpers\DB\Insert as Insert;
use Controller\ Controller_work\ Controller_stage as Controller_stage;
use Controller\ Controller_work\ Controller_last as Controller_last;
use Controller\ Controller_work\ Controller_trialpledged as Controller_trialpledged;
use Model\Work\Model_work_trial as Model_work_trial;

class Controller_trial extends Controller_base {
	protected static $pages = ['head','header','trialmain','footer'];
	private static $name = 'work';
	
	public function show($debter,$user,$stage) {
		if($debter and $user) {
			$id = $debter['id'];
			$data = ['debters_id'=>$id,'stage'=>$stage];
			$table = 'collection_stage';
			$insert = Model_work_trial::insert($id,$stage,$data,$table);
			if($insert) {
					foreach ( self::$pages as $key ) {
			if ( $key == 'head' ) {
				self::render( self::$name, $key, [ 'css' => self::$css, 'js' => self::$js, 'favicon' => self::$favicon ] );
			} else if($key == 'trialmain') {
				self::render( self::$name . '/trial', $key );
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
	public function proceedfirst($debter,$user,$post) {
		if($debter and $user) {
			$property = WorkValidator::checkNumber($post['number_elseproperty']);
			if($property) {
				$id = $debter['id'];
				$prospects = WorkValidator::getRadioMult($_POST,'perspective');
				$terms = WorkValidator::getRadioMult($_POST,'time');
				$pledged_property = WorkValidator::getRadioMult($_POST,'pledged');
				$data = ['debters_id'=>$id,'prospects'=>$prospects,'terms'=>$terms,'property'=>$property];
				$table = 'trial_stage';
				$insert = Model_work_trial::insertBroaden($id,$terms,$property,$data,$table);
				if($insert) {
					if($pledged_property == 'yes') {
						$controller = new Controller_trialpledged();
						$controller->show($debter,$user);
					} else {
						$controller = new Controller_last();
						$controller->simpleShow($debter,$user);
					}
				} else {
					self::showAnswer($debter,$user,'Не удалось записать данные');
				}
			} else {
				self::showAnswer($debter,$user,'Не заполнено поле стоимости имущества');
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
			} else if($key == 'trialmain') {
				self::render( self::$name . '/trial', $key,['answer'=>$answer] );
			} else {
				self::render( self::$name, $key );
			}
		}
		} else {
			header('Location:index.php');
		}
	}
	
}














?>