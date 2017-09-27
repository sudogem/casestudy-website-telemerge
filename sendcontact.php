<?php
	require_once ( 'libraries/class.phpmailer.php' );
	require_once ( 'libraries/class.validator.php' );
	require_once ( 'sysfunctions/sysfunc.php' );
	require_once ( 'http/class.sessions.php' );
	require_once ( 'config/conf.php' );
	
	//print_r($_POST);
	
	$session = new sessions();

	if ( isset( $_POST['submit'] ) ) 
	{
		$session->setAttribute( 'userdata' , 
			array( 
				'name' => $_POST['name'] , 
				'email' => $_POST['email'] ,
				'subject' => $_POST['subject'] ,
				'message' => $_POST['message'] ,		
				'contactno' => $_POST['contactno'] ,
			) );
		
	
		$val = new validator();
		$thisfields = array( 
			'name' => ' * Please input your name. ' , 
			'email' => ' * Please input your email address.' ,
			'subject' => ' * Please input a subject.' ,
			'message' => ' * Please input your message. ' ,
			'contactno' => ' * Please input your contact no. ' ,
			// 'securitycode' => ' * Please input the security code.' 
		);

		if ( $_SESSION['captcha'] != $_POST['securitycode'] )
		{
			// $val->setErrors( ' * Security Code is invalid. Please type the valid code number.' );
		}
		
		// chek if fields are empty..
		$val->validateFieldIsEmpty( $_POST , $thisfields );
		if ( count( $val->errors ) - 1 > 0 ) 
		{
			$session->setAttribute( 'result_message' , $val->getErrors() );
			$session->writeSession();	
			header("Location: contactus.php");
			exit;
		}
		else
		{
			$mail = new phpmailer;
			$from = $_POST['email'];
			$mail->From = $from;
			$mail->FromName = $_POST['name'];
			
			$to = $conf['mail_c_to'] ;
			$mail->AddAddress( $to );         
			
			if ( $_POST['email_copy'] != '' ) $mail->AddCC( $from );                        
			$mail->AddReplyTo( $_POST['email'] , 'RE:' );
			$mail->IsHTML( true );    	

			$subject = $conf['mail_c_subject'] ;
			$mail->Subject = $subject;
			$data = array();
			$data['name'] = $_POST['name'];
			$data['email'] = $_POST['email'];
			$data['contactno'] = $_POST['contactno'];
			$data['subject'] = $_POST['subject'];
			$data['message'] = $_POST['message'];
			$mailtemplate = load_email_message_template( 'contactus' , $data  );						
			$mail->Body = $mailtemplate  ;
			$mail->AltBody = "This is the body in plain text for non-HTML mail clients";
			if(!$mail->Send())
			{
			   $msg = "Message could not be sent. <br />";
			   $msg .= "Mailer Error: " . $mail->ErrorInfo;
			}
			else 
			{
$msg = "Thank you for filling in your details. We will be getting back to you as soon as possible.";
			}
		
		}
	}

?>  
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html><!-- InstanceBegin template="/Templates/index.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="developer+designer" content="Arman Ortega :: arman.ortega{att}yahoo{dot}com" />
<meta name="robots" content="index , follow"  />
<meta name="revisit-after" content="7 days"  />
<meta name="description" content="Telemerge is a medical transcription company catering the increasing demand for accurate and effective data gathering and storage.The company is owned and operated by Telemerge Company Inc. A very young and promising corporation composed of tested and successful businessman in Cebu."  />
<meta name="keywords" content="cebu medical transcription , medical transcription company , affordable medical transcription ,  philippine medical transcription , affordable medical transcription in cebu , transcriptionists , outsource medical transcription "  />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Telemerge Corporation</title>
<!-- InstanceEndEditable -->
<link rel="stylesheet" href="css/style.css" media="screen" type="text/css"  />
<script type="text/javascript" src="js/footer.js" language="javascript" ></script>
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
</head>

<body>
<div id= "container" >
  <div id="header"><span>Logo</span></div>
  <div id="slogan" >Telemerge Leading the World of Transcription...</div>
  <!-- InstanceBeginEditable name="topnav" -->
  <ul id="topnav">
    <li><a href="job.php">Job Opportunities</a> </li>
    <li><a href="clienttestimonial.php">Client Testimonials</a></li>
  </ul>
  <div class="clear"></div>
  
  <!-- InstanceEndEditable --><!-- InstanceBeginEditable name="nav" -->
  <ul id="nav" >
    <li><a href="index.php" id="cmdhome" >Home</a></li>
    <li><a href="aboutus.php" id="cmdabout" >About Us</a></li>
    <li><a href="hipaa.php" id="cmdhipaa" >HIPAA</a></li>
    <li><a href="freetrial.php" id="cmdfreetrial" >Free Trial</a></li>
    <li><a href="contactus.php" id="cmdcontact"  class="cmddefault">Contact Us</a></li>
    <li><a href="what_is_medical_transcription.php" id="cmdmt" >Medical Transcription</a></li>
    <li><a href="request_info.php" id="cmdrequest" >Request Info</a></li>
  </ul>
  <!-- InstanceEndEditable -->
  <div class="clear" ></div>
  <!-- InstanceBeginEditable name="front-content" -->
<?php echo '<h1 class="cap2" >' . $msg . '</h1>' ; ?>
  <p><a href="http://www.teletranscription.com" >&laquo; Back to home</a></p>
  <div style="height:350px;" >&nbsp;</div>
  <!-- InstanceEndEditable -->
  
	<div class="clear" ></div>
	
</div>
	<div id="footer" >
		<div id="wrapper" >
			<div id="contact-info" class="left" >
				<h1><b>Contact :</b></h1>
				<h1>John Doe </h1>
				<h1>CEO, Telemerge Corporation </h1>
				<h1>Cebu  Philippines 6000</h1>				
				<h1>Email: johndoe@telemerge.com</h1>		
				<h1>Contact No: 1800-1234-5678</h1>
			</div>
			
				<!-- InstanceBeginEditable name="footnav" -->
				<ul id="footnav" >
				  <li><a href="terms.php">Terms of Use</a>&nbsp;|&nbsp;</li>
				  <li><a href="privacy-policy.php">Privacy Policy</a>&nbsp;|&nbsp;</li>
				  <li><a href="contactus.php">Contact Us</a>&nbsp;|&nbsp;</li>
				  <li><a href="sitemap.php">Sitemap</a>&nbsp;|&nbsp;</li>
			    </ul>
				<!-- InstanceEndEditable -->
				<div id="copyright" >
					<h1>Copyright &copy; 2006. Telemerge Corporation. All Rights Reserved.</h1>
				</div>
		</div>
	</div>	

</body>
<!-- InstanceEnd --></html>
