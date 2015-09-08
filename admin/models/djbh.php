<?php
class models_djbh {
	
	/**
	 * random create  number
	 *201504180000
	 */
	public function create() {
		$year = date('Ymd');
		$random = rand(0,9999);
		if($random>999) {
			$djbh = $year.$random;
		}elseif($random>99) {
			$djbh =$year.'0'.$random;
		}elseif($random>9) {
			$djbh =$year.'00'.$random;
		}else{
			$djbh =$year.'000'.$random;
		}
		
		return $djbh;
	}
}