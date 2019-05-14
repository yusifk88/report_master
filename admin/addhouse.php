<?php
include_once './objts/config.php';
$cf = new config();
$cf->connect();
$stfid = $_GET['id'];
$staff = mysqli_fetch_object(mysqli_query($cf->con, "select * from staff where id = '$stfid'"));
$duties = mysqli_query($cf->con, "select * from duties where stfid = '$stfid'");
$houses = mysqli_query($cf->con, "select * from houses WHERE houses.id not in (SELECT  hid from housem where stfid = '$stfid' ) and house_type = 'genhouse'");
$myhouse = mysqli_query($cf->con, "select houses.name,housem.id from houses,housem where housem.stfid = '$stfid' and  houses.id = housem.hid");
?>
<div class="row" style="border-bottom: 1px solid #ccc;">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <img src="<?= ($staff->photo) ? $staff->photo : 'objts/dpic/photo.jpg' ?>"
             class="img-responsive img-thumbnail img-rounded" alt="">
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <h5><?= strtoupper($staff->fname . " " . $staff->lname) ?></h5>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <input type="hidden" value="<?= $stfid ?>" id="stfid">
        <label for="" class="control-label">Select House</label>
        <select class="form-control" id="houses">
            <?php
            while ($hrow = mysqli_fetch_object($houses)) {
                ?>
                <option value="<?= $hrow->id ?>"><?= $hrow->name ?>(<?= $hrow->des ?>)</option>
                <?php
            }
            ?>
        </select>
    </div>
</div>
<br>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <label class="control-label">CURRENT HOUSE</label>
        <div class="card">
            <div class="card-body">
                <?php
                while ($h = mysqli_fetch_object($myhouse)) {
                    ?>
                    <div class="list-group list-group-flush" id="house-row<?= $h->id ?>">
                        <div class="list-group-item">
                            <div class="row">

                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <?= $h->name ?>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                    <i onclick="delhm(<?= $h->id ?>)"
                                       class="fa fa-remove text-danger pull-right waves-effect waves-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
<script>
    function mkhm() {
        var data = {
            stfid: $("#stfid").val(),
            house: $("#houses").val();
        };
        if ($("#houses").val().length > 0) {
            $
                .post("mkhm.php", data)
                .done(function () {
                    Snarl.addNotification({
                        title: "SUCCESSFUL",
                        text: "Your house assignment was successful",
                        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle'></i>",
                        timeout: 3000
                    });
                    $(".snarl-notification").addClass('snarl-success');
                })
                .error(function () {
                    Snarl.addNotification({
                        title: "ERROR",
                        text: "Sorry we could not assign the house",
                        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                        timeout: 3000
                    });
                    $(".snarl-notification").addClass('snarl-error');
                });
        }
    }
</script>
