<?php
include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$cls = mysqli_query($cf->con,"select * from classes order by classname ASC");
$ayear = mysqli_query($cf->con,"select distinct(acyear) from records");
$stud = mysqli_query($cf->con,"select id,fname,lname,oname from stuinfo order by fname ASC");
?>
<div class="col-md-12">

    <div class="row">

        <div class="col-md-3"></div>


<div class="col-lg-6 col-md-6 col-sm-12 col-12">
    <div class="card card-info" style="border-radius: 0;">
        <div class="card-header bg-info text-white">
            <p class="card-title">Print Reports For A Class</p>
        </div>
        <div class="card-body">
        <form>
            <div class="row" style="padding-left: 5px !important; padding-right: 5px !important;">
               
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label  class="control-label" for="cls">Class</label>
                    <select id="stcls1" class="form-control">
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
                    <select id="ayer6" class="we-select form-control">
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
                    <select id="term2" class="we-select form-control">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                    </select>
                </div>
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <br/>                    
                    <button onclick="get_rep_all();" type="button" class="btn bg-info">Print</button>
                </div>                
            </div>            
            </div>            
        </form>        
    </div>
    <br/>
    <span style="color: red;" id="cntcont">
  
    </span>
</div>

    </div>


</div>


<script type="text/javascript">

   function get_rep_all(){
     var cls = $("#stcls1").val();
     var ayear = $("#ayer6").val();
     var term = $("#term2").val();
     $.getJSON("cnt_all.php?ayear="+$("#ayer6").val()+"&term="+$("#term2").val()+"&cls="+$("#stcls1").val(),function(dataobj){
     if (dataobj.count_val === 0){
     Snarl.addNotification({
                        title:"NO RECORD",
                        text:"No Records found in this class with this academic year",
                        icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                        timeout:3000
                    });
                    $(".snarl-notification").addClass('snarl-error');
        
    }   else{
        
         window.open("rep_all.php?ayear="+ayear+"&cls="+cls+"&term="+term,"Terminal reports","outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");
     
    }    
    
    });
         
   } 
    
$(document).ready(function(){
 
    
});
</script>


