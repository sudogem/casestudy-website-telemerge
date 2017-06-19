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
require_once ( '../libraries/class.articles.php' );
require_once ( '../libraries/class.status.php' );

$data = $session->getAttribute( TELEMERGECONSTANT_SESS_ACCOUNT_SESSID );
$uid = $data[TELEMERGECONSTANT_SESS_UID];

$sessdata = $session->getAttribute( 'uploaddata' );
$formerr = $session->getAttribute( 'news_form_errors' );
#print_r($formerr);
$myts =& textSanitizer::getInstance();
$article = new newsArticles ();
$status =& status::getInstance();

$statusdata = $status->getAllStatus();
$id = $_GET['id'];
$newsdata = $article->getArticleByID( $id );

$session->setAttribute( 'sess_news_data' , $newsdata  );
#print_r($newsdata);
$result = NULL;
$errorfound = 0 ;

if ( count( $formerr ) > 0  ) {
	foreach( $formerr as $value ) {
		$result .= $value .'<br />';
		$errorfound = 1;	
	}	
	$session->removeAttribute( 'news_form_errors' );
	// get the saved session data frm submitted post data
	$sessdata = $session->getAttribute( 'newsdata' );	
	$tmp_newstitle = $sessdata['newstitle'] ;
	$tmp_body = $sessdata['newsdesc'] ; 
	$session->removeAttribute( 'newsdata' );	
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
<form name="formupload" action="savenews.php" method="post" enctype="multipart/form-data" >
<table width="100%" border="0" id="tupload" style="float:left;" >
  <tr>
    <td colspan="2"><h1 class="cap1" > News/Events Details </h1></td>
  </tr>
  <tr>
    <td colspan="2" >Fields marked * are required to be filled up. Thanks.</td>
  </tr>
  <tr>
    <td width="23%"></td>
    <td width="77%"></td>
  </tr>
  <tr>
    <td class="column-label" >Title * :</td>
    <td><input type="text" name="newstitle" class="formtextfield" size="54" maxlength="100" value="<?php
	echo ( isset($tmp_newstitle ) ) ? $tmp_newstitle : $newsdata[0]->newstitle ; 
	?>" />
(max chars: 100 ) </td>
  </tr>
  <tr>
    <td class="column-label" valign="top" >Body * : </td>
    <td><textarea name="newsdesc" class="formtextfield" cols="40" rows="10" ><?php 
	
	echo ( isset( $tmp_body ) ) ? $tmp_body : $newsdata[0]->body ;
	?></textarea></td>
  </tr>
  <tr>
    <td class="column-label" valign="top" >Status : </td>
    <td><select name="status" >
	<?php
		$n = count( $statusdata );
		for( $i=0; $i < $n; $i++ )
		{
			if ( $newsdata[0]->status == $statusdata[$i]->getStatusId() )
			{
				echo '<option value="' . $statusdata[$i]->getStatusId() . '" selected="selected" >' . $statusdata[$i]->getstatus() . '</option>';			
			}
			else
			{
				echo '<option value="' . $statusdata[$i]->getStatusId() . '" >' . $statusdata[$i]->getstatus() . '</option>';			
			}
		}
	?></select></td>
  </tr>
  <tr>
    <td ></td>
    <td><input type="image" name="submitupload" src="../images/submit.gif" onclick="document.formupload.submit();"  />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="newsmanager.php"><input type="image" name="cancel" src="../images/cancel.gif" onclick="document.formupload.submit();"  /></a></td>
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
 
