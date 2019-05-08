<?php
include_once './objts/config.php';
$cf = new config();
$cf->connect();
$stid = $_GET['stid'];
$cls = $_GET['cls'];
$ayear = $_GET['ayear'];
$term = $_GET['term'];
$subjt = $_GET['subjt'];
$per_page = 1;
$page = ( isset($_GET['page'])) ? (int) $_GET['page']:1;
$start = ($page-1) * $per_page;
$cnsql =mysqli_query($cf->con,"select id,fname,lname,oname,photo from stuinfo where class='$cls' and id like '%$stid%' and id  not in (select stid from records  where (ta1 is not null or ta1=0) and (ta2 is not null or ta2=0) and (ta3 is not null or ta3=0) and (ta4 is not null or ta4 =0 ) and acyear = '$ayear' and term = '$term' and subjt = '$subjt' and cls = '$cls') and id not in(SELECT stid from withdraw)");
$stinputs = mysqli_query($cf->con,"select id,fname,lname,oname,photo from stuinfo where class='$cls' and id like '%$stid%' and id not in (select stid from records where (ta1 is not null or ta1=0) and (ta2 is not null or ta2=0) and (ta3 is not null or ta3=0) and (ta4 is not null or ta4 =0 ) and acyear = '$ayear' and term = '$term' and subjt = '$subjt' and cls = '$cls') and id not in(SELECT stid from withdraw) order by fname ASC, lname ASC");
$recount = mysqli_num_rows($cnsql);
$pages = ceil($recount/$per_page);
$stnames = mysqli_query($cf->con,"select id,fname,lname,oname,photo from stuinfo where class='$cls' and id not in (select stid from records where (ta1 is not null or ta1=0) and (ta2 is not null or ta2=0) and (ta3 is not null or ta3=0) and (ta4 is not null or ta4 =0 ) and acyear = '$ayear' and term = '$term' and subjt = '$subjt' and cls = '$cls') and id not in(SELECT stid from withdraw) order by fname ASC");

if(mysqli_num_rows($stinputs)>0){
?>
    <div style="height: 800px !important; overflow-x: hidden !important; overflow-y: auto;">
 <form id="batchtaskform">
     <div class="row">
         <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 col-md-offset-2 col-lg-offset-2">
             <div class="alert alert-info">
                 <ul>
                     <li>
                         Please leave the input boxes empty if you want to skip a student
                     </li>

                     <li>
                        The system will skip students with empty records
                     </li>

                 </ul>


             </div>
         </div>

     </div>
<?php
    while ($row = mysqli_fetch_assoc($stinputs)) { ?>

                            <input name="stud[]" type="hidden" value="<?=$row['id']?>" id="stid" />

                            <div class="row">

                                <div class="col-lg-2 col-md-2 co-sm-4 col-xs-4">
                                    <img src="../admin/<?= $row['photo'];?>" width="180" height="200" class="img-thumbnail" />
                                </div>

                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-8">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <h5><?= $row['fname']." ".$row['lname']." ".$row['oname']; ?></h5>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2 col-md-2">
                                            <label class="control-label">Task One</label>
                                            <input required="required" name="task1[]" autofocus style="text-align: center" id="ta1" class="form-control taskinput" type="number" value="0"  />
                                        </div>
                                        <div class="col-lg-2 col-md-2">
                                            <label class="control-label">Task Two</label>
                                            <input required="required" name="task2[]" style="text-align: center" id="ta2" class="form-control taskinput" type="number" value="0"/>
                                        </div>
                                        <div class="col-lg-2 col-md-2">
                                            <label class="control-label">Task Three</label>
                                            <input required="required" name="task3[]" style="text-align: center" id="ta3" class="form-control taskinput" type="number" value="0"/>
                                        </div>
                                        <div class="col-lg-2 col-md-2">
                                            <label class="control-label">Task Four</label>
                                            <input value="0" required="required" name="task4[]" style="text-align: center" id="ta4" class="form-control taskinput" type="number" />
                                        </div>

                                    </div>

                                </div>
                            </div>






        <?php
    }
?>


    </form>
        </div>
    <?php

}else{
    ?>
    <h2 class="text-muted"><span class="glyphicon glyphicon-warning-sign"></span>Sorry, no records found, this could be because class task records on all students in this class were recorded or no student exist in the selected class </h2>
    <?php

}

?>
<script>


    function savtask(){

            $("#batchtaskform").submit();
    }

    $(document).ready(function(){
        $("#batchtaskform").submit(function(){

            var progress = Snarl.addNotification({
                title:"Please Wait...",
                text:"Saving class task record",
                icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-circle-o-notch fa-spin'></i>",
                timeout:null
            });
            $(".snarl-notification").addClass('snarl-info');
            var cls = $("#assess_class").val();
            var term = $("#assess-term").val();
            var ayear = $("#assess-ayear").val();
            var sub = $("#assess-subjt").val();
            var data = $("#batchtaskform :input").serializeArray();
            $
                .post("savebatchtask.php?cls="+cls+"&term="+term+"&ayear="+ayear+"&sub="+sub,data)
                .done(function () {
                    $("#assess-subjt").change();
                    cloasedlgs();
                    Snarl.removeNotification(progress);
                    Snarl.addNotification({
                        title:"Save",
                        text:"Record Saved Successfully",
                        icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle'></i>",
                        timeout:5000
                    });
                    $(".snarl-notification").addClass('snarl-success');

                })

                .error(function(){

                    Snarl.removeNotification(progress);
                    Snarl.addNotification({
                        title:"Error",
                        text:"Something went wrong, please check your connection and try again",
                        icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                        timeout:5000
                    });
                    $(".snarl-notification").addClass('snarl-error');


                });
            return false;
        });


        $("#ta1,#ta2,#ta3,#ta4").focusin(function(){
            if( Number($(this).val())<=0){
                $(this).val("");
            }

        });
        $("#ta1,#ta2,#ta3,#ta4").focusout(function(){
            if( Number($(this).val())<=0){
                $(this).val(0);
            }

        });

        $("#ta1,#ta2,#ta3,#ta4").keypress(function(e) {
            if (e.which === 13) {
                savtask();
            }
        });
    });

</script>
    