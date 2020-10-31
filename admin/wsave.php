<?php

require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\config;

$cf = new config();
$cf->connect();

$id = $_POST['wstid'];
$ayear = $_POST['wayear'];
$reason = $_POST['wresn'];
$term = $_POST['wterm'];
$dentry = $_POST['wdate'];
if (!\APP\Students::isWithdrawn($id)){

mysqli_query($cf->con, "insert into ginfo(stid,term,ayear,coment,dentry) VALUES ('$id','$term','$ayear','$reason','$dentry')");

mysqli_query($cf->con, "insert into withdraw(stid,wdate) VALUES ('$id','$dentry')");

}