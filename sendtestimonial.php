<?php
if ( isset( $_POST['submit'] ) && trim( $_POST['message'] ) == ''  )
{
		header('Location: clienttestimonial.php');
		exit;
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
    <li><a href="#" id="cmdhome" class="cmddefault" >Home</a></li>
    <li><a href="#" id="cmdabout" >About Us</a></li>
    <li><a href="#" id="cmdhipaa" >HIPAA</a></li>
    <li><a href="#" id="cmdfreetrial" >Free Trial</a></li>
    <li><a href="#" id="cmdcontact" >Contact Us</a></li>
    <li><a href="#" id="cmdmt" >Medical Transcription</a></li>
    <li><a href="#" id="cmdrequest" >Request Info</a></li>
  </ul>
  <!-- InstanceEndEditable -->
  <div class="clear" ></div>
  <!-- InstanceBeginEditable name="front-content" -->
  <div class="client-testimonial" >
<?php
require_once ( 'config/conf.php' );
require_once ( 'config/constants.php' );
require_once ( 'sysfunctions/sysfunc.php' );
require_once ( 'libraries/class.database.php' );
require_once ( 'libraries/class.sanitizer.php' );
require_once ( 'libraries/class.client_testimonials.php' );
require_once ( 'web/class.sessions.php' );
require_once ( 'web/class.request.php' );

$db = new database ( $conf['dbhost'] , $conf['dbusername'] , $conf['dbpassword'] , $conf['dbdatabasename'] );

$session = new sessions();
$data = $session->getAttribute( TELEMERGECONSTANT_SESS_ACCOUNT_SESSID );
$uname = $data[TELEMERGECONSTANT_SESS_UNAME];
$uid = $data[TELEMERGECONSTANT_SESS_UID];
if ( isset( $_POST['submit'] ) && trim( $_POST['message'] ) != ''  )
{
	// $message = $_POST['testimonial_text'];
	$testi = new clientTestimonials();
	$data = array(
		'message' => $_POST['message'] ,
		'datecreated' => time() ,
		'status' => 1 ,
		'userID' => $uid
	);
	$result = $testi->addTestimonial( $data );
	if ( $result )
	{
		$session->setAttribute( 'result_message' , 'You have successfully submit your testimonial.' );  
		$session->writeSession();
		$msg = ' You have successfully submit your testimonial.<br />';
		$msg .= ' Your testimonial will be display on the site after we approve it. Thanks...<br />';
		echo $msg ;
	}
	else
	{
		header('Location: clienttestimonial.php');
		exit;
	}

}
?>  
</div>
<div style="height:400px;" >&nbsp;</div>
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
