<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\Staff;
use APP\config;
use APP\Utitlity;

$stf = new Staff();
$ut = new utitlity();
$cfg = new config();
$cfg->connect();
$stfid = $_POST['stfid'];
$cls = $_POST['cls'];


$clsname = mysqli_fetch_object(mysqli_query($cfg->con,"select * from classes where id = '$cls'"))->classname;
$stf = mysqli_fetch_object(mysqli_query($cfg->con,"select * from staff where id = '$stfid'"));
$testaff = mysqli_query($cfg->con, "select fname,lname,gender,frmmaters.clid from staff,frmmaters where frmmaters.clid = '$cls' and staff.id = frmmaters.stfid ");
if (mysqli_num_rows($testaff) > 0) {
    $mstaff = mysqli_fetch_object($testaff);
    $pronoun = ($mstaff->gender == "Male" ? "Mr." : "Miss");
    $titl = ($mstaff->gender == "Male" ? "Form master" : "Form mistress");
    echo $pronoun . " " . $mstaff->fname . " " . $mstaff->lname . " is currently the " . $titl . " of ".$clsname.", please select a different class";
} else {
    mysqli_query($cfg->con, "insert into frmmaters(stfid,clid) VALUES ('$stfid','$cls')");
    session_start();
    $ut->uid = isset($_SESSION['id']) ?  $_SESSION['id'] : $_SESSION['ad_id'];
    $ut->action = "Assigned ".$stf->fname." ".$stf->lname." as form master/mistress of ".$cls ;
    $ut->create_log();
    echo "Class added successfully";
}