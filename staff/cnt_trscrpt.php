<?php

include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$stid = $_GET['stname'];
$cnt = mysqli_query("select count(*) from records where stid = '$stid'");
$data = mysql_result($cnt, 0);
header("content-Type:application/JSON");
echo '{"count_val" : '.$data.'}';