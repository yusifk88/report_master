<?php
include_once 'objts/config.php';
$cf = new config();
$cf->connect();

$cls = mysqli_query("select * from classes");
$ayear = mysqli_query("select distinct(ayear) from stuinfo");

?>

<div class="col-lg-6 col-md-6 col-lg-offset-3 col-md-offset-3 col-sm-12 col-xs-12">
    <div class="panel panel-info" style="border-radius: 0;">
        <div class="panel-body">            
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="alert alert-info">                        
                        <p class="panel-title">Print class List</p>
                    </div>
                </div>                
            </div>
        <form>
            <div class="row" style="padding-left: 5px; padding-right: 5px; padding-bottom: 5px;">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label  class="control-label" for="cls">Class</label>
                    <select id="cls" class="we-select form-control">
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
                    <label class="control-label" for="cls">Academic Year</label>
                    <select id="ayer" class="we-select form-control">
                        <?php
                        while ($row2 = mysqli_fetch_object($ayear)) {
                            
                            ?>
                        <option><?=$row2->ayear;?></option>   
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-12">                  
                    <br/>                    
                    <button onclick="getcls_list();" type="button" class="wb wb-good">Print</button>
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
     var cls = $("#cls").val();
     var ayear = $("#ayer").val();
     $.getJSON("cnt_cls.php?clas="+$("#cls").val()+"&ayear="+$("#ayer").val(),function(dataobj){
    
    if (dataobj.count_val === 0){
        $(".dlg-ex").html("<span style='color:red;'>No student found in this class with this academic year</span>");
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
        
         window.open("cls_list.php?ayear="+ayear+"&cls="+cls,"Class List","outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");
     
        
    }    
    
    });
         
   } 
    
$(document).ready(function(){
    $("#cls").change(function(){
      
        $.getJSON("cnt_cls.php?clas="+$("#cls").val()+"&ayear="+$("#ayer").val(),function(dataobj){
    
            $("#cntcont").html("There are "+ dataobj.count_val +" student(s) in this class");
        });
        
        
    });
    $("#ayer").change(function(){
        $("#cls").change();
        
        
    });
    
    
});
</script>

