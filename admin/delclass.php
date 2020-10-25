<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');

use APP\Rclass;

$id = $_GET['id'];
$cls = new Rclass();
$rs = $cls->delclass($id);
echo $rs;
