<?php
include_once '../admin/chck_sub.php';

include_once '../admin/objts/config.php';
$cf = new config();
$cf->connect();
$stid = $_GET['stid'];
$cls = $_GET['cls'];
$ayear = $_GET['ayear'];
$term = $_GET['term'];
$subjt = $_GET['subjt'];
$per_page = 1;
$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $per_page;
//$cnsql = mysqli_query($cf->con, "select id,fname,lname,oname,photo from stuinfo where class='$cls' and id like '%$stid%' and ayear = '$ayear' and id  not in (select stid from records  where (ta1 is not null and ta1>0) and (ta2 is not null and ta2>0) and (ta3 is not null and ta3>0) and (ta4 is not null and ta4 >0 ) and acyear = '$ayear' and term = '$term' and subjt = '$subjt' and cls = '$cls') and id not in(SELECT stid from withdraw)");
$stinputs = mysqli_query($cf->con, "select id,fname,lname,oname,photo from stuinfo where class='$cls' and id like '%$stid%' and ayear = '$ayear' and id not in (select stid from records where (ta1 is not null and ta1>0) or (ta2 is not null and ta2>0) or (ta3 is not null and ta3>0) or (ta4 is not null and ta4 >0 ) and acyear = '$ayear' and term = '$term' and subjt = '$subjt' and cls = '$cls') and id not in(SELECT stid from withdraw) order by fname ASC, lname ASC ");
//$recount = mysqli_num_rows($cnsql);
//$pages = ceil($recount / $per_page);
if (mysqli_num_rows($stinputs) > 0) {
    ?>
    <div style="height: 800px !important; overflow-x: hidden !important; overflow-y: auto; width: 100%;">
        <form id="batchtaskform">
            <div class="row">
                <div class=" col-md-12 col-sm-12 col-12 ">
                    <div class="alert alert-info">
                        <ul>
                            <li>
                                Please leave the input boxes empty if you want to skip a student
                            </li>

                            <li>
                                The system will skip students with empty records
                            </li>

                            <li class="bg-warning text-dark">
                                Records under this category MUST aum up to a maximum of 40 Any invalid records will NOT be saved
                            </li>
                        </ul>


                    </div>
                </div>

            </div>
            <div class="list-group">
            <?php
            while ($row = mysqli_fetch_assoc($stinputs)) { ?>

                <div class="list-group-item">

                <input name="stud[]" type="hidden" value="<?= $row['id'] ?>" id="stid"/>

                <div class="row">

                    <div class=" col-md-2 co-sm-4 col-4">
                        <img src="<?= file_exists('../admin/'.$row['photo']) ? '../admin/'.$row['photo'] : '../admin/objts/dpic/photo.jpg' ; ?>" width="180" height="200" class="img-thumbnail"/>
                    </div>

                    <div class=" col-md-10 col-sm-8 col-8">
                        <div class="row">
                            <div class="col-md-12">
                                <h6><?= $row['fname'] . " " . $row['lname'] . " " . $row['oname']; ?></h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="md-form">
                                <input min="0" required="required" name="task1[]" autofocus style="text-align: center" id="ta1" class="form-control taskinput" type="number" value="0"/>
                                <label for="ta1" class="control-label active">Task One</label>
                             </div>

                            </div>
                            <div class="col-md-3">
                                <div class="md-form">
                                <input min="0" required="required" name="task2[]" style="text-align: center" id="ta2" class="form-control taskinput" type="number" value="0"/>
                                <label for="ta2" class="control-label active">Task Two</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="md-form">
                                    <input min="0" required="required" name="task3[]" style="text-align: center" id="ta3" class="form-control taskinput" type="number" value="0"/>
                                    <label for="ta3" class="control-label active">Task Three</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="md-form">
                                    <input min="0" value="0" required="required" name="task4[]" style="text-align: center" id="ta4" class="form-control taskinput" type="number"/>
                                    <label for="ta4" class="control-label active">Task Four</label>
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
        because class task records on all students in this class were recorded or no student exist in the selected class
    </h2>
    <?php

}

?>
<script>


    function savtask() {

        $("#batchtaskform").submit();
    }

    $(document).ready(function () {
        $("#batchtaskform").submit(function () {

            var progress = Snarl.addNotification({
                title: "Please Wait...",
                text: "Saving class task record",
                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-circle-o-notch fa-spin'></i>",
                timeout: null
            });
            $(".snarl-notification").addClass('snarl-info');
            var cls = $("#assess_class").val();
            var term = $("#assess-term").val();
            var ayear = $("#assess-ayear").val();
            var sub = $("#assess-subjt").val();
            var data = $("#batchtaskform :input").serializeArray();
            $
                .post("savebatchtask.php?cls=" + cls + "&term=" + term + "&ayear=" + ayear + "&sub=" + sub, data)
                .done(function () {
                    $("#assess-subjt").change();
                    cloasedlgs();
                    Snarl.removeNotification(progress);
                    Snarl.addNotification({
                        title: "Save",
                        text: "Record Saved Successfully",
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


        $("#ta1,#ta2,#ta3,#ta4").focusin(function () {
            if (Number($(this).val()) <= 0) {
                $(this).val("");
            }

        });
        $("#ta1,#ta2,#ta3,#ta4").focusout(function () {
            if (Number($(this).val()) <= 0) {
                $(this).val(0);
            }

        });

        $("#ta1,#ta2,#ta3,#ta4").keypress(function (e) {
            if (e.which === 13) {
                savtask();
            }
        });
    });

</script>
    