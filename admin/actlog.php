<?php
ini_set("max_execution_time",300);

include("check_session.php");
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');


$cf = new \APP\config();
$sch = new \APP\school();
$limit = $_GET['limit'];
$cf->connect();
$log_list = mysqli_query($cf->con,"select user_log.*,staff.fname,staff.lname from user_log,staff where user_log.uid = staff.id order by datetime_entry desc limit 0 ,".$limit);
if (!$log_list){
    die();
}
$num = mysqli_num_rows($log_list);
?>
<html>
<head>
    <meta charset="UTF-8">

    <link href="css/bootstrap-print.css" rel="stylesheet" type="text/css"/>
    <script src='js/wejs.js' type="text/javascript"></script>
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
    <div class="row text-center" style="border-bottom: 1px solid #000">
        <h2><?= $sch->schname ?></h2>
        <h4><?= $sch->schooladdress ?></h4>
        <h3>System User Activity Log Sheet</h3>
        Generated as at <?= date("d-M-Y", time()) ?>
        </h4>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <button class="btn btn-primary hidden-print" onclick="window.print();">Print</button>
            <br>
            <table class="table table-striped table-condensed">
                <thead>
                <tr>
                    <th class="text-center">S/N</th>
                    <th>Staff Name</th>
                    <th>Action</th>
                    <th>Time</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 1;
                while ($row = mysqli_fetch_object($log_list)) {
                    ?>
                    <tr>
                        <td class="text-center" style="vertical-align: middle"><?= $i ?></td>
                        <td style="vertical-align: middle">
                            <a href=""onclick='printstf(<?= $row->uid ?>); return false'><?= $row->fname ?> <?= $row->lname ?><a/>
                        </td>
                        <td>
                            <small>
                                <?=$row->action?>
                            </small>
                        </td>
                        <td>
                            <small>
                                <?=$row->datetime_entry?>
                            </small>
                        </td>

                    </tr>
                    <?php
                    $i++;
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-4">
            <?php

                if($i >= $limit){
                    $new_limit = $limit+500;
                    ?>
                    <a href="actlog.php?limit=<?=$new_limit?>" class="btn btn-primary btn-lg hidden-print">Load More</a>
                    <?php
                }

            ?>
            <button class="btn btn-primary hidden-print" onclick="window.print();">Print</button>
        </div>
    </div>
</div>
</body>
</html>