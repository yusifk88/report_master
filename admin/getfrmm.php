<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\config;
$cfg = new config();
$cfg->connect();
$stfid = $_GET['id'];
$stfclasses = mysqli_query($cfg->con, "SELECT classes.classname,frmmaters.id from classes,frmmaters where frmmaters.stfid = '$stfid' and classes.id = frmmaters.clid");
while ($row2 = mysqli_fetch_object($stfclasses)) {
    ?>
    <tr>
        <td><?= $row2->classname; ?></td>
        <td><i onclick="remfrmm(<?= $row2->id; ?>)" style="cursor: pointer;" data-toggle="tooltip" title="Remove"
               class="fa fa-remove text-danger waves-effect waves-circle"></i></td>
    </tr>
    <?php
}