<?php

	require_once ( '../config/conf.php' );
	require_once ( '../config/constants.php' );
	require_once ( '../libraries/class.database.php' );
	require_once ( '../libraries/class.sanitizer.php' );
	require_once ( '../libraries/class.useraccount.php' );
	require_once ( '../libraries/class.uploads.php' );
	require_once ( '../libraries/class.validator.php' );
	require_once ( '../libraries/class.httpdownload.php' );
	require_once ( '../http/class.sessions.php' );

	$object = new httpdownload;
	$filename = $_GET['file'];
	$object->set_byfile($filename);	
	$object->use_resume = false;
	$object->speed = 100;	
	$object->download();
	
?>