<?php
include_once './objts/config.php';
include_once './objts/school.php';
$sch = new school();
$term = $_GET['term'];
$ayear = $_GET['ayear'];
$cls = $_GET['cls'];
$sub = $_GET['subjt'];

$cg = new config();
$cg->connect();
include_once '../admin/objts/utitlity.php';
$util = new Utitlity();
$classname = mysqli_fetch_object(mysqli_query($cg->con, "select classname from classes where id = '$cls'"))->classname;
$staff = mysqli_fetch_object(mysqli_query($cg->con, "select lname,fname from staff where id = (select stfid from subas where clid='$cls' and subid = '$sub')"));
$subname = mysqli_fetch_object(mysqli_query($cg->con, "select subjdesc from subjects where id = '$sub'"))->subjdesc;
$numroll = mysqli_fetch_object(mysqli_query($cg->con, "select count(*) as numroll from records where term ='$term' and acyear = '$ayear' and subjt = '$sub' and cls = '$cls'"))->numroll;
$avge=0;
$term_suf = $util->addsufix($term);
$staf_name = "";
if ($staff) {
    $staf_name = $staff->fname . " " . $staff->lname;


}
?>
<html>
<head>
    <title>Termly assessment Plan</title>
    <link href='../admin/css/bootstrap-print.css' rel='stylesheet'/>
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
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <img style="margin: 10px;" class="img-responsive" width="140" height="150"
                 src="../admin/objts/<?= $sch->logopath ?>" alt="School crest"/>
        </div>
        <div class='col-lg-10 col-md-10 col-sm-10 col-xs-10'>
            <center>
                <u><span id='main_head'><?= $sch->schname; ?></span></u> <br/>
                <?= $sch->schooladdress; ?>
                <br/><u><span id='sub_head'>TERMLY ASSESSMENT PLAN</span></u>
            </center>
        </div>
    </div>
    <div class='row'
         style="background-image:  url('./img/wmark1.png'); background-repeat: no-repeat; background-position: center;">
        <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
            <table class='table table-striped table-condensed'>
                <thead>
                <tr>
                    <th colspan='2'>TUTOR:</th>
                    <td colspan='9'><?= $staf_name; ?></td>
                    <th colspan='2'>NO. ON ROLL:</th>
                    <td><?= $numroll; ?></td>
                    <th colspan='3'>AVERAGE MARK:</th>
                    <td id="avg_td"><?= number_format($avge, 2); ?></td>
                </tr>
                <tr>
                    <th colspan='2'>SUBJECT:</th>
                    <td style="vertical-align: bottom;" colspan='8'><?= $subname; ?></td>
                    <th colspan='2'>CLASS:</th>
                    <td style="vertical-align: bottom;"><?= $classname; ?></td>
                    <th colspan='2'>AC. YEAR:</th>
                    <td style="vertical-align: bottom;"><?= $ayear; ?></td>
                    <th>TERM:</th>
                    <td><?= $term_suf; ?> Term</td>

                </tr>
                <tr>
                </tr>
                <tr>
                    <th style='text-align:center;'>S/N</th>
                    <th>FULL NAME</th>
                    <th style='text-align :center;' colspan='4'>CLASS<br/>TEST</th>
                    <th style='text-align: center;' colspan='4'>CLASS EXERCISE</th>
                    <!--						<th style='text-align: center; '  colspan="2">PROJECT<br/>WORK</th>-->
                    <th style='text-align: center;'>SBA</th>
                    <th style='text-align: center;'>SBA <br/>(<?= $sch->clscore_ratio . "%"; ?>)</th>
                    <th style='text-align: center;'>EXAMS<br/>100%</th>
                    <th style='text-align: center;'>EXAM<br/>(<?= $sch->exam_ratio . "%"; ?>)</th>
                    <th style='text-align: center;'>TOTAL<br/>SCORE</th>
                    <th style='text-align: center;'>GRADE</th>
                    <th style='text-align: center;'>REMARK</th>
                    <th style='text-align: center;'>POS.</th>
                </tr>
                </thead>
                <tbody>

                <?php
                $recs = mysqli_query($cg->con, "select stuinfo.fname,stuinfo.lname,stuinfo.oname,classes.classname,records.term,records.acyear,subjects.subjdesc,ta1,ta2,ta3,ta4,hw1,hw2,hw3,hw4,pw1,pw2,subtotl,cvsubtotl,exam,cvexam,totlscore,grd,remark,post,((subtotl*$sch->clscore_ratio)/$sch->sba+(exam*($sch->exam_ratio/100))) as tscore from records,stuinfo,classes,subjects where records.subjt = subjects.id and records.cls = classes.id and records.stid = stuinfo.id and records.term = '$term' and records.acyear='$ayear' and records.subjt = '$sub' and records.cls = '$cls' ORDER by tscore DESC");
                $i = 1;
                $sum_sc=0;
                while ($recrows = mysqli_fetch_object($recs)) {
                    $cvsubtotal = (($recrows->subtotl * $sch->clscore_ratio) / $sch->sba);
                    $cvexam = (($sch->exam_ratio / 100) * $recrows->exam);
                    $tscore=$cvexam+$cvsubtotal;
                    ?>
                    <tr>
                        <td style='text-align: center;'><?= $i; ?></td>
                        <td><?= $recrows->fname . " " . $recrows->lname . " " . $recrows->oname; ?></td>
                        <td style='text-align:center; vertical-align: middle;'><?= $recrows->ta1; ?></td>
                        <td style='text-align: center; vertical-align: middle;'><?= $recrows->ta2; ?></td>
                        <td style='text-align:center; vertical-align: middle;'><?= $recrows->ta3; ?></td>
                        <td style='text-align:center; vertical-align: middle;'><?= $recrows->ta4; ?></td>
                        <td style='text-align: center; vertical-align: middle;'><?= $recrows->hw1; ?></td>
                        <td style='text-align:center; vertical-align: middle;'><?= $recrows->hw2; ?></td>
                        <td style='text-align:center; vertical-align: middle;'><?= $recrows->hw3; ?></td>
                        <td style='text-align: center; vertical-align: middle;'><?= $recrows->hw4; ?></td>
                        <!--					<td style='text-align:center; vertical-align: middle;'></td>-->
                        <!--					<td style='text-align:center; vertical-align: middle;'></td>-->
                        <td style='text-align: center; vertical-align: middle;'><?= $recrows->subtotl; ?></td>
                        <td style='text-align:center; vertical-align: middle;'><?= $cvsubtotal; ?></td>
                        <td style='text-align:center; vertical-align: middle;'><?= $recrows->exam; ?></td>
                        <td style='text-align: center; vertical-align: middle;'><?= $cvexam; ?></td>
                        <td style='text-align:center; vertical-align: middle;'><?= number_format($tscore, 1); ?></td>
                        <td style='text-align:center; vertical-align: middle;'><?= $util->getgrd($tscore); ?></td>
                        <td style='text-align:center; vertical-align: middle;'><?= $util->getremark($tscore); ?></td>
                        <td style='text-align:center; vertical-align: middle;'><?= $util->addsufix($i); ?></td>
                    </tr>
                    <?php

                    $sum_sc+=$tscore;
                    $i++;
                }
                $avge = number_format(($sum_sc/$i),2);
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class='row'>
        <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
        </div>

    </div>

    <button type='button' class='btn btn-primary btn-sm pull-right hidden-print' onclick='window.print();'>Print
    </button>

</div>
    <script>
        function mkavg(a) {
         var avge_td = document.querySelector('#avg_td').innerHTML = a;
        }
            mkavg(<?=$avge?>)

    </script>
</body>
</html>