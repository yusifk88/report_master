<?php
include_once '../admin/objts/config.php';
$cf = new config();
$cf->connect();
$cls = $_GET['cls'];
$stid = $_GET['stid'];
$ayear = $_GET['ayear'];
$term = $_GET['term'];
$subjt = $_GET['subjt'];
$per_page = 1;
$page_query = mysqli_query($cf->con, "select count(*) from stuinfo where class='$cls' and");
$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $per_page;
$cnsql = mysqli_query($cf->con, "select id,fname,lname,oname,photo from stuinfo where class='$cls' and id like '%$stid%' and ayear = '$ayear' and id  not in (select stid from records  where pw1 is not null and pw2 is not null and acyear = '$ayear' and term = '$term' and subjt = '$subjt' and cls = '$cls' ) and id not in(SELECT stid from withdraw)");
$stinputs = mysqli_query($cf->con, "select id,fname,lname,oname,photo from stuinfo where class='$cls' and id like '%$stid%' and ayear = '$ayear' and id not in (select stid from records where pw1 is not null and pw2 is not null and acyear = '$ayear' and term = '$term' and subjt = '$subjt' and cls = '$cls') and id not in(SELECT stid from withdraw) order by fname ASC LIMIT " . $start . "," . $per_page);
$recount = mysqli_num_rows($cnsql);
$pages = ceil($recount / $per_page);
$stnames = mysqli_query($cf->con, "select id,fname,lname,oname,photo from stuinfo where class='$cls' and ayear = '$ayear' and id not in (select stid from records where pw1 is not null and pw2 is not null and acyear = '$ayear' and term = '$term' and subjt = '$subjt' and cls = '$cls') and id not in(SELECT stid from withdraw) order by fname ASC ");
if (mysqli_num_rows($stinputs) > 0) {
    while ($row = mysqli_fetch_assoc($stinputs)) {
        ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-info" style="border-radius: 0;">
                    <div class="panel-body">
                        <form id="cls-hworkform">
                            <input type="hidden" value="<?= $row['id'] ?>" id="stid3"/>
                            <br>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <button onclick="skipstud3(1);" class="btn rgba-cyan-strong btn-sm pull-right">Reset
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
                                    <img src="<?= file_exists('../admin/'.$row['photo']) ? '../admin/'.$row['photo'] : '../admin/objts/dpic/photo.jpg'; ?>" width="180" height="200"
                                         class="img-thumbnail"/>
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
                                            <div class="md-form">
                                                <input min="0" style="text-align: center" id="pw1" class="form-control" type="number" value="0"/>
                                                <label for="pw1" class="control-label active">Project W. One</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4">
                                            <div class="md-form">
                                                <input min="0" style="text-align: center" id="pw2" class="form-control" type="number" value="0"/>
                                                <label for="pw2" class="control-label active">Project W. Two</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4">
                                            <div class="md-form">
                                                <input style="text-align: center" readonly="" id="pwtotl" class="form-control" type="number" value="0"/>
                                                <label for="pwtotl" class="control-label active">Total</label>
                                            </div>
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
                            <button id="skipbtn" onclick="skipstud3(<?= $prev ?>)" type="button"
                                    class="btn btn-sm rgba-cyan-strong pull-left">&les;&les; Back
                            </button>
                            <?php

                        }

                        ?>
                        <span class="text-success"> <i class="fa fa-info-circle"></i> <strong>NOTE.</strong> Scores under this category should sum up to a maximum of 20 </span>

                        <?php
                        // echo 'term:'. $term."year:".$ayear."sub:".$subjt."cls:".$cls;

                        if ($page < $pages) {

                            ?>

                            <button id="skipbtn2" onclick="skipstud3(<?= $next ?>)" type="button"
                                    class="btn btn-sm rgba-cyan-strong pull-right">Skip &GreaterGreater;
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
        because Project Work records on all students in this class were recorded or no student exist in the selected
        class </h2>
    <?php

}

?>

<script>
    function skipstud3(page) {
        var sid = $("#stname").val();

        $.get("getstudinputs-pw.php?page=" + page + "&cls=" + $("#assess_class").val() + "&ayear=" + $("#assess-ayear").val() + "&term=" + $("#assess-term").val() + "&subjt=" + $("#assess-subjt").val() + "&stid=" + sid, function (data) {
            $("#pwork-cont").hide();
            $("#pwork-cont").html(data);
            $("#pwork-cont").fadeIn(100);
        });
    }

    function savpwork() {
        var stid = $("#stid3").val();
        var pw1 = $("#pw1").val();
        var pw2 = $("#pw2").val();
        var totl = $("#pwtotl").val();
        var cls = $("#assess_class").val();
        var term = $("#assess-term").val();
        var ayear = $("#assess-ayear").val();
        var sub = $("#assess-subjt").val();

        if (Number(totl) === 0) {

            $("#pw1").focus();


        } else if (Number(totl) > 20) {


            Snarl.addNotification({
                title: "ERROR",
                text: "Project work records should sum up to a maximum of 20, please check and try again",
                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                timeout: 3000
            });
            $(".snarl-notification").addClass('snarl-error');


        } else {

            var progress = Snarl.addNotification({
                title: "Please Wait...",
                text: "Saving Project Work record",
                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-circle-o-notch fa-spin'></i>",
                timeout: null
            });
            $(".snarl-notification").addClass('snarl-info');

            $.get("savepwork.php?stid3=" + stid + "&pw1=" + pw1 + "&pw2=" + pw2 + "&totl=" + totl + "&term=" + term + "&cls=" + cls + "&ayear=" + ayear + "&sub=" + sub, function (data) {


            }).done(function (data) {
                finish();
                $("#assess-subjt").change();
                Snarl.removeNotification(progress);
                Snarl.addNotification({
                    title: "SAVED",
                    text: data,
                    icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle-o'></i>",
                    timeout: 3000
                });
                $(".snarl-notification").addClass('snarl-success');
                skipstud3(1);
            });


        }


    }


    $(document).ready(function () {


        $("#stname").change(function () {
            skipstud3(1);

        });


        $("#pw1,#pw2").keyup(function () {
            var pw1 = isNaN($("#pw1").val()) ? 0 : $("#pw1").val();
            var pw2 = isNaN($("#pw2").val()) ? 0 : $("#pw2").val();
            var sum = (Number(pw1) + Number(pw2));
            $("#pwtotl").val(sum);

        });
        $("#pw1,#pw2").focusin(function () {
            if (Number($(this).val()) <= 0) {
                $(this).val("");
            }

        });
        $("#pw1,#pw2").focusout(function () {
            if (Number($(this).val()) <= 0) {
                $(this).val(0);
            }

        });

        $("#pw1,#pw2").keypress(function (e) {
            if (e.which === 13) {
                savpwork();
            }

            if (!((e.which >= 47 && e.which <= 58) || e.which === 8 || e.which === 0)) {
                e.preventDefault();

            }


        });


    });


</script>
    