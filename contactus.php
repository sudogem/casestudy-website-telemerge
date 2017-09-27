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

<title>Contact us</title>

<!-- InstanceEndEditable -->
<link rel="stylesheet" href="css/style.css" media="screen" type="text/css"  />
<script type="text/javascript" src="js/footer.js" language="javascript" ></script>
<!-- InstanceBeginEditable name="head" --><style type="text/css">

<!--

.style1 {color: red}

-->

</style><!-- InstanceEndEditable -->
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

<script type="text/javascript" >

    <!--

    function validate(){

      if ( ( document.emailForm.message.value == "" ) || ( document.emailForm.name.value == "" ) ||

        ( document.emailForm.email.value.search("@") == -1 ) || ( document.emailForm.email.value.search("[.*]" ) == -1 ) ) {

        alert( "Please make sure the form is complete and valid." );

        return false;

      } else {

      document.emailForm.action = "sendcontact.php"

      document.emailForm.submit();

      return true;

      }

    }

    //-->

</script>

<form method="post" action="sendcontact.php" name="emailForm"  >

      <div class="contact_email">

      <h1 class="cap2 capline" >Contact Us</h1>



<h1 class="cap1"> Fields marked <span class="requiredfield">*  </span> are required to be filled up. Thanks. </h1>

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



<table width="96%" border="0" id="tregister" >

  <tr>

    <td width="32%">Name : <span class="requiredfield">*  </span></td>

    <td width="68%"><input type="text" name="name" class="formtextfield"  size="30" value="<?php echo $tmp_name ; ?>" /></td>

  </tr>

  <tr>

    <td>E-mail : <span class="requiredfield">*  </span></td>

    <td><input type="text" name="email" class="formtextfield"  size="30" value="<?php echo $tmp_email ;?>" /></td>

  </tr>

  <tr>

    <td>Contact no. :<span class="requiredfield"> * </span></td>

    <td><input type="text" name="contactno" class="formtextfield"  size="30" value="<?php echo $tmp_contactno; ?>" /></td>

  </tr>

  <tr>

    <td>Subject : <span class="requiredfield">*  </span></td>

    <td><input type="text" name="subject" class="formtextfield"  size="30" value="<?php echo $tmp_subject; ?>" /></td>

  </tr>

  <tr>

    <td>Your message : <span class="requiredfield">*  </span></td>

    <td><textarea name="message" cols="22" rows="5"  class="formtextfield" ><?php echo $tmp_message ; ?></textarea></td>

  </tr>

  <tr>

    <td colspan="2" ><input name="email_copy" value="1" type="checkbox" ><span class="cap6">Email a copy of this message to your own address.</span></td>

    </tr>

  <tr>

    <td>&nbsp;</td>

    <td>					<p class="submit"><input name="submit" value="Submit" class="button" type="submit"></p></td>

  </tr>

</table>

  </div>

  <div class="contact-details" >

    <div style="padding-top:210px; position:relative;">

          <h1 class="cap4" >Head Office </h1>

          <h1 class="cap5" > IT-Hub Cebu , Philippines 6000 </h1>

          <br />

          <h1 class="cap4" >Contact No. </h1>

          <h1 class="cap5" >  1800-1234-5678 </h1>

          <br />

          <h1 class="cap4" >Email Address </h1>

           support@telemerge.com

    </div>

  </div>

</form>

<div class="clear" >&nbsp;</div><br /><br />

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

          <li><a href="contactus.php" class="active">Contact Us</a>&nbsp;|&nbsp;</li>

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
