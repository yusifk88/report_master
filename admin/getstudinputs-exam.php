<?php
include_once './objts/config.php';
$cf = new config();
$cf->connect();
$cls = $_GET['cls'];
$ayear = $_GET['ayear'];
$term = $_GET['term'];
$subjt = $_GET['subjt'];
$stid = $_GET['stid'];
$per_page = 1;
//$page_query = mysqli_query("select count(*) from stuinfo where class='$cls' and");
$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $per_page;
$cnsql = mysqli_query($cf->con, "select id,fname,lname,oname,photo from stuinfo where class='$cls'and id like '%$stid%' and  id  not in (select stid from records  where exam >0 and acyear = '$ayear' and term = '$term' and subjt = '$subjt' and cls = '$cls' ) and id not in(SELECT stid from withdraw)");
$stinputs = mysqli_query($cf->con, "select id,fname,lname,oname,photo from stuinfo where class='$cls' and id like '%$stid%' and id not in (select stid from records where exam >0 and acyear = '$ayear' and term = '$term' and subjt = '$subjt' and cls = '$cls') and id not in(SELECT stid from withdraw) order by fname ASC LIMIT " . $start . "," . $per_page);
$recount = mysqli_num_rows($cnsql);
$pages = ceil($recount / $per_page);
$stnames = mysqli_query($cf->con, "select id,fname,lname,oname,photo from stuinfo where class='$cls' and id not in (select stid from records where exam >0 and acyear = '$ayear' and term = '$term' and subjt = '$subjt' and cls = '$cls') and id not in(SELECT stid from withdraw) order by fname ASC");

if (mysqli_num_rows($stinputs) > 0) {

    while ($row = mysqli_fetch_assoc($stinputs)) {

        ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-info" style="border-radius: 0;">
                    <div class="panel-body">
                        <form id="cls-examform">
                            <input type="hidden" value="<?= $row['id'] ?>" id="stid4"/>
                            <br>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <button onclick="skipstud4(1);" class="btn btn-good waves-effect pull-right">Reset
                                        <i class="fa fa-undo"></i></button>
                                </div>

                                <div class="col-lg-8 col-md-8  col-sm-8 col-xs-8">
                                    <label class="control-label">Select Student</label>
                                    <select id="stname" class="form-control">
                                        <option value="">Select Student</option>
                                        <?php
                                        while ($strow = mysqli_fetch_object($stnames)) {
                                            ?>
                                            <option value="<?= $strow->id ?>"><?= $strow->fname . " " . $strow->lname . " " . $strow->oname ?></option>
                                            <?php
                                        }
                                        ?>

                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-2 col-md-2 co-sm-4 col-xs-4">
                                    <img src="<?= $row['photo']; ?>" width="180" height="200" class="img-thumbnail"/>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-8">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <label class="control-label">Full Name</label>
                                            <input style="font-weight: bold; color: red;" class="form-control"
                                                   type="text"
                                                   value=" <?= $row['fname'] . " " . $row['lname'] . " " . $row['oname']; ?>"
                                                   readonly=""/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            <br/>
                                            <label class="control-label">Exam Score(100%)</label>
                                            <input autofocus maxlength="3" style="text-align: center" id="exam_val"
                                                   class="form-control" type="number" value="0"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>

                    <div class="panel-footer clsfooter">
                        <input type="hidden" value="<?= $page ?>" id="nexval"/>

                        <?php


                        $next = $page + 1;
                        $prev = $page - 1;
                        if ($page > 1) {
                            ?>

                            <button id="skipbtn" onclick="skipstud4(<?= $prev ?>)" type="button"
                                    class="btn btn-good waves-effect waves-button pull-left">&les;&les; Back
                            </button>
                            <?php

                        }

                        ?>
                        <span class="text-success"> <i class="fa fa-info-circle"></i> <strong>NOTE.</strong>Please enter raw exam score </span>

                        <?php
                        // echo 'term:'. $term."year:".$ayear."sub:".$subjt."cls:".$cls;

                        if ($page < $pages) {

                            ?>

                            <button id="skipbtn2" onclick="skipstud4(<?= $next ?>)" type="button"
                                    class="btn btn-good waves-effect waves-button pull-right">Skip &GreaterGreater;
                            </button>
                            <input type="hidden" value="notend" id="endval2"/>

                            <?php

                        } else {
                            ?>

                            <input type="hidden" value="end" id="endval2"/>

                            <?php
                        }
                        ?>
                    </div>
                    </form>
                </div>
            </div>

        </div>

        <?php
    }
} else {
    ?>
    <h2 class="text-muted"><span class="glyphicon glyphicon-warning-sign"></span>Sorry, no records found, this could be
        because Exam records on all students in this class were recorded or no student exist in the selected class </h2>
    <?php

}

?>


<script>


    function skipstud4(page) {
        var sid = $("#stname").val();
        $.get("getstudinputs-exam.php?page=" + page + "&cls=" + $("#assess_class").val() + "&ayear=" + $("#assess-ayear").val() + "&term=" + $("#assess-term").val() + "&subjt=" + $("#assess-subjt").val() + "&stid=" + sid, function (data) {
            $("#exam-cont").hide();
            $("#exam-cont").html(data);
            $("#exam-cont").fadeIn(100);
        });
    }

    function savexam() {
        var stid = $("#stid4").val();
        var exam = $("#exam_val").val();
        var cls = $("#assess_class").val();
        var term = $("#assess-term").val();
        var ayear = $("#assess-ayear").val();
        var sub = $("#assess-subjt").val();
        if (Number(exam) === 0) {
            $("input#exam_val").focus();
        } else if (Number(exam) > 100) {
            Snarl.addNotification({
                title: "ERROR",
                text: "Invalid input, exam score should not be greater than 100 ",
                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                timeout: 3000
            });
            $(".snarl-notification").addClass('snarl-error');
        } else {


            var progress = Snarl.addNotification({
                title: "Please Wait...",
                text: "Saving Assignment record",
                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-circle-o-notch fa-spin'></i>",
                timeout: null
            });
            $(".snarl-notification").addClass('snarl-info');

            $.get("saveexam.php?stid=" + stid + "&exam=" + exam + "&term=" + term + "&cls=" + cls + "&ayear=" + ayear + "&sub=" + sub, function (data) {
            }).done(function (data) {
                $("#assess-subjt").change();
                Snarl.removeNotification(progress);
                Snarl.addNotification({
                    title: "SAVED",
                    text: data,
                    icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle-o'></i>",
                    timeout: 3000
                });
                $(".snarl-notification").addClass('snarl-success');
                skipstud4(1);
            }).error(function () {
                Snarl.removeNotification(progress);

                Snarl.addNotification({
                    title: "ERROR",
                    text: "Could not process data",
                    icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                    timeout: 3000
                });
                $(".snarl-notification").addClass('snarl-error');

            });
        }

    }


    $(document).ready(function () {

        $("#stname").change(function () {
            skipstud4(1);

        });
        $("#exam_val").focusin(function () {
            if (Number($(this).val()) <= 0) {
                $(this).val("");
            }

        });


        $("#exam_val").focusout(function () {
            if (Number($(this).val()) <= 0) {
                $(this).val(0);
            }

        });
        $("#exam_val").keypress(function (e) {
            if (e.which === 13) {
                savexam();
            }

            if (!((e.which >= 47 && e.which <= 58) || e.which === 8 || e.which === 0)) {
                e.preventDefault();

            }
        });


    });


</script>
    