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
require_once ( '../libraries/class.uploads.php' );
require_once ( '../libraries/class.transcribed_docs.php' );

$data = $session->getAttribute( TELEMERGECONSTANT_SESS_ACCOUNT_SESSID );
$uid = $data[TELEMERGECONSTANT_SESS_UID];
$guid = $data[TELEMERGECONSTANT_SESS_GUID];

$sessdata = $session->getAttribute( 'uploaddata' );
$formerr = $session->getAttribute( 'upload_form_errors' );

$myts =& textSanitizer::getInstance();

$result = NULL;
$errorfound = 0 ;

if ( count( $formerr ) > 0  ) {
	foreach( $formerr as $value ) {
		$result .= $value .'';
		$errorfound = 1;	
	}	
	$session->removeAttribute( 'upload_form_errors' );
}
else{
	$result = $session->getAttribute( 'msg' );
	$session->removeAttribute( 'uploaddata' );
}

$data = '';
$id = $_GET['id'];
if ( !is_numeric( $id ) ) echo '<script>alert("not a number")</script>';
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
// print_r($data);
if ( isset( $result ) && $result != NULL) {
$colortxt = ( $errorfound ) ? " #fff " : " #fff ";
$session->removeAttribute( 'msg' );
?>
<div style="border:1px solid #ccc; background-color:#CC4F06 ; padding:5px; color:<?php echo $colortxt; ?>">
	<p style="margin:0; font:normal 17px verdana,Arial, Helvetica, sans-serif; text-align:left;"><?php echo  $myts->stripslashesGPC( $result ); ?></p>
</div>
<?php } ?>
<form name="formupload" action="save_mt_docs.php" method="post" enctype="multipart/form-data" >
<table width="100%" border="0" id="tupload" style="float:left;" >
  <tr>
    <td colspan="3" ><h1 class="cap1" > Voice file Details </h1></td>
  </tr>
  <tr>
    <td colspan="3" >Fields marked * are required to be filled up. Thanks.</td>
  </tr>
  <tr>
    <td width="30%" ></td>
    <td  width="61%" ></td>
  </tr>
  <tr>
    <td class="column-label" valign="top" >File ID : </td>
    <td style="line-height:1.7em;"><?php echo ( $data[0]->uploadID );?></td>
  </tr>
  <tr>
    <td class="column-label" valign="top" >Remarks : </td>
    <td style="line-height:1.7em;"><?php echo $myts->stripslashesGPC( $data[0]->uploaddesc );?></td>
  </tr>
  <tr>
    <td class="column-label">Current Voice file : </td><td>
	<?php
		$path = '../uploads/audio_files/';	
		$file = $data[0]->uploadfilename; 		
		$wholepath = $path . $file ;
		//echo "f=$wholepath ";		
		 if (file_exists( $wholepath ) )
		 {
	?>
	Download =&gt;
    <b><a href= "download_audiofile.php?file=<?php echo $file; ?>" ><?php echo $file ; ?></a></b>
	<?php 
		 }
		 else
		 {
		 	echo "<span class=\"redtxt\">none</span>";
		 }
	?>
	</td>
  </tr>
  <tr>
    <td class="column-label" >Current Transcribed Doc file : </td>
    <?php
	
	$doc = new transcribedDocs();
	$docdata = array();
	$docdata = $doc->getTranscribedDocumentOfVoiceFile( $_GET['id'] ); 
	$path = '../uploads/document_files/';
	$file = $docdata[0]->docfilename; 
	
	$s = ( $file != NULL ) ? 'Download =&gt;&nbsp;<b><a href=download_docfile.php?file=' . $file . ' >' .  $file . '</b></a>' : 'none';	
	if ( file_exists( $path . $file ) )
	{
		
	}
	else
	{
		$s =  "<span class=\"redtxt\">none</span>";
	}	

	?>	
    <td><?php echo $s ; ?></td>
  </tr>
  <tr>
    <td class="column-label" >Priority : </td>
    <td>
	<?php
	 switch( $data[0]->priority  )
	 {
	 	case 1 :
			$s1 = "normal";
			$colore = ' class="pnormal" ' ;
			break ;
		case 2 :
			$s1 = "high";		
			$colore = ' class="phigh" ' ;
			break ;			
	 }
    echo "<span $colore >" . strtolower( $s1 ) . "</span>"; 	  
	?>	
	</td>
  </tr>
  <tr>
    <td class="column-label" >* Browse your  transcribed document : </td>
    <td><input type="file" name="uploadfile" class="formtextfield" size="40" style="border:1px solid #ccc;" /></td>
  </tr>
  <tr>
    <td >&nbsp;</td>
    <td><p class="ptext" >Format supported : <b>DOC , TXT, RTF </b><br />
      Maximum filesize allowed: <b><?php echo $conf['max_voicefile_upload'] / 1000000 ; ?>mb </b></p></td>
  </tr>
  <tr>
    <td ></td>
    <td><input type="submit" name="submitupload" value="Upload DOC file" onclick="document.formupload.submit();" class="formbutton" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="button" name="cancel" value="Cancel" onclick="location='list.php?menuclick=1'" class="formbutton" /> </td>
  </tr>
</table>
<input type="hidden" name="userID" value="<?php echo $uid; ?>"  />
<input type="hidden" name="uploaddate" value="<?php echo time(); ?>"  />
<input type="hidden" name="action" value="update"  />
</form>
</div>
<div class="clear" ></div>
 
<?php
	include_once( '../tiles/footer.php' );
?> 
