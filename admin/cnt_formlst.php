<?php

include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$form = $_GET['form'];
$ayear = $_GET['ayear'];
$term = $_GET["term"];
$cnt = mysqli_query($cf->con,"select count(*) as cn from stuinfo where ayear = '$ayear' and form = '$form' and id not in(SELECT stid from withdraw)");
$data = mysqli_fetch_object($cnt)->cn;
header("content-Type:application/JSON");
echo '{"count_val" : '.$data.'}';