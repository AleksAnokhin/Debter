<?php
namespace Controller;
use Controller\Controller_base as Controller_base;
use Controller\Controller_reg as Controller_reg;
use Helpers\DB\DB as DB;
use Model\Model_user as Model_user;

class Controller_auth extends Controller_base {
	
	public static function check($post) {
		if(empty($post)) {
			Controller_reg::mainErr('Такого пользователя не существует. Пройдите регистрацию.');
		} else {
			$login = DB::escape($post['login']);
			$password = DB::escape($post['password']);
			Model_user::checkAuth($login,$password);
		}
	} 
	
	
}















?>