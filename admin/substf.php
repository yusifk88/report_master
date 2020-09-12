<?php
ini_set("max_execution_time",300);
include("check_session.php");
include_once './objts/config.php';
include_once './objts/school.php';
include_once './objts/utitlity.php';
$ut = new utitlity();
$sch = new school();
$cg = new config();
$cg->connect();
include_once './objts/utitlity.php';
$util = new Utitlity();
$stafflist = mysqli_query($cg->con, "select * from staff WHERE user_type <>'admin'  ORDER by fname ASC ");
?>
<html>
<head>
    <title>List Of Staff</title>
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
                <u><span id='main_head'><?= $sch->schname; ?></span></u>
                <br/><u><span id='sub_head'>LIST OF SUBJECT TEACHERS AND CLASSES TAUGHT</span></u>
            </center>
        </div>
    </div>
    <table class="table">
        <thead>
        <th class="text-uppercase text-center">S/N</th>
        <th class="text-uppercase">Name</th>
        <th class="text-uppercase">Sex</th>
        <th class="text-uppercase">Contact</th>
        <th class="text-uppercase text-center">subjects & classes taught</th>
        <th class="text-uppercase">SIGN./COMMENT</th>

        </thead>
        <tbody>
        <?php
        $i = 1;
        while ($row = mysqli_fetch_object($stafflist)) {

            $sublist = mysqli_query($cg->con, "select subjects.subjdesc,subjects.type,classes.classname from subjects,subas,classes WHERE subas.stfid = '$row->id' and subjects.id = subas.subid and classes.id = subas.clid");

            ?>
            <tr>
                <td class="text-center" style="vertical-align: middle"><?= $i ?></td>
                <td style="vertical-align: middle"><?= $row->fname . " " . $row->lname ?></td>
                <td style="vertical-align: middle"><?= $row->gender ?></td>
                <td style="vertical-align: middle"><?= $row->contact ?></td>
                <td class="text-center">
                    <div class="list-group" style="border: none !important;">

                        <?php

                        while ($sbrow = mysqli_fetch_object($sublist)) {
                            ?>
                            <div class="list-group-item">
                                <div class="row">


                                    <div class="col-md-4">

                                        <?= $sbrow->classname ?>:

                                    </div>
                                    <div class="col-md-8">

                                        <?= $sbrow->subjdesc ?>(<?= $sbrow->type ?>)

                                    </div>

                                </div>

                            </div>


                            <?php
                        }
                        ?>

                    </div>

                </td>
                <td>

                </td>
            </tr>
            <?php
            $i++;
        }
        ?>
        </tbody>
    </table>
    <button onclick="window.print();" class="btn btn-primary">Print</button>
</div>
</body>
</html>
