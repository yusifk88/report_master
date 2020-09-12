<?php
include_once("../admin/objts/config.php");
include_once("../admin/objts/utitlity.php");
$cf = new config();
$id = $_GET['id'];
mysqli_query($cf->con, "delete from stlogin WHERE stindex = '$id'");

$ut = new utitlity();
$stud = mysqli_fetch_object(mysqli_query($cf->con,"select * from stuinfo where stindex = '$id'"));
session_start();
$ut->uid = isset($_SESSION['id']) ?  $_SESSION['id'] : $_SESSION['ad_id'];
$ut->action="Reset the portal password for student with ID Number ". $id;
$ut->create_log();