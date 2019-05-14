<?php

include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$cls = $_GET['cls'];
$ayear = $_GET['ayear'];
$term = $_GET["term"];
$cnt = mysqli_query("select count(*) from records where acyear = '$ayear' and term = '$term' and cls = '$cls'");
$data = mysql_result($cnt, 0);
header("content-Type:application/JSON");
echo '{"count_val" : ' . $data . '}';