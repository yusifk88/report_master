<?php

include_once './objts/config.php';
$cnfg = new config();
$cnfg->connect();

$sfid = $_GET['sfid'];
$subid = $_GET['subid'];
$clsid = $_GET['clsid'];

if(mysqli_num_rows(mysqli_query($cnfg->con,"select * from subas where subid = ".$subid." and clid = ".$clsid))>0){
    echo"This subject along with this class was already assigned";
    
    
}else{
    
    mysqli_query($cnfg->con,"insert into subas(subid,stfid,clid) values('$subid','$sfid','$clsid')");
    echo"subject assigned successfully";
    
}