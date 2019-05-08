<?php

include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$hse = $_GET['hse'];
$ayear = $_GET['ayear'];
$cnt = mysqli_query("select count(*) from stuinfo where house = '$hse' and ayear = '$ayear'");
$data = mysql_result($cnt, 0);
header("content-Type:application/JSON");
echo '{"count_val" : '.$data.'}';