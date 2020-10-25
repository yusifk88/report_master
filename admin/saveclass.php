<?php

require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\Rclass;

$cname = $_GET['classname'];
$dpid = $_GET['dpid'];

$cls = new Rclass();

$cls->class_name = $cname;
$cls->depid = $dpid;
$rs = $cls->createclass();
\APP\Utitlity::response($rs);
