<?php
include("check_session.php");
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\config;

$cf = new config();
$cf->connect();
$frmcls = $_GET['frmcls'];
$frmayear = $_GET['frmayear'];
$frmform = $_GET['frmform'];
$toform = $_GET['toform'];
$tocls = $_GET['tocls'];
$toayear = $_GET['toayear'];
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

    $toclassname = mysqli_fetch_object(mysqli_query($cf->con, "select classname from classes where id = '$tocls'"))->classname;
    $cls_list = mysqli_query($cf->con, "select fname,oname,lname,gender,ayear from stuinfo where (class = '$frmcls' and ayear = '$frmayear' and form = '$frmform') or (class = '$tocls' and ayear = '$toayear' and form = '$toform') and id not in (SELECT stid from withdraw) order by fname ASC ");
    $sch = new school();
    $clas = mysqli_query($cf->con, "select classname from classes where id = '$frmcls'");
    $cl = mysqli_fetch_object($clas)->classname;
    ?>

    <div class="row" style="border-bottom: 1px solid #000; margin-bottom: 15px;">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <img class="img-responsive" src="objts/<?= $sch->logopath ?>" alt="School Crest"/> <br>
        </div>
        <div class="col-lg-10 col-md-10">
            <center>
                <u><span style="font-size: 25px; font-weight: bold;"><?= ucwords($sch->schname) ?></span><br/></u>
                <span style="font-size: 15px;"><?= strtoupper($sch->schooladdress) ?></span><br/>
                <span style="font-size: 20px;">PROMOTION LIST FOR <?= strtoupper($cl); ?>(<?= $toayear ?>) </span> <br>
                <strong>Students with statuses PROMOTED have been promoted to Form <?= $toform ?> (<?= $toclassname ?>
                    )</strong>
            </center>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
        <tr>
            <th style="text-align: center;">
                S/N
            </th>

            <th>
                FULL NAME
            </th>
            <th>
                GENDER
            </th>
            <th>STATUS</th>

        </tr>
        </thead>
        <tbody>
        <?php
        $i = 1;
        while ($row = mysqli_fetch_object($cls_list)) {
            ?>

            <tr>
                <td style="text-align: center;"><?= $i; ?></td>

                <td><?= $row->fname . ' ' . $row->lname . ' ' . $row->oname; ?></td>
                <td><?= $row->gender; ?></td>
                <?php
                if ($row->ayear === $frmayear) {

                    ?>

                    <td>REPEATED</td>

                    <?php
                } else {
                    ?>
                    <td>PROMOTED</td>


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

    <span style="color:red" class="hidden-print">
                You are advised to print or save this document Immediately. This is because it is only generated during the promotion process 
                
            </span>

    <button type='button' class='btn btn-primary btn-sm pull-right hidden-print' onclick='window.print();'>Print
    </button>

</div>
</body>
</html>
