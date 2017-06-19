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
require_once ( '../libraries/class.client_testimonials.php' );
require_once ( '../libraries/class.status.php' );

$data = $session->getAttribute( TELEMERGECONSTANT_SESS_ACCOUNT_SESSID );
$uid = $data[TELEMERGECONSTANT_SESS_UID];

$sessdata = $session->getAttribute( 'uploaddata' );
$formerr = $session->getAttribute( 'news_form_errors' );

$myts =& textSanitizer::getInstance();
$testimonial = new clientTestimonials ();

$status =& status::getInstance();
$statusdata = $status->getAllTestimonialStatus();

$id = $_GET['id'];
$testimonialdata = $testimonial->getTestimonialsById( $id );
$testimonial->readTestimonial( $id );
$session->setAttribute( 'sess_client_testimonial_data' , $testimonialdata  );
// print_r($testimonialdata);
$result = NULL;
$errorfound = 0 ;

if ( count( $formerr ) > 0  ) {
	foreach( $formerr as $value ) {
		$result .= $value .'<br />';
		$errorfound = 1;	
	}	
	$session->removeAttribute( 'news_form_errors' );
	// get the saved session data frm submitted post data
	$sessdata = $session->getAttribute( 'testimonialdata' );	
	$tmp_newstitle = $sessdata['newstitle'] ;
	$tmp_body = $sessdata['newsdesc'] ; 
	$session->removeAttribute( 'testimonialdata' );	
}
else{
	$result = 	$session->getAttribute( 'msg' );
	$session->removeAttribute( 'uploaddata' );
}
if ( isset( $result ) ) {
$colortxt = ( $errorfound ) ? " #fff " : " #000 ";
$session->removeAttribute( 'msg' );
?>
	<div style="border:1px solid #ccc; margin-bottom:5px ; background-color:#CC4F06 ; padding:5px; color:<?php echo $colortxt; ?>">
	<p style="margin:0; font:normal 17px verdana , Arial, Helvetica, sans-serif; text-align:left;"><?php echo $result; ?></p>
	</div>
<?php } ?>
<form name="formupload" action="savetestimonial.php" method="post"  >
<table width="100%" border="0" id="tupload" style="float:left;" >
  <tr>
    <td colspan="2"><h1 class="cap1" > Testimonial Details </h1></td>
  </tr>
  <tr>
    <td colspan="2" >Fields marked * are required to be filled up. Thanks.</td>
  </tr>
  <tr>
    <td width="23%"></td>
    <td width="77%"></td>
  </tr>
  <tr>
    <td class="column-label" valign="top" >Testimonial Message  * : </td>
    <td><textarea name="message" class="formtextfield" cols="40" rows="10" ><?php 
	echo ( isset( $tmp_body ) ) ? $tmp_body : $testimonialdata[0]->message ;
	?></textarea></td>
  </tr>
  <tr>
    <td   class="column-label" valign="top" >Status : </td>
    <td><select name="status" >
	<?php
		$n = count( $statusdata );
		for( $i=0; $i < $n; $i++ )
		{
			if (   $testimonialdata[0]->status == $statusdata[$i]->getTestiStatusId())
			{
				echo '<option value="' . $statusdata[$i]->getTestiStatusId() . '" selected="selected" >' . $statusdata[$i]->getTestiStatus() . '&nbsp;&nbsp;&nbsp;</option>';
			}
			else
			{
				echo '<option value="' . $statusdata[$i]->getTestiStatusId() . '" >' . $statusdata[$i]->getTestiStatus() . '&nbsp;&nbsp;&nbsp;</option>';
			}
		}
	?></select></td>
  </tr>
  <tr>
    <td  class="column-label" valign="top" >Date Posted : </td>
    <td><?php echo date( "F j, Y g:i a" , $testimonialdata[0]->datecreated ) ;  ?></td>
  </tr>
  <tr>
    <td  class="column-label" valign="top" >Author : </td>
    <td><?php echo ( isset( $tmp_body ) ) ? $tmp_body : $testimonialdata[0]->userID ; ?></td>
  </tr>
  <tr>
    <td height="17"></td>
    <td><input type="image" name="submitupload" src="../images/submit.gif" onclick="document.formupload.submit();"  />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="testimonialmanager.php"><input type="image" name="cancel" src="../images/cancel.gif" onclick="document.formupload.submit();"  /></a></td>
  </tr>
</table>
<input type="hidden" name="userID" value="<?php echo $uid; ?>"  />
<input type="hidden" name="action" value="update"  />
</form>
</div>
<div class="clear" ></div>
<?php
	include_once( '../tiles/footer.php' );
?> 
 
