<?php

include_once './objts/config.php';
include_once './objts/rclass.php';
$clss = new Rclass();
$d = $clss->getclasses();
?>
<div class="row">
    <div class="col-md-8 mx-auto">
    <div class="card">
        <div class="card-header bg-primary2">
            <p class="card-title text-white">List of Classes</p>
        </div>
        <div class="table-responsive">

            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Class Name</th>
                    <th>Department</th>
                    <th colspan="2">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 1;
                while ($row = mysqli_fetch_assoc($d)) {
                    ?>
                    <tr id="row_<?= $row['id'] ?>">
                        <td><?= $i; ?>  </td>
                        <td><?php echo $row['classname']; ?>  </td>
                        <td><?php echo $row['depname']; ?>  </td>
                        <td><i title="Edit this class" data-get="<?= $row['classname']; ?>"
                               data-dpid="<?= $row['dpid']; ?>" style="cursor: pointer;"
                               class="fa fa-edit editicon1 text-primary waves-circle" data-id="<?php echo $row['id']; ?>"> </i></td>
                        <td><i title="Delete this class" style="cursor: pointer;"
                               class="fa fa-remove waves-effect waves-circle delicon text-danger" data-id="<?= $row['id']; ?>"> </i>
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
    <script>

        $(".editicon1").click(function () {
            var me = $(this);
            BootstrapDialog.show({
                title: "Edit Class Info.",
                message: "<div id='cls-cont'></div>",
                onshown: function () {

                    showprogress("cls-dont");

                    $.get("class_updat_input.php?id=" + me.attr("data-id") + "&dpid=" + me.attr("data-dpid") + "&classname=" + me.attr("data-get"), null, function (data) {

                        $("div#cls-cont").html(data);

                    });

                },
                buttons: [{
                    label: "UPDATE", cssClass: "bg-info text-white", action: function (d) {

                        if (!$("input#classname1").val()) {
                            $("input#classname1").focus();
                        } else {
                            fullProg();

                            $.get("updateclass.php?id=" + me.attr("data-id") + "&classname=" + $("#classname1").val() + "&dpid=" + $("#dept1").val(), null, function (data) {

                            }).done(function (data) {
                                d.close();
                                remove_fullprog();

                                getclass();

                                Snarl.removeNotification(progress);
                                Snarl.addNotification({
                                    title: "UPDATED",
                                    text: "Class Update successfully",
                                    icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle-o'></i>",
                                    timeout: 3000
                                });
                                $(".snarl-notification").addClass('snarl-success');

                            }).error(function () {
                                Snarl.removeNotification(progress);
                                Snarl.addNotification({
                                    title: "ERROR",
                                    text: "Something went wrong, could not update class",
                                    icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                                    timeout: 8000
                                });
                                $(".snarl-notification").addClass('snarl-error');

                            });
                        }


                    }
                }]

            });

        });

        //--------------------------------------------------------------------------------------------------------------------------
        $(".delicon").click(function () {
            var me = $(this);
            BootstrapDialog.show({
                title: "Confirm Delete",
                message: "Are you sure you want to delete this class, this action could affect students",
                buttons: [{
                    label: "DELETE", cssClass: "btn-danger", action: function (d) {
                        fullProg();
                        $.get("delclass.php?id=" + me.attr("data-id"), function (data) {

                        }).done(function (data) {
                            d.close();
                            remove_fullprog();
                            var viewid = "#row_" + me.attr("data-id");
                            $(viewid).fadeOut(200, function () {
                                $(viewid).remove();
                            });
                            Snarl.removeNotification(progress);
                            Snarl.addNotification({
                                title: "DELETE",
                                text: "Class Deleted successfully",
                                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle-o'></i>",
                                timeout: 300
                            });
                            $(".snarl-notification").addClass('snarl-success');
                        });
                    }
                }]
            });
            $(".modal-backdrop").addClass("backdrop-light");
        });
        //==========================================================================================================================
    </script>

<?php


