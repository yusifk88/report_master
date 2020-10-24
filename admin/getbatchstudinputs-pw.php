<?php

include_once './objts/config.php';
$cf = new config();
$cf->connect();
$cls = $_GET['cls'];
$stid = $_GET['stid'];
$ayear = $_GET['ayear'];
$term = $_GET['term'];
$subjt = $_GET['subjt'];
$per_page = 1;
$page_query = mysqli_query($cf->con, "select count(*) from stuinfo where class='$cls' and");
$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $per_page;
$cnsql = mysqli_query($cf->con, "select id,fname,lname,oname,photo from stuinfo where class='$cls' and id like '%$stid%' and id  not in (select stid from records  where (pw1 is not null or pw1=0) and (pw2 is not null or pw2=0) and acyear = '$ayear' and term = '$term' and subjt = '$subjt' and cls = '$cls' ) and id not in(SELECT stid from withdraw)");
$stinputs = mysqli_query($cf->con, "select id,fname,lname,oname,photo from stuinfo where class='$cls' and id like '%$stid%' and id not in (select stid from records where (pw1 is not null or pw1 = 0) and (pw2 is not null or pw2 =0) and acyear = '$ayear' and term = '$term' and subjt = '$subjt' and cls = '$cls') and id not in(SELECT stid from withdraw) order by fname ASC, lname ASC");
$recount = mysqli_num_rows($cnsql);
$pages = ceil($recount / $per_page);

if (mysqli_num_rows($stinputs) > 0) {
    ?>
    <div style="height: 800px !important; overflow-x: hidden !important; overflow-y: auto;">
        <form id="batchpwform">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 col-md-offset-1 col-lg-offset-1">
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

            <?php


            while ($row = mysqli_fetch_assoc($stinputs)) {
                ?>

                <input name="stud[]" type="hidden" value="<?= $row['id'] ?>" id="stid3"/>
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-lg-offset-1 col-md-offset-1 co-sm-4 col-xs-4">
                        <img src="<?= $row['photo']; ?>" width="180" height="200" class="img-thumbnail"/>


                    </div>


                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <h5><?= $row['fname'] . " " . $row['lname'] . " " . $row['oname']; ?></h5>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4">
                                <label class="control-label">Project W. One</label>
                                <input min="1" max="20" name="pw1[]" maxlength="2" style="text-align: center" id="pw1"
                                       class="form-control" type="number" value="0"/>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <label class="control-label">Project W. Two</label>
                                <input min="1" max="20" name="pw2[]" maxlength="2" style="text-align: center" id="pw2"
                                       class="form-control" type="number" value="0"/>
                            </div>

                        </div>

                    </div>
                </div>

                <?php
            }
            ?>


        </form>
    </div>


    <?php


} else {
    ?>
    <h2 class="text-muted"><span class="glyphicon glyphicon-warning-sign"></span>Sorry, no records found, this could be
        because Project Work records on all students in this class were recorded or no student exist in the selected
        class </h2>
    <?php

}

?>


<script>


    function savpwork() {
        $("#batchpwform").submit();
    }

    $(document).ready(function () {
        $("#batchpwform").submit(function () {
            var cls = $("#assess_class").val();
            var term = $("#assess-term").val();
            var ayear = $("#assess-ayear").val();
            var sub = $("#assess-subjt").val();

            var progress = Snarl.addNotification({
                title: "Please Wait...",
                text: "Saving Project Work record",
                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-circle-o-notch fa-spin'></i>",
                timeout: null
            });
            $(".snarl-notification").addClass('snarl-info');
            var data = $("#batchpwform :input").serializeArray();
            $
                .post("savebatchpw.php?cls=" + cls + "&term=" + term + "&ayear=" + ayear + "&sub=" + sub, data)
                .done(function () {
                    $("#assess-subjt").change();
                    cloasedlgs();
                    Snarl.removeNotification(progress);
                    Snarl.addNotification({
                        title: "Saved",
                        text: "Project Work record saved",
                        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle'></i>",
                        timeout: null
                    });
                    $(".snarl-notification").addClass('snarl-success');
                })
                .error(function () {
                    Snarl.removeNotification(progress);
                    Snarl.addNotification({
                        title: "Erorr",
                        text: "Something went wrong, please check your connection and try again",
                        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                        timeout: 8000
                    });
                    $(".snarl-notification").addClass('snarl-error');


                });

            return false;
        });


        $("#pw1,#pw2").focusin(function () {
            if (Number($(this).val()) <= 0) {
                $(this).val("");
            }

        });
        $("#pw1,#pw2").focusout(function () {
            if (Number($(this).val()) <= 0) {
                $(this).val(0);
            }

        });

        $("#pw1,#pw2").keypress(function (e) {
            if (e.which === 13) {
                savpwork();
            }

            if (!((e.which >= 47 && e.which <= 58) || e.which === 8 || e.which === 0)) {
                e.preventDefault();

            }


        });


    });


</script>
    