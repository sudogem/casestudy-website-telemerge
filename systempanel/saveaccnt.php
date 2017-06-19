<?php
// turn off error reporting when presenting to live site
error_reporting(0);

require_once ( '../config/conf.php' );
require_once ( '../config/constants.php' );
require_once ( '../libraries/class.database.php' );
require_once ( '../libraries/class.sanitizer.php' );
require_once ( '../libraries/class.useraccount.php' );
require_once ( '../libraries/class.articles.php' );
require_once ( '../libraries/class.validator.php' );
require_once ( '../libraries/class.phpmailer.php' );
require_once ( '../web/class.sessions.php' );

$db = new database ( $conf['dbhost'] , $conf['dbusername'] , $conf['dbpassword'] , $conf['dbdatabasename'] );

$session = new sessions();
$myts = new textSanitizer();

if ( ( $session->isAttributeExist( TELEMERGECONSTANT_SESS_ACCOUNT_SESSID ) == NULL ) || 
	( $session->isAttributeExist( TELEMERGECONSTANT_SESS_ACCOUNT_SESSID ) == FALSE ) )	{
	header( 'Location: ../index.php' );
	exit ;
}	

$action = ( isset( $_POST['action'] ) ) ? $_POST['action'] : 'null' ;

//print_r($_POST);

// convert bdate to timestamp..
$bdate_t = mktime( 0 ,0,0,$_POST['month'] ,$_POST['day'] , $_POST['year'] );
$_POST['birthdate'] = $bdate_t;

$useraccountdata = array(
	'fullname' => $_POST['fullname'] ,
	'gender' => $_POST['gender'] ,
	'email' => $_POST['email'] ,		
	'address' => $_POST['address'] ,
	'contactno' => $_POST['contactno'] ,
	'position' => $_POST['position'] ,
	'birthdate' => $_POST['birthdate'] ,
	'usertypeID' => $_POST['usertypeID'] ,
	'country' => $_POST['country'] ,
	'status' =>	$_POST['status'] 
);
$session->setAttribute( 'useraccountdata' , $useraccountdata );	

#print_r($_POST);
switch ( $action ) 
{
	case 'update' :
		$myts =& textSanitizer::getInstance();
		$user = new UserAccount();
		$val = new validator();
		/*$thisfields = array( 
			'username' , 
			'password' , 
			'verify_password' , 
			'fullname' ,
			'email' ,
			'address' ,
			'contactno' ,
			'position' ,
			'usertypeID' ,
			'birthdate' 
		);*/
		
		// check the two pasword..
		!( $val->validateFieldStrcmp( $_POST['password'] , $_POST['verify_password'] ) ) ? $val->setErrors( ' * Verification password doesnt match.' )  : '' ;
		
		// chek email	
		!( $val->validateEmail( $_POST['email'] ) ) ? $val->setErrors(' * Invalid email address.') : '';
		
		$fields = array(
			'fullname' => ' * Please input a fullname.' ,
			'contactno' => ' * Please input a contact no. ' ,
			'address' => ' * Please input a home address.' ,
			'email'	=> ' * Please input an email address.'
		);
		$val->validateFieldIsEmpty( $_POST , $fields );	
		if ( count( $val->errors ) > 0 ) {
			// $_SESSION['registration_form_errors'] = $val->getErrors();
			$session->setAttribute( 'registration_form_errors' , $val->getErrors() );
			header("Location: " . $_SERVER['HTTP_REFERER'] );
			exit;
		}
		else {
			$user = new UserAccount();
			$user->setUserID( intval( $_POST['userID'] ) );
			/*$res = $user->isUsernameExist( $username ) ; 
			if ( true == $res ){
				$val->setErrors('Username already exists. Please choose another username.');
				$_SESSION['registration_form_errors'] = $val->getErrors();
				session_write_close();			
				header("Location: " . $_SERVER['HTTP_REFERER'] );
				exit;
			}*/
			
			// convert bdate to timestamp..
			$bdate_t = mktime( 0 ,0,0,$_POST['month'] ,$_POST['day'] , $_POST['year'] );
			$_POST['birthdate'] = $bdate_t;
			
			if ( trim($_POST['password']) != '' ) 
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
				$activationlink = 'http://www.teletranscription.com/activate.php?uid=' . $uid . '&code=' . $actcode ;
				$to = $_POST['email'];
				$mail->From =  $conf['mail_from'] ;
				$mail->FromName = $ownerName;
				$mail->AddAddress( $to );                 
				$mail->AddReplyTo( $email , 'RE:' );
				$mail->IsHTML( true );    	
				
				$subject = 'Telemerge Transcription Registration Confirmation';
$message = "
Hello, <br>
Thank you for signing up! Click or copy and paste this URL to your browser to 
activate your account: <br>
Please activate your account by going to: <br>
$activationlink
<br>
Thanks!
<br>
<br>
Telemerge Transcription
"  ;
				$mail->Subject = $subject;
				$mail->Body    = $message;
				$mail->AltBody = $message ;
				//echo 'm='.$message ;
				if(!$mail->Send())
				{
				   $err = "Message could not be sent. <p>";
				   $err .= "Mailer Error: " . $mail->ErrorInfo;
				   //die( $err );
				   //echo $err;		
				}
			}
			/*$data = array(
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
			);*/
			
			$ok = $user->updateUserAccountData( $useraccountdata , " userID = " . intval( $_POST['userID'] ));
			if ( $ok ) {
				$username = $_POST['username'];
				$message = ' Successfully update profile. ' ;
			}
			else{
				$message = 'There was an error in registration process. <br />';
				$message .= 'Kindly contact the site administrator regarding this problem. Thanks.';
			}
			$session->setAttribute( 'msg' , $message );
			
			$data = $session->getAttribute( TELEMERGECONSTANT_SESS_ACCOUNT_SESSID );
			$guid = $data[TELEMERGECONSTANT_SESS_GUID];
			switch( $guid )
			{
				case TELEMERGECONSTANT_GUID_CLIENT :
					header( 'Location: editprofile.php?menuclick=2' );				
					break ;
				case TELEMERGECONSTANT_GUID_ADMIN :
					header( 'Location: usermanager.php?menuclick=3' );				
					break ;
				case TELEMERGECONSTANT_GUID_MT :
					header( 'Location: editprofile.php?menuclick=2' );						
					break ;		
			}
			exit;	
		}
		
		break;
	default :
		die( 'Unknown action.' );
		break;	
}

?>