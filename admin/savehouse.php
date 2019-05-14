<?php

include_once './objts/config.php';
include_once './objts/house.php';

$hse = new House();
$name = $_GET['name'];
$des = $_GET['des'];
$type = $_GET['htype'];
$hse->house_des = $des;
$hse->house_name = $name;
$hse->housetype = $type;
$res = $hse->createhouse();
echo $res;