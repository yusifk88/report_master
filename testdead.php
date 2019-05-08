<?php
include_once 'admin/objts/config.php';
$cf = new config();
$cf->connect();
$nw = date("Y-m-d");
$teston = mysqli_query($cf->con,"select * from deadline where status = 'ON'");
if(mysqli_num_rows($teston)>0){
    $dead = mysqli_query($cf->con,"select * from deadline  WHERE ddate > '$nw'");
    $dcnt = mysqli_num_rows($dead);
    if ($dcnt > 0){
        header("content-Type:application/JSON");
        echo '{"status":0}';
    }else {
        header("content-Type:application/JSON");
        echo '{"status":1}';
    }

}else{
header("content-Type:application/JSON");
echo '{"status" : 0}';
}