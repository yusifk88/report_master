<?php
include_once 'objts/config.php';
$cf = new config();
$cf->connect();

$hse = mysqli_query("select * from houses");
$ayear = mysqli_query("select distinct(ayear) from stuinfo");

?>

<div class="col-lg-6 col-md-6 col-lg-offset-3 col-md-offset-3 col-sm-12 col-xs-12">
    <div class="panel panel-info" style="border-radius: 0;">
        <div class="panel-body">            
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="alert alert-info">                        
                        <p class="panel-title">Print House List</p>
                    </div>
                </div>                
            </div>
        <form>
            <div class="row" style="padding-left: 5px; padding-right: 5px; padding-bottom: 5px;">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label  class="control-label" for="huse">Class</label>
                    <select id="huse" class="we-select form-control">
                        <?php
                        while ($row = mysqli_fetch_object($hse)) {
                            ?>
                        <option value="<?=$row->id;?>"><?=$row->name;?></option>   
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label class="control-label" for="ayer3">Academic Year</label>
                    <select id="ayer3" class="we-select form-control">
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
                    <button onclick="gethse_list();" type="button" class="wb wb-good">Print</button>
                </div>                
            </div>            
            </div>            
        </form>        
    </div>
    <br/>
    <span style="color: red;" id="cntcont3">
  
    </span>
</div>


<script type="text/javascript">
    function gethse_list(){
     var hse = $("#huse").val();
     var ayear = $("#ayer3").val();
     $.getJSON("cnt_hse.php?hse="+$("#huse").val()+"&ayear="+$("#ayer3").val(),function(dataobj){
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
        
         window.open("hse_list.php?ayear="+ayear+"&hse="+hse,"House List","outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");
     
    }    
    
    });
         
   } 
    
$(document).ready(function(){
    $("#huse").change(function(){
      
        $.getJSON("cnt_hse.php?hse="+$("#huse").val()+"&ayear="+$("#ayer3").val(),function(dataobj){
    
            $("#cntcont3").html("There are "+ dataobj.count_val +" student(s) in this house");
        });
    });
    $("#ayer3").change(function(){
        $("#huse").change();
    });
});
</script>
