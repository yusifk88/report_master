<?php
include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$id = $_GET['id'];
$user = mysqli_query("select * from staff where id = '$id'");
$user_info = mysqli_fetch_object($user);
?>


<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <label class="control-label">
                Name
            </label>
            <input type="text" readonly="" value="<?=$user_info->fname." ".$user_info->lname;?>" class="form-control" />
          </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <label class="control-label">
                New Password
            </label>
            <input type="password" id="new_pass" placeholder="enter new password" class="form-control" />
          </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <label class="control-label">
               Confirm Password
            </label>
            <input type="password" id="cnew_pass" placeholder="enter new password again" class="form-control" />
          </div>
        
        </div>
        
    </div>
    
</div>