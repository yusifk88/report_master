<?php

include_once '../admin/objts/config.php';
$cf = new config();
$cf->connect();
$cls = $_GET['cls'];
$ayear = $_GET['ayear'];
$term = $_GET['term'];
$subjt = $_GET['subjt'];
$stid = $_GET['stid'];
$per_page = 1;
//$page_query = mysqli_query("select count(*) from stuinfo where class='$cls' and");
$page = ( isset($_GET['page'])) ? (int) $_GET['page']:1;
$start = ($page-1) * $per_page;
$cnsql =mysqli_query($cf->con,"select id,fname,lname,oname,photo from stuinfo where class='$cls' and id like '%$stid%' and ayear = '$ayear' and id  not in (select stid from records  where hw1 is not null and hw2 is not null and hw3 is not null and hw4 is not null and acyear = '$ayear' and term = '$term' and subjt = '$subjt' and cls = '$cls' ) and id not in(SELECT stid from withdraw)");
$stinputs = mysqli_query($cf->con,"select id,fname,lname,oname,photo from stuinfo where class='$cls'and id like '%$stid%' and ayear = '$ayear' and id not in (select stid from records where hw1 is not null and hw2 is not null and hw3 is not null and hw4 is not null and acyear = '$ayear' and term = '$term' and subjt = '$subjt' and cls = '$cls') and id not in(SELECT stid from withdraw) order by fname ASC LIMIT ".$start.",".$per_page);
$recount = mysqli_num_rows($cnsql);
$pages = ceil($recount/$per_page);
$stnames = mysqli_query($cf->con,"select id,fname,lname,oname,photo from stuinfo where class='$cls' and ayear = '$ayear' and id not in (select stid from records where hw1 is not null and hw2 is not null and hw3 is not null and hw4 is not null and acyear = '$ayear' and term = '$term' and subjt = '$subjt' and cls = '$cls') and id not in(SELECT stid from withdraw) order by fname ASC ");

if(mysqli_num_rows($stinputs)>0){
while ($row = mysqli_fetch_assoc($stinputs)) {
 ?>  
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="panel panel-info" style="border-radius: 0;">
            <div class="panel-body">
                <form id="cls-hworkform">
                    <input type="hidden" value="<?=$row['id']?>" id="stid2" />
                    <br>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <button onclick="skipstud2(1);" class="btn btn-good waves-effect pull-right">Reset <i class="fa fa-undo"></i></button>
                        </div>

                        <div class="col-lg-8 col-md-8  col-sm-8 col-xs-8">
                            <label class="control-label">Select Student</label>
                            <select id="stname" class="form-control">
                                <option value="">Select Student</option>
                                <?php
                                while($strow = mysqli_fetch_object($stnames)){
                                    ?>
                                    <option value="<?=$strow->id?>"><?=$strow->fname." ".$strow->lname." ".$strow->oname?></option>
                                    <?php
                                }
                                ?>

                            </select>
                        </div>
                    </div>
                    <br>
                <div class="row">
                    <div class="col-lg-2 col-md-2 co-sm-4 col-xs-4">
                        <img src="../admin/<?= $row['photo'];?>" width="180" height="200" class="img-thumbnail" />
                        
                        
                    </div>
                    
               
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-8">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                        <label class="control-label">Full Name</label>                      
                        <input style="font-weight: bold; color: red;" class="form-control" type="text" value=" <?= $row['fname']." ".$row['lname']." ".$row['oname']; ?>" readonly="" />
                                              
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-md-2">
                        <label class="control-label">Ex. One</label>
                        <input style="text-align: center" id="hw1" class="form-control" type="number" value="0" />
                         </div>                      
                        <div class="col-lg-2 col-md-2">
                        <label class="control-label">Ex. Two</label>
                        <input style="text-align: center" id="hw2" class="form-control" type="number" value="0" />
                         </div>                      
                        <div class="col-lg-2 col-md-2">
                        <label class="control-label">Ex. Three</label>
                        <input style="text-align: center" id="hw3" class="form-control" type="number" value="0" />
                         </div>                      
                        <div class="col-lg-2 col-md-2">
                        <label class="control-label">Ex. Four</label>
                        <input style="text-align: center" id="hw4" class="form-control" type="number" value="0" />
                         </div>  
                        <div class="col-lg-2 col-md-2">                       
                          <label class="control-label">Total</label>                      
                        <input style="text-align: center" readonly="" id="hwtotl" class="form-control" type="number" value="0" />
                        </div>          
                          </div>                      
                                     
                    </div>
                    </div>
                </div>
           

            <div class="panel-footer clsfooter">
                <input type="hidden" value="<?=$page?>" id="nexval" />

                <?php


                $next = $page+1;
                $prev = $page-1;
                if($page>1){?>

                    <button id="skipbtn" onclick="skipstud2(<?=$prev?>)" type="button" class="btn btn-good waves-effect waves-button pull-left">&les;&les; Back</button>
                    <?php

                }

                ?>
                <span class="text-success"> <i class="fa fa-info-circle"></i> <strong>NOTE.</strong> Scores under this category should sum up to a maximum of 40 </span>

                <?php
              // echo 'term:'. $term."year:".$ayear."sub:".$subjt."cls:".$cls;

               if($page<$pages){
                   
               ?>
               
                <button id="skipbtn2" onclick="skipstud2(<?=$next?>)" type="button" class="btn btn-good waves-effect waves-button pull-right">Skip &GreaterGreater;</button>
                    <input type="hidden" value="notend" id="endval2" />
               
               <?php
               
               }  else {
               ?>
                    
                <input type="hidden" value="end" id="endval2" />
                
                 <?php  
               }
               ?>
            </div></form>
         </div>
    </div>   
    
</div>

   <?php 
}}else{
    ?>
    <h2 class="text-muted"><span class="glyphicon glyphicon-warning-sign"></span>Sorry, no records found, this could be because Class Exercise records on all students in this class were recorded or no student exist in the selected class </h2>
    <?php
    
}

?>


<script>
    
    
     function skipstud2(page){
         var sid = $("#stname").val();
         $.get("getstudinputs-hw.php?page="+page+"&cls="+$("#assess_class").val()+"&ayear="+$("#assess-ayear").val()+"&term="+$("#assess-term").val()+"&subjt="+$("#assess-subjt").val()+"&stid="+sid,function(data){
             $("div#hw-cont").hide();
             $("div#hw-cont").html(data);
             $("div#hw-cont").fadeIn(100);
         });
    }

    function savhwork(){
        var stid = $("#stid2").val();
        var hw1 = $("#hw1").val();
        var hw2 = $("#hw2").val();
        var hw3 = $("#hw3").val();
        var hw4 = $("#hw4").val();
        var totl = $("#hwtotl").val();
        var cls = $("#assess_class").val();
        var term = $("#assess-term").val();
        var ayear = $("#assess-ayear").val();
        var sub = $("#assess-subjt").val();
        if(Number(totl) ===0){
           $("#hw1").focus();
        }else if(Number(totl)>40){
            Snarl.addNotification({
                title:"ERROR",
                text:"Class exercise records should sum up to a maximum of 40, please check and try again",
                icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                timeout:3000
            });
            $(".snarl-notification").addClass('snarl-error');
        }else{
            var progress = Snarl.addNotification({
                title:"Please Wait...",
                text:"Saving Assignment record",
                icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-circle-o-notch fa-spin'></i>",
                timeout:null
            });
            $(".snarl-notification").addClass('snarl-info');

            $.get("savehwork.php?stid="+stid+"&hw1="+hw1+"&hw2="+hw2+"&hw3="+hw3+"&hw4="+hw4+"&totl="+totl+"&term="+term+"&cls="+cls+"&ayear="+ayear+"&sub="+sub,function(data){
            }).done(function(data){
                $("#assess-subjt").change();
                Snarl.removeNotification(progress);
                Snarl.addNotification({
                    title:"SAVED",
                    text:data,
                    icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle-o'></i>",
                    timeout:3000
                });
                $(".snarl-notification").addClass('snarl-success');
                skipstud2(1);
            });
            
            
        }
        
        
    }
    $(document).ready(function(){


        $("#stname").change(function(){
            skipstud2(1);

        });
     $("#hw1,#hw2,#hw3,#hw4").keyup(function(){
            var hw1 = isNaN($("#hw1").val())? 0: $("#hw1").val();
            var hw2 = isNaN($("#hw2").val())? 0: $("#hw2").val();
            var hw3 = isNaN($("#hw3").val())? 0: $("#hw3").val();
            var hw4 = isNaN($("#hw4").val())? 0: $("#hw4").val(); 
            var sum = (Number(hw1) + Number(hw2) + Number(hw3) + Number(hw4));
             $("#hwtotl").val(sum);                   
       
    });
     $("#hw1,#hw2,#hw3,#hw4").focusin(function(){
         if( Number($(this).val())<=0){
             $(this).val("");
         }
         
     });
     $("#hw1,#hw2,#hw3,#hw4").focusout(function(){
         if( Number($(this).val())<=0){
             $(this).val(0);
         }
         
     });
    
     $("#hw1,#hw2,#hw3,#hw4").keypress(function(e){
         if(e.which===13){
             savhwork();             
         }
     
         if(!((e.which>=47 && e.which<=58)|| e.which===8 || e.which===0)){
             e.preventDefault();
             
         }

     });
    });
</script>
    