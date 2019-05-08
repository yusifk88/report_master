<?php
include_once './objts/config.php';
$cf = new config();
$cf->connect();
$keyword = $_GET['keyword'];
$search = mysqli_query($cf->con,"select stuinfo.ayear,stuinfo.id, stuinfo.photo, stuinfo.fname,stuinfo.lname,stuinfo.oname,stuinfo.form,classes.classname from stuinfo,classes where (fname like '%$keyword%' or lname like '%$keyword%' or oname like '%$keyword%' or ayear like '%$keyword%' or stindex like '%$keyword%') and  (stuinfo.class = classes.id) order by fname ASC");
$schnum =  mysqli_num_rows($search);
?>
<div class="container-fluid">

<?php

if(($schnum <1) || !$keyword){
    ?>
    <span style="color: #FC3; font-style: italic; text-align: center; font-weight: bold;" class="text-center">No records found that matches with the keyword: <?=$keyword;?></span> 
    
    <?php
}else{
    ?>
    <div class="row" style="margin-bottom: 5px;">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?php
            if($schnum === 1){
                ?>
                
            <span style="color: #FC3 !important; font-weight: bold;" class="pull-left"><?=$schnum?> Search Result Found</span>
            
                <?php
            }else{
                
                ?>
                          <span style="color: #FC3 !important; font-weight: bold;" class="pull-left"><?=$schnum?> Search Results Found</span>

                <?php
            }
            
            ?>
           
            
        </div>
        
        
    </div>
    
    <?php
while ($row = mysqli_fetch_object($search)) {
    
    ?>
    <div class="row result-row" style="border-bottom: 1px solid #ccc; margin-bottom: 10px; cursor: pointer;">
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
        <img class="img-circle img-responsive" src="../admin/<?=$row->photo;?>" />
        
    </div>
    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="color: #fff; font-weight: bold;">
                <?=$row->fname." ".$row->lname." ".$row->oname?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="color: #EAEAEA;">
                Class:   <?=$row->classname;?> <br /> 
             Form: Form <?=$row->form;?>
            </div>
            
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="color: #EAEAEA;">
                Academic Year:   <?=$row->ayear;?> <br /> 
           
            </div>
            
        </div>
        
        
        
        
        
    </div>
    
        <button onclick="showres('<?=$row->id;?>');" type="button" class="btn btn-link pull-right">View Details</button>
    
</div>
    
    
    
    <?php
    
}}

?>

</div>