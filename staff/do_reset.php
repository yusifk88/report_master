<?php
include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$id = $_GET['id'];
$pass = md5($_GET['new_pass']);


mysqli_query($cf->con,"update staff set upass = '$pass' where id = '$id'");


