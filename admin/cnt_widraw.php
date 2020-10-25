<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\config;

$cf = new config();
$cf->connect();
$ayear = $_GET['ayear'];
$cnt = mysqli_query($cf->con, "select count(*) as cn from stuinfo where ayear = '$ayear' and id in (select stid from withdraw) ");
$data = mysqli_fetch_object($cnt)->cn;
header("content-Type:application/JSON");
echo '{"count_val" : ' . $data . '}';