
<?php
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
$stafflist = mysqli_query($cg->con,"select staff.*,houses.name,houses.des from staff,houses,housem WHERE staff.id = housem.stfid and houses.id = housem.hid ORDER by fname ASC ");
?>
<html>
<head>
    <title>List Of Staff</title>
    <link href='css/bootstrap-print.css' rel='stylesheet' />
    <style type="text/css">
        table, th, tr, td{
            border:1px solid #000 !important;


        }

        #main_head{

            font-size:28px;
            font-weight: bold;


        }

        #sub_head{


            font-size:20px;
            font-weight: bold;


        }

        @media print{

            table, th, tr, td{
                border:1px solid #000 !important;


            }

        }
    </style>
</head>
<body>
<div class='container-fluid'>
    <div class='row'>
        <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
            <center>
                <u><span id='main_head'><?=$sch->schname;?></span></u>
                <br/><u><span id='sub_head'>LIST OF HOUSE MASTERS/MISTRESSES</span></u>
            </center>
        </div>
    </div>
    <table class="table">
        <thead>
            <th class="text-uppercase text-center">S/N</th>
            <th class="text-uppercase">Name</th>
            <th class="text-uppercase">Sex</th>
            <th class="text-uppercase">Contact</th>
            <th class="text-uppercase">House</th>
            <th class="text-uppercase">SIGN./COMMENT</th>

        </thead>
        <tbody>
<?php
    $i=1;
    while($row = mysqli_fetch_object($stafflist)){

     ?>
        <tr>
            <td class="text-center"><?=$i?></td>
            <td><?=$row->fname." ".$row->lname?></td>
            <td><?=$row->gender?></td>
            <td><?=$row->contact?></td>
            <td><?=$row->name?>(<?=$row->des?>)</td>
            <td></td>




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

