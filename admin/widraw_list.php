<?php
include("check_session.php");
include_once './objts/school.php';
include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$ayear = $_GET['ayear'];
?>

<html>
<head>
    <meta charset="UTF-8">
    <link href="css/bootstrap-print.css" rel="stylesheet" type="text/css"/>
    <style type="text/css">
        table, th, tr, td{
            border:1px solid #000 !important;
        }

        @media print{

            table, th, tr, td{
                border:1px solid #000 !important;

            }

        }

    </style>
</head>
<body>
<div class="container">
    <?php

    $cls_list = mysqli_query($cf->con,"select fname,oname,lname,stindex,gender,classes.classname,form from stuinfo,classes where ayear = '$ayear' and stuinfo.id in (SELECT stid from withdraw) and stuinfo.class = classes.id order by fname ASC ");
    $sch = new school();
    ?>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <img style="margin: 10px;"  class="img-responsive" src="objts/<?= $sch->logopath ?>" alt="School Crest" />
        </div>
        <div class="col-lg-10 col-md-10">
            <center>
                <u><span style="font-size: 25px; font-weight: bold;"><?= ucwords($sch->schname) ?></span><br/></u>
                <span style="font-size: 13px;"><?= strtoupper($sch->schooladdress) ?></span><br/>
                <span style="font-size: 20px;">LIST OF WITHDRAWN STUDENTS <?= "(". $ayear .")";?> </span>

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
                ID No.
            </th>
            <th>
                FULL NAME
            </th>
            <th>
                GENDER
            </th>
            <th>
                FORM

            </th>
            <th>
                CLASS

            </th>

        </tr>



        </thead>
        <tbody>
        <?php
        $i=1;
        while ($row = mysqli_fetch_object($cls_list)) {

            ?>

            <tr>
                <td style="text-align: center;"><?=$i;?></td>
                <td><?=$row->stindex;?></td>
                <td><?=$row->fname.' '.$row->lname.' '.$row->oname;?></td>
                <td><?=$row->gender;?></td>
                <td><?="Form ".$row->form;?></td>
                <td><?=$row->classname;?></td>


            </tr>
            <?php
            $i++;
        }
        ?>

        </tbody>




    </table>

    <button type='button' class='btn btn-primary btn-sm pull-right hidden-print' onclick='window.print();'>Print</button>

</div>
</body>
</html>
