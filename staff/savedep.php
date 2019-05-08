<?php
include_once './objts/config.php';
include_once './objts/department.php';
$dept = new Department();
$depname = mysql_escape_string($_GET['depname']);

$dept->depname = $depname;
$dept->entrydate= date("Y-m-d");

$res=$dept->createdept();
echo $res;

        