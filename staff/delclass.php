<?php
include_once './objts/config.php';
include_once './objts/rclass.php';

$id = $_GET['id'];
$cls = new Rclass();
$rs = $cls->delclass($id);
echo $rs;
