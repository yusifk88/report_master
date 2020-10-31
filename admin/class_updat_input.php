<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\Department;
$id = $_GET['id'];
$dpid = $_GET['dpid'];
$cname = $_GET['classname'];
$dp = new Department();
$d = $dp->getdpts();

?>
<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
    <form>
        <div class="md-form">
            <label class="active form-control-label" for="classname">Class Name</label>
            <input id="classname1" class="form-control" value="<?php echo $cname; ?>" type="text" required="required"/>
        </div>


        <label class="control-label" for="dept">Department</label>
        <select class="form-control" id="dept1">

            <?php

            while ($row = mysqli_fetch_assoc($d)) {



                    ?>

                    <option <?=$dpid===$row['id'] ? 'selected' : ''?>
                            value="<?php echo $row['id']; ?>"><?php echo $row['depname']; ?></option>


                    <?php



            }


            ?>


        </select>


    </form>


</div>