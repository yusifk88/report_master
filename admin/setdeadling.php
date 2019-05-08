<?php
include_once 'objts/config.php';
include_once './objts/utitlity.php';
$ut = new utitlity();

$cf = new config();
$cf->connect();

$status = $_POST['status'];
$ddate = $_POST['ddate'];


mysqli_query($cf->con,"update deadline set status = '$status', ddate = '$ddate'");