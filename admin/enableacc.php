<?php
include_once 'objts/config.php';
include_once 'objts/utitlity.php';
$ut = new utitlity();
$cf = new config();
$cf->connect();
$id = $_GET['id'];
$stf = mysqli_fetch_object(mysqli_query($cf->con,"select * from staff where id = '$id'"));
mysqli_query($cf->con, "update staff set status = 'active' where id = '$id'");
$ut = new utitlity();
session_start();
$ut->uid = isset($_SESSION['id']) ?  $_SESSION['id'] : $_SESSION['ad_id'];
$ut->action = "Enabled the login of $stf->fname $stf->lname";
$ut->create_log();