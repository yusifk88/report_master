<?php

include_once './objts/config.php';
include_once './objts/staff.php';
$stf = new Staff();
$id = $_GET['id'];
$d = $stf->deletestaff($id);
echo $d;
