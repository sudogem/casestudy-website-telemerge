<?php
	require_once ( '../config/conf.php' );
	require_once ( '../config/constants.php' );	
	require_once ( '../libraries/class.database.php' );
	require_once ( '../libraries/class.uploads.php' );
	require_once ( '../libraries/class.client_testimonials.php' );
	require_once ( '../web/class.sessions.php' );
	
	$db = new database ( $conf['dbhost'] , $conf['dbusername'] , $conf['dbpassword'] , $conf['dbdatabasename'] );
	$session = new sessions();
	
	if ( ( $session->isAttributeExist( TELEMERGECONSTANT_SESS_ACCOUNT_SESSID ) == NULL ) || 
		( $session->isAttributeExist( TELEMERGECONSTANT_SESS_ACCOUNT_SESSID ) == FALSE ) )	{
		header( 'Location: ../index.php' );
		exit ;
	}	

	if ( isset( $_POST['cid'] ) )
	{
		$testi = new clientTestimonials ();
		foreach( $_POST['cid'] as $idx => $val )
		{
			$item[] = $val ;
		}
	
		foreach( $item as $k => $value )
		{
			$testi->removeTestimonial( $value );
		}
		$session->setAttribute( 'msg' , 'Successfuly delete item(s).' );
		header('Location: testimonialmanager.php');
		exit ;
	}
?>