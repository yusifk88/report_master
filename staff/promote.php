<?php
include_once './objts/config.php';
$cf = new config();
$cf->connect();
$prmfrom_class = $_POST['prmfrom_class'];
$prmfrom_form = $_POST['prmfrom_form'];
$prmfrom_ayear = $_POST['prmfrom_ayear'];
$prmto_class = $_POST['prmto_class'];
$prmto_form = $_POST['prmto_form'];
$prmto_ayear = $_POST['prmto_ayear'];
$selects = $_POST['selectchk'];
$selcount = count($selects);


for($i=0; $i<$selcount; $i++){
    $id = $selects[$i];
    mysqli_query("update stuinfo set class = '$prmto_class',form='$prmto_form',ayear='$prmto_ayear' where class = '$prmfrom_class' and form = '$prmfrom_form' and ayear = '$prmfrom_ayear' and id = '$id' ");
    
}
echo 'Promotion Was Successful';
