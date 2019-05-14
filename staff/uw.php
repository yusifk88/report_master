<?php
include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$id = $_GET['id'];
mysqli_query($cf->con, "delete from withdraw where stid = '$id'");