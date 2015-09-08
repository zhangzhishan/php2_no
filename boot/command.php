<?php
class boot_command{
	public static function factory($classname){
		return new $classname();
	}
}