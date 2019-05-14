<?php
include_once("objts/config.php");
include_once("objts/utitlity.php");
set_time_limit(300);
$cf = new config();
$cf->connect();
$ut = new utitlity();
$cls = $_POST['cls'];
$term = $_POST['term'];
$ayear = $_POST['ayear'];
$msg = $_POST['msg'];
$numbers = mysqli_query($cf->con, "select * from stuinfo where class = '$cls' and ayear = '$ayear'");
$number_list = '';
$scount = 0;
$fcount = 0;
$i = 0;
while ($row = mysqli_fetch_object($numbers)) {
    $i++;
    $ut->numbers = $row->ftel;
    $ut->message = $msg;
    $info = $ut->sendMessage();

    echo($info . " - " . $row->fname . $row->lname . "'s Father( Mr." . $row->ffname . ") <br/><br/>");


    if ($info == "Messages has been sent successfully") {

        $scount++;;

    } else {

        $fcount++;


    }

}

$rep = "Total terget number: " . $i . " Number successful: " . $scount . " number failed: " . $fcount;

mysqli_query($cf->con, "insert into smsnotif(term,ayear,cls,msg,status) VALUES('$term','$ayear','$cls','$msg','$rep')");









