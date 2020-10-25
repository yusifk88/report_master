<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\Students;

$sub = new Subjects();
$subname = $_GET['subname'];
$subtype = $_GET['type'];
$sub->subdescrip = $subname;
$sub->type = $subtype;
$res = $sub->createsubjects();
echo $res;
