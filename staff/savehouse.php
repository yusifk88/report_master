<?php

include_once './objts/config.php';
include_once './objts/house.php';

$hse = new House();
$name = $_GET['name'];
$des = $_GET['des'];
$hse->house_des = $des;
$hse->house_name = $name;

$res = $hse->createhouse();
echo $res;