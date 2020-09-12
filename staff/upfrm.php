<?php
include_once './objts/config.php';
$cf = new config();
$cf->connect();
$id = $_GET['id'];
$attndance = $_GET['attndance'];
$attended = $_GET['attnded'];
$interest = $_GET['interest'];
$cnduct = $_GET['cnduct'];
$remark = $_GET['remark'];
$ayear = $_GET['ayear'];
$term = $_GET['term'];
mysqli_query($cf->con, "update frmass set attdance = '$attndance' WHERE  term ='$term' and ayear = '$ayear'");

mysqli_query($cf->con, "update frmass set attnded = '$attended',cnduct = '$cnduct',interest = '$interest',remark='$remark' where id = '$id'");
echo "Record updated successfully";


