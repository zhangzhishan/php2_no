<?php
/*
 * 
 */
class lib_functions{



	public static function echo_url_frame($view_path){
		$url = $_SERVER['SCRIPT_NAME'].'/'.$view_path;
		echo $url;
	}
	

	public static function format_pre(array $params){
		echo '<pre>';
		print_r($params);
		echo '</pre>';
	}
	

	public static function setSession($name,$value){
	
		if(!isset($_SESSION)) {
			session_start();
		}
		$lifeTime = 24*3600;
		$_SESSION[$name] = $value;
		//setcookie(session_name(),session_id(),time()+$lifeTime);
	}
	

	public static function getSession($name){
		if(!isset($_SESSION)) {
			session_start();
		}
		return isset($_SESSION[$name])?$_SESSION[$name]:null;
	}

	public static function unsetSession($name){
		if(!isset($_SESSION)) {
			session_start();
		}
		unset($_SESSION[$name]);
		session_destroy();
	}
	
	/*
	 * redirect
	 * @param url  redirect to url  url 'controller/action'  test/index
	 * @param $time redirect time 
	 * @return void
	 */
	public static function redirect($url,$time = NULL){
		$url = $_SERVER['SCRIPT_NAME'].'/'.$url;
		if(!$time){
			@header('Location:'.$url);
		}else{
			@header("Refresh:$time;url=$url");
		}
	}
	
	/**
	 * output <a></a>
	 * <?php lib_functions::action('test/add', 'ADD', array('id'=>'add_id','class'=>'add_class'));
	 * <=>  <a class="add_class" id="add_id" href="/front_controller/index.php/test/add">ADD</a>
	 * @param $url <a href=$url>
	 * @param $name <a>$name</a>
	 * @param attributes 
	 */
	public static function action($url,$name,array $attributes =NULL){
		$u = $_SERVER['SCRIPT_NAME'].'/'.$url;
		$attr = '';
		if(!is_null($attributes)){
			foreach($attributes as $key => $val){
				$attr .= " $key='{$val}'";
			}
		}
		return "<a href='{$u}' $attr>$name</a>";
	}

	public static function url($url) {
		return $_SERVER['SCRIPT_NAME'].'/'.$url;
	}
	
	/*
	 * 
	 */
	public static function require_layout($file){
		if(defined('DS')) {
			require (DS.DIRECTORY_SEPARATOR.'layout'.DIRECTORY_SEPARATOR.$file);
		}
	}
	
	/*
	 * output pictures src
	 * @param  string $url pictures in layout/images
	 */
	public static function image_src($url='') {
		if(defined('DS')) {
			return DIR.'/layout/images/'.$url;
		}
	}
	
	/*
	 * output image
	 * @return string 
	 */
	public static function image($url,array $attributes = NULL) {
		$url = self::image_src($url);
		$attr = '';
		if(!is_null($attributes)) {
			foreach($attributes as $key => $val){
				$attr .= "$key='{$val}'";
			}
		}
		return  "<img src = '{$url}' $attr />";
	} 
	
	
	public static function file_path($file){
		if(defined('DS')) {
			return DIR.basename(DS).'/'.$file;
		}
	}


	 public static function get_layout($file=null) {
		 if(defined('DS')) {
			return DIR.basename(DS).'/layout/'.$file;
		 }
	 }

	 public static function get_config($key) {
		 if(defined('DS')) {
			$configPath = DS.DIRECTORY_SEPARATOR.'boot'.DIRECTORY_SEPARATOR.'config.php';
			$config = include $configPath; //
			return $config[$key];
		 }
	 }


	  public static function include_view($file) {
		  if(defined('DS')) { 
			   $file_path =  DS.'/views/'.$file;
			   include $file_path;
		  }
	  }


	public static function get_include_contents($filename) {
		if(!defined('DS')) {
			return;
		}
		$filename = DS.'/'.$filename;

		if (is_file($filename)) {
			ob_start();
			include $filename;
			$contents = ob_get_contents();
			ob_end_clean();
			return $contents;
		}
		return false;
	}
}