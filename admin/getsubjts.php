<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\Subjects;
$sbjt = new Subjects();
$data = $sbjt->getsubjects();
if (mysqli_num_rows($data) > 0) {
    ?>
    <div class="row">
        <div class="col-md-8 mx-auto">

    <div class="card">
        <div class="card-header bg-primary2 text-white">
            <p class="card-title text-white">List of Subjects</p>
        </div>
        <div class="card-body">
            <table class="table table-hover table-striped" >
                <thead>
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

                        <td><i class="fa fa-edit waves-effect waves-circle  text-primary" title="Edit this Subject"
                               onclick="editsubject(<?=$row['id']?>,'<?=$row['subjdesc']?>','<?=$row['type']?>')"
                            ></i>
                        </td>
                        <td><i class="fa fa-remove waves-effect waves-circle delicon2 text-danger" title="Delete this Subject"
                               data-del="delsubj.php" data-id="<?php echo $row['id']; ?>"
                               onclick="deletesubject(<?=$row['id']?>)"
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
    <?php
} else {
    ?>
    <p style="margin-top:10em;"><h1 class="text-danger">No subjects registered at the moment <span
                class="glyphicon glyphicon-warning-sign"</h1>

    </p>
    <?php
}
?>

            
            
       
        
   
    









