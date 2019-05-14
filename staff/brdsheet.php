<?php
include_once './objts/config.php';
include_once './objts/school.php';
$sch = new school();
$term = $_GET['term'];
$ayear = $_GET['ayear'];
$cls = $_GET['cls'];
//$sub= $_GET['subjt'];

$cg = new config();
$cg->connect();
include_once './objts/utitlity.php';
$util = new Utitlity();
$subs = mysqli_query("select id,subjdesc from subjects where id in (select distinct(subjt) from records where acyear = '$ayear' and term = '$term' and cls = '$cls')");
$classname = mysql_result(mysqli_query("select classname from classes where id = '$cls'"), 0);
$numroll = mysql_result(mysqli_query("select count(*) from records where term ='$term' and acyear = '$ayear' and cls = '$cls'"), 0);
$avge = mysql_result(mysqli_query("select avg(totlscore) from records where term ='$term' and acyear = '$ayear' and cls='$cls'"), 0);
$term_suf = $util->addsufix($term);
?>
<html>
<head>
    <title>Termly assessment Plan</title>
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
<div class='container-fluid'>
    <div class='row'>
        <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
            <center>

                <u><span id='main_head'><?= $sch->schname; ?></span></u> <br/>

                <?= $sch->schooladdress; ?>
                <br/><u><span id='sub_head'>TERMLY ASSESSMENT BROADSHEET</span></u>
            </center>
        </div>
    </div>
    <div class='row'>
        <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
            <table class='table table-striped table-condensed'>
                <thead>

                <tr>
                    <th colspan='2'>CLASS:</th>
                    <td colspan='3'><?= $classname; ?></td>
                    <th colspan='2'>AC. YEAR:</th>
                    <td colspan='2'><?= $ayear; ?></td>
                    <th>TERM:</th>
                    <td colspan="3"><?= $term_suf; ?> Term</td>

                </tr>
                <tr>

                </tr>

                <tr>
                    <th style='text-align:center;'>S/N</th>
                    <th>FULL NAME</th>
                    <?php
                    while ($row = mysqli_fetch_object($subs)) {
                        ?>
                        <th style="text-align: center;">
                            <?= $row->subjdesc; ?>

                        </th>


                        <?php
                    }

                    ?>
                    <th>POS.</th>
                    <th>FAILS</th>
                </tr>
                </thead>
                <tbody>

                <?php
                $studs = mysqli_query("select id,fname,lname,oname from stuinfo where id in (select distinct(stid) from records where term = '$term' and acyear = '$ayear' and cls = '$cls')  order by fname ASC");
                $i = 1;
                while ($studrows = mysqli_fetch_object($studs)) {
                    $stid = $studrows->id;
                    $subs2 = mysqli_query("select id,subjdesc from subjects");

                    ?>


                    <tr>
                        <td style="text-align: center;"><?= $i; ?></td>
                        <td><?= $studrows->fname . ' ' . $studrows->lname . ' ' . $studrows->oname ?></td>
                        <?php
                        while ($row1 = mysqli_fetch_object($subs2)) {
                            $subid = $row1->id;

                            $grds = mysqli_query("select grd from records where stid = '$stid' and subjt = '$subid' and term = '$term' and acyear = '$ayear'");
                            while ($row2 = mysqli_fetch_object($grds)) {


                                if ($row2->grd === 'F9') {

                                    ?>

                                    <td style="text-align: center; background-color: red; color: white;"><?= $row2->grd; ?></td>

                                    <?php
                                } else {

                                    ?>

                                    <td style="text-align: center;"><?= $row2->grd; ?></td>

                                    <?php


                                }


                                ?>


                                <?php
                            }

                        }
                        $overpos = mysql_result(mysqli_query("select post from totls where stid = '$stid' and term = '$term' and ayear = '$ayear'"), 0);

                        $fails = mysql_result(mysqli_query("select count(grd) from records where stid ='$stid' and cls = '$cls' and term = '$term' and acyear ='$ayear' and grd = 'F9'"), 0)
                        ?>
                        <td style="text-align: center;"><?= $overpos; ?></td>
                        <td style="text-align: center;"><?= $fails; ?></td>


                    </tr>
                    <?php

                    $i++;
                } ?>

                </tbody>

            </table>

        </div>

    </div>


    <button type='button' class='btn btn-primary btn-sm pull-right hidden-print' onclick='window.print();'>Print
    </button>

</div>
</body>
</html>