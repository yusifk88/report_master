<?php
include_once './objts/config.php';
include_once './objts/subjects.php';
$sbjt = new Subjects();
$data = $sbjt->getsubjects();
if (mysqli_num_rows($data) > 0) {
    ?>
    <div class="card">
        <div class="card-header bg-info text-white">
            <p class="card-title">List of Subjects</p>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover table-striped">
                <thead class="bg-info text-white">
                <tr>
                    <th>S/N</th>
                    <th>Subject Description</th>
                    <th>Subject Type</th>
                    <th colspan="2">Actions</th>
                </tr>
                </thead>

                <tbody>
                <?php
                $i = 1;
                while ($row = mysqli_fetch_assoc($data)) {
                    ?>
                    <tr id="row_<?= $row['id'] ?>">

                        <td>
                            <?= $i ?>
                        </td>
                        <td>
                            <?php
                            echo $row['subjdesc'];
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $row['type'];
                            ?>
                        </td>

                        <td><i class="fa fa-edit waves-effect waves-circle editicon2" title="Edit this Subject"
                               data-type="<?php echo "$row[type]"; ?>" data-input="<?php echo "$row[subjdesc]"; ?>"
                               data-id="<?php echo $row['id']; ?>" style="color: deepskyblue; cursor: pointer;"></i>
                        </td>
                        <td><i class="fa fa-remove waves-effect waves-circle delicon2" title="Delete this Subject"
                               data-del="delsubj.php" data-id="<?php echo $row['id']; ?>"
                               style="color: #F00; cursor: pointer;"></i></td>

                    </tr>
                    <?php

                    $i++;


                }


                ?>

                </tbody>

            </table>
        </div>
    </div>
    <?php
} else {
    ?>
    <p style="margin-top:10em;"><h1 class="text-danger">No subjects registered at the moment <span
                class="glyphicon glyphicon-warning-sign"</h1>

    </p>
    <?php
}
?>
<script>
    $(".editicon2").click(function () {
        fullProg();
        var me = $(this);
        remove_fullprog();
        BootstrapDialog.show({
            title: "Update Subject",
            message: "<div style='transition: 0.2s ease-in-out' id='sub-cont'></div>",
            onshown: function () {
                showprogress("sub-cont");
                $.get("sub_update_input.php?name=" + me.attr("data-input") + "&type=" + me.attr("data-type"), null, function (data) {
                }).done(function (data) {
                    $("#sub-cont").html(data);
                });
            },
            buttons: [{
                label: "UPDATE", cssClass: "bg-info text-white", action: function (d) {

                    if (!$("#name").val()) {
                        $("#name").focus();
                        return false;
                    }
                    d.close();
                    $.get("updatesub.php?id=" + me.attr("data-id") + "&name=" + $("#name").val() + "&type=" + $("#type").val(), null, function (data) {
                    }).done(function (data) {
                        getsubjts();
                        Snarl.addNotification({
                            title: "UPDATE",
                            text: data,
                            icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle-o'></i>",
                            timeout: 3000
                        });
                        $(".snarl-notification").addClass('snarl-success');
                    });
                }
            }]
        });
    });
    //==========================================================================================
    $(".delicon2").click(function () {
        var me = $(this);
        BootstrapDialog.show({
            title: "Confirm Delete",
            message: "Are you sure you want to delete this subject?",
            buttons: [{
                label: "DELETE", cssClass: "btn-danger", action: function (d) {
                    d.close();
                    $.get(me.attr("data-del") + "?id=" + me.attr("data-id"), null, function () {

                    }).done(function () {
                        Snarl.addNotification({
                            title: "DELETE",
                            text: "Subject Deleted successfully",
                            icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle-o'></i>",
                            timeout: 3000
                        });
                        $(".snarl-notification").addClass('snarl-success');
                        var viewid = "#row_" + me.attr('data-id');
                        $(viewid).fadeOut(200, function () {
                            $(viewid).remove();
                        });

                    });


                }
            }]


        });

        $(".modal-backdrop").addClass("backdrop-light");


    });
    $("i").tooltip();

</script>
            
            
       
        
   
    









