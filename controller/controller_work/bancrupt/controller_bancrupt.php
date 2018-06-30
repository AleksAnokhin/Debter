<?php
namespace Controller\Controller_work\Bancrupt;
use Controller\ Controller_base as Controller_base;
use Model\ Model_user as Model_user;
use Model\ Model_debter as Model_debter;
use Helpers\ Validators\ WorkValidator as WorkValidator;
use Helpers\ DB\ DB as DB;
use Helpers\DB\Insert as Insert;
use Controller\ Controller_work\ Controller_stage as Controller_stage;
use Controller\ Controller_work\ Controller_last as Controller_last;
use Controller\ Controller_work\ Controller_trialpledged as Controller_trialpledged;
use Model\Work\Model_work_bancrupt as Model_work_bancrupt;

class Controller_bancrupt extends Controller_base {
	protected static $pages = ['head','header','bancrupt','bancruptnext','footer'];
	private static $name = 'work';
	
	public function show($debter,$user,$stage) {
		if($debter and $user) {
			$id = $debter['id'];
			$data = ['debters_id'=>$id,'stage'=>$stage];
			$table = 'collection_stage';
			$insert = Model_work_bancrupt::insert($id,$data,$table);
			if($insert) {
					foreach ( self::$pages as $key ) {
			if ( $key == 'head' ) {
				self::render( self::$name, $key, [ 'css' => self::$css, 'js' => self::$js, 'favicon' => self::$favicon ] );
			} else if($key == 'bancrupt') {
				self::render( self::$name . '/bancrupt', $key );
			} else if($key == 'bancruptnext') {
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
			} else if($key == 'bancrupt') {
				self::render( self::$name . '/bancrupt', $key,['answer'=>$answer] );
			} else if($key =='bancruptnext') {
				continue;
			} else {
				self::render( self::$name, $key );
			}
		}
		} else {
			header('Location:index.php');
		}
	}
	public static function showAnswerNext($debter,$user,$answer) {
		if($debter and $user) {
						foreach ( self::$pages as $key ) {
			if ( $key == 'head' ) {
				self::render( self::$name, $key, [ 'css' => self::$css, 'js' => self::$js, 'favicon' => self::$favicon ] );
			} else if($key == 'bancrupt') {
				continue;
			} else if($key =='bancruptnext') {
				self::render( self::$name . '/bancrupt', $key,['answer'=>$answer] );
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
			$miss = WorkValidator::getRadioMult($_POST,'miss');
			$id = $debter['id'];
			if($miss == 'yes') {
				$data = ['debters_id'=>$id,'total_summ'=>'0','real_summ'=>'0','terms'=>'0'];
				$table = 'bancrupts_stage';
				$insert = Model_work_bancrupt::insert($id,$data,$table);
				if($insert) {
					$controller = new Controller_last();
					$controller->simpleShow($debter,$user);
				} else {
					self::showAnswer($debter,$user,'Проблема с соханением данных');
				}
			} else if($miss == 'no') {
				
					foreach ( self::$pages as $key ) {
			if ( $key == 'head' ) {
				self::render( self::$name, $key, [ 'css' => self::$css, 'js' => self::$js, 'favicon' => self::$favicon ] );
			} else if($key == 'bancrupt') {
				continue;
			} else if($key == 'bancruptnext') {
				self::render( self::$name . '/bancrupt', $key );
			} else {
				self::render( self::$name, $key );
			}
		}	
			}
		} else {
			header('Location:index.php');
		}
	}
	public function proceedsecond($debter,$user,$post) {
		if($debter and $user) {
			if($total = WorkValidator::checkNumber($post['number_total']) and $real=WorkValidator::checkNumber($post['number_real']) ) {
				$id = $debter['id'];
				$terms = WorkValidator::getRadioMult($post,'term');
				$data = ['debters_id'=>$id,'total_summ'=>$total,'real_summ'=>$real,'terms'=>$terms];
				$table = 'bancrupts_stage';
				$insert = Model_work_bancrupt::insertBroaden($id,$total,$real,$terms,$data,$table);
				if($insert) {
					$controller = new Controller_last();
					$controller->simpleShow($debter,$user);
				} else {
					self::showAnswerNext($debter,$user,'Не удалось сохранить данные');
				}
			} else {
				self::showAnswerNext($debter,$user,'Не заполнены поля с параметрами требований кредитора');
			}
		} else {
			header('Location:index.php');
		}
	}
}

















?>