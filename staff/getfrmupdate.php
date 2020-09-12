<?php
include_once '../admin/objts/config.php';
include_once '../admin/objts/school.php';
include_once '../admin/objts/utitlity.php';
$ut = new utitlity();
$sch = new school();
$cf = new config();
$cf->connect();
$id = $_GET['id'];
$stid = $_GET['stid'];
$term = $_GET['term'];
$ayear = $_GET['ayear'];
$frmrec = mysqli_query($cf->con, "select frmass.id,frmass.attdance,frmass.attnded,frmass.cnduct,frmass.attitude,frmass.interest,frmass.remark,stuinfo.fname,stuinfo.lname,stuinfo.oname,stuinfo.photo from frmass,stuinfo WHERE frmass.id = '$id' and frmass.stid = stuinfo.id");
//$stass = mysqli_query($cf->con,"select subjects.subjdesc,records.totlscore,records.grd from subjects,records where records.subjt = subjects.id and records.term = '$term' and records.acyear = '$ayear' and records.stid = '$stid'");
$stass = mysqli_query($cf->con, "select subjects.subjdesc,((subtotl*$sch->clscore_ratio)/$sch->sba+(exam*($sch->exam_ratio/100))) as tscore from subjects,records where records.subjt = subjects.id and records.term = '$term' and records.acyear = '$ayear' and records.stid = '$stid'");
$rec = mysqli_fetch_object($frmrec);
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="panel panel-info" style="border-radius: 0; box-shadow: none; margin: 0 !important;">
            <div class="panel-body">
                <form id="frmaddfrm">
                    <input type="hidden" value="<?= $rec->id; ?>" id="upfrmid"/>
                    <div class="row">
                        <div class="col-lg-2 col-md-2 co-sm-12 col-xs-12 text-center">
                            <img src="<?= file_exists('../admin/'.$rec->photo)? '../admin/'.$rec->photo : '../admin/objts/dpic/photo.jpg' ; ?>" width="150" height="180" class="img-thumbnail"/>
                            <br>
                            <strong class="text-muted"><?= $rec->fname . " " . $rec->lname . " " . $rec->oname ?></strong>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="md-form">
                                    <input value="<?= $rec->attdance ?>" id="upfrmattndance" required class="form-control" type="text" name="attndance" placeholder="Enter total attendance for the term"/>
                                    <label for="attndance" class="control-label active">Total Attendance</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="md-form">
                                        <input value="<?= $rec->attnded ?>" id="upfrmattnded" required class="form-control" type="number" name="attnded" placeholder="Enter number of days student attended"/>
                                        <label for="attnded" class="control-label active">Total Attended</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="md-form">
                                        <textarea required class="form-control md-textarea" name="cnduct" id="upfrmcnduct" rows="1"><?= $rec->cnduct; ?></textarea>
                                        <label class="control-label active">Conduct</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="md-form">
                                        <textarea required name="interest" class="form-control md-textarea" id="upfrminterest" rows="1"><?= $rec->interest ?></textarea>
                                        <label class="control-label active">Interest</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="md-form">
                                        <textarea required name="remark" class="form-control md-textarea" id="upfrmremark" rows="1"><?= $rec->remark ?></textarea>
                                        <label for="upfrmremark" class="control-label active">Your Remark</label>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm12 col-xs-12">
                            <div class="well well-sm" style="padding: 1px !important;  margin: 0 !important;">
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped table-hover  text-dark">
                                        <thead>
                                        <tr>
                                            <th>Subject</th>
                                            <th>Score</th>
                                            <th>Grade</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        while ($assesrec = mysqli_fetch_object($stass)) {
                                            ?>
                                            <tr>
                                                <td><?= $assesrec->subjdesc ?></td>
                                                <td><?= number_format($assesrec->tscore, 1) ?></td>
                                                <td><?= $ut->getgrd(number_format($assesrec->tscore, 1)) ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>
<script>

    $("#upfrmattndance,#upfrmattnded").keypress(function (e) {
        if (!((e.which >= 47 && e.which <= 58) || e.which === 8 || e.which === 0)) {
            e.preventDefault();
        }
    });
</script>