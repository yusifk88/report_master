<?php
include_once("objts/config.php");
$cf = new config();
$cf->connect();
$ayears = mysqli_query($cf->con, "select distinct(ayear) from stuinfo ORDER by ayear ASC");
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <label for="" class="form-control-label">Year</label>
        <select class="form-control" name="" id="entry_year">
            <?php
            while ($row = mysqli_fetch_object($ayears)) {

                ?>
                <option value="<?= $row->ayear ?>"><?= $row->ayear ?></option>
                <?php
            }

            ?>
        </select>
        <label for="" class="form-control-label">Term</label>
        <select class="form-control" name="" id="entry_term">
            <option value="1">1st Term</option>
            <option value="2">2nd Term</option>
            <option value="3">3rd Term</option>

        </select>
    </div>
</div>
