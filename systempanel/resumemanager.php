<?php
	include_once( '../tiles/header.php' );
?>
<?php
	// load user menu
	load_usermenu( );
?>
<div id="content" >
<?php
require_once ( '../libraries/class.resume.php' );
require_once ( '../libraries/class.transcribed_docs.php' );
require_once ( '../libraries/class.sanitizer.php' );
require_once ( '../libraries/class.paginator.php' );

$resume = new applicant_resume;
$myts =& textSanitizer::getInstance( );


$data = $session->getAttribute( TELEMERGECONSTANT_SESS_ACCOUNT_SESSID );
$uid = $data[TELEMERGECONSTANT_SESS_UID];
$guid = $data[TELEMERGECONSTANT_SESS_GUID];

$limit = 10;
$start = (isset($_GET['start'])) ? $_GET['start'] : 0;

switch( $guid )
{
	case TELEMERGECONSTANT_GUID_ADMIN : // admin
		$alldata = $resume->getAllSubmittedResume(  );
		$totalrows = count( $alldata ) ;
		$resumedatas = $resume->getAllSubmittedResume( $start  , $limit );
		$setviewpage = 'viewdetails.php';
		$numrows = count( $resumedatas ) ;
		break;
	case TELEMERGECONSTANT_GUID_CLIENT : // client
		break;
	case TELEMERGECONSTANT_GUID_MT : // mt
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
	 $first="<a href=\"" .  $a->getPageName() . "?page=" . $a->getFirst() . "&start=0"  . "\">First</a> |"; 
}

//check to see that getPrevious() is returning a value. If not there will be no link.
if($a->getPrevious())
{
	 $prev = "<a href=\"" .  $a->getPageName() . "?page=" . $a->getPrevious() . "&start=" . ($a->getFirstOf() - $limit-1) . "\">Prev</a> | ";
}
else 
{
	$prev="Prev | "; 
}
//check to see that getNext() is returning a value. If not there will be no link.
if($a->getNext())
{
	 $next = "<a href=\"" . $a->getPageName() . "?page=" . $a->getNext() . "&start=" . $a->getSecondOf() .  "\">Next</a> | ";
}
else 
{ 
	$next="Next | "; 
}

 //check to see that getLast() is returning a value. If not there will be no link.
if($a->getLast())
{
	 $last = "<a href=\"" . $a->getPageName() . "?page=" . $a->getLast() . "&start=" . ($limit2 + $limit) . "\">Last</a> | ";
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
<form name="adminForm" method="post" onsubmit="return submitForm();" >	
<?php
	if ( $guid == TELEMERGECONSTANT_GUID_ADMIN )
	{
?>
<div id="toolbar" >
<input type="submit" onClick="javascript: if (document.adminForm.boxchecked.value == 0)  { alert('Please select an item from the list to DELETE. '); return false; }else{  document.pressed = this.name ;  }" value="Delete" name="deleteresume" class="refresh-button">

</div>
<?php } ?>
<table width="100%" border="0" id="tlist" cellspacing="0" >
  <tr >
    <td width="1%" align="center" class="column-title" >#</td>
    <td width="1%" align="center" class="column-title" ><input type="checkbox" name="toggle" onClick="checkAll(<?php echo  $totalrows ; ?>);" ></td>
    <td width="15%" class="column-title" >Name</td>
    <td width="18%"	class="column-title" >Email </td>
    <td width="19%" class="column-title" >Position Desired </td>
    <td width="18%" class="column-title" >Resume</td>
    <td width="23%" colspan="3" align="left" class="column-title" >Cover letter </td>
    </tr>
	<?php
	 for($i=0; $i<$numrows; $i++) 
	 {
	 $num = isset( $_GET['start'] ) ? $_GET['start'] : '' ;
	?>
  <tr class="row<?php echo ($i%2); ?>">
    <td align="center" ><?php echo ($num+$i+1); ?></td>
    <td align="center" ><input type="checkbox" name="cid[]" id="cb<?php echo $i ;?>" value="<?php echo $resumedatas[$i]->resumeID; ?>" onclick="ischecked(this.checked)"  /></td>
    <td><span class="cap2"><?php echo wordwrap( ( $resumedatas[$i]->name ), 50, "<br />" ); ?> </span>	  </td>

    <td valign="middle"><?php echo date( 'F j, Y ', $resumedatas[$i]->email ) ; ?></td>
	<td valign="middle"><?php echo $resumedatas[$i]->position_desired ; ?></td>
	<td valign="middle">
     <a href= "download.php?file=<?php $path = '../uploads/resume_files/';  $file = $resumedatas[$i]->resume; echo $path.$file; ?>" ><?php echo wordwrap( $resumedatas[$i]->resume , 20 , "<br />" , 1 ) ; ?></a>	</td>
	<td valign="middle"> <a href= "download.php?file=<?php $path = '../uploads/resume_files/';  $file = $resumedatas[$i]->coverletter; echo $path.$file; ?>" ><?php echo wordwrap( $resumedatas[$i]->coverletter , 20 , "<br />" , 1 ) ; ?></a>	</td>
  </tr>
  <?php } ?>
  
<tr class="pager">
  <td colspan="7"  class="pagelinks" ><?php echo $pagelinks; ?></td>
  <!--<td valign="top">&nbsp;</td>-->
</tr>  
</table>
<input type="hidden" name="boxchecked" value="0" />
</form>
</div>
<?php
	include_once( '../tiles/footer.php' );
?> 
