<?php
include_once("objts/config.php");
$cf = new config();
$cf->connect();
$grade_val = array(
    "A1"=>1,
    "B2"=>2,
    "B3"=>3,
    "C4"=>4,
    "C5"=>4,
    "C6"=>4,
    "D7"=>5,
    "E8"=>5,
    "F9"=>7,
    "WH"=>0,
    "CNL"=>7
);

$stid = $_POST['stid'];
$sub = $_POST['sub'];
$grade = $_POST['grade'];
$sub2 = $_POST['sub2'];
$grade2 = $_POST['grade2'];
for($i=0;$i<count($sub); $i++){

    $s = $sub[$i];
    $g = $grade[$i];
    $val = $grade_val[$g];
    if($g!="None"){
    mysqli_query($cf->con,"insert into waec(subid,stid,grade,grade_val) VALUES ('$s','$stid','$g','$val')");
}
}
for($x=0;$x<count($sub2); $x++){

    $s2 = $sub2[$x];
    $g2 = $grade2[$x];
    $val = $grade_val[$g2];
    if($g2!="None"){
    mysqli_query($cf->con,"insert into waec(subid,stid,grade,grade_val) VALUES ('$s2','$stid','$g2','$val')");
}}




