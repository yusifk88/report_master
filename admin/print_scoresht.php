<?php
include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$cls = mysqli_query($cf->con,"select * from classes order by classname ASC");
$ayear = mysqli_query($cf->con,"select distinct(ayear) from stuinfo");
$stud = mysqli_query($cf->con,"select id,fname,lname,oname from stuinfo order by fname ASC");
$subjts = mysqli_query($cf->con,"select * from subjects");
?>
<div class="col-md-12">
    <div class="row">
<div class="col-md-3"></div>
<div class="col-lg-6 col-md-6 col-sm-12 col-12">
    <div class="card card-info" style="border-radius: 0;">
        <div class="card-header bg-info text-white">
            <p class="card-title">Print Assessment Score sheet</p>
        </div>
        <div class="card-body">
        <form>
            <div class="row" style="padding-left: 5px !important; padding-right: 5px !important;">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label  class="control-label" for="cls">Subject</label>
                    <select id="subjt" class="form-control">
                        <?php
                        while ($subrow = mysqli_fetch_object($subjts)) {
                            ?>
                        <option value="<?=$subrow->id;?>"><?=$subrow->subjdesc;?></option>   
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label  class="control-label" for="cls">Class</label>
                    <select id="stcls5" class="form-control">
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
                    <select id="ayer0" class="we-select form-control">
                        <?php
                        while ($row2 = mysqli_fetch_object($ayear)) {
                            
                            ?>
                        <option><?=$row2->ayear;?></option>   
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label class="control-label" for="cls">Term</label>
                    <select id="term6" class="we-select form-control">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                    </select>
                </div>
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <br/>                    
                    <button onclick="get_brdsheet();" type="button" class="btn bg-info">Print</button>
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
    </div>
</div>
<script type="text/javascript">
   function get_brdsheet(){
     var cls = $("#stcls5").val();
     var ayear = $("#ayer0").val();
     var term = $("#term6").val();
     var sub = $("#subjt").val();
     $.getJSON("cnt_scoresht.php?ayear="+$("#ayer0").val()+"&term="+$("#term6").val()+"&cls="+$("#stcls5").val(),function(dataobj){
     if (dataobj.count_val === 0){
       Snarl.addNotification({
                        title:"NO RECORD",
                        text:"No Records found in this class with this academic year",
                        icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                        timeout:3000
                    });
                    $(".snarl-notification").addClass('snarl-error');

    }   else{

         window.open("scoresheet.php?ayear="+ayear+"&cls="+cls+"&term="+term+"&sub="+sub,"Terminal Score Sheet","outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");
     
    }
    
    });
         
   } 
    
$(document).ready(function(){
 
    
});
</script>


