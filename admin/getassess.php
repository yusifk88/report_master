<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\config;
use APP\school;
use APP\Utitlity;

$ut = new utitlity();
$cf = new config();
$sch = new school();
$cf->connect();
$cls = $_GET['cls'];
$ayear = $_GET['ayear'];
$term = $_GET['term'];
$subjt = $_GET['subjt'];
$key = $_GET['key'];

$recs = mysqli_query($cf->con, "select records.subjt,records.id,stuinfo.fname,stuinfo.lname,stuinfo.oname,classes.classname,records.term,records.acyear,subjects.subjdesc,ta1,ta2,ta3,ta4,hw1,hw2,hw3,hw4,pw1,pw2,subtotl,cvsubtotl,exam,cvexam,totlscore,post ,((subtotl*$sch->clscore_ratio)/$sch->sba+(exam*($sch->exam_ratio/100))) as tscore from records,stuinfo,classes,subjects where records.subjt = subjects.id and records.cls = classes.id and records.stid = stuinfo.id and records.term = '$term' and records.acyear='$ayear' and records.subjt = '$subjt' and records.cls = '$cls' and (stuinfo.fname like '%$key%' or stuinfo.lname LIKE '%$key%' or stuinfo.oname LIKE '%$key%') order by tscore DESC ");
$sch = new school();
if (mysqli_num_rows($recs) > 0) {
    ?>

    <div class="card card-info mt-0">
        <div class="table-responsive">
            <table class="table table-condensed table-hover table-striped table-sm table-bordered" id="assess-table">
                <thead class="bg-info text-white">
                <tr>
                    <th style="border: 1px solid deepskyblue; border-right: 1px solid #fff;">
                        S/N
                    </th>
                    <th style="border: 1px solid deepskyblue; border-right: 1px solid #fff;">
                        Name
                    </th>
                    <th colspan="4"
                        style="text-align: center; border: 1px solid deepskyblue; border-right: 1px solid #fff;">
                        Class Task
                    </th>

                    <th colspan="4"
                        style="text-align: center; border: 1px solid deepskyblue; border-right: 1px solid #fff;">
                        Assignment
                    </th>

                    <th colspan="2" style="text-align: center; border: 1px solid deepskyblue; border-right: 1px solid #fff;">
                        Project Work
                    </th>

                    <th style="text-align: center; border: 1px solid deepskyblue; border-right: 1px solid #fff;">
                        SBA
                    </th>
                    <th style="text-align: center; border: 1px solid deepskyblue; border-right: 1px solid #fff;">
                        SBA(<?= $sch->clscore_ratio . "%"; ?>)
                    </th>
                    <th style="text-align: center; border: 1px solid deepskyblue; border-right: 1px solid #fff;">
                        Exam(100%)
                    </th>
                    <th style="text-align: center; border: 1px solid deepskyblue; border-right: 1px solid #fff;">
                        Exam(<?= $sch->exam_ratio . "%"; ?>)
                    </th>
                    <th style="text-align: center; border: 1px solid deepskyblue; border-right: 1px solid #fff;">
                        Total Score
                    </th>
                    <th style="text-align: center; border: 1px solid deepskyblue; border-right: 1px solid #fff;">
                        Grade
                    </th>
                    <th style="text-align: center; border: 1px solid deepskyblue; border-right: 1px solid #fff;">
                        Remark
                    </th>
                    <th style="text-align: center; border: 1px solid deepskyblue; border-right: 1px solid #fff;">
                        Pos.
                    </th>
                </tr>
                </thead>
                <tbody id="assess-content">

                <?php
                $a = 1;
                while ($recrow = mysqli_fetch_assoc($recs)) {
                    $cvsubtotal = (($sch->clscore_ratio / $sch->sba) * $recrow['subtotl']);
                    $cvexam = ($sch->exam_ratio / 100) * $recrow['exam'];
                    $totlscore = $cvexam + $cvsubtotal;
                    $id = $recrow['id'];
                    ?>
                    <tr id="row_<?= $recrow['id'] ?>">
                        <td><?= $a; ?></td>
                        <td><?= $recrow['fname'] . " " . $recrow['lname'] . " " . $recrow['oname']; ?></td>
                        <td style="text-align: center; vertical-align: middle;"><?= $recrow['ta1']; ?></td>
                        <td style="text-align: center; vertical-align: middle;"><?= $recrow['ta2']; ?></td>
                        <td style="text-align: center; vertical-align: middle;"><?= $recrow['ta3']; ?></td>
                        <td style="text-align: center; vertical-align: middle;"><?= $recrow['ta4']; ?></td>
                        <td style="text-align: center; vertical-align: middle;"><?= $recrow['hw1']; ?></td>
                        <td style="text-align: center; vertical-align: middle;"><?= $recrow['hw2']; ?></td>
                        <td style="text-align: center; vertical-align: middle;"><?= $recrow['hw3']; ?></td>
                        <td style="text-align: center; vertical-align: middle;"><?= $recrow['hw4']; ?></td>
                                  <td style="text-align: center; vertical-align: middle;"><?= $recrow['pw1']; ?></td>
                                   <td style="text-align: center; vertical-align: middle;"><?= $recrow['pw2']; ?></td>
                        <td style="text-align: center; vertical-align: middle;"><?= $recrow['subtotl']; ?></td>
                        <td style="text-align: center; vertical-align: middle;"><?= $cvsubtotal; ?></td>
                        <td style="text-align: center; vertical-align: middle;"><?= $recrow['exam']; ?></td>
                        <td style="text-align: center; vertical-align: middle;"><?= $cvexam; ?></td>
                        <td style="text-align: center; vertical-align: middle;"><?= number_format($recrow['tscore'], 1); ?></td>
                        <td style="text-align: center; vertical-align: middle;"><?= $ut->getgrd(number_format($recrow['tscore'], 1)); ?></td>
                        <td style="text-align: center; vertical-align: middle;"><?= $ut->getremark(number_format($totlscore, 1)); ?></td>
                        <td style="text-align: center; vertical-align: middle;"><?= $ut->addsufix($a); ?></td>
                        <!--            <td style="text-align: center; vertical-align: middle;"><i data-toggle='tooltip' onclick="" title="Make changes to this record" style="color: deepskyblue; cursor: pointer;" class="fa fa-edit waves-effect waves-circle"></i></td>-->
                        <!--            <td style="text-align: center; vertical-align: middle;"><i data-toggle='tooltip' onclick=")" title="Delete this record permanently" style="color: red; cursor: pointer;" class="fa fa-remove waves-effect waves-circle"></i></td>-->
                    </tr>
                    <?php
                    $a++;
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>


    <?php
} else {
    echo '<center><h2 class="text-muted"><span class="glyphicon glyphicon-warning-sign"></span>No record exist for the filter</h2></center>';
} ?>

<script type="text/javascript">

    function updateassess(id) {
        fullProg();
        $.get("getassessupdate.php?id=" + id, function (data) {
        }).done(function (data) {
            remove_fullprog();
            BootstrapDialog.show({
                title: "Edit This Record",
                message: data,
                size: "size-wide",
                buttons: [{
                    label: "CANCEL", cssClass: 'btn-bad waves-effect waves-button', action: function (d) {
                        d.close()
                    }
                }, {
                    label: "UPDATE", cssClass: "btn-good waves-effect waves-button", action: function (d) {
                        var progress = Snarl.addNotification({
                            title: "Please Wait...",
                            text: "Updating Assessment record.",
                            icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-circle-o-notch fa-spin'></i>",
                            timeout: null
                        });
                        $(".snarl-notification").addClass('snarl-info');
                        var sum = Number($("#up-ta1").val()) + Number($("#up-ta2").val()) + Number($("#up-ta3").val()) + Number($("#up-ta4").val()) + Number($("#up-hw1").val()) + Number($("#up-hw2").val()) + Number($("#up-hw3").val()) + Number($("#up-hw4").val());
                        if (Number(sum) <= 100 && Number($("#up-exam").val()) <= 100) {
                            $.get("up_assess.php?id=" + $("#up-id").val() + "&ayear=" + $("#assess-ayear").val() + "&term=" + $("#assess-term").val() + "&subjt=" + $("#assess-subjt").val() + "&cls=" + $("#assess_class").val() + "&ta1=" + $("#up-ta1").val() + "&ta2=" + $("#up-ta2").val() + "&ta3=" + $("#up-ta3").val() + "&ta4=" + $("#up-ta4").val() + "&hw1=" + $("#up-hw1").val() + "&hw2=" + $("#up-hw2").val() + "&hw3=" + $("#up-hw3").val() + "&hw4=" + $("#up-hw4").val() + "&exam=" + $("#up-exam").val(), function (data) {
                            }).done(function () {
                                $("#assess_class").change();
                                d.close();
                                Snarl.removeNotification(progress);
                                Snarl.addNotification({
                                    title: "UPDATED",
                                    text: "Assessment Record Updated Successfully",
                                    icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle-o'></i>",
                                    timeout: 3000
                                });
                                $(".snarl-notification").addClass('snarl-success');
                            }).error(function () {

                                Snarl.removeNotification(progress);
                                Snarl.addNotification({
                                    title: "ERROR",
                                    text: "Something went wrong, could not update record",
                                    icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                                    timeout: 3000
                                });
                                $(".snarl-notification").addClass('snarl-error');

                            });

                        } else {
                            Snarl.removeNotification(progress);
                            Snarl.addNotification({
                                title: "ERROR",
                                text: "Invalid entry, please check your values and try again",
                                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                                timeout: 8000
                            });
                            $(".snarl-notification").addClass('snarl-error');

                        }


                    }
                }]
            });


        }).error(function () {
            finish();
            show_error();
        });
    }


    //-----------------------------------------------------------------------------------
    function delass(id) {
        BootstrapDialog.show({
            title: "Confirm Delete",
            message: "This record will be permanently removed from the server, proceed?",
            buttons: [{
                label: "DELETE", cssClass: "btn-bad waves-effect waves-button", action: function (d) {
                    d.close();
                    $.get("delass.php?id=" + id + "&ayear=" + $("#assess-ayear").val() + "&term=" + $("#assess-term").val() + "&subjt=" + $("#assess-subjt").val() + "&cls=" + $("#assess_class").val(), function (data) {
                    }).done(function () {
                        var rowid = "#row_" + id;
                        $(rowid).fadeOut(200, function () {
                            $(rowid).remove();
                        });

                    });
                }
            }]

        });

        $(".modal-backdrop").addClass("backdrop-light");

    }


    function assess_page(p) {
        showprog();
        $.get("getassess.php?cls=" + $("#assess_class").val() + "&ayear=" + $("#assess-ayear").val() + "&term=" + $("#assess-term").val() + "&subjt=" + $("#assess-subjt").val() + "&page=" + p, function (data) {
            $("#assess-container").hide();
            $("#assess-container").html(data);
        }).done(function () {
            $("#assess-container").effect("drop", {mode: "show", direction: "left", height: "toggle"}, 500);
            finish();
        });
    }

    function deslelect() {

        $("tbody tr").css("background-color", "#fff");
        $("tbody tr").css("color", "#000");
    }

    function select(elmt) {

        $(elmt).parent().css("background-color", "green");
        $(elmt).parent().css("color", "#fff");
        $(elmt).trigger("create");
    }

    $(document).ready(function () {


        $("#ass_updateform :input").keypress(function (e) {
            if (!((e.which >= 47 && e.which <= 58) || e.which === 8 || e.which === 0)) {
                e.preventDefault();
            }
        });


        $("td").mousedown(function () {
            deslelect();
            select(this);
        });
        $("td").mouseup(function () {
            select(this);


        });
        //------------------------------------------
        $("#ass_updateform :input").keypress(function (e) {

            if (!((e.which >= 47 && e.which <= 58) || e.which === 8 || e.which === 0)) {
                e.preventDefault();

            }
        });
        //-----------------------------------------
        $("#cbopage-list2").change(function () {
            var page = $(this).val();
            assess_page(page);

        });
        $("span").tooltip();
        //$("#assess-table").dataTable();
    });
</script>