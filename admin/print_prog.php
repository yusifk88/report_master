<?php
include_once 'objts/config.php';
$cf = new config();
$cf->connect();

$prog = mysqli_query($cf->con, "select * from dept");
$ayear = mysqli_query($cf->con, "select distinct(ayear) from stuinfo");

?>

<div class="col-md-12">
    <div class="row">


        <div class="col-md-3 col-md-3"></div>
        <div class="col-lg-6 col-md-6 col-12 mr-auto">
            <div class="card card-info" style="border-radius: 0;">
                <div class="card-header bg-info">
                    <p class="card-title text-white">Print Programe List</p>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row" style="padding-left: 5px !important; padding-right: 5px !important;">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label" for="cls">Programe</label>
                                <select id="prog" class="we-select form-control">
                                    <?php
                                    while ($row = mysqli_fetch_object($prog)) {
                                        ?>
                                        <option value="<?= $row->id; ?>"><?= $row->depname; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label" for="cls">Academic Year</label>
                                <select id="ayer2" class="we-select form-control">
                                    <?php
                                    while ($row2 = mysqli_fetch_object($ayear)) {

                                        ?>
                                        <option><?= $row2->ayear; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                <br/>
                                <button onclick="getprog_list();" type="button" class="btn bg-info">Print</button>
                            </div>
                        </div>
                </div>
                </form>
            </div>
            <br/>
            <span style="color: red;" id="cntcont2">

    </span>
        </div>


    </div>

</div>
<script type="text/javascript">

    function getprog_list() {
        var prog = $("#prog").val();
        var ayear = $("#ayer2").val();
        $.getJSON("cnt_prog.php?prog=" + $("#prog").val() + "&ayear=" + $("#ayer2").val(), function (dataobj) {

            if (dataobj.count_val === 0) {
                Snarl.addNotification({
                    title: "NO RECORD",
                    text: "No student found in this class with this academic year",
                    icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                    timeout: 3000
                });
                $(".snarl-notification").addClass('snarl-error');

            } else {

                window.open("prog_list.php?ayear=" + ayear + "&prog=" + prog, "Programe List", "outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");


            }

        });


    }

    $(document).ready(function () {
        $("#prog").change(function () {

            $.getJSON("cnt_prog.php?prog=" + $("#prog").val() + "&ayear=" + $("#ayer2").val(), function (dataobj) {

                $("#cntcont2").html("There are " + dataobj.count_val + " student(s) that offer this programe");
            });


        });
        $("#ayer2").change(function () {
            $("#prog").change();


        });


    });
</script>

