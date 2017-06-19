<?php

	require_once ( '../config/conf.php' );
	require_once ( '../config/constants.php' );
	require_once ( '../libraries/class.database.php' );
	require_once ( '../libraries/class.sanitizer.php' );
	require_once ( '../libraries/class.useraccount.php' );
	require_once ( '../libraries/class.articles.php' );
	require_once ( '../libraries/class.validator.php' );
	require_once ( '../libraries/class.httpupload.php' );
	require_once ( '../web/class.sessions.php' );
	
	$db = new database ( $conf['dbhost'] , $conf['dbusername'] , $conf['dbpassword'] , $conf['dbdatabasename'] );
	$session = new sessions();
	$myts = new textSanitizer();

	if ( ( $session->isAttributeExist( TELEMERGECONSTANT_SESS_ACCOUNT_SESSID ) == NULL ) || 
		( $session->isAttributeExist( TELEMERGECONSTANT_SESS_ACCOUNT_SESSID ) == FALSE ) )	{
		header( 'Location: ../index.php' );
		exit ;
	}	
	
	// get the  sessiondata of the account
	$accountdata = $session->getAttribute( TELEMERGECONSTANT_SESS_ACCOUNT_SESSID );
	$uid = $accountdata[TELEMERGECONSTANT_SESS_UID];
	$sess_news_data = $session->getAttribute( 'sess_news_data' );				
	
	if ( isset( $_POST['submitupload_x'] ) ) 
	{
		$val = new validator();

		$newsdata = array(
			'newstitle' => $myts->stripslashesGPC( $_POST['newstitle'] ), 
			'newsdesc' => ( $_POST['newsdesc'] )
		);
		$session->setAttribute( 'newsdata' , $newsdata );	
		
		$fields = array(
			'newstitle' => ' * Please input a title. ' ,
			'newsdesc' => ' * Please input a message body. '
		);
		$val->validateFieldIsEmpty( $_POST , $fields );
		
		if ( count( $val->errors ) > 0 ) 
		{
			$err = $val->getErrors();
			$session->setAttribute( 'news_form_errors' , $err );			
			header('Location: ' . $_SERVER['HTTP_REFERER'] );
			exit;
		}
		
		$action = isset( $_POST['action'] ) ? $_POST['action'] : 'null' ;
		
		switch( $action )
		{
			case 'insert' :
				$article = new NewsArticles();
				$_POST['datecreated'] = time();
				$result = $article->addArticle( $_POST );
				if ( $result )
				{
					$session->setAttribute( 'msg' ,  'Successfully saved item : ' . $myts->htmlspecialchars( $_POST['newstitle'] ));
					header('Location: newsmanager.php?menuclick=4');
					exit;
				}
				break;
			case 'update' :
				$article = new NewsArticles();
				$newsid = $sess_news_data[0]->newsID ;
				$result = $article->editArticle( $_POST , $newsid );
				if ( $result )
				{
					$session->setAttribute( 'msg' ,  'Successfully saved item : ' . $myts->htmlspecialchars( $_POST['newstitle'] ));
					header('Location: newsmanager.php?menuclick=4');
					exit;
				}
				break;	
			default :
				$session->setAttribute( 'msg' ,  'Unknown command : ' .  $myts->htmlspecialchars( $_POST['action'] ) );
				header('Location: newsmanager.php');			
				exit ;
				break;	
		}
	}
	header('Location: newsmanager.php');			
	exit ;
?>
