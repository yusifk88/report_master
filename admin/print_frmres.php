<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\config;
$cf = new config();
$cf->connect();
$cls = mysqli_query($cf->con, "select * from classes order by classname ASC");
$ayear = mysqli_query($cf->con, "select distinct(ayear) from stuinfo order by ayear desc");
$stud = mysqli_query($cf->con, "select id,fname,lname,oname from stuinfo order by fname ASC");
?>

<div class="col-md-12">
    <div class="row">
        <div class="col-md-3"></div>


        <div class="col-lg-6 col-md-6 col-lg-offset-3 col-md-offset-3 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <p class="card-title text-white"> Print Form Results </p>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row" style="padding-left: 5px !important; padding-right: 5px !important;">
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
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <br/>
                                <button onclick="get_formlst();" type="button" class="btn btn-primary">Print</button>
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
    function get_formlst() {
        var form = $("#frm").val();
        var ayear = $("#ayer8").val();
        var term = $("#term4").val();

        window.open("formres.php?ayear=" + ayear + "&term=" + term + "&form=" + form, "Form List", "outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");


    }


</script>


