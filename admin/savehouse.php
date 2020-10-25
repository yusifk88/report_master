<?php

require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\House;

$hse = new House();
$name = $_GET['name'];
$des = $_GET['des'];
$type = $_GET['htype'];
$hse->house_des = $des;
$hse->house_name = $name;
$hse->housetype = $type;
$res = $hse->createhouse();
echo $res;