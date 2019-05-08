<?php
include_once("objts/config.php");
$cf = new config();
$id = $_GET['id'];
mysqli_query($cf->con,"delete from stlogin WHERE stindex = '$id'");

