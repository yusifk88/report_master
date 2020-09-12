<?php
include_once '../admin/objts/config.php';
$cf = new config();
$cf->connect();
include_once '../admin/objts/utitlity.php';
$ut = new Utitlity();
$id = $_GET['id'];
$term = $_GET['term'];
$ayear = $_GET['ayear'];
$cls = $_GET['cls'];
$sub = $_GET['subjt'];
$stud_rec = mysqli_fetch_object(mysqli_query($cf->con,"select records.*, stuinfo.fname,stuinfo.lname,stuinfo.oname,subjects.subjdesc from records,stuinfo,subjects where records.id = '$id' and records.stid = stuinfo.id and records.subjt = subjects.id"));
session_start();
$ut->uid = isset($_SESSION['id']) ?  $_SESSION['id'] : $_SESSION['ad_id'];
$ut->action ="Deleted record for ".$stud_rec->fname." ".$stud_rec->lname." ".$stud_rec->oname . " ( ".$stud_rec->ta1." : ".$stud_rec->ta2." : ".$stud_rec->ta3." : ".$stud_rec->ta4." : ".$stud_rec->hw1." : ".$stud_rec->hw2." : ".$stud_rec->hw3." : ".$stud_rec->hw4." : ".$stud_rec->pw1." : ".$stud_rec->pw2." : ". $stud_rec->exam .", ".$ut->addsufix($stud_rec->term)." Semester, ".$stud_rec->acyear.",".$stud_rec->subjdesc." ) ";
$ut->create_log();
mysqli_query($cf->con, "delete from records where id = " . $id);

