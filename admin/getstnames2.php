<?php

include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$cls = $_GET['cls'];
$comyear = $_GET['year'];

$stn = mysqli_query("select id,fname,lname,oname from stuinfo where class = '$cls' and ayear = '$comyear' order by fname ASC");
while ($row = mysqli_fetch_object($stn)) {

    ?>
    <option value="<?= $row->id; ?>"><?= $row->fname . ' ' . $row->lname . ' ' . $row->oname ?></option>


    <?php
}
