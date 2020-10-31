<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');

use APP\Department;


$dept = new Department();

$data = $dept->getdpts();
?>
<div class="row">
    <div class="col-md-8 mx-auto">


<div class="card">
    <div class="card-header bg-primary2 text-white">
        <p class="card-title text-white">List of Departments</p>
    </div>


    <div class="table-responsive text-nowrap">
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th>S/N</th>
                <th>Description</th>
                <th>Date of Entry</th>
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
                        echo $row['depname'];
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $row['dentry'];
                        ?>
                    </td>

                    <td><i onclick="edit_department(<?=$row['id']?>,'<?=$row['depname']?>')" class="fa fa-edit waves-effect waves-circle editicon text-primary" title="Edit this department"
                           style="cursor: pointer;"></i></td>
                    <td><i onclick="delete_department(<?= $row['id']; ?>)" class="fa fa-remove waves-effect waves-circle delicon text-danger" title="Delete this department"
                           style="cursor: pointer;"></i></td>

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



