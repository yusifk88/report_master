<?php

require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\config;

$cf = new config();
$cf->connect();

$id = $_GET['id'];
$data = mysqli_query($cf->con, "select subjects.subjdesc,classes.classname,subas.id from subjects,classes,subas  where subas.stfid ='$id' and subas.clid=classes.id and subjects.id=subas.subid");


while ($row = mysqli_fetch_assoc($data)) {
    ?>
    <tr id="sub_<?= $row['id'] ?>">

        <td>
            <?php
            echo $row['subjdesc'];
            ?>
        </td>
        <td>
            <?php
            echo $row['classname'];
            ?>
        </td>

        <td><i class="fa fa-chain-broken rmsub btn btn-danger btn-sm" title="Unasign this subject"
               data-del="delsubj.php" onclick="rmsub(<?= $id ?>,<?= $row['id'] ?>)"
               style="color: #F00; cursor: pointer;"></i></td>

    </tr>
    <?php
}
?>