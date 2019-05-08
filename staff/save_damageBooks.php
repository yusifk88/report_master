<?php
include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$bid = $_POST['id'];
$damaged = mysqli_escape_string($cf->con,$_POST['damagednum']);
mysqli_query($cf->con,"update books set numdamaged = '$damaged' where id = '$bid' and copies > '$mssing'");