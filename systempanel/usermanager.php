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
require_once ( '../libraries/class.useraccount.php' );

$user = new UserAccount;
$myts =& textSanitizer::getInstance( );
	
$data = $session->getAttribute( TELEMERGECONSTANT_SESS_ACCOUNT_SESSID );
$uid = $data[TELEMERGECONSTANT_SESS_UID];
$guid = $data[TELEMERGECONSTANT_SESS_GUID];

$start = (isset($_GET['start'])) ? $_GET['start'] : 0 ;
$limit = 10 ;

switch( $guid )
{
	case TELEMERGECONSTANT_GUID_ADMIN : // admin
		$userdata = $user->getAllUserAccount(  );
		$totalrows = count( $userdata ) - 1;
		$userdatas = $user->getAllUserAccount( $start  , $limit );
		$numrows = count( $userdatas ) - 1;
		break;
	case TELEMERGECONSTANT_GUID_CLIENT : // client
		break; 
	case TELEMERGECONSTANT_GUID_MT : // mt
		break;		
}

// remove pre- existing form datas
$session->removeAttribute( 'useraccountdata' );	

if ( isset($_GET['page']) && !empty($_GET['page']) ) {
	$page = $_GET['page'];
}
else {
	$page = 1;
}

$a =& new paginator(  $page , $totalrows ); 
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
	 $first="<a href=\"" .  $a->getPageName() . "?page=" . $a->getFirst() . "&start=0"  . "&menuclick=3\">First</a> |"; 
}

//check to see that getPrevious() is returning a value. If not there will be no link.
if($a->getPrevious())
{
	 $prev = "<a href=\"" .  $a->getPageName() . "?page=" . $a->getPrevious() . "&start=" . ($a->getFirstOf() - $limit-1) . "&menuclick=3\">Prev</a> | ";
}
else 
{
	$prev="Prev | "; 
}
//check to see that getNext() is returning a value. If not there will be no link.
if($a->getNext())
{
	 $next = "<a href=\"" . $a->getPageName() . "?page=" . $a->getNext() . "&start=" . $a->getSecondOf() .  "&menuclick=3\">Next</a> | ";
}
else 
{ 
	$next="Next | "; 
}

 //check to see that getLast() is returning a value. If not there will be no link.
if($a->getLast())
{
	 $last = "<a href=\"" . $a->getPageName() . "?page=" . $a->getLast() . "&start=" . ($limit2 + $limit) . "&menuclick=3\">Last</a> | ";
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
	<h1 style="margin:0; text-align:center;"><?php echo ($result); ?></h1>
	</div>
<?php } ?>
<form name="adminForm" method="post" onsubmit="return submitForm();" action="deletenews.php" >	

<table width="100%" border="0" id="tlist" cellspacing="0">
    <tr>
      <td width="2%"  align="center" class="column-title" >#</td>
      <td width="178"   class="column-title" >Username</td>
      <td width="139"   class="column-title" >Fullname</td>
      <td width="178"   class="column-title" >Email</td>
      <td width="178"  class="column-title" >Contact</td>
      <td width="178"   class="column-title" >Usertype</td>
      <td width="222" colspan="3" align="left"   class="column-title" >Registration Status</td>
      </tr>
    <?php
	 for($i= 0; $i< ( $numrows  )  ; $i++) 
	 {
	 $num = $_GET['start'];
	?>
    <tr class="row<?php echo ($i%2); ?>">
      <td valign="top" align="center"><?php echo ($num+$i+1); ?></td>
      <td valign="top" ><span class="cap2"><a href="viewaccnt.php?id=<?php echo $userdatas[$i]->userID; ?>&amp;menuclick=3" ><?php echo $userdatas[$i]->username; ?></a></span><br /></td>
      <td valign="top"><?php echo $userdatas[$i]->fullname; ?></td>
      <td valign="top"><a href="mailto:<?php echo $userdatas[$i]->email ; ?>" ><?php echo $userdatas[$i]->email ; ?></a></td>
      <td valign="top"><?php echo $userdatas[$i]->contactno ; ?></td>
	  <td valign="top">
	  <?php
	   $g = $user->getGroupname( $userdatas[$i]->usertypeID );
	   echo $g[0]->usertype_name;
	   ?>
	   </td>
	  <td valign="top">
	  <?php 

	  $s = strtolower( $userdatas[$i]->status );
	  $colore = '';
	  switch( $s ) {
	  	case 'accepted' :
			$colore = ' class="paint-accepted" ';
			break;
		case 'waiting for approval' :		
			$colore = ' class="paint-approval" ';
			break;	
		case 'rejected' :		
			$colore = ' class="paint-reject" ';
			break;	
	  }
	  echo "<span $colore >" . $s . "</span>"; 	  
	  ?>
	  </td>
      </tr>
    <?php } ?>
    
  <tr class="pager">
    <td colspan="7"  class="pagelinks"><?php echo $pagelinks; ?></td>
    <!--<td valign="top">&nbsp;</td>-->
  </tr>  
  </table>
</form>  
</div>
<?php
	include_once( '../tiles/footer.php' );
?> 
 
