<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\config;

$cf = new config();
$cf->connect();
$id = $_GET['id'];
mysqli_query($cf->con, "delete from withdraw where stid = '$id'");