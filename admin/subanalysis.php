<?php
include("check_session.php");
include_once("objts/config.php");
include_once("objts/school.php");
$cf = new config();
$cf->connect();
$sch = new school();
$grade_val = array(
    "A1" => 1,
    "B2" => 2,
    "B3" => 3,
    "C4" => 4,
    "C5" => 5,
    "C6" => 6,
    "D7" => 7,
    "E8" => 8,
    "F9" => 9,
    "WH" => 0,
    "CNL" => 9
);
$grades = ["A1", "B2", "B3", "C4", "C5", "C6", "D7", "E8", "F9", "CNL"];
$ayear = $_GET['ayear'];
$subs = mysqli_query($cf->con, "select * from subjects where subjdesc not LIKE '%ICT%' and subjdesc not like '%physical education%' and subjdesc not like '%pe%' and subjdesc not LIKE '%PE%' and subjdesc not like '%I.C.T%' and subjdesc not LIKE '%P.E%'");
function best_range()
{
    $ayear = $_GET['ayear'];
    $cf = new config();
    $cf->connect();
    $studs = mysqli_query($cf->con, "select * from stuinfo where form = '3' and ayear = '$ayear'");
    $count = 0;
    while ($grow = mysqli_fetch_object($studs)) {
        $stid = $grow->id;
        $core = mysqli_fetch_object(mysqli_query($cf->con, "select sum(grade_val) as sm from waec where stid = '$stid' and subid in (SELECT id from subjects where type = 'Core Subject' and subjdesc not LIKE '%social studies%' and subjdesc not LIKE '%PE%' and subjdesc not LIKE '%P.E%' and subjdesc not LIKE '%physical education%' and subjdesc not LIKE '%ict%' and subjdesc not LIKE '%I.C.T%')"))->sm;
        $elec = mysqli_query($cf->con, "select grade_val from waec where stid = '$stid' and subid in (SELECT id from subjects where type = 'Elective Subject') ORDER  by grade_val ASC ");
        $elec_val = 0;
        $i = 1;
        while ($val = mysqli_fetch_object($elec)) {
            if ($i < 4) {
                $elec_val += $val->grade_val;
            }
            $i++;
        }
        $grade = $core + $elec_val;
        if ($grade >= 6 && $grade <= 24) {

            $count++;


        }

    }

    return $count;
}

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
            font-size: 13px;
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
            <h4>DETAILED GRADES OBTAINED BY STUDENTS IN VARIOUS SUBJECTS TAKEN</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <table class="table table-striped table-condensed text-center table-hover">
                <thead>
                <tr>
                    <th rowspan="2">S/N</th>
                    <th rowspan="2">SUBJECT</th>
                    <th rowspan="2">NO. OF CAND.</th>
                    <th colspan="2">A1</th>
                    <th colspan="2">B2</th>
                    <th colspan="2">B3</th>
                    <th colspan="2">C4</th>
                    <th colspan="2">C5</th>
                    <th colspan="2">C6</th>
                    <th colspan="2">D7</th>
                    <th colspan="2">E8</th>
                    <th colspan="2">F9</th>
                    <th colspan="2">CANCELED</th>
                    <th colspan="3">NO. PASSED</th>
                    <th rowspan="2">PERCENTAGE <br> PASSED(%)</th>
                </tr>
                <tr>
                    <th>
                        B
                    </th>
                    <th>
                        G
                    </th>

                    <th>
                        B
                    </th>
                    <th>
                        G
                    </th>

                    <th>
                        B
                    </th>
                    <th>
                        G
                    </th>

                    <th>
                        B
                    </th>
                    <th>
                        G
                    </th>

                    <th>
                        B
                    </th>
                    <th>
                        G
                    </th>

                    <th>
                        B
                    </th>
                    <th>
                        G
                    </th>

                    <th>
                        B
                    </th>
                    <th>
                        G
                    </th>

                    <th>
                        B
                    </th>
                    <th>
                        G
                    </th>

                    <th>
                        B
                    </th>
                    <th>
                        G
                    </th>

                    <th>
                        B
                    </th>
                    <th>
                        G
                    </th>
                    <th>
                        B
                    </th>
                    <th>
                        G
                    </th>
                    <th>TOTAL</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 1;
                $totlcan = 0;
                $totalpass = 0;
                while ($row = mysqli_fetch_object($subs)) {
                    ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $row->subjdesc ?></td>
                        <?php
                        $nocand = mysqli_fetch_object(mysqli_query($cf->con, "select count(*) as cn from waec where subid = '$row->id' and stid in(SELECT  id from stuinfo where ayear='$ayear' and form = '3')"))->cn;
                        $totlcan += $nocand;
                        ?>
                        <td><?= $nocand ?></td>
                        <?php
                        for ($x = 0; $x < count($grades); $x++) {
                            $gr = $grades[$x];
                            $num1 = mysqli_fetch_object(mysqli_query($cf->con, "select count(*) as cn from waec where subid = '$row->id' and grade = '$gr' and stid in (SELECT id from stuinfo where ayear = '$ayear' and form = '3' and gender = 'Male')"))->cn;
                            $num2 = mysqli_fetch_object(mysqli_query($cf->con, "select count(*) as cn from waec where subid = '$row->id' and grade = '$gr' and stid in (SELECT id from stuinfo where ayear = '$ayear' and form = '3' and gender = 'Female')"))->cn;
                            ?>
                            <td><?= $num1 ?></td>
                            <td><?= $num2 ?></td>
                            <?php
                        }
                        $nopass1 = mysqli_fetch_object(mysqli_query($cf->con, "select count(*) as cn from waec where subid = '$row->id' and grade_val < 9 and stid in (SELECT id from stuinfo where ayear = '$ayear' and form = '3' and gender = 'Male') "))->cn;
                        $nopass2 = mysqli_fetch_object(mysqli_query($cf->con, "select count(*) as cn from waec where subid = '$row->id' and grade_val < 9 and stid in (SELECT id from stuinfo where ayear = '$ayear' and form = '3' and gender = 'Female') "))->cn;
                        $nopass = $nopass1 + $nopass2;
                        $totalpass += $nopass;
                        $percent = ($nocand == 0) ? 0 : ($nopass / $nocand) * 100;
                        ?>
                        <td><?= $nopass1 ?></td>
                        <td><?= $nopass2 ?></td>
                        <td><?= $nopass ?></td>
                        <td><?= number_format($percent, 1) ?>%</td>
                    </tr>
                    <?php
                    $i++;
                }
                $totalpercent = ($totlcan == 0) ? 0 : ($totalpass / $totlcan) * 100;
                $testud = mysqli_query($cf->con, "select * from stuinfo where ayear = '$ayear' and form = '3' and gender = 'Male' and id in(SELECT stid from waec)");
                $testud1 = mysqli_query($cf->con, "select * from stuinfo where ayear = '$ayear' and form = '3' and gender = 'Female' and id in(SELECT stid from waec)");
                $p8 = 0;
                $p7 = 0;
                $p6 = 0;
                $p5 = 0;
                $p4 = 0;
                $p3 = 0;
                $p2 = 0;
                $p1 = 0;
                $p0 = 0;
                $pg8 = 0;
                $pg7 = 0;
                $pg6 = 0;
                $pg5 = 0;
                $pg4 = 0;
                $pg3 = 0;
                $pg2 = 0;
                $pg1 = 0;
                $pg0 = 0;
                while ($testrow = mysqli_fetch_object($testud)) {
                    $stid = $testrow->id;
                    $cnt = mysqli_fetch_object(mysqli_query($cf->con, "select count(*) as cn from waec where grade_val <=8 and grade_val >0 and stid='$stid' "))->cn;
                    if ($cnt == 8) {
                        $p8++;
                    } else if ($cnt == 7) {
                        $p7++;
                    } else if ($cnt == 6) {
                        $p6++;
                    } else if ($cnt == 5) {
                        $p5++;
                    } else if ($cnt == 4) {
                        $p4++;
                    } elseif ($cnt == 3) {
                        $p3++;
                    } elseif ($cnt == 2) {
                        $p2++;
                    } elseif ($cnt == 1) {
                        $p1++;
                    } elseif ($cnt == 0) {
                        $p0++;
                    }
                }
                while ($testrow1 = mysqli_fetch_object($testud1)) {
                    $stid1 = $testrow1->id;
                    $cnt1 = mysqli_fetch_object(mysqli_query($cf->con, "select count(*) as cn from waec where grade_val <=8 and grade_val >0 and stid='$stid1' "))->cn;
                    if ($cnt1 == 8) {
                        $pg8++;
                    } else if ($cnt1 == 7) {
                        $pg7++;
                    } else if ($cnt1 == 6) {
                        $pg6++;
                    } else if ($cnt1 == 5) {
                        $pg5++;
                    } else if ($cnt1 == 4) {
                        $pg4++;
                    } elseif ($cnt1 == 3) {
                        $pg3++;
                    } elseif ($cnt1 == 2) {
                        $pg2++;
                    } elseif ($cnt1 == 1) {
                        $pg1++;
                    } elseif ($cnt1 == 0) {
                        $pg0++;
                    }
                }
                $allcan = mysqli_fetch_object(mysqli_query($cf->con, "select count(*) as cn from stuinfo where ayear = '$ayear' and form = '3' and id in(SELECT stid from waec)"))->cn;
                $absent = mysqli_fetch_object(mysqli_query($cf->con, "select count(*) as cn from stuinfo where ayear = '$ayear' and form = '3' and gender ='Male' and id not in (SELECT stid from waec)"))->cn;
                $absent1 = mysqli_fetch_object(mysqli_query($cf->con, "select count(*) as cn from stuinfo where ayear = '$ayear' and form = '3' and gender ='Female' and id not in (SELECT stid from waec)"))->cn;
                $rawtotls = mysqli_fetch_object(mysqli_query($cf->con, "select count(*) as cn from stuinfo where ayear = '$ayear' and form = '3'"))->cn;
                $best_grade_querry1 = mysqli_query($cf->con, "select id,gender,(select sum(grade_val) from waec where waec.stid = stuinfo.id and subid in (SELECT id from subjects where subjdesc not LIKE '%social studies%' and subjdesc not LIKE '%PE%' and subjdesc not LIKE '%P.E%' and subjdesc not LIKE '%physical education%' and subjdesc not LIKE '%ict%' and subjdesc not LIKE '%I.C.T%') ) as smg from stuinfo WHERE gender = 'Male' and ayear = '$ayear' and form = '3' and stuinfo.id in( select stid from waec ) ORDER BY smg ASC");
                $best_grade1 = mysqli_fetch_object($best_grade_querry1);
                $maleid = isset($best_grade1) ? $best_grade1->id : 0;
                $core = mysqli_fetch_object(mysqli_query($cf->con, "select sum(grade_val) as sm from waec where stid = '$maleid' and subid in (SELECT id from subjects where type = 'Core Subject' and subjdesc not LIKE '%social studies%' and subjdesc not LIKE '%PE%' and subjdesc not LIKE '%P.E%' and subjdesc not LIKE '%physical education%' and subjdesc not LIKE '%ict%' and subjdesc not LIKE '%I.C.T%')"))->sm;
                $elec = mysqli_query($cf->con, "select grade_val from waec where stid = '$maleid' and subid in (SELECT id from subjects where type = 'Elective Subject') ORDER  by grade_val asc");
                $elec_val = 0;
                $i = 1;
                $allcan = ($allcan == 0) ? 1 : $allcan;
                while ($val = mysqli_fetch_object($elec)) {
                    if ($i < 4) {
                        $elec_val += isset($val->grade_val) ? $val->grade_val : 1;
                    }
                    $i++;
                }
                $grade1 = $core + $elec_val;
                $best_grade_querry2 = mysqli_query($cf->con, "select id,gender,(select sum(grade_val) from waec where waec.stid = stuinfo.id and subid in (SELECT id from subjects where subjdesc not LIKE '%social studies%' and subjdesc not LIKE '%PE%' and subjdesc not LIKE '%P.E%' and subjdesc not LIKE '%physical education%' and subjdesc not LIKE '%ict%' and subjdesc not LIKE '%I.C.T%') ) as smg from stuinfo WHERE gender = 'Female' and ayear = '$ayear' and form = '3' and stuinfo.id in( select stid from waec ) ORDER BY smg ASC");
                $best_grade2 = mysqli_fetch_object($best_grade_querry2);
                $maleid = $best_grade2->id ? $best_grade2->id : 0;
                $core = mysqli_fetch_object(mysqli_query($cf->con, "select sum(grade_val) as sm from waec where stid = '$maleid' and subid in (SELECT id from subjects where type = 'Core Subject' and subjdesc not LIKE '%social studies%' and subjdesc not LIKE '%PE%' and subjdesc not LIKE '%P.E%' and subjdesc not LIKE '%physical education%' and subjdesc not LIKE '%ict%' and subjdesc not LIKE '%I.C.T%')"))->sm;
                $elec = mysqli_query($cf->con, "select grade_val from waec where stid = '$maleid' and subid in (SELECT id from subjects where type = 'Elective Subject') ORDER  by grade_val asc");
                $elec_val = 0;
                $i = 1;
                while ($val = mysqli_fetch_object($elec)) {
                    if ($i < 4) {
                        $elec_val += isset($val->grade_val) ? $val->grade_val : 1;
                    }
                    $i++;
                }
                $grade2 = $core + $elec_val;
                ?>
                <tr>
                    <th colspan="26">
                        OVERALL TOTAL PERCENTAGE PASSED
                    </th>
                    <th><?= number_format($totalpercent, 1) ?>%</th>
                </tr>
                <tr>
                    <th class="text-center" style="vertical-align: middle;">No. and percentage of candidates with
                        aggregates between 6 and 24
                    </th>
                    <td><?= best_range() ?></td>
                    <td><?= number_format((best_range() / $allcan) * 100, 1) ?>%</td>
                </tr>
                <tr>
                    <th rowspan="3" class="text-center" style="vertical-align: middle;">Best Grades</th>
                </tr>
                <tr>
                    <th>Boys</th>
                    <td><?= $grade1 ?></td>
                </tr>
                <tr>
                    <th>Girls</th>
                    <td><?= $grade2 ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row" style="page-break-before: always;">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <table class="table table-condensed table-striped">
                <tr>
                    <th colspan="5">SUMMARY OF RESULTS</th>
                </tr>
                <tr>
                    <th rowspan="2">NUMBER OF PASSES</th>
                    <th colspan="3">VALUE</th>

                    <th rowspan="2">PERCENTAGE</th>
                </tr>
                <tr>
                    <th>
                        BOYS
                    </th>

                    <th>
                        GIRLS
                    </th>
                    <th>TOTAL</th>
                </tr>

                <tr>
                    <td>8 PASSES</td>
                    <td><?= $p8 ?></td>
                    <td><?= $pg8 ?></td>
                    <td><?= $pg8 + $p8 ?></td>
                    <td><?= number_format((($pg8 + $p8) / $allcan) * 100, 1) ?>%</td>
                </tr>

                <tr>
                    <td>7 PASSES</td>
                    <td><?= $p7 ?></td>
                    <td><?= $pg7 ?></td>
                    <td><?= $pg7 + $p7 ?></td>
                    <td><?= number_format((($pg7 + $p7) / $allcan) * 100, 1) ?>%</td>
                </tr>

                <tr>
                    <td>6 PASSES</td>
                    <td><?= $p6 ?></td>
                    <td><?= $pg6 ?></td>
                    <td><?= $pg6 + $p6 ?></td>
                    <td><?= number_format((($pg6 + $p6) / $allcan) * 100, 1) ?>%</td>

                </tr>
                <tr>
                    <td>5 PASSES</td>
                    <td><?= $p5 ?></td>
                    <td><?= $pg5 ?></td>
                    <td><?= $pg5 + $p5 ?></td>
                    <td><?= number_format((($pg5 + $p5) / $allcan) * 100, 1) ?>%</td>
                </tr>
                <tr>
                    <td>4 PASSES</td>
                    <td><?= $p4 ?></td>
                    <td><?= $pg4 ?></td>
                    <td><?= $pg4 + $p4 ?></td>
                    <td><?= number_format((($pg4 + $p4) / $allcan) * 100, 1) ?>%</td>
                </tr>
                <tr>
                    <td>3 PASSES</td>
                    <td><?= $p3 ?></td>
                    <td><?= $pg3 ?></td>
                    <td><?= $pg3 + $p3 ?></td>
                    <td><?= number_format((($pg3 + $p3) / $allcan) * 100, 1) ?>%</td>
                </tr>
                <tr>
                    <td>2 PASSES</td>
                    <td><?= $p2 ?></td>
                    <td><?= $pg2 ?></td>
                    <td><?= $pg2 + $p2 ?></td>
                    <td><?= number_format((($pg2 + $p2) / $allcan) * 100, 1) ?>%</td>
                </tr>
                <tr>
                    <td>1 PASS</td>
                    <td><?= $p1 ?></td>
                    <td><?= $pg1 ?></td>
                    <td><?= $pg1 + $p1 ?></td>
                    <td><?= number_format((($pg1 + $p1) / $allcan) * 100, 1) ?>%</td>
                </tr>
                <tr>
                    <td>NO PASSES</td>
                    <td><?= $p0 ?></td>
                    <td><?= $pg0 ?></td>
                    <td><?= $pg0 + $p0 ?></td>
                    <td><?= number_format((($pg0 + $p0) / $allcan) * 100, 1) ?>%</td>
                </tr>
                <tr class="text-danger">
                    <th>ABSENT</th>
                    <th><?= $absent ?></th>
                    <th><?= $absent1 ?></th>
                    <th><?= $absent + $absent1 ?></th>
                    <th><?= number_format((($absent + $absent1) / $rawtotls) * 100, 1) ?>% OF TOTAL NUMBER <br> OF
                        CANDIDATES(<?= $rawtotls ?>)
                    </th>
                </tr>
                <tr class="text-success">
                    <th colspan="3">TOTAL NUMBER OF CANDIDATES</th>
                    <th colspan="2"><?= $rawtotls ?></th>
                </tr>
                <tr class="text-success">
                    <th colspan="3">NUMBER OF CANDIDATES WHO WROTE THE EXAM.</th>
                    <th colspan="2"><?= $allcan ?></th>
                </tr>
            </table>
        </div>
    </div>
    <button class="btn btn-primary hidden-print" onclick="window.print();">Print</button>
</div>
</body>
</html>