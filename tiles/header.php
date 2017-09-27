<?php

// turn off error reporting when presenting to live site

error_reporting(0);
require_once ( '../config/conf.php' );
require_once ( '../config/constants.php' );
require_once ( '../sysfunctions/sysfunc.php' );
require_once ( '../libraries/class.database.php' );
require_once ( '../http/class.sessions.php' );
require_once ( '../http/class.request.php' );

$session = new sessions();
$request = new request();



$sessdata = $session->getAttribute( TELEMERGECONSTANT_SESS_ACCOUNT_SESSID );
$logname = $sessdata[TELEMERGECONSTANT_SESS_UNAME];
$guid = $sessdata[TELEMERGECONSTANT_SESS_GUID];


switch( $guid )

{

	case TELEMERGECONSTANT_GUID_ADMIN : // admin

		$s = 'Administrator CPanel Menu';

		break ;

	case TELEMERGECONSTANT_GUID_CLIENT : // client

		$s = 'Client CPanel Menu';	

		break ;

	case TELEMERGECONSTANT_GUID_MT : // mt

		$s = 'MT CPanel Menu';		

		break ;

}



if ( ( $session->isAttributeExist( TELEMERGECONSTANT_SESS_ACCOUNT_SESSID ) == NULL ) || 

	( $session->isAttributeExist( TELEMERGECONSTANT_SESS_ACCOUNT_SESSID ) == FALSE ) )	{

	header( 'Location: ../index.php' );

	exit ;

}	



$db = new database ( $conf['dbhost'] , $conf['dbusername'] , $conf['dbpassword'] , $conf['dbdatabasename'] );



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Control Panel</title>

<link rel="stylesheet" href="../css/admin2.css" media="screen"  />

<script type="text/javascript" language="javascript" src="../js/scripts.js" ></script>

</head>



<body>

<div id="container" >

	<div id="head" ><h1><span>Telemerge Control Panel</span></h1></div>

	<div id="navcontainer" >

		<ul id="topnav">

			<h1 class="nav-head" ><?php echo $s ; ?></h1>

		  <li><a href="logout.php">Log-out <?php echo $logname; ?></a></li>

		  <li><a href="../index.php"  >&laquo; Visit Website</a></li>

		  <li></li>

		</ul>		

	</div>	

	<div class="clear"></div>

	

	<div id="outer">

		<div id="inner" >	