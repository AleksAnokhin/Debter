<?php

namespace Classes;
use Helpers\DB\Select as Select;
use Helpers\DB\Insert as Insert;
use Helpers\DB\Delete as Delete;
use Helpers\DB\Update as Update;
use Helpers\DB\DB as DB;
use Interfaces\Debter as Debter;
use Model\Model_debter as Model_debter;
use Model\Model_result as Model_result;


class Liquidation_debter extends Model_debter implements Debter {
	
	private $id;
	
	
	public function __construct($id) {
		if(is_numeric($id)) {
			$this->id = $id;
			return $this;
		}
	}
	
	public function getInfo() {
		$tables = ['collection_stage','main_parameters','liquidation_stage','type_of_debter'];
		$cond = ['collection_stage'=>'debters.id = collection_stage.debters_id','main_parameters'=>'collection_stage.debters_id=main_parameters.debters_id',
				 'liquidation_stage'=>'main_parameters.debters_id=liquidation_stage.debters_id',
				'type_of_debter'=>'liquidation_stage.debters_id=type_of_debter.debters_id'];
		$id = $this->id;
		$maintable = 'debters';
		$select = Model_result::select($maintable,$cond,$tables,$id);
		if($select) {
			$result = $this->generateResult( $select );
			echo json_encode( $result, JSON_UNESCAPED_UNICODE );
			header( 'Content-Type: application/json' );
		} else {
			return false;
		}
	}
	public function generateResult($select) {
		$total_summ = $select['total_summ'];
		$real_summ = $select['real_summ'];
		$coaf = $this->factorsAnalysis( $select, $total_summ );
		if($select['real_summ'] == 0) {
			$select += [ 'result' => 'По цене предложения' ];
			return $select;
		}
		if($coaf >= 0) {
			$select += ['result'=>$real_summ];
			$select += ['mark'=>'liquidation'];
			return $select;
		} else {
				$discount = $real_summ * ( -0.1 * $coaf );
				$real_summ -= $discount;
				$select += [ 'result' => $real_summ ];
                $select += ['mark'=>'liquidation'];
				return $select;
		}
	}
	public function factorsAnalysis( $select, $total_summ ) {
		$minus = 0;
		$plus = 0;
		if ( floatval( $select[ 'reserves' ] ) > ( $total_summ * 0.5 ) ) {
			$minus++;
		} else {
			$plus++;
		}
		if ( $select[ 'days_of_delay' ] > 50 ) {
			$minus += 0.5;
		} else {
			$plus += 0.5;
		}
		if ( $select[ 'full_expiration' ] == 'fullexpiration_true' ) {
			$minus++;
		} else {
			$plus++;
		}
		if ( $select[ 'reason_of_delay' ] == 'fraud' ) {
			$minus += 2;
		}
		if($select['term'] == 3) {
			$plus++;
		} else if($select['term'] == 12) {
			$minus++;
		} 
		return $plus - $minus;
	}
	
}









?>