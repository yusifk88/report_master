<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\config;
use APP\Utitlity;

$ut = new utitlity();
$cf = new config();
$cf->connect();

$id = $_GET['id'];


?>


<table class="table table-stripped">
    <thead>
    <tr>
        <th>S/N</th>
        <th>Comment</th>
        <th>Academic Year</th>
        <th>Term</th>
        <th>Date</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $cmts = mysqli_query($cf->con, "select * from ginfo where stid = '$id' order by id DESC ");

    $i = 1;
    while ($row = mysqli_fetch_object($cmts)) {


        ?>
        <tr id="tr_<?=$row->id;?>">
            <td ><?= $i; ?></td>
            <td><?= $row->coment; ?></td>
            <td><?= $row->ayear; ?></td>
            <td><?= $ut->addsufix($row->term); ?> Term</td>
            <td><?= $row->dentry; ?></td>
            <td style="text-align: center;">
                <i onclick="delcomm(<?= $row->id; ?>);"
               title="Delete this Comment"
               data-toggle="tooltip" style="color: red; cursor: pointer;"
               class="fa fa-remove waves-effect waves-circle"></i>
            </td>

        </tr>

        <?php
        $i++;
    }
    ?>

    </tbody>

</table>

