<?php
namespace Controller\Controller_work;
use Controller\ Controller_base as Controller_base;
use Model\Model_user as Model_user;
use Model\Model_debter as Model_debter;
use Helpers\Validators\ WorkValidator as WorkValidator;
use Helpers\DB\DB as DB;
use Helpers\DB\Insert as Insert;
use Controller\Controller_work\Controller_pledged as Controller_pledged;
use Controller\Controller_work\Controller_trialpledged as Controller_trialpledged;
class Controller_last extends Controller_base {
	protected static $pages = [ 'head', 'header', 'final', 'footer' ];
	private static $name = 'work';

	public function show( $debter, $user,$post ) {
		if ( $debter and $user ) {
			if($price = WorkValidator::checkNumber($post['number_pledgedprice'])) {
				$liquidity = WorkValidator::getRadioMult($post,'liquidity');
				$will_to_sell =  WorkValidator::getRadioMult($post,'will');
				$id = $debter['id'];
				$data = ['debters_id'=>$id,'price'=>$price,'liquidity'=>$liquidity,'will_to_sell'=>$will_to_sell];
				$insert = (new Insert())->setTable('pledged_property')->setColumns($data)->setValues($data)->setRow();
				if($insert) {
					foreach ( self::$pages as $key ) {
				if ( $key == 'head' ) {
					self::render( self::$name, $key, [ 'css' => self::$css, 'js' => self::$js, 'favicon' => self::$favicon ] );
				} else {
					self::render( self::$name, $key );
				}
			}
				} else {
					Controller_pledged::showAnswer($debter,$user,'Не удалось записать данные');
				}
			} else {
				Controller_pledged::showAnswer($debter,$user,'Не заполнено поле стоимость заложенного имущества');
			}
		} else {
			header( 'Location:index.php' );
		}
	}
	public function showTrial( $debter, $user,$post ) {
		if ( $debter and $user ) {
			if($price = WorkValidator::checkNumber($post['number_pledgedprice'])) {
				$liquidity = WorkValidator::getRadioMult($post,'liquidity');
				$id = $debter['id'];
				$data = ['debters_id'=>$id,'price'=>$price,'liquidity'=>$liquidity];
				$insert = (new Insert())->setTable('trial_pledged_property')->setColumns($data)->setValues($data)->setRow();
				if($insert) {
					foreach ( self::$pages as $key ) {
				if ( $key == 'head' ) {
					self::render( self::$name, $key, [ 'css' => self::$css, 'js' => self::$js, 'favicon' => self::$favicon ] );
				} else {
					self::render( self::$name, $key );
				}
			}
				} else {
					Controller_trialpledged::showAnswer($debter,$user,'Не удалось записать данные');
				}
			} else {
				Controller_trialpledged::showAnswer($debter,$user,'Не заполнено поле стоимость заложенного имущества');
			}
		} else {
			header( 'Location:index.php' );
		}
	}
	public function simpleShow($debter,$user) {
		if($debter and $user) {
			foreach ( self::$pages as $key ) {
				if ( $key == 'head' ) {
					self::render( self::$name, $key, [ 'css' => self::$css, 'js' => self::$js, 'favicon' => self::$favicon ] );
				} else {
					self::render( self::$name, $key );
				}
			}
		} else {
			header( 'Location:index.php' );
		}
	}
	
}









?>