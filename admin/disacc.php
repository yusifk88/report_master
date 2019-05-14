<?php
include_once 'objts/config.php';
include_once 'objts/utitlity.php';
$cf = new config();
$ut = new utitlity();
$cf->connect();
$id = $_GET['id'];
$stf = mysqli_fetch_object(mysqli_query($cf->con,"select * from staff where id = '$id'"));
mysqli_query($cf->con, "update staff set status = 'Disabled' where id = '$id'");
$ut = new utitlity();
session_start();
$ut->uid = isset($_SESSION['id']) ?  $_SESSION['id'] : $_SESSION['ad_id'];
$ut->action = "Disabled the login of $stf->fname $stf->lname";
$ut->create_log();