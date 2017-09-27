<?php
require_once ( 'libraries/class.countries.php' );
require_once ( 'libraries/class.captcha_numbers.php' );
require_once ( 'libraries/class.sanitizer.php' );
require_once ( 'http/class.sessions.php' );

$session = new sessions();
$myts =& textsanitizer::getInstance();
$tmp_account = $session->getAttribute( 'userdata' );

$tmp_username = $tmp_account['username'] ;
$tmp_fullname = $tmp_account['fullname'];
$tmp_gender = $tmp_account['gender'];
$malechecked = $femalechecked = '';
switch( strtoupper( $tmp_gender ) )
{
	case 'MALE':
		$malechecked = " checked=\"checked\" ";
		break;
	default :
		$femalechecked = " checked=\"checked\" ";
		break;
}
$tmp_email = $tmp_account['email'];
$tmp_address = $tmp_account['address'];
$tmp_contactno = $tmp_account['contactno'];
$tmp_occupation = $tmp_account['occupation'];
$tmp_birthdate = $tmp_account['birthdate'];
$tmp_birthdateyear = date( 'Y' , $tmp_birthdate );
$tmp_birthdatemonth = date( 'n' , $tmp_birthdate );  
$tmp_birthdateday = date( 'j' , $tmp_birthdate );  
$tmp_usertypeID = $tmp_account['usertypeID'];
$tmp_country = $tmp_account['country'];
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
<title>Sign up - Telemerge Corporation</title>
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
    <li><a href="index.php" id="cmdhome"   >Home</a></li>
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
<script language="JavaScript">
<!--
// you may use/modify this code, but please give credit as a courtesy
// script by Arash Ramin (http://www.digitalroom.net)

function setCurrentDate() {
  // changes the date selector menus to the current date
  var currentDate = new Date();

  document.userinfo.year.selectedIndex = 0;
  document.userinfo.month.selectedIndex = currentDate.getMonth();

  setDays();  
  document.userinfo.day.selectedIndex = currentDate.getDate() - 1;
}

function setDays() {

  var y = document.userinfo.year.options[document.userinfo.year.selectedIndex].value;
  var m = document.userinfo.month.selectedIndex;
  var d;

  // find number of days in current month
  if ( (m == 3) || (m == 5) || (m == 8) || (m == 10) ) {
    days = 30;
  }
  else if (m == 1) {
    // check for leapyear - Any year divisible by 4, except those divisible by 100 (but NOT 400)
    if ( (Math.floor(y/4) == (y/4)) && ((Math.floor(y/100) != (y/100)) || (Math.floor(y/400) == (y/400))) )
      days = 29
    else
      days = 28
  }
  else {
    days = 31;
  }


  // if (days in new month > current days) then we must add the extra days
  if (days > document.userinfo.day.length) {
    for (i = document.userinfo.day.length; i < days; i++) {
      document.userinfo.day.length = days;
      document.userinfo.day.options[i].text = i + 1;
      document.userinfo.day.options[i].value = i + 1;
    }
  }

  
  // if (days in new month < current days) then we must delete the extra days
  if (days < document.userinfo.day.length) {
    document.userinfo.day.length = days;
    if (document.userinfo.day.selectedIndex == -1) 
      document.userinfo.day.selectedIndex = days - 1;
  }

}

//-->
</script>
<div class="signup-form" >  
<form action="register.php" name="userinfo" method="post" >
<table width="100%" border="0" id="tregister" >
  <tr>
    <td colspan="2"><h1 class="cap2" >Registration form</h1></td>
    </tr>
  <tr>
    <td colspan="2" ><h1 class="cap1"> Fields marked <span class="requiredfield">*  </span> are required to be filled up. Thanks. </h1></td>
    </tr>
  <tr>
    <td width="162">Member Login ID : <span class="requiredfield">*  </span></td>
    <td width="313"><input type="text" name="username" class="formtextfield"  size="40" value="<?php echo $tmp_username ;?>" maxlength="15" /><br />
	<div class="notes" >(max chars = 15 . Combination of alphanumeric , underscore , lower/uppercase characters.
White space and special characters are not allowed. ) </div>	</td>
  </tr>
  <tr>
    <td>Password : <span class="requiredfield" >*  </span></td>
    <td><input type="password" name="password" class="formtextfield" size="40" maxlength="15" /><br />
<div class="notes" >(max chars = 15 . Combination of alphanumeric , lower/uppercase characters. Special characters are not allowed like ( ! , @ , # , $ , % , ^ , & , * , ( ,) , etc. ). <br />
  White space character is not allowed.</div>	</td>
  </tr>
  <tr>
    <td> Verify Password : <span class="requiredfield" >*  </span></td>
    <td><input type="password" name="verify_password" class="formtextfield" size="40" maxlength="15"><br />    <div class="notes" >(max chars = 15. )</div></td>
  </tr>
  <tr>
    <td>Full name : <span class="requiredfield" >*  </span></td>
    <td><input type="text" name="fullname" class="formtextfield" size="40" value="<?php echo stripslashes( $tmp_fullname ); ?>" maxlength="50"><br />
    <div class="notes" >(max chars = 50. )</div></td>
  </tr>
  <tr>
    <td> Email : <span class="requiredfield" >*  </span></td>
    <td><input type="text" name="email" class="formtextfield" size="40" value="<?php echo $tmp_email ; ?>" /></td>
  </tr>
  <tr>
    <td>Gender : </td>
    <td><input type="radio" name="gender" value="Male" <?php echo $malechecked ; ?>  />Male <input type="radio" name="gender" value="Female" <?php echo $femalechecked ; ?>  />Female</td>
  </tr>
  <tr>
    <td valign="top">Address :  </td>
    <td><textarea name="address" cols="30" rows="5" class="formtextfield" ><?php echo $tmp_address ;?></textarea></td>
  </tr>
  <tr>
    <td> Tel no : <span class="requiredfield" >*  </span></td>
    <td><input type="text" name="contactno" class="formtextfield" size="40" value="<?php echo $tmp_contactno ; ?>"><br />    <div class="notes" >(Must be a digit. )</div></td>
  </tr>
  <tr>
    <td>Country : </td>
    <td>
<select id="country" name="country" size="1"  class="formtextfield" >
<?php
	$countries = CountryList::getCountries();
	while( list( $key , $value ) = each( $countries ) ) {
		if ( $tmp_country == $value ) {
			echo '<option selected=selected value="' . $key . '">' . $value . ' </option>';					
		}
		else{
			echo '<option value="' . $key . '">' . $value . ' </option>';					
		}
	}
?>	
</select></td>
  </tr>
  <tr>
    <td>Birthdate : </td>
    <td>
<select name="year" class="formtextfield" >
<?php
$curyr = date('Y' , time() );
$inityr = 1971;
for( $j =  $curyr; $j > $inityr; $j-- ) {
	if ( $tmp_birthdateyear == $j ) {
		echo '<option selected=selected value="' . $j . '">' . $j . ' </option>';					
	}
	else{
		echo '<option value="' . $j . '">' . $j . ' </option>';					
	}
}
?>	
	</select>	
	<select name="month" onChange="setDays();" class="formtextfield" >
<?php 
	$date = array( 
	"1" =>  "Jan" ,
	"2" =>  "Feb" ,
	"3" =>  "Mar" ,
	"4" =>  "Apr" ,
	"5" =>  "May" ,
	"6" =>  "June" ,
	"7" =>  "Jul" ,
	"8" =>  "Aug" ,
	"9" =>  "Sept" ,
	"10" =>  "Oct" ,
	"11" =>  "Nov" ,
	"12" =>  "Dec" ,
	);
	
	while ( list( $key , $value ) = each ( $date ) )
	{
		if (  $tmp_birthdatemonth == $key ) 
		{
			echo '<option selected=selected value="' . $key . '">' . $value . ' </option>';				
		}
		else 
		{
			echo '<option value="' . $key . '">' . $value . '</option>';				
		}

	}
?>
	</select>
	<select name="day" class="formtextfield" >
	<?php
	for($i=1; $i<=31; $i++) {
		if (  $tmp_birthdateday == $i ) {
			echo '<option selected=selected value="' . $i . '">' . $i . '</option>';						
		}
		else {
			echo '<option value="' . $i . '">' . $i . '</option>';						
		}
	}
	?>
</select>	</td>
  </tr>
  <tr>
    <td>Occupation : <span class="requiredfield" >*  </span></td>
    <td><input type="text" name="occupation" class="formtextfield" size="40" value="<?php echo $tmp_occupation ;?>"/></td>
  </tr>
  <tr>
    <td>Affiliation : </td>
    <td><input type="text" name="affiliation" class="formtextfield" size="40" value="<?php echo $tmp_affiliation ; ?>" /></td>
  </tr>
  <tr>
    <td>Register as : <span class="requiredfield">*</span></td>
    <td><select name="usertypeID" class="formtextfield" >
      <?php
	$type = array( 
	"2" =>  "Client" ,
	"3" =>  "Medical Transcriptionist" 
	 ); 
	$utype = isset( $tmp_usertypeID ) ?  $tmp_usertypeID : '2' ; 	 
	foreach( $type as $j => $value ) 
	{
		if ( $utype == $j ) 
		{
			echo '<option selected=selected value="' . $j . '">' . $value . ' </option>';					
		}
		else
		{
			echo '<option value="' . $j . '">' . $value . ' </option>';					
		}
	}	 

?>
      <!-- <script language="JavaScript">
// Netscape doesn't seem to like a SELECT menu without any <OPTION> elements
var startYear = 1920;
var currentDate = new Date();
var currentYear = currentDate.getFullYear();
for (j = currentYear; j > 1920; j--) {
  document.writeln('<OPTION VALUE="' + j + '">' + j);
  }
</script>-->
    </select></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><p class="submit"><input type="submit" name="submit" id="submit" value="Submit &raquo;" style="margin-top:2px; " onclick="document.userinfo.submit();"  /></p></td>
  </tr>
</table>
<input type="hidden" name="registerdate" value="<?php echo time();?>"  />
<input type="hidden" name="lastvisitdate" value="0"  />
<input type="hidden" name="timestamp" value="<?php echo time(); ?>"  />
<input type="hidden" name="status" value="unactivated" />
</form>	  
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
                  <li><a href="#">Terms of Use</a>&nbsp;|&nbsp;</li>
				  <li><a href="#">Privacy Policy</a>&nbsp;|&nbsp;</li>
				  <li><a href="#">Contact Us</a>&nbsp;|&nbsp;</li>
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
