<?php
include_once 'objts/config.php';
$cf = new config();
$cf->connect();

$acc = mysqli_query("select id,uname,upass,user_type,status from staff");
$ayear = mysqli_query("select distinct(ayear) from stuinfo");

?>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="panel panel-info" style="border-radius: 0;">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="alert alert-info">
                        <p class="panel-title">Manage User Accounts</p>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    <div class="table-responsive">

                        <table class="table table-condensed table-hover table-striped">
                            <thead>
                            <th>S/N</th>
                            <th>User Name</th>
                            <th>Password</th>
                            <th>User Type</th>
                            <th>Status</th>
                            <th colspan="2">Action</th>


                            </thead>
                            <tbody>

                            <?php
                            $i = 1;
                            while ($row = mysqli_fetch_object($acc)) {
                                if ($row->status == "active") {
                                    ?>
                                    <tr>

                                        <td>
                                            <?= $i; ?>

                                        </td>
                                        <td>
                                            <?= $row->uname; ?>

                                        </td>
                                        <td>
                                            <?= $row->upass; ?>

                                        </td>
                                        <td>
                                            <?= $row->user_type; ?>

                                        </td>
                                        <td style="font-style: italic;">
                                            <?= $row->status; ?>

                                        </td>
                                        <td>
                                            <span onclick="resetpass(<?= $row->id; ?>)" title="Reset user's password"
                                                  style="color: deepskyblue; cursor: pointer;"
                                                  class="glyphicon glyphicon-retweet"></span>

                                        </td>
                                        <td>
                                            <span onclick="disacc(<?= $row->id; ?>)" title="Disable user Account"
                                                  style="color: red; cursor: pointer;"
                                                  class="glyphicon glyphicon-off"></span>
                                        </td>


                                    </tr>

                                    <?php

                                } else {

                                    ?>
                                    <tr>

                                        <td style="color: red;">
                                            <?= $i; ?>

                                        </td>
                                        <td style="color: red;">
                                            <?= $row->uname; ?>

                                        </td>
                                        <td style="color: red;">
                                            <?= $row->upass; ?>

                                        </td>
                                        <td style="color: red;">
                                            <?= $row->user_type; ?>

                                        </td>
                                        <td style="color: red; font-style: italic;">
                                            <?= $row->status; ?>

                                        </td>
                                        <td>
                                            <span onclick="resetpass(<?= $row->id; ?>)" title="Reset user's password"
                                                  style="color: deepskyblue; cursor: pointer;"
                                                  class="glyphicon glyphicon-retweet"></span>

                                        </td>
                                        <td>
                                            <span onclick="enableacc(<?= $row->id; ?>)" title="Enable user Account"
                                                  style="color: deepskyblue; cursor: pointer;"
                                                  class="glyphicon glyphicon-star"></span>
                                        </td>


                                    </tr>

                                    <?php
                                }
                                $i++;
                            }


                            ?>


                            </tbody>

                        </table>

                    </div>
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

        $.get("resetpass.php?id=" + id, function (data) {

            $(".dlg").html(data).dialog({
                modal: true,
                show: "drop",
                hide: "fade",
                title: "Reset Password",
                buttons: {
                    Reset: function () {

                        if (!$("#new_pass").val() || !$("#cnew_pass").val()) {
                            exit();

                        }
                        if ($("#new_pass").val() === $("#cnew_pass").val()) {
                            $.get("do_reset.php?id=" + id + "&new_pass=" + $("#new_pass").val(), function () {

                            }).done(function () {
                                $(".dlg").dialog("close");
                                $.get("accounts.php", function (data) {

                                }).done(function (data) {

                                    $("#print-pool").html(data);

                                });

                            });
                        } else {

                            $(".dlg-ex").html("The passwords you enter do not match").dialog({
                                modal: true,
                                show: "bounce",
                                hide: "fade",
                                title: "Invalid Confirmation",
                                buttons: {
                                    Ok: function () {

                                        $(this).dialog("close");

                                    }

                                }


                            });

                        }

                    },
                    Cancel: function () {

                        $(this).dialog("close");


                    }


                }
            });


        });


    }

    function disacc(id) {
        $(".dlg").html("This will prevent this user from logging into the system, proceed?").dialog({
            modal: true,
            show: "bounce",
            hide: "fade",
            title: "Confirm Disable",
            buttons: {

                Yes: function () {
                    $(this).dialog("close");
                    $.get("disacc.php?id=" + id, function (data) {

                    }).done(function () {

                        $.get("accounts.php", function (data) {

                        }).done(function (data) {

                            $("#print-pool").html(data);

                        });

                    });

                },
                No: function () {
                    $(this).dialog("close");
                }

            }


        });


    }


    //--------------------------------------------------------------
    //
    //
    //
    function enableacc(id) {
        $(".dlg").html("Are you sure you want to enable this user account ?").dialog({
            modal: true,
            show: "bounce",
            hide: "fade",
            title: "Confirm Enable",
            buttons: {

                Yes: function () {
                    $(this).dialog("close");
                    $.get("enableacc.php?id=" + id, function (data) {

                    }).done(function () {

                        $.get("accounts.php", function (data) {

                        }).done(function (data) {

                            $("#print-pool").html(data);

                        });

                    });

                },
                No: function () {
                    $(this).dialog("close");
                }

            }


        });


    }

    //
    //--------------------------------------------------------------
    $(document).ready(function () {
        $("span").tooltip();
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

