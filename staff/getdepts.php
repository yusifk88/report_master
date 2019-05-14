<?php
include_once './objts/config.php';
include_once './objts/department.php';


$dept = new Department();

$data = $dept->getdpts();
?>

<div class="alert alert-info"><strong>List of Departments</strong></div>
<div class="table-responsive">
    <table class="table table-condensed table-hover table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Description</th>
            <th>Date of Entry</th>
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
                    echo $row['depname'];
                    ?>
                </td>
                <td>
                    <?php
                    echo $row['dentry'];
                    ?>
                </td>

                <td><span class="glyphicon glyphicon-edit editicon" title="Edit this department"
                          data-input="<?php echo "$row[depname]"; ?>" data-id="<?php echo $row['id']; ?>"
                          style="color: deepskyblue; cursor: pointer;"></span></td>
                <td><span class="glyphicon glyphicon-trash delicon" title="Delete this department"
                          data-del="deldept.php" data-id="<?php echo $row['id']; ?>"
                          style="color: #F00; cursor: pointer;"></span></td>

            </tr>


            <?php


        }


        ?>


        <script>

            $(".editicon").click(function () {

                var me = $(this);
                var temp = "<form> <div class='col-lg-12 col-md-12 col-xs-12 col-sm-12'>";
                temp += "<label class='control-label' for='depname'>Department name/description</label>";
                temp += "<input type='text' id='depname' class='form-control'/>";
                temp += "</div></form>";
                $(".dlg-ex").html(temp);
                $("#depname").val(me.attr("data-input").toString());
                $(".dlg-ex").dialog({
                    modal: true,
                    show: 'drop',
                    hide: 'fade',
                    buttons: {
                        Update: function () {

                            $.get("updatedep.php?id=" + me.attr("data-id") + "&depname=" + $("#depname").val().toString(), null, function (data) {

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
                                            getdepts();

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
            $(".delicon").click(function () {
                var me = $(this);
                $(".dlg-ex").title = "Confirm delete";
                $(".dlg-ex").html("Are you sure you want to delete this department?");
                $(".dlg-ex").dialog({
                    modal: true,
                    show: 'bounce',
                    hide: 'fade',
                    buttons: {
                        Yes: function () {
                            $(this).dialog("close");
                            $.get(me.attr("data-del") + "?id=" + me.attr("data-id"), null, function (data) {

                            }).done(function () {

                                getdepts();

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








