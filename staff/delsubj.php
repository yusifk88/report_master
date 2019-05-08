<?php
include_once './objts/config.php';
include_once './objts/subjects.php';
$cn = new config();
$cn->connect();
$id= $_GET['id'];
mysqli_query("delete from subas where subid = '$id'");

$sbject = new Subjects();
$sbject->delsubject($id);
