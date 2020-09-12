<?php
include_once("../admin/objts/config.php");
$cf = new config();
$cf->connect();
$id = $_GET['id'];
$cls = $_GET['cls'];
$sub = $_GET['subjt'];
$test = mysqli_fetch_object(mysqli_query($cf->con, "select subas.*,subjects.subjdesc,classes.classname from subas,subjects,classes  WHERE stfid = '$id' and clid = '$cls' and subid ='$sub' and subjects.id=subas.subid and classes.id = subas.clid"));

header("content-type:application/JSON");
echo(json_encode($test));