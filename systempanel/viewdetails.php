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
require_once ( '../libraries/class.uploads.php' );
require_once ( '../libraries/class.priority.php' );

$data = $session->getAttribute( TELEMERGECONSTANT_SESS_ACCOUNT_SESSID );
$uid = $data[TELEMERGECONSTANT_SESS_UID];
$guid = $data[TELEMERGECONSTANT_SESS_GUID];

$sessdata = $session->getAttribute( 'uploaddata' );
$formerr = $session->getAttribute( 'upload_form_errors' );

$myts =& textSanitizer::getInstance();

$priori =& priority::getInstance() ;
$prioritydata = $priori->getAllPriority();

$result = NULL;
$errorfound = 0 ;

if ( count( $formerr ) > 0  ) {
	foreach( $formerr as $value ) {
		$result .= $value .'<br />';
		$errorfound = 1;	
	}	
	$session->removeAttribute( 'upload_form_errors' );
}
else{
	$result = $session->getAttribute( 'msg' );
	$session->removeAttribute( 'uploaddata' );
}

$data = '';
$id = (int)$_GET['id'];
if ( !is_numeric( $id ) ) echo "<script>alert('" . ERR_INVALID_ID . "');</script>";
$upload = new uploads();
switch( $guid )
{
	case TELEMERGECONSTANT_GUID_CLIENT :
		$data = $upload->getUploadDetails( $id , $uid );
		break ;
	case TELEMERGECONSTANT_GUID_ADMIN :		
		$data = $upload->getUploadDetails( $id , 0 );	
		break ;
	case TELEMERGECONSTANT_GUID_MT :
		$data = $upload->getUploadDetails( $id , 0 );	
		break ;
}
$session->setAttribute( 'sess_upload_data' , $data );

if ( isset( $result ) && $result != NULL) {
$colortxt = ( $errorfound ) ? " #fff " : " #fff ";
$session->removeAttribute( 'msg' );
?>
<div style="border:0px solid #ccc; background-color:#CC4F06 ; padding:5px; color:<?php echo $colortxt; ?>">
	<p style="margin:0; padding:0; font:normal 17px verdana,Arial, Helvetica, sans-serif; text-align:left;"><?php echo  $myts->stripslashesGPC( $result ); ?></p>
</div>
<?php } ?>
<form name="formupload" action="saveupload.php" method="post" enctype="multipart/form-data" >
<table width="100%" border="0" id="tupload" style="float:left;" cellpadding="0" cellspacing="0" >
  <tr>
    <td colspan="2" ><h1 class="cap1" > Audio file Details </h1></td>
  </tr>
  <tr>
    <td colspan="2" >Fields marked * are required to be filled up. Thanks.</td>
  </tr>
  <tr>
    <td width="23%" ></td>
    <td  width="77%" ></td>
  </tr>
  <tr>
    <td class="column-label" valign="top" >Remarks : </td>
    <td><textarea name="uploaddesc" class="formtextfield" cols="40" rows="10" ><?php 
	$sessdata = $session->getAttribute( 'uploaddata' );
	//echo ( $myts->stripslashesGPC( $sessdata['uploaddesc'] ));
	echo $myts->stripslashesGPC( $data[0]->uploaddesc );
	?></textarea></td>
  </tr>
  <tr>
    <td class="column-label">Current Voice file : </td>
    <td>
	<?php
	$path = '../uploads/audio_files/' ; 
	$file = $data[0]->uploadfilename ;
	if ( file_exists( $path . $file ) )
	{
	?>
	Download =&gt;&nbsp;
	<b><a href= "download_audiofile.php?file=<?php  echo $file ; ?>" ><?php echo $file; ?></a></b>
	<?php
	}
	else echo "<span class=\"redtxt\">none</span>";
	?>	</td>
  </tr>
  <tr>
    <td class="column-label" valign="top" >Browse your  new voice file to <b>replace</b> the old one: </td>
    <td><input type="file" name="uploadfile" class="formtextfield" size="40" style="border:1px solid #ccc;" /></td>
  </tr>
  <tr>
    <td class="column-label" valign="top" >Priority : </td>
    <td><select name= "priority" >
		<?php
			$n = count($prioritydata);
			for( $i=0; $i<$n; $i++ )
			{
				if ( $data[0]->priority ==  $prioritydata[$i]->getPriorityId() )
				{
					echo "<option value='" . $prioritydata[$i]->getPriorityId() . "' selected='selected' >&nbsp;" . $prioritydata[$i]->getPriority(). "&nbsp;&nbsp;&nbsp;&nbsp;</option>";				
				}
				else
				{
					echo "<option value='" . $prioritydata[$i]->getPriorityId() . "' >&nbsp;" . $prioritydata[$i]->getPriority(). "&nbsp;&nbsp;&nbsp;&nbsp;</option>";				
				}
			}
		?>
	</select></td>
  </tr>
  <tr>
    <td height="17">&nbsp;</td>
    <td><p class="ptext" >Format supported : <b>MP3 , WAV , WMA </b><br />
      Maximum filesize allowed: <b><?php echo $conf['max_voicefile_upload'] / 1000000 ; ?>mb </b></p></td>
  </tr>
  <tr>
    <td height="17"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="17"></td>
    <td>
	<input type="submit" name="submitupload" value="Update this Audio file" onclick="document.formupload.submit();" class="formbutton" />
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="button" name="cancel" value="Cancel" onclick="location='list.php?menuclick=1'" class="formbutton" />	</td>
  </tr>
</table>
<input type="hidden" name="userID" value="<?php echo $data[0]->userID ; ?>"  />
<input type="hidden" name="uploaddate" value="<?php echo time(); ?>"  />
<input type="hidden" name="action" value="update"  />
<input type="hidden" name="fileid" value="<?php echo htmlspecialchars( $_GET['id'] ); ?>"  />
</form>
</div>
<div class="clear" ></div>
<?php
	include_once( '../tiles/footer.php' );
?> 
 
