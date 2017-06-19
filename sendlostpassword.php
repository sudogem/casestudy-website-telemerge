<?php
require_once ( 'libraries/class.phpmailer.php' );	
require_once ( 'libraries/class.database.php' );
require_once ( 'libraries/class.useraccount.php' );
require_once ( 'config/conf.php' );

$db = new database ( $conf['dbhost'] , $conf['dbusername'] , $conf['dbpassword'] , $conf['dbdatabasename'] );

if ( isset( $_POST['submit'] ) )
{
	
	$from = trim( $_POST['email'] );
	
	if ( isset( $from ) && $from != '' )
	{
		$account = new UserAccount;
		$result = $account->isEmailExist( $from );

		if ( $result )
		{
			$data = $account->getUserAccountSelectedData( array( 'password' ) , "email = '$from' " );
			$mail = new phpmailer;		
			$mail->From = $conf['mail_from'] ;
			$mail->AddAddress( $from );         
			$mail->AddReplyTo( $_POST['email'] , 'RE:' );
			$mail->IsHTML( true );    	
			$subject = 'Lost Your Password';
			$mail->Subject = $subject;
			$pw = $data[0]->password ;
			$body = " Your password is $pw " ;
			// echo $body ;
			$mail->Body    = $body ;
			$mail->AltBody = $body ;
			if(!$mail->Send())
			{
			   $msg = "Message could not be sent. <br />";
			   $msg .= "Mailer Error: " . $mail->ErrorInfo;
			}
			else 
			{
				$msg = "We will email your password to the email address you provided.";
			}
		
		}
		else
		{
			$msg = "Email does not exist.";
		}
			
	}
}
?>
<?php echo $msg; ?>
