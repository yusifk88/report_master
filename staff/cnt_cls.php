<?php

include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$cls = $_GET['clas'];
$ayear = $_GET['ayear'];
$cnt = mysqli_query("select count(*) from stuinfo where class = '$cls' and ayear = '$ayear'");
$data = mysql_result($cnt, 0);
header("content-Type:application/JSON");
echo '{"count_val" : ' . $data . '}';