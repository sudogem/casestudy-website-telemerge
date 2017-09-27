<?php
	
	require_once ( '../config/conf.php' );
	require_once ( '../config/constants.php' );
	require_once ( '../libraries/class.database.php' );
	require_once ( '../libraries/class.sanitizer.php' );
	require_once ( '../libraries/class.useraccount.php' );
	require_once ( '../libraries/class.uploads.php' );
	require_once ( '../libraries/class.validator.php' );
	require_once ( '../libraries/class.httpupload.php' );
	require_once ( '../http/class.sessions.php' );
	
	$db = new database ( $conf['dbhost'] , $conf['dbusername'] , $conf['dbpassword'] , $conf['dbdatabasename'] );
	$session = new sessions();
	$upload = new uploads();
	$myts = new textSanitizer();
	
	// get the  sessiondata of the account
	$accountdata = $session->getAttribute( TELEMERGECONSTANT_SESS_ACCOUNT_SESSID );
	$uid = $accountdata[TELEMERGECONSTANT_SESS_UID];

	// lets get the sessiondata of the selected voice file	
	$sess_upload_data = $session->getAttribute( 'sess_upload_data' );
	$tmp_uploadID = $sess_upload_data[0]->uploadID;
	//print_r($sess_upload_data );
	
	//print_r($_POST);
	$maxfilesize = $conf_maxfilesize['voicefile']; // 5mb
	$uploadpath = '.';
	$allowedextensions = array( 'mp3' , 'wav' , 'wma' );
	
	$uploaddata = array(
		'uploadname' => $_POST['uploadname'] , 
		'uploaddesc' => $_POST['uploaddesc']
	);
	$session->setAttribute( 'uploaddata' , $uploaddata );	
		


	$action = $_POST['action'];
	
	switch( $action ) 
	{
		case 'insert':
			if ( isset( $_POST['submitupload'] ) ) 
			{
				// here ,, the user das upload a voice file ..
				if ( isset( $_FILES['uploadfile']['name'] )   ) 
				{
					$uploader = new httpupload( $uploadpath , 'uploadfile' );
					$uploader->setuploaddir( '../uploads/audio_files/' );
					$uploader->setmaxsize( $maxfilesize );
					$uploader->setallowext( $allowedextensions , ',' );
					// hash the target file to prevent name conflict
					// better, difficult to guess
					$targetfile = substr( md5(uniqid(rand(), true) ),0 , 7 );
					//$targetfile .= '_' . $myts->make_friendly_str( $_FILES['uploadfile']['name'] ) ;					
					$targetfile .= '_' . $_FILES['uploadfile']['name'];		
					$targetfile = str_replace( ' ', '_' , $targetfile );

					// get extension and filename
					$ext = strchr( $targetfile , '.' );
					$file = basename( $targetfile , $ext );
					$targetfile = $myts->make_friendly_str( $file ) . $ext ;
					
					$uploader->settargetfile( $targetfile );
					if ( $uploader->hasUpload() ) 
					{
						if ($uploader->upload()) 
						{
							$result = 'Your file has been uploaded successfuly.<br>';
							$result .= "File size : " . $uploader->getuploadsize() . " byte<BR>";
							$result .= "File MIME : " . $uploader->getuploadtype() . "<BR>";
							$result .= "Orginal filename : " . $uploader->getuploadname() . "<BR>";
							$result .= "Saved filename : " . $uploader->targetName . "<BR>";					
							$thisdata = array();
							$thisdata = array(
								'uploadname' => $_POST['uploadname'] , 
								'uploaddesc' => $_POST['uploaddesc'] ,
								'priority'	=> $_POST['priority'],
								'uploadfilename' => $targetfile ,
								'userID' => $_POST['userID'] ,
								'uploaddate' => time() 
							);
							$result = $upload->saveData( $thisdata );	
							if ( !$result ) die('not saved');			
							//$_SESSION['msg'] = 'Successfully update items :' ;
							$session->setAttribute( 'msg' ,  'Successfully saved item. ' . $myts->htmlspecialchars( $thisdata['uploadname'] ));
							header('Location: ' .  ( $_SERVER['HTTP_REFERER'] ) );
							exit;
							$errorfound = 0;
						}
						else 
						{
							$result = " There was a problem with your uploaded file. ";
							$result .= $uploader->get_error();
							$errorfound = 1;	
							$session->setAttribute( 'upload_form_errors' , array( $result ) );			
							header('Location: ' .  ( $_SERVER['HTTP_REFERER'] ) );
							exit;
						}
					}
					else
					{
						$result = 'No file was submitted.';
						$session->setAttribute( 'upload_form_errors' , array( $result ) );	
						header('Location: ' .  ( $_SERVER['HTTP_REFERER'] ) );
						exit;
					}
				}
			}	
							
			break;
		case 'update':
			if ( isset( $_POST['submitupload'] ) ) 
			{
				// here ,, the user das upload a new voice file ..
				if ( isset( $_FILES['uploadfile']['name'] ) && $_FILES['uploadfile']['name'] != ''  ) 
				{
					$uploader = new httpupload( $uploadpath , 'uploadfile' );
					$uploader->setuploaddir( '../uploads/audio_files/' );
					$uploader->setmaxsize( $maxfilesize );
					$uploader->setallowext( $allowedextensions , ',' );
					 
					// hash the target file to prevent name conflict
					// better, difficult to guess
					$targetfile = substr( md5(uniqid(rand(), true) ),0 , 7 );
					$targetfile .= '_' . $_FILES['uploadfile']['name'];		
					$targetfile = str_replace( ' ', '_' , $targetfile );

					// get extension and filename
					$ext = strchr( $targetfile , '.' );
					$file = basename( $targetfile , $ext );
					$targetfile = $myts->make_friendly_str( $file ) . $ext ;
					
					$uploader->settargetfile( $targetfile );
					if ( $uploader->hasUpload() ) 
					{
						if ($uploader->upload()) 
						{
							$thisdata = array();
							$thisdata = array(
								'uploadname' => $_POST['uploadname'] , 
								'uploaddesc' => $_POST['uploaddesc'] ,
								'priority'	=> $_POST['priority'],
								'uploadfilename' => $targetfile ,
								'userID' => $_POST['userID'] ,
								'uploaddate' => time() 
							);
							// remove old voice file .. . then replace the new 
							// uploaded voice file..
							$oldfile = $upload->getUploadDetails( $tmp_uploadID , $uid , array( 'uploadfilename' ) );
							$path = '../uploads/audio_files/';
							$thisfile = $path . $oldfile[0]->uploadfilename ;
							
							if ( file_exists( $thisfile ) ) 
							{
								@unlink( $thisfile );
							}
							$where = " uploadID = $tmp_uploadID  and userID = " . intval( $_POST['userID'] ) ;
							$result = $upload->updateData( $thisdata , $where );				
							if ( $result ) 
							{
								$msg = 'Successfully saved File ID ' . $myts->htmlspecialchars( $_POST['fileid'] ) ;
								$session->setAttribute( 'msg' , $msg );
							}
							header('Location: list.php?menuclick=1');
							exit;
						}
						else 
						{
							$result = "There was a problem with your uploaded file. ";
							$result .= $uploader->get_error();
							$errorfound = 1;	
							$session->setAttribute( 'upload_form_errors' , array( $result ) );	
							header('Location: ' .  ( $_SERVER['HTTP_REFERER'] ) );
							exit;
						}
					}
					else
					{
						$result = 'No file was submitted.';
						$session->setAttribute( 'upload_form_errors' , array( $result ) );	
						header('Location: ' .  ( $_SERVER['HTTP_REFERER'] ) );
						exit;
					}
					
				}
				else
				{ 
				// here ,, we assume that the user doesnt upload , 
				// or change the currently stored voice file
				$thisdata = array();
				$thisdata = array(
					'uploadname' => $_POST['uploadname'] , 
					'uploaddesc' => $_POST['uploaddesc'] ,
					'priority'	=> $_POST['priority'],
				);
				$where = " uploadID = $tmp_uploadID  and userID = " . intval( $_POST['userID'] );				
				$upload->updateData( $thisdata , $where );				
				//$_SESSION['msg'] = 'Successfully saved items :' .  $_POST['uploadname'] ;
				$session->setAttribute( 'msg' , 'Successfully saved File ID ' .  $myts->htmlspecialchars( $_POST['fileid'] ) ) ;
				header('Location: list.php?menuclick=1');
				exit;
				}
			}	
			break;	
	}

	//unset( $_SESSION['uploaddata'] );					

?>