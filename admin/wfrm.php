<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\config;
$cf = new config();
$cf->connect();
$id = $_GET{"id"};
$stinfo = mysqli_query($cf->con, "select * from stuinfo where id = '$id'");
$stud = mysqli_fetch_object($stinfo);
?>
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-12 col-12">
        <img src="<?= file_exists($stud->photo) ? $stud->photo : 'objts/dpic/photo.jpg' ?>" alt="<?= $stud->fname ?>"
             class="img-thumbnail img-responsive" width="150" height="180"/> <br>
        <span class="text-muted text-uppercase"
              style="font-weight: bold"><?= $stud->fname . " " . $stud->lname . " " . $stud->oname ?></span>
    </div>

    <div class="col-lg-9 col-md-9 col-sm-12 col-12">
        <form id="wfrm">
            <input name="wstid" type="hidden" value="<?= $id ?>" id="wstid"/>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-xs-12">
                    <div class="md-form">
                        <label class="control-label active" for="wayear">Academic Year</label>
                        <input name="wayear" type="text" readonly id="wayear" class="form-control"
                               value="<?= $stud->ayear ?>"/>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-xs-12">
                    <label class="control-label">Term</label>
                    <select class="form-control" name="wterm">
                        <option value="1">1st Term</option>
                        <option value="2">2nd Term</option>
                        <option value="3">3rd Term</option>
                    </select>
                </div>
                <div class="col-lg-4 col-md-4 col-xs-12">
                    <div class="md-form">
                        <input name="wdate" id="wdate" type="date" class="form-control"/>
                        <label class="control-label active" for="wdate">Date</label>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12">
                    <div class="md-form">
                        <label class="control-label text-muted" for="wresn">Reason (Why you are withdrawing this
                            student)</label>
                        <textarea name="wresn" class="form-control md-textarea" id="wresn" rows="2"></textarea>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>
<script>
    $(document).ready(function () {


        $("#wfrm").submit(function () {
            fullProg();
            var data = $("form#wfrm :input").serializeArray();
            $.post("wsave.php", data, function () {
                Snarl.addNotification({
                    title: "WITHDRAW",
                    text: "Student Withdrawn successfully",
                    icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle-o'></i>",
                    timeout: 3000
                });
                $(".snarl-notification").addClass('snarl-success');
                reInit();


            });
            return false;
        });
    });
</script>