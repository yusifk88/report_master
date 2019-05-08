<?php
include_once './objts/config.php';
$cfg = new config();
$cfg->connect();
$id = $_GET['id'];
mysqli_query($cfg->con,"delete from shm where stfid = '$id'");