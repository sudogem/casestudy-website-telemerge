<?php
	require_once ( 'http/class.sessions.php' );
	require_once ( 'config/conf.php' );
	require_once ( 'libraries/class.sanitizer.php' ) ;
	
	$myts = new textsanitizer();
	$session = new sessions();	
	
	$tmp_contact = $session->getAttribute( 'userdata' );
	$tmp_name = $tmp_contact['name'];
	$tmp_email = $tmp_contact['email'];
	$tmp_contactno = $tmp_contact['contactno'];
	$tmp_subject = $tmp_contact['subject'];
	$tmp_message = $tmp_contact['message'];
	
	
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
<title>7 day Free trial - Telemerge Corporation</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="developer" content="Arman Ortega :: arman.ortega{at}yahoo{dot}com" />
<meta name="robots" content="index , follow"  />
<meta name="description" content="Telemerge is a medical transcription company catering the increasing demand for accurate and effective data gathering and storage.The company is owned and operated by Telemerge Company Inc. A very young and promising corporation composed of tested and successful businessman in Cebu."  />
<meta name="keywords" content=" 7 day free trial , affordable medical transcription , philippine medical transcription , affordable medical transcription cebu , transcriptionists , cebu outsource medical transcription , philippine outsource medical transcription "  />

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
    <li><a href="freetrial.php" id="cmdfreetrial" class="cmddefault" >Free Trial</a></li>
    <li><a href="contactus.php" id="cmdcontact" >Contact Us</a></li>
    <li><a href="what_is_medical_transcription.php" id="cmdmt" >Medical Transcription</a></li>
    <li><a href="request_info.php" id="cmdrequest" >Request Info</a></li>
  </ul>
  <!-- InstanceEndEditable -->
  <div class="clear" ></div>
  <!-- InstanceBeginEditable name="front-content" -->
<div class="freetrial" >
		<script language="JavaScript" type="text/javascript">
		<!--
		function validate(){
			if ( ( document.emailForm.name.value == "" ) || ( document.emailForm.email.value.search("@") == -1 ) || ( document.emailForm.email.value.search("[.*]" ) == -1 ) ) {
				alert( "Please make sure the form is complete and valid." );
			} else {
			document.emailForm.action = "sendfreetrial.php"
			document.emailForm.submit();
			}
		}
		//-->
		</script>	  
	  
        <div id="colwrap" >
		  <h1 class="cap2 capline" >Free trial</h1>
<h1 class="cap1">
To avail the free trial services , you can email us at support@telemerge.com or fill the form below and someone from our company will contact you within the next 12 hours. <br />
 Fields marked <span class="requiredfield">*  </span> are required to be filled up. Thanks. </h1>		  			
<?php
	if ( $session->isAttributeExist( 'result_message' ) )
	{
		$result = $session->getAttribute( 'result_message' );		
		if ( count( $result ) > 0  )
		{
			$str = '';
			foreach( $result as $val )
			{
				if ( $val != '' )
					$str = $str . $val . '<br />';
			}
		}
		
?>  
<div style="border:1px solid #ccc; background-color:#A8290A ; padding:5px; color:#fff;">
<p style="margin:0; font:normal 17px verdana,Arial, Helvetica, sans-serif; text-align:left;"><?php echo  $myts->stripslashesGPC( $str ); ?></p>
<?php
$session->removeAttribute( 'result_message' ) ;
$session->removeAttribute( 'userdata' );
?>
</div>	
<?php } ?>

<form method="post"  name="emailForm" action="sendfreetrial.php"   >
<table width="100%" border="0" id="tregister" >
  <tr>
    <td width="18%">Name : <span class="requiredfield">*  </span></td>
    <td width="82%"><input type="text" name="name" class="formtextfield"  size="40" value="" /></td>
  </tr>
  <tr>
    <td>Profession : </td>
    <td><input type="text" name="profession" class="formtextfield"  size="40" value="" /></td>
  </tr>
  <tr>
    <td>Home Address  : <span class="requiredfield">*  </span></td>
    <td><input type="text" name="homeaddress" class="formtextfield"  size="40" value="" /></td>
  </tr>
  <tr>
    <td>Office Address : <span class="requiredfield">*  </span></td>
    <td><input type="text" name="officeaddress" class="formtextfield"  size="40" value="" /></td>
  </tr>
  <tr>
    <td>City / State : </td>
    <td><input type="text" name="city" class="formtextfield"  size="40" value="" /></td>
  </tr>
  <tr>
    <td>Country : </td>
    <td><input type="text" name="country" class="formtextfield"  size="40" value="" /></td>
  </tr>
  <tr>
    <td>Fax # : </td>
    <td><input type="text" name="faxno" class="formtextfield"  size="40" value="" /></td>
  </tr>
  <tr>
    <td>Contact #. / Telephone #. :  <span class="requiredfield">*  </span></td>
    <td><input type="text" name="contactno" class="formtextfield"  size="40" value="" /></td>
  </tr>
  <tr>
    <td>E-mail Address : <span class="requiredfield">*  </span></td>
    <td><input type="text" name="emailaddress" class="formtextfield"  size="40" value="" /></td>
  </tr>
  <tr>
    <td>What is medical specialty : </td>
    <td><textarea name="medicalspecialty" cols="30" rows="5"  class="formtextfield" ></textarea></td>
  </tr>
  <tr>
    <td valign="top">What type of document to be dictated : </td>
    <td style="font:normal 12px arial; line-height: 1.5em ; " >
		<input type="checkbox" name="type[]" value="1"  />	History of the Patient	<br />	
		<input type="checkbox" name="type[]" value="2"  />	 Operative and Procedure Notes	<br />	
		<input type="checkbox" name="type[]" value="3"  />	 Discharge Summary	<br />	
		<input type="checkbox" name="type[]" value="4"  />	Progress Report	<br />					
		<input type="checkbox" name="type[]" value="5"  />	Chart Notes	<br />					
		<input type="checkbox" name="type[]" value="6"  />	Consultation Report	<br />									
		<input type="checkbox" name="type[]" value="7"  />	Rehabilitation Report	<br />									
		<input type="checkbox" name="type[]" value="8"  />	Emergency Notes 	<br />											
		<input type="checkbox" name="type[]" value="9"  />	Others 	<br />											
	</td>
  </tr>
  <tr>
    <td>Average of lines per document : </td>
    <td><input type="text" name="averageline" class="formtextfield"  size="40" value="" /></td>
  </tr>
  <tr>
    <td><p>Current  MT service payment rate :</p></td>
    <td><input type="text" name="rate" class="formtextfield"  size="40" value="" /></td>
  </tr>
  <tr>
    <td><p>How long is the delivery :</p></td>
    <td><input type="text" name="deliverytime" class="formtextfield"  size="40" value="" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><p class="submit"><input name="submit" value="Send" class="button" type="submit"></p></td>
  </tr>
</table>
<input type="hidden" name="_token" value="<?php ?>"  />
<br />

          </form>
        </div>
	
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
<?php $session->removeAttribute( 'userdata' )?>