<?php
	include_once( '../tiles/header.php' );
?>
<?php
	// load user menu
	load_usermenu( );
?>
<div id="content" >
<?php
require_once ( '../libraries/class.articles.php' );
require_once ( '../libraries/class.status.php' );
require_once ( '../libraries/class.sanitizer.php' );
require_once ( '../libraries/class.paginator.php' );

$articles = new NewsArticles;
$myts =& textSanitizer::getInstance( );


$data = $session->getAttribute( TELEMERGECONSTANT_SESS_ACCOUNT_SESSID );
$uid = $data[TELEMERGECONSTANT_SESS_UID];
$guid = $data[TELEMERGECONSTANT_SESS_GUID];

$limit = 10;
$start = (isset($_GET['start'])) ? $_GET['start'] : 0;

switch( $guid )
{
	case TELEMERGECONSTANT_GUID_ADMIN : // admin
		$alldata = $articles->getAllNewsAndEvents(  );
		$totalrows = count( $alldata ) ;
		$newsdatas = $articles->getAllNewsAndEventsByLimit( $start  , $limit );
		// print_r($newsdatas);
		$numrows = count( $newsdatas )-1;
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
	 $first="<a href=\"" .  $a->getPageName() . "?page=" . $a->getFirst() . "&start=0"  . "&menuclick=4\">First</a> |"; 
}

//check to see that getPrevious() is returning a value. If not there will be no link.
if($a->getPrevious())
{
	 $prev = "<a href=\"" .  $a->getPageName() . "?page=" . $a->getPrevious() . "&start=" . ($a->getFirstOf() - $limit-1) . "&menuclick=4\">Prev</a> | ";
}
else 
{
	$prev="Prev | "; 
}
//check to see that getNext() is returning a value. If not there will be no link.
if($a->getNext())
{
	 $next = "<a href=\"" . $a->getPageName() . "?page=" . $a->getNext() . "&start=" . $a->getSecondOf() .  "&menuclick=4\">Next</a> | ";
}
else 
{ 
	$next="Next | "; 
}

 //check to see that getLast() is returning a value. If not there will be no link.
if($a->getLast())
{
	 $last = "<a href=\"" . $a->getPageName() . "?page=" . $a->getLast() . "&start=" . ($limit2 + $limit) . "&menuclick=4\">Last</a> | ";
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
	<h1 style="margin:0; text-align:center;"><?php echo (stripslashes($result)); ?></h1>
	</div>
<?php } ?>
<form name="adminForm" method="post" onsubmit="return submitForm();" action="deletenews.php" >	
<div id="toolbar" >
<input type="submit" onClick="javascript: if (document.adminForm.boxchecked.value == 0)  { alert('Please select an item from the list to DELETE. '); return false; }else{  document.pressed = this.name ;  }" value="Delete" name="deletenews" class="refresh-button" >
</div>

<table width="100%" border="0" id="tlist" cellspacing="0">
  <tr >
    <td width="1%" align="center" class="column-title" >#</td>
    <td width="1%" align="center" class="column-title" ><input type="checkbox" name="toggle" onClick="checkAll(<?php echo  $totalrows ; ?>);" ></td>
    <td width="29%" class="column-title" >News/Events Title </td>
    <td width="26%"	class="column-title" >Date Created </td>
    <td width="20%" colspan="3" align="left" class="column-title" > Status </td>
    </tr>
	<?php
	 for($i=0; $i<$numrows; $i++) 
	 {
	 $num = isset( $_GET['start'] ) ? $_GET['start'] : '' ;
	?>
  <tr class="row<?php echo ($i%2); ?>">
    <td align="center" ><?php echo ($num+$i+1); ?></td>
    <td align="center" ><input type="checkbox" name="cid[]" id="cb<?php echo $i ;?>" value="<?php echo $newsdatas[$i]->newsID; ?>" onclick="ischecked(this.checked)"  /></td>
    <td><span class="cap2"><a href="viewnews.php?id=<?php echo $newsdatas[$i]->newsID; ?>&amp;menuclick=4" ><?php echo wordwrap( ( $newsdatas[$i]->newstitle ), 50, "<br />" ); ?></a></span>	  </td>

    <td valign="middle"><?php echo date( 'F j, Y g:i a', $newsdatas[$i]->datecreated ) ; ?></td>
	
	<td valign="middle"><?php
	$status =& status::getInstance();
	$statname = $status->getStatusById( $newsdatas[$i]->status );
	// echo $statname[0]->status;
	$s = strtolower( $statname[0]->status );
	$colore = '';
	switch( $s ) {
	case 'published' :
		$colore = ' class="paint-accepted" ';
		break;
	case 'unpublished' :		
		$colore = ' class="paint-approval" ';
		break;	
	case 'draft' :		
		$colore = ' class="paint-reject" ';
		break;	
	}
	echo "<span $colore >" . $s . "</span>"; 	  
	
	 ?></td>
  </tr>
  <?php } ?>
  
<tr class="pager">
  <td colspan="6" class="pagelinks" ><?php echo $pagelinks; ?></td>
  <!--<td valign="top">&nbsp;</td>-->
</tr>  
</table>
<input type="hidden" name="boxchecked" value="0" />
</form>
</div>
<?php
	include_once( '../tiles/footer.php' );
?> 
 
