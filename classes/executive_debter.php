<?php

namespace Classes;
use Helpers\ DB\ Select as Select;
use Helpers\ DB\ Insert as Insert;
use Helpers\ DB\ Delete as Delete;
use Helpers\ DB\ Update as Update;
use Helpers\ DB\ DB as DB;
use Interfaces\ Debter as Debter;
use Model\ Model_debter as Model_debter;
use Model\Model_result;


class Executive_debter extends Model_debter
implements Debter {

	private $id;


	public function __construct( $id ) {
		if ( is_numeric( $id ) ) {
			$this->id = $id;
			return $this;
		}
	}

	public function getInfo() {
		$tables = [ 'collection_stage', 'main_parameters', 'trial_pledged_property', 'execution_stage', 'type_of_debter' ];
		$cond = [ 'collection_stage' => 'debters.id = collection_stage.debters_id', 'main_parameters' => 'collection_stage.debters_id=main_parameters.debters_id',
			'trial_pledged_property' => 'main_parameters.debters_id=trial_pledged_property.debters_id',
			'execution_stage' => 'trial_pledged_property.debters_id=execution_stage.debters_id',
			'type_of_debter' => 'execution_stage.debters_id=type_of_debter.debters_id'
		];
		$id = $this->id;
		$maintable = 'debters';
		$select = Model_result::select($maintable,$cond,$tables,$id);
		if ( $select ) {
			$result = $this->generateResult( $select );
			echo json_encode( $result, JSON_UNESCAPED_UNICODE );
			header( 'Content-Type: application/json' );
		} else {
			$tables = [ 'collection_stage', 'main_parameters', 'execution_stage', 'type_of_debter' ];
			$cond = [ 'collection_stage' => 'debters.id = collection_stage.debters_id',
				'main_parameters' => 'collection_stage.debters_id=main_parameters.debters_id',
				'execution_stage' => 'main_parameters.debters_id=execution_stage.debters_id',
				'type_of_debter' => 'execution_stage.debters_id=type_of_debter.debters_id'
			];
			$id = $this->id;
			$select = Model_result::select($maintable,$cond,$tables,$id);
			if ( $select ) {
				$result = $this->generateResult( $select );
				echo json_encode( $result, JSON_UNESCAPED_UNICODE );
				header( 'Content-Type: application/json' );
			}
			return false;
		}
	}
	public function generateResult( $select ) {
		if ( !isset( $select[ 'price' ] ) ) {
			$select[ 'price' ] = 0;
		}
		$total_summ = floatval( $select[ 'main_debt' ] ) + floatval( $select[ 'persentage' ] + floatval( $select[ 'forfeit' ] ) );
		$property = floatval( $select[ 'price' ] ) + floatval( $select[ 'property' ] );
		$coaf = $this->factorsAnalysis( $select, $total_summ );
		if ( $property >= $total_summ ) {
			$select += [ 'result' => $total_summ ];
			return $select;
		}

		if ( $property == 0 ) {
			$select += [ 'result' => 'По цене предложения' ];
			return $select;
		}
		if ( $select[ 'price' ] > 0 ) {
			if ( $coaf > 0 ) {
				$discount = $property * 0.25;
				$property -= $discount;
				$select += [ 'result' => $property ];
				return $select;
			} else {
				$discount = $property * ( -0.1 * $coaf );
				$property -= $discount;
				$select += [ 'result' => $property ];
				return $select;
			}

		} else {

			if ( $select[ 'property' ] > 0 and $coaf >= 0 ) {
				$discount = $property * 0.25;
				$property -= $discount;
				$select += [ 'result' => $property ];
				return $select;
			} else if ( $select[ 'property' ] > 0 and $coaf < 0 ) {
				$discount = $property * ( -0.1 * $coaf );
				$property -= $discount;
				$select += [ 'result' => $property ];
				return $select;
			}
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
		if ( isset( $select[ 'liquidity' ] ) ) {
			if ( $select[ 'liquidity' ] == 'low' ) {
				$minus++;
			} else if ( $select[ 'liquidity' ] == 'high' ) {
				$plus++;
			}
		} else {
			$select += [ 'liquidity' => 'middle' ];
		}
		if ( $select[ 'payments' ] == 'no' ) {
			$minus++;
		} else {
			$plus++;
		}
		return $plus - $minus;
	}

}









?>