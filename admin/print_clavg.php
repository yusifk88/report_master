<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\config;
$cf = new config();
$cf->connect();

$cls = mysqli_query($cf->con, "select * from classes");
$ayear = mysqli_query($cf->con, "select distinct(acyear) from records");

?>

<div class="col-md-12">
    <div class="row">
        <div class="col-md-3"></div>


        <div class="col-lg-6 col-md-6 col-lg-offset-3 col-md-offset-3 col-sm-12 col-xs-12">
            <div class="card" style="border-radius: 0;">
                <div class="card-header bg-primary text-white">
                    <p class="card-title text-white"><i class="fa fa-bar-chart"></i> Print class Averages</p>

                </div>
                <div class="card-body">

                    <form>
                        <div class="row" style="padding-left: 5px !important; padding-right: 5px !important;">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label" for="cls">Class</label>
                                <select id="cls" class="we-select form-control">
                                    <?php
                                    while ($row = mysqli_fetch_object($cls)) {
                                        ?>
                                        <option value="<?= $row->id; ?>"><?= $row->classname; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label" for="cls">Term</label>
                                <select id="clterm" class="we-select form-control">
                                    <?php
                                    for ($i = 1; $i < 4; $i++) {

                                        ?>
                                        <option><?= $i; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label" for="cls">Academic Year</label>
                                <select id="ayer" class="we-select form-control">
                                    <?php
                                    while ($row2 = mysqli_fetch_object($ayear)) {

                                        ?>
                                        <option><?= $row2->acyear; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                <br/>
                                <button onclick="getcls_list();" type="button"
                                        class="btn btn-primary">Print
                                </button>
                            </div>
                        </div>
                </div>
                </form>
                <div class="alert bg-warning">
                    <h5>This document might take a long time to load depending on the number of students in the selected class</h5>
                </div>
            </div>
            <br/>
            <span style="color: red;" id="cntcont">
    </span>
        </div>
    </div>
</div>
<script type="text/javascript">
    function getcls_list() {
        var cls = $("#cls").val();
        var ayear = $("#ayer").val();
        $.getJSON("cnt_cavg.php?clas=" + $("#cls").val() + "&ayear=" + $("#ayer").val() + "&term=" + $("#clterm").val(), function (dataobj) {
            if (dataobj.count_val === 0) {
                Snarl.addNotification({
                    title: "NO RECORD",
                    text: "No student found in this class with this academic year",
                    icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                    timeout: 3000
                });
                $(".snarl-notification").addClass('snarl-error');
            } else {

                window.open("clavg.php?ayear=" + ayear + "&cls=" + cls + "&term=" + $("#clterm").val(), "Class List", "outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");


            }

        });

    }

    $(document).ready(function () {
        $("#cls").change(function () {

//            $.getJSON("cnt_cls.php?clas="+$("#cls").val()+"&ayear="+$("#ayer").val(),function(dataobj){
//
//                $("#cntcont").html("There are "+ dataobj.count_val +" student(s) in this class");
//            });
//
//
        });
        $("#ayer").change(function () {
            $("#cls").change();


        });


    });
</script>

