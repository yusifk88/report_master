<?php
include_once './objts/config.php';
include_once './objts/house.php';
$hse = new House();

$data = $hse->gethouses();
if (mysqli_num_rows($data) > 0) {
    ?>

    <div class="alert alert-info"><strong>List of Houses</strong></div>
    <div class="table-responsive">
        <table class="table table-condensed table-hover table-striped">
            <thead>
            <tr>
                <th>ID</th>

                <th>House Name</th>
                <th>House Description</th>

                <th colspan="2">Actions</th>
            </tr>

            </thead>
            <tbody>
            <?php
            while ($row = mysql_fetch_assoc($data)) {

                ?>

                <tr>

                    <td>
                        <?php
                        echo $row['id'];
                        ?>
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

                    <td><span class="glyphicon glyphicon-edit editicon3" title="Edit this department"
                              data-input="<?php echo "$row[name]"; ?>" data-id="<?php echo $row['id']; ?>"
                              data-des="<?php echo $row['des']; ?>" style="color: deepskyblue; cursor: pointer;"></span>
                    </td>
                    <td><span class="glyphicon glyphicon-trash delicon3" title="Delete this department"
                              data-del="delhouse.php" data-id="<?php echo $row['id']; ?>"
                              style="color: #F00; cursor: pointer;"></span></td>

                </tr>
                <?php
            }

            ?>
            <script>

                $(".editicon3").click(function () {

                    var me = $(this);
                    var temp = "<form> <div class='col-lg-12 col-md-12 col-xs-12 col-sm-12'>";
                    temp += "<label class='control-label' for='name'>House Name</label>";
                    temp += "<input type='text' id='name' class='form-control'/>";

                    temp += "<label class='control-label' for='des'>House Description</label>";
                    temp += "<input type='text' id='des' class='form-control'/>";
                    temp += "</div></form>";
                    $(".dlg-ex").html(temp);
                    $("#name").val(me.attr("data-input").toString());
                    $("#des").val(me.attr("data-des").toString());
                    $(".dlg-ex").dialog({
                        modal: true,
                        show: 'drop',
                        hide: 'fade',
                        buttons: {
                            Update: function () {
                                if (!$("#name").val() || !$("#des").val()) {

                                    return false;

                                }


                                $.get("updatehouse.php?id=" + me.attr("data-id") + "&name=" + $("#name").val() + "&des=" + $("#des").val(), null, function (data) {
                                    $(".dlg-ex").html(data);
                                }).done(function () {
                                    $(".dlg-ex").dialog({
                                        modal: true,
                                        show: 'bounce',
                                        hide: 'fade',
                                        buttons: {
                                            Ok: function () {
                                                $(this).dialog("close");
                                                $(".dlg-ex").dialog("close");
                                                gethouses();
                                            }
                                        }


                                    });


                                });

                                $(this).dialog("close");


                            }


                            ,
                            Cancel: function () {

                                $(this).dialog("close");

                            }

                        }


                    });

                });
                //==========================================================================================
                $(".delicon3").click(function () {
                    var me = $(this);
                    $(".dlg-ex").title = "Confirm delete";
                    $(".dlg-ex").html("Are you sure you want to delete this house?");
                    $(".dlg-ex").dialog({
                        modal: true,
                        show: 'bounce',
                        hide: 'fade',
                        buttons: {
                            Yes: function () {
                                $(this).dialog("close");
                                $.get(me.attr("data-del") + "?id=" + me.attr("data-id"), null, function (data) {

                                }).done(function () {

                                    gethouses();

                                });


                            },
                            No: function () {

                                $(this).dialog("close");
                            }
                        }


                    });


                });
                $("span").tooltip();

            </script>


            </tbody>

        </table>


    </div>

    <?php

} else {

    ?>


    <p><h1 class="text-danger" style="text-align: center; margin-top: 5em;">No houses registered at the moment <span
                class="glyphicon glyphicon-warning-sign"></span></h1></p>


    <?php
}

?>






