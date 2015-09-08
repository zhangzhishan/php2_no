<?php
require 'lib/myautoload.php';
spl_autoload_register(array('Myautoload','autoLoad'));
define('DS', dirname(__FILE__)); //root document
define('DT', dirname(dirname(__FILE__)));
define('DIR', '/phphomework/');
$start = boot_command::factory('boot_init');
