<?php
include("../admin/check_session.php");
include_once("../admin/objts/config.php");
include_once("../admin/objts/school.php");
$cf= new config();
$cf->connect();
$sch= new school();
$id = $_GET['id'];
$staf = mysqli_fetch_object(mysqli_query($cf->con,"select * from staff where id = '$id'"));
$subs  = mysqli_query($cf->con,"select subjects.subjdesc,subjects.type,classes.*,subas.* from subjects,classes,subas WHERE subas.subid = subjects.id and subas.clid = classes.id and subas.stfid = '$id'");

$ranklist = ["Senior Sup't","Prin. Sup't","Assist. Dir ii","Assist. Dir I","Dep. Dir.", "Dir. II","Dir. I"];
$formcls = mysqli_query($cf->con,"select * from classes where id in(select clid from frmmaters where stfid = '$id')");
$tday = date("Y-M-d");
$tyear = substr($tday,0,4);
$svyear = is_null($staf->assdate)?$tyear: substr($staf->assdate,0,4);
$apyear = is_null($staf->appdate)?$tyear: substr($staf->appdate,0,4);
$dbyear = is_null($staf->dob)?$tyear: substr($staf->dob,0,4);
$dbyear+=60;
$dur = $tyear-$apyear;
$years= $tyear-$svyear;
$rank = is_numeric($staf->rank)?$staf->rank:0;
?>


<html>
<head>
    <title>Staff Profile</title>
    <link href="../admin/css/bootstrap-print.css" rel="stylesheet" type="text/css"/>
    <style type="text/css">
        table, th, tr, td{
            border:1px solid #000 !important;
            vertical-align: middle !important;
            font-size: 13px;
            font-family: Arial, Helvetica, "sans-serif";


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
    <div class="row" style="border-bottom: 1px solid #000;">

        <center>
        <h3><?=strtoupper($sch->schname)?></h3>
    <h5><?=$sch->schooladdress?></h5>
        <h3>STAFF PROFILE</h3>
    </center>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <br>
<table class="table table-striped table-condensed">
    <tr>
        <th class="text-center">DEMOGRAPHIC INFORMATION</th>
    </tr>

    <tr>
        <td rowspan="5" style="text-align: center;">
            <img src="<?=$staf->photo ? $staf->photo: 'img/photo.jpg' ?>" alt="<?=$staf->fname?> 's photo">
        </td>
        </tr>
    <tr>
        <th>Name</th>
        <td colspan="5"><?=$staf->fname." ".$staf->lname?></td>
    </tr>

    <tr>
        <th>Gender</th>
        <td><?=$staf->gender?></td>
        <th>D.O.B</th>
        <td><?=$staf->dob?></td>
        <th>Contact Number</th>
        <td><?=$staf->contact?></td>
    </tr>

    <tr>
        <th>Staff ID</th>
        <td><?=$staf->stfid?></td>
        <th>Registered Number</th>
        <td><?=$staf->regno?></td>
        <th>SSNIT Number</th>
        <td><?=$staf->snnid?></td>
    </tr>
    <tr>
        <th>Academic Qualification</th>
        <td><?=$staf->aqual?></td>
        <th>Professional Qualification</th>
        <td><?=$staf->pqual?></td>
        <th>Rank</th>
        <td><?=$ranklist[$rank]?></td>
    </tr>

    <tr>
        <th>Date Of first Appointment</th>
        <td><?=$staf->appdate?></td>
        <th>Associated Bank</th>
        <td><?=$staf->bank?></td>
        <th>Bank Acc. No.</th>
        <td colspan="2"><?=$staf->accno?></td>
    </tr>

    <tr>
        <th>Duration At Post</th>
        <td><?=$years?> Years</td>
        <th>Retirement Year</th>
        <td><?=$dbyear?></td>
        <th>Duration In Service</th>
        <td colspan="2"><?=$dur?> Years</td>
    </tr>
</table>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <table class="table table-striped table-condensed">
            <tr>
                <th class="text-center">SUBJECTS/CLASSES TAUGHT</th>
            </tr>
                <?php
                 while($sb = mysqli_fetch_object($subs)){
                 ?>

                    <tr>

                        <td><?=$sb->classname?></td>

                        <td><?=$sb->subjdesc?></td>

                    </tr>


                   <?php

                }

                ?>
            </table>

        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <table class="table table-striped table-condensed">
                <tr>
                    <th class="text-center">

                        FORM <?=($staf->gender == "Male")?"MASTER":"MISTRESS"?>
                    </th>
                </tr>

                <?php
                while($fm = mysqli_fetch_object($formcls)){
                    ?>

                    <tr>
                        <td>
                        <?=$fm->classname?>
                        </td>
                    </tr>
                    <?php
                }

                ?>


            </table>

        </div>
        <br>
        <button class="btn btn-primary hidden-print" onclick="window.print();">Print</button>
    </div>
    </div>
</body>
</html>


