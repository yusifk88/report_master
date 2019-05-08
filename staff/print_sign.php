<?php
include_once 'objts/config.php';
$cf = new config();
$cf->connect();

$prog = mysqli_query("select * from dept");
$ayear = mysqli_query("select distinct(ayear) from stuinfo");
$cls = mysqli_query("select * from classes");

?>

<div class="col-lg-6 col-md-6 col-lg-offset-3 col-md-offset-3 col-sm-12 col-xs-12">
    <div class="panel panel-info" style="border-radius: 0;">
        <div class="panel-body">            
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="alert alert-info">                        
                        <p class="panel-title">Print Sign List</p>
                    </div>
                </div>                
            </div>
        <form>
            <div class="row" style="padding-left: 5px; padding-right: 5px; padding-bottom: 5px;">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label  class="control-label" for="prog2">Programe</label>
                    <select id="prog2" class="we-select form-control">
                        <?php
                        while ($row = mysqli_fetch_object($prog)) {
                            ?>
                        <option value="<?=$row->id;?>"><?=$row->depname;?></option>   
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row" style="padding-left: 5px; padding-right: 5px; padding-bottom: 5px;">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label  class="control-label" for="cls4">Class</label>
                    <select id="cls4" class="we-select form-control">
                        <?php
                        while ($row1 = mysqli_fetch_object($cls)) {
                            ?>
                        <option value="<?=$row1->id;?>"><?=$row1->classname;?></option>   
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
                <div class="row" style="padding-left: 5px; padding-right: 5px; padding-bottom: 5px;">
                          
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label class="control-label" for="ayer3">Academic Year</label>
                    <select id="ayer3" class="we-select form-control">
                        <?php
                        while ($row2 = mysqli_fetch_object($ayear)){
                            ?>
                        <option><?=$row2->ayear;?></option>  
                            <?php
                            }
                          ?>
                    </select>
                </div>
                </div>
            <div class="row" style="padding-left: 5px; padding-right: 5px; padding-bottom: 5px;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label class="control-label" for="rate">Rate</label>
                    
                    <input style="text-align: center;" type="text" id="rate" class="form-control" placeholder="Enter rate amount (GH¢)" />
                </div>
            </div>
                <div class="col-md-12">                  
                    <br/>                    
                    <button onclick="getprog_list();" type="button" class="wb wb-good">Print</button>
                </div>                
            </div>            
            </div>            
        </form>        
    </div>
    <br/>
    <span style="color: red;" id="cntcont2">
  
    </span>
</div>


<script type="text/javascript">
   function getprog_list(){
     var prog = $("#prog2").val();
     var ayear = $("#ayer3").val();
     var cls = $("#cls4").val();
     if (!$("#rate").val()){
         
         $(".dlg-ex").html("<span style='color:red;'>Rate not entered, please enter rate</span>");
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
       
     }else{
     $.getJSON("cnt_sign.php?prog="+$("#prog2").val()+"&ayear="+$("#ayer3").val()+"&cls="+$("#cls4").val(),function(dataobj){    
    if (dataobj.count_val === 0){
        $(".dlg-ex").html("<span style='color:red;'>No student found</span>");
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
    }else{        
         window.open("sign_list.php?ayear="+ayear+"&prog="+prog+"&cls="+cls+"&rate="+$("#rate").val(),"Sign List","outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");
    }    
    });
   } }
$(document).ready(function(){
    $("#prog").change(function(){
        $.getJSON("cnt_sign.php?prog="+$("#prog2").val()+"&ayear="+$("#ayer3").val()+"&cls="+$("#cls4").val(),function(dataobj){
            $("#cntcont2").html("There are "+ dataobj.count_val +" student(s) that offer this programe");
        });
    });
    $("#ayer2").change(function(){
        $("#prog").change();
    });
});
</script>

