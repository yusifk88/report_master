<?php
include_once 'objts/config.php';
include_once 'objts/utitlity.php';
$cf = new config();
$cf->connect();
$fname = $_GET['fname'];
$lname = $_GET['lname'];
$gender = $_GET['gender'];
$cont = $_GET['cont'];
$uname = $_GET['uname'];
$upass = md5($_GET['upass']);


try {
$exist_uname = mysqli_fetch_object(mysqli_query($cf->con,"select count(*) as sm from staff where uname = '$uname'"))->sm;
if ($exist_uname > 0) {

    utitlity::response('This email was already taken',302);
} else {
    mysqli_query($cf->con,"insert into staff(fname,lname,gender,contact,uname,upass,type,status) values('$fname','$lname','$gender','$cont','$uname','$upass','admin','active')");

    utitlity::response('Admin account created successfully');

}

}catch (Exception $e){

    utitlity::set_response(500);
    throw new Exception($e->getMessage());
}
