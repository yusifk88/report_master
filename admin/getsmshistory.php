<?php
include_once("objts/config.php");
include_once("objts/utitlity.php");
$cf = new config();
$ut = new utitlity();
$cf->connect();
$history_list = mysqli_query($cf->con, "select distinct(ayear) as ayear from smsreport order by ayear");

?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="row">
                <?php
                while ($hrow = mysqli_fetch_object($history_list)) {
                    $ayear = $hrow->ayear;
                    $terms = mysqli_query($cf->con, "select distinct(term) from smsreport where ayear = '$ayear' order by term ASC ");
                    while ($row = mysqli_fetch_object($terms)) {
                        $term = $row->term;

                        $details = mysqli_query($cf->con, "select smsreport.*, classes.classname from smsreport,classes where ayear = '$ayear' and term = '$term' and smsreport.cls = classes.id");

                        ?>


                        <div class="col-lg-2 col-md-2 col-sm-2 col-3 text-center"
                             style="border-right: 1px solid #CCCCCC; height: 100%;">
                            <?= $ayear ?>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-3 text-center"
                             style="border-right: 1px solid #CCCCCC; vertical-align: middle;">
                            <?= $ut->addsufix($term) ?> Term
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-6">
                            <div class="list-group list-group-flush">
                                <?php
                                while ($drow = mysqli_fetch_object($details)) {
                                    ?>
                                    <div class="list-group-item">
                                        <strong><?= $drow->classname ?>:</strong> <?= $drow->status ?> <br>
                                        <span class="label label-success"><?= $drow->dentry ?></span>
                                    </div>
                                    <?php

                                }
                                ?>
                            </div>
                        </div>


                        <?php
                    }
                }
                ?>
            </div>
        </div>

    </div>
</div>