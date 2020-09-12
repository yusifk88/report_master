<?php

include_once '../admin/objts/students.php';
include_once '../admin/objts/config.php';
include_once '../admin/objts/utitlity.php';
$cf = new config();
$cf->connect();
$id = $_GET['id'];
$stud = new Students();
$ut = new utitlity();
$stud = mysqli_fetch_object(mysqli_query($cf->con,"select * from stuinfo where id = '$id'"));
session_start();
$ut->uid = isset($_SESSION['id']) ?  $_SESSION['id'] : $_SESSION['ad_id'];
$ut->action="Deleted a student ($stud->fname $stud->lname $stud->oname)";
$ut->create_log();
$msg = $stud->delstudentinfo($id);
mysqli_query($cf->con, "delete from records where stid = '$id'");
mysqli_query($cf->con, "delete from totls where stid = '$id'");




