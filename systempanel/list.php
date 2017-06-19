<?php
	include_once( '../tiles/header.php' );
?>
<?php
	// load user menu
	load_usermenu( );
?>
<div id="content" >
<?php
require_once ( '../libraries/class.uploads.php' );
require_once ( '../libraries/class.transcribed_docs.php' );
require_once ( '../libraries/class.sanitizer.php' );
require_once ( '../libraries/class.paginator.php' );
require_once ( '../libraries/class.priority.php' );

$upload = new uploads;
$myts =& textSanitizer::getInstance( );

$priori =& priority::getInstance() ;

$data = $session->getAttribute( TELEMERGECONSTANT_SESS_ACCOUNT_SESSID );
$uid = $data[TELEMERGECONSTANT_SESS_UID];
$guid = $data[TELEMERGECONSTANT_SESS_GUID];

$limit = 10 ;
$start = (isset($_GET['start'])) ? $_GET['start'] : 0;

switch( $guid )
{
	case TELEMERGECONSTANT_GUID_ADMIN : // admin
		$alldata = $upload->getAllUserUploads(  );
		$totalrows = count( $alldata ) - 1;
		$uploaddatas = $upload->getAllUserUploads( $start  , $limit );
		$setviewpage = 'viewdetails.php';
		$numrows = count( $uploaddatas )-1;
		break;
	case TELEMERGECONSTANT_GUID_CLIENT : // client
		$alldata = $upload->getAllUserUploads( 0 , 0  , $uid  );
		$totalrows = count( $alldata ) - 1;
		$uploaddatas = $upload->getAllUserUploads( $start  , $limit ,  $uid  );
		$setviewpage = 'viewdetails.php';		
		$numrows = count( $uploaddatas )-1;
		break;
	case TELEMERGECONSTANT_GUID_MT : // mt
		$alldata = $upload->getAllUserUploads(  );
		$totalrows = count( $alldata ) - 1;
		$uploaddatas = $upload->getAllUserUploads( $start  , $limit );
		$numrows = count( $uploaddatas )-1;
		$setviewpage = 'viewdetails_by_mt.php';
		break;		
}

// remove pre- existing form datas
if ( isset($_SESSION['uploaddata']) ) unset( $_SESSION['uploaddata'] );	

if ( isset($_GET['page']) && !empty($_GET['page']) ) {
	$page = $_GET['page'];
}
else {
	$page = 1;
}

$a =& new paginator( $page , $totalrows ); 
$a->set_Limit( $limit );

$limit1 = $a->getRange1();  
//gets number of items displayed on page.
$limit2 = $a->getRange2();  
	
 //check to see if current page is one. If so there will be no link.
$pagelinks = '';
if($a->getCurrent()==1)
{
	 $first = "First | ";
} 
else
{ 
	 $first="<a href=\"" .  $a->getPageName() . "?page=" . $a->getFirst() . "&start=0"  . "&menuclick=1\">First</a> |"; 
}

//check to see that getPrevious() is returning a value. If not there will be no link.
if($a->getPrevious())
{
	 $prev = "<a href=\"" .  $a->getPageName() . "?page=" . $a->getPrevious() . "&start=" . ($a->getFirstOf() - $limit-1) . "&menuclick=1\">Prev</a> | ";
}
else 
{
	$prev="Prev | "; 
}
//check to see that getNext() is returning a value. If not there will be no link.
if($a->getNext())
{
	 $next = "<a href=\"" . $a->getPageName() . "?page=" . $a->getNext() . "&start=" . $a->getSecondOf() .  "&menuclick=1\">Next</a> | ";
}
else 
{ 
	$next="Next | "; 
}

 //check to see that getLast() is returning a value. If not there will be no link.
if($a->getLast())
{
	 $last = "<a href=\"" . $a->getPageName() . "?page=" . $a->getLast() . "&start=" . ($limit2 + $limit) . "&menuclick=1\">Last</a> | ";
}
else 
{ 
	$last="Last | "; 
}
 //since these will always exist just print out the values.  Result will be
 //something like 1 of 4 of 25
 $pagelinks .= $a->getFirstOf() . " of " .$a->getSecondOf() . " of " . $a->getTotalItems() . " ";
//print the values determined by the if statements above.
 $pagelinks .= $first . " " . $prev . " " . $next . " " . $last;
?>
<?php
$result = $session->getAttribute( 'msg' );
if ( isset( $result ) ) {
$session->removeAttribute( 'msg' );
?>
	<div class="confirm-message" >
	<h1 style="margin:0; text-align:center;"><?php echo stripslashes($result); ?></h1>
	</div>
<?php } ?>
<form name="adminForm" method="post" onsubmit="return submitForm();"   >	
<?php
	if ( $guid == TELEMERGECONSTANT_GUID_ADMIN )
	{
?>
<div id="toolbar" >
<input type="submit" onClick="javascript: if (document.adminForm.boxchecked.value == 0)  { alert('Please select an item from the list to DELETE. '); return false; }else{  document.pressed = this.name ;  }" value="Delete" name="deletevoicefile" class="refresh-button" >
<input type="submit" name="refresh" value="Refresh" class="refresh-button" onclick="javascript:document.location=' <?php echo $myts->htmlentities( $_SERVER['PHP_SELF'] ) . '?' . $myts->htmlentities( $_SERVER['QUERY_STRING'] ); ?>' " /> 
</div>
<?php 
	}
	else
	{
?>
<div id="toolbar" >
<input type="submit" name="refresh" value="Refresh" class="refresh-button" onclick="javascript:document.location=' <?php echo $myts->htmlentities( $_SERVER['PHP_SELF'] ) . '?' . $myts->htmlentities( $_SERVER['QUERY_STRING'] ); ?>' " />
Click on File ID to view the details.
</div>
<?php } ?>
<table width="100%" border="0" id="tlist" cellspacing="0"  >
  <tr >
	<?php if ( $guid == TELEMERGECONSTANT_GUID_ADMIN ) { ?>
    <td width="1%" align="center" class="column-title" ><input type="checkbox" name="toggle" onClick="checkAll(<?php echo  $totalrows ; ?>);" ></td>
	<?php } ?>
	<td width="9%" align="center" class="column-title" >File ID </td>
    <td width="22%" class="column-title" >Audio filename</td>
    <td width="24%"	class="column-title" >Audio file Date uploaded </td>
    <td width="24%"	class="column-title" >Priority</td>
    <td width="37%" colspan="3" align="left" class="column-title" >Transcribed Document </td>
    </tr>
	<?php
	 for($i=0; $i<$numrows; $i++) 
	 {
	 $num = isset( $_GET['start'] ) ? $_GET['start'] : '' ;
	?>
  <tr class="row<?php echo ($i%2); ?>">
	<?php if ( $guid == TELEMERGECONSTANT_GUID_ADMIN ) { ?>
    <td align="center" ><input type="checkbox" name="cid[]" id="cb<?php echo $i ;?>" value="<?php echo $uploaddatas[$i]->uploadID; ?>" onclick="ischecked(this.checked)"  /></td>
    <?php } ?>
	
	<?php
	if ( $guid == TELEMERGECONSTANT_GUID_CLIENT  )
	{
	?>	
    <td align="center" ><a href="viewdetails.php?id=<?php echo $uploaddatas[$i]->uploadID; ?>&menuclick=1"  class="under-line"><?php echo $uploaddatas[$i]->uploadID; ?></a></td>
	<?php
	}
	elseif ( $guid == TELEMERGECONSTANT_GUID_MT or  $guid == TELEMERGECONSTANT_GUID_ADMIN )
	{
	?>
    <td align="center" ><a href="viewdetails_by_mt.php?id=<?php echo $uploaddatas[$i]->uploadID; ?>&menuclick=1"  class="under-line"><?php echo $uploaddatas[$i]->uploadID; ?></a></td>
	<?php
	} ?>
	
	<td>
	<?php
		$path = '../uploads/audio_files/';	
		$file = $uploaddatas[$i]->uploadfilename; 		
		
		$wholepath = $path . $file ;
		//echo "f=$wholepath ";		
		 if (file_exists( $wholepath ) )
		 {
	?>
    <a href= "download_audiofile.php?file=<?php echo $file; ?>" ><?php echo wordwrap( $file , 27 , '<br />' , 1 ); ?>	</a>
	<?php 
		 }
		 else
		 {
		 	echo "<span class=\"redtxt\">none</span>";
		 }
	echo '<br /><b>Remarks : </b>'. $uploaddatas[$i]->uploaddesc ;
	?>	</td>
    <td valign="middle"><?php echo date( 'F j, Y ', $uploaddatas[$i]->uploaddate ) ; ?><br /><?php echo date( 'g:i a', $uploaddatas[$i]->uploaddate ) ; ?></td>
	
	<td valign="middle">
	<?php
	 switch( $uploaddatas[$i]->priority  )
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
	?></td>
	<td valign="middle"><?php
	$doc = new transcribedDocs();
	$data = array();
	$data = $doc->getTranscribedDocumentOfVoiceFile( $uploaddatas[$i]->uploadID ); 
	$path = '../uploads/document_files/';
	$file = $data[0]->docfilename; 
	$s = ( $file != NULL ) ? '<a href=download_docfile.php?file=' . $file . ' >' . wordwrap( $file , 27 , '<br />' , 1 ). '</a>' : 'none';	
	if ( file_exists( $path . $file ) )
	{
		echo $s;	
	}
	else
	{
		 	echo "<span class=\"redtxt\"></span>";
	}	

	?></td>
  </tr>
  <?php } ?>
  
<tr class="pager">
  <td colspan="8"  class="pagelinks" ><?php echo $pagelinks; ?></td>
  <!--<td valign="top">&nbsp;</td>-->
</tr>  
</table>
<input type="hidden" name="boxchecked" value="0" />
</form>
</div>
<?php
	include_once( '../tiles/footer.php' );
?> 
