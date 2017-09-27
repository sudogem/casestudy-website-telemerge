<?php  
require_once ( 'libraries/class.validator.php' ) ;
require_once ( 'libraries/class.database.php' ) ;
require_once ( 'libraries/class.sanitizer.php' ) ;
require_once ( 'libraries/class.useraccount.php' ) ;
require_once ( 'http/class.sessions.php' );
require_once ( 'config/conf.php' );

$db = new database ( $conf['dbhost'] , $conf['dbusername'] , $conf['dbpassword'] , $conf['dbdatabasename'] );
$session = new sessions();

if ( isset( $_POST['submit'] )  ) 
{
//print_r($_POST);
	// format bdate to timestamp
	$bdate_t = mktime( 0 ,0,0,$_POST['month'] ,$_POST['day'] , $_POST['year'] );
	$_POST['birthdate'] = $bdate_t;
	array_push( $_POST , array( $_POST['birthdate'] => $bdate_t ) );  		
	$username = (!get_magic_quotes_gpc()) ? addslashes( $_POST['username'] ) : $_POST['username'] ;
	$val = new validator();
	$thisfields = array( 
	'username' => ' * Please input your username. ' , 
	'password' => ' * Please input your password. ' , 
	'verify_password' , 
	'fullname' => ' * Please input your fullname. ' ,
	'email' => ' * Please input your email address.' ,
	'address' => ' * Please input your homeaddress.' ,
	'contactno' => ' * Please input your contact no. ' ,
	'occupation' => ' * Please input your occupation. ' ,
	'usertypeID' => '' ,
	'birthdate' => '' ,
	'securitycode' => ' * Please input the captcha code.' 
	);
	
	// filter group
	$validgroup = array( 2 , 3 );
	if ( !in_array(	intval( $_POST['usertypeID'] ) , $validgroup ) )
	{
		$val->setErrors( ' * You try to register an invalid group. ' ) ;	
	}

	// check the two pasword..
	!( $val->validateFieldStrcmp( $_POST['password'] , $_POST['verify_password'] ) ) ? $val->setErrors( ' * Verification password doesnt match.' )  : '' ;
	// chek if fields are empty..
	$val->validateFieldIsEmpty( $_POST , $thisfields );
	// chek email	
	!( $val->validateEmail( $_POST['email'] ) ) ? $val->setErrors(' * Invalid email address.') : '';
	// chek uname
	!( $val->validateAlphaNumeric( $_POST['username'] ) ) ? $val->setErrors(' * Username must be a combination of letters and/or numbers with no spaces and other special characters.') : '';

	// chek uname
	!( $val->validateAlphaNumeric( $_POST['password'] ) ) ? $val->setErrors(' * Password must be a combination of letters and/or numbers with no spaces and other special characters.') : '';

	// chek contact tel no
	!( $val->is_unsign_number( $_POST['contactno'] ) ) ? $val->setErrors(' * Tel nos. must be a digit.') : '';
	
	if ( $_SESSION['captcha'] != $_POST['securitycode'] )
	{
		// $val->setErrors( ' * Captcha Code is invalid. Please type the valid code number.' );
	}

	$session->setAttribute( 'userdata' ,  
		array( 
			'username' => $_POST['username'] , 
			'fullname' => $_POST['fullname'] ,
			'gender' => $_POST['gender'] ,
			'email' => $_POST['email'] ,		
			'address' => $_POST['address'] ,
			'contactno' => $_POST['contactno'] ,
			'occupation' => $_POST['occupation'] ,
			'birthdate' => $_POST['birthdate'] ,
			'usertypeID' => $_POST['usertypeID'] ,
			'affiliation' => $_POST['affiliation'] ,
			'country' => $_POST['country']			
		) );
	
	if ( count( $val->errors ) - 1 > 0 ) {
		$session->setAttribute( 'result_message' , $val->getErrors() );
		$session->writeSession();	
		header("Location: signup.php");
		exit;
	}
	else{
		$user = new UserAccount();
		$res = $user->isUsernameExist( $username ) ; 
		if ( true == $res )
		{
			$val->setErrors(' * Username already exists. Please choose another username.');
			$session->setAttribute( 'result_message' , $val->getErrors() );
			$session->writeSession();
			header("Location: signup.php");
			exit;
		}
		
		$data = array(
		'username' => $_POST['username'] ,
		'password' => $_POST['password'] , 
		'fullname' => $_POST['fullname'] ,
		'gender' => $_POST['gender'] ,
		'email' => $_POST['email'] ,		
		'address' => $_POST['address'] ,
		'contactno' => $_POST['contactno'] ,
		'position' => $_POST['occupation'] ,
		'status' => 'waiting for approval' ,
		'birthdate' => $_POST['birthdate'] ,
		'country' => $_POST['country'] ,
		'usertypeID' => $_POST['usertypeID'] ,
		'affiliation' => $_POST['affiliation'] ,
		'registerdate' => $_POST['registerdate'] ,
		'lastvisitdate' => $_POST['lastvisitdate']
		);
		
		$ok = $user->saveData( $data );
		if ( $ok ) {
			$message = '<br /><br /><br />Finally , the registration is complete. The site admin will approve your membership and you will receive a 
confirmation email alerting you that your account has been approved. Thank you very much.. <br />';	
			$message .= 'Note that you must activate the account by clicking on the 
activation link when you get the e-mail before you can login. Thanks!';	

		}
		else{
			$message = '<br /><br /><br />There was an error in registration process. <br />';
			$message .= 'Kindly contact the site administrator regarding this problem. Thanks.';
		}
	}
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
    <li><a href="index.php" id="cmdhome"  >Home</a></li>
    <li><a href="aboutus.php" id="cmdabout" >About Us</a></li>
    <li><a href="hipaa.php" id="cmdhipaa" >HIPAA</a></li>
    <li><a href="freetrial.php" id="cmdfreetrial" >Free Trial</a></li>
    <li><a href="contactus.php" id="cmdcontact"  >Contact Us</a></li>
    <li><a href="what_is_medical_transcription.php" id="cmdmt" >Medical Transcription</a></li>
    <li><a href="request_info.php" id="cmdrequest" >Request Info</a></li>
  </ul>
  <!-- InstanceEndEditable -->
  <div class="clear" ></div>
  <!-- InstanceBeginEditable name="front-content" -->
  <?php
  echo $message ;
  ?>
  <p><a href="http://www.teletranscription.com" >&laquo; Back to home</a></p>
  <div class="clear" >&nbsp;</div>
  <div style="height:200px;" >&nbsp;</div>
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
