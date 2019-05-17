<?php
include_once '../admin/chck_sub.php';

include_once '../admin/objts/config.php';
include_once '../admin/objts/staff.php';
$cfg = new config();
$cfg->connect();
$ayear = $_GET['ayear'];
$student = mysqli_fetch_object(mysqli_query($cfg->con, "select * from stuinfo where ayear = '$ayear'  and id not in(select stid from waec) and id not in (SELECT stid from withdraw) and form='3' ORDER  by lname ASC "));
if ($student) {
    $corsubs = mysqli_query($cfg->con, "select * from subjects where subjects.type='Core Subject' and subjdesc not LIKE '%ICT%' and subjdesc not like '%physical education%' and subjdesc not like '%pe%' and subjdesc not LIKE '%PE%' and subjdesc not like '%I.C.T%' and subjdesc not LIKE '%P.E%'");
    $elsubs = mysqli_query($cfg->con, "select * from subjects where subjects.type='Elective Subject' and subjects.id in (SELECT subjt from records where stid = '$student->id' )");
    ?>
    <form action="savewaec.php" id="frmsavewaec">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                <img src="../admin/<?= $student->photo ?>" alt="" class="img-thumbnail"/> <br>
                <?= strtoupper($student->lname . " " . $student->oname . " " . $student->fname) ?>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-6 col-xs-6">
                <input type="hidden" value="<?= $student->id ?>" name="stid">
                <?php
                while ($csub = mysqli_fetch_object($corsubs)) {
                    ?>
                    <div class="row">
                        <input type="hidden" name="sub[]" value="<?= $csub->id ?>">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label class="control-label"><?= $csub->subjdesc ?></label>
                            <select required name="grade[]" id="" class="form-control">
                                <option value="None">None</option>
                                <option value="A1">A1</option>
                                <option value="B2">B2</option>
                                <option value="B3">B3</option>
                                <option value="C4">C4</option>
                                <option value="C5">C5</option>
                                <option value="C6">C6</option>
                                <option value="D7">D7</option>
                                <option value="E8">E8</option>
                                <option value="F9">F9</option>
                                <option value="WH">WH</option>
                                <option value="CNL">CNL</option>
                            </select>
                        </div>
                    </div>
                    <?php
                }
                while ($esub = mysqli_fetch_object($elsubs)) {
                    ?>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <input type="hidden" name="sub2[]" value="<?= $esub->id ?>">
                            <label class="control-label"><?= $esub->subjdesc ?></label>
                            <select name="grade2[]" class="form-control">
                                <option value="None">None</option>
                                <option value="A1">A1</option>
                                <option value="B2">B2</option>
                                <option value="B3">B3</option>
                                <option value="C4">C4</option>
                                <option value="C5">C5</option>
                                <option value="C6">C6</option>
                                <option value="D7">D7</option>
                                <option value="E8">E8</option>
                                <option value="F9">F9</option>
                                <option value="WH">WH</option>
                                <option value="CNL">CNL</option>

                            </select>
                        </div>
                    </div>


                    <?php
                }


                ?>


            </div>
        </div>
    </form>
    <?php
} else {
    ?>
    <h2 class="text-muted">All waec records for the selected year have been entered</h2>
    <?php
}
?>

<script>

    $("#frmsavewaec").submit(function () {
        var recs = $("#frmsavewaec :input").serializeArray();
        $.post("savewaec.php", recs, function () {
            getwaec();
        });
        return false;

    });


</script>

