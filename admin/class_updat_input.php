<?php
include_once './objts/config.php';
include_once './objts/department.php';
include_once './objts/rclass.php';
$id = $_GET['id'];
$dpid = $_GET['dpid'];
$cname = $_GET['classname'];
$dp = new Department();
$d = $dp->getdpts();

?>
<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
    <form>
       <div class="md-form">
           <i class="prefix fa fa-home active"></i>
           <input id="classname1" class="form-control" value="<?php echo $cname; ?>" type="text" required="required" />
           <label class="active" for="classname">Class Name</label>
       </div>


        <label class="control-label" for="dept">Department</label>
        <select class="form-control" id="dept1">
            
            <?php
           
            while ($row = mysqli_fetch_assoc($d)) {
                
                
                if($dpid == $row['id']){
                    
                    ?>
                    
            <option selected="selected" value="<?php echo $row['id']; ?>"><?php echo $row['depname'];?></option>    

            
                    <?php
                }
                ?>
                
            
            <option value="<?php echo $row['id']; ?>"><?php echo $row['depname'];?></option>    
            
            
            
            
                <?php
                
            }
            
            
            ?>
            
            
            
            
        </select>
        
        
        
        
        
        
        
    </form> 
    
    
    
    
</div>