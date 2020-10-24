<?php
include_once './objts/config.php';
$stid = $_GET['stid'];
$term = $_GET['term'];
$ayear = $_GET['ayear'];
$cls = $_GET['cls'];
$sub = $_GET['sub'];
$ta1 = $_GET['ta1'];
$ta2 = $_GET['ta2'];
$ta3 = $_GET['ta3'];
$ta4 = $_GET['ta4'];
$totl = $_GET['totl'];

$cg = new config();
$cg->connect();
include_once './objts/utitlity.php';
$util = new Utitlity();
$n = mysqli_fetch_object(mysqli_query($cg->con, "select count(*) as cn from records where stid = '$stid' and term='$term' and acyear='$ayear' and subjt='$sub'and cls='$cls'"))->cn;
if ($n < 1) {
    mysqli_query($cg->con, "insert into records(stid,ta1,ta2,ta3,ta4,subjt,term,acyear,cls,subtotl) values('$stid','$ta1','$ta2','$ta3','$ta4','$sub','$term','$ayear','$cls','$totl')");
    echo "Records Saved";
} else {
    $n2 = mysqli_fetch_object(mysqli_query($cg->con, "select count(*) as cn from records where stid = '$stid' and term='$term' and acyear='$ayear' and subjt='$sub'and cls='$cls' and ta1 is not null and ta2 is not null and ta3 is not null and ta4 is not null"))->cn;
    if ($n2 > 0) {
        echo 'This record already exist, go to the view assessment records page if you want to modify this record';
    } else {
        mysqli_query($cg->con, "update records set ta1='$ta1',ta2='$ta2',ta3='$ta3',ta4='$ta4',subtotl=subtotl+$totl where stid='$stid' and term='$term' and acyear='$ayear' and subjt='$sub'and cls='$cls'");
        echo "Records Saved";
    }


}

