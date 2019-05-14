<?php

include_once './objts/config.php';
include_once './objts/subjects.php';

$subjt = new Subjects();
$id = $_GET['id'];
$name = $_GET['name'];
$type = $_GET['type'];
$res = $subjt->update_subject($id, $name, $type);
echo $res;