<?php
	include_once( '../tiles/header.php' );
?>
<?php
	// load user menu
	load_usermenu( );
?>
<div id="content" > 
<?php 
require_once ( '../libraries/class.sanitizer.php' );
require_once ( '../libraries/class.database.php' );
require_once ( '../libraries/class.useraccount.php' );
require_once ( '../libraries/class.countries.php' );
$data = $session->getAttribute( TELEMERGECONSTANT_SESS_ACCOUNT_SESSID );
$uid = $data[TELEMERGECONSTANT_SESS_UID];
$user = new UserAccount;

$tmp_useraccountdata = $session->getAttribute( 'useraccountdata' );

$formerr = $session->getAttribute( 'registration_form_errors' );
#print_r($formerr);
$myts =& textSanitizer::getInstance();
$userid = $_GET['id'];

$userdata = $user->getUserAccountData( $userid );
$session->setAttribute( 'sess_useraccount_data' , $userdata  );

$result = NULL;
$errorfound = 0 ;
//print_r($_SESSION);
if ( count( $formerr ) > 0  ) {
	foreach( $formerr as $value ) {
		$result .= $value .'<br />';
		$errorfound = 1;	
	}	
	$session->removeAttribute( 'registration_form_errors' );
	// get the saved session data frm submitted post data
	$sessdata = $session->getAttribute( 'newsdata' );	
	$tmp_newstitle = $sessdata['newstitle'] ;
	$tmp_body = $sessdata['newsdesc'] ; 
	
	$session->removeAttribute( 'useraccountdata' );	
}
else{
	$result = 	$session->getAttribute( 'msg' );
}
if ( isset( $result ) ) {
$colortxt = ( $errorfound ) ? " #fff " : " #000 ";
$session->removeAttribute( 'msg' );
?>
	<div style="border:1px solid #ccc; margin-bottom:5px ; background-color:#CC4F06 ; padding:5px; color:<?php echo $colortxt; ?>">
	<p style="margin:0; font:normal 17px verdana , Arial, Helvetica, sans-serif; text-align:left;"><?php echo $result; ?></p>
	</div>
<?php } ?>
<form name="fromaccnt" action="saveaccnt.php" method="post"  >
<table width="100%" border="0" id="tregister" >
  <tr>
    <td colspan="2"><h1 class="cap1" >User Profile </h1></td>
    </tr>
  <tr>
    <td colspan="2">Fields marked * are required to be filled up. Thanks. </td>
    </tr>
  <tr>
    <td width="163" class="column-label" ><span class="requiredfield">*</span> Username : </td>
    <td width="690"><?php echo $userdata[0]->username; ?></td>
  </tr>
  <tr>
    <td class="column-label" ><span class="requiredfield">*</span>Password :</td>
    <td><input type="password" name="password" class="formtextfield passwordfield" size="26" /> <br />
    Leave it blank if you dont want to change it.</td>
  </tr>
  <tr>
    <td class="column-label" ><span class="requiredfield">*</span>Verify Password : </td>
    <td><input type="password" name="verify_password" class="formtextfield passwordfield" size="26"></td>
  </tr>
  <tr>
    <td class="column-label" >&nbsp;</td>
    <td>You should verify password if above field is being inputted . </td>
  </tr>
  <tr>
    <td class="column-label" ><span class="requiredfield">*</span>Full name : </td>
    <td><input type="text" name="fullname" class="formtextfield" size="40" value="<?php echo isset( $tmp_useraccountdata['fullname'] ) ? $tmp_useraccountdata['fullname'] : $myts->stripslashesGPC( $userdata[0]->fullname ); ?>"></td>
  </tr>
  <tr>
    <td class="column-label" ><span class="requiredfield">*</span>Email : </td>
    <td><input type="text" name="email" class="formtextfield" size="40" value="<?php echo isset( $tmp_useraccountdata['email'] ) ? $tmp_useraccountdata['email'] : $myts->stripslashesGPC( $userdata[0]->email ); ?>" /></td>
  </tr>
  <tr>
    <td class="column-label" ><span class="requiredfield">*</span>Gender : </td>
    <td>
	<?php 
		if ( $userdata[0]->gender == 'Male' ) {
			$g = '<input type="radio" name="gender" value="Male" checked="checked"  />Male&nbsp;&nbsp;' ;
			$g .= '<input type="radio" name="gender" value="Female" />Female';
		}
		else {
			$g = '<input type="radio" name="gender" value="Male"  />Male&nbsp;&nbsp;' ;
			$g .= '<input type="radio" name="gender" value="Female" checked="checked" />Female';
		}
		echo $g;
	?>	</td>
  </tr>
  <tr>
    <td valign="top" class="column-label" ><span class="requiredfield">*</span>Address : </td>
    <td><textarea name="address" cols="30" rows="5" class="formtextfield" ><?php echo  isset( $tmp_useraccountdata['address'] ) ? $tmp_useraccountdata['address'] : $myts->stripslashesGPC( $userdata[0]->address ); ?></textarea></td>
  </tr>
  <tr>
    <td class="column-label" ><span class="requiredfield">*</span>Contact no : </td>
    <td><input type="text" name="contactno" class="formtextfield" size="40" value="<?php echo isset( $tmp_useraccountdata['contactno'] ) ? $tmp_useraccountdata['contactno'] : $myts->stripslashesGPC( $userdata[0]->contactno ); ?>"></td>
  </tr>
  <tr>
    <td class="column-label" ><span class="requiredfield">*</span>Country : </td>
    <td>
<select id="country" name="country" size="1" >
	<?php
	$countries = CountryList::getCountries();
	while( list( $key , $value ) = each( $countries ) ) {
		if ( $userdata[0]->country == $value ) {
			echo '<option selected=selected value="' . $key . '">' . $value . ' </option>';					
		}
		else{
			echo '<option value="' . $key . '">' . $value . ' </option>';					
		}
	}
	?>
	</select>   </td>
  </tr>
  <tr>
    <td class="column-label" ><span class="requiredfield">*</span>Birthdate : </td>
    <td>
<select name="year" class="inputfield" >
<?php
$curyr = date('Y' , time() );
$b_yr = date( 'Y' , $userdata[0]->birthdate );

$inityr = 1920;
for( $j =  $curyr; $j > $inityr; $j-- ) {
	if ( $b_yr == $j ) {
		echo '<option value="' . $j . '" selected="selected" >' . $j . ' </option>';					
	}
	else{
		echo '<option value="' . $j . '">' . $j . ' </option>';					
	}
}
?>	
	</select>	
	<select name="month" onChange="setDays();" class="inputfield" >
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

$b_month = date( 'm' , $userdata[0]->birthdate );
	
	while ( list( $key , $value ) = each ( $date ) )
	{
		if ( $b_month == $key ) 
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
	<select name="day">
	<?php
$b_day = date( 'd' , $userdata[0]->birthdate );
	
	for($i=1; $i<=31; $i++) {
		if ( $b_day == $i ) {
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
    <td class="column-label" ><span class="requiredfield">*</span>Position :</td>
    <td><input type="text" name="position" class="formtextfield" size="40" value="<?php echo isset( $tmp_useraccountdata['position'] ) ? $tmp_useraccountdata['position'] : $myts->stripslashesGPC( $userdata[0]->position ); ?>"/></td>
  </tr>
  <tr>
    <td class="column-label" ><span class="requiredfield">*</span>Register as  :</td>
    <td><select name="usertypeID" class="inputfield" >
      <?php
	$type = array( 
	"1" =>  "Administrator" ,
	"2" =>  "Client" ,
	"3" =>  "Medical Transcriptionist" 
	 ); 
	//$utype = isset( $_SESSION['userdata']['usertypeID'] ) ?  $_SESSION['userdata']['usertypeID'] : '2' ; 	 
	$utype = $userdata[0]->usertypeID ;
	foreach( $type as $j => $value ) {
		if ( $utype == $j ) {
			echo '<option selected=selected value="' . $j . '">' . $value . ' </option>';					
		}
		else{
			echo '<option value="' . $j . '">' . $value . ' </option>';					
		}
	}	 

?>
    </select></td>
  </tr>
  <tr>
    <td class="column-label" >Registration status : </td>
    <td>
	<?php
		switch ( $userdata[0]->usertypeID ) {
			case 1 :
				$status = 'Registration status cannot be set.';
				break;
			default:
				$s = strtolower($userdata[0]->status);
				if ( $s == 'accepted' ) {
					$status = '<input type="radio" name="status" value="accepted" checked="checked" >Accepted&nbsp;&nbsp;';
					$status .= '<input type="radio" name="status" value="rejected">Rejected';
				}
				elseif ( $s == 'rejected' ) {
					$status = '<input type="radio" name="status" value="accepted"  >Accepted&nbsp;&nbsp;';
					$status .= '<input type="radio" name="status" value="rejected" checked="checked" >Rejected';
				}
				else {
					$status = '<input type="radio" name="status" value="accepted"  >Accepted&nbsp;&nbsp;';
					$status .= '<input type="radio" name="status" value="rejected" checked="checked" >Rejected';
				}	
				break;	
		}
		echo $status;
	?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="submit" onclick="document.userinfo.submit();" value="Update Profile" class="formbutton" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="button" name="cancel" value="Cancel" onclick="location='usermanager.php?menuclick=3'" class="formbutton" /></td>
  </tr>
</table>
<input type="hidden" name="userID" value="<?php echo $userid; ?>"  />
<input type="hidden" name="uploaddate" value="<?php echo time(); ?>"  />
<input type="hidden" name="action" value="update"  />
</form>
</div>
<div class="clear" ></div>
<?php
	include_once( '../tiles/footer.php' );
?> 
 
