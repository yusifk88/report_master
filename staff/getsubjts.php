<?php
include_once './objts/config.php';
include_once './objts/subjects.php';
$sbjt = new Subjects();
$data = $sbjt->getsubjects();
if (mysqli_num_rows($data) > 0) {
    ?>
    <div class="alert alert-info"><strong>List of Subjects</strong></div>
    <div class="table-responsive">
        <table class="table table-condensed table-hover table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Subject Description</th>
                <th>Subject Type</th>
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
                        echo $row['subjdesc'];
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $row['type'];
                        ?>
                    </td>

                    <td><span class="glyphicon glyphicon-edit editicon2" title="Edit this Subject"
                              data-type="<?php echo "$row[type]"; ?>" data-input="<?php echo "$row[subjdesc]"; ?>"
                              data-id="<?php echo $row['id']; ?>" style="color: deepskyblue; cursor: pointer;"></span>
                    </td>
                    <td><span class="glyphicon glyphicon-trash delicon2" title="Delete this Subject"
                              data-del="delsubj.php" data-id="<?php echo $row['id']; ?>"
                              style="color: #F00; cursor: pointer;"></span></td>

                </tr>
                <?php


            }


            ?>

            </tbody>

        </table>
    </div>

    <?php

} else {

    ?>

    <p style="margin-top:10em;"><h1 class="text-danger">No subjects registered at the moment <span
                class="glyphicon glyphicon-warning-sign"</h1>

    </p>


    <?php

} ?>


<script>

    $(".editicon2").click(function () {

        var me = $(this);
        $.get("sub_update_input.php?name=" + me.attr("data-input") + "&type=" + me.attr("data-type"), null, function (data) {
            $(".dlg-ex").html(data);

        }).done(function () {


            $(".dlg-ex").dialog({
                modal: true,
                show: 'drop',
                hide: 'fade',
                buttons: {
                    Update: function () {

                        if (!$("#name").val()) {
                            $("#name").focus();
                            return false;


                        }

                        $.get("updatesub.php?id=" + me.attr("data-id") + "&name=" + $("#name").val() + "&type=" + $("#type").val(), null, function (data) {

                            $(".dlg-ex").html(data);
                        }).done(function () {
                            $(".dlg-ex").dialog({
                                show: 'bounce',
                                hide: 'fade',
                                modal: true,
                                buttons: {
                                    Ok: function () {
                                        $(this).dialog("close");
                                        getsubjts();


                                    }

                                }


                            });

                        });


                    }, cancel: function () {

                        $(this).dialog("close");


                    }


                }


            });


        });


    });


    //==========================================================================================
    $(".delicon2").click(function () {
        var me = $(this);
        $(".dlg-ex").title = "Confirm delete";
        $(".dlg-ex").html("Are you sure you want to delete this subject?");
        $(".dlg-ex").dialog({
            modal: true,
            show: 'bounce',
            hide: 'fade',
            buttons: {
                Yes: function () {
                    $(this).dialog("close");
                    $.get(me.attr("data-del") + "?id=" + me.attr("data-id"), null, function () {

                    }).done(function () {

                        getsubjts();

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
            
            
       
        
   
    









