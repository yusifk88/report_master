<?php
include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$ayear = mysqli_query($cf->con, "select distinct(ayear) from stuinfo order by ayear DESC ");

?>

<div class="col-md-12">

    <div class="row">
        <div class="col-md-3"></div>


        <div class="col-lg-6 col-md-6 col-lg-offset-3 col-md-offset-3 col-sm-12 col-xs-12">
            <div class="card card-info" style="border-radius: 0;">
                <div class="card-header bg-info text-white">
                    <p class="card-title">Print Withdrawal List</p>
                </div>
                <form>
                    <div class="card-body">
                        <div class="row" style="padding-left: 5px !important; padding-right: 5px !important;">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label" for="ayer3">Academic Year</label>
                                <select id="ayer3" class="we-select form-control">
                                    <?php
                                    while ($row2 = mysqli_fetch_object($ayear)) {
                                        ?>
                                        <option><?= $row2->ayear; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">

                        <button onclick="getprog_widraw();" type="button" class="btn bg-info">Print</button>

                    </div>
                </form>
            </div>

        </div>
    </div>

</div>
<br/>
<span style="color: red;" id="cntcont2">
  
    </span>
</div>
<script type="text/javascript">
    function getprog_widraw() {
        var prog = $("#prog2").val();
        var ayear = $("#ayer3").val();
        var cls = $("#cls4").val();

        $.getJSON("cnt_widraw.php?ayear=" + $("#ayer3").val(), function (dataobj) {
            if (dataobj.count_val === 0) {
                Snarl.addNotification({
                    title: "NO RECORD",
                    text: "No student found",
                    icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                    timeout: 3000
                });
                $(".snarl-notification").addClass('snarl-error');
            } else {
                window.open("widraw_list.php?ayear=" + ayear, "Sign List", "outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");
            }
        });
    }

</script>

