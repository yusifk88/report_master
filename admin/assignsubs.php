<?php

include_once './objts/config.php';
include_once './objts/utitlity.php';
$ut = new utitlity();
$cnfg = new config();
$cnfg->connect();
$sfid = $_GET['sfid'];
$subid = $_GET['subid'];
$clsid = $_GET['clsid'];
$sub = mysqli_fetch_object(mysqli_query($cnfg->con,"select * from subjects where id = '$subid'"))->subjdesc;
$cls = mysqli_fetch_object(mysqli_query($cnfg->con,"select * from classes where id = '$clsid'"))->classname;
$stf = mysqli_fetch_object(mysqli_query($cnfg->con,"select * from staff where id = '$sfid'"));

if (mysqli_num_rows(mysqli_query($cnfg->con, "select * from subas where subid = " . $subid . " and clid = " . $clsid)) > 0) {
    echo "This subject along with this class was already assigned";
    session_start();
    $ut->uid = isset($_SESSION['id']) ?  $_SESSION['id'] : $_SESSION['ad_id'];
    $ut->action = "Assigned $sub with class $cls to ".$stf->fname." ".$stf->lname ;
    $ut->create_log();
} else {
    mysqli_query($cnfg->con, "insert into subas(subid,stfid,clid) values('$subid','$sfid','$clsid')");
    echo "subject assigned successfully";
}