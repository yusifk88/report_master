<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');

use APP\config;
use APP\Utitlity;

$stid = $_GET['stid3'];
$term = $_GET['term'];
$ayear = $_GET['ayear'];
$cls = $_GET['cls'];
$sub = $_GET['sub'];
$pw1 = $_GET['pw1'];
$pw2 = $_GET['pw2'];
$totl = $_GET['totl'];


$cg = new config();
$cg->connect();
$util = new Utitlity();
$n = mysqli_fetch_object(mysqli_query($cg->con, "select count(*) as cn from records where stid = '$stid' and term='$term' and acyear='$ayear' and subjt='$sub'and cls='$cls'"))->cn;
if ($n < 1) {
    mysqli_query($cg->con, "insert into records(stid,pw1,pw2,subjt,term,acyear,cls,subtotl) values('$stid','$pw1','$pw2','$sub','$term','$ayear','$cls','$totl')");

    echo "Records Saved";
} else {
    $n2 = mysqli_fetch_object(mysqli_query($cg->con, "select count(*) as cn from records where stid = '$stid' and term='$term' and acyear='$ayear' and subjt='$sub'and cls='$cls' and pw1 is not null and pw2 is not null and hw3 is not null and hw4 is not null"))->cn;
    if ($n2 > 0) {
        echo 'This record already exist, go to the view assessment records page if you want to modify this record';
    } else {
        mysqli_query($cg->con, "update records set pw1='$pw1',pw2='$pw2',subtotl=subtotl+$totl where stid='$stid' and term='$term' and acyear='$ayear' and subjt='$sub'and cls='$cls'");
        //--------------------------------------------------totl score------------------
        echo "Records Saved";


    }


}

