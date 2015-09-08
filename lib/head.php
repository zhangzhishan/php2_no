<?php
/*
 * This class is used in <head></head>£¬it is used to add css£¬js
 * css is located in layout/css
 * js is located in layout/js
 */
class lib_head {
	private $css = array();
	private $js = array();

	/*
	 * add css
	 */
	public  function addCss($file){
		$this->css[] = '/'.basename(DS).'/layout/css/'.$file;
		return $this;
	}
	
	/*
	 * output css
	 */
	public function getCss(){
		$link = '';
		foreach ($this->css as $c){
			$link .=  "<link type='text/css' rel='stylesheet' href='{$c}'></link>";
		}
		return $link;
	}
	
	public static function css($file) {
		$file = '/'.basename(DS).'/layout/css/'.$file;
		$link = "<link type='text/css' rel='stylesheet' href='{$file}'></link>";
		return $link;
	}

	/*
	 * add js
	 */
	public function addScript($file){
		$this->js[] = '/'.basename(DS).'/layout/js/'.$file;
		return $this;
	}
	
	/*
	 * output js
	 */
	public function getScript(){
		$js = '';
		foreach($this->js as $j){
			$js .= "<script type='text/javascript' src='{$j}'></script>";
		}
		return $js;
	}
	public static function script($file) {
		$file = '/'.basename(DS).'/layout/js/'.$file;
		$link = "<script type='text/javascript' src='{$file}'></script>";
		return $link;
	}
	
	/*
	 * output title
	 */
	public static function setTitle($title){
		echo '<title>'.$title.'</title>';
	} 
}