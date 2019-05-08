<?php
include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$cls = mysqli_query("select * from classes order by classname ASC");
$ayear = mysqli_query("select distinct(acyear) from records");
$stud = mysqli_query("select id,fname,lname,oname from stuinfo order by fname ASC");
?>

<div class="col-lg-6 col-md-6 col-lg-offset-3 col-md-offset-3 col-sm-12 col-xs-12">
    <div class="panel panel-info" style="border-radius: 0;">
        <div class="panel-body">            
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="alert alert-info">                        
                        <p class="panel-title">Print Assessment Broadsheet</p>
                    </div>
                </div>                
            </div>
        <form>
            <div class="row" style="padding-left: 5px; padding-right: 5px; padding-bottom: 5px;">
               
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label  class="control-label" for="cls">Class</label>
                    <select id="stcls2" class="form-control">
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
                   
                </div>
                
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label class="control-label" for="cls">Academic Year</label>
                    <select id="ayer7" class="we-select form-control">
                        <?php
                        while ($row2 = mysqli_fetch_object($ayear)) {
                            
                            ?>
                        <option><?=$row2->acyear;?></option>   
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label class="control-label" for="cls">Term</label>
                    <select id="term3" class="we-select form-control">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                    </select>
                </div>
                <div class="col-md-12">                  
                    <br/>                    
                    <button onclick="get_brdsheet();" type="button" class="wb wb-good">Print</button>
                </div>                
            </div>            
            </div>            
        </form>        
    </div>
    <br/>
    <span style="color: red;" id="cntcont">
        <span class="glyphicon glyphicon-warning-sign"></span> The document you are about to generate should be printed in landscape
    </span>
</div>


<script type="text/javascript">

   function get_brdsheet(){
     var cls = $("#stcls2").val();
     var ayear = $("#ayer7").val();
     var term = $("#term3").val();
     $.getJSON("cnt_all.php?ayear="+$("#ayer7").val()+"&term="+$("#term3").val()+"&cls="+$("#stcls2").val(),function(dataobj){
     if (dataobj.count_val === 0){
        $(".dlg-ex").html("<span style='color:red;'>No records found on this class for the selected academic year and term</span>");
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
        
         window.open("brdsheet.php?ayear="+ayear+"&cls="+cls+"&term="+term,"Terminal reports","outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");
     
    }    
    
    });
         
   } 
    
$(document).ready(function(){
 
    
});
</script>


