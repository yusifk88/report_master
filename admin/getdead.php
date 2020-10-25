<?php

require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\config;
use APP\Utitlity;
$ut = new utitlity();
$cf = new config();
$cf->connect();
$deadset = mysqli_query($cf->con, "select * from deadline");
$d = mysqli_fetch_object($deadset);
?>
<form id="deadfrm" action="setdeadling.php">
    <?php
    if ($d->status == "OFF") {
        ?>
        <div class="row">
            <div class="ccol-md-4 col-sm-6 col-6">
                <label class="control-label btn bg-info p-2 m-2" style="color: #fff;">ON
                    <input type="radio" class="form-control" name="status" value="ON"/>
                </label>
            </div>
            <div class="col-md-4 col-sm-6 col-6">
                <label class="control-label btn bg-info p-2 m-2" style="color: #fff;">OFF
                    <input type="radio" class="form-control" name="status" value="OFF" checked="checked"/>
                </label>
            </div>
        </div>
        <?php
    } else {
        ?>
        <div class="row">
            <div class="col-md-4 col-sm-6 col-6">
                <label class="control-label btn bg-info p-2 m-2" style="color: #fff;">ON
                    <input type="radio" class="form-control" checked="checked" name="status" value="ON"/>
                </label>
            </div>
            <div class="col-md-4 col-sm-6 col-6">
                <label class="control-label btn bg-info p-2 m-2" style="color: #fff;">OFF
                    <input type="radio" class="form-control" name="status" value="OFF"/>
                </label>
            </div>
        </div>
        <?php
    }
    ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 co-sm-12 col-xs-12">
            <label class="control-label">Date</label>
            <input type="date" class="form-control" value="<?= $d->ddate ?>" name="ddate" id="ddate"/>
        </div>
    </div>
</form>
<script>
    $(document).ready(function () {
        $("#deadfrm").submit(function () {
            var data = $("#deadfrm :input").serializeArray();
            $.post("setdeadling.php", data, function () {

            });
            return false;
        });
    });
</script>