<?php
include_once '../admin/objts/config.php';
include_once '../admin/objts/utitlity.php';
$cf = new config();
$cf->connect();
$id = $_POST['id'];
$term = $_POST['term'];
$year = $_POST['ayear'];
$d = $_POST['dentry'];
$cmt = $_POST['cmnt'];
mysqli_query($cf->con, "insert into ginfo(stid,coment,term,ayear,dentry) VALUES ('$id','$cmt','$term','$year','$d')");
$stud = mysqli_fetch_object(mysqli_query($cf->con,"select * from stuinfo where id = '$id'"));
$ut = new utitlity();
session_start();
$ut->uid = isset($_SESSION['id']) ?  $_SESSION['id'] : $_SESSION['ad_id'];
$ut->action = mysqli_escape_string($cf->con,"Added a comment ($cmt) to   $stud->fname $stud->lname $stud->oname's profile");
$ut->create_log();