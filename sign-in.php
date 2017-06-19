<?php

require_once ( 'config/conf.php' );
require_once ( 'config/constants.php' );
require_once ( 'libraries/class.database.php' );
require_once ( 'libraries/class.sanitizer.php' );
require_once ( 'libraries/class.useraccount.php' );
require_once ( 'web/class.sessions.php' );

$db = new database ( $conf['dbhost'] , $conf['dbusername'] , $conf['dbpassword'] , $conf['dbdatabasename'] );
$session = new sessions();

if ( isset( $_POST['submit'] ) ) 
{
	// print_r($_POST);
	$sanitize =& textSanitizer::getInstance();
	$account = new userAccount ; 
	$username = ( $_POST['username'] );
	$password = ( $_POST['password'] );
	
	$result = $account->checkUserAccount( $username , $password ) ;
	
	if ( !$result ) 
	{
		// sayop password
		$msg = 'Invalid username and/or password';
		$session->setAttribute( 'login_error' ,  $msg );
		$session->writeSession() ;
		header( 'Location: index.php' );		
		exit ;
	}
	else
	{
		// print_r($result);
		$account = array(
			TELEMERGECONSTANT_SESS_UNAME => $result[0]->username ,
			TELEMERGECONSTANT_SESS_PWORD => sha1( $result[0]->password ) ,
			TELEMERGECONSTANT_SESS_UID => $result[0]->userID ,
			TELEMERGECONSTANT_SESS_GUID => sha1( $result[0]->usertypeID ) 
		) ;
		//print_r($account);
		$session->setAttribute( TELEMERGECONSTANT_SESS_ACCOUNT_SESSID , $account  ) ;
		$session->writeSession() ;
		header( 'Location: systempanel/list.php' );
		exit ;
	}
}

?>