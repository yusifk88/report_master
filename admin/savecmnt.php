<?php
include_once 'objts/config.php';
$cf = new config();
$cf->connect();


$id = $_POST['id'];
$term = $_POST['term'];
$year = $_POST['ayear'];
$d = $_POST['dentry'];
$cmt = $_POST['cmnt'];
mysqli_query($cf->con,"insert into ginfo(stid,coment,term,ayear,dentry) VALUES ('$id','$cmt','$term','$year','$d')");

