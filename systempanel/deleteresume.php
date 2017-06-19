<?php
	require_once ( '../config/conf.php' );
	require_once ( '../config/constants.php' );	
	require_once ( '../libraries/class.database.php' );
	require_once ( '../libraries/class.resume.php' );
	require_once ( '../web/class.sessions.php' );
	
	$db = new database ( $conf['dbhost'] , $conf['dbusername'] , $conf['dbpassword'] , $conf['dbdatabasename'] );
	$session = new sessions();

	if ( ( $session->isAttributeExist( TELEMERGECONSTANT_SESS_ACCOUNT_SESSID ) == NULL ) || 
		( $session->isAttributeExist( TELEMERGECONSTANT_SESS_ACCOUNT_SESSID ) == FALSE ) )	{
		header( 'Location: ../index.php' );
		exit ;
	}	
//print_r($_POST);	
	if ( isset( $_POST['cid'] ) )
	{
		$resume = new Applicant_resume ();
		foreach( $_POST['cid'] as $idx => $val )
		{
			$item[] = $val ;
		}
	
		foreach( $item as $k => $value )
		{
			$resume->removeResume( $value );
		}
		$session->setAttribute( 'msg' , 'Successfuly delete item(s).' );
		header('Location: resumemanager.php');
		exit ;
	}
?>