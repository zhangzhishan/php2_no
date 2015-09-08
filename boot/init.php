<?php

class boot_init {
	public $controller;
	public $action;
	public $params;
	private $default = array();
	
	public function __construct(){
		$configPath = DS.DIRECTORY_SEPARATOR.'boot'.DIRECTORY_SEPARATOR.'config.php';
		$this->default = include $configPath; //include the config files
		define('DEBUG', $this->default['debug']);
		if(DEBUG) {
			error_reporting(E_ALL);
		}else {
			error_reporting(E_ALL ^ E_NOTICE);
		}
		
		date_default_timezone_set($this->default['timezone']);
	
		if(empty($this->default['default_controller'])) {
			$this->controller = 'goods';
			$this->action = 'index';
		}else{
			$this->controller = $this->default['default_controller'];
			$this->action = $this->default['default_action'];
		}
		
		$this->get_path();
		$this->start();
		
	}
	
	/*
	 * get controller£¬action£¬params from url
	 */
	public function get_path(){
		
		$url = $_SERVER['PHP_SELF'];
		$start = strpos($url,'index.php');
		
		if($start){  // http://localhost/hr/index.php/....
			$url = trim($url,'/'); //remove "/" in index.php/
			$url = substr($url, $start+strlen('index.php'));
			
			if(!$url){
				return;
			}
			  
			$url = str_ireplace('.php','',$url); //   control/action/params
			$url_array = explode('/', $url);
			
			switch (sizeof($url_array)){
				case 0 : //default value
					break;
				case 1 :
					$this->controller = $url_array[0];
					break;
				case 2 :
					$this->controller = $url_array[0];
					$this->action = $url_array[1];
					break;
				case 3 :
					$this->controller = $url_array[0];
					$this->action = $url_array[1];
					$this->params = $url_array[2];
					break;
				default:
					$this->controller = $url_array[0];
					$this->action = $url_array[1];
					array_splice($url_array, 0,2); //remove 2 before
					$this->params = $url_array;
			}
		}
	}
	
	/*
	 * start program and find the controller£¬action
	 */
	public function start(){
		$classname = "controllers_".$this->controller;
		$action = $this->action;

		$ctl_reflect = new ReflectionClass($classname);
		$ctl = $ctl_reflect->newInstance();
//		$ctl = new $classname();
		if(method_exists($ctl, $action)){
			$response = $ctl;

			$ctl->$action($this->params);
		    
			//layout
			if(!empty($ctl->layout)){
				include(DS.DIRECTORY_SEPARATOR.'layout'.DIRECTORY_SEPARATOR.$ctl->layout.'.php');
			}
			
			//view
			if(!empty($ctl->view)){ 
				$filename = DS.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR.$ctl->view.'.php';
				if(!file_exists($filename)){
					exit("<div class='error'>files: <b>$filename</b> not exists!</div>");
				}
				include_once ($filename);
			}else{  
				$filename = DS.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR.$this->controller.DIRECTORY_SEPARATOR.$action.".php";
				if(!file_exists($filename)){
					exit("<div class='error'>files: <b>$filename</b> not exist!</div>");
				}
				include_once ($filename);
			}
		}else{
			exit("<div class='error'>action: <b>$action</b>  not exist in controller class: <b>$classname</b></div>");
		}
		
	}
}