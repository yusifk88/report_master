<?php
include_once './objts/config.php';
include_once './objts/house.php';
$cf = new config();
$cf->connect();
$data = mysqli_query($cf->con, "select * from houses ORDER by name ASC");
if (mysqli_num_rows($data) > 0) {
    ?>
    <div class="row">
        <div class="col-md-8 mx-auto">

    <div class="card">
        <div class="card-header bg-primary2 text-white">
            <p class="card-title text-white">List of Houses</p>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-condensed table-hover table-striped">
                <thead>
                <tr>
                    <th>S/N</th>
                    <th>House Name</th>
                    <th>House Description</th>
                    <th>House Type</th>
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
                            echo $row['name'];
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $row['des'];
                            ?>
                        </td>
                        <td>
                            <?php
                            if ($row['house_type'] == 'genhouse') {
                                echo("General House");

                            } elseif ($row['house_type'] == 'ghouse') {
                                echo('Girls House');
                            } else {
                                echo("Boy House");
                            }
                            ?>
                        </td>
                        <td><i class="fa fa-edit waves-effect waves-button editicon3 text-primary" title="Edit this department"
                               data-input="<?php echo "$row[name]"; ?>" data-id="<?php echo $row['id']; ?>"
                               data-des="<?= $row['des']; ?>" data-htype="<?= $row['house_type'] ?>"
                               style="cursor: pointer;"></i></td>
                        <td><i class="fa fa-remove  waves-effect waves-button delicon3 text-danger" title="Delete this department"
                               data-del="delhouse.php" data-id="<?php echo $row['id']; ?>"
                               style="cursor: pointer;"></i></td>
                    </tr>
                    <?php
                    $i++;
                }
                ?>
                <script>
                    $(".editicon3").click(function () {
                        var me = $(this);
                        var temp = "<form> <div class='col-lg-12 col-md-12 col-xs-12 col-sm-12'><div class='md-form'><i class='active prefix fa fa-home'></i>";
                        temp += "<input type='text' id='name' value='" + me.attr("data-input").toString() + "' class='form-control'/>";
                        temp += "<label class='active' for='name'>House Name</label></div><div class='md-form'><i class='active prefix fa fa-file-text-o'></i>";
                        temp += "<input type='text' id='des' value='" + me.attr("data-des").toString() + "' class='form-control'/>";
                        temp += "<label class='active' for='des'>House Description</label></div>";
                        temp += "<label class='control-label' for='des'>House Type</label>";
                        temp += "<select type='text' id='house_type' class='form-control'>";
                        if (me.attr('data-htype') == 'ghouse') {
                            temp += "<option selected value='ghouse'>Girls House</option>";
                            temp += "<option value='bhouse'>Boys House</option>";
                            temp += "<option value='genhouse'>General House</option>";
                        } else if (me.attr('data-htype') == 'bhouse') {
                            temp += "<option value='ghouse'>Girls House</option>";
                            temp += "<option selected value='bhouse'>Boys House</option>";
                            temp += "<option value='genhouse'>General House</option>";
                        } else {
                            temp += "<option value='ghouse'>Girls House</option>";
                            temp += "<option  value='bhouse'>Boys House</option>";
                            temp += "<option selected value='genhouse'>General House</option>";
                        }
                        temp += "</select>";
                        temp += "</div></form>";
                        BootstrapDialog.show({
                            title: "Update House Info.",
                            message: temp,
                            buttons: [{
                                label: "UPDATE", cssClass: "bg-info text-white", action: function (d) {
                                    if (!$("#name").val() || !$("#des").val()) {
                                        return false;
                                    }
                                    d.close();
                                    $.get("updatehouse.php?id=" + me.attr("data-id") + "&name=" + $("#name").val() + "&des=" + $("#des").val() + "&house_type=" + $("#house_type").val(), null, function (data) {
                                    }).done(function (data) {
                                        gethouses();
                                        Snarl.addNotification({
                                            title: "UPDATED",
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
                    $(".delicon3").click(function () {
                        var me = $(this);
                        BootstrapDialog.show({
                            title: "Confirm Delete",
                            message: "Are you sure you want to delete this house",
                            buttons: [{
                                label: "DELETE", cssClass: "btn-danger", action: function (d) {
                                    d.close();
                                    $.get(me.attr("data-del") + "?id=" + me.attr("data-id"), null, function (data) {
                                    }).done(function () {
                                        Snarl.addNotification({
                                            title: "DELETE",
                                            text: "House deleted successfully",
                                            icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle-o'></i>",
                                            timeout: 3000
                                        });
                                        $(".snarl-notification").addClass('snarl-success');
                                        gethouses();
                                    });
                                }
                            }]
                        });
                        $(".modal-backdrop").addClass("backdrop-light");
                    });
                    $("i").tooltip();
                </script>
                </tbody>
            </table>
        </div>
    </div>

        </div>

    </div>
    <?php
} else {

    ?>
    <p><h1 class="text-danger" style="text-align: center; margin-top: 5em;">No houses registered at the moment <span
                class="glyphicon glyphicon-warning-sign"></span></h1></p>
    <?php
}

?>