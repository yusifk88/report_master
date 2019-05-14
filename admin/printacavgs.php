<?php
include_once("objts/config.php");
include_once("objts/school.php");
include_once("objts/utitlity.php");
$cf = new config();
$cf->connect();
$sch = new school();
$util = new utitlity();
$cls = $_GET["cls"];
$ayrar = $_GET["ayear"];
$title = $_GET["title"];
$heading = $title ? $title : "Accumulated Averages for " . $ayrar;
$subs1 = mysqli_query($cf->con, "select * from subjects where subjects.type = 'Core Subject' and subjects.subjdesc not like'%ict%'");
$subs2 = mysqli_query($cf->con, "select * from subjects where subjects.type = 'Elective Subject' and subjects.id in (select DISTINCT(subjt) from records where cls = '$cls' )");
$students = mysqli_query($cf->con, "select * from stuinfo where id in(select distinct(stid) from records where cls = '$cls' and acyear = '$ayrar') ORDER BY fname ASC");
?>
<html>
<head>
    <title>Accumulated Averages</title>
    <link href='css/bootstrap-print.css' rel='stylesheet'/>
    <style type="text/css">
        table, th, tr, td {
            border: 1px solid #000 !important;
        }

        #main_head {
            font-size: 28px;
            font-weight: bold;
        }

        #sub_head {
            font-size: 20px;
            font-weight: bold;
        }

        @media print {
            table, th, tr, td {
                border: 1px solid #000 !important;
            }
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row" style="border-bottom: 1px solid #000; margin-bottom: 5px;">
        <center>
            <h3><?= strtoupper($sch->schname) ?></h3>
            <h5><?= strtoupper($sch->schooladdress) ?></h5>
            <h4><?= strtoupper($heading) ?></h4>
        </center>
    </div>

    <table class="table table-striped table-condensed">
        <thead>
        <tr>
            <th>S/N</th>
            <th>Name</th>
            <?php
            while ($s1 = mysqli_fetch_object($subs1)) {
                ?>
                <th><?= $s1->subjdesc ?></th>
                <?php
            }
            while ($s2 = mysqli_fetch_object($subs2)) {
                ?>
                <th><?= $s2->subjdesc ?></th>
                <?php
            }
            ?>
        </tr>
        </thead>
        <tbody>
        <?php
        $i = 1;
        while ($strow = mysqli_fetch_object($students)) {
            ?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $strow->fname . " " . $strow->lname . " " . $strow->oname ?></td>
                <?php
                $subs1 = mysqli_query($cf->con, "select * from subjects where subjects.type = 'Core Subject' and subjects.subjdesc not like'%ict%'");
                $subs2 = mysqli_query($cf->con, "select * from subjects where subjects.type = 'Elective Subject' and subjects.id in (select DISTINCT(subjt) from records where cls = '$cls' )");
                while ($rec1 = mysqli_fetch_object($subs1)) {
                    $smtotl = mysqli_fetch_object(mysqli_query($cf->con, "select sum((subtotl*$sch->clscore_ratio)/$sch->sba+(exam*($sch->exam_ratio/100))) as sm from records where stid = '$strow->id' and subjt = '$rec1->id' and acyear = '$ayrar' "))->sm;
                    $cntotl = mysqli_fetch_object(mysqli_query($cf->con, "select count(id) as cn from records where stid = '$strow->id' and subjt = '$rec1->id' "))->cn;
                    $avg = ($cntotl == 0) ? 0 : ($smtotl / 2);
                    ?>
                    <td><?= number_format($avg, 2) ?></td>
                    <?php
                }
                while ($rec2 = mysqli_fetch_object($subs2)) {
                    $smtotl = mysqli_fetch_object(mysqli_query($cf->con, "select sum((subtotl*$sch->clscore_ratio)/$sch->sba+(exam*($sch->exam_ratio/100))) as sm from records where stid = '$strow->id' and subjt = '$rec2->id' and acyear = '$ayrar' "))->sm;
                    $cntotl = mysqli_fetch_object(mysqli_query($cf->con, "select count(id) as cn from records where stid = '$strow->id' and subjt = '$rec2->id' "))->cn;
                    $avg = ($cntotl == 0) ? 0 : ($smtotl / 3);
                    ?>
                    <td><?= number_format($avg, 2) ?></td>
                    <?php
                }
                ?>
            </tr>
            <?php
            $i++;
        }
        ?>
        </tbody>
    </table>
    <span class="hidden-print">Averages are calculated by dividing the sum of the total scores on every subject by 2 as a student is supposed to do 2 Semesters in a year</span>
</div>
</body>
</html>