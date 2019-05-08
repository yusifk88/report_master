<?php
include_once("../admin/objts/config.php");
$cf = new config();
$cf->connect();
$id = $_GET['stfid'];
$sublist = mysqli_query($cf->con,"select subas.*,subjects.subjdesc,classes.classname from subas,subjects,classes where subas.stfid = '$id' and subas.clid = classes.id and subas.subid = subjects.id");
$JSON_list = array();
while($row = mysqli_fetch_object($sublist)){
    $JSON_list[] = $row;


}



header("content-type:application/JSON");
echo(json_encode($JSON_list));