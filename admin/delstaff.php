<?php
include_once './objts/config.php';
include_once './objts/staff.php';
$id = $_GET['id'];
$stf = new Staff();
$d = $stf->deletestaff($id);
echo $d;
