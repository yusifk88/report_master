<?php

require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\config;

$cf = new config();
$cf->connect();
$cls = $_GET['cls'];
$ayear = $_GET['ayear'];
$term = $_GET["term"];
$cnt = mysqli_query($cf->con, "select count(*) as cn from records where acyear = '$ayear' and term = '$term' and cls = '$cls'");
$data = mysqli_fetch_object($cnt)->cn;
header("content-Type:application/JSON");
echo '{"count_val" : ' . $data . '}';