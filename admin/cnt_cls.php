<?php

include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$cls = $_GET['clas'];
$ayear = $_GET['ayear'];
$cnt = mysqli_query($cf->con, "select count(*) as cn from stuinfo where class = '$cls' and ayear = '$ayear' and id not in(SELECT stid from withdraw)");
$data = mysqli_fetch_object($cnt)->cn;
header("content-Type:application/JSON");
echo '{"count_val" : ' . $data . '}';