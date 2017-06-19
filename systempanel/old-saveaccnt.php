<?php

	require ( '../classes/class.loader.php' );
	require ( '../common.php' );
	require ( '../functions/functions.php' );
		
	//print_r($_SESSION);
	$ss = new SecureSession();
	$ss->check_browser = true;
	$ss->check_ip_blocks = 2;
	$ss->secure_word = '8de58831a8e6ea7f89a163c8214dbf67';
	$ss->regenerate_id = true;
	if (!$ss->Check() || !isset($_SESSION['logged_in']) || ( $_SESSION['logged_in'] == false ) || $_SESSION['guid'] != 1 )
	{
		header('Location: ../index.php');
		exit;
	}

//print_r($_POST);

$action = ( isset( $_POST['action'] ) ) ? $_POST['action'] : 'unknown_action' ;
switch ( $action ) 
{
	case 'update' :
		$myts =& textSanitizer::getInstance();
		$user = new UserAccount();
		$val = new validator();
		$thisfields = array( 
		'username' , 
		'password' , 
		'verify_password' , 
		'fullname' ,
		'email' ,
		'address' ,
		'contactno' ,
		'occupation' ,
		'usertypeID' ,
		'birthdate' 
		);
		// check the two pasword..
		!( $val->validateFieldStrcmp( $_POST['password'] , $_POST['verify_password'] ) ) ? $val->setErrors( 'Verification password doesnt match.' )  : '' ;
		
		// chek email	
		!( $val->validateEmail( $_POST['email'] ) ) ? $val->setErrors('Invalid email address.') : '';

		if ( count( $val->errors ) > 0 ) {
			$_SESSION['registration_form_errors'] = $val->getErrors();
			$_SESSION['userdata'] = array( 
			'username' => $myts->addSlashesGPC( $_POST['username'] ), 
			'fullname' => $myts->addSlashesGPC( $_POST['fullname'] ),
			'gender' => $_POST['gender'] ,
			'email' => $_POST['email'] ,		
			'address' => $myts->addSlashesGPC( $_POST['address'] ),
			'contactno' => $myts->addSlashesGPC( $_POST['contactno'] ),
			'occupation' => $myts->addSlashesGPC( $_POST['occupation'] ),
			'birthdate' => $_POST['birthdate'] ,
			'usertypeID' => $_POST['usertypeID'] ,
			'country' => $_POST['country']	
			);
			header("Location: " . $_SERVER['HTTP_REFERER'] );
			exit;
		}
		else {
			$user = new UserAccount();
			$user->setUserID( $_POST['userID'] );
			$res = $user->isUsernameExist( $username ) ; 
			if ( true == $res ){
				$val->setErrors('Username already exists. Please choose another username.');
				$_SESSION['registration_form_errors'] = $val->getErrors();
				session_write_close();			
				header("Location: " . $_SERVER['HTTP_REFERER'] );
				exit;
			}
			
			// convert bdate to timestamp..
			$bdate_t = mktime( 0 ,0,0,$_POST['month'] ,$_POST['day'] , $_POST['year'] );
			$_POST['birthdate'] = $bdate_t;
			
			if ( $_POST['password'] != '' ) 
			{
				$data = array( 'password' => $_POST['password'] );
				$user->updateUserAccountData( $data , " userID = " . $_POST['userID'] );			
			}
			$uid = $user->getUserID();						
			$lastv = $user->getLastVisitDate();			
			if ( isset( $_POST['status'] ) && $_POST['status'] == 'accepted' && $lastv == 0 ) 
			{
				$mail = new phpmailer();
				$actcode = $user->getUserActivationCode();
				$activationlink = 'http://www.primaryoffshore.com/activate.php?uid=' . $uid . '&code=' . $actcode ;
				include( '../config.php' );
				$to = $_POST['email'];
				$mail->From = $from;
				$mail->FromName = $ownerName;
				$mail->AddAddress( $to );                 
				$mail->AddReplyTo( $email , 'RE:' );
				$mail->IsHTML( true );    	
				
				$subject = 'Primary Offshore Registration';
				$mail->Subject = $subject;
				$mail->Body    = $message;
				$mail->AltBody = "This is the body in plain text for non-HTML mail clients";
				//echo 'm='.$message ;
				// if error .. the record on the db must retain ..				
				// if no error... continue saving the record to db...
				if(!$mail->Send())
				{
				   $err = "Message could not be sent. <p>";
				   $err .= "Mailer Error: " . $mail->ErrorInfo;
				   //die( $err );
				   //echo $err;		
				}
			}
			$data = array(
				'fullname' => $myts->stripSlashesGPC( $_POST['fullname'] ),
				'gender' => $myts->stripSlashesGPC( $_POST['gender'] ),
				'email' => $myts->stripSlashesGPC( $_POST['email'] ),		
				'address' => $myts->stripSlashesGPC( $_POST['address'] ),
				'contactno' => $myts->stripSlashesGPC( $_POST['contactno'] ),
				'occupation' => $myts->stripSlashesGPC( $_POST['occupation'] ),
				'birthdate' => $_POST['birthdate'] ,
				'usertypeID' => $_POST['usertypeID'] ,
				'country' => $_POST['country'] ,
				'status' => $myts->stripSlashesGPC( $_POST['status'] )	
			);
			
			$ok = $user->updateUserAccountData( $data , " userID = " . $_POST['userID'] );
			if ( $ok ) {
				$username = $_POST['username'];
				$message = 'Successfully updated items : ' . $username ;	
			}
			else{
				$message = 'There was an error in registration process. <br />';
				$message .= 'Kindly contact the site administrator regarding this problem. Thanks.';
			}
			$_SESSION['msg'] = $message ;
			header( 'Location: usermanager.php' );
			exit;	
		}
		
		break;
	default :
		die( 'Unknown action.' );
		break;	
}

?>