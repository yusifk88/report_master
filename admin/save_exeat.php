<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\config;
$cf = new config();
$cf->connect();
$stid = $_POST['stid'];
$sign_dtime = $_POST['sign_dtime'];
$return_dtime = $_POST['return_dtime'];
$ex = $_POST['ex_type'];
$reason = $_POST['reason'];
session_start();
$stfid = $_SESSION['ad_id'];
mysqli_query($cf->con, "insert into exiat(stid,stfid,date_signed,return_date,reason,ex_type) VALUES ('$stid','$stfid','$sign_dtime','$return_dtime','$reason','$ex')");
echo(mysqli_error($cf->con));