<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\config;
use APP\Utitlity;
$cfg = new config();
$cfg->connect();
$ut = new utitlity();

$jhsno = Utitlity::escape( $_POST['upjhsno']);
$shsno = Utitlity::escape( $_POST['upshsno']);
$fname = Utitlity::escape( $_POST['upfname']);
$lname = Utitlity::escape( $_POST['uplname']);
$oname = Utitlity::escape( $_POST['uponame']);
$gender = Utitlity::escape( $_POST['upgender']);
$form = Utitlity::escape( $_POST['upform']);
$ayear = Utitlity::escape( $_POST['upayear']);
$dept = Utitlity::escape( $_POST['upprog']);
$class = Utitlity::escape( $_POST['upclass']);
$dob = Utitlity::escape( $_POST['updob']);
$house = Utitlity::escape( $_POST['uphouse']);
$lschool = Utitlity::escape( $_POST['uplsch']);
$ffname = Utitlity::escape( $_POST['upffname']);
$fhometown = Utitlity::escape( $_POST['upfhometown']);
$ftel = Utitlity::escape( $_POST['upftel']);
$mname = Utitlity::escape( $_POST['upmname']);
$mhometown = Utitlity::escape( $_POST['upmhometown']);
$mtel = Utitlity::escape( $_POST['upmtel']);
$photo = Utitlity::escape( $_POST['picpath']);
$id = Utitlity::escape( $_POST['upid']);
$index = Utitlity::escape( $_POST['upindex']);
$resstatus = Utitlity::escape( $_POST['resstatus']);
if (!$photo) {
    mysqli_query($cfg->con, "update stuinfo set fname='$fname',lname='$lname',oname='$oname',gender='$gender',ayear='$ayear',form='$form',class='$class',dept='$dept',house='$house',dob='$dob',lschool='$lschool',ffname='$ffname',fhometown='$fhometown',ftel='$ftel',mfname='$mname',mhometown='$mhometown',mtel='$mtel',jhsno='$jhsno',shsno='$shsno', res_status = '$resstatus' where id = '$id'");
    echo "Student's Info. Updated";
    session_start();
    $ut->uid = isset($_SESSION['id']) ?  $_SESSION['id'] : $_SESSION['ad_id'];
    $ut->action = "Edited the profile of  $fname $lname ";
    $ut->create_log();
} else {
    $exten = substr($photo, -4);
    $picname = md5(time());
    if (copy('objts/' . $photo, 'objts/pass/' . $picname . $exten)) {
        $newpic = 'objts/pass/' . $picname . $exten;
        unlink('objts/' . $photo);
        mysqli_query($cfg->con, "update stuinfo set fname='$fname',lname='$lname',oname='$oname',gender='$gender',ayear='$ayear',form='$form',class='$class',dept='$dept',house='$house',dob='$dob',lschool='$lschool',ffname='$ffname',fhometown='$fhometown',ftel='$ftel',mfname='$mname',mhometown='$mhometown',mtel='$mtel',photo='$newpic',jhsno='$jhsno',shsno='$shsno', res_status='$resstatus' where id = '$id'");
        echo "Student's Info. Updated";
        session_start();
        $ut->uid = isset($_SESSION['id']) ?  $_SESSION['id'] : $_SESSION['ad_id'];
        $ut->action = "Edited the profile of  $fname $lname";
        $ut->create_log();
    } else {
        echo 'Could not move photo, please check and try again';
    }
}




