<?php

include_once './objts/config.php';
include_once './objts/rclass.php';
include_once './objts/subjects.php';
$cls = new Rclass();
$sub = new Subjects();
$subs = $sub->getsubjects();
$clss = $cls->getclasses();

?>



    <form>
        <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <label class="control-label" for="sub">Subject</label>
            <select id="sub" class="form-control">
                <?php
                while ($row = mysqli_fetch_assoc($subs)) {
                    
                    ?>
                <option value="<?php echo $row['id'];?>"><?php echo $row['subjdesc'];?></option>
                    
                    <?php
                    
                }
                ?>
            </select>
            
            
        </div>
         </div>   
        <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <label class="control-label" for="cls">Class</label>
            <select id="cls" class="form-control">
                <?php
                while ($row = mysqli_fetch_assoc($clss)) {
                    
                    ?>
                <option value="<?php echo $row['id'];?>"><?php echo $row['classname'];?></option>
                    
                    <?php
                    
                }
                
                
                
                ?>
                
                
                
            </select>
            
            
        </div>
         </div>   
            
    </form>
    
    
    
    
