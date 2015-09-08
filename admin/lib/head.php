<?php

class lib_head {
	private $css = array();
	private $js = array();


	public  function addCss($file){
		$this->css[] = DIR.basename(DS).'/layout/css/'.$file;
		return $this;
	}
	

	public function getCss(){
		$link = '';
		foreach ($this->css as $c){
			$link .=  "<link type='text/css' rel='stylesheet' href='{$c}'></link>";
		}
		return $link;
	}
	
	public static function css($file) {
		$file = DIR.basename(DS).'/layout/css/'.$file;
		$link = "<link type='text/css' rel='stylesheet' href='{$file}'></link>";
		return $link;
	}


	public function addScript($file){
		$this->js[] = DIR.basename(DS).'/layout/js/'.$file;
		return $this;
	}

	public function getScript(){
		$js = '';
		foreach($this->js as $j){
			$js .= "<script type='text/javascript' src='{$j}'></script>";
		}
		return $js;
	}
	public static function script($file) {
		$file = DIR.basename(DS).'/layout/js/'.$file;
		$link = "<script type='text/javascript' src='{$file}'></script>";
		return $link;
	}
	

	public static function setTitle($title){
		echo '<title>'.$title.'</title>';
	} 
}