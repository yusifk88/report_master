<?php

include_once '../admin/objts/students.php';
include_once '../admin/objts/config.php';
$cf = new config();
$cf->connect();
$id = $_GET['id'];
$stud = new Students();
$msg=$stud->delstudentinfo($id);
mysqli_query($cf->con,"delete from records where stid = '$id'");
mysqli_query($cf->con,"delete from totls where stid = '$id'");





