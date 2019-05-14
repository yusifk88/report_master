<?php
include_once("objts/config.php");
include_once("objts/utitlity.php");
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
