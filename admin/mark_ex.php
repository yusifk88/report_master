<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\config;
$con = new config();
$con->connect();
$id = $_GET['stid'];
$comm = $_GET['cmm'];
mysqli_query($con->con, "update exiat set remark = '$comm', returned_time = NOW(),returned = 1 WHERE id = '$id'");
echo(mysqli_error($con->con));