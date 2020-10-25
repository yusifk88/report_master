<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\Utitlity;
use APP\config;

$ut = new utitlity();

$cf = new config();
$cf->connect();

$status = $_POST['status'];
$ddate = $_POST['ddate'];

$ut = new utitlity();
session_start();
$ut->uid = isset($_SESSION['id']) ?  $_SESSION['id'] : $_SESSION['ad_id'];
$ut->action="Set a login deadline for $ddate with status: $status";
$ut->create_log();
mysqli_query($cf->con, "update deadline set status = '$status', ddate = '$ddate'");