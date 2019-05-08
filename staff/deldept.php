<?php
include_once './objts/config.php';
include_once './objts/department.php';
$dept = new Department();
$id = $_GET['id'];
$d = $dept->delpdpts($id);
echo $d;