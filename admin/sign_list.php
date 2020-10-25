<?php
include("check_session.php");
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\config;
use APP\school;


$cls = $_GET['cls'];
$ayear = $_GET['ayear'];
$prog = $_GET['prog'];
$rate = $_GET['rate'];
?>
<html>
<head>
    <meta charset="UTF-8">

    <link href="css/bootstrap-print.css" rel="stylesheet" type="text/css"/>
    <style type="text/css">
        table, th, tr, td {
            border: 1px solid #000 !important;

            font-family: Arial, Helvetica, sans-serif;
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
    <?php
    $cfg = new config();
    $cfg->connect();
    $cls_list = mysqli_query($cfg->con, "select fname,oname,lname,photo,gender,fhometown,mhometown,jhsno,shsno from stuinfo where class = '$cls' and ayear = '$ayear' and dept = '$prog' order by fname ASC ");
    $sch = new school();
    $clas = mysqli_query($cfg->con, "select classname from classes where id = '$cls'");
    $cl = mysqli_fetch_object($clas)->classname;
    $progrm = mysqli_fetch_object(mysqli_query($cfg->con, "select depname from dept where id = '$prog'"))->depname;
    ?>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <img style="margin: 10px;" class="img-responsive" src="objts/<?= $sch->logopath ?>" alt="School Crest"/>


        </div>
        <div class="col-lg-10 col-md-10">
            <center>
                <u><span style="font-size: 25px; font-weight: bold;"><?= ucwords($sch->schname) ?></span><br/></u>
                <span style="font-size: 13px;"><?= ucwords($sch->schooladdress) ?></span><br/>
                <strong>Email:</strong>tumusectec@gmail.com <br>
                <span style="font-size: 20px;">SIGN LIST BY CLASSES FOR <?= $ayear; ?> ACADEMIC YEAR </span> <br/>
                <span style="font-size: 20px;">CLASS: <?= $progrm . '/' . $cl ?> </span>

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
                PHOTO
            </th>
            <th style="text-align: center;">
                JHS No.
            </th>
            <th style="text-align: center;">
                SHS No.
            </th>
            <th style="text-align: center;">
                FULL NAME
            </th>
            <th style="text-align: center;">
                FATHER'S <br/> HOMETOWN
            </th>


            <th style="text-align: center;">
                GENDER
            </th>

            <th style="text-align: center;">
                RATE
            </th>

            <th style="text-align: center;">
                SIGNATURE
            </th>


        </tr>


        </thead>
        <tbody>
        <?php
        $i = 1;
        while ($row = mysqli_fetch_object($cls_list)) {

            ?>

            <tr>
                <td style="vertical-align: middle; text-align: center;"><?= $i; ?></td>
                <td style="padding: 0; text-align: center;">

                    <img width="90" height="100" src="<?= $row->photo; ?>"/>

                </td>
                <td style="vertical-align: middle; text-align: center;"><?= $row->jhsno ?></td>
                <td style="vertical-align: middle; text-align: center;"><?= $row->shsno ?></td>
                <td style="vertical-align: middle; text-align: center;"><?= $row->fname . ' ' . $row->lname . ' ' . $row->oname; ?></td>
                <td style="vertical-align: middle; text-align: center;"><?= $row->fhometown; ?></td>
                <td style="vertical-align: middle; text-align: center;"><?= $row->gender; ?></td>
                <td style="vertical-align: middle; text-align: center;"><?= $rate; ?></td>
                <td></td>

            </tr>
            <?php
            $i++;
        }
        ?>

        </tbody>


    </table>

    <button type='button' class='btn btn-primary btn-sm pull-right hidden-print' onclick='window.print();'>Print
    </button>

</div>
</body>
</html>
