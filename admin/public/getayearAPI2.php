<?php
include_once("../objts/config.php");
$cf = new config();
$cf->connect();
$stlist = array();

$stds = mysqli_query($cf->con,"select DISTINCT(acyear) from records ORDER by acyear DESC ");
while($row = mysqli_fetch_object($stds)){
    $stlist[]=$row;
}

header("content-type:application/json");
header('Access-Control-Allow-Origin: *');
header("access-control-allow-credetials:true");

echo(json_encode($stlist));