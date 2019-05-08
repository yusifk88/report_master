<?php
include_once '../admin/objts/config.php';
$cf = new config();
$cf->connect();
session_start();
$stid = $_GET['stid'];
$cls = $_GET['cls'];
$ayear = $_GET['ayear'];
$term = $_GET['term'];
$attndance = $_GET['attndance'];
$attended = $_GET['attnded'];
 $attitude = "none";
$_SESSION['attendance'] =$attndance;
$interest = $_GET['interest'];
$cnduct = $_GET['cnduct'];
$remark = $_GET['remark'];

$cntfrm = mysqli_fetch_object(mysqli_query($cf->con,"select count(id) as cnt from frmass where stid = '$stid' and term = '$term' and ayear = '$ayear' and cls = '$cls'"))->cnt;
if($cntfrm <1) {
 mysqli_query($cf->con, "insert into frmass(stid,term,ayear,cls,attdance,attnded,cnduct,attitude,interest,remark) VALUES ('$stid','$term','$ayear','$cls','$attndance','$attended','$cnduct','$attitude','$interest','$remark')");
echo("Record saved");

}else{
 echo("This record was already saved, please skip this student");


}
