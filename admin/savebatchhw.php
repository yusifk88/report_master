<?php
include_once './objts/config.php';
include_once './objts/school.php';
$cg = new config();
$cg->connect();
$hw1 = $_POST['hw1'];
$hw2 = $_POST['hw2'];
$hw3 = $_POST['hw3'];
$hw4 = $_POST['hw4'];
$stud = $_POST['stud'];
$term = $_GET['term'];
$ayear = $_GET['ayear'];
$sub = $_GET['sub'];
$cls = $_GET['clas'];
$totl = 0;
for ($i = 0; $i < count($stud); $i++) {
    $totl = ($hw1[$i] + $hw2[$i] + $hw3[$i] + $hw4[$i]);
    if ($totl > 0 && $totl<=40) {
        $n = mysqli_fetch_object(mysqli_query($cg->con, "select count(*) as cn from records where stid = '$stud[$i]' and term='$term' and acyear='$ayear' and subjt='$sub'and cls='$cls'"))->cn;
        if ($n < 1) {
            mysqli_query($cg->con, "insert into records(stid,hw1,hw2,hw3,hw4,subjt,term,acyear,cls,subtotl) values('$stud[$i]','$hw1[$i]','$hw2[$i]','$hw3[$i]','$hw4[$i]','$sub','$term','$ayear','$cls','$totl')");

            echo "Records Saved";
        } else {
            $n2 = mysqli_fetch_object(mysqli_query($cg->con, "select count(*) as cn from records where stid = '$stud[$i]' and term='$term' and acyear='$ayear' and subjt='$sub'and cls='$cls' and hw1 is not null and hw2 is not null and hw3 is not null and hw4 is not null"))->cn;
            if ($n2 < 1) {

                mysqli_query($cg->con, "update records set hw1='$hw1[$i]',hw2='$hw2[$i]',hw3='$hw3[$i]',hw4='$hw4[$i]',subtotl=subtotl+$totl where stid='$stud[$i]' and term='$term' and acyear='$ayear' and subjt='$sub'and cls='$cls'");
                echo "Records Saved";
            }

        }


    }
}

