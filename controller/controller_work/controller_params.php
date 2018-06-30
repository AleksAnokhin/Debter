<?php

namespace Controller\ Controller_work;
use Controller\ Controller_base as Controller_base;
use Model\ Model_user as Model_user;
use Model\ Model_debter as Model_debter;
use Helpers\ Validators\ WorkValidator as WorkValidator;
use Controller\ Controller_work\ Controller_type as Controller_type;

class Controller_params extends Controller_base {
	protected static $pages = [ 'head', 'header', 'params', 'footer' ];
	private static $name = 'work';

	public static function show($post) {
		if ( $user = Model_user::checkUser() ) {
			if($name = WorkValidator::checkText($post['title'])) {
				$post = $_POST;
			$type = WorkValidator::getRadioValue($post);
			} else {
				Controller_type::ShowAnswer('Не заполнено поле с наименованием должника');
			}
			$debter = ( new Model_debter() )->setType( $type )->setUser( $user[ 'users_id' ] )->setName($name);
			$debter->create( $debter );
			$_SESSION['debter'] = $debter->getToken();
				foreach ( self::$pages as $key ) {
			if ( $key == 'head' ) {
				self::render( self::$name, $key, [ 'css' => self::$css, 'js' => self::$js, 'favicon' => self::$favicon ] );
			} else if($key == 'params') {
				self::render( self::$name . '/pages', $key );
			} else {
				self::render( self::$name, $key );
			}
		}
		} else {
			header( 'Location:index.php' );
		}
	}
		public static function showAnswer($answer) {
		if(Model_user::checkUser()) {

			foreach(self::$pages as $key) {

				if($key == 'head') {
					self::render( self::$name, $key, [ 'css' => self::$css, 'js' => self::$js, 'favicon' => self::$favicon ] );
				} else if($key == 'params') {
					self::render(self::$name . '/pages',$key,['answer'=>$answer]);
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