<?php
include_once '../admin/objts/school.php';
include_once '../admin/objts/config.php';
include_once '../admin/objts/utitlity.php';
$cf = new config();
$cf->connect();
$util = new Utitlity();
$stid = $_GET['id'];

?>

<html>
<head>
    <meta charset="UTF-8">

    <link href="../admin/css/bootstrap-print.css" rel="stylesheet" type="text/css"/>
    <style type="text/css">
        .alert-info {
            background-color: deepskyblue;
            color: #fff;
            border: 1px solid deepskyblue;
            border-radius: 0;
        }

        table, th, tr, td {
            border: 1px solid #000 !important;
            background-color: transparent !important;
            -webkit-background-color: transparent !important;
        }

        @media print {

            table, th, tr, td {
                border: 1px solid #000 !important;
                background-color: transparent !important;
                -webkit-background-color: transparent !important;

            }

            .rescont {
                background-image: url('./img/wmark3.png') !important;
                background-repeat: no-repeat;
                background-position: center;
                background-size: contain;
                background-repeat: no-repeat !important;
                background-position: center !important;
                background-size: 60% !important;
            }

        }
    </style>
</head>
<body>
<div class="container-fluid">
    <?php

    $years = mysqli_query($cf->con, "select distinct(acyear) from records where stid = '$stid' order by acyear ASC");
    $sch = new school();
    $stinfo = mysqli_fetch_object(mysqli_query($cf->con, "select Stuinfo.id,fname,lname,oname,photo,form,classes.classname,class,ayear from stuinfo,classes where stuinfo.id = '$stid' and stuinfo.class = classes.id"));
    $num_roll = mysqli_fetch_object(mysqli_query($cf->con, "select count(*) as cn from stuinfo where class = '$stinfo->class' and ayear = '$stinfo->ayear'"))->cn;
    ?>
    <div class="row">

        <div class="col-lg-12 col-md-12">
            <center>
                <img style="margin: 10px;" class="img-responsive" src="../admin/objts/<?=$sch->logopath ?>" alt="School Crest"/>
                <br/>
                <u><span style="font-size: 25px; font-weight: bold;"><?= ucwords($sch->schname) ?></span><br/></u>
                <span style="font-size: 15px;"><?= ucwords($sch->schooladdress) ?></span><br/>
                <strong>Email:</strong>menjiagricshs@yahoo.com<br>

                <span style="font-size: 22px;">STUDENT'S PERFORMANCE TRANSCRIPT </span>

            </center>

        </div>

    </div>

    <div class="row" style="page-break-after: always;">
        <div class="col-lg-12 col-md-12">
            <table class="table table-condensed">

                <tr>


                    <th rowspan="5" style="text-align: center;">
                        <img width="180" height="200" src="../admin/<?=$stinfo->photo; ?>"/>

                    </th>
                    <th style="vertical-align: middle;">FULL NAME:</th>
                    <td style="vertical-align: middle;"><?= strtoupper($stinfo->fname . ' ' . $stinfo->lname . ' ' . $stinfo->oname) ?></td>

                </tr>


                <tr>
                    <th style="vertical-align: middle;">CURRENT CLASS:</th>
                    <td style="vertical-align: middle;"><?= strtoupper($stinfo->classname) ?></td>
                </tr>
                <tr>

                    <th style="vertical-align: middle;">CURRENT NO. ON ROLL:</th>

                    <td style="vertical-align: middle;"><?= $num_roll; ?></td>


                </tr>
                <tr>
                    <th style="vertical-align: middle;">CURRENT FORM:</th>
                    <td style="vertical-align: middle;"><?= "FORM " . $stinfo->form; ?></td>
                </tr>

            </table>
            <center><span style="font-style: italic;" class="text-danger  hidden-print">(THIS DOCUMENT SHOULD BE ENDORSED BY THE HEADMASTER/MISTRESS OF THE SCHOOL )</span>
            </center>
            <br/>
        </div>
    </div>


    <?php
    $studid = $stinfo->id;
    while ($row1 = mysqli_fetch_object($years)) {

        $ayear = $row1->acyear;
        $term = 1;
        ?>
        <div class="rescont"
             style="background-image:  url('./img/wmark3.png') !important; background-repeat: no-repeat; background-position: center;  background-color: transparent !important; border: 1px solid #000; margin-bottom: 5px; padding:5px; page-break-after: always;">
            <strong style="font-size: 18px;"> <?= $ayear . " ACADEMIC YEAR" ?> </strong><br/>
            <div style="border-top: 1px solid #000;"></div>
            <br/>
            <?php
            while ($term <= 3) {

                $cfg = new config();
                $cfg->connect();
                $rep1 = mysqli_query($cfg->con, "select cls,subjt,subtotl,exam,cvsubtotl,cvexam,totlscore,subjects.subjdesc,post,((subtotl*$sch->clscore_ratio)/$sch->sba+(exam*($sch->exam_ratio/100))) as tscore from records,subjects where acyear = '$ayear' and term = '$term' and stid = '$stid' and records.subjt = subjects.id and subjects.type = 'Core Subject'");
                $rep2 = mysqli_query($cfg->con, "select cls,subjt,subtotl,exam,cvsubtotl,cvexam,totlscore,subjects.subjdesc,grd,remark,post,((subtotl*$sch->clscore_ratio)/$sch->sba+(exam*($sch->exam_ratio/100))) as tscore from records,subjects where   acyear = '$ayear' and term = '$term' and stid = '$stid' and records.subjt = subjects.id and subjects.type = 'Elective Subject'");


                if (mysqli_num_rows($rep1) > 0 || mysqli_num_rows($rep2) > 0) {
                    $numsubs = (mysqli_num_rows($rep1) + mysqli_num_rows($rep2));
                    $summark = mysqli_fetch_object(mysqli_query($cf->con, "select sum(totlscore) as sm from records where stid = '$stid' and acyear = '$ayear' and term = '$term'"))->sm;
                    $avg = ($summark / $numsubs)

                    ?>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <table class="table table-striped table-condensed"
                                   style=" font-size: 12px; background-color: transparent !important; background-image: background-repeat: no-repeat; background-size:corver; background-position:center;">
                                <thead>
                                <tr>
                                    <td><?= $util->addsufix($term) . " Term"; ?></td>

                                </tr>
                                <tr>
                                    <th style="text-align: center;">
                                        SUBJECT
                                    </th>

                                    <th style="text-align: center;">
                                        TOTAL MARK
                                    </th>
                                    <th style="text-align: center;">
                                        GRADE
                                    </th>

                                    <th style="text-align: center;">
                                        REMARK
                                    </th>

                                    <th style="text-align: center;">
                                        POSITION
                                    </th>

                                </tr>


                                </thead>
                                <tbody>
                                <tr>

                                    <td colspan="5" class="text-muted"
                                        style="text-align: center; font-weight: bold; font-style: italic;">CORE SUBJECTS
                                    </td>

                                </tr>
                                <?php
                                $i = 1;
                                $totlscore1 = 0;
                                $totlscore2 = 0;
                                $nusub = 0;
                                while ($row = mysqli_fetch_object($rep1)) {
                                    $nusub++;
                                    $cvsubtotl = (($sch->clscore_ratio / $sch->sba) * $row->subtotl);
                                    $cvexam = (($sch->exam_ratio / 100) * $row->exam);
                                    $totlscore1 += $row->tscore;
                                    $poscls = $row->cls;
                                    ?>
                                    <tr>
                                        <td style="text-align: center;"><?= strtoupper($row->subjdesc); ?></td>
                                        <td style="text-align: center;"><?= number_format($row->tscore, 1); ?></td>
                                        <td style="text-align: center;"><?= $util->getgrd(number_format($row->tscore, 1)); ?></td>
                                        <td style="text-align: center;"><?= $util->getremark(number_format($row->tscore, 1)); ?></td>
                                        <td style="text-align: center;"><?= $util->addsufix($util->getpost($stid, $row->subjt, $term, $ayear, $row->cls)); ?></td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>

                                <tr>

                                    <td class="text-muted" colspan="5"
                                        style="text-align: center; font-weight: bold; font-style: italic;">ELECTIVE
                                        SUBJECTS
                                    </td>

                                </tr>

                                <?php

                                while ($row2 = mysqli_fetch_object($rep2)) {
                                    $nusub++;
                                    $cvsubtotl = (($sch->clscore_ratio / $sch->sba) * $row2->subtotl);
                                    $cvexam = (($sch->exam_ratio / 100) * $row2->exam);
                                    $totlscore2 += $row2->tscore;

                                    ?>

                                    <tr>
                                        <td style="text-align: center;"><?= strtoupper($row2->subjdesc); ?></td>
                                        <td style="text-align: center;"><?= number_format($row2->tscore, 1); ?></td>
                                        <td style="text-align: center;"><?= $util->getgrd(number_format($row2->tscore, 1)); ?></td>
                                        <td style="text-align: center;"><?= $util->getremark(number_format($row2->tscore, 1)); ?></td>
                                        <td style="text-align: center;"><?= $util->addsufix($util->getpost($stid, $row2->subjt, $term, $ayear, $row2->cls)); ?></td>


                                    </tr>
                                    <?php

                                }
                                $totlscore = ($totlscore1 + $totlscore2);
                                ?>

                                </tbody>
                                <tfoot>

                                <tr style="color:red;">
                                    <th>Overall Position:</th>
                                    <td style="text-align: center;">
                                        <?php
                                        $stids = mysqli_query($cf->con, "SELECT id as stid,(SELECT SUM((subtotl*$sch->clscore_ratio)/$sch->sba+(exam*($sch->exam_ratio/100))) FROM records WHERE stid = stuinfo.id and acyear='$ayear' and term='$term') as sm from stuinfo WHERE id in(SELECT DISTINCT(stid) from records where acyear = '$ayear' and term = '$term' and cls = '$poscls') and id not in(select stid from withdraw) ORDER by sm DESC");
                                        $pos = 1;
                                        while ($p = mysqli_fetch_object($stids)) {
                                            if ($p->stid === $studid) {
                                                echo($util->addsufix($pos));
                                            }
                                            $pos++;
                                        }
                                        ?>

                                    </td>
                                    <th>Overall Average Score:</th>
                                    <td style="text-align: center;"><?= number_format($totlscore / $nusub, 2); ?></td>
                                </tr>
                                </tfoot>
                            </table>
                            <div style="border-top: 1px solid #000; margin-bottom: 10px;"></div>
                        </div>
                    </div>
                    <?php
                }
                $term++;
            }
            ?>

        </div>

        <?php
    }

    ?>


    <div class="row hidden-print">
        <div style="border: 1px dashed red" class="col-lg-12 col-md-12 col-xs-12 alert alert-info">
            Individual subjet averages are caculated by adding all total scores for each subject in a year and then
            dividing the sum by 2 (2 semisters) <br>
            Total averages are caculated by adding all individual averages of each subject and then dividing the sum by
            6 (6 Semisters in a year) <br>
              <strong>Please note that if the government ever change the number of years a student should do in senior
                high school, you are supposed to call for an update as this function can only be adjusted through
                code</strong>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <center><p>
                <h3><u>Accumulated Averages</u></h3></p></center>
            <table class="table table-condensed" style="font-size: 12px;">
                <thead>
                <tr>
                    <th>Subject</th>
                    <?php
                    $ays = mysqli_query($cf->con, "select distinct(acyear) from records WHERE stid = '$stid' ORDER by acyear ASC ");
                    $i = 1;
                    while ($y = mysqli_fetch_object($ays)) {
                        ?>
                        <th style="text-align: center;"><?= $y->acyear; ?> (<?= $util->addsufix($i) ?> Year)</th>

                        <?php
                        $i++;
                    }
                    ?>
                    <th style="text-align: center;">Total Average</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $subids = mysqli_query($cf->con, "select distinct(subjt) from records WHERE stid = '$stid'");

                while ($sids = mysqli_fetch_object($subids)) {
                    $subname = mysqli_fetch_object(mysqli_query($cf->con, "select subjdesc from subjects where id = '$sids->subjt'"))->subjdesc;
                    ?>
                    <tr>
                        <td><?= $subname ?></td>
                        <?php
                        $ys2 = mysqli_query($cf->con, "select distinct(acyear) from records WHERE stid = '$stid' ORDER by acyear ASC ");
                        $sumt = 0;
                        while ($y2 = mysqli_fetch_object($ys2)) {
                            $sums = mysqli_fetch_object(mysqli_query($cf->con, "select sum((subtotl*$sch->clscore_ratio)/$sch->sba+(exam*($sch->exam_ratio/100))) as sm from records WHERE stid = '$stid' and acyear = '$y2->acyear' and subjt = '$sids->subjt'"))->sm;
                            $sumt += $sums;
                            ?>
                            <td style="text-align: center;"><?= number_format(($sums / 2), 2) ?></td>
                            <?php
                        }
                        // $tsums = mysqli_fetch_object(mysqli_query($cf->con,"select sum(totlscore) as sm from records where stid = '$stid' and subjt = '$sids->subjt'"))->sm;
                        ?>
                        <td style="text-align: center;"><?= number_format(($sumt / 6), 2) ?></td>
                        <?php
                        ?>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <strong> HEADMASTER/HEADMISTRESS'
                SIGNATURE/STAMP................................................................</strong>


        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <strong> DATE..........................................................</strong>

        </div>
    </div>


    <button type='button' class='btn btn-primary btn-sm pull-right hidden-print' onclick='window.print();'>Print
    </button>

</div>
</body>
</html>

