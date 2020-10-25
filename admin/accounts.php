<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\config;
$cf = new config();
$cf->connect();

$acc = mysqli_query($cf->con, "select id,uname,upass,type,status from staff");
$ayear = mysqli_query($cf->con, "select distinct(ayear) from stuinfo");

?>

<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 mx-auto">
    <div class="alert bg-warning">
        <h4><i class="fa fa-info"></i> If you want to delete a user account, please go to the staff view and delete the
            staff</h4>
    </div>
    <div class="card" style="border-radius: 0;">

                <div class="card-header bg-primary">
                    <p class="card-title text-white">Manage User Accounts</p>
                </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                <div class="table-responsive">

                    <table class="table table-condensed table-hover table-striped">
                        <thead>
                        <th>S/N</th>
                        <th>Email</th>
                        <th>User Type</th>
                        <th>Status</th>
                        <th colspan="2">Action</th>


                        </thead>
                        <tbody>

                        <?php
                        $i = 1;
                        while ($row = mysqli_fetch_object($acc)) {
                                ?>
                                <tr>

                                    <td>
                                        <?= $i; ?>

                                    </td>
                                    <td>
                                        <?= $row->uname; ?>

                                    </td>
                                    <td>
                                        <?= $row->type; ?>

                                    </td>
                                    <td style="font-style: italic;" class="<?=$row->status == 'active' ? 'text-success' : 'text-danger'?>">
                                        <?= $row->status; ?>
                                    </td>
                                    <td>
                                        <i onclick="resetpass(<?= $row->id; ?>)" title="Reset user's password"
                                           style="color: deepskyblue; cursor: pointer;"
                                           class="fa fa-refresh waves-effect waves-circle"></i>

                                    </td>
                                    <td>
                                        <i onclick="disacc(<?= $row->id; ?>)" title="Disable user Account"
                                           style="color: red; cursor: pointer;"
                                           class="fa fa-power-off waves-effect waves-circle"></i>
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

        </div>


    </div>
    <br/>
    <span style="color: red;" id="cntcont2">
  
    </span>
</div>


<script type="text/javascript">
    function resetpass(id) {
        fullProg();

        $.get("resetpass.php?id=" + id, function (data) {
            remove_fullprog();
            BootstrapDialog.show({
                title: "Reset Account",
                message: data,
                buttons: [{
                    label: "RESET", cssClass: "btn-good waves-button waves-effect", action: function (d) {


                        if (!$("#new_pass").val() || !$("#cnew_pass").val()) {
                            exit();

                        }
                        if ($("#new_pass").val() === $("#cnew_pass").val()) {

                            fullProg();
                            $.get("do_reset.php?id=" + id + "&new_pass=" + $("#new_pass").val(), function () {

                            }).done(function () {
                                remove_fullprog();
                                d.close();

                                Snarl.addNotification({
                                    title: "ERROR",
                                    text: "Password reset successfully",
                                    icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle'></i>",
                                    timeout: 3000
                                });
                                $(".snarl-notification").addClass('snarl-success');

                                getaccounts();
                            });
                        } else {

                            Snarl.addNotification({
                                title: "ERROR",
                                text: "The passwords you entered do not match",
                                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                                timeout: 3000
                            });
                            $(".snarl-notification").addClass('snarl-error');

                        }


                    }
                }]


            });


        });


    }

    function disacc(id) {


        BootstrapDialog.show({
            title: "Confirm Diable",
            message: "This will prevent this user from logging into the system, proceed?",
            buttons: [{
                label: "DISABLE", cssClass: "btn-bad waves-button waves-effect", action: function (d) {

                    d.close();

                    fullProg();
                    $.get("disacc.php?id=" + id, function (data) {
                    }).done(function () {
                        remove_fullprog();

                        getaccounts();

                    });

                }
            }]


        });


    }


    //--------------------------------------------------------------
    //
    //
    //
    function enableacc(id) {

        BootstrapDialog.show({
            title: "Confirm Enable",
            message: "Are you sure you want to enable this user account ?",
            buttons: [{
                label: "ENABLE", cssClass: "btn-good waves-button waves-effect", action: function (d) {

                    d.close();
                    fullProg();

                    $.get("enableacc.php?id=" + id, function (data) {

                    }).done(function () {

                        remove_fullprog();
                        getaccounts();

                    });
                }
            }]


        });


    }

    //
    //--------------------------------------------------------------
    $(document).ready(function () {
        $("i").tooltip();
        $("#prog").change(function () {

            $.getJSON("cnt_prog.php?prog=" + $("#prog").val() + "&ayear=" + $("#ayer2").val(), function (dataobj) {

                $("#cntcont2").html("There are " + dataobj.count_val + " student(s) that offer this programe");
            });


        });
        $("#ayer2").change(function () {
            $("#prog").change();


        });


    });
</script>

