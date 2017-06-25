<?php
// database configuration
// change the settings below that will match in your mysql database server

// $conf['dbhost'] = 'localhost';
// $conf['dbusername'] = 'root';
// $conf['dbpassword'] = 'webdevel' ;
// $conf['dbdatabasename'] = 'teletrandb';

// for live site
$conf['dbhost'] = isset($_ENV["DB_CLEARDB_HOST"]) ? $_ENV["DB_CLEARDB_HOST"]: 'localhost';
$conf['dbusername'] = isset($_ENV["DB_CLEARDB_USERNAME"]) ? $_ENV["DB_CLEARDB_USERNAME"]: 'root';
$conf['dbpassword'] = isset($_ENV["DB_CLEARDB_PASSWORD"]) ? $_ENV["DB_CLEARDB_PASSWORD"]: 'webdevel';
$conf['dbdatabasename'] = isset($_ENV["DB_CLEARDB_DBNAME"]) ? $_ENV["DB_CLEARDB_DBNAME"]: 'teletrandb';
// max file size allocated
$conf['max_voicefile_upload'] = 2000000 ;
// mail
$conf['mail_from'] = 'support@telemerge.com';
$conf['mail_c_to'] = 'support@telemerge.com';
$conf['mail_c_subject'] = 'Telemerge Contact Us Form';
$conf['mail_freetrial_to'] = 'support@telemerge.com';
$conf['mail_freetrial_subject'] = 'Telemerge Free Trial Form';
?>
