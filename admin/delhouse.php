<?php
include_once './objts/config.php';
include_once './objts/house.php';

$hse = new House();
$id = $_GET['id'];
$hse->delhouse($id);

