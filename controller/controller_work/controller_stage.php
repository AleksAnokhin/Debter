<?php
namespace Controller\ Controller_work;
use Controller\ Controller_base as Controller_base;
use Model\ Model_user as Model_user;
use Model\ Model_debter as Model_debter;
use Helpers\ Validators\ WorkValidator as WorkValidator;
use Helpers\ DB\ DB as DB;
use Controller\ Controller_work\ Controller_params as Controller_params;

class Controller_stage extends Controller_base {
	protected static $pages = [ 'head', 'header', 'stage', 'footer' ];
	private static $name = 'work';

	public static function show( $post ) {
		if ( Model_user::checkUser() ) {
			if ( WorkValidator::checkNumber($post['number_main_debt']) and WorkValidator::checkNumber($post['number_persentage']) 
				and WorkValidator::checkNumber($post['number_forfeit']) and WorkValidator::checkNumber($post['number_reserves'])
				and $reason = WorkValidator::checkCheckBox($post) ) {
				if ( $debter = Model_debter::getByToken( $_SESSION[ 'debter' ] ) ) {
					$id = $debter[ 'id' ];
					$type = Model_debter::getType($id);
					$expiration = WorkValidator::getRadioValue( $post );
					$reason_of_delay = implode($reason);
					extract( $post );
					$data = [ 'debters_id' => $id, 'main_debt' => $number_main_debt, 'persentage' => $number_persentage, 'forfeit' => $number_forfeit, 'reserves' => $number_reserves, 'days_of_delay' => $number_days_of_delay, 'full_expiration' => $expiration, 'reason_of_delay' => $reason_of_delay ];
					$insert = Model_debter::insert( 'main_parameters', $data );
					if ( $insert ) {
						foreach ( self::$pages as $key ) {
							if ( $key == 'head' ) {
								self::render( self::$name, $key, [ 'css' => self::$css, 'js' => self::$js, 'favicon' => self::$favicon ] );
							} else if($key == 'stage'){
								self::render( self::$name . '/pages', $key,['type'=>$type] );
							}else { 
								self::render( self::$name, $key );
							}
						}
					} else {
						Controller_params::ShowAnswer( 'Не удалось записать данные' );
					}
				} else {
					unset( $_SESSION[ 'debter' ] );
					header( 'Location:index.php?route=main/start' );
				}
			} else {
				Controller_params::ShowAnswer( 'Ошибки в заполнении формы.' );
			}
		} else {
			header( 'Location:index.php' );
		}
	}
	public static function showAnswer($answer) {
		if(Model_user::checkUser()) {
			$debter = Model_debter::getByToken( $_SESSION[ 'debter' ] );
			$id = $debter[ 'id' ];
			$type = Model_debter::getType($id);
			foreach(self::$pages as $key) {

				if($key == 'head') {
					self::render( self::$name, $key, [ 'css' => self::$css, 'js' => self::$js, 'favicon' => self::$favicon ] );
				} else if($key == 'stage') {
					self::render(self::$name . '/pages',$key,['answer'=>$answer,'type'=>$type]);
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