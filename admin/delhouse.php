<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\House;
use APP\config;


$hse = new House();
$id = $_GET['id'];
$hse->delhouse($id);

