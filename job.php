<?php
require_once ( 'http/class.sessions.php' );
require_once ( 'libraries/class.sanitizer.php' );

$session = new sessions();
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
    <li><a href="job.php" class="active" >Job Opportunities</a> </li>
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
  <div class="job-hiring" >
  	<h1 class="cap2" >Job Opportunities</h1>
	<h1 class="cap5">  If you are a professional with experience and feel competent enough to join our team, please submit your resume in the form given below. Alternatively, you can call us at +1800-1234-5678 or email us at support@telemerge.com</h1><br />
<h1 class="cap1"> Fields marked <span class="requiredfield">*  </span> are required to be filled up. Thanks. </h1>
<?php
$formerr = $session->getAttribute( 'upload_form_errors' );
$tmp_data = $session->getAttribute( 'uploaddata' );

$myts =& textSanitizer::getInstance();

$result = NULL;
$errorfound = 0 ;

if ( count( $formerr ) > 0  ) {
	foreach( $formerr as $value ) {
		$result .= $value .'<br/>';
		$errorfound = 1;
	}
	$session->removeAttribute( 'upload_form_errors' );

}
else{
	$session->removeAttribute( 'uploaddata' );
}
$session->removeAttribute( 'uploaddata' );

?>
<?php if ( $errorfound ) {?>
<div style="border:1px solid #ccc; background-color:#A8290A ; padding:5px; color:#fff;">
<p style="margin:0; font:normal 17px verdana,Arial, Helvetica, sans-serif; text-align:left;"><?php echo  $myts->stripslashesGPC( $result ); ?></p>
</div>
<?php } ?>
	<form name="job" method="post" action="sendresume.php" enctype="multipart/form-data" >
	<table border="0" width="100%" id="tregister" >
		<tr>
			<td width="35%">Name : <span class="requiredfield">*  </span></td>
			<td width="65%"><input name="name" size="30" class="formtextfield" value="<?php echo $tmp_data['name']; ?>" type="text" /></td>
		</tr>
		<tr>
			<td>Email : <span class="requiredfield">*  </span></td>
			<td><input name="email" size="30" class="formtextfield" value="<?php echo $tmp_data['email'];?>" type="text" /></td>
		</tr>
		<tr>
			<td>Position desired : <span class="requiredfield">*  </span></td>
			<td><input name="position_desired" size="30" class="formtextfield" value="<?php echo $tmp_data['position_desired'];?>" type="text" /></td>
		</tr>
		<tr>
			<td valign="top" >Cover letter  : <span class="requiredfield">*  </span></td>
			<td><input type="file" name="coverletter" class="formtextfield" value="" />
			<br /><h1 class="cap1"> Upload your cover letter here. <br />Format supported : .DOC, .PDF, .TXT</h1></td>
			</td>
		</tr>
		<tr>
			<td valign="top" >Your   Resume : <span class="requiredfield">*  </span></td>
			<td><input type="file" name="resume" class="formtextfield" value="" />
			<br /><h1 class="cap1"> Upload your resume here. <br />Format supported: .DOC, .PDF, .TXT</h1></td>
		</tr>
		<tr>
			<td></td>
			<td>
			<p class="submit">
			<input name="submit" value="Submit &raquo;" class="button" onclick="validate()" type="submit" />
			</p>
	</td>
		</tr>
	</table>
	</form>
  </div>
  <div class="job-open">

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
