<?php
ini_set("max_execution_time",300);

include("check_session.php");
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');

use APP\Utitlity;
use APP\school;
use APP\config;
$ut = new utitlity();
$sch = new school();
$cg = new config();
$cg->connect();
include_once './objts/utitlity.php';
$util = new Utitlity();
$acyear = mysqli_fetch_object(mysqli_query($cg->con, "select distinct(ayear) from stuinfo ORDER by ayear DESC "));
$stafflist = mysqli_query($cg->con, "select * from staff WHERE  type <>'admin' ORDER by fname ASC ");
$ranklist = ["Senior Sup't", "Prin. Sup't", "Assist. Dir ii", "Assist. Dir I", "Dep. Dir.", "Dir. II", "Dir. I"];
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
                <br/><u><span
                            id='sub_head'>LIST OF TEACHING STAFF AND THEIR PARTICULARS- <?= $acyear->ayear ?></span></u>
            </center>
        </div>
    </div>
    <div class='row'>
        <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
            <table class='table table-striped table-condensed' style="font-size: 12px;">
                <thead>
                <tr class="hidden-print">
                    <th></th>
                    <th id="col1">
                        <button class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="col2">
                        <button onclick="rmcol('col2');" class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="col3">
                        <button onclick="rmcol('col3');" class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="col4">
                        <button onclick="rmcol('col4');" class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="col5">
                        <button onclick="rmcol('col5');" class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="col6">
                        <button onclick="rmcol('col6');" class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="col7">
                        <button onclick="rmcol('col7');" class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="col8">
                        <button onclick="rmcol('col8');" class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="col9">
                        <button onclick="rmcol('col9');" class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="col10">
                        <button onclick="rmcol('col10');" class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="col11">
                        <button onclick="rmcol('col11');" class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="col12">
                        <button onclick="rmcol('col12');" class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="col20">
                        <button onclick="rmcol('col20');" class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="col21">
                        <button onclick="rmcol('col21');" class="btn btn-xs btn-danger">X</button>
                    </th>
                </tr>

                <tr>
                    <th class="hidden-print"></th>
                    <th style="text-align: center">S/N</th>
                    <th id="col2">NAME
                    </td>
                    <th id="col3" style="text-align: center">DATE OF BIRTH</th>
                    <th id="col4" style="text-align: center">STAFF ID</th>
                    <th id="col5" style="text-align: center">REGISTERED NO.</th>
                    <th id="col6">RANK
                    </td>
                    <th id="col7">ACADEMIC QUALIFICATION</th>
                    <th id="col8">PROF. QUALIFICATION</th>
                    <th id="col9" style="text-align: center">FIRST APPOINTMENT</th>
                    <th id="col10" style="text-align: center">YEARS AT POST</th>
                    <th id="col11" style="text-align: center">SSNIT NO.</th>
                    <th id="col12" style="text-align: center">CONTACT NO.</th>
                    <th id="col20" style="text-align: center">ASSOCIATE BANK.</th>
                    <th id="col21" style="text-align: center">BANK ACCOUNT NO.</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 1;

                while ($staff = mysqli_fetch_object($stafflist)) {
                    $tday = date("Y-M-d");
                    $tyear = substr($tday, 0, 4);
                    $svyear = is_null($staff->assdate) ? $tyear : substr($staff->assdate, 0, 4);
                    $apyear = is_null($staff->appdate) ? $tyear : substr($staff->appdate, 0, 4);
                    $dbyear = is_null($staff->dob) ? $tyear : substr($staff->dob, 0, 4);
                    $dbyear += 60;
                    $dur = $tyear - $apyear;
                    $years = $tyear - $svyear;
                    $rank = is_numeric($staff->rank) ? $staff->rank : 0;
                    ?>
                    <tr>
                        <td class="hidden-print">
                            <button id="rmrow" class="btn btn-xs btn-danger">X</button>
                        </td>
                        <td class="indexcol" style="text-align: center"><?= $i ?></td>
                        <td id="col2"><?= strtoupper($staff->fname . " " . $staff->lname) ?></td>
                        <td id="col3" style="text-align: center"><?= $staff->dob ?></td>
                        <td id="col4" style="text-align: center"><?= $staff->stfid ?></td>
                        <td id="col5" style="text-align: center"><?= $staff->regno ?></td>
                        <td id="col6"><?= strtoupper($ranklist[$rank]) ?></td>
                        <td id="col7"><?= strtoupper($staff->aqual) ?></td>
                        <td id="col8"><?= strtoupper($staff->pqual) ?></td>
                        <td id="col9" style="text-align: center"><?= $staff->appdate ?></td>
                        <td id="col10" style="text-align: center"><?= $years ?> Years</td>
                        <td id="col11" style="text-align: center"><?= $staff->snnid ?></td>
                        <td id="col12" style="text-align: center"><?= $staff->contact ?></td>
                        <td id="col20" style="text-align: center"><?= $staff->bank ?></td>
                        <td id="col21" style="text-align: center"><?= $staff->accno ?></td>
                    </tr>


                    <?php

                    $i++;
                }


                ?>


                </tbody>

            </table>

        </div>

    </div>


    <button type='button' class='btn btn-primary btn-sm pull-right hidden-print' onclick='window.print();'>Print
    </button>

</div>
<script src="js/jquery.min.js"></script>

<script>
    $(document).ready(function () {
        $("button#rmrow").click(function () {
            $(this).parent().parent().remove();
            for (var i = 0; i < $(".indexcol").length; i++) {

                var el = $(".indexcol")[i];
                el.innerHTML = (i + 1);
            }
        });
    });

    function rmcol(colid) {
        var tdid = 'td#' + colid;
        var thid = 'th#' + colid;
        $(tdid).remove();
        $(thid).remove();
    }

</script>
</body>
</html>