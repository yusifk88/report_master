<?php

include_once './objts/config.php';
include_once './objts/rclass.php';
$cls = new Rclass();
$id = $_GET['id'];
$dpid = $_GET['dpid'];
$cname = $_GET['classname'];
$res = $cls->update_class($id, $cname, $dpid);
echo $res;