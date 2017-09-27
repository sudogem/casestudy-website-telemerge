<?php
	
	require_once ( '../config/conf.php' );
	require_once ( '../config/constants.php' );
	require_once ( '../libraries/class.database.php' );
	require_once ( '../libraries/class.sanitizer.php' );
	require_once ( '../libraries/class.useraccount.php' );
	require_once ( '../libraries/class.transcribed_docs.php' );
	require_once ( '../libraries/class.validator.php' );
	require_once ( '../libraries/class.httpupload.php' );
	require_once ( '../http/class.sessions.php' );
	
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

	// lets get the sessiondata of the selected voice file	
	$sess_upload_data = $session->getAttribute( 'sess_upload_data' );
	// print_r($sess_upload_data);
	$tmp_uploadID = $sess_upload_data[0]->uploadID;
	$tmp_uploadname = $sess_upload_data[0]->uploadID ;
	$maxfilesize = $conf_maxfilesize['voicefile']; // 5mb
	$uploadpath = '.';
	$allowedextensions = array( 'doc' , 'txt' , 'rtf' );
	
	$action = $_POST['action'];
	// print_r($_FILES);
	switch( $action  )
	{
		case 'update':
			if ( isset( $_FILES['uploadfile'] )  && $_FILES['uploadfile']['name'] != ''  ) 
			{
				$uploader = new httpupload( $uploadpath , 'uploadfile' );
				$uploader->setuploaddir( '../uploads/document_files' );
				$uploader->setmaxsize( $maxfilesize );
				$uploader->setallowext( $allowedextensions , ',' );
				// hash the target file to prevent name conflict
				// better, difficult to guess
				$targetfile = substr( md5(uniqid(rand(), true) ),0 , 5 );
				$targetfile .= '_' . $_FILES['uploadfile']['name'];		
				$targetfile = str_replace( ' ' , '_' , $targetfile );
				
				// get extension and filename
				$ext = strchr( $targetfile , '.' );
				$file = basename( $targetfile , $ext );
				$targetfile = $myts->make_friendly_str( $file ) . $ext ;
				//echo $targetfile ;
				$uploader->settargetfile( $targetfile );
				if ( $uploader->hasUpload() ) 
				{
					if ($uploader->upload()) 
					{
						$result = 'Your file has been uploaded successfuly.<br>';
						$result .= "File size : " . $uploader->getuploadsize() . " byte<BR>";
						$result .= "File MIME : " . $uploader->getuploadtype() . "<BR>";
						$result .= "Orginal name : " . $uploader->getuploadname() . "<BR>";
						$transcribed_docs = new transcribedDocs( );

						// remove old voice file .. . then replace the new 
						// uploaded voice file..
						$oldfile = $transcribed_docs->getUploadDetails( $tmp_uploadID , 0  );
						$path = '../uploads/document_files/';
						$filen = $oldfile[0]->docfilename ;
						$thisfile = $path  .  $filen ;
						$docID = $oldfile[0]->docID ;
						// if the file is exists
						if ( isset( $filen ) && $filen != '' ) 
						{
							$data = array( );
							$data = array (
								'docfilename' => $targetfile
							);
						
							@unlink( $thisfile );
							$result = $transcribed_docs->updateData( $data , " docID = $docID"  );	
							if ( $result ) 
							{
								$msg = 'Successfully update File ID ' . $myts->htmlspecialchars( $tmp_uploadname ) ;
								$session->setAttribute( 'msg' , $msg );
							}									
						}
						else
						{
							$data = array( );
							$data = array (
								'uploadID' => $tmp_uploadID ,
								'docfilename' => $targetfile
							);
						
							$result = $transcribed_docs->saveData( $data  );	
							if ( $result ) 
							{
								$msg = 'Successfully update File ID ' . $myts->htmlspecialchars( $tmp_uploadname ) ;
								$session->setAttribute( 'msg' , $msg );
							}									
						}
													
						header('Location: list.php');
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
				$result = 'No file was submitted.';
				$session->setAttribute( 'upload_form_errors' , array( $result ) );			
				header('Location: ' .  ( $_SERVER['HTTP_REFERER'] ) );
				exit;
			}
			break;	
	}
?>