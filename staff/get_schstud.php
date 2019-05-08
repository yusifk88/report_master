<?php
include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$id = $_GET['id'];
$studs = mysqli_query($cf->con,"select stuinfo.id,fname,oname,lname,stindex,form,classes.classname,dept.depname,dob,dor,ffname,fhometown,ftel,gender,ayear,houses.des,houses.name,lschool,mfname,mhometown,mtel,photo from stuinfo,classes,dept,houses where stuinfo.class = classes.id and stuinfo.dept = dept.id and stuinfo.house = houses.id and stuinfo.id = '$id' ");
while ($row = mysqli_fetch_assoc($studs)) {
$id = $row['id'];
$wtest=mysqli_query($cf->con,"select * from withdraw WHERE stid = '$id'");
if(mysqli_num_rows($wtest)<1) {

    ?>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin:0 !important;">
        <div class="panel panel-default"
             style="margin:0 !important; margin-bottom: 2px !important; border-radius: 0 !important;">
            <div class="panel-body" style="padding: 0 !important; margin: 0 !important;">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3"
                         style="margin: 0 !important;  text-align: center !important; padding-right: 0 !important; ">


                        <img style="max-height: 170px; border-radius: 0 !important; " alt="<?php echo $row['fname']; ?>"
                             src="../admin/<?= $row['photo'] ?>" class="img-thumbnail img-responsive"/>

                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-9"
                         style="margin: 0 !important; padding-left: 0 !important;">

                        <div class="table-responsive" style="margin: 0 !important; padding: 0 !important;">


                            <table class="table table-striped table-bordered table-condensed"
                                   style="padding: 0 !important; margin: 0 !important;">
                                <tr>

                                    <th style="text-align: right;">ID:</th>
                                    <td><?php echo $row['stindex']; ?></td>

                                    <th style="text-align: right;">Name:</th>
                                    <td colspan='3'>
                                        <?php echo $row['fname'] . ' ' . $row['lname'] . ' ' . $row['oname']; ?>

                                    </td>


                                    <th style="text-align: right;">Gender:</th>
                                    <td>
                                        <?= $row['gender']; ?>
                                </tr>
                                <tr>


                                    <th style="text-align: right;">D.O.B:</th>
                                    <td>
                                        <?php echo $row['dob']; ?>
                                    </td>
                                    <th style="text-align: right;">Form:</th>
                                    <td>
                                        <?php echo "Form " . $row['form']; ?>

                                    </td>

                                    <th style="text-align: right;">Program:</th>
                                    <td>
                                        <?= $row["depname"] ?>


                                    </td>
                                    <th style="text-align: right;">Class</th>
                                    <td>


                                        <?= $row["classname"]; ?>


                                        </select>

                                    </td>

                                </tr>

                                <tr>
                                    <th style="text-align: right;">House:</th>
                                    <td colspan='2'><?php echo $row['name']; ?></td>
                                    <th style="text-align: right;">Last Sch.:</th>
                                    <td colspan='2'><?php echo $row['lschool']; ?> </td>
                                    <th style="text-align: right;">Reg. Date:</th>
                                    <td><?php echo $row['dor']; ?></td>
                                </tr>

                                <tr>
                                    <th style="text-align: right;">Father's Name:</th>
                                    <td colspan='3'>
                                        <?php echo $row['ffname']; ?>
                                    </td>
                                    <th style="text-align: right;">Father's Hometown:</th>
                                    <td>
                                        <?php echo $row['fhometown']; ?>
                                    </td>
                                    <th style="text-align: right;">Father's Tel.:</th>
                                    <td>
                                        <?php echo $row['ftel']; ?>

                                    </td>
                                </tr>
                                <tr>
                                    <th style="text-align: right;">Mother's Name:</th>
                                    <td colspan='3'>
                                        <?php echo $row['mfname']; ?>
                                    </td>
                                    <th style="text-align: right;">Mother's Hometown:</th>
                                    <td>
                                        <?php echo $row['mhometown']; ?>


                                    </td>
                                    <th style="text-align: right;">Mother's Tel.:</th>
                                    <td>
                                        <?php echo $row['mtel']; ?>

                                    </td>
                                </tr>
                            </table>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer"
                 style=" padding: 0 !important; margin-top: 0!important; height: 2em !important;  padding-left: 10px !important;">
                <i onclick="upstud(<?= $row['id']; ?>)" title="Edit this student's info." data-toggle='tooltip'
                      id="edstud"
                      style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="fa fa-edit waves-effect waves-circle btn btn-link"></i> 
                <i onclick="printstud(<?php echo $row['id']; ?>)" data-id="<?php echo $row['id']; ?>"
                      title="Print this student's profile" data-toggle='tooltip' id="printstud"
                      style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="fa fa-print waves-effect waves-circle btn btn-link"></i>
                <i onclick="Comnt(<?php echo $row['id']; ?>)" data-id="<?php echo $row['id']; ?>"
                      title="Add extra info. to this studen's profile eg. suspension" data-toggle='tooltip'
                      id="printstud"
                      style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="fa fa-comment waves-effect waves-circle btn btn-link"></i>
                      <i onclick="printrep(<?php echo $row['id']; ?>)" data-id="<?php echo $row['id']; ?>"
                      title="Print termnal report" data-toggle='tooltip'
                      id="printstud"
                      style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="fa fa-bar-chart-o waves-effect waves-circle btn btn-link"></i> 
                      <i onclick="printtransc(<?php echo $row['id']; ?>)" data-id="<?php echo $row['id']; ?>"
                      title="Print Transcript" data-toggle='tooltip'
                      id="printstud"
                      style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="fa fa-line-chart waves-effect waves-circle btn btn-link"></i> 
					  

                <i onclick="withdraw(<?= $row['id']; ?>)" data-id="<?php echo $row['id']; ?>"
                      title="Withdraw this student from the school" data-toggle='tooltip'
                      style="font-weight: bold; color: red; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="fa fa-undo waves-circle waves-effect btn btn-link"></i>

                <i onclick="delstud('<?php echo $row['id']; ?>')" data-stid="<?php echo $row['id']; ?>"
                      title="Delete this student" data-toggle='tooltip' id="delstud"
                      style="color: red; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="fa fa-remove btn waves-effect waves-circle btn-link"></i>
            </div>
        </div>


    </div>


    <?php
}else{

    ?>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin:0 !important;">
        <div class="panel panel-default"
             style="margin:0 !important; margin-bottom: 2px !important; border-radius: 0 !important;">
            <div class="panel-body" style="padding: 0 !important; margin: 0 !important;">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3"
                         style="margin: 0 !important;  text-align: center !important; padding-right: 0 !important; ">
                        <img style="max-height: 170px; border-radius: 0 !important; " alt="<?php echo $row['fname']; ?>"
                             src="../admin/<?= $row['photo'] ?>" class="img-thumbnail img-responsive"/>

                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-9"
                         style="margin: 0 !important; padding-left: 0 !important;">
                        <div class="table-responsive text-danger" style="margin: 0 !important; padding: 0 !important;">
                            <table class="table table-striped table-bordered table-condensed"
                                   style="padding: 0 !important; margin: 0 !important;">
                                <tr>

                                    <th style="text-align: right;">ID:</th>
                                    <td><?php echo $row['stindex']; ?></td>

                                    <th style="text-align: right;">Name:</th>
                                    <td colspan='3'>
                                        <?php echo $row['fname'] . ' ' . $row['lname'] . ' ' . $row['oname']; ?>

                                    </td>


                                    <th style="text-align: right;">Gender:</th>
                                    <td>
                                        <?= $row['gender']; ?>
                                </tr>
                                <tr>


                                    <th style="text-align: right;">D.O.B:</th>
                                    <td>
                                        <?php echo $row['dob']; ?>
                                    </td>
                                    <th style="text-align: right;">Form:</th>
                                    <td>
                                        <?php echo "Form " . $row['form']; ?>

                                    </td>

                                    <th style="text-align: right;">Program:</th>
                                    <td>
                                        <?= $row["depname"] ?>


                                    </td>
                                    <th style="text-align: right;">Class</th>
                                    <td>


                                        <?= $row["classname"]; ?>


                                        </select>

                                    </td>

                                </tr>

                                <tr>
                                    <th style="text-align: right;">House:</th>
                                    <td colspan='2'><?php echo $row['name']; ?></td>
                                    <th style="text-align: right;">Last Sch.:</th>
                                    <td colspan='2'><?php echo $row['lschool']; ?> </td>
                                    <th style="text-align: right;">Reg. Date:</th>
                                    <td><?php echo $row['dor']; ?></td>
                                </tr>

                                <tr>
                                    <th style="text-align: right;">Father's Name:</th>
                                    <td colspan='3'>
                                        <?php echo $row['ffname']; ?>
                                    </td>
                                    <th style="text-align: right;">Father's Hometown:</th>
                                    <td>
                                        <?php echo $row['fhometown']; ?>
                                    </td>
                                    <th style="text-align: right;">Father's Tel.:</th>
                                    <td>
                                        <?php echo $row['ftel']; ?>

                                    </td>
                                </tr>
                                <tr>
                                    <th style="text-align: right;">Mother's Name:</th>
                                    <td colspan='3'>
                                        <?php echo $row['mfname']; ?>
                                    </td>
                                    <th style="text-align: right;">Mother's Hometown:</th>
                                    <td>
                                        <?php echo $row['mhometown']; ?>


                                    </td>
                                    <th style="text-align: right;">Mother's Tel.:</th>
                                    <td>
                                        <?php echo $row['mtel']; ?>

                                    </td>
                                </tr>
                            </table>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer"
                 style=" padding: 0 !important; margin-top: 0!important; height: 2em !important;  padding-left: 10px !important;">
                <span onclick="upstud(<?= $row['id']; ?>)" title="Edit this student's info." data-toggle='tooltip'
                      id="edstud"
                      style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="glyphicon glyphicon-edit btn btn-link"></span> &nbsp; &nbsp;
                <span onclick="printstud(<?php echo $row['id']; ?>)" data-id="<?php echo $row['id']; ?>"
                      title="Print this student's profile" data-toggle='tooltip' id="printstud"
                      style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="glyphicon glyphicon-print btn btn-link"></span>&nbsp; &nbsp;
                <span onclick="Comnt(<?php echo $row['id']; ?>)" data-id="<?php echo $row['id']; ?>"
                      title="Add extra info. to this studen's profile eg. suspension" data-toggle='tooltip'
                      id="printstud"
                      style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="glyphicon glyphicon-comment btn btn-link"></span>&nbsp; &nbsp;
                      <i onclick="printrep(<?php echo $row['id']; ?>)" data-id="<?php echo $row['id']; ?>"
                      title="Print termnal report" data-toggle='tooltip'
                      id="printstud"
                      style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="fa fa-bar-chart-o waves-effect waves-circle btn btn-link"></i> 
                      <i onclick="printtransc(<?php echo $row['id']; ?>)" data-id="<?php echo $row['id']; ?>"
                      title="Print Transcript" data-toggle='tooltip'
                      id="printstud"
                      style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="fa fa-line-chart waves-effect waves-circle btn btn-link"></i> 					  
                <span onclick="unwithdraw(<?php echo $row['id']; ?>)" data-id="<?php echo $row['id']; ?>"
                      title="Resume this student back into the school" data-toggle='tooltip'
                      style="font-weight: bold; color: deepskyblue; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="fa fa-plus-square btn btn-link"></span>&nbsp; &nbsp;

                <span onclick="delstud('<?php echo $row['id']; ?>')" data-stid="<?php echo $row['id']; ?>"
                      title="Delete this student" data-toggle='tooltip' id="delstud"
                      style="color: red; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="glyphicon glyphicon-remove-circle btn btn-link"></span>
            </div>
        </div>
    </div>
    
<?php }

} ?>
    


<script>

function printtransc(id){

    window.open("transcript.php?id="+id,"Transcript","outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");
    
}

function printrep(id){

$.get("print_rep_one.php?stid="+id,function (data) {  
BootstrapDialog.show({
title:"Print termnal report for this student",
message:data,buttons:[{label:"VIEW & PRINT",cssClass:"btn-good waves-effect waves-button",action:function (d) {
    
    $.getJSON("cnt_rep.php?id="+id+"&ayear="+$("#ayer5").val()+"&term="+$("#term").val(),function(dataobj){    
    if (dataobj.count_val === 0){        
        Snarl.addNotification({
                          title:"NO RECORD",
                          text:"No records found for this student for the selected academic year and term",
                          icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                          timeout:8000
                      });
                      $(".snarl-notification").addClass('snarl-error');
    }   else{
        
         window.open("rep_one.php?ayear="+$("#ayer5").val()+"&id="+id+"&term="+$("#term").val(),"Termnal Report","outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");
     
    }    
    
    });
       
    
    
  }}]


});

});

}



    function unwithdraw(id){

        BootstrapDialog.show({
            title:"Confirm Resume",
            message:"Do you want to resume this student into the school?",
            buttons:[{label:"RESUME",cssClass:"btn-good waves-effect waves-button",action:function(d){
                d.close();
                $.get("uw.php?id="+id,function(){
                }).done(function(){
                          $.get("get_schstud.php?id="+id,function(data){
        
                        }).done(function(data){

                        $("#schres").html(data);
              Snarl.addNotification({
                        title:"RESUMED",
                        text:"Student Resumed successfully",
                        icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle-o'></i>",
                        timeout:3000
                    });
                    $(".snarl-notification").addClass('snarl-success');
                        });
                 
                });
            }}]

        });

    }


    function withdraw(id){
        showprog();
        $.get("wfrm.php?id="+id,function(data){
        }).done(function(data){
            finish();
            BootstrapDialog.show({
                title:"Withdraw This student",
                message:data,
                buttons:[{label:"WITHDRAW",cssClass:"btn-bad waves-effect waves-button",action:function(d){
                    if(!$("#wresn").val()){
                        $("#wresn").focus();
                    }else if(!$("#wdate").val()){
                        $("#wdate").focus();
                    }else {
                        d.close();
                        $("#wfrm").submit();
						$.get("get_schstud.php?id="+id,function(data){        
                        }).done(function(data){
                        $("#schres").html(data);           
                        });
                    }
                }}]

            });
        }).error(function(){
            finish();
            show_error();
        });
    }


    function Comnt(id){
        showprog();
        $.get("getcomnts.php?id="+id,function(data){

            BootstrapDialog.show({
                title:"Manage Comments Under This Student",
                message:data,
                size:"size-wide",
                closable:false,
                buttons:[{label:"DONE",cssClass:"btn-good waves-effect waves-button",action:function(d){
                        d.close();
                }}]

            });
        }).done(function(){

finish();


        }).error(function(){

            finish();
            show_error();

        });
    }






    
    function upstud(id){
        showprog();
  $.get("upstud_inputs.php?id="+id,function(data){
  }).done(function(data){
finish();
     BootstrapDialog.show({
         title:"Update Student's Info.",
         message:data,
         size:"size-wide",
         closable:false,
         buttons:[{label:"UPDATE",cssClass:"btn-good waves-effect waves-button",action:function(d){

                  if(!$("#upfname").val()){
                      Snarl.addNotification({
                          title:"MISSING INPUT",
                          text:"First name not entered, please check and try again",
                          icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                          timeout:8000
                      });
                      $(".snarl-notification").addClass('snarl-error');


                  }else if(!$("#uplname").val()){
                      Snarl.addNotification({
                          title:"MISSING INPUT",
                          text:"Last name not entered, please check and try again",
                          icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                          timeout:8000
                      });
                      $(".snarl-notification").addClass('snarl-error');


                  }else if(!$("#upffname").val()){

                      Snarl.addNotification({
                          title:"MISSING INPUT",
                          text:"Father's name not entered, please check and try again",
                          icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                          timeout:8000
                      });
                      $(".snarl-notification").addClass('snarl-error');
                  }else if(!$("#upfhometown").val()){

                      Snarl.addNotification({
                          title:"MISSING INPUT",
                          text:"Father's hometown not entered, please check and try again",
                          icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                          timeout:8000
                      });
                      $(".snarl-notification").addClass('snarl-error');
                  }else if(!$("#upftel").val()){


                      Snarl.addNotification({
                          title:"MISSING INPUT",
                          text:"Father's Tel. not entered, please check and try again",
                          icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                          timeout:8000
                      });
                      $(".snarl-notification").addClass('snarl-error');

                  }else if(!$("#upmname").val()){
                      Snarl.addNotification({
                          title:"MISSING INPUT",
                          text:"Mother's name not entered, please check and try again",
                          icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                          timeout:8000
                      });
                      $(".snarl-notification").addClass('snarl-error');


                  }else if(!$("#upmhometown").val()){

                      Snarl.addNotification({
                          title:"MISSING INPUT",
                          text:"Mother's Hometown not entered, please check and try again",
                          icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                          timeout:8000
                      });

                      $(".snarl-notification").addClass('snarl-error');

                  }else{
                      d.close();
                      var progress = Snarl.addNotification({
                          title:"Please Wait...",
                          text:"Updating Student's Info.",
                          icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-circle-o-notch fa-spin'></i>",
                          timeout:null
                      });

                      var data = $("#stud_upform :input").serializeArray();
                      $.post("upstud_script.php",data,function(d){
                      }).done(function(d){
                                 $.get("get_schstud.php?id="+id,function(data){
        
                        }).done(function(data){

                        $("#schres").html(data);
						Snarl.removeNotification(progress);
                          Snarl.addNotification({
                              title:"UPDATED",
                              text:d,
                              icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle-o'></i>",
                              timeout:3000
                          });
                          $(".snarl-notification").addClass('snarl-success');
                        });
                         

                      });


                  }

    }},{label:"CANCEL",cssClass:"btn-bad waves-button waves-effect",action:function(d){d.close();}}]});

  }).error(function(){
      show_error();

  });

    }

                 function printstud(id){
        window.open("studprofile.php?id="+id,"Student's Profile","outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");
        
        
    }
$(document).ready(function(){
    
     
    

    
    $("span").tooltip();
    
    //$(".we-select").select2();
    $('#cbopage-list').change(function(){
        var page = $(this).val();
        getstud(page);
        
        
    });
//    $('#delstud').click(function(){
//        
//        alert($(this).attr('data-stid'));
//        
//        
//    });
    

    
    
});


function delstud(id){
    BootstrapDialog.show({
        title:"Confirm Delete",
        message:"Are you sure you want to delete this student's info. from the system",
        buttons:[{label:"DELETE",cssClass:"btn-bad waves-effect waves-button",action:function(d){
            d.close();
            $.get("delstud.php?id="+id,function(data){
            }).done(function(){
                if($('#cbopage-list').index($('#cbopage-list'))> -1) {
                    $("#cbopage-list").change();
                    Snarl.addNotification({
                        title:"DELETE",
                        text:"Student Deleted successfully",
                        icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle-o'></i>",
                        timeout:3000
                    });
                    $(".snarl-notification").addClass('snarl-success');
                }else{
                    getstud(1);
                    Snarl.addNotification({
                        title:"DELETE",
                        text:"Student Deleted successfully",
                        icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle-o'></i>",
                        timeout:3000
                    });
                    $(".snarl-notification").addClass('snarl-success');

                }


            });






        }}]

    });

    $(".modal-backdrop").addClass("backdrop-light");


}
