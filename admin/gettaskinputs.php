<?php
include_once './objts/config.php';
$cf = new config();
$cf->connect();
$stid = $_GET['stid'];
$cls = $_GET['cls'];
$ayear = $_GET['ayear'];
$term = $_GET['term'];
$subjt = $_GET['subjt'];
$per_page = 1;
$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $per_page;
$cnsql = mysqli_query($cf->con, "select id,fname,lname,oname,photo from stuinfo where class='$cls' and id like '%$stid%' and id  not in (select stid from records  where (ta1 is not null or ta1=0) and (ta2 is not null or ta2=0) and (ta3 is not null or ta3=0) and (ta4 is not null or ta4 =0 ) and acyear = '$ayear' and term = '$term' and subjt = '$subjt' and cls = '$cls') and id not in(SELECT stid from withdraw)");
$stinputs = mysqli_query($cf->con, "select id,fname,lname,oname,photo from stuinfo where class='$cls' and id like '%$stid%' and id not in (select stid from records where (ta1 is not null or ta1=0) and (ta2 is not null or ta2=0) and (ta3 is not null or ta3=0) and (ta4 is not null or ta4 =0 ) and acyear = '$ayear' and term = '$term' and subjt = '$subjt' and cls = '$cls') and id not in(SELECT stid from withdraw) order by fname ASC LIMIT " . $start . "," . $per_page);
$recount = mysqli_num_rows($cnsql);
$pages = ceil($recount / $per_page);
$stnames = mysqli_query($cf->con, "select id,fname,lname,oname,photo from stuinfo where class='$cls' and id not in (select stid from records where (ta1 is not null or ta1=0) and (ta2 is not null or ta2=0) and (ta3 is not null or ta3=0) and (ta4 is not null or ta4 =0 ) and acyear = '$ayear' and term = '$term' and subjt = '$subjt' and cls = '$cls') and id not in(SELECT stid from withdraw) order by fname ASC");


if (mysqli_num_rows($stinputs) > 0) {
    while ($row = mysqli_fetch_assoc($stinputs)) {
        ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-info" style="border-radius: 0;">
                    <div class="panel-body">
                        <form id="cls-taskform">
                            <input type="hidden" value="<?= $row['id'] ?>" id="stid"/>
                            <br>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <button onclick="skipstud(1);" class="btn btn-good waves-effect pull-right">Reset <i
                                                class="fa fa-undo"></i></button>
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
                                        <div class="col-lg-2 col-md-2">
                                            <label class="control-label">Task One</label>
                                            <input autofocus style="text-align: center" id="ta1" class="form-control"
                                                   type="number" value="0"/>
                                        </div>
                                        <div class="col-lg-2 col-md-2">
                                            <label class="control-label">Task Two</label>
                                            <input style="text-align: center" id="ta2" class="form-control"
                                                   type="number" value="0"/>
                                        </div>
                                        <div class="col-lg-2 col-md-2">
                                            <label class="control-label">Task Three</label>
                                            <input style="text-align: center" id="ta3" class="form-control"
                                                   type="number" value="0"/>
                                        </div>
                                        <div class="col-lg-2 col-md-2">
                                            <label class="control-label">Task Four</label>
                                            <input style="text-align: center" id="ta4" class="form-control"
                                                   type="number" value="0"/>
                                        </div>
                                        <div class="col-lg-4 col-md-4">
                                            <label class="control-label">Total</label>
                                            <input style="text-align: center" readonly="" id="totl" class="form-control"
                                                   type="number" value="0"/>
                                        </div>
                                    </div>

                                </div>
                            </div>
                    </div>


                    <div class="panel-footer clsfooter">
                        <?php
                        $next = $page + 1;
                        $prev = $page - 1;
                        if ($page > 1) {
                            ?>

                            <button id="skipbtn" onclick="skipstud(<?= $prev ?>)" type="button"
                                    class="btn btn-good waves-effect waves-button pull-left">&les;&les; Back
                            </button>
                            <?php
                        }
                        ?>
                        <input type="hidden" value="<?= $page ?>" id="nexval"/>
                        <span class="text-success"> <i class="fa fa-info-circle"></i> <strong>NOTE.</strong> Scores under this category should sum up to a maximum of 50 </span>

                        <?php
                        // echo 'term:'. $term."year:".$ayear."sub:".$subjt."cls:".$cls;
                        if ($page < $pages) {

                            ?>

                            <button id="skipbtn" onclick="skipstud(<?= $next ?>)" type="button"
                                    class="btn btn-good waves-effect waves-button pull-right">Skip &GreaterGreater;
                            </button>
                            <input type="hidden" value="notend" id="endval"/>

                            <?php

                        } else {

                            ?>

                            <input type="hidden" value="end" id="endval"/>

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
        because class task records on all students in this class were recorded or no student exist in the selected class
    </h2>
    <?php

}

?>
<script>

    function skipstud(page) {
        var sid = $("#stname").val();
        $.get("gettaskinputs.php?page=" + page + "&cls=" + $("#assess_class").val() + "&ayear=" + $("#assess-ayear").val() + "&term=" + $("#assess-term").val() + "&subjt=" + $("#assess-subjt").val() + "&stid=" + sid, function (data) {
            $("div#task-cont").hide();
            $("div#task-cont").html(data);
            $("div#task-cont").fadeIn(100);
        });

    }

    function savtask() {
        var stid = $("#stid").val();
        var ta1 = $("#ta1").val();
        var ta2 = $("#ta2").val();
        var ta3 = $("#ta3").val();
        var ta4 = $("#ta4").val();
        var totl = $("#totl").val();
        var cls = $("#assess_class").val();
        var term = $("#assess-term").val();
        var ayear = $("#assess-ayear").val();
        var sub = $("#assess-subjt").val();
        if (Number(totl) === 0) {
            $("#ta1").focus();
        } else if (Number(totl) > 50) {
            Snarl.addNotification({
                title: "ERROR",
                text: "Class Task records should sum up to a maximum of 50, please check and try again",
                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                timeout: 3000
            });
            $(".snarl-notification").addClass('snarl-error');
        } else {
            var progress = Snarl.addNotification({
                title: "Please Wait...",
                text: "Saving class task record",
                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-circle-o-notch fa-spin'></i>",
                timeout: null
            });
            $(".snarl-notification").addClass('snarl-info');

            $.get("savetask.php?stid=" + stid + "&ta1=" + ta1 + "&ta2=" + ta2 + "&ta3=" + ta3 + "&ta4=" + ta4 + "&totl=" + totl + "&term=" + term + "&cls=" + cls + "&ayear=" + ayear + "&sub=" + sub, function (data) {
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
                skipstud(1);
            });

        }


    }

    $(document).ready(function () {


        $("#stname").change(function () {
            skipstud(1);

        });

        $("#ta1").focus();
        $("#ta1,#ta2,#ta3,#ta4").keyup(function () {
            var ta1 = isNaN($("#ta1").val()) ? 0 : $("#ta1").val();
            var ta2 = isNaN($("#ta2").val()) ? 0 : $("#ta2").val();
            var ta3 = isNaN($("#ta3").val()) ? 0 : $("#ta3").val();
            var ta4 = isNaN($("#ta4").val()) ? 0 : $("#ta4").val();
            var sum = (Number(ta1) + Number(ta2) + Number(ta3) + Number(ta4));
            $("#totl").val(sum);

        });
        $("#ta1,#ta2,#ta3,#ta4").focusin(function () {
            if (Number($(this).val()) <= 0) {
                $(this).val("");
            }

        });
        $("#ta1,#ta2,#ta3,#ta4").focusout(function () {
            if (Number($(this).val()) <= 0) {
                $(this).val(0);
            }

        });

        $("#ta1,#ta2,#ta3,#ta4").keypress(function (e) {
            if (e.which === 13) {
                savtask();
            }

            if (!((e.which >= 47 && e.which <= 58) || e.which === 8 || e.which === 0)) {
                e.preventDefault();

            }


        });


    });

</script>
    