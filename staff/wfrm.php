<?php
include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$id= $_GET{"id"};
$stinfo = mysqli_query($cf->con,"select fname,lname,oname,photo,ayear from stuinfo where id = '$id'");
$stud = mysqli_fetch_object($stinfo);
?>
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <img src="../admin/<?=$stud->photo?>" alt="<?=$stud->fname?>" class="img-thumbnail img-responsive" width="150" height="180"/> <br>
        <span class="text-muted text-uppercase" style="font-weight: bold"><?=$stud->fname." ".$stud->lname." ".$stud->oname?></span>
    </div>

    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
        <form id="wfrm">
        <input name="wstid" type="hidden" value="<?=$id?>" id="wstid" />
        <div class="row">
            <div class="col-lg-4 col-md-4 col-xs-12">
                <label class="control-label">Academic Year</label>
                 <input name="wayear" type="text" readonly class="form-control" value="<?=$stud->ayear?>" />
                </div>
            <div class="col-lg-4 col-md-4 col-xs-12">
                <label class="control-label">Term</label>
                <select class="form-control" name="wterm">
                    <option value="1">1st Term</option>
                    <option value="2">2nd Term</option>
                    <option value="3">3rd Term</option>
                </select>
            </div>
            <div class="col-lg-4 col-md-4 col-xs-12">
                <label class="control-label">Date</label>
                <input name="wdate" id="wdate" type="text" readonly class="form-control" />
            </div>
            </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12">
                <label  class="control-label text-muted">Reason (Why you are withdrawing this student)</label>
                <textarea name="wresn" class="form-control" id="wresn" rows="2"></textarea>
            </div>
        </div>
        </form>
    </div>

</div>
<script>
    $(document).ready(function(){
       $("#wdate").datepicker({
           changeMonth:true,
           changeYear:true,
           showAnim:"slideDown",
           dateFormat:"yy-m-d",
           currentDate:true
       });


        $("#wfrm").submit(function(){
            var data = $("form#wfrm :input").serializeArray();
            $.post("wsave.php",data,function(){
            }).done(function(){
                getstud(1);
                Snarl.addNotification({
                    title:"WITHDRAW",
                    text:"Student Withdrawn successfully",
                    icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle-o'></i>",
                    timeout:3000
                });
                $(".snarl-notification").addClass('snarl-success');
            });
            return false;
        });
});
</script>