<?php

require_once ( 'http/class.sessions.php' );
require_once ( 'config/constants.php' );

$session = new sessions ;
$session->removeAttribute( TELEMERGECONSTANT_SESS_ACCOUNT_SESSID ); 

$session->destroySession( );
header( 'Location: index.php' );

?>