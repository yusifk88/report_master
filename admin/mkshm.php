<?php
include_once './objts/config.php';
include_once './objts/utitlity.php';
$ut = new utitlity();
$cf = new config();
$cf->connect();
$id = $_GET['id'];
$stf = mysqli_fetch_object(mysqli_query($cf->con,"select * from staff where id = '$id'"));
mysqli_query($cf->con, "insert into shm(stfid) VALUES('$id')");
session_start();
$ut->uid = isset($_SESSION['id']) ?  $_SESSION['id'] : $_SESSION['ad_id'];
$ut->action = "Made ".$stf->fname." ".$stf->lname." Senior house master/mistress";
$ut->create_log();