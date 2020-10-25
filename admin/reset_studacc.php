<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\config;
use APP\Utitlity;

$cf = new config();
$id = $_GET['id'];
mysqli_query($cf->con, "delete from stlogin WHERE stindex = '$id'");

$ut = new utitlity();
$stud = mysqli_fetch_object(mysqli_query($cf->con,"select * from stuinfo where stindex = '$id'"));
session_start();
$ut->uid = isset($_SESSION['id']) ?  $_SESSION['id'] : $_SESSION['ad_id'];
$ut->action="Reset the portal password for $stud->fname $stud->lname $stud->oname";
$ut->create_log();