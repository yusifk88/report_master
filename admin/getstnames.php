<?php

include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$cls = $_GET['cls'];
$ayear = $_GET['acyear'];

$stn = mysqli_query("select id,fname,lname,oname from stuinfo where id in (select distinct(stid) from records where cls = '$cls' and acyear = '$ayear') order by fname ASC");
while ($row = mysqli_fetch_object($stn)) {

    ?>
    <option value="<?= $row->id; ?>"><?= $row->fname . ' ' . $row->lname . ' ' . $row->oname ?></option>


    <?php
}
