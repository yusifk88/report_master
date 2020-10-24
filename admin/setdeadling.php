<?php
include_once 'objts/config.php';
include_once './objts/utitlity.php';
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