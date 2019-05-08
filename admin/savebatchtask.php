<?php
include_once './objts/config.php';
include_once './objts/school.php';
$cg = new config();
$cg->connect();

$task1 = $_POST['task1'];
$task2 = $_POST['task2'];
$task3 = $_POST['task3'];
$task4 = $_POST['task4'];
$stids = $_POST['stud'];
$cls = $_GET['cls'];
$term = $_GET['term'];
$ayear = $_GET['ayear'];
$sub = $_GET['sub'];
$sumtask =0;
    for ($i = 0; $i < count($stids); $i++) {
        $sumtask = ($task1[$i] + $task2[$i] + $task3[$i] + $task4[$i]);
        if ($sumtask > 0) {
            $n = mysqli_fetch_object(mysqli_query($cg->con, "select count(*) as cn from records where stid = '$stids[$i]' and term='$term' and acyear='$ayear' and subjt='$sub'and cls='$cls'"))->cn;
            if ($n < 1) {
                mysqli_query($cg->con, "insert into records(stid,ta1,ta2,ta3,ta4,subjt,term,acyear,cls,subtotl) values('$stids[$i]','$task1[$i]','$task2[$i]','$task3[$i]','$task4[$i]','$sub','$term','$ayear','$cls','$sumtask')");
                echo "Records Saved";
            } else {
                $n2 = mysqli_fetch_object(mysqli_query($cg->con, "select count(*) as cn from records where stid = '$stids[$i]' and term='$term' and acyear='$ayear' and subjt='$sub'and cls='$cls' and ta1 is not null and ta2 is not null and ta3 is not null and ta4 is not null"))->cn;
                if ($n2 > 0) {
                    echo 'This record already exist, go to the view assessment records page if you want to modify this record';
                } else {
                    mysqli_query($cg->con, "update records set ta1='$task1[$i]',ta2='$task2[$i]',ta3='$task3[$i]',ta4='$task4[$i]',subtotl=subtotl+$sumtask where stid='$stids[$i]' and term='$term' and acyear='$ayear' and subjt='$sub'and cls='$cls'");
                    echo "Records Saved";
                }


            }


        }
    }





