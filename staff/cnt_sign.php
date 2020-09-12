<?php
include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$prog = $_GET['prog'];
$ayear = $_GET['ayear'];
$cls = $_GET['cls'];
$cnt = mysqli_query("select count(*) from stuinfo where dept = '$prog' and ayear = '$ayear' and class = '$cls'");
$data = mysql_result($cnt, 0);
header("content-Type:application/JSON");
echo '{"count_val" : ' . $data . '}';