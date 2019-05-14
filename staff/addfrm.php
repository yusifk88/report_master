<?php
include_once '../admin/objts/config.php';
include_once '../admin/objts/school.php';
include_once '../admin/objts/utitlity.php';
$cf = new config();
$sch = new school();
$util = new utitlity();
$cf->connect();
$cls = $_GET['cls'];
$ayear = $_GET['ayear'];
$term = $_GET['term'];
session_start();
$svattendance = isset($_SESSION['attendance']) ? $_SESSION['attendance'] : "";
$per_page = 1;
$page_query = mysqli_query($cf->con, "select count(*) from stuinfo where class='$cls' and ayear = '$ayear' ");
$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $per_page;
$cnsql = mysqli_query($cf->con, "select id,fname,lname,oname,photo from stuinfo where class='$cls' and  ayear = '$ayear' AND id  not in (select stid from frmass  where term = '$term' and cls = '$cls' and ayear = '$ayear' ) and id not in (select stid from withdraw)");
$stinputs = mysqli_query($cf->con, "select id,fname,lname,oname,photo from stuinfo where class='$cls' and ayear = '$ayear' AND id  not in (select stid from frmass where ayear = '$ayear' and term = '$term' and cls = '$cls') and id not in (select stid from withdraw) order by stuinfo.fname ASC LIMIT " . $start . "," . $per_page);
$recount = mysqli_num_rows($cnsql);
$pages = ceil($recount / $per_page);
if (mysqli_num_rows($stinputs) > 0) {
    while ($row = mysqli_fetch_assoc($stinputs)) {
        $page++;
        ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-info" style="border-radius: 0; box-shadow: none; margin: 0 !important;">
                    <div class="panel-body" style="padding: 0 !important; margin: 0 !important;">
                        <form id="frmaddfrm">
                            <input type="hidden" value="<?= $row['id'] ?>" id="frmstid"/>
                            <div class="row">
                                <div class="col-lg-2 col-md-2 co-sm-12 col-xs-12 text-center">
                                    <img src="<?= file_exists('../admin/'.$row['photo'])? '../admin/'.$row['photo'] : '../admin/objts/dpic/photo.jpg' ; ?>" width="150" height="180" class="img-thumbnail"/>
                                    <br>
                                    <strong class="text-muted"><?= $row['fname'] . " " . $row['lname'] . " " . $row['oname'] ?></strong>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="md-form">
                                                <input min="0" id="attndance" value="<?= $svattendance ?>" required class="form-control" type="number" name="attndance"/>
                                                <label for="attndance" class="control-label">Total Att</label>
                                            </div>

                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="md-form">
                                                <input id="attnded" min="0" required class="form-control" type="number" name="attnded"/>
                                                <label for="attnded" class="control-label">No. Attended</label>
                                            </div>

                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="md-form">
                                                <label for="cnduct" class="control-label active">Conduct</label>
                                                <select class="form-control" name="cnduct" id="cnduct">
                                                    <option value="Good">Good</option>
                                                    <option value="Very Good">Very Good</option>
                                                    <option value="Satisfactory">Satisfactory</option>
                                                    <option value="Fair">Fair</option>
                                                    <option value="Bad">Bad</option>
                                                    <option value="Very Bad">Very Bad</option>
                                                    <option value="Cannot say">Cannot say</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="md-form">
                                                <textarea required name="interest" class="form-control md-textarea" id="interest" rows="1"></textarea>
                                                <label for="interest" class="control-label">Interest</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="md-form">
                                                <textarea required name="remark" class="form-control md-textarea" id="remark" rows="1"></textarea>
                                                <label for="remark" class="control-label">Your Remark</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm12 col-xs-12">
                                    <div class="well well-sm" style="padding: 1px !important;  margin: 0 !important;">
                                        <?php
                                        $id = $row['id'];
                                        $stres = mysqli_query($cf->con, "select subjects.subjdesc,((subtotl*$sch->clscore_ratio)/$sch->sba+(exam*($sch->exam_ratio/100))) as tscore from subjects,records where records.subjt = subjects.id and records.term = '$term' and records.acyear = '$ayear' and records.stid = '$id'");
                                        // if(mysqli_num_rows($stres)>0){
                                        ?>
                                        <div class="table-responsive">
                                            <table class="table table-sm table-striped table-hover">
                                                <thead>
                                                <tr>
                                                    <th>Subject</th>
                                                    <th>Score</th>
                                                    <th>Grade</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                while ($rec = mysqli_fetch_object($stres)) {
                                                    ?>
                                                    <tr>
                                                        <td><?= $rec->subjdesc ?></td>
                                                        <td><?= number_format($rec->tscore, 2) ?></td>
                                                        <td><?= $util->getgrd(number_format($rec->tscore, 1)) ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="panel-footer">
                        <input type="hidden" value="<?= $page ?>" id="nexval4"/>
                        <?php
                        if (($pages - $page) > -1) {
                            ?>
                            <button id="frmskipbtn" onclick="frmskipstud(<?= $page ?>)" type="button"
                                    class="btn rgba-cyan-strong pull-right btn-sm">Skip &GreaterGreater;
                            </button>
                            <input type="hidden" value="notend" id="endval3"/>
                            <?php
                        } else {
                            ?>
                            <input type="hidden" value="end" id="endval4"/>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
} else {
    ?>
    <h2 class="text-muted"><span class="glyphicon glyphicon-warning-sign"></span>Sorry, no records found</h2>
    <?php
}
?>
<script>
    function frmskipstud(page) {
        if ($("#endval4").val() === "end") {
        } else {
            $.get("addfrm.php?page=" + page + "&cls=" + $("#frm_class").val() + "&ayear=" + $("#frm-ayear").val() + "&term=" + $("#frm-term").val(), function (data) {
                $("#frm-cont").html(data);
            });
        }
    }

    function savefrm() {
        $("#frmaddfrm").submit();
    }

    $("#attndance,#attnded").keypress(function (e) {
        if (!((e.which >= 47 && e.which <= 58) || e.which === 8 || e.which === 0)) {
            e.preventDefault();
        }
    });
    $("#frmaddfrm").submit(function () {

        if (!$("#attndance").val()) {

            $("#attndance").focus();

        } else if (!$("#attnded").val()) {

            $("#attnded").focus();
        } else if (!$("#interest").val()) {

            $("#interest").focus();
        } else if (!$("#remark").val()) {

            $("#remark").focus();
        } else {

            fullProg();
            $.get("savefrm.php?stid=" + $("#frmstid").val() + "&attndance=" + $("#attndance").val() + "&cnduct=" + $("#cnduct").val() + "&remark=" + $("#remark").val() + "&interest=" + $("#interest").val() + "&attnded=" + $("#attnded").val() + "&term=" + $("#frm-term").val() + "&ayear=" + $("#frm-ayear").val() + "&cls=" + $("#frm_class").val(), function (data) {
            }).done(function (data) {
                Snarl.addNotification({
                    title: "SAVE",
                    text: data,
                    icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                    timeout: 8000
                });
                $(".snarl-notification").addClass('snarl-info');


                $("#frm_class").change();
                frmskipstud(1);
                remove_fullprog();

            });
        }
        return false;
    });

</script>
