<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\config;
use APP\Utitlity;

$cg = new config();
$cg->connect();
$util = new Utitlity();

$stid = $_GET['stid'];
$term = $_GET['term'];
$ayear = $_GET['ayear'];
$cls = $_GET['cls'];
$sub = $_GET['sub'];
$hw1 = $_GET['hw1'];
$hw2 = $_GET['hw2'];
$hw3 = $_GET['hw3'];
$hw4 = $_GET['hw4'];
$totl = $_GET['totl'];

$n = mysqli_fetch_object(mysqli_query($cg->con, "select count(*) as cn from records where stid = '$stid' and term='$term' and acyear='$ayear' and subjt='$sub'and cls='$cls'"))->cn;
if ($n < 1) {
    mysqli_query($cg->con, "insert into records(stid,hw1,hw2,hw3,hw4,subjt,term,acyear,cls,subtotl) values('$stid','$hw1','$hw2','$hw3','$hw4','$sub','$term','$ayear','$cls','$totl')");

    echo "Records Saved";
} else {
    $n2 = mysqli_fetch_object(mysqli_query($cg->con, "select count(*) as cn from records where stid = '$stid' and term='$term' and acyear='$ayear' and subjt='$sub'and cls='$cls' and hw1 is not null and hw2 is not null and hw3 is not null and hw4 is not null"))->cn;
    if ($n2 > 0) {
        echo 'This record already exist, go to the view assessment records page if you want to modify this record';
    } else {
        mysqli_query($cg->con, "update records set hw1='$hw1',hw2='$hw2',hw3='$hw3',hw4='$hw4',subtotl=subtotl+$totl where stid='$stid' and term='$term' and acyear='$ayear' and subjt='$sub'and cls='$cls'");
        echo "Records Saved";

    }

}

