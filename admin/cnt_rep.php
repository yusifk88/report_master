<?php

include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$stid = $_GET['id'];
$ayear = $_GET['ayear'];
$term = $_GET["term"];
$cnt = mysqli_query($cf->con, "select count(*) as num from records where acyear = '$ayear' and term = '$term' and stid = '$stid'");
$data = mysqli_fetch_object($cnt)->num;
header("content-Type:application/JSON");
echo '{"count_val" : ' . $data . '}';