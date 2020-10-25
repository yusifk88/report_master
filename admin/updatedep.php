<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\Department;

$dep = new Department();
$id = $_GET['id'];
$dname = $_GET['depname'];

$d = $dep->updatedept($id, $dname);
echo $d;