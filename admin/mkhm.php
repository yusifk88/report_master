<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\Utitlity;
use APP\config;
$ut = new utitlity();
$cf = new config();
$cf->connect();
$stfid = $_POST['stfid'];
$house = $_POST['house'];
$stf = mysqli_fetch_object(mysqli_query($cf->con,"select * from staff where id = '$stfid'"));
$hus = mysqli_fetch_object(mysqli_query($cf->con,"select * from houses where id = '$house'"));
mysqli_query($cf->con, "insert into housem(stfid,hid) VALUES('$stfid','$house')");
session_start();
$ut->uid = isset($_SESSION['id']) ?  $_SESSION['id'] : $_SESSION['ad_id'];
$ut->action = "Assigned ".$stf->fname." ".$stf->lname." as house master/mistress of ".$hus->name."(".$hus->des.")";
$ut->create_log();