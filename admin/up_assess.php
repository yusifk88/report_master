<?php
include_once './objts/config.php';
$cfg = new config();
$cfg->connect();
include_once './objts/utitlity.php';
$util = new Utitlity();
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
$pw1 = $_GET['pw1'];
$pw2 = $_GET['pw2'];
$sum = $ta1 + $ta2 + $ta3 + $ta4 + $hw1 + $hw2 + $hw3 + $hw4 + $pw1 + $pw2;
if ($sum <= 100 && $exam <= 100) {
    $olsubtotl = mysqli_query($cfg->con, "select subtotl,stid,exam from records where id = '$id'");
    $oldrecss = mysqli_fetch_object($olsubtotl);
    $old_subtotl = $oldrecss->subtotl;
    $old_exam = $oldrecss->exam;
    $totl_old_score = $old_exam + $old_subtotl;
    $stid = $oldrecss->stid;
    $subtotl = $ta1 + $ta2 + $ta3 + $ta4 + $hw1 + $hw2 + $hw3 + $hw4 + $pw1 + $pw2;
    mysqli_query($cfg->con, "update records set ta1='$ta1',ta2='$ta2',ta3='$ta3',ta4='$ta4',hw1='$hw1',hw2='$hw2',hw3='$hw3',hw4='$hw4',pw1='$pw1',pw2='$pw2',exam='$exam',subtotl='$subtotl' where id = '$id'");
    mysqli_query($cfg->con, "update totls set totlscore = totlscore-$totl_old_score where term = '$term' and ayear='$ayear' and cls ='$cls' and stid = '$stid'");
    $totlscore = $subtotl + $exam;
    mysqli_query($cfg->con, "update totls set totlscore = totlscore+$totlscore where term = '$term' and ayear='$ayear' and cls ='$cls' and stid = '$stid'");
    echo 'Assessment record Updated successfully';

} else {

    echo 'Invalid entry please check your values and try again';

}