<!DOCTYPE html>
<?php
include("check_session.php");
include_once './objts/utitlity.php';
include_once './objts/config.php';
include_once './objts/school.php';
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
    $id = $_GET['id'];
    $stprof = mysqli_query($cfg->con, "select jhsno,shsno,stuinfo.id,fname,oname,lname,stindex,form,classes.classname,dept.depname,dob,dor,ffname,fhometown,ftel,gender,ayear,houses.des,houses.name,lschool,mfname,mhometown,mtel,photo,(select name from houses where id = stuinfo.ghouse) as ghouse from stuinfo,classes,dept,houses where stuinfo.class = classes.id and stuinfo.dept = dept.id and stuinfo.house = houses.id and stuinfo.id = '$id'");

    $librec = mysqli_query($cfg->con, "select books.title,books_lend.* from books,books_lend where books_lend.stid = '$id' and books.id = books_lend.bid");
    $sch = new school();
    $exiat = mysqli_query($cfg->con, "select exiat.*,staff.fname as stfname, staff.lname as stlname,TIMESTAMPDIFF(HOUR,return_date,returned_time) as duedays from exiat,staff,stuinfo WHERE exiat.stfid = staff.id and exiat.stid = stuinfo.id and returned = 1 and exiat.stid = '$id' and return_date < NOW() order by returned_time asc LIMIT 0, 50");
    while ($row = mysqli_fetch_assoc($stprof)) {
        ?>
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <img style="margin: 10px;" class="img-responsive" src="objts/<?= $sch->logopath ?>" alt="School Crest"/>

            </div>
            <div class="col-lg-10 col-md-10">
                <center>
                    <u><span style="font-size: 25px; font-weight: bold;"><?= ucwords($sch->schname) ?></span><br/></u>
                    <span style="font-size: 20px;"><?= ucwords($sch->schooladdress) ?></span><br/>
                    <span style="font-size: 25px;">STUDENT'S PROFILE</span>

                </center>
            </div>
        </div>
        <table class="table table-striped">
            <tr>
                <td rowspan="6" style="text-align: center;">
                    <img src="<?php echo $row['photo']; ?> " alt="<?php $row['fname'] . " " . $row['oname'] ?>"
                         width="180" height="200"/>

                </td>
            </tr>
            <tr>
                <th>FULL NAME:</th>
                <td colspan="3"><?= strtoupper($row['fname'] . ' ' . $row['lname'] . ' ' . $row['oname']) ?></td>
                <th>REG. DATE:</th>
                <td colspan="2"><?= $row['dor'] ?></td>
            </tr>
            <tr>
                <th>ID NUMBER:</th>
                <td><?= $row['stindex']; ?></td>
                <th>GENDER:</th>
                <td><?= strtoupper($row['gender']); ?></td>
                <th>D.O.B:</th>
                <td><?= $row['dob']; ?></td>

            </tr>
            <tr>
                <th>PROGRAME:</th>
                <td><?= strtoupper($row['depname']); ?></td>
                <th>YEAR</th>
                <td><?= $row['ayear']; ?></td>
                <th>Gender House/Hall</th>
                <td><?= strtoupper($row['ghouse'] ? $row['ghouse'] : "None"); ?></td>

            </tr>

            <tr>
                <th>FORM:</th>
                <td><?= "FORM" . $row['form']; ?></td>
                <th>LAST SCH:</th>
                <td colspan="3"><?= strtoupper($row['lschool']); ?></td>

            </tr>
            <tr>
                <th>CLASS:</th>
                <td><?= strtoupper($row['classname']); ?></td>
                <th>HOUSE:</th>
                <td colspan="3"><?= strtoupper($row['name']); ?></td>

            </tr>
            <tr>
                <th>JHS NUMBER:</th>
                <td colspan="2"><?= $row['jhsno']; ?></td>
                <th>SHS NUMBER:</th>
                <td colspan="3"><?= $row['shsno']; ?></td>

            </tr>
            <tr>
                <th>FARTHER'S NAME:</th>
                <td colspan="6"><?= strtoupper($row['ffname']); ?></td>

            </tr>
            <tr>
                <th>FARTHER'S HOMETOWN:</th>
                <td colspan="6"><?= strtoupper($row['fhometown']); ?></td>
            </tr>
            <tr>
                <th>FARTHER'S CONTACT NO.:</th>
                <td colspan="6"><?= $row['ftel']; ?></td>

            </tr>

            <tr>
                <th>MOTHER'S NAME:</th>
                <td colspan="6"><?= strtoupper($row['mfname']); ?></td>

            </tr>
            <tr>
                <th>MOTHER'S HOMETOWN:</th>
                <td colspan="6"><?= strtoupper($row['mhometown']); ?></td>

            </tr>
            <tr>
                <th>MOTHER'S CONTACT NO.:</th>
                <td colspan="6"><?= $row['mtel']; ?></td>

            </tr>


        </table>
        <?php
    }
    $ut = new utitlity();
    $cmnt = mysqli_query($cfg->con, "select * from ginfo WHERE stid = '$id' order BY id DESC ");
    while ($c = mysqli_fetch_object($cmnt)) {
        ?>
        <div class="row" style="border-bottom: solid 1px #000;">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <strong>
                    On <?= $c->dentry ?>, <?= $c->ayear ?> Academic Year, <?= $ut->addsufix($c->term) ?> Term
                </strong><br>
                <?= $c->coment; ?>

            </div>
        </div>
        <?php
    }
    ?>


    <div class="row" style="page-break-before: always;">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <table class="table table-striped">
                <thead>

                <tr>
                    <th colspan="6" class="text-center"><H4>LIBRARY LOG</H4></th>
                </tr>
                <tr>
                    <th>S/N</th>
                    <th>Book Title</th>
                    <th>Lend Date</th>
                    <th>Expected Return Date</th>
                    <th>Return Status</th>
                    <th>Return Date</th>
                </tr>
                </thead>

                <tbody>
                <?php
                $i = 1;
                while ($row = mysqli_fetch_object($librec)) {
                    ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $row->title ?></td>
                        <td><?= $row->lenddate ?></td>
                        <td><?= $row->returndate ?></td>
                        <td><?= $row->returned ? "Returned" : "Not Returned" ?></td>
                        <td><?= $row->date_returned ?></td>
                    </tr>
                    <?php
                    $i++;
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

            <?php

                if (count($exiat)>0){
                ?>
                    <div class="row">
                        <div class="col-md-12">
                            <h3>EXEAT HISTORY</h3>
                            <div class="list-group">
                             <?php
                                 while($exiat_row = mysqli_fetch_object($exiat)){
                                        ?>
        <div class="list-group-item">
            <div class="row">
                <div class="col-md-4">
                    <?=$exiat_row->date_signed?> <strong>To</strong>  <?=$exiat_row->return_date?>
                </div>
                <div class="col-md-4">
                    <?=$exiat_row->reason?>
                </div>
                <div class="col-md-4">
                    <strong>Exeat Type: </strong><?=$exiat_row->ex_type == 'in'?'Internal Exeat':'External Exeat'?> <br> <strong>Returned Date/Time</strong> <?=$exiat_row->returned_time?> <strong>Authorized By:</strong>
                    <a onclick="printstf(<?=$exiat_row->stfid?>); return false;" href=""><?=$exiat_row->stfname. ' ' .$exiat_row->stlname?></a>
                    | <small class="text-danger"><?=$exiat_row->duedays?> Hours Late</small>
                    <br>
                    <small>
                    <strong>Remarks:</strong> <?=$exiat_row->remark?>
                    </small>

                </div>
            </div>
        </div>
              <?php
                  }
               ?>
             </div>
            </div>
            </div>
                  <?php
                }
                ?>
    <button type='button' class='btn btn-primary btn-sm pull-right hidden-print' onclick='window.print();'>Print
    </button>
</div>
<script src="./js/wejs.js"></script>
</body>
</html>
