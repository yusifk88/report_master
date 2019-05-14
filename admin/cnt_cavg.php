<?php

include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$cls = $_GET['clas'];
$ayear = $_GET['ayear'];
$term = $_GET['term'];
$cnt = mysqli_query($cf->con, "select count(*) as cn from records where cls = '$cls' and acyear = '$ayear' and term='$term' and stid not in(SELECT stid from withdraw)");
$data = mysqli_fetch_object($cnt)->cn;
header("content-Type:application/JSON");
echo '{"count_val" : ' . $data . '}';