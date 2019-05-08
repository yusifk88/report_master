<?php
include_once("../admin/objts/config.php");
$cf = new config();
$stid = $_POST['stid'];
$bid = $_POST['bid'];
$start = $_POST['start'];
$end = $_POST['end'];
$cf->connect();
mysqli_query($cf->con,"insert into books_lend(stid,bid,lenddate,returndate,returned) VALUES ('$stid','$bid','$start','$end',FALSE)");
