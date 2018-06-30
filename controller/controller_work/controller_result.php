<?php
namespace Controller\Controller_work;
use Controller\ Controller_base as Controller_base;
use Model\Model_user as Model_user;
use Model\Model_debter as Model_debter;
use Helpers\Validators\ WorkValidator as WorkValidator;
use Helpers\DB\DB as DB;
use Classes\Pretrial_individual as Pretrial_individual;
use Classes\Pretrial_entity as Pretrial_entity;
use Classes\Trial_debter as Trial_debter;
use Classes\Executive_debter as Executive_debter;
use Classes\Bancrupt_debter as Bancrupt_debter;
use Classes\Liquidation_debter as Liquidation_debter;

class Controller_result {
	
	public function show() {
		if(Model_user::checkUser()) {
			if($debter = Model_debter::getByToken($_SESSION['debter'])) {
				$id = $debter[ 'id' ];
				$stage = Model_debter::getStage($id);
				$type = Model_debter::getType($id);
				switch($stage) {
					case 'pretrial' :
						if($type=='individual') {
							$debter = new Pretrial_individual($id);
							$debter->getInfo();
							break;
						} else if($type == 'entity') {
							$debter = new Pretrial_entity($id);
							$debter->getInfo();
							break;
						}
					case 'trial' :
						$debter = new Trial_debter($id);
						$debter->getInfo();
						break;
					case 'execution' :
						$debter = new Executive_debter($id);
						$debter->getInfo();
						break;
					case 'bancrupt' :
						$debter = new Bancrupt_debter($id);
						$debter->getInfo();
						break;
					case 'liquidation':
						$debter = new Liquidation_debter($id);
						$debter->getInfo();
						break;
				}
			} else {
				unset( $_SESSION[ 'debter' ] );
					header( 'Location:index.php?route=main/start' );
			}
		} else {
			header('Location:index.php');
		}
	}
	
}



?>