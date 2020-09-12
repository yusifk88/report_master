<?php
if ($_SESSION['stdob'] == $_SESSION['stpassword']) {
    ?>
    <div class="card rgba-orange-strong animated fadeInUp">
        <div class="card-body text-white">

            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4 text-center">
                    <i class="fa fa-warning fa-4x"></i>
                </div>
                <div class="col-lg-10 col-md-10 col-sm-12">
                    <h4>NOTE</h4>
                    You are currently using your defalt password, please change to a more secure and seceret password,
                    as it is a part of your bio-data people who know you very well can get to login as your with ease.
                    <br> <a href="./myprofile/#account" class="btn rgba-cyan-strong">Change my password</a>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
<div class="row mt-3">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card rgba-cyan-slight animated fadeInUp">
            <div class="card-header bg-transparent text-muted">
                <h5>YOUR PERFORMANCE AT A GLANCE</h5>
            </div>
            <div class="card-body" style="overflow-x: auto;">
                <div style="overflow-x: auto;">
                    <canvas id="perf_graph" style="width: 100%; height: 400px;"></canvas>
                </div>
            </div>
            <div class="card-footer rgba-cyan-strong text-white">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2 text-center">
                        <i class="fa fa-info-circle text-white fa-3x"></i>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                        The graph above is generated from accumulation of your marks, this can be used to assess your
                        general performance on all the subjects that you studeid.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card animated fadeInUp">
            <div class="card-header bg-white text-muted">
                <h5>ACADEMIC SUMMARY</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <div class="list-group-item list-group-item-info">
                        <i class="fa fa-clock-o pull-left fa-2x mr-3"></i>
                        You
                        did <?= ($numyears < 2) ? $numyears . 'Academic Year' : $numyears . ' Academic Years' ?>  <?= ($numterms < 2) ? $numterms . ' Term' : $numterms . ' Terms' ?>

                    </div>
                    <div class="list-group-item list-group-item-danger">
                        <i class="fa fa-retweet fa-2x pull-left mr-3"></i>
                        <h4>Form Master's Reports</h4>
                    </div>

                    <?php
                    foreach ($frmrecs as $frm) {
                        ?>
                        <div class="list-group-item">
                            <div class="row text-muted">
                                <div class="col-lg-1 col-md-1 col-sm-2 col-xs-2 text-center border-right">
                                    <i class="fa fa-check-square pull-left mt-3 text-info fa-2x"></i>
                                </div>
                                <div class="col-lg-11 col-md-11 col-sm-10 col-xs-10">
                                    <strong><?= $frm->ayear ?> (<?= $this->utility->addsufix($frm->term) ?>
                                        Term)</strong> <br>
                                    <strong>Attendance:</strong> <?= $frm->attdance ?> <strong>Out
                                        Of</strong> <?= $frm->attnded ?>
                                    <strong>Conduct:</strong> <?= $frm->cnduct ?>
                                    <strong>Interest</strong> <?= $frm->interest ?> <br>
                                    <strong>Remark</strong> <?= $frm->remark ?>

                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>


<?php
if (count($comments) > 0) {
    ?>
    <div class="row mt-4">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card animated fadeInUp">
                <div class="card-header bg-white text-muted">
                    <h5>COMMENTS ON YOUR PROFILE</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <?php
                        foreach ($comments as $cm) {
                            ?>
                            <div class="list-group-item ">
                                <div class="row">
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 rgba-cyan-strong text-white text-center">
                                        <i class="fa fa-comment fa-3x m-4"></i>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 bg-light text-muted">
                                        <strong><?= $this->utility->addsufix($cm->term) ?> TERM</strong>
                                        <strong><?= $cm->ayear ?></strong> <br>
                                        <?= $cm->coment ?>

                                    </div>
                                </div>
                            </div>
                            <?php
                        }

                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>

