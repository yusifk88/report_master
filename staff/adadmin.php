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

mysqli_query("insert into staff(fname,lname,gender,contact,uname,upass,user_type,status) values('$fname','$lname','$gender','$cont','$uname','$upass','admin','active')");
echo 'Admin account created successfully';