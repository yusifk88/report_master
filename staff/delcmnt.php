<?php
include_once '../admin/objts/config.php';
include_once '../admin/objts/utitlity.php';
$cf = new config();
$cf->connect();
$id = $_GET['id'];
$ut = new utitlity();
$cm = mysqli_fetch_object(mysqli_query($cf->con,"select * from ginfo where id = '$id'"));
session_start();
$ut->uid = isset($_SESSION['id']) ?  $_SESSION['id'] : $_SESSION['ad_id'];
$ut->action="Deleted a comment from a student profile ($cm->coment)";
$ut->create_log();
mysqli_query($cf->con, "delete from ginfo where id = '$id'");