<?php
// database configuration
// change the settings below that will match in your mysql database server 

$conf['dbhost'] = 'localhost';
$conf['dbusername'] = 'root';
$conf['dbpassword'] = 'webdevel' ;
$conf['dbdatabasename'] = 'teletrandb';





// for live site
/*$conf['dbhost'] = 'localhost';
$conf['dbusername'] = 'teletran_admin' ;
$conf['dbpassword'] = 'admin147$' ;
$conf['dbdatabasename'] = 'teletran_teledb'; */

// max file size allocated 
$conf['max_voicefile_upload'] = 2000000 ;


// mail
//$conf['mail_from'] = 'brainwired@gmail.com';

$conf['mail_from'] = 'support@telemerge.com';

//$conf['mail_c_to'] = 'brainwired@gmail.com';
$conf['mail_c_to'] = 'support@telemerge.com';

$conf['mail_c_subject'] = 'Telemerge Contact Us Form';

// $conf['mail_freetrial_to'] = 'brainwired@gmail.com';
$conf['mail_freetrial_to'] = 'support@telemerge.com';

$conf['mail_freetrial_subject'] = 'Telemerge Free Trial Form';
?>