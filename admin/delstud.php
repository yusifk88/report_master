<?php

include_once './objts/config.php';
include_once './objts/utitlity.php';
$cf = new config();
$cf->connect();
$id = $_GET['id'];
$ut = new utitlity();
$stud = mysqli_fetch_object(mysqli_query($cf->con,"select * from stuinfo where id = '$id'"));
session_start();
$ut->uid = isset($_SESSION['id']) ?  $_SESSION['id'] : $_SESSION['ad_id'];
$ut->action="Deleted a student ($stud->fname $stud->lname $stud->oname)";
$ut->create_log();
mysqli_query($cf->con,"delete from stuinfo where id = '$id'");
mysqli_query($cf->con, "delete from records where stid = '$id'");




