<?php
include_once '../admin/chck_sub.php';
include_once '../admin/objts/config.php';
$cf = new config();
$cf->connect();
$cls = $_GET['cls'];
$ayear = $_GET['ayear'];
$term = $_GET['term'];
$subjt = $_GET['subjt'];
$stid = $_GET['stid'];
$per_page = 1;
//$page_query = mysqli_query("select count(*) from stuinfo where class='$cls' and");
//$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
//$start = ($page - 1) * $per_page;
//$cnsql = mysqli_query($cf->con, "select id,fname,lname,oname,photo from stuinfo where class='$cls' and  id like '%$stid%' and ayear = '$ayear' and id  not in (select stid from records  where (hw1 is not null and hw1>0) and (hw2 is not null and hw2 > 0) and (hw3 is not null and hw3 > 0) and (hw4 is not null and hw4>0) and acyear = '$ayear' and term = '$term' and subjt = '$subjt' and cls = '$cls' ) and id not in(SELECT stid from withdraw)");
$stinputs = mysqli_query($cf->con, "select id,fname,lname,oname,photo from stuinfo where class='$cls'and id like '%$stid%' and ayear = '$ayear' and id not in (select stid from records where (hw1 is not null and hw1>0) or (hw2 is not null and hw2 > 0) or (hw3 is not null and hw3 > 0) or (hw4 is not null and hw4>0) and acyear = '$ayear' and term = '$term' and subjt = '$subjt' and cls = '$cls') and id not in(SELECT stid from withdraw) order by fname ASC, lname ASC");
//$recount = mysqli_num_rows($cnsql);
//$pages = ceil($recount / $per_page);

if (mysqli_num_rows($stinputs) > 0) {

    ?>
    <div style="height: 800px !important; overflow-x: hidden !important; overflow-y: auto;">

        <form id="batchhwform">
            <div class="row">
                <div class=" col-md-12 col-12 ">
                    <div class="alert alert-info">
                        <ul>
                            <li>
                                Please leave the input boxes empty if you want to skip a student
                            </li>

                            <li>
                                The system will skip students with empty records
                            </li>
                            <li class="bg-warning text-dark">
                                Records under this category MUST aum up to a maximum of 40. Any Invalid records will NOT be saved
                            </li>
                        </ul>
                    </div>
                </div>

            </div>

            <div class="list-group">
            <?php

            while ($row = mysqli_fetch_assoc($stinputs)) {
                ?>
                <div class="list-group-item">
                <input name="stud[]" type="hidden" value="<?= $row['id'] ?>" id="stid2"/>
                <div class="row">
                    <div class="col-lg-2 col-md-2 co-sm-4 col-xs-4">
                        <img src="<?= file_exists('../admin/'.$row['photo']) ? '../admin/'.$row['photo'] : '../admin/objts/dpic/photo.jpg' ; ?>" width="180" height="200"
                             class="img-thumbnail img-rounded"/>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-8">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <h6> <?= $row['fname'] . " " . $row['lname'] . " " . $row['oname']; ?></h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-3">
                                <div class="md-form">
                                <input min="0" name="hw1[]" style="text-align: center" id="hw1" class="form-control" type="number" value="0"/>
                                <label for="hw1" class="control-label active">Assign. One</label>
                                </div>
                                </div>
                            <div class=" col-md-3">
                                <div class="md-form">
                                    <input min="0" name="hw2[]" style="text-align: center" id="hw2" class="form-control" type="number" value="0"/>
                                    <label for="hw2" class="control-label active">Asign. Two</label>
                                </div>

                            </div>
                            <div class="col-md-3">
                                <div class="md-form">
                                    <input min="0" name="hw3[]" style="text-align: center" id="hw3" class="form-control" type="number" value="0"/>
                                    <label for="hw3" class="control-label active">Asign. Three</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="md-form">
                                <input name="hw4[]" style="text-align: center" id="hw4" class="form-control" type="number" value="0"/>
                                <label for="hw4" class="control-label active">Asign. Four</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <?php
            }
            ?>
            </div>
        </form>
    </div>
    <?php
} else {
    ?>
    <h2 class="text-muted"><span class="glyphicon glyphicon-warning-sign"></span>Sorry, no records found, this could be
        because Assignment records on all students in this class were recorded or no student exist in the selected class
    </h2>
    <?php
}
?>
<script>
    function savhwork() {
        $("#batchhwform").submit();
    }

    $(document).ready(function () {
        $("#batchhwform").submit(function () {
            var cls = $("#assess_class").val();
            var term = $("#assess-term").val();
            var ayear = $("#assess-ayear").val();
            var sub = $("#assess-subjt").val();
            var progress = Snarl.addNotification({
                title: "Please Wait...",
                text: "Saving Assignment record",
                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-circle-o-notch fa-spin'></i>",
                timeout: null
            });
            $(".snarl-notification").addClass('snarl-info');
            var data = $("#batchhwform :input").serializeArray();
            $
                .post("savebatchhw.php?clas=" + cls + "&term=" + term + "&ayear=" + ayear + "&sub=" + sub, data)

                .done(function () {
                    $("#assess-subjt").change();
                    cloasedlgs();
                    Snarl.removeNotification(progress);
                    Snarl.addNotification({
                        title: "Saved",
                        text: "Assignment Records saved successfully",
                        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle'></i>",
                        timeout: 5000
                    });
                    $(".snarl-notification").addClass('snarl-success');
                })
                .error(function () {
                    Snarl.removeNotification(progress);
                    Snarl.addNotification({
                        title: "Error",
                        text: "Something went wrong, please check your connection and try again",
                        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                        timeout: 5000
                    });
                    $(".snarl-notification").addClass('snarl-error');
                });

            return false;

        });

        $("#hw1,#hw2,#hw3,#hw4").focusin(function () {
            if (Number($(this).val()) <= 0) {
                $(this).val("");
            }

        });
        $("#hw1,#hw2,#hw3,#hw4").focusout(function () {
            if (Number($(this).val()) <= 0) {
                $(this).val(0);
            }

        });

        $("#hw1,#hw2,#hw3,#hw4").keypress(function (e) {
            if (e.which === 13) {
                savhwork();
            }

            if (!((e.which >= 47 && e.which <= 58) || e.which === 8 || e.which === 0)) {
                e.preventDefault();

            }

        });
    });
</script>
    