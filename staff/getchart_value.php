<?php
include_once("objts/config.php");
$cf = new config();
$cf->connect();
$cls = $_GET['class'];
$ayear = $_GET['ayear'];
$sub1 = mysqli_query($cf->con, "select * from subjects where subjects.type = 'Core Subject' and subjdesc not LIKE '%ICT%' and subjdesc not LIKE '%I.C.T%' and subjdesc not like '%pe%' and subjdesc not LIKE '%P.E%' and subjdesc not LIKE '%physical education%'");
$sub2 = mysqli_query($cf->con, "select * from subjects where subjects.type = 'Elective Subject' and id in(select DISTINCT(subjt) from records where cls = '$cls')");
$subarr = array();
$passesArr = array();
$passesArr2 = array();
$failArr = array();
$failArr2 = array();
$index = 0;

while ($row = mysqli_fetch_object($sub1)) {
    $subid = $row->id;
    $numpass = mysqli_fetch_object(mysqli_query($cf->con, "select count(*) as cn from waec where grade_val < 7 and subid = '$subid' and waec.stid in(SELECT id from stuinfo WHERE ayear = '$ayear' and form = '3' and class = '$cls' and gender = 'Male')"))->cn;
    $numpass2 = mysqli_fetch_object(mysqli_query($cf->con, "select count(*) as cn from waec where grade_val< 7 and subid = '$subid' and stid in(SELECT id from stuinfo WHERE ayear = '$ayear' and form = '3' and class = '$cls' and gender = 'Female')"))->cn;
    $numfail = mysqli_fetch_object(mysqli_query($cf->con, "select count(*) as cn from waec where grade_val>6 and subid = '$subid' and stid in(SELECT id from stuinfo WHERE ayear = '$ayear' and form = '3' and class = '$cls' and gender = 'Male')"))->cn;
    $numfail2 = mysqli_fetch_object(mysqli_query($cf->con, "select count(*) as cn from waec where grade_val>6 and subid = '$subid' and stid in(SELECT id from stuinfo WHERE ayear = '$ayear' and form = '3' and class = '$cls' and gender = 'Female')"))->cn;
    $passesArr[$index] = $numpass;
    $passesArr2[$index] = $numpass2;
    $failArr[$index] = $numfail;
    $failArr2[$index] = $numfail2;
    $subarr[$index] = $row->subjdesc;
    $index++;
}
$index2 = $index;
while ($row2 = mysqli_fetch_object($sub2)) {
    $subid = $row2->id;
    $numpass = mysqli_fetch_object(mysqli_query($cf->con, "select count(*) as cn from waec where grade_val<=6 and subid = '$subid' and stid in(SELECT id from stuinfo WHERE ayear = '$ayear' and form = '3' and class = '$cls' and gender = 'Male')"))->cn;
    $numpass2 = mysqli_fetch_object(mysqli_query($cf->con, "select count(*) as cn from waec where grade_val<=6 and subid = '$subid' and stid in(SELECT id from stuinfo WHERE ayear = '$ayear' and form = '3' and class = '$cls' and gender = 'Female')"))->cn;
    $numfail = mysqli_fetch_object(mysqli_query($cf->con, "select count(*) as cn from waec where grade_val>6 and subid = '$subid' and stid in(SELECT id from stuinfo WHERE ayear = '$ayear' and form = '3' and class = '$cls' and gender = 'Male')"))->cn;
    $numfail2 = mysqli_fetch_object(mysqli_query($cf->con, "select count(*) as cn from waec where grade_val>6 and subid = '$subid' and stid in(SELECT id from stuinfo WHERE ayear = '$ayear' and form = '3' and class = '$cls' and gender = 'Female')"))->cn;
    $passesArr[$index2] = $numpass;
    $passesArr2[$index2] = $numpass2;
    $failArr[$index2] = $numfail;
    $failArr2[$index2] = $numfail2;
    $subarr[$index2] = $row2->subjdesc;
    $index2++;
}

$data = (object)[
    "labels" => $subarr,
    "malePass" => $passesArr,
    "maleFail" => $failArr,
    "femalepass" => $passesArr2,
    "femalefail" => $failArr2,
    "inde" => $index

];

header("content-type:application/JSON");
echo(json_encode($data));