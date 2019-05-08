<?php

include_once './objts/config.php';
include_once './objts/department.php';
$dp = new Department();
$d = $dp->getdpts();
?>
<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
    <form>

        <div class="md-form">
            <i class="prefix fa fa-home"></i>
            <input id="classname" class="form-control" type="text" required="required" />
            <label for="classname">Class Name</label>

        </div>


        <label class="control-label" for="dept">Department</label>
        <select class="form-control" id="dep">
            
            <?php
            while ($row = mysqli_fetch_object($d)) {
                
                
                ?>
                
            <option value="<?php echo $row->id; ?>"><?php echo "$row->depname";?></option>
            
                <?php
                
            }
            
            ?>
        </select>
        
    </form> 
</div>