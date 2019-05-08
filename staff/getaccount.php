<?php
include_once("./objts/config.php");
$cf= new config();
$cf->connect();
session_start();
if(isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $mydet = mysqli_fetch_object(mysqli_query($cf->con, "select * from staff where id = '$id'"));
    $ranklist = ["Senior Sup't", "Prin. Sup't", "Assist. Dir ii", "Assist. Dir I", "Dep. Dir.", "Dir. II", "Dir. I"];
    $tday = date("Y-M-d");
    $tyear = substr($tday, 0, 4);
    $svyear = is_null($mydet->assdate) ? $tyear : substr($mydet->assdate, 0, 4);
    $apyear = is_null($mydet->appdate) ? $tyear : substr($mydet->appdate, 0, 4);
    $dbyear = is_null($mydet->dob) ? $tyear : substr($mydet->dob, 0, 4);
    $dbyear += 60;
    $dur = $tyear - $apyear;
    $years = $tyear - $svyear;
    $rank = is_numeric($mydet->rank) ? $mydet->rank : 0;
    ?>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 col-lg-offset-2 col-md-offset-2">
            <div class="panel panel-default">
                <div class="page-header">
                    <div class="row">
                        <div class="col-gl-2 col-md-2 col-sm-4 col-xs-4">
                            <button class="btn btn-good waves-effect waves-button"
                                    onclick="editaccount(<?= $mydet->id ?>)">Change Details
                            </button>
                        </div>
                        <div class="col-gl-2 col-md-2 col-sm-4 col-xs-4">
                            <button class="btn btn-good waves-effect waves-button"
                                    onclick="chngpass(<?= $mydet->id ?>);">Change Password
                            </button>
                        </div>
                        <div class="col-gl-2 col-md-2 col-sm-4 col-xs-4">
                            <button class="btn btn-good waves-effect waves-button"
                                    onclick="printstf(<?= $mydet->id ?>)">My Profile
                            </button>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" id="dp-cont">
                            <img style=" margin-left:10px;width: 150px; height:150px;"
                                 class="img-responsive img-circle waves-effect waves-float"
                                 src="<?= $mydet->photo ? $mydet->photo : "../admin/img/photo.jpg" ?>" alt="">

                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6" style="vertical-align: bottom;">
                            <button onclick="$('#dp-cont').click();" style="vertical-align: bottom;"
                                    class="btn btn-good waves-effect waves-button">Change Photo
                            </button>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-gl-2 col-md-2 col-sm-12 col-xs-12">
                            <button class="btn btn-good waves-effect waves-button">Name:</button>
                        </div>
                        <div class="col-gl-10 col-md-10 col-sm-12 col-xs-12"
                             style="padding: 10px; border-bottom: 1px solid #DDDDDD;">
                      <?=$mydet->fname." ".$mydet->lname?>
                  </div>
                    </div>

                    <div class="row">
                        <div class="col-gl-2 col-md-2 col-sm-2 col-xs-12">
                            <button class="btn btn-good waves-effect waves-button">Staff ID:</button>
                        </div>
                        <div class="col-gl-10 col-md-10 col-sm-10 col-xs-12"
                             style="padding: 10px; border-bottom: 1px solid #DDDDDD;">
                      <?=$mydet->stfid?>
                  </div>
                    </div>

                    <div class="row">
                        <div class="col-gl-2 col-md-2 col-sm-2 col-xs-12">
                            <button class="btn btn-good waves-effect waves-button">Contact Number:</button>
                        </div>
                        <div class="col-gl-10 col-md-10 col-sm-10 col-xs-12"
                             style="padding: 10px; border-bottom: 1px solid #DDDDDD;">
                      <?=$mydet->contact?>
                  </div>
                    </div>

                    <div class="row">
                        <div class="col-gl-2 col-md-2 col-sm-2 col-xs-12">
                            <button class="btn btn-good waves-effect waves-button">Date Of Birth:</button>
                        </div>
                        <div class="col-gl-10 col-md-10 col-sm-10 col-xs-12"
                             style="padding: 10px; border-bottom: 1px solid #DDDDDD;">
                      <?=$mydet->dob?>
                  </div>
                    </div>

                    <div class="row">
                        <div class="col-gl-2 col-md-2 col-sm-2 col-xs-12">
                            <button class="btn btn-good waves-effect waves-button">Registered No:</button>
                        </div>
                        <div class="col-gl-10 col-md-10 col-sm-10 col-xs-12"
                             style="padding: 10px; border-bottom: 1px solid #DDDDDD;">
                      <?=$mydet->regno?>
                  </div>
                    </div>


                    <div class="row">
                        <div class="col-gl-2 col-md-2 col-sm-2 col-xs-12">
                            <button class="btn btn-good waves-effect waves-button">SSNIT No:</button>
                        </div>
                        <div class="col-gl-10 col-md-10 col-sm-10 col-xs-12"
                             style="padding: 10px; border-bottom: 1px solid #DDDDDD;">
                      <?=$mydet->snnid?>
                  </div>
                    </div>


                    <div class="row">
                        <div class="col-gl-2 col-md-2 col-sm-2 col-xs-12">
                            <button class="btn btn-good waves-effect waves-button">Prof. Qualification:</button>
                        </div>
                        <div class="col-gl-10 col-md-10 col-sm-10 col-xs-12"
                             style="padding: 10px; border-bottom: 1px solid #DDDDDD;">
                      <?=$mydet->pqual?>
                  </div>
                    </div>

                    <div class="row">
                        <div class="col-gl-2 col-md-2 col-sm-2 col-xs-12">
                            <button class="btn btn-good waves-effect waves-button">Acd. Qualification:</button>
                        </div>
                        <div class="col-gl-10 col-md-10 col-sm-10 col-xs-12"
                             style="padding: 10px; border-bottom: 1px solid #DDDDDD;">
                      <?=$mydet->aqual?>
                  </div>
                    </div>

                    <div class="row">
                        <div class="col-gl-2 col-md-2 col-sm-2 col-xs-12">
                            <button class="btn btn-good waves-effect waves-button">Rank:</button>
                        </div>
                        <div class="col-gl-10 col-md-10 col-sm-10 col-xs-12"
                             style="padding: 10px; border-bottom: 1px solid #DDDDDD;">
                      <?=$ranklist[$rank]?>
                  </div>
                    </div>

                    <div class="row">
                        <div class="col-gl-2 col-md-2 col-sm-2 col-xs-12">
                            <button class="btn btn-good waves-effect waves-button">1<sup>st</sup> Appmnt. Date:</button>
                        </div>
                        <div class="col-gl-10 col-md-10 col-sm-10 col-xs-12"
                             style="padding: 10px; border-bottom: 1px solid #DDDDDD;">
                      <?=$mydet->appdate?>
                  </div>
                    </div>

                    <div class="row">
                        <div class="col-gl-2 col-md-2 col-sm-2 col-xs-12">
                            <button class="btn btn-good waves-effect waves-button">Years At Post:</button>
                        </div>
                        <div class="col-gl-10 col-md-10 col-sm-10 col-xs-12"
                             style="padding: 10px; border-bottom: 1px solid #DDDDDD;">
                            Years
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-gl-2 col-md-2 col-sm-2 col-xs-12">
                            <button class="btn btn-good waves-effect waves-button">Duration in service:</button>
                        </div>
                        <div class="col-gl-10 col-md-10 col-sm-10 col-xs-12"
                             style="padding: 10px; border-bottom: 1px solid #DDDDDD;">
                            Years
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-gl-2 col-md-2 col-sm-2 col-xs-12">
                            <button class="btn btn-good waves-effect waves-button">Retirement Year:</button>
                        </div>
                        <div class="col-gl-10 col-md-10 col-sm-10 col-xs-12"
                             style="padding: 10px; border-bottom: 1px solid #DDDDDD;">
                      <?=$dbyear?>
                  </div>
                    </div>

                    <div class="row">
                        <div class="col-gl-2 col-md-2 col-sm-2 col-xs-12">
                            <button class="btn btn-good waves-effect waves-button">Associate Bank:</button>
                        </div>
                        <div class="col-gl-10 col-md-10 col-sm-10 col-xs-12"
                             style="padding: 10px; border-bottom: 1px solid #DDDDDD;">
                      <?=$mydet->bank?>
                  </div>
                    </div>
                    <div class="row">
                        <div class="col-gl-2 col-md-2 col-sm-2 col-xs-12">
                            <button class="btn btn-good waves-effect waves-button">Bank Acc. No.:</button>
                        </div>
                        <div class="col-gl-10 col-md-10 col-sm-10 col-xs-12"
                             style="padding: 10px; border-bottom: 1px solid #DDDDDD;">
                      <?=$mydet->accno?>
                  </div>
                    </div>

                    <div class="row">
                        <div class="col-gl-2 col-md-2 col-sm-2 col-xs-12">
                            <button class="btn btn-good waves-effect waves-button">Login Name:</button>
                        </div>
                        <div class="col-gl-10 col-md-10 col-sm-10 col-xs-12"
                             style="padding: 10px; border-bottom: 1px solid #DDDDDD;">
                      <?=$mydet->uname?>
                  </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php
}else{
    ?>
    <script>

        window.location = './';
    </script>

    <?php
}
?>
<script>

    function printstf(id){
        window.open("staffprf.php?id=" + id, "Staff Profile", "outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");
    }
    function editaccount(id){
        fullProg();
        $.get("get_up_inputs.php?id="+id,null,function(data){
        }).done(function(data){
            remove_fullprog();
            BootstrapDialog.show({
                title:"Update Your Particulars.",
                message:data,
                buttons:[{label:"UPDATE",cssClass:"btn-good waves-effect waves-button",action:function(d){
                    if(!$("#upfname,#uplname,#upcontact").val()){
                        return false;
                    }
                    d.close();
                    var progress = Snarl.addNotification({
                        title:"Please Wait...",
                        text:"Updating Staff Info.",
                        icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-circle-o-notch fa-spin'></i>",
                        timeout:null
                    });
                    $(".snarl-notification").addClass('snarl-info');
                    $.get("updatestaff.php?id="+id+"&fname="+$("#upfname").val()+"&lname="+$("#uplname").val()+"&gender="+$("#upgender").val()+"&contact="+$("#upcontact").val()+"&rank="+$("#uprank").val()+"&stfid="+$("#upstfid").val()+"&dob="+$("#updob").val()+"&regno="+$("#upregno").val()+"&aqual="+$("#upaqual").val()+"&pqual="+$("#uppqual").val()+"&appdate="+$("#upappdate").val()+"&assdate="+$("#upassdate").val()+"&bank="+$("#upbank").val()+"&accno="+$("#upaccno").val()+"&ssnid="+$('#upssnid').val(),function(data){
                    }).done(function(){
                        Snarl.removeNotification(progress);
                        Snarl.addNotification({
                            title:"UPDATED",
                            text:"Staff Info. Updated successfully",
                            icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle-o'></i>",
                            timeout:5000
                        });
                        $(".snarl-notification").addClass('snarl-success');
                        getMyaccount();
                    });
                }},{label:"CANCEL",cssClass:"btn-bad waves-effect waves-button",action:function(d){d.close()}}],
                closable:false,
                size:"size-wide"
            });
        }).error(function(){
            show_error();
        });

    }

    function chngpass(id){
        var temp ="<input id='myid' type='hidden' value='"+id+"'>";
        temp+="<div class='row'>";
        temp+="<div class='col-lg-12 ol-md-12 col-sm-12 col-xs-12'><label class='control-label'>Password</label><input id='newpass' type='password' class='form-control' placeholder='Create New password'></div>";
        temp+="<div class='col-lg-12 ol-md-12 col-sm-12 col-xs-12'><label class='control-label'>Confirm Password</label><input id='cnewpass' type='password' class='form-control' placeholder='Confirm New password'></div>";
        temp+="</div>";
        BootstrapDialog.show({
        title:"Reset your password",
        message:temp,
        buttons:[{label:"Chnage",cssClass:"btn-good waves-effect waves-button",action:function(d){
        var id = $("#myid").val();
        var newpass = $("#newpass").val();
        var cnewpass = $("#cnewpass").val();
            if(newpass.length<1){
                $("#newpass").focus();

            }else if(cnewpass.length<1){
                $("#cnewpass").focus();
            }else if(newpass !=cnewpass){
                Snarl.addNotification({
                    title: "ERROR",
                    text: "The passwords you entered are not the same, please check and try again",
                    icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                    timeout: 8000
                });
                $(".snarl-notification").addClass('snarl-error');
            }else{

                $.get("do_reset.php?id="+id+"&new_pass="+newpass,function(){

                    Snarl.addNotification({
                        title: "SUCCESS",
                        text: "Your password was changed successfully, please remember to use the new password next time",
                        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle'></i>",
                        timeout: 8000
                    });

                    $(".snarl-notification").addClass('snarl-success');
                    d.close();

                });
            }
        }}]

});
    }




   var drp = $("div#dp-cont").dropzone(
        { url: "./dropdp.php",
            acceptedFiles: "image/*",
            addRemoveLinks:true,
            dictDefaultMessage:"",
            resizeWidth:"180",
            resizeHeight:"200",
            resizeMethod:"crop",
            maxFiles:1,
            complete:function(){

                getMyaccount();
            }

        });
</script>