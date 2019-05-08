<?php
include_once './objts/config.php';
include_once './objts/school.php';
$cg = new config();
$cg->connect();
$exam = $_POST['examval'];
$stud = $_POST['stud'];
$term = $_GET['term'];
$ayear = $_GET['ayear'];
$sub = $_GET['sub'];
$cls = $_GET['cls'];
for ($i = 0; $i < count($stud); $i++) {
    if ($exam[$i] > 0) {
        $n = mysqli_fetch_object(mysqli_query($cg->con,"select count(*) as cn from records where stid = '$stud[$i]' and term='$term' and acyear='$ayear' and subjt='$sub'and cls='$cls'"))->cn;
        if($n<1){
            mysqli_query($cg->con,"insert into records(stid,subjt,term,acyear,cls,exam) values('$stud[$i]','$sub','$term','$ayear','$cls','$exam[$i]')");
            echo"Records Saved";
        }else{
             mysqli_query($cg->con,"update records set exam='$exam[$i]' where stid='$stud[$i]' and term='$term' and acyear='$ayear' and subjt='$sub'and cls='$cls'");

        echo"Records Saved";
        }
    }
}

