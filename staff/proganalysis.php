<?php
include_once("../admin/objts/config.php");
include_once("../admin/objts/school.php");
$cf = new config();
$cf->connect();
$sch = new school();
$grade_val = array(
    "A1" => 1,
    "B2" => 2,
    "B3" => 2,
    "C4" => 3,
    "C5" => 4,
    "C6" => 4,
    "D7" => 5,
    "E8" => 6,
    "F9" => 7,
    "WH" => 0,
    "CNL" => 7
);
$grades = ["A1", "B2", "B3", "C4", "C5", "C6", "D7", "E8", "F9", "CNL"];
$ayear = $_GET['ayear'];
$prog = $_GET['prog'];
$subs1 = mysqli_query($cf->con, "select * from subjects where type = 'Core Subject' and subjdesc not LIKE '%ICT%' and subjdesc not like '%physical education%' and subjdesc not like '%pe%' and subjdesc not LIKE '%PE%' and subjdesc not like '%I.C.T%' and subjdesc not LIKE '%P.E%'");
$subs2 = mysqli_query($cf->con, "select * from subjects where type = 'Elective Subject' and id in (SELECT subjt from records where stid in(SELECT id from stuinfo where dept = '$prog' and ayear ='$ayear' and form = '3') )");
$studs = mysqli_query($cf->con, "select * from stuinfo where form = '3' and ayear = '$ayear' and dept = '$prog' ORDER BY fname ASC ");
$depname = mysqli_fetch_object(mysqli_query($cf->con, "select depname from dept  WHERE id = '$prog'"))->depname;
?>

<html>
<head>
    <meta charset="UTF-8">
    <link href="../admin/css/bootstrap-print.css" rel="stylesheet" type="text/css"/>
    <style type="text/css">
        table, th, tr, td {
            border: 1px solid #000 !important;
            vertical-align: middle !important;
            text-align: center;
            font-size: 12px;
        }

        @media print {
            table, th, tr, td {
                border: 1px solid #000 !important;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row" style="border-bottom: 1px solid #000; margin-bottom: 5px;">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <h3><?= strtoupper($sch->schname) ?></h3>
            <h5><?= strtoupper($sch->schooladdress) ?></h5>
            <h4>MAY/JUNE <?= $ayear ?> WASSCE RESULTS</h4>
            <h4>DETAILED GRADES OBTAINED BY <?= strtoupper($depname) ?> STUDENTS IN VARIOUS SUBJECTS TAKEN</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <table class="table table-striped table-condensed text-center table-hover">
                <thead>
                <tr>
                    <th>S/N</th>
                    <th>CANDIDATE</th>
                    <?php

                    while ($srow = mysqli_fetch_object($subs1)) {
                        ?>
                        <th><?= $srow->subjdesc ?></th>
                        <?php
                    }
                    while ($srow1 = mysqli_fetch_object($subs2)) {


                        ?>
                        <th><?= $srow1->subjdesc ?></th>
                        <?php

                    }


                    ?>
                </tr>
                </thead>
                <tbody>
                <?php

                $i = 1;
                while ($strow = mysqli_fetch_object($studs)) {
                    $core = mysqli_query($cf->con, "select * from subjects where type = 'Core Subject' and subjdesc not LIKE '%ICT%' and subjdesc not like '%physical education%' and subjdesc not like '%pe%' and subjdesc not LIKE '%PE%' and subjdesc not like '%I.C.T%' and subjdesc not LIKE '%P.E%'");
                    $elec = mysqli_query($cf->con, "select * from subjects where type = 'Elective Subject' and id in (SELECT subjt from records where stid in(SELECT id from stuinfo where dept = '$prog' and ayear ='$ayear' and form = '3') )");

                    ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $strow->fname . " " . $strow->lname . " " . $strow->oname ?></td>
                        <?php
                        while ($srow = mysqli_fetch_object($core)) {
                            $subid = $srow->id;
                            $stid = $strow->id;
                            $rec = mysqli_fetch_object(mysqli_query($cf->con, "select * from waec where subid = '$subid' and stid='$stid'"));
                            ?>
                            <td><?= $rec ? $rec->grade : "-" ?></td>
                            <?php
                        }
                        while ($erow = mysqli_fetch_object($elec)) {
                            $subid2 = $erow->id;
                            $stid2 = $strow->id;
                            $rec2 = mysqli_fetch_object(mysqli_query($cf->con, "select * from waec where subid = '$subid2' and stid='$stid2'"));
                            ?>
                            <td><?= $rec2 ? $rec2->grade : "-" ?></td>
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

        </div>


    </div>
</body>
</html>