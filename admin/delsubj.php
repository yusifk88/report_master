<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\config;
use APP\Subjects;

$cn = new config();
$cn->connect();
$id = $_GET['id'];
mysqli_query("delete from subas where subid = '$id'");

$sbject = new Subjects();
$sbject->delsubject($id);
