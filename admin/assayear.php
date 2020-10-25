<?php
/**
 * Created by PhpStorm.
 * User: Godson
 * Date: 5/29/2017
 * Time: 2:16 AM
 */

require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\config;

$cf = new config();
$cf->connect();

$ayears = mysqli_query($cf->con, "select distinct(ayear) from stuinfo where ayear not in(select distinct(acyear) from records) ORDER BY ayear DESC");

$ayears2 = mysqli_query($cf->con, "select distinct(acyear) from records");


while ($row = mysqli_fetch_object($ayears)) {
    ?>
    <option><?= $row->ayear ?></option>

    <?php
}

while ($row = mysqli_fetch_object($ayears2)) {
    ?>
    <option><?= $row->acyear ?></option>


    <?php
}