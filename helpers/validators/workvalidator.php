<?php
namespace Helpers\ Validators;
use Controller\ Controller_work\ Controller_type as Controller_type;



class WorkValidator {

	public static function checkText( $text ) {
		if ( $text !== '' ) {
			return htmlspecialchars( $text );
		} else {
			return false;
		}
	}
	
//борьба с нулем и ложью при возвращении
	public static function checkNumber( $number ) {
		if ( $number == '') {
			return false;
		} else if(is_numeric($number) and $number !== '0' and $number > 0) {
			return $number;
		} else if($number == 0 and is_numeric($number)) {
			return 0.0000000001;
		} else {
			return false;
		}
	}
	public static function checkCheckBox($post) {
		$data = [];
		$checkbox = '/^checkbox_+/Ui';
		foreach($post as $key=>$value) {
			if(preg_match($checkbox,$key) and $value !== '') {
				$data[] = $value;
			}
		}
		if(!empty($data)) {
			return $data;
		} else {
			return false;
		}
	}
	
		public static function getRadioValue($post) {
			$pattern = '/^radio_+/Ui';
			foreach($post as $key=>$value) {
				if(preg_match($pattern,$key) and $value !=='') {
					return $value;
				}
			}
		}
	
	public static function getRadioMult($post,$name) {
		$pattern = "/^radio_$name$/Ui";
		foreach($post as $key=>$value) {
				if(preg_match($pattern,$key) and $value !=='') {
					return $value;
				}
			}
	}
	}











?>