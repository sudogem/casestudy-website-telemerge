<?php
require_once ( 'config/conf.php' );
require_once ( 'config/constants.php' );
require_once ( 'sysfunctions/sysfunc.php' );
require_once ( 'libraries/class.database.php' );
require_once ( 'libraries/class.client_testimonials.php' );
require_once ( 'libraries/class.useraccount.php' );
require_once ( 'web/class.sessions.php' );
require_once ( 'web/class.request.php' );

$session = new sessions();
$db = new database ( $conf['dbhost'] , $conf['dbusername'] , $conf['dbpassword'] , $conf['dbdatabasename'] );

$data = $session->getAttribute( TELEMERGECONSTANT_SESS_ACCOUNT_SESSID );
$uname = $data[TELEMERGECONSTANT_SESS_UNAME];
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
    <li><a href="clienttestimonial.php" class="active">Client Testimonials</a></li>
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
  <?php
  $testi = new clientTestimonials;
  $account = new userAccount;
  $result = $testi->getPublishedClientTestimonials(0);
  // print_r($result);
  ?>
  <div class="client-testimonial" >
  	<h1 class="cap2 capline">Client Testimonial</h1>
	<?php
	$n = count($result);
	for( $i=0 ; $i<$n; $i++ )
	{
		$msg = $result[$i]->message ;
		$accountdata = $account->getUserAccountData( $result[$i]->userID );  
	?>
	<p class="text"><?php echo $msg ; ?></p>
	<h1 class="cap4">-<?php echo $accountdata[0]->fullname ;?> , <?php echo $accountdata[0]->occupation ;?>&nbsp;/&nbsp;<?php echo $accountdata[0]->company ;?></h1><br />
	<?php } ?>
	<?php
	if ( ( $session->isAttributeExist( TELEMERGECONSTANT_SESS_ACCOUNT_SESSID ) == true ))	
	{
	?>
	<h1 class="cap2" >Submit your testimonial here : </h1>Logged in : <?php echo $uname ; ?> <a href="systempanel/list.php" >[Go to Control Panel]</a> <a href="sign-out.php" >[Sign-out]</a>
	<br class="spacer">
	<form name="testi" method="post" action="sendtestimonial.php" >
					 Enter your testimonial :					<br class="spacer" />
					<textarea cols="35" rows="10" name="message" class="formtextfield"></textarea>
											<br>
					<p class="submit"><input name="submit" value="Submit &raquo;" class="button" onclick="validate()" type="submit"></p>
	</form>				
	<?php
	}
	?>
  </div>
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
