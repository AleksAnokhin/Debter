<?php
namespace Controller;
use Controller;
use Model\ Model_user as Model_user;
use Model\ Model_debter as Model_debter;
use Model\Model_index as Model_index;
use Helpers\DB\DB as DB;

class Controller_index extends Controller\ Controller_base {
	private static $name = 'index';


	public static function showIndex() {
		foreach ( self::$pages as $key ) {
			if ( $key == 'head' ) {
				self::render( self::$name, $key, [ 'css' => self::$css, 'js' => self::$js, 'favicon' => self::$favicon ] );
			} else {
				self::render( self::$name, $key );
			}
		}
	}

	public static function xhr_about() {
		if ( $sql = Model_index::showAbout() ) {
			echo( implode( $sql ) );
		} else {
			exit( 'Контент не загружается' );
		}
	}
	public static function xhr_rules() {

		if ( $sql = Model_index::showRules() ) {
			echo( implode( $sql ) );
		} else {
			exit( 'Контент не загружается' );
		}
	}
	public static function additionalRender($answer){
		foreach ( self::$pages as $key ) {
					if ( $key == 'head' ) {
						self::render( self::$name, $key, [ 'css' => self::$css, 'js' => self::$js, 'favicon' => self::$favicon ] );
					} else if( $key == 'main' ) {
						self::render( self::$name, $key, [ 'answer' => $answer ] );
					} else {
						self::render( self::$name, $key);
					}
				}
	}
	public static function question( $post ) {
	if ( !empty( $post ) and $post['text'] !== '') {
		if ( $sql = Model_user::checkQuestion( DB::escape( $post[ 'login' ] ) ) ) {
			$id = $sql['id'];
			$question = DB::escape($post['text']);
			$inf = array('user_id'=>$id,'question'=>$question);
			if (Model_index::question($inf)) {
				self::additionalRender('Спасибо за Ваш вопрос! Мы ответим на него в ближайшее время.');
			}
		} else {
			self::additionalRender('Вы не зарегистрированы.');
		}
	} else{
		self::additionalRender('Форма с вопросом не заполнена.');
	}
}
	public static function delete() {
		if(isset($_SESSION['debter'])) {
			if($debter = Model_debter::getByToken($_SESSION['debter'])) {
				$id = $debter['id'];
				$delete = Model_debter::deleteDebter($id);
				if($delete) {
					header('Location:index.php');
				} else {
					self::additionalRender('Не удалось удалить должника');
				}
			} else {
				header('Location:index.php');
			}
			
		} else {
			header('Location:index.php');
		}
	}


}






?>