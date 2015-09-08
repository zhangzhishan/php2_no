<?php
class models_user extends models_base{

	public function __construct() {
		$this->table = 'taoyizhang_wbsd1415_resit_users';
	}

	public function add($user_name,$info=null) {
		$user_id = $this->get_user_id($user_name);
		if(empty($user_id)) {
			$info['user_name'] = $user_name;
			
			$num = $this->insert($info);
			if($num > 0) {
				return $this->get_last_id();
			}
		}else {
			return $user_id;
		}
	}

	public function get_user_id($user_name) {
		$sql = "select id from taoyizhang_wbsd1415_resit_users where user_name = '{$user_name}'";
		return $this->getOne($sql);
	}

	/**
	 *
	 * new  users address user_address
	 *@param int $user_id 
	 *@param array $info
	 *@return void
	 */
	public function insert_address($user_id,$info) {
		$info['user_id'] = $user_id;
		$sql = "select count(*) from taoyizhang_wbsd1415_resit_user_address where user_id='{$user_id}'";
		$num = $this->getOne($sql);
		if($num == 0) {
			$info['is_default'] = 1;
		}
		return $this->table('taoyizhang_wbsd1415_resit_user_address')->insert($info);
	}

}



