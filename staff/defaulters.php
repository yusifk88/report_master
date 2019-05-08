<?php
include_once("../admin/objts/school.php");
include_once("../admin/objts/config.php");
$sch = new school();
$cf  = new config();
$cf->connect();
$booklist = mysqli_query($cf->con,"select books.*,stuinfo.fname,stuinfo.lname,stuinfo.oname,stuinfo.photo,stuinfo.id as stid,books_lend.* from books,stuinfo,books_lend where books_lend.stid=stuinfo.id and books_lend.bid = books.id and books_lend.returned = FALSE");
?>
<html>
<head>
    <link href="../admin/css/bootstrap-print.css" rel="stylesheet">
    <script src="../admin/js/jquery.min.js"></script>
    <script src="../admin/js/wejs.js"></script>

    <style type="text/css">
        table th,table td{
            border:1px solid #000 !important;
            vertical-align: middle !important;
        }
        @media print{
            table, th, tr, td{
                border:1px solid #000 !important; }

            *{-webkik-print-color-adjust:exact;}
        }
    </style>
    <title>List of Library Defaulters</title>
</head>
<body>
<center>
    <h2><?=$sch->schname?></h2>
    <h5><?=$sch->schooladdress?></h5>
    <u><h3 class="text-uppercase">List of Library Defaulters</h3></u>
</center>
<hr>
<div class="container">
    <table class="table table-condensed table-striped">
        <thead>
        <tr>
            <th>S/N</th>
            <th class="text-center">Photo</th>
            <th>Name</th>
            <th>Book</th>
            <th>Lend Date</th>
            <th>Expected Return Date</th>
            <th>Other Description</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i=1;
            while($row = mysqli_fetch_object($booklist)){
                ?>
                <tr>
             <td class="text-center"><?=$i?></td>
                    <td class="text-center">
                    <img height="90" width="80" src="../admin/<?= $row->photo ?>" alt="<?=$row->fname?>'s photo">
                    </td>
                    <td> <button onclick="printstud(<?=$row->stid?>)" class="btn btn-link"><?=$row->fname?> <?=$row->lname?> <?=$row->oname?> </button> </td>
                    <td><?=$row->title?></td>
                    <td><?=$row->lenddate?></td>
                    <td><?=$row->returndate?></td>
                    <td><?=$row->descrip?></td>
                </tr>
                <?php
            $i++;
            }
        ?>
        </tbody>
    </table>

    <button class="btn btn-info hidden-print" onclick="window.print();">Print</button>
</div>
</body>
</html>
