<?php
include_once './objts/config.php';

$stid = $_GET['stid3'];
$term = $_GET['term'];
$ayear = $_GET['ayear'];
$cls = $_GET['cls'];
$sub = $_GET['sub'];
$pw1 = $_GET['pw1'];
$pw2 = $_GET['pw2'];
$totl = $_GET['totl'];

$totl = $pw1+$pw2;
if($totl<=20){
$cg = new config();
$cg->connect();
include_once './objts/utitlity.php';
$util = new Utitlity();
$n = mysqli_fetch_object(mysqli_query($cg->con, "select count(*) as cn from records where stid = '$stid' and term='$term' and acyear='$ayear' and subjt='$sub'and cls='$cls'"))->cn;
if ($n < 1) {
    mysqli_query($cg->con, "insert into records(stid,pw1,pw2,subjt,term,acyear,cls,subtotl) values('$stid','$pw1','$pw2','$sub','$term','$ayear','$cls','$totl')");

    echo "Records Saved";
} else {
    $n2 = mysqli_fetch_object(mysqli_query($cg->con, "select count(*) as cn from records where stid = '$stid' and term='$term' and acyear='$ayear' and subjt='$sub'and cls='$cls' and (pw1 + pw2)>0 "))->cn;
    if ($n2 > 0) {
        echo 'This record already exist, go to the view assessment records page if you want to modify this record';
    } else {
        mysqli_query($cg->con, "update records set pw1='$pw1',pw2='$pw2',subtotl=subtotl+$totl where stid='$stid' and term='$term' and acyear='$ayear' and subjt='$sub'and cls='$cls'");
        echo "Records Saved";


    }


}}

