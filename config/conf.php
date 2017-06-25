<?php
// database configuration
// change the settings below that will match in your mysql database server

// $conf['dbhost'] = 'localhost';
// $conf['dbusername'] = 'root';
// $conf['dbpassword'] = 'webdevel' ;
// $conf['dbdatabasename'] = 'teletrandb';

// for live site
// $conf['dbhost'] = $_ENV["DB_CLEARDB_HOST"];
if (isset($_ENV["VCAP_SERVICES"])) {
  print 'VCAP_SERVICES: ';
  print_r($_ENV["VCAP_SERVICES"]);
}
$a =getenv("DB_CLEARDB_HOST");
print 'x1: ';
print $a;
$b = isset($_ENV["DB_CLEARDB_USERNAME"]) ? $_ENV["DB_CLEARDB_USERNAME"]: 'none x2';
print '<br>x2: ';
print $b;
// $conf['dbusername'] = $_ENV["DB_CLEARDB_USERNAME"];
// $conf['dbusername'] = getenv("DB_CLEARDB_USERNAME");
$conf['dbhost'] = 'us-cdbr-sl-dfw-01.cleardb.net';
$conf['dbusername'] = 'b7616571a16ba9';
$conf['dbpassword'] = 'b946dcbc';
$conf['dbdatabasename'] = 'ibmx_98f1ba724131160';
// max file size allocated
$conf['max_voicefile_upload'] = 2000000 ;
// mail
$conf['mail_from'] = 'support@telemerge.com';
$conf['mail_c_to'] = 'support@telemerge.com';
$conf['mail_c_subject'] = 'Telemerge Contact Us Form';
$conf['mail_freetrial_to'] = 'support@telemerge.com';
$conf['mail_freetrial_subject'] = 'Telemerge Free Trial Form';
?>
