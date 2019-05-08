<?php
include_once './objts/config.php';
include_once './objts/school.php';
$cg = new config();
$cg->connect();
$pw1 = $_POST['pw1'];
$pw2 = $_POST['pw2'];
$stud = $_POST['stud'];
$term = $_GET['term'];
$ayear = $_GET['ayear'];
$sub = $_GET['sub'];
$cls = $_GET['cls'];
$totl =0;
for ($i = 0; $i < count($stud); $i++) {
    $totl = ($pw1[$i] + $pw2[$i]);
    if ($totl > 0) {
        $n = mysqli_fetch_object(mysqli_query($cg->con,"select count(*) as cn from records where stid = '$stud[$i]' and term='$term' and acyear='$ayear' and subjt='$sub'and cls='$cls'"))->cn;
        if($n<1){
            mysqli_query($cg->con,"insert into records(stid,pw1,pw2,subjt,term,acyear,cls,subtotl) values('$stud[$i]','$pw1[$i]','$pw2[$i]','$sub','$term','$ayear','$cls','$totl')");

            echo"Records Saved";
        }  else {
              mysqli_query($cg->con,"update records set pw1='$pw1[$i]',pw2='$pw2[$i]',subtotl=subtotl+$totl where stid='$stud[$i]' and term='$term' and acyear='$ayear' and subjt='$sub'and cls='$cls'");

                echo"Records Saved";


            }


        }





}

