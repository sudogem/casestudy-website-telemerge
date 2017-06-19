<?php
	require_once ( 'libraries/class.phpmailer.php' );
	require_once ( 'libraries/class.httpupload.php' );
	require_once ( 'libraries/class.database.php' );
	require_once ( 'web/class.sessions.php' );
	require_once ( 'libraries/class.resume.php' );
	require_once ( 'libraries/class.sanitizer.php' );
	require_once ( 'libraries/class.validator.php' );
	require_once ( 'config/conf.php' );
	
	$session = new sessions();
	$db = new database ( $conf['dbhost'] , $conf['dbusername'] , $conf['dbpassword'] , $conf['dbdatabasename'] );

	/*$mail = new phpmailer;
	
	$from = $_POST['email'];
	$mail->From = $from;
	$mail->FromName = $_POST['name'];
	
	$to = $conf['mail_c_to'] ;
	$mail->AddAddress( $to );         
	
	if ( $_POST['email_copy'] != '' ) $mail->AddCC( $from );                        
	$mail->AddReplyTo( $_POST['email'] , 'RE:' );
	$mail->IsHTML( true );    	*/

	$uploaddata = array(
		'name' => $_POST['name'] , 
		'email' => $_POST['email'] ,
		'position_desired' => $_POST['position_desired']
	);
	$session->setAttribute( 'uploaddata' , $uploaddata );	

	if ( isset( $_POST['submit'] ) )
	{
		$val = new validator();
		$fields = array(
			'name' => ' * Please input your name.' ,
			'email' => ' * Please input your  email.' ,
			'position_desired' => ' * Please input your desired position.' ,
			'coverletter' => ' * Please upload your cover letter.' ,
			'resume' => ' * Please upload your resume.'
		);
		
		$val->validateFieldIsEmpty( $_POST , $fields );
		// chek email	
		!( $val->validateEmail( $_POST['email'] ) ) ? $val->setErrors(' * Invalid email address.') : '';
		
		if ( count( $val->errors ) > 0 ) 
		{
			$err = $val->getErrors();
			$session->setAttribute( 'upload_form_errors' , $err );			
			header('Location: ' . $_SERVER['HTTP_REFERER'] );
			exit;
		}
	}
	
	$maxfilesize = 6000000;
	$allowedextensions = array( 'pdf' , 'doc' , 'txt' );	
	$targetfile = substr( md5(uniqid(rand(), true) ),0 , 7 );	
	$targetfile2 = $targetfile ;
	if ( isset( $_FILES['resume']['name'] ) )
	{
		$uploader = new httpupload( $uploadpath , 'resume' );
		$uploader->setuploaddir( 'uploads/resume_files/' );
		$uploader->setmaxsize( $maxfilesize );

		$uploader->setallowext( $allowedextensions , ',' );
		// hash the target file to prevent name conflict
		// better, difficult to guess

		//$targetfile .= '_' . $myts->make_friendly_str( $_FILES['uploadfile']['name'] ) ;					
		$targetfile .= '_resume_' . $_FILES['resume']['name'] ;		
		$targetfile = str_replace( ' ', '_' , $targetfile );
		$uploader->settargetfile( $targetfile );
		if ( $uploader->hasUpload() ) 
		{
			if ( $uploader->upload() ) 
			{
			}
			else
			{
				$result = " There was a problem in uploading your resume file.";
				$result .= $uploader->get_error();
				$errorfound = 1;	
				$session->setAttribute( 'upload_form_errors' , array( $result ) );			
				header('Location: job.php');
				exit;
			}
		}	
	}

	if ( isset( $_FILES['coverletter']['name'] ) )
	{
		$uploader = new httpupload( $uploadpath , 'coverletter' );
		$uploader->setuploaddir( 'uploads/resume_files/' );
		$uploader->setmaxsize( $maxfilesize );
		$uploader->setallowext( $allowedextensions , ',' );
		// hash the target file to prevent name conflict
		// better, difficult to guess
		//$targetfile = substr( md5(uniqid(rand(), true) ),0 , 7 );
		//$targetfile .= '_' . $myts->make_friendly_str( $_FILES['uploadfile']['name'] ) ;					
		$targetfile2 .= '_coverletter_' . $_FILES['coverletter']['name'] ;		
		$targetfile2 = str_replace( ' ', '_' , $targetfile2 );
		$uploader->settargetfile( $targetfile2 );
		if ( $uploader->hasUpload() ) 
		{
			if ( $uploader->upload() ) 
			{
			}
			else
			{
				$result = " There was a problem in uploading your cover letter file.";
				$result .= $uploader->get_error();
				$errorfound = 1;	
				$session->setAttribute( 'upload_form_errors' , array( $result ) );			
				header('Location: job.php');
				exit;
			}
		}	
	}
	
	if ( isset( $_POST['submit'] ) )
	{
		$resume = new applicant_resume();
		$data = array
		(
			'name' => $_POST['name'] ,
			'email' => $_POST['email'] ,
			'position_desired' => $_POST['position_desired'] ,
			'coverletter' => $targetfile2 ,
			'resume' => $targetfile ,
			'datesubmitted' => time()
		);
		$result = $resume->addResume( $data );
		if ( $result )
		{
			$msg = "Successfully submit your resume.";
			
		}
		else
		{
			$msg = 'There was an error in submitting your resume. <br />';
			$msg .= 'Kindly contact the site administrator regarding this problem. Thanks.';
		}
	}
	/*$subject = $conf['mail_c_subject'] ;
	$mail->Subject = $subject;
	$mail->Body    = $_POST['message'];
	$mail->AltBody = "This is the body in plain text for non-HTML mail clients";
	if(!$mail->Send())
	{
	   $msg = "Message could not be sent. <br />";
	   $msg .= "Mailer Error: " . $mail->ErrorInfo;
	}
	else 
	{
		$msg = "Thank you for submitting your resume. We will look further you , please be guided.";
	}
 echo $msg ; */
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
    <li><a href="contactus.php" id="cmdcontact" >Contact Us</a></li>
    <li><a href="what_is_medical_transcription.php" id="cmdmt" >Medical Transcription</a></li>
    <li><a href="request_info.php" id="cmdrequest" >Request Info</a></li>
  </ul>
  <!-- InstanceEndEditable -->
  <div class="clear" ></div>
  <!-- InstanceBeginEditable name="front-content" -->
<br />  
Thank you for submitting your resume and cover letter.
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
