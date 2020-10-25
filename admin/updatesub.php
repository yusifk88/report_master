<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\Subjects;


$subjt = new Subjects();
$id = $_GET['id'];
$name = $_GET['name'];
$type = $_GET['type'];
$res = $subjt->update_subject($id, $name, $type);
echo $res;