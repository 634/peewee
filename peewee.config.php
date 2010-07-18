<?php
// peewee root directory
$root_dir = "C:/xampp/htdocs/peewee/";

// adodb_path
$adodb_inc_path = "./adodb/adodb.inc.php"; 

// dsn(data source name)
//$peewee_dsn = "mysql://root:@localhost/peewee";
$peewee_dsn_server = "localhost";
$peewee_dsn_user = "root";
$peewee_dsn_password = "";
$peewee_dsn_database = "";
$peewee_dsn_encode = "utf8";

// output directory
$output_dir = "./output/";

// system definition
define("ADODB_INC_PATH", $adodb_inc_path);
define("PEEWEE_DSN_SERVER", $peewee_dsn_server);
define("PEEWEE_DSN_USER", $peewee_dsn_user);
define("PEEWEE_DSN_PASSWORD", $peewee_dsn_password);
define("PEEWEE_DSN_DATABASE", $peewee_dsn_database);
define("PEEWEE_DSN_ENCODE", $peewee_dsn_encode);
define("OUTPUT_DIR", $output_dir);
define("ROOT_DIR", $root_dir);
?>