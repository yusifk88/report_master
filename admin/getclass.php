<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');

use APP\Rclass;

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
                        <td><i title="Edit this class" style="cursor: pointer;"
                               class="fa fa-edit text-primary waves-circle"
                               onclick="edit_class(<?=$row['id']?>,<?=$row['dpid']?>,'<?=$row['classname']?>')"
                               >
                            </i></td>
                        <td><i title="Delete this class" style="cursor: pointer;"
                               onclick="deleclass(<?=$row['id']?>)"
                               class="fa fa-remove waves-effect waves-circle text-danger" > </i>
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


<?php


