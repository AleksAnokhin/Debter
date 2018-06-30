<?php
namespace Interfaces;

interface Debter {
	
	public function getInfo();
	public function generateResult($select);
	public function factorsAnalysis($select,$total_sum);
	
}





?>