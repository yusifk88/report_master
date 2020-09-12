<?php
/**
 * Created by PhpStorm.
 * User: Godson
 * Date: 4/22/2019
 * Time: 1:09 AM
 */
include_once '../admin/objts/config.php';
$cf = new config();
$cf->connect();
session_start();
$id = $_SESSION['id'];
$due = mysqli_fetch_object(mysqli_query($cf->con, "select count(id) as cn from exiat WHERE  exiat.stfid = '$id' and returned = 0 and return_date < NOW()"))->cn;

header("content-type:application/JSON");

echo ('{"value" : "'.$due.'"}');
