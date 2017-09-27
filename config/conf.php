<?php
// database configuration
// change the settings below that will match in your mysql database server

// $conf['dbhost'] = 'localhost';
// $conf['dbusername'] = 'root';
// $conf['dbpassword'] = 'webdevel' ;
// $conf['dbdatabasename'] = 'teletrandb';

date_default_timezone_set("Asia/Manila");

define('DB_HOST_DEV', 'localhost');
define('DB_PORT_DEV', '3306'); 
define('DB_USER_DEV', 'root');
define('DB_PASS_DEV', 'webdevel');
define('DB_DBNAME_DEV', 'teletrandb');

if (isset($_ENV["DB_HOST_DEV"])) {
  // $DB_HOST_DEV = $_ENV["DB_HOST_DEV"] || DB_HOST_DEV; // it wont work like this!
  $DB_HOST_DEV = isset($_ENV["DB_HOST_DEV"]) ? $_ENV["DB_HOST_DEV"] : DB_HOST_DEV;
  $DB_PORT_DEV = isset($_ENV["DB_PORT_DEV"]) ? $_ENV["DB_PORT_DEV"] : DB_PORT_DEV;
  $DB_USER_DEV = isset($_ENV["DB_USER_DEV"]) ? $_ENV["DB_USER_DEV"] : DB_USER_DEV;
  $DB_PASS_DEV = isset($_ENV["DB_PASS_DEV"]) ? $_ENV["DB_PASS_DEV"] : DB_PASS_DEV;
  $DB_DBNAME_DEV = isset($_ENV["DB_DBNAME_DEV"]) ? $_ENV["DB_DBNAME_DEV"] : DB_DBNAME_DEV;
}

if (isset($_ENV["DB_CLEARDB_HOST"])) { // If using IBM Bluemix ClearDB
  $DB_HOST_PROD = $_ENV["DB_CLEARDB_HOST"];
  $DB_PORT_PROD = $_ENV["DB_CLEARDB_PORT"];
  $DB_USER_PROD = $_ENV["DB_CLEARDB_USERNAME"];
  $DB_PASS_PROD = $_ENV["DB_CLEARDB_PASSWORD"];
  $DB_DBNAME_PROD = $_ENV["DB_CLEARDB_DBNAME"];
} else if(isset($_ENV["OPENSHIFT_MYSQL_DB_HOST"])) { // If using OpenShift MYSQL
  $DB_HOST_PROD = $_ENV["OPENSHIFT_MYSQL_DB_HOST"];
  $DB_PORT_PROD = $_ENV["OPENSHIFT_MYSQL_DB_PORT"];
  $DB_USER_PROD = $_ENV["OPENSHIFT_MYSQL_DB_USERNAME"];
  $DB_PASS_PROD = $_ENV["OPENSHIFT_MYSQL_DB_PASSWORD"];
  $DB_DBNAME_PROD = $_ENV["OPENSHIFT_MYSQL_DB_DBNAME"];
}

$conf['dbhost'] = isset($DB_HOST_DEV) ? $DB_HOST_DEV: $DB_HOST_PROD;
$conf['dbusername'] = isset($DB_USER_DEV) ? $DB_USER_DEV: $DB_USER_PROD;
$conf['dbpassword'] = isset($DB_PASS_DEV) ? $DB_PASS_DEV: $DB_PASS_PROD;
$conf['dbdatabasename'] = isset($DB_DBNAME_DEV) ? $DB_DBNAME_DEV: $DB_DBNAME_PROD;

// max file size allocated
$conf['max_voicefile_upload'] = 2000000 ;
// mail
$conf['mail_from'] = 'support@telemerge.com';
$conf['mail_c_to'] = 'support@telemerge.com';
$conf['mail_c_subject'] = 'Telemerge Contact Us Form';
$conf['mail_freetrial_to'] = 'support@telemerge.com';
$conf['mail_freetrial_subject'] = 'Telemerge Free Trial Form';

echo "<pre>";
print_r($conf);
echo "</pre>";