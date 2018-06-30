<?php

namespace Controller\Controller_work;
use Controller\Controller_base as Controller_base;
use Model\ Model_user as Model_user;

class Controller_type extends Controller_base {
	protected static $pages = ['head','header','type','footer'];
	private static $name = 'work';
	
	public static function show() {
		if(Model_user::checkUser()) {
			foreach ( self::$pages as $key ) {
			if ( $key == 'head' ) {
				self::render( self::$name, $key, [ 'css' => self::$css, 'js' => self::$js, 'favicon' => self::$favicon ] );
			} else if($key == 'type') {
				self::render( self::$name . '/pages', $key );
			} else {
				self::render( self::$name, $key );
			}
		}
		} else {
			header('Location:index.php');
		}
	}
	public static function showAnswer($answer) {
		if(Model_user::checkUser()) {

			foreach(self::$pages as $key) {

				if($key == 'head') {
					self::render( self::$name, $key, [ 'css' => self::$css, 'js' => self::$js, 'favicon' => self::$favicon ] );
				} else if($key == 'type') {
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