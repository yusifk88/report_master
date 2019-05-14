<?php
include_once("./objts/config.php");
include_once("./objts/rclass.php");
$cf = new config();
$cf->connect();

$clas = new Rclass();
$cl = $clas->getclasses();

$ayears = mysqli_query($cf->con, "select distinct(ayear) from stuinfo");

?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <label for="acayear" class="control-label">Academic Year</label>
        <select name="" id="acayear" class="form-control">
            <?php
            while ($ays = mysqli_fetch_object($ayears)) {
                ?>
                <option value="<?= $ays->ayear ?>"><?= $ays->ayear ?></option>
                <?php
            }
            ?>
        </select>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <label for="acclas" class="control-label">Class</label>
        <select name="" id="acclas" class="form-control">
            <?php
            while ($cls = mysqli_fetch_object($cl)) {
                ?>
                <option value="<?= $cls->id ?>"><?= $cls->classname ?></option>
                <?php
            }
            ?>
        </select>
    </div>
</div>
<br>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="md-form">
            <i class="prefix fa fa-font"></i>
            <textarea id="actitle" class="form-control md-textarea"></textarea>
            <label for="actitle">Customize the heading of this document</label>
        </div>


    </div>
</div>


