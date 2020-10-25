<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\config;

$cf = new config();
$cf->connect();
$depts = mysqli_query($cf->con, "select * from dept");
?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <label for="" class="control-label">Programe</label>
        <select name="" id="anprog" class="form-control">
            <?php
            while ($row = mysqli_fetch_object($depts)) {
                ?>

                <option value="<?= $row->id ?>"><?= $row->depname ?></option>
                <?php
            }
            ?>
        </select>
    </div>
</div>

