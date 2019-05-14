<?php

include_once './objts/config.php';
include_once './objts/department.php';
$dep = new Department();
$id = $_GET['id'];
$dname = $_GET['depname'];

$d = $dep->updatedept($id, $dname);
echo $d;