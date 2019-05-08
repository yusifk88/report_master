<?php
include_once("objts/config.php");
include_once("objts/utitlity.php");
$cf = new config();
$ut = new utitlity();
$cf->connect();
$history_list = mysqli_query($cf->con,"select distinct(ayear) as ayear from smsnotif order by ayear");
while($hrow = mysqli_fetch_object($history_list)){
    $ayear = $hrow->ayear;
    $terms = mysqli_query($cf->con,"select distinct(term) from smsnotif where ayear = '$ayear' order by term ASC ");
    ?>
    <div class="card">
        <div class="card-body">
    <?php
    while($row = mysqli_fetch_object($terms)){
        $term = $row->term;
        $details = mysqli_query($cf->con,"select smsnotif.*, classes.classname from smsnotif,classes where ayear = '$ayear' and term = '$term' and smsnotif.cls = classes.id");
        ?>
        <div class="row" style="margin-top: 2px;">
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 text-center" style="border-right: 1px solid #CCCCCC; height: 100%;">
                            <?=$ayear?>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 text-center" style="border-right: 1px solid #CCCCCC; vertical-align: middle;">
                            <?=$ut->addsufix($term)?> Term
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <div class="list-group list-group-flush">
                                <?php
                                while($drow = mysqli_fetch_object($details)){
                                    ?>
                                    <div class="list-group-item font-small">
                                        <strong>Message:</strong><?=$drow->msg?> <br>
                                        <strong><?=$drow->classname?>:</strong> <?=$drow->status?> <br>
                                        <span class="label label-success"><?=$drow->dentry?></span>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                    </div>

        </div>
        <?php
    }
    ?>
        </div>
    </div>
        <?php

}