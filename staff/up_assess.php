<?php
include_once '../admin/objts/config.php';
$cfg = new config();
$cfg->connect();
include_once '../admin/objts/utitlity.php';
$ut = new Utitlity();
$id = $_GET['id'];
$term = $_GET['term'];
$ayear = $_GET['ayear'];
$cls = $_GET['cls'];
$sub = $_GET['subjt'];
$exam = $_GET['exam'];
$ta1 = $_GET['ta1'];
$ta2 = $_GET['ta2'];
$ta3 = $_GET['ta3'];
$ta4 = $_GET['ta4'];
$hw1 = $_GET['hw1'];
$hw2 = $_GET['hw2'];
$hw3 = $_GET['hw3'];
$hw4 = $_GET['hw4'];
$pw1= $_GET['pw1'];
$pw2= $_GET['pw2'];
$sum = $ta1 + $ta2 + $ta3 + $ta4 + $hw1 + $hw2 + $hw3 + $hw4 + $pw1 + $pw2;
$stud_rec = mysqli_fetch_object(mysqli_query($cfg->con,"select records.*, stuinfo.fname,stuinfo.lname,stuinfo.oname,subjects.subjdesc from records,stuinfo,subjects where records.id = '$id' and records.stid = stuinfo.id and records.subjt = subjects.id"));
if ($sum <= 100 && $exam <= 100) {
    $subtotl = $ta1 + $ta2 + $ta3 + $ta4 + $hw1 + $hw2 + $hw3 + $hw4 + $pw1 + $pw2;
    mysqli_query($cfg->con, "update records set ta1='$ta1',ta2='$ta2',ta3='$ta3',ta4='$ta4',hw1='$hw1',hw2='$hw2',hw3='$hw3',hw4='$hw4',pw1= '$pw1',pw2='$pw2',exam='$exam',subtotl='$subtotl' where id = '$id'");
    session_start();
    $ut->uid = isset($_SESSION['id']) ?  $_SESSION['id'] : $_SESSION['ad_id'];
    $ut->action ="Changed records of ".$stud_rec->fname." ".$stud_rec->lname." ".$stud_rec->oname . " from ".$stud_rec->ta1." : ".$stud_rec->ta2." : ".$stud_rec->ta3." : ".$stud_rec->ta4." : ".$stud_rec->hw1." : ".$stud_rec->hw2." : ".$stud_rec->hw3." : ".$stud_rec->hw4." : ".$stud_rec->pw1." : ".$stud_rec->pw2." : ". $stud_rec->exam ." TO ".$ta1." : ".$ta2." : ".$ta3." : ".$ta4." : ".$hw1." : ".$hw2." : ".$hw3." : ".$hw4." : ".$pw1." : ".$pw2." : ".$exam." (".$ut->addsufix($term)." Semister, ".$ayear." ".$stud_rec->subjdesc.")";
    $ut->create_log();
    echo 'Assessment record Updated successfully';

} else {
    echo 'Invalid entry please check your values and try again';
}