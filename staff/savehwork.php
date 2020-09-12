<?php
include_once './objts/config.php';

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

$cg = new config();
$cg->connect();
include_once './objts/utitlity.php';
$util = new Utitlity();
$totl = $hw1+$hw2+$hw3+$hw4;
if ($totl <= 40) {
    $n = mysqli_fetch_object(mysqli_query($cg->con, "select count(*) as cn from records where stid = '$stid' and term='$term' and acyear='$ayear' and subjt='$sub'and cls='$cls'"))->cn;
    if ($n < 1) {
        mysqli_query($cg->con, "insert into records(stid,hw1,hw2,hw3,hw4,subjt,term,acyear,cls,subtotl) values('$stid','$hw1','$hw2','$hw3','$hw4','$sub','$term','$ayear','$cls','$totl')");

        echo "Records Saved";
    } else {
        $n2 = mysqli_fetch_object(mysqli_query($cg->con, "select count(*) as cn from records where stid = '$stid' and term='$term' and acyear='$ayear' and subjt='$sub'and cls='$cls' and (hw1 + hw2 + hw3 + hw4)>0"))->cn;
        if ($n2 > 0) {
            echo 'This record already exist,please contact your exam officer to modify this record';
        } else {
            mysqli_query($cg->con, "update records set hw1='$hw1',hw2='$hw2',hw3='$hw3',hw4='$hw4',subtotl=subtotl+$totl where stid='$stid' and term='$term' and acyear='$ayear' and subjt='$sub'and cls='$cls'");
            echo "Records Saved";

        }

    }

}