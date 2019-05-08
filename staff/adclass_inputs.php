<?php

include_once './objts/config.php';
include_once './objts/department.php';
$dp = new Department();
$d = $dp->getdpts();
?>
<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
    <form>
        
        <label class="control-label" for="classname">Class Name</label>
        <input id="classname" class="form-control" type="text" placeholder="Enter class name" required="required" />
        <label class="control-label" for="dept">Department</label>
        <select class="form-control" id="dep">
            
            <?php
            while ($row = mysql_fetch_assoc($d)) {
                
                
                ?>
                
            <option value="<?php echo $row['id']; ?>"><?php echo "$row[depname]";?></option>    
            
                <?php
                
            }
            
            ?>
        </select>
        
    </form> 
</div>