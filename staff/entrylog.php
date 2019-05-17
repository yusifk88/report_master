<?php
ini_set("max_execution_time",300);
include("check_session.php");
include_once '../admin/objts/school.php';
include_once '../admin/objts/config.php';
include_once '../admin/objts/utitlity.php';
$ut = new utitlity();
$cf = new config();
$sch = new school();
$year = $_GET['year'];
$term = $_GET['term'];
$cf->connect();
$staff_list = mysqli_query($cf->con, "select staff.fname,staff.lname,classes.classname,subjects.subjdesc,subas.*,(SELECT count(id) from stuinfo where class = clid and ayear = '$year') as class_pop,
                                    (SELECT COUNT(stid) from records WHERE cls = clid and term = '$term' and acyear = '$year' and subjt = subid and stid in(select id from stuinfo where ayear = '$year' and class = clid)) as entry_pop,
									(SELECT COUNT(stid) from records WHERE cls = clid and term = '$term' and acyear = '$year' and subjt = subid AND exam >0) as exam_pop,
                                    (SELECT COUNT(stid) from records WHERE cls = clid and term = '$term' and acyear = '$year' and subjt = subid and subtotl>0) as ex_pop,
									(SELECT COUNT(stid) from records WHERE cls = clid and term = '$term' and acyear = '$year' and subjt = subid and (ta1+ta2+ta3+ta4)>0) as test_pop,
									(SELECT COUNT(stid) from records WHERE cls = clid and term = '$term' and acyear = '$year' and subjt = subid and (hw1+hw2+hw3+hw4)>0) as classex_pop  
									 from staff,classes,subjects,subas WHERE subas.stfid = staff.id and subas.clid = classes.id and subas.subid = subjects.id and staff.user_type = 'staff' ORDER by fname");

?>
<html>
<head>
    <meta charset="UTF-8">

    <link href="../admin/css/bootstrap-print.css" rel="stylesheet" type="text/css"/>
    <script src='../admin/js/wejs.js' type="text/javascript"></script>
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
        <h3>Staff Record Entry log</h3>
        <h4><?= $ut->addsufix($term) ?> Term, <?= $year ?> Academic Year. <br>
            Generated as at <?= date("d/M/Y", time()) ?>
        </h4>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <br>
            <table class="table table-striped table-condensed">
                <thead>
                <tr>
                    <th class="text-center">S/N</th>
                    <th>Staff Name</th>
                    <th>Class</th>
                    <th>Subject</th>
                    <th class="text-center">Entry Level</th>
                    <th class="text-center">Percentage</th>
                    <th>Detailed Analysis</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 1;
                while ($row = mysqli_fetch_object($staff_list)) {
                    ?>
                    <tr>
                        <td class="text-center" style="vertical-align: middle"><?= $i ?></td>
                        <td style="vertical-align: middle"><a href=""
                                                              onclick='printstf(<?= $row->stfid ?>); return false'><?= $row->fname ?> <?= $row->lname ?>
                                <a/></td>
                        <td style="vertical-align: middle"><?= $row->classname ?></td>
                        <td style="vertical-align: middle"><?= $row->subjdesc ?></td>
                        <td class="text-center" style="vertical-align: middle"><?= $row->entry_pop ?> Out
                            Of <?= $row->class_pop ?></td>
                        <td class="text-center"
                            style="vertical-align: middle"><?= $row->class_pop < 1 ? "-" : number_format(($row->entry_pop / $row->class_pop) * 100, 1) ?>
                            %
                        </td>
                        <td>
                            No. of class task entered:<?= $row->test_pop ?> <br>
                            No. of assignment entered:<?= $row->classex_pop ?> <br>
                            No. of exam records entered: <?= $row->exam_pop ?>
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
</div>
</body>
</html>