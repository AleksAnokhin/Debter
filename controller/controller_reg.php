<?php
namespace Controller;
use Controller;
use Helpers;
use Helpers\Validators\Regvalidator as RegValidator;
use Model\Model_user as Model_user;

class Controller_reg extends Controller\Controller_base {
	private static $name = 'reg';
	
	
	public static function main() {
		foreach(self::$pages as $key) {
			if($key =='head') {
				self::render(self::$name,$key,['css'=>self::$css,'js'=>self::$js,'favicon'=>self::$favicon] );
			} else {
				self::render(self::$name,$key);
			}
		}
	}
	public static function mainErr($errorText) {
		foreach(self::$pages as $key){
			if($key=='head') {
				self::render(self::$name,$key,['css'=>self::$css,'js'=>self::$js,'favicon'=>self::$favicon] );
			}else if ($key=='main') {
				self::render(self::$name,$key,['errorText'=>$errorText]);
			} else {
				self::render(self::$name,$key);
			}
		}
	}
	
	public static function create($post) {
		if(RegValidator::checkEmpty($post) and RegValidator::checkPass($post['password'],$post['password2'])
		  and RegValidator::checkMailValid($post['email'])){
			if(Model_user::checkLogin($post['login']) and Model_user::checkMail($post['email'])) {
				$user = (new Model_user($post))->setSession()->setToken()->setPassword();
				$user->escapeAll($user)->insert();
				if($user) {
					$_SESSION['token'] = $user->getToken();
					header("location:index.php?route=main/start");
				}
				
			} 
		} 
			
	
	
}

}









?>