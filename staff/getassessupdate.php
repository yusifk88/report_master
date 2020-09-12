<?php
include_once './objts/config.php';
$cfg = new config();
$cfg->connect();
$id = $_GET['id'];
$rcs = mysqli_query($cfg->con, "select records.id,stid,stuinfo.photo,stuinfo.fname,stuinfo.lname,stuinfo.oname,ta1,ta2,ta3,ta4,hw1,hw2,hw3,hw4,pw1,pw2,exam from records,stuinfo where records.id = '$id' and stuinfo.id=records.stid");
while ($row = mysqli_fetch_object($rcs)) {
    ?>
            <form id="ass_updateform" method="post" action="up_assess.php" class="row">
                <input type="hidden" id="up-id" value="<?= $row->id; ?>"
                <div class="row">
                    <div class="col-md-10 col-sm-12 col-12" style="border-right: 1px solid #ccc;">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                <label for="stname" class="control-label text-muted">Student's Name</label>
                                <input style="color:red; font-weight: bold;" name="" readonly="true" type="text"
                                       class="form-control"
                                       value="<?= $row->fname . " " . $row->lname . " " . $row->oname ?>"/>
                            </div>
                        </div>
                        <div class="row" style="border-bottom: 1px solid #ccc;">
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <strong>Class Task:</strong>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                                <label for="up-ta1" class="control-label text-muted">One</label>
                                <input min="0" id="up-ta1" class="form-control" type="number" name="ta1"
                                       value="<?= $row->ta1; ?>"/>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                                <label for="up-ta2" class="control-label text-muted"> Two</label>
                                <input min="0" id="up-ta2" class="form-control" type="number" name="ta2"
                                       value="<?= $row->ta2; ?>"/>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                                <label for="up-ta3" class="control-label text-muted">Three</label>
                                <input min="0" id="up-ta3" class="form-control" type="number" name="ta3"
                                       value="<?= $row->ta3; ?>"/>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                                <label for="up-ta4" class="control-label text-muted">Four</label>
                                <input min="0" id="up-ta4" class="form-control" type="number" name="ta4"
                                       value="<?= $row->ta4; ?>"/>
                            </div>
                        </div>
                        <div class="row" style="border-bottom: 1px solid #ccc;">
                            <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                                <strong>Assignment</strong>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                                <label for="up-hw1" class="control-label text-muted">One</label>
                                <input min="0" id="up-hw1" class="form-control" type="number" name="hw1"
                                       value="<?= $row->hw1; ?>"/>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                                <label for="up-hw2" class="control-label text-muted">Two</label>
                                <input min="0" id="up-hw2" class="form-control" type="number" name="hw2"
                                       value="<?= $row->hw2; ?>"/>
                           </div>
                            <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                                <label for="up-hw3" class="control-label text-muted">Three</label>
                                <input min="0" id="up-hw3" class="form-control" type="number" name="hw3"
                                       value="<?= $row->hw3; ?>"/>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                                <label for="up-hw4" class="control-label text-muted">Four</label>
                                <input min="0" id="up-hw4" class="form-control" type="number" name="hw4"
                                       value="<?= $row->hw4; ?>"/>
                            </div>
                        </div>
                        <div class="row"  style="border-bottom: 1px solid #ccc;">
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                    <strong>Project Work:</strong>
                                </div>
                                <div class="col-lg-5 col-md-5 col-sm-4 col-12">
                                    <label for="up-pw1" class="control-label text-muted">Project W. One</label>
                                    <input min="0" id="up-pw1"  class="form-control" type="number" name="pw1" value="<?= $row->pw1; ?>" />
                                </div>
                                <div class="col-lg-5 col-md-5 col-sm-4 col-12">
                                    <label for="up-pw2" class="control-label text-muted">Project W. Two</label>
                                    <input min="0" id="up-pw2" class="form-control"  type="number" name="pw2" value="<?= $row->pw2; ?>" />
                                </div>
                            </div>
                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <strong>Exam:</strong>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-5 col-12">
                                <label for="up-exam" class="control-label text-muted">Exam(100%)</label>
                                <input min="0" id="up-exam" class="form-control" type="number" name="exam"
                                       value="<?= $row->exam; ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12 col-12">
                        <img src="<?= file_exists('../admin/'.$row->photo) ? '../admin/'.$row->photo : '../admin/objts/dpic/photo.jpg' ; ?>" class="img-fluid"/>
                    </div>
                </div>
            </form>

    <?php
}
?>
<script type="text/javascript">

    $(document).ready(function () {
        $("#ass_updateform :input").keypress(function (e) {
            if (!((e.which >= 47 && e.which <= 58) || e.which === 8 || e.which === 0)) {
                e.preventDefault();
            }
        });
    });

</script>