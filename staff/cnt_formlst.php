<?php

include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$form = $_GET['form'];
$ayear = $_GET['ayear'];
$term = $_GET["term"];
$cnt = mysqli_query("select count(*) from stuinfo where ayear = '$ayear' and form = '$form'");
$data = mysql_result($cnt, 0);
header("content-Type:application/JSON");
echo '{"count_val" : ' . $data . '}';