<?php
	//error_reporting(0);
	ini_set('max_execution_time', 30000000000000);
	date_default_timezone_set('America/Lima');
	require_once 'config/config.php';	
	/*require_once 'librarys/Controller.php';
	require_once 'librarys/Core.php';
	require_once 'librarys/DataBase.php';
	require_once 'librarys/Session.php';*/

	spl_autoload_register(function($class){
		require_once 'librarys/'.$class.'.php';
	});

	Session::init();
?>
