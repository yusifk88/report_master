<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\configl;

$cf = new config();
$cf->connect();
$prog = $_GET['prog'];
$ayear = $_GET['ayear'];
$cls = $_GET['cls'];
$cnt = mysqli_query($cf->con, "select count(*) as cn from stuinfo where dept = '$prog' and ayear = '$ayear' and class = '$cls'");
$data = mysqli_fetch_object($cnt)->cn;
header("content-Type:application/JSON");
echo '{"count_val" : ' . $data . '}';