<?php

include_once './objts/config.php';
include_once './objts/rclass.php';

$cname = $_GET['classname'];
 $dpid =$_GET['dpid'];
 
$cls = new Rclass();

$cls->class_name= $cname;
$cls->depid=$dpid;
$rs = $cls->createclass();
echo $rs;
