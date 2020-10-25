<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\Staff;
use APP\config;

$id = $_GET['id'];
$stf = new Staff();
$d = $stf->deletestaff($id);
echo $d;
