<?php
include_once './objts/config.php';
include_once './objts/subjects.php';

$sub = new Subjects();
$subname = $_GET['subname'];
$subtype = $_GET['type'];
$sub->subdescrip=$subname;
$sub->type=$subtype;
$res = $sub->createsubjects();
echo $res;
