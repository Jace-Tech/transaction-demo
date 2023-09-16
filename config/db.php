<?php 

define("HOST", "localhost");
define("USER", "root");
define("PASSWORD", "");
define("DB", "transact");

$DSN = "mysql:host=" . HOST .";dbname=" . DB;
$connect = new PDO($DSN, USER, PASSWORD);

if(!$connect) die("FAILED TO CONNECT TO DB");

$connect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
