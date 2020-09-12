<?php
include_once '../admin/objts/config.php';
include_once '../admin/objts/utitlity.php';
$cfg = new config();
$cfg->connect();
$jhsno = mysqli_escape_string($cfg->con, $_POST['upjhsno']);
$shsno = mysqli_escape_string($cfg->con, $_POST['upshsno']);
$fname = mysqli_escape_string($cfg->con, $_POST['upfname']);
$lname = mysqli_escape_string($cfg->con, $_POST['uplname']);
$oname = mysqli_escape_string($cfg->con, $_POST['uponame']);
$gender = mysqli_escape_string($cfg->con, $_POST['upgender']);
$form = mysqli_escape_string($cfg->con, $_POST['upform']);
$ayear = mysqli_escape_string($cfg->con, $_POST['upayear']);
$dept = mysqli_escape_string($cfg->con, $_POST['upprog']);
$class = mysqli_escape_string($cfg->con, $_POST['upclass']);
$dob = mysqli_escape_string($cfg->con, $_POST['updob']);
$house = mysqli_escape_string($cfg->con, $_POST['uphouse']);
$lschool = mysqli_escape_string($cfg->con, $_POST['uplsch']);
$ffname = mysqli_escape_string($cfg->con, $_POST['upffname']);
$fhometown = mysqli_escape_string($cfg->con, $_POST['upfhometown']);
$ftel = mysqli_escape_string($cfg->con, $_POST['upftel']);
$mname = mysqli_escape_string($cfg->con, $_POST['upmname']);
$mhometown = mysqli_escape_string($cfg->con, $_POST['upmhometown']);
$mtel = mysqli_escape_string($cfg->con, $_POST['upmtel']);
$photo = mysqli_escape_string($cfg->con, $_POST['picpath']);
$id = mysqli_escape_string($cfg->con, $_POST['upid']);
$index = mysqli_escape_string($cfg->con, $_POST['upindex']);
$resstatus = mysqli_escape_string($cfg->con, $_POST['resstatus']);
if (!$photo) {
    mysqli_query($cfg->con, "update stuinfo set fname='$fname',lname='$lname',oname='$oname',gender='$gender',ayear='$ayear',form='$form',class='$class',dept='$dept',house='$house',dob='$dob',lschool='$lschool',ffname='$ffname',fhometown='$fhometown',ftel='$ftel',mfname='$mname',mhometown='$mhometown',mtel='$mtel',jhsno='$jhsno',shsno='$shsno', res_status = '$resstatus' where id = '$id'");
    echo "Student's Info. Updated";
    $ut = new utitlity();
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
        $ut = new utitlity();
        session_start();
        $ut->uid = isset($_SESSION['id']) ?  $_SESSION['id'] : $_SESSION['ad_id'];
        $ut->action = "Edited the profile of  $fname $lname";
        $ut->create_log();
    } else {
        echo 'Could not move photo, please check and try again';
    }
}




