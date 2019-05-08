<?php
include_once './objts/config.php';
$cfg = new config();
$cfg->connect();
$id = $_GET['id'];
        $stud= mysqli_query($cfg->con,"select * from stuinfo where id = '$id'");
$row = mysqli_fetch_assoc($stud);
?>
 <div class="row">

      
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="margin: 0 !important; ">
                        <div class="text-center waves-effect waves-float" id="image_cont" style="width: 180px; height:200px; color: #FFFFFF; vertical-align: middle; background-position: center; background-size: cover; border: thin dashed deepskyblue; background-image: url('../admin/<?= $row['photo']?>')">
                            Drop photo or click to change photo
                        </div>
                    </div>
        

                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12" style="border-left: 1px solid #ccc;">
                        <form id="stud_upform">
                            <input type="hidden" id="picpath" name="picpath" />
                            <input type="hidden" id="upid" value="<?= $row['id'];?>" name="upid" />
                            <input type="hidden" id="upindex" value="<?= $row['stindex'];?>" name="upindex" />

                                <div class="row">

                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label class="control-label">JHS No.</label>
                                    <input class="form-control" name="upjhsno" id="upjhsno" type ="text" value="<?=$row['jhsno'];?>" />
                                      </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label class="control-label">SHS No.</label>
                                    <input class="form-control" name="upshsno" id="upshsno" type ="text" value="<?=$row['shsno'];?>" />
                                    </div>

                                </div>
                                     <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <label class="control-label">First Name</label>
                                    <input class="form-control" name="upfname" id="upfname" type ="text" value="<?=$row['fname'];?>"/>

                                    </div>


                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <label class="control-label">Last Name</label>
                                    <input class="form-control" name="uplname" id="uplname" type ="text" value="<?=$row['lname'];?>" />
                                      </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <label class="control-label">Other Name(s)</label>
                                    <input class="form-control" name="uponame" id="uponame" type ="text" value="<?=$row['oname'];?>" />
                                    </div>
                                </div>



                            <div class="row">
                                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                    <label class="control-label">Gender</label>
                                    <select name="upgender" id="gender" class="form-control">                                        
                                        <?php                                        
                                        if($row['gender']=="Male"){                                            
                                            ?>
                                        <option selected="selected">Male</option>
                                        <option>Female</option>                                            
                                            <?php
                                        }else{                                            
                                            ?>
                                        <option>Male</option>
                                        <option selected="selected">Female</option>                                            
                                            <?php 
                                        }
                                        ?>
                                    </select> 
                            </div>
                                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                    <label class="control-label">Form</label>
                                    <select name="upform" id="upform" class="form-control">                                        
                                        <?php                                        
                                       
                                        for($i =1;$i<=4;$i++){
                                         if($i == $row['form']){                                             
                                             ?>                                             
                                        <option selected="selected" value="<?=$row['form'];?>"><?="Form".$i;?></option>
                                             <?php
                                         } else{                                             
                                            ?>                                             
                                        <option value="<?=$i;?>"><?="Form".$i;?></option>
                                             <?php 
                                         }  
                                        }
                                        ?>
                                    </select> 
                            </div>
                                
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <label class="control-label">Program</label>
                                    <select name="upprog" id="upprog" class="form-control">                                        
                                        <?php                                        
                                       $progs = mysqli_query($cfg->con,"select depname,id from dept");
                                       while ($row1 = mysqli_fetch_object($progs)) {
                                           
                                           if($row["dept"]== $row1->id){
                                               ?>                                               
                                <option selected="selected" value="<?=$row['dept'];?>"><?=$row1->depname;?></option>                                               
                                               <?php
                                           }else{
                                                ?>                                               
                                <option value="<?=$row1->id;?>"><?=$row1->depname;?></option>                                               
                                               <?php 
                                           }
                                       }
                                        
                                        ?>
                                    </select> 
                            </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <label class="control-label">House</label>
                                    <select name="uphouse" id="uphouse" class="form-control">                                        
                                        <?php                                        
                                       $huse = mysqli_query($cfg->con,"select name,id from houses where house_type = 'genhouse'");
                                       while ($row2 = mysqli_fetch_object($huse)) {
                                           
                                           if($row["house"]== $row2->id){
                                               ?>                                               
                                <option selected="selected" value="<?=$row['house'];?>"><?=$row2->name;?></option>                                               
                                               <?php
                                           }else{
                                                ?>                                               
                                <option value="<?=$row2->id;?>"><?=$row2->name;?></option>                                               
                                               <?php 
                                           }
                                       }
                                        
                                        ?>
                                    </select> 
                            </div>
                                
                                
                                
                            </div>                          
                         
                            <div class="row" style="border-bottom: 1px solid #ccc;">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label class="control-label">Class</label>
                                    <select name="upclass" id="upclass" class="form-control">                                        
                                        <?php                                        
                                       $clses = mysqli_query($cfg->con,"select classname,id from classes");
                                       while ($row3 = mysqli_fetch_object($clses)) {
                                           
                                           if($row["class"]== $row3->id){
                                               ?>                                               
                                <option selected="selected" value="<?=$row['class'];?>"><?=$row3->classname;?></option>                                               
                                               <?php
                                           }else{
                                                ?>                                               
                                <option value="<?=$row3->id;?>"><?=$row3->classname;?></option>                                               
                                               <?php 
                                           }
                                       }
                                        
                                        ?>
                                    </select> 
                            </div>
                                
                                
                                
                                
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <label class="control-label">Academic Year</label>
                                    <select name="upayear" id="upayear" class="form-control">                                        
                                        <?php 
                                        $curyear = date("Y");
                                                 $start_date = $curyear -10;
                                                 $curyear2 = $start_date+1;
                                                 for($x=0;$x<=20;$x++){
                                                     $backyear=$start_date +$x;
                                                     $frontyear= $curyear2 +$x;
                                                   $myayear = $backyear."/".$frontyear; 
                                                   if($row['ayear']==$myayear){
                                                     ?>
                                        <option selected=""><?=$myayear;?></option>
                                                     
                                                     <?php
                                                 }else{
                                                      ?>
                                        <option><?=$myayear;?></option>
                                                     
                                                     <?php
                                                     
                                                 }
                                                 
                                                 
                                                 
                                                 
                                                 
                                                   }
                                        
                                        
                                       
                                        
                                        ?>
                                    </select> 
                                 
                            </div>
                                
                                
                                
                                
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <label class="control-label">Date Of Birth</label>
                                    <input name="updob" id="updob" readonly="" class="form-control" type="text" value="<?=$row['dob'];?>" />
                                    
                            </div>
                                
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label class="control-label">Last School Attended</label>
                                   
                                    <input name="uplsch" id="uplsch" type="text" class="form-control" value="<?=$row['lschool'];?>" />
                                    
                                    
                            </div>
                                
                                
                                
                            </div>                               
                            
                            <div class="row">
                               
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <label class="control-label">Father's Name</label>
                                    <input name="upffname" id="upffname" class="form-control" type="text" value="<?=$row['ffname'];?>" />
                            </div>
                                
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <label class="control-label">Father's Hometown</label>
                                   
                                    <input name="upfhometown" id="upfhometown" type="text" class="form-control" value="<?=$row['fhometown'];?>" />
                            </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <label class="control-label">Father's Tel.</label>
                                   
                                    <input name="upftel" id="upftel" type="tel" class="form-control" value="<?=$row['ftel'];?>" />
                            </div> 
                            </div>                               
                            <div class="row">
                               
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <label class="control-label">Mother's Name</label>
                                    <input name="upmname" id="upmname" class="form-control" type="text" value="<?=$row['mfname'];?>" />
                            </div>
                                
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <label class="control-label">Mother's Hometown</label>
                                   
                                    <input name="upmhometown" id="upmhometown" type="text" class="form-control" value="<?=$row['mhometown'];?>" />
                            </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <label class="control-label">Mother's Tel.(Optional)</label>
                                   
                                    <input name="upmtel" id="upmtel" type="tel" class="form-control" value="<?=$row['mtel'];?>" />
                            </div> 
                            </div>  
                                              


</form>
                    </div>
          </div>


 
 
 <script>
 
 $(document).ready(function(){
     $("div#image_cont").dropzone(
         { url: "./dropfile.php",
             acceptedFiles: "image/*",
             addRemoveLinks:true,
             dictDefaultMessage:"drop photo here or click to upload",
             dictRemoveFile:"Remove photo",
             resizeWidth:"180",
             resizeHeight:"200",
             resizeMethod:"crop",
             maxFiles:1,
             accept:function(file,done){
                 $("#picpath").val("temppic/"+file.name);
                 done();
             }


         });
     
     
     $($("#upfname,#uplname,#uponame,#upffname,#upmname")).keypress(function(e){
      if(e.which >47 && e.which < 59){          
          e.preventDefault();
          
      }  
      
        
        
    });
     $($("#upftel,#upmtel")).keypress(function(e){
      if(!(e.which >47 && e.which < 59)){          
          e.preventDefault();
          
      }  
      
        
        
    });
    
     
       $("#updob").datepicker({
                      changeMonth:true,
                      changeYear:true,
                      showAnim:"drop",
                      dateFormat:"yy-m-d"
                     
                  });
 });
 
 
 
 
 
 
 
 </script>