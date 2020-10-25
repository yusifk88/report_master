<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\config;
$cf = new config();
$cf->connect();
$id = $_GET["stid"];
$ayear = mysqli_query($cf->con, "select distinct(acyear) from records where stid = '$id'");
?>


<form>
    <div class="row" style="padding-left: 5px !important; padding-right: 5px !important;">


        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <label class="control-label" for="cls">Academic Year</label>
            <select id="ayer5" class="we-select form-control">
                <?php
                while ($row2 = mysqli_fetch_object($ayear)) {

                    ?>
                    <option><?= $row2->acyear; ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <label class="control-label" for="term">Term</label>
            <select id="term" class="we-select form-control">
                <option>1</option>
                <option>2</option>
                <option>3</option>
            </select>
        </div>
    </div>
    </div>
</form>


<script type="text/javascript">
    /*
       function getcls_list(){
         var ayear = $("#ayer5").val();
         var stname = $("#stname").val();
         var term = $("#term").val();
         $.getJSON("cnt_rep.php?stname="+$("#stname").val()+"&ayear="+$("#ayer5").val()+"&term="+$("#term").val()+"&cls="+$("#stcls").val(),function(dataobj){
        if (dataobj.count_val === 0){
            $(".dlg-ex").html("<span style='color:red;'>No records found for this student for the selected academic year and term</span>");
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

             window.open("rep_one.php?ayear="+ayear+"&cls="+cls+"&stname="+stname+"&term="+term,"Class List","outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");

        }

        });

       } */

    // $(document).ready(function(){

    //---------------------------------------------------------------------------------------------

    /*  $("#stcls").change(function(){

         $.get("getstnames.php?cls="+$("#stcls").val()+"&acyear="+$("#ayer5").val(),function(data){


             $("#stname").text("");
              $("#stname").html(data);
         });
         $("#ayer5").change(function(){

             $("#stcls").change();
         }); */

    //        $.getJSON("cnt_cls.php?clas="+$("#cls").val()+"&ayear="+$("#ayer").val(),function(dataobj){
    //
    //            $("#cntcont").html("There are "+ dataobj.count_val +" student(s) in this class");
    //        });
    // });


    // });
</script>


