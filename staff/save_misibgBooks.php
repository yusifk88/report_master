<?php
include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$bid = $_POST['id'];
$mssing = mysqli_escape_string($cf->con, $_POST['misingnum']);
mysqli_query($cf->con, "update books set nummising = '$mssing' where id = '$bid' and copies > '$mssing'");
