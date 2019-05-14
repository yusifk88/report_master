<?php
include_once './objts/config.php';
include_once './objts/utitlity.php';
$ut = new utitlity();
$cfg = new config();
$cfg->connect();
$id = $_GET['id'];
$stf = mysqli_fetch_object(mysqli_query($cfg->con,"select * from staff where id = '$id'"));
mysqli_query($cfg->con, "delete from shm where stfid = '$id'");
session_start();
$ut->uid = isset($_SESSION['id']) ?  $_SESSION['id'] : $_SESSION['ad_id'];
$ut->action = "Unassigned ".$stf->fname." ".$stf->lname." as Senior house master/mistress";
$ut->create_log();