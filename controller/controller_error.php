<?php 

namespace Controller;
use Controller\Controller_base as Controller_base;

class Controller_error extends Controller_base {
	private static $name = 'error';
	
	public static function showErrorPage() {
		foreach ( self::$pages as $key ) {
			if ( $key == 'head' ) {
				self::render( self::$name, $key, [ 'css' => self::$css, 'js' => self::$js, 'favicon' => self::$favicon ] );
			} else {
				self::render( self::$name, $key );
			}
		}
	}
	
	
}












?>