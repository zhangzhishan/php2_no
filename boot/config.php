<?php
/*
 * config files
 * the default ctrl-action....
 */
$array = array(
	'default_controller' => 'goods',
	'default_action' => 'index',
	'debug' => false  //debug
);

/**
 *
 *database configure
 *
 */
$array['host'] = 'phpmyadmin.helios.csesalford.com';
$array['database'] = 'wbsd12';
$array['user'] = 'wbsd12';
$array['password'] = 'php54';

/**
 *code charset
 */
$array['charset'] = 'utf8';

$array['timezone'] = 'Europe/London';

return $array;