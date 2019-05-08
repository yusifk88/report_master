<?php
include_once './objts/config.php';
$cfg = new config();
$cfg->connect();

$id = $_GET['id'];
mysqli_query($cfg->con,"delete from housem where id = '$id'");