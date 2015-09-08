<?php
class controllers_base {
	protected $model;
	public  $view;
	public  $layout = 'index';
	public function __construct(){
		$this->model = boot_command::factory('models_base');
	}
	
	/**
	 * define the request function for  post and get method
	 * @param string $name  $_POST[$name]
	 * @return string 
	 */
	protected function _request($name){
		return isset($_REQUEST[$name])?$_REQUEST[$name]:null;
	}
	
	/**
	 * interceptor
	 */
	protected function interceptor($session_name,$url){
		$session = lib_functions::getSession($session_name);
		if(!isset($session)) {
//			header('Refresh:5;url=login.php');
			lib_functions::redirect($url,5);
			print('Sorry, you need to sign in, jump after 5 seconds....');
			exit;
		}
	}



	/**
	 *json output 
	 *2015-6-5
	 */
	protected function make_json_exit($tpl,$filter) {
		$response = &$this;
		$tpl = 'views/'.$tpl;
		$filename = DS.'/'.$tpl;
		
		if (is_file($filename)) {
			
			ob_start();
			include $filename;
			$contents = ob_get_contents();
			ob_end_clean();

			$ret = array('content'=>$contents,'filter'=>$filter);
			exit(json_encode($ret));
		}
		
	}
	
	protected function add_magic($arr) {
		foreach($arr as &$value) {
			$value = trim($value);
			$value = addslashes($value);
		}
		return $arr;
	}

}