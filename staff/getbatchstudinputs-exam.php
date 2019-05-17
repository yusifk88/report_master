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

//$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
//$start = ($page - 1) * $per_page;
//$cnsql = mysqli_query($cf->con, "select id,fname,lname,oname,photo from stuinfo where class='$cls'and id like '%$stid%' and ayear = '$ayear' and  id  not in (select stid from records  where exam >0 and acyear = '$ayear' and term = '$term' and subjt = '$subjt' and cls = '$cls' ) and id not in(SELECT stid from withdraw)");
$stinputs = mysqli_query($cf->con, "select id,fname,lname,oname,photo from stuinfo where class='$cls' and id like '%$stid%' and ayear = '$ayear' and id not in (select stid from records where exam >0 and acyear = '$ayear' and term = '$term' and subjt = '$subjt' and cls = '$cls') and id not in(SELECT stid from withdraw) order by fname ASC, lname ASC ");
//$recount = mysqli_num_rows($cnsql);
//$pages = ceil($recount / $per_page);

if (mysqli_num_rows($stinputs) > 0) {

    ?>
    <div style="height: 800px !important; overflow-x: hidden !important; overflow-y: auto;">
        <form id="batchexamform">
            <div class="row">
                <div class="col-md-12 col-12">
                    <div class="alert alert-info">
                        <ul>
                            <li>
                                Please leave the input boxes empty if you want to skip a student
                            </li>

                            <li>
                                The system will skip students with empty records
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
                <input name="stud[]" type="hidden" value="<?= $row['id'] ?>" id="stid4"/>
                <div class="row">
                    <div class=" col-lg-offset-1 col-md-offset-1 col-lg-2 col-md-2 co-sm-4 col-xs-4">
                        <img src="<?= file_exists('../admin/'.$row['photo']) ? '../admin/'.$row['photo'] : '../admin/objts/dpic/photo.jpg' ; ?>" width="180" height="200" class="img-thumbnail"/>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <h6><?= $row['fname'] . " " . $row['lname'] . " " . $row['oname']; ?></h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="md-form">
                                    <input min="1" max="100" name="examval[]" autofocus maxlength="3" style="text-align: center" id="exam_val" class="form-control exam" type="number" value="0"/>
                                    <label for="exam_val" class="control-label active">Exam Score(100%)</label>

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
        because Exam records on all students in this class were recorded or no student exist in the selected class </h2>
    <?php
}

?>
<script>
    function savexam() {
        $("#batchexamform").submit();
    }

    $(document).ready(function () {

        $(".exam").focusin(function () {
            if (Number($(this).val()) <= 0) {
                $(this).val("");
            }

        });

        $(".exam").focusout(function () {
            if (Number($(this).val()) <= 0) {
                $(this).val(0);
            }

        });
        $(".exam").keypress(function (e) {
            if (e.which === 13) {
                savexam();
            }

            if (!((e.which >= 47 && e.which <= 58) || e.which === 8 || e.which === 0)) {
                e.preventDefault();

            }
        });


        $("#batchexamform").submit(function () {
            var cls = $("#assess_class").val();
            var term = $("#assess-term").val();
            var ayear = $("#assess-ayear").val();
            var sub = $("#assess-subjt").val();
            var data = $("#batchexamform :input").serializeArray();

            var progress = Snarl.addNotification({
                title: "Please Wait...",
                text: "Saving exam records",
                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-circle-o-notch fa-spin'></i>",
                timeout: null
            });
            $(".snarl-notification").addClass('snarl-info');


            $
                .post("savebatchexam.php?term=" + term + "&cls=" + cls + "&ayear=" + ayear + "&sub=" + sub, data)
                .done(function () {
                    cloasedlgs();
                    $("#assess-subjt").change();
                    Snarl.removeNotification(progress);
                    Snarl.addNotification({
                        title: "SAVED",
                        text: "Exam Records saved successfully",
                        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle-o'></i>",
                        timeout: 3000
                    });
                    $(".snarl-notification").addClass('snarl-success');
                })
                .error(function () {
                    Snarl.removeNotification(progress);
                    Snarl.addNotification({
                        title: "ERROR",
                        text: "something went wrong, please check your connection and try again",
                        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                        timeout: 3000
                    });
                    $(".snarl-notification").addClass('snarl-error');
                });

            return false;
        });


    });


</script>
    