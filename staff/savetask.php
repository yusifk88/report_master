<?php
include_once '../admin/objts/config.php';
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

$cg = new Config();
$cg->connect();
$totl = $ta1+$ta2+$ta3+$ta4;

if ($totl <= 40) {
    $n = mysqli_fetch_object(mysqli_query($cg->con, "select count(*) as cn from records where stid = '$stid' and term='$term' and acyear='$ayear' and subjt='$sub'and cls='$cls'"))->cn;
    if ($n < 1) {
        mysqli_query($cg->con, "insert into records(stid,ta1,ta2,ta3,ta4,subjt,term,acyear,cls,subtotl) values('$stid','$ta1','$ta2','$ta3','$ta4','$sub','$term','$ayear','$cls','$totl')");
        echo "Records Saved1";
    } else {
        $n2 = mysqli_fetch_object(mysqli_query($cg->con, "select count(*) as cn from records where stid = '$stid' and term='$term' and acyear='$ayear' and subjt='$sub'and cls='$cls' and (ta1+ta2+ta3+ta4) > 0"))->cn;
        if ($n2 > 0) {
            echo 'This record already exist, go to the view assessment records page if you want to modify this record';
        } else {
            mysqli_query($cg->con, "update records set ta1='$ta1',ta2='$ta2',ta3='$ta3',ta4='$ta4',subtotl=subtotl+$totl where stid='$stid' and term='$term' and acyear='$ayear' and subjt='$sub'and cls='$cls'");
            echo "Records Saved2";
        }

    }
}
