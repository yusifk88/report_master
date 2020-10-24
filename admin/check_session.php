<?php
session_start();
if (!$_SESSION['ad_id']) {
    ?>
    <center><h1 style="color: red;">Your login session can't be found please login again to view this document</h1>
    </center>

    <?php
    exit(0);

}