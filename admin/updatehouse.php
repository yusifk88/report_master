<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\House;


$hse = new House();
$name = $_GET['name'];
$des = $_GET['des'];
$id = $_GET['id'];
$house_type = $_GET['house_type'];
$res = $hse->update_houses($id, $name, $des, $house_type);
echo $res;