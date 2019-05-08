<?php
include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$ayear = mysqli_query($cf->con,"select distinct(ayear) from stuinfo ORDER by ayear desc");

?>
<div class="col-lg-6 col-md-6 col-md-offset-3 col-sm-12 col-12 mx-auto">
    <div class="card card-info" style="border-radius: 0;">
        <div class="card-header bg-info text-white">
            <p class="card-title">Print General Population List</p>
        </div>
        <form>
            <div class="card-body">

                <div class="row" style="padding-left: 5px !important; padding-right: 5px !important;">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label class="control-label" for="ayer3">Academic Year</label>
                        <select id="ayer3" class="we-select form-control">
                            <?php
                            while ($row2 = mysqli_fetch_object($ayear)){
                                ?>
                                <option><?=$row2->ayear;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="col-md-12">

                    <button onclick="get_genpop();" type="button" class="btn bg-info">Print</button>
                </div>
            </div>
        </form>
    </div>

</div>
<br/>
<span style="color: red;" id="cntcont2">

    </span>
</div>


<script type="text/javascript">
    function get_genpop() {
        var ayear = $("#ayer3").val();


        window.open("genpop.php?ayear=" + ayear, "General population list", "outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");

    }

</script>

