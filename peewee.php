<?php
require_once "./peewee.config.php";
require_once ROOT_DIR . "logic/Peewee.php";

$peewee = new Peewee();
$fileNameArray = $peewee->autoCreate();
foreach($fileNameArray as $fileName){
    print(OUTPUT_DIR . $fileName . "<br>");
}
//example
?>
