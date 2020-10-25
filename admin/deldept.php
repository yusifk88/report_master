<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');

use APP\Department;

$dept = new Department();
$id = $_GET['id'];
$d = $dept->delpdpts($id);
echo $d;