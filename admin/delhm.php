<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\config;

$cfg = new config();
$cfg->connect();

$id = $_GET['id'];
mysqli_query($cfg->con, "delete from housem where id = '$id'");