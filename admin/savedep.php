<?php
include_once './objts/config.php';
include_once './objts/department.php';
$cf = new config();
$cf->connect();
$dept = new Department();
$depname = mysqli_escape_string($cf->con,$_GET['depname']);

$dept->depname = $depname;
$dept->entrydate= date("Y-m-d");

$res=$dept->createdept();
echo $res;

        