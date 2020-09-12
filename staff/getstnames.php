<?php

include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$cls = $_GET['cls'];

$stn = mysqli_query("select id,fname,lname,oname from stuinfo where id in (select distinct(stid) from records where cls = '$cls')");
while ($row = mysqli_fetch_object($stn)) {

    ?>
    <option value="<?= $row->id; ?>"><?= $row->fname . ' ' . $row->lname . ' ' . $row->oname ?></option>


    <?php
}
