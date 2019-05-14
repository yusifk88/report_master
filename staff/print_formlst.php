<?php
include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$cls = mysqli_query("select * from classes order by classname ASC");
$ayear = mysqli_query("select distinct(ayear) from stuinfo");
$stud = mysqli_query("select id,fname,lname,oname from stuinfo order by fname ASC");
?>

<div class="col-lg-6 col-md-6 col-lg-offset-3 col-md-offset-3 col-sm-12 col-xs-12">
    <div class="panel panel-info" style="border-radius: 0;">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="alert alert-info">
                        <p class="panel-title">Print Form List</p>
                    </div>
                </div>
            </div>
            <form>
                <div class="row" style="padding-left: 5px; padding-right: 5px; padding-bottom: 5px;">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label class="control-label" for="cls">Class</label>
                        <select id="frm" class="form-control">
                            <option value="1">Form 1</option>
                            <option value="2">Form 2</option>
                            <option value="3">Form 3</option>
                            <option value="4">Form 4</option>
                        </select>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label class="control-label" for="cls">Academic Year</label>
                        <select id="ayer8" class="we-select form-control">
                            <?php
                            while ($row2 = mysqli_fetch_object($ayear)) {

                                ?>
                                <option><?= $row2->ayear; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label class="control-label" for="cls">Term</label>
                        <select id="term4" class="we-select form-control">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <br/>
                        <button onclick="get_formlst();" type="button" class="wb wb-good">Print</button>
                    </div>
                </div>
        </div>
        </form>
    </div>
    <br/>
    <span style="color: red;" id="cntcont">
    </span>
</div>

<script type="text/javascript">
    function get_formlst() {
        var form = $("#frm").val();
        var ayear = $("#ayer8").val();
        var term = $("#term4").val();
        $.getJSON("cnt_formlst.php?ayear=" + $("#ayer8").val() + "&term=" + $("#term4").val() + "&form=" + $("#frm").val(), function (dataobj) {
            if (dataobj.count_val === 0) {
                $(".dlg-ex").html("<span style='color:red;'>No records found on students in this form</span>");
                $(".dlg-ex").dialog({
                    show: "bounce",
                    hide: "fade",
                    modal: "true",
                    buttons: {
                        Ok: function () {
                            $(this).dialog("close");
                        }

                    }
                });

            } else {
                window.open("formlst.php?ayear=" + ayear + "&term=" + term + "&form=" + form, "Form List", "outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");
            }
        });

    }

    $(document).ready(function () {


    });
</script>


