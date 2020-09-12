<?php
include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$id = $_GET['id'];
mysqli_query("update staff set status = 'active' where id = '$id'");
