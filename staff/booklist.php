<?php
include_once("../admin/objts/school.php");
include_once("../admin/objts/config.php");
$sch = new school();
$cf  = new config();
$cf->connect();
$booklist = mysqli_query($cf->con,"select books.*,(select count(*) from books_lend WHERE bid = books.id and returned = false) as lcn from books order BY title ASC");
?>
<html>
    <head>
        <link href="../admin/css/bootstrap-print.css" rel="stylesheet">
        <style type="text/css">
            table th,table td, table tr{
                border:1px solid #000 !important;
                vertical-align: middle !important;
                }
                @media print{
                table, th, tr, td{
                    border:1px solid #000 !important; }
                *{-webkik-print-color-adjust:exact;}
                }
        </style>
        <title>List of books</title>
    </head>
<body>
<center>
    <h2><?=$sch->schname?></h2>
    <h5><?=$sch->schooladdress?></h5>
    <h3>LIST OF BOOKS IN SCHOOL LIBRARY</h3>
</center>
<hr>
<div class="container">
<table class="table table-condensed table-striped">
    <thead>
    <tr>
        <th>S/N</th>
        <th>Book title</th>
        <th>Author</th>
        <th>ISBN</th>
        <th>Shelf</th>
        <th>Other Description</th>
        <th class="text-center">Grand Copies</th>
        <th class="text-center">Available/Good copies</th>
        <th class="text-center">No. Damaged</th>
        <th class="text-center">No. Missing</th>
        <th class="text-center">No. Lent</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $i=1;
    $totalcopies =0;
    $total_goodcopies=0;
    $total_damagedcopies=0;
    $total_misngcopies=0;
    $total_numlent =0;
        while($brow = mysqli_fetch_object($booklist)){
            $acopies =$brow->copies - ($brow->numdamaged+$brow->nummising+$brow->lcn);
        ?>
        <tr>
            <td class="text-center"><?=$i?></td>
            <td><?=$brow->title?></td>
            <td><?=$brow->author?></td>
            <td><?=$brow->isbn?></td>
            <td><?=$brow->shelf?></td>
            <td><?=$brow->descrip?></td>
            <td class="text-center"><?=$brow->copies?></td>
            <td class="text-center"><?=$acopies?></td>
            <td class="text-center"><?=$brow->numdamaged?></td>
            <td class="text-center"><?=$brow->nummising?></td>
            <td class="text-center"><?=$brow->lcn?></td>
        </tr>

            <?php
            $totalcopies+=$brow->copies;
            $total_damagedcopies +=$brow->numdamaged;
            $total_misngcopies += $brow->nummising;
            $total_goodcopies+=$acopies;
            $total_numlent +=$brow->lcn;
        $i++;
        }

    ?>

    </tbody>
    <tfooter>


        <tr>
            <th class="text-center" colspan="6">
                TOTALS
            </th>
            <th class="text-center"><?=$totalcopies?></th>
            <th class="text-center"><?=$total_goodcopies?></th>
            <th class="text-center"><?=$total_damagedcopies?></th>
            <th class="text-center"><?=$total_misngcopies?></th>
            <th class="text-center"><?=$total_numlent?></th>
        </tr>
    </tfooter>
</table>

    <button class="btn btn-info hidden-print" onclick="window.print();">Print</button>

</div>
</body>
</html>
