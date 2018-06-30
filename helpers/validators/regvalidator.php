<?php
namespace Helpers\Validators;
use Controller;
class RegValidator {
	
	public static function checkEmpty($post) {
		foreach($post as $key=>$value) {
			if($value == '') {
				Controller\Controller_reg::mainErr('Не заполнено поле ' . $key );
				return false;
			}
		}
		return true;
	}
	
public static function checkPass($password,$password2) {
	if ($password !== $password2) {
		Controller\Controller_reg::mainErr('Пароли не совпадают.');
		return false;
	} else if(strlen($password) < 5 and strlen($password2) < 5 ) {
		Controller\Controller_reg::mainErr('Пароль должен содержать как минимум 5 символов.');
		return false;
	} else {
		return true;
	}
}
	public static function checkMailValid($mail) {
		if(filter_var($mail,FILTER_VALIDATE_EMAIL)) {
			return true;
		} else {
			Controller\Controller_reg::mainErr('Неверно указан адрес электронной почты.');
		return false;
		}
	}
	
}














?>