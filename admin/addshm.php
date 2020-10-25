<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\config;

$cf = new config();
$cf->connect();
$stfid = $_GET['id'];
$staff = mysqli_fetch_object(mysqli_query($cf->con, "select * from staff where id = '$stfid'"));
$status = mysqli_query($cf->con, "select * from shm where stfid = '$stfid'");
?>
<div class="row" style="border-bottom: 1px solid #ccc;">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <img src="<?= ($staff->photo) ? $staff->photo : 'objts/dpic/photo.jpg' ?>"
             class="img-responsive img-thumbnail img-rounded" alt="">
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <h4><?= strtoupper($staff->fname . " " . $staff->lname) ?></h4>

        <?php

        if (mysqli_num_rows($status) < 1) {
            ?>

            <button onclick="mkshm(<?= $stfid ?>)" type="button" class="btn bg-info waves-effect waves-light">Assign
                Duty
            </button>


            <?php


        } else {

            ?>
            <div class="alert alert-info">This staff is already the senior house master.</div>

            <button onclick="rmshm(<?= $stfid ?>)" type="button" class="btn btn-danger waves-effect waves-light">
                Unassign Duty
            </button>

            <?php
        }
        ?>

    </div>
</div>

<script>


</script>
