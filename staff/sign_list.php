<?php
include_once './objts/school.php';
include_once 'objts/config.php';
$cf = new config();
$cf->connect();
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
    $cls_list = mysqli_query("select fname,oname,lname,photo,gender,fhometown,mhometown from stuinfo where class = '$cls' and ayear = '$ayear' and dept = '$prog' order by fname ASC ");
    $sch = new school();
    $clas = mysqli_query("select classname from classes where id = '$cls'");
    $cl = mysql_result($clas, 0);
    $progrm = mysql_result(mysqli_query("select depname from dept where id = '$prog'"), 0);


    ?>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <img class="img-responsive" src="objts/<?= $sch->logopath ?>" alt="School Crest"/>


        </div>
        <div class="col-lg-10 col-md-10">
            <center>
                <u><span style="font-size: 25px; font-weight: bold;"><?= ucwords($sch->schname) ?></span><br/></u>
                <span style="font-size: 10px;"><?= ucwords($sch->schooladdress) ?></span><br/>
                <span style="font-size: 23px;">SIGN LIST BY CLASSES FOR <?= $ayear; ?> ACADEMIC YEAR </span> <br/>
                <span style="font-size: 23px;">CLASS: <?= $progrm . '/' . $cl ?> </span>


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
                FULL NAME
            </th>
            <th style="text-align: center;">
                FATHER'S <br/> HOME TOWN
            </th>

            <th style="text-align: center;">
                MOTHER'S <br/> HOME TOWN
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

            <th style="text-align: center;">
                REMARKS
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
                <td style="vertical-align: middle; text-align: center;"><?= $row->fname . ' ' . $row->lname . ' ' . $row->oname; ?></td>
                <td style="vertical-align: middle; text-align: center;"><?= $row->fhometown; ?></td>
                <td style="vertical-align: middle; text-align: center;"><?= $row->mhometown; ?></td>
                <td style="vertical-align: middle; text-align: center;"><?= $row->gender; ?></td>
                <td style="vertical-align: middle; text-align: center;"><?= $rate; ?></td>
                <td style="vertical-align: middle;">............................</td>
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
