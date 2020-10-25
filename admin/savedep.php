<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\config;
use APP\Department;

$cf = new config();
$cf->connect();
$dept = new Department();
$depname = mysqli_escape_string($cf->con, $_GET['depname']);

$dept->depname = $depname;
$dept->entrydate = date("Y-m-d");

$res = $dept->createdept();
echo $res;

        