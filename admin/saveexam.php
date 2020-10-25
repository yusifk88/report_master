<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\config;
use APP\Utitlity;
$stid = $_GET['stid'];
$term = $_GET['term'];
$ayear = $_GET['ayear'];
$cls = $_GET['cls'];
$sub = $_GET['sub'];
$exam = $_GET['exam'];


$cg = new config();
$cg->connect();
$util = new Utitlity();
$n = mysqli_fetch_object(mysqli_query($cg->con, "select count(*) as cn from records where stid = '$stid' and term='$term' and acyear='$ayear' and subjt='$sub'and cls='$cls'"))->cn;
if ($n < 1) {
    mysqli_query($cg->con, "insert into records(stid,subjt,term,acyear,cls,exam) values('$stid','$sub','$term','$ayear','$cls','$exam')");
    //--------------------------------------------------totl score------------------

    echo "Records Saved";
} else {
    $n2 = mysqli_fetch_object(mysqli_query($cg->con, "select count(*) as cn from records where stid = '$stid' and term='$term' and acyear='$ayear' and subjt='$sub'and cls='$cls' and exam > 0"))->cn;
    if ($n2 > 0) {
        echo 'This record already exist, go to the view assessment records page if you want to modify this record';
    } else {
        mysqli_query($cg->con, "update records set exam='$exam' where stid='$stid' and term='$term' and acyear='$ayear' and subjt='$sub'and cls='$cls'");
        //--------------------------------------------------totl score------------------

        echo "Records Saved";


    }


}

