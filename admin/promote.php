<?php
include_once './objts/config.php';
include_once './objts/utitlity.php';
$cf = new config();
$ut = new utitlity();
$cf->connect();
$prmfrom_class = $_POST['prmfrom_class'];
$prmfrom_form = $_POST['prmfrom_form'];
$prmfrom_ayear = $_POST['prmfrom_ayear'];
$prmto_class = $_POST['prmto_class'];
$prmto_form = $_POST['prmto_form'];
$prmto_ayear = $_POST['prmto_ayear'];
$selects = $_POST['selectchk'];
$selcount = count($selects);
$frmstuds = mysqli_query($cf->con, "select id from stuinfo where id not in (SELECT stid from withdraw) and class = '$prmfrom_class' and form = '$prmfrom_form' and ayear = '$prmfrom_ayear'");
$tday = date('Y-m-d');
for ($i = 0; $i < $selcount; $i++) {
    $stid = $selects[$i];
    $totlfails = mysqli_fetch_object(mysqli_query($cf->con, "select count(*) as cn from records where stid = '$stid' and acyear = '$prmfrom_ayear' and grd = 'F9'"))->cn;
    if ($totlfails < 4) {
        mysqli_query($cf->con, "insert into ginfo(stid,ayear,term,coment,dentry) VALUES ('$stid','$prmfrom_ayear','3','Promoted to Form $prmto_form','$tday')");
        mysqli_query($cf->con, "update stuinfo set ayear = '$prmto_ayear',form='$prmto_form',class='$prmto_class' where id = '$stid'");

    } else if ($totlfails > 3) {
        mysqli_query($cf->con, "insert into ginfo(stid,ayear,term,coment,dentry) VALUES ('$stid','$prmfrom_ayear','3','Promoted on probation to Form $prmto_form','$tday')");
        mysqli_query($cf->con, "update stuinfo set ayear = '$prmto_ayear',form='$prmto_form',class='$prmto_class' where id = '$stid'");
    }
}
$ut = new utitlity();
session_start();
$ut->uid = isset($_SESSION['id']) ?  $_SESSION['id'] : $_SESSION['ad_id'];
$ut->action = "promoted students from $prmfrom_class in form $prmfrom_form $prmfrom_ayear academic year to $prmto_class form $prmto_form $prmto_ayear Academic year";
$ut->create_log();
echo 'Promotion Was Successful';
