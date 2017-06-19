<?php
require_once ( 'config/conf.php' );
require_once ( 'config/constants.php' );
require_once ( 'libraries/class.database.php' );
require_once ( 'libraries/class.sanitizer.php' );
require_once ( 'libraries/class.useraccount.php' );

$db = new database ( $conf['dbhost'] , $conf['dbusername'] , $conf['dbpassword'] , $conf['dbdatabasename'] );

$uid = $_GET['uid'];
$actcode = $_GET['code'];

$user =& UserAccount::getInstance( );
$sql = " select userID , activationcode from useraccount ";
$sql .= " where userID = '$uid' ";
$sql .= " and activationcode = '$actcode' ";
$result = $db->query( $sql );
if ( $db->getnumrows() > 0 ) {
	$data = array(
		'lastvisitdate' => time()
	);
	$result = $user->updateUserAccountData( $data , ' userID = ' . $uid );
} 
	if ( $result ) {
?>
You have successfully activated your account. <br  />
Click <a href="http://www.teletranscription.com/index.php" >here</a> to login on the website using your <b>username</b> and <b>password</b>.  <br  />
Thanks!
<?php 
	} 
	else {
?>
<br />
An error occured while activating your account. <br  />
Please contact the site administrator . <br  />
Thanks!
<?php 
	}
?>