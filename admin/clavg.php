<?php
ini_set("max_execution_time",300);

include("check_session.php");

require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\school;
use APP\config;
use APP\Utitlity;

$utl = new utitlity();

$class = $_GET['cls'];
$term = $_GET['term'];
$ayear = $_GET['ayear'];
$sch = new school();

?>

<html>
<head>
    <meta charset="UTF-8">

    <link href="css/bootstrap-print.css" rel="stylesheet" type="text/css"/>
    <style type="text/css">
        table, th, tr, td {
            border: 1px solid #000 !important;
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
    <?php
    $cfg = new config();
    $cfg->connect();
    $stids = mysqli_query($cfg->con, "SELECT id as stid,(SELECT SUM((subtotl*$sch->clscore_ratio)/$sch->sba+(exam*($sch->exam_ratio/100))) FROM records WHERE stid = stuinfo.id and acyear='$ayear' and term='$term') as sm, fname,lname,oname  from stuinfo WHERE id in(SELECT DISTINCT(stid) from records where acyear = '$ayear' and term = '$term' and cls = '$class') and stuinfo.id not in(SELECT stid from withdraw) ORDER by sm DESC");
    $class_name = mysqli_fetch_object(mysqli_query($cfg->con, "select classname from classes where id = '$class'"))->classname;
    ?>
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <img style="margin: 10px;" class="img-responsive" src="objts/<?= $sch->logopath ?>" alt="School Crest"/>
        </div>
        <div class="col-lg-10 col-md-10">
            <center>
                <u><span style="font-size: 25px; font-weight: bold;"><?= ucwords($sch->schname) ?></span><br/></u>
                <span style="font-size: 13px;"><?= ucwords($sch->schooladdress) ?></span><br/>
                <span style="font-size: 20px;">GENERAL RESULTS FOR  <?= strtoupper($class_name) ?> <br> ACADEMIC YEAR: <?= $ayear ?>, TERM: <?= $utl->addsufix($term); ?> Term</span>
            </center>
        </div>
        <hr/>
    </div>
    <table class="table table-striped table-condensed">
        <thead>
        <tr>
            <th style="text-align: center;">
                S/N
            </th>
            <th>
                NAME
            </th>
            <th style="text-align: center;">
                OVERALL AVERAGE
            </th>
            <th style="text-align: center;">
                SUM OF SCORES
            </th>
            <th style="text-align: center;">
                GRADE
            </th>
            <th style="text-align: center;">
                POSITION
            </th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i = 1;
        while ($row = mysqli_fetch_object($stids)) {
            $subnum = mysqli_num_rows(mysqli_query($cfg->con, "select DISTINCT(subjt) from records WHERE acyear='$ayear' and term='$term' and cls = '$class' and stid = '$row->stid'"));
            $sumsc = mysqli_fetch_object(mysqli_query($cfg->con, "select sum(totlscore) as sm from records where term='$term' and acyear = '$ayear' and stid='$row->stid'"))->sm;
            $stname = mysqli_fetch_object(mysqli_query($cfg->con, "select fname,oname,lname from stuinfo where id = '$row->stid'"));
            if ($subnum > 0) {
                $avg = number_format($sumsc / $subnum, 2);
                ?>
                <tr>
                    <td style="text-align: center;"><?= $i ?></td>
                    <td><?= $row->fname . ' ' . $row->lname . ' ' . $row->oname; ?></td>
                    <td style="text-align: center;"><?= number_format($row->sm / $subnum, 2); ?></td>
                    <td style="text-align: center;"><?= number_format($row->sm, 2); ?></td>
                    <td style="text-align: center;"><?= $utl->getgrd($row->sm / $subnum, 2); ?></td>
                    <td style="text-align: center;"><?= $utl->addsufix($i) ?></td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
        </tbody>
    </table>
    <button type='button' class='btn btn-primary btn-sm pull-right hidden-print' onclick='window.print();'>Print
    </button>
</div>
</body>
</html>
