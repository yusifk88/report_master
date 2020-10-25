<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\config;
use APP\Utitlity;

$ut = new utitlity();
$cf = new config();
$cf->connect();
$id = $_GET['id'];
$pass = md5($_GET['new_pass']);
$stf = mysqli_fetch_object(mysqli_query($cf->con,"select * from staff where id = '$id'"));
mysqli_query($cf->con, "update staff set upass = '$pass' where id = '$id'");
session_start();
$ut->uid = isset($_SESSION['id']) ?  $_SESSION['id'] : $_SESSION['ad_id'];
$ut->action = "Changed the password of ".$stf->fname." ".$stf->lname;
$ut->create_log();
