<?php

include_once './objts/config.php';
include_once './objts/house.php';

$hse = new House();
$name = $_GET['name'];
$des = $_GET['des'];
$id=$_GET['id'];
$res = $hse->update_houses($id,$name,$des);
echo $res;