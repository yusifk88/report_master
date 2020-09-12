<?php
include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$fname = $_GET['fname'];
$lname = $_GET['lname'];
$gender = $_GET['gender'];
$cont = $_GET['cont'];
$uname = $_GET['uname'];
$upass = md5($_GET['upass']);

$exist_uname = mysqli_fetch_object(mysqli_query("select count(*) as sm from staff where uname = '$uname'"))->sm;
if ($exist_uname > 0) {

    echo 'This user name aready exist please user a different user name';
} else {
    mysqli_query("insert into staff(fname,lname,gender,contact,uname,upass,user_type,status) values('$fname','$lname','$gender','$cont','$uname','$upass','admin','active')");
    echo 'Admin account created successfully';
}