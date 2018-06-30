<?php

namespace Controller\Controller_work;
use Controller\ Controller_base as Controller_base;
use Model\Model_user as Model_user;
use Model\Model_debter as Model_debter;
use Helpers\Validators\ WorkValidator as WorkValidator;
use Controller\ Controller_work\ Controller_type as Controller_type;
use Controller\Controller_work\Pretrial\Controller_ind as Controller_ind;
use Controller\Controller_work\Pretrial\Controller_ent as Controller_ent;
use Controller\Controller_work\Trial\Controller_trial as Controller_trial;
use Controller\Controller_work\Bancrupt\Controller_bancrupt as Controller_bancrupt;
use Controller\Controller_work\Executive\Controller_executive as Controller_executive;
use Controller\Controller_work\Liquidation\Controller_liquidation as Controller_liquidation;
use Controller\Controller_work\Controller_last as Controller_last;

class Controller_router  {
	
	public function start($post) {
		if($user = Model_user::checkUser()) {
			if($debter = Model_debter::getByToken($_SESSION['debter'])) {
				$id = $debter[ 'id' ];
				$type = Model_debter::getType($id);
				$stage = WorkValidator::getRadioValue($post);
			$controller = self::chooseDiraction($type,$stage,$debter,$user);
			$controller->show($debter,$user,$stage);
			} else {
				unset( $_SESSION[ 'debter' ] );
					header( 'Location:index.php?route=main/start' );
			}
			
		} else {
			header('Location:index.php');
		}
		
		
	}
	public function proceedfirst($post) {
		if($user = Model_user::checkUser()) {
			if($debter = Model_debter::getByToken($_SESSION['debter'])) {
			$id = $debter[ 'id' ];
			$type = Model_debter::getType($id);
			$stage = Model_debter::getStage($id);
			$controller = self::chooseDiraction($type,$stage,$debter,$user);
			$controller->proceedfirst($debter,$user,$post);
			} else {
				unset( $_SESSION[ 'debter' ] );
					header( 'Location:index.php?route=main/start' );
			}
	
		} else {
			header('Location:index.php');
		}
		
	}
	public function proceedsecond($post) {
		if($user = Model_user::checkUser()) {
			if($debter = Model_debter::getByToken($_SESSION['debter'])) {
			$id = $debter[ 'id' ];
			$type = Model_debter::getType($id);
			$stage = Model_debter::getStage($id);
			$controller = self::chooseDiraction($type,$stage,$debter,$user);
			if($stage == 'pretrial') {
			$analysis = Model_debter::getAnalysis($id);
			$contact = Model_debter::getContact($id);
			$controller->proceedsecond($debter,$user,$analysis,$contact);
			} else if($stage == 'bancrupt' or $stage == 'liquidation') {
				$controller->proceedsecond($debter,$user,$post);
			}
			
			} else {
				unset( $_SESSION[ 'debter' ] );
					header( 'Location:index.php?route=main/start' );
			}
	
		} else {
			header('Location:index.php');
		}
		
	}
	public function proceedthird($post) {
		if($user = Model_user::checkUser()) {
			if($debter = Model_debter::getByToken($_SESSION['debter'])) {
			$id = $debter[ 'id' ];
			$type = Model_debter::getType($id);
			$stage = Model_debter::getStage($id);
			$analysis = Model_debter::getAnalysis($id);
			$contact = Model_debter::getContact($id);
			$controller = self::chooseDiraction($type,$stage,$debter,$user);
			$controller->proceedthird($debter,$user,$post,$analysis,$contact);
			} else {
				unset( $_SESSION[ 'debter' ] );
					header( 'Location:index.php?route=main/start' );
			}
	
		} else {
			header('Location:index.php');
		}
		
	}
	public static function complete($post) {
		if($user = Model_user::checkUser()) {
			if($debter = Model_debter::getByToken($_SESSION['debter'])) {
			$id = $debter[ 'id' ];
			$stage = Model_debter::getStage($id);
			$controller = new Controller_last();
			if($stage == 'pretrial') {
			$controller->show($debter,$user,$post);
			} else if($stage == 'trial' or $stage == 'execution') {
				$controller->ShowTrial($debter,$user,$post);
			}
			} else {
				unset( $_SESSION[ 'debter' ] );
					header( 'Location:index.php?route=main/start' );
			}
		} else {
			header('Location:index.php');
		}
		
	}
	public static function chooseDiraction($type,$stage,$debter,$user) {
		switch($stage) {
			case 'pretrial':
				if($type == 'individual') {
					$controller = new Controller_ind;
					return $controller;
				} else if($type == 'entity') {
					$controller = new Controller_ent;
					return $controller;
				}
			case 'trial' : 
				$controller = new Controller_trial;
				return $controller;
			case 'execution' : 
				$controller = new Controller_executive;
				return $controller;
			case 'bancrupt' : 
				$controller = new Controller_bancrupt;
				return $controller;
			case 'liquidation' :
				$controller = new Controller_liquidation;
				return $controller;
		}
	}
	
}












?>