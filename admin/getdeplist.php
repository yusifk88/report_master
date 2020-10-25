<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');

use APP\config;

$cf = new config();
$cf->connect();

$deplist = mysqli_query($cf->con, "select id,depname from dept");
while ($row = mysqli_fetch_object($deplist)) {
    ?>

    <option value="<?= $row->id; ?>"><?= $row->depname; ?></option>


    <?php

}