<?php
	require_once ( '../config/conf.php' );
	require_once ( '../config/constants.php' );
	require_once ( '../libraries/class.database.php' );
	require_once ( '../libraries/class.sanitizer.php' );
	require_once ( '../libraries/class.useraccount.php' );
	require_once ( '../libraries/class.articles.php' );
	require_once ( '../libraries/class.validator.php' );
	require_once ( '../libraries/class.httpupload.php' );
	require_once ( '../libraries/class.client_testimonials.php' );	
	require_once ( '../http/class.sessions.php' );
	
	$db = new database ( $conf['dbhost'] , $conf['dbusername'] , $conf['dbpassword'] , $conf['dbdatabasename'] );
	$session = new sessions();
	$myts = new textSanitizer();
	$testimonial = new clientTestimonials();

	if ( ( $session->isAttributeExist( TELEMERGECONSTANT_SESS_ACCOUNT_SESSID ) == NULL ) || 
		( $session->isAttributeExist( TELEMERGECONSTANT_SESS_ACCOUNT_SESSID ) == FALSE ) )	{
		header( 'Location: ../index.php' );
		exit ;
	}	
	
	$sess_client_testimonial_data = $session->getAttribute( 'sess_client_testimonial_data' );
	
	$action = isset( $_POST['action'] ) ? $_POST['action'] : 'null';	
	switch( $action )
	{
		case 'insert' :
			break ;
		case 'update' :
			$testiID = $sess_client_testimonial_data[0]->testimonialID ;
			$result = $testimonial->editTestimonial( $_POST , $testiID );
			if ( $result )
			{
				$session->setAttribute( 'msg' ,  'Successfully saved testimonial' );  
				header( 'Location: testimonialmanager.php' );
				exit;
			}	
			break ;	
		default :
			die( 'Unknown command : ' . $_POST['action'] );
			break ;	
	}
header( 'Location: testimonialmanager.php' );
?>