<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\Rclass;

$cls = new Rclass();
$id = $_GET['id'];
$dpid = $_GET['dpid'];
$cname = $_GET['classname'];
$res = $cls->update_class($id, $cname, $dpid);
echo $res;