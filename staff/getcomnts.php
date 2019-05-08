<?php
include_once 'objts/config.php';
include_once './objts/utitlity.php';
$ut = new utitlity();
$id = $_GET['id'];
$cf = new config();
$cf->connect();
$stud = mysqli_query($cf->con,"select fname,lname,oname,photo from stuinfo where id= '$id'");
$stuinfo = mysqli_fetch_object($stud);
?>

<div class="row">
    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
        <center>
        <img class="img-thumbnail" src="../admin/<?=$stuinfo->photo?>" alt="<?=$stuinfo->fname?>" width="150" height="180" />
        <br>
           <span class="text-muted"><?=$stuinfo->fname?> <?=$stuinfo->lname?> <?=$stuinfo->oname?></span>

        </center>


    </div>
    <div class="col-lg-10 col-lg-12 col-sm-12 col-xs-12">


<div class="row" style="border-bottom: 1px solid #cccccc;">

    <form id="cmtform" action="savecmnt.php">
        <input id="id"  type="hidden" name="id" value="<?=$id;?>">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
   <label class="control-label">Academic Year</label>

            <?php
            $ayears = mysqli_query($cf->con,"select distinct(ayear) from stuinfo where  id = '$id'");
            $yea = mysqli_fetch_object($ayears)
                ?>
                <input name="ayear" type="text" value="<?=$yea->ayear;?>" readonly class="form-control">
                <?php

            ?>

    </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <label class="control-label">Term</label>
            <select class="form-control" name="term">
                <option value="1">1st Term</option>
                <option value="2">2nd Term</option>
                <option value="3">3rd Term</option>
            </select>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <label class="control-label">Date</label>
            <input class="form-control" type="text" name="dentry" id="dentry" required="required" placeholder="select date" readonly style="cursor: alias" />
        </div>
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
            <label class="control-label">Comment</label>
            <textarea  id="cmnt" class="form-control" rows="3" name="cmnt" required="required"></textarea>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <br>
            <br>
            <br>
            <button id="savecmt" type="submit" class="btn btn-good waves-button waves-effect"><i class="fa fa-save"></i> Save</button>

        </div>
    </form>
</div>
</div>
    </div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="wel" style="background-color: #FFFFFF;">
            <?php
        $cmts = mysqli_query($cf->con,"select * from ginfo where stid = '$id' order by id DESC ");
            ?>

          <div class="table-responsive" id="cmnttbl">
              <table class="table table-stripped table-hover">
                  <thead>
                  <tr>
                  <th>S/N</th>
                  <th>Comment</th>
                  <th>Academic Year</th>
                  <th>Term</th>
                  <th>Date</th>
                  <th style="text-align: center;">Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i =1;
                        while($row = mysqli_fetch_object($cmts)){


                            ?>
                         <tr>
                             <td><?=$i;?></td>
                             <td><?=$row->coment;?></td>
                             <td><?=$row->ayear;?></td>
                             <td><?= $ut->addsufix($row->term);?> Term</td>
                             <td><?=$row->dentry;?></td>
                             <td style="text-align: center;"><i onclick="delcomm(<?=$row->id;?>);" title="Delete this Comment" data-toggle ="tooltip" style="color: red; cursor: pointer;" class="fa fa-remove waves-circle waves-effect"></i> </td>




                         </tr>


                    <?php
                            $i++;
                        };
                    ?>

                  </tbody>

              </table>
          </div>

        </div>
    </div>
</div>

<script>

    function cmntlist(id){
    $("#cmnttbl").fadeOut(100);
        $.get("cmntlist.php?id="+id,function(data){
            $("#cmnttbl").html(data);

        }).done(function(){
            $("#cmnttbl").fadeIn(200);
finish();
        });
    }


    function delcomm(id){


        BootstrapDialog.show({
            title:"Confirm Delete",
            message:"Do you want to delete this comment? ",
            buttons:[{label:"DELETE",cssClass:"btn-good waves-effect waves-button",action:function(d){
                d.close();
                $.get("delcmnt.php?id="+id,function(){
                    cmntlist($("#id").val());
                });
            }}]
        });


    }




    $(document).ready(function(){
        $("i").tooltip();



        $("#dentry").datepicker({
            changeMonth:true,
            changeYear:true,
            showAnim:"slideDown",
            dateFormat:"yy-m-d",
            currentDate:true
        });
        $("#cmtform").submit(function(){

            var data = $("#cmtform :input").serializeArray();
         if(!$("#dentry").val()){
             $("#dentry").focus();
         }else if(!$("#cmnt").val()){
             $("#cmnt").focus();
         }else{
             showprog();
             $.post($("#cmtform").attr('action'),data,function(){
             }).done(function(){
                 cmntlist($("#id").val());
             });
         }
            return false;

        });
    });
</script>