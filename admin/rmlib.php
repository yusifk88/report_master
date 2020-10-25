<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\Utitlity;
use APP\config;

$cf = new config();
$ut = new utitlity();
$cf->connect();
$id = $_GET['id'];
$stf = mysqli_fetch_object(mysqli_query($cf->con,"select * from staff where id = '$id'"));
mysqli_query($cf->con, "delete from librian where stfid = '$id'");
session_start();
$ut->uid = isset($_SESSION['id']) ?  $_SESSION['id'] : $_SESSION['ad_id'];
$ut->action = "Unassigned ".$stf->fname." ".$stf->lname." the librarian";
$ut->create_log();
