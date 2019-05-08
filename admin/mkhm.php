<?php
include_once("objts/config.php");
$cf = new config();
$cf->connect();

$stfid = $_POST['stfid'];
$house = $_POST['house'];
mysqli_query($cf->con,"insert into housem(stfid,hid) VALUES('$stfid','$house')");
