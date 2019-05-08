<?php
include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$cls = mysqli_query("select * from classes order by classname ASC");
$ayear = mysqli_query("select distinct(ayear) from stuinfo");
$stud = mysqli_query("select id,fname,lname,oname from stuinfo order by fname ASC");
?>

<div class="col-lg-6 col-md-6 col-lg-offset-3 col-md-offset-3 col-sm-12 col-xs-12">
    <div class="panel panel-info" style="border-radius: 0;">
        <div class="panel-body">            
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="alert alert-info" style="padding-left: 10px !important;">
                        <p class="panel-title">Print Student Transcript</p>
                    </div>
                </div>                
            </div>
        <form>
            <div class="row" style="padding-left: 5px !important; padding-right: 5px !important;">
               
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label  class="control-label" for="cls">Class</label>
                    <select id="stcls" class="we-select form-control">
                        <?php
                        while ($row = mysqli_fetch_object($cls)) {
                            ?>
                        <option value="<?=$row->id;?>"><?=$row->classname;?></option>   
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label  class="control-label" for="cls">Year Of completion</label>
                    <select id="comyear" class="we-select form-control">
                        <?php
                        while ($row2 = mysqli_fetch_object($ayear)) {
                            ?>
                        <option value="<?=$row2->ayear;?>"><?=$row2->ayear;?></option>   
                            <?php
                        }
                        ?>
                    </select>
                </div>
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label  class="control-label" for="cls">Student's Name</label>
                    <select id="stname2" class="we-select" style="width: 100%;">
                       
                    </select>
                </div>  
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <br/>                    
                    <button onclick="getcls_list();" type="button" class="btn btn-good waves-effect waves-button">Print</button>
                </div>                
            </div>            
            </div>            
        </form>        
    </div>
    <br/>
    <span style="color: red;" id="cntcont">
  
    </span>
</div>


<script type="text/javascript">

   function getcls_list(){
     var cls = $("#stcls").val();
     var ayear = $("#comyear").val();
     var stname = $("#stname2").val();
     var term = $("#term").val();
     $.getJSON("cnt_trscrpt.php?stname="+$("#stname2").val(),function(dataobj){
    
    if (dataobj.count_val === 0){
        $(".dlg-ex").html("<span style='color:red;'>No records found for selected student</span>");
        $(".dlg-ex").dialog({
            show:"bounce",
            hide:"fade",
            modal:"true",
            buttons:{
                Ok:function(){
                    
                    $(this).dialog("close");
                    
                }
                
                
            }
            
            
            
        });
        
    }   else{
        
         window.open("transcript.php?cls="+cls+"&stname="+stname+"&comyear="+ayear,"Student's Transcript","outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");
     
    }    
    
    });
         
   } 
    
$(document).ready(function(){
  $.get("getstnames2.php?cls="+$("#stcls").val()+"&year="+$("#comyear").val(),function(data){
            $("#stname2").text("");
             $("#stname2").html(data);
        });
   
      //---------------------------------------------------------------------------------------------
$("#stname2").select2({ placeholder: 'select students name'});
    $("#stcls").change(function(){
        
        $.get("getstnames2.php?cls="+$("#stcls").val()+"&year="+$("#comyear").val(),function(data){
           
            
            $("#stname2").text("");
             $("#stname2").html(data);
        });
      
//        $.getJSON("cnt_cls.php?clas="+$("#cls").val()+"&ayear="+$("#ayer").val(),function(dataobj){
//    
//            $("#cntcont").html("There are "+ dataobj.count_val +" student(s) in this class");
//        });
    });
    $("#comyear").change(function(){
      $("#stcls").change();
  });    
    
    
});
</script>


