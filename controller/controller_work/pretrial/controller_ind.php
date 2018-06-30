<?php
namespace Controller\Controller_work\Pretrial;
use Controller\ Controller_base as Controller_base;
use Model\ Model_user as Model_user;
use Model\ Model_debter as Model_debter;
use Helpers\ Validators\ WorkValidator as WorkValidator;
use Helpers\ DB\ DB as DB;
use Helpers\DB\Insert as Insert;
use Controller\ Controller_work\ Controller_stage as Controller_stage;
use Controller\ Controller_work\ Controller_last as Controller_last;
use Controller\ Controller_work\ Controller_pledged as Controller_pledged;
use Model\Work\Model_work_pretrial_individual as Model_work_pretrial_individual;


class Controller_ind extends Controller_base {
	protected static $pages = ['head','header','individual','footer'];
	private static $name = 'work';
	public function show($debter,$user,$stage) {
		if($debter and $user) {
			$id = $debter['id'];
			$data = ['debters_id'=>$id,'stage'=>$stage];
			$table = 'collection_stage';
			$insert = Model_work_pretrial_individual::insert($id,$stage,$data,$table);
			if($insert) {
					foreach ( self::$pages as $key ) {
			if ( $key == 'head' ) {
				self::render( self::$name, $key, [ 'css' => self::$css, 'js' => self::$js, 'favicon' => self::$favicon ] );
			} else if($key == 'individual') {
				self::render( self::$name . '/pretrial', $key );
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
			} else if($key == 'individual') {
				self::render( self::$name . '/pretrial', $key,['answer'=>$answer] );
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
			$number = WorkValidator::checkNumber($post['number_elseproperty']);
			if($number) {
				$id = $debter['id'];
				$contact = WorkValidator::getRadioMult($_POST,'contact');
				$pledged_property = WorkValidator::getRadioMult($_POST,'property');
				$data = ['debters_id'=>$id,'contact'=>$contact,'property'=>$number];
				$table = 'pretrial_stage_individual';
				$insert = Model_work_pretrial_individual::insertBroaden($id,$contact,$number,$data,$table);
				if($insert) {
					if($pledged_property == 'yes') {
						$controller = new Controller_pledged();
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
	
}









?>