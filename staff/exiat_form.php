<?php
include("objts/config.php");
$cf = new config();
$cf->connect();
$stid = $_GET['id'];
$stinfo = mysqli_fetch_object(mysqli_query($cf->con, "select * from stuinfo where id ='$stid'"));
$exeat_check = mysqli_fetch_object(mysqli_query($cf->con, "select exiat.*,staff.fname,staff.lname from exiat,staff WHERE stid = '$stid' and returned = 0 and staff.id = exiat.stfid"));
$exeat_history = mysqli_query($cf->con, "select exiat.*,staff.fname,staff.lname from exiat,staff WHERE stid = '$stid' and returned = 1 and staff.id = exiat.stfid");
?>
<div class="row">
    <div class="col-md-12 text-muted p-2 mb-2">
        <i class="fa fa-info-circle fa-2x  m-2"></i> A copy of this exeat could be sent to the parent through SMS But it
        is an on-demand feature and is not available on your package
    </div>
    <div class="col-12 col-md-3">
        <img class="img-responsive" src="<?= file_exists($stinfo->photo) ? $stinfo->photo : 'objts/dpic/photo.jpg' ?>"
             alt=""> <br/>
        <h6><?= $stinfo->fname . ' ' . $stinfo->lname . ' ' . $stinfo->oname ?></h6>
    </div>
    <?php
    if (!$exeat_check) {

        ?>
        <div class="col-12 col-md-9">
            <form action="" id="exeat_form">
                <input id="stid" name="stid" type="hidden" value="<?= $stid ?>">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="md-form">
                            <i class="prefix fa fa-clock-o active"></i>
                            <input required class="form-control" type="datetime-local" name="sign_dtime"
                                   id="sign_dtime">
                            <label for="sign_dtime" class="control-label active">Date/Time Signed</label>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="md-form">
                            <i class="prefix fa fa-clock-o active"></i>
                            <input required class="form-control" type="datetime-local" name="return_dtime"
                                   id="return_dtime">
                            <label for="return_dtime" class="control-label active">Expected Return Date/Time</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="md-form">
                            <select name="ex_type" id="ex_type" class="form-control">
                                <option selected value="in">Internal</option>
                                <option value="ex">External</option>
                            </select>
                            <label for="sign_dtime" class="control-label active">Exeat Type</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="md-form">
                            <textarea required name="reason" id="reason" class="form-control md-textarea"
                                      rows="5"></textarea>
                            <label for="reason" class="control-label">Reason for Exeat</label>
                        </div>
                    </div>

                </div>
                <button type="submit" class="btn bg-info text-white">Create Exeat</button>

            </form>
        </div>
        <?php
    } else {
        ?>
        <div class="col-12 col-md-9 border border-success">
            <h5>This student is already on exeat</h5>
            <strong>Reason for exeat</strong> <br>
            <span class="blockquote"><?= $exeat_check->reason ?>

                <span class="blockquote-footer">
              <span class="text-success label p-2 mt-4"><?= $exeat_check->date_signed ?></span> to
            <span class="text-danger p-2 mt-4"><?= $exeat_check->return_date ?></span>
            </span>
            </span>
            <p>
                <strong>Authorized By:</strong>
                <span><?= $exeat_check->fname . " " . $exeat_check->lname ?></span>

            </p>


        </div>
        <?php
    }
    ?>
</div>
<div class="row mt-2">
    <div class="col-md-12 col-12 bg-info p-3 text-center text-white">
        EXEAT HISTORY
    </div>
    <div class="table-responsive">
        <table class="table table-sm">
            <thead class="bg-info text-white">
            <tr>
                <th>#</th>
                <th>Reason</th>
                <th>Exeat Type</th>
                <th>Date/Time Signed</th>
                <th>Expected Returnd Date/Time</th>
                <th>Returned_Date/Time</th>
                <th>Signed By</th>
            </tr>

            </thead>
            <tbody id="exeat_listcont">
            <?php
            $i = 1;
            while ($exrow = mysqli_fetch_object($exeat_history)) {
                ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= $exrow->reason ?></td>
                    <td><?= $exrow->ex_type == 'ex' ? 'External ' : 'Internal ' ?>Exeat</td>
                    <td><?= $exrow->date_signed ?></td>
                    <td><?= $exrow->return_date ?></td>
                    <td><?= $exrow->returned_time ?></td>
                    <td><a href="" class="text-info"
                           onclick="printstf(<?= $exrow->stfid ?>); return false"><?= $exrow->fname . " " . $exrow->lname ?></a>
                    </td>

                </tr>
                <?php
                $i++;
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $("#exeat_form").submit(function () {

        var data = $("#exeat_form :input").serializeArray();

        $
            .post("save_exeat.php", data)
            .done(function () {
                cloasedlgs();
                Snarl.addNotification({
                    title: "CREATED",
                    text: "Exeat Created successfully",
                    icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle-o'></i>",
                    timeout: 3000
                });
                $(".snarl-notification").addClass('snarl-success');


            })
            .error(function () {

                show_error();
            });


        return false;

    });


</script>