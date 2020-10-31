<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\config;
use APP\House;

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
                        <td><i
                               class="fa fa-edit waves-effect waves-button editicon3 text-primary" title="Edit this department"
                               onclick="edithouse(<?=$row['id']?>,'<?=$row['name']?>','<?=$row['des']?>','<?=$row['house_type']?>')"
                               style="cursor: pointer;"></i></td>
                        <td><i
                               class="fa fa-remove  waves-effect waves-button delicon3 text-danger"
                               title="Delete this department"
                               onclick="deletehouse(<?=$row['id']?>)"
                               style="cursor: pointer;"></i></td>
                    </tr>
                    <?php
                    $i++;
                }
                ?>
                <script>

                    //==========================================================================================
                    $(".delicon3").click(function () {
                        var me = $(this);

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