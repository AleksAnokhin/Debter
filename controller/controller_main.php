<?php
namespace Controller;
use Controller\ Controller_base as Controller_base;
use Model\ Model_user as Model_user;
use Helpers\DB\Delete as Delete;

class Controller_main extends Controller_base {
	private static $name = 'main';
	

	public static function start() {
		if ( $user = Model_user::checkUser() ) {
			foreach(self::$pages as $key) {
			if($key =='head') {
				self::render(self::$name,$key,['css'=>self::$css,'js'=>self::$js,'favicon'=>self::$favicon] );
			} else if($key == 'main') {
				self::render(self::$name,$key,['user'=>$user]);
			} else {
				self::render(self::$name,$key);
			}
		}
		} else {
			header('Location:index.php');
		}
	}
	
	public static function leave() {
		if(isset($_SESSION['token'])) {
			$session = $_COOKIE['PHPSESSID'];
			Model_user::leave($session);
		}
		header('location:index.php');
	}
}









?>