<?php
include_once '../objts/school.php';
include_once '../objts/config.php';
include_once '../objts/utitlity.php';
$cf = new config();
$cf->connect();
$sch = new school();
$util = new Utitlity();
$stlist = array();
$cls = $_GET['cls'];
$acyear = $_GET['acyear'];
$term = $_GET['term'];
$studs= mysqli_query($cf->con,"select stuinfo.* from stuinfo where stuinfo.id in(SELECT stid from records where records.term = '$term' and records.acyear='$acyear')");
while($row = mysqli_fetch_object($studs)){
    $rep = mysqli_query($cf->con,"select subjects.subjdesc,((subtotl*$sch->clscore_ratio)/$sch->sba+(exam*($sch->exam_ratio/100))) as tscore from records,subjects where acyear = '$acyear' and term = '$term' and stid = '$row->id' and records.subjt = subjects.id");

    $msg = "Dear Sir, here are the results of your ward (".$row->fname." ".$row->lname." ".$row->oname.") for ".$acyear.",".$util->addsufix($term)." term \n";
    while($row2 = mysqli_fetch_object($rep)){
        $msg.=$row2->subjdesc.": ".number_format($row2->tscore,1)." (".$util->getgrd(number_format($row2->tscore,1)).") \n";
    }

    $stlist[]=(object)[
        "stud"=>$row,
        "rep"=>$msg
    ];
}

header("content-type:application/json");
header('Access-Control-Allow-Origin: *');
header("access-control-allow-credetials:true");

echo(json_encode($stlist));



