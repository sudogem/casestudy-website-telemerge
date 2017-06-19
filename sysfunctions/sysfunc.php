<?php
	
function load_usermenu()
{
	global $session ;
	
	if ( $session->isAttributeExist( TELEMERGECONSTANT_SESS_ACCOUNT_SESSID ) === true )
	{
		$data = $session->getAttribute( TELEMERGECONSTANT_SESS_ACCOUNT_SESSID );
		if ( isset( $data[TELEMERGECONSTANT_SESS_GUID] ) && $data[TELEMERGECONSTANT_SESS_GUID] != NULL ) 
		{
			switch( $data[TELEMERGECONSTANT_SESS_GUID] )
			{
				case TELEMERGECONSTANT_GUID_ADMIN : // admin
				 	include_once( '../tiles/sys-menu.php' );						
					break ;
				case TELEMERGECONSTANT_GUID_CLIENT : // client
					include_once( '../tiles/client-menu.php' );							
					break ;
				case TELEMERGECONSTANT_GUID_MT : // mt
					include_once( '../tiles/mt-menu.php' );												
					break ;		
				
			}
		}
	}
}

function getcurrent_page(){
	$curpage = strtolower( basename($_SERVER['PHP_SELF']) );
	return $curpage;
}	

function getmenuclick( $id )
{
	return intval( $id );
}

function isAllowedAccessPage( $guid )
{
	if ( $guid != TELEMERGECONSTANT_GUID_CLIENT ) die( 'Permission denied.' );
}

function load_email_message_template( $template , $data )
{
	switch( strtolower( trim($template) ) )
	{
		case 'contactus' :
$str = '<table width="58%" border="0" cellpadding="11" cellspacing="0" >
  <tr>
    <td width="25%" >Name : </td>
    <td width="85%" >' . $data['name'] . '</td>
  </tr>
  <tr>
    <td>Email : </td>
    <td>' . $data['email'] .'</td>
  </tr>
  <tr>
    <td>Contact no : </td>
    <td>' . $data['contactno'] . '</td>
  </tr>
  <tr>
    <td>Subject : </td>
    <td>' . $data['subject'] . '</td>
  </tr>
  <tr>
    <td valign="top">Message : </td>
    <td>' . $data['message'] . '</td>
  </tr>
</table>';
		
			break;
		case 'freetrial' :
$str = '
<table width="80%" border="0" cellpadding="11" cellspacing="0" >
  <tr>
    <td width="28%" >Name : </td>
    <td width="72%">' . $data['name'] .'</td>
  </tr>
  <tr>
    <td>Profession : </td>
    <td>' . $data['profession'] . '</td>
  </tr>
  <tr>
    <td>Office address : </td>
    <td>' . $data['officeaddress'] . '</td>
  </tr>
  <tr>
    <td>Home address  : </td>
    <td>' . $data['homeaddress'] . '</td>
  </tr>
  <tr>
    <td>City / State : </td>
    <td>' . $data['city'] . '</td>
  </tr>
  <tr>
    <td>Country: </td>
    <td>' . $data['country'] . '</td>
  </tr>
  <tr>
    <td>Cellphone # : </td>
    <td>' . $data['contactno'] . '</td>
  </tr>
  <tr>
    <td>Fax # : </td>
    <td>' . $data['faxno'] . '</td>
  </tr>
  <tr>
    <td>Email address : </td>
    <td>' . $data['emailaddress'] . '</td>
  </tr>
  <tr>
    <td valign="top">What is medical specialty : </td>
    <td>' . $data['medicalspecialty'] . '</td>
  </tr>
  <tr>
    <td valign="top"><p>What  type of document to be dictated: </p></td>
    <td>' . $data['doctype'] . '</td>
  </tr>
  <tr>
    <td valign="top"><p>Average  of lines per document:</p></td>
    <td>' . $data['averageline'] . '</td>
  </tr>
  <tr>
    <td valign="top"><p>Current  MT service payment rate:</p></td>
    <td>' . $data['rate'] . '</td>
  </tr>
  <tr>
    <td valign="top"><p>How long is the delivery:</p></td>
    <td>' . $data['deliverytime'] . '</td>
  </tr>
</table>

';
			break;	
		default :
			$str = 'no template found.';
			break;			
			
	}
	
	return $str ;
}

function makeAShortSummary( $str )
{
	$dotposition = 300 ;
	$str = @substr( $str , 0 , $dotposition + 1 );
	return $str . "......";
}
?>