<?php

require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');

use APP\Utitlity;
use APP\config;
$ut = new utitlity();
$id = $_GET['id'];
$cf = new config();
$cf->connect();
$stud = mysqli_query($cf->con, "select fname,lname,oname,photo from stuinfo where id= '$id'");
$stuinfo = mysqli_fetch_object($stud);
$ayears = mysqli_query($cf->con, "select ayear from stuinfo where  id = '$id'");
$yea = mysqli_fetch_object($ayears);

?>
<div class="row">
    <div class="col-lg-2 col-md-2 col-sm-12 col-12 m-0 o-0">
        <img class="img-thumbnail" src="<?= file_exists($stuinfo->photo) ? $stuinfo->photo : 'objts/dpic/photo.jpg' ?>"
             alt="<?= $stuinfo->fname ?>" width="150" height="180"/>
        <br>
        <span class="text-muted"><?= $stuinfo->fname ?> <?= $stuinfo->lname ?> <?= $stuinfo->oname ?></span>
    </div>
    <div class="col-lg-10 col-md-10 col-sm-12 col-12">

        <form style="width: 100%;" id="cmtform" action="savecmnt.php">
            <div class="row">
                <input id="id" type="hidden" name="id" value="<?= $id; ?>">
                <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="md-form">
                        <i class="prefix fa fa-calendar-o active"></i>
                        <input name="ayear" type="text" value="<?= $yea->ayear; ?>" readonly class="form-control">
                        <label class="control-label active">Academic Year</label>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                    <label class="control-label">Term</label>
                    <select class="form-control" name="term">
                        <option value="1">1st Term</option>
                        <option value="2">2nd Term</option>
                        <option value="3">3rd Term</option>
                    </select>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="md-form">
                        <i class="prefix fa fa-calendar-check-o"></i>
                        <input class="form-control" type="date" name="dentry" id="dentry" required="required"
                               style="cursor: alias"/>
                        <label class="control-label active">Date</label>
                    </div>

                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="md-form">
                        <textarea id="cmnt" class="form-control md-textarea" rows="3" name="cmnt"
                                  required="required"></textarea>
                        <label for="cmt" class="control-label">Brief Comment on this student...</label>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">

                    <button id="savecmt" type="submit" class="btn bg-info">Save</button>
                </div>
            </div>
        </form>

    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
        <?php
        $cmts = mysqli_query($cf->con, "select * from ginfo where stid = '$id' order by id DESC ");
        ?>
        <div class="table-responsive" id="cmnttbl">
            <table class="table table-stripped table-sm table-hover">
                <thead class="bg-info text-white">
                <tr>
                    <th>S/N</th>
                    <th>Comment</th>
                    <th>Academic Year</th>
                    <th>Term</th>
                    <th>Date</th>
                    <th style="text-align: center;">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 1;
                while ($row = mysqli_fetch_object($cmts)) {

                    ?>
                    <tr id="tr_<?= $row->id; ?>">
                        <td><?= $i; ?></td>
                        <td><?= $row->coment; ?></td>
                        <td><?= $row->ayear; ?></td>
                        <td><?= $ut->addsufix($row->term); ?> Term</td>
                        <td><?= $row->dentry; ?></td>
                        <td style="text-align: center;"><i onclick="delcomm(<?= $row->id; ?>);"
                                                           title="Delete this Comment" data-toggle="tooltip"
                                                           style="color: red; cursor: pointer;"
                                                           class="fa fa-remove waves-circle waves-effect"></i></td>


                    </tr>


                    <?php
                    $i++;
                };
                ?>

                </tbody>

            </table>
        </div>


    </div>
</div>

<script>

    function cmntlist(id) {
        showprogress("cmnttbl");
        $.get("cmntlist.php?id=" + id, function (data) {

        }).done(function (data) {


            $("#cmnttbl").html(data);
        });
    }


    function delcomm(id) {
        var trid = "#tr_" + id;

        BootstrapDialog.show({
            title: "Confirm Delete",
            message: "Do you want to delete this comment? ",
            buttons: [{
                label: "DELETE", cssClass: "btn-good waves-effect waves-button", action: function (d) {
                    d.close();
                    fullProg();
                    $.get("delcmnt.php?id=" + id, function () {
                    }).done(function () {
                        remove_fullprog();
                        $(trid).fadeOut(100).remove();

                    });
                }
            }]
        });


    }


    $(document).ready(function () {

        $("#cmtform").submit(function () {

            var data = $("#cmtform :input").serializeArray();
            if (!$("#dentry").val()) {
                $("#dentry").focus();
            } else if (!$("#cmnt").val()) {
                $("#cmnt").focus();
            } else {
                fullProg();
                $.post($("#cmtform").attr('action'), data, function () {
                }).done(function () {
                    remove_fullprog();

                    cmntlist($("#id").val());
                });
            }
            return false;

        });
    });
</script>