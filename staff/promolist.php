<?php
include_once './objts/config.php';
include_once './objts/school.php';
$cf = new config();
$cf->connect();
$cls = $_GET['cls'];
$ayear = $_GET['ayear'];
$form = $_GET['form'];


$recs = mysqli_query("select id,fname,lname,oname from stuinfo where ayear = '$ayear' and class='$cls' and form = '$form' order by fname ASC");
    $sch = new school();
    if(mysqli_num_rows($recs)>0){
?>
      <div class="panel panel-info">
    <div class="panel-body">
   

<div class="table-responsive">    
    <table class="table table-condensed table-hover table-striped table-bordered" id="assess-table">
    <thead>
        <tr style="background-color: deepskyblue; color:#fff;">
            
            <th style="border: 1px solid deepskyblue; text-align: center;">
    <center>
                Select All <input type="checkbox" id="checkall" class="checkbox" />    
    </center>
            </th>            
            <th style="border: 1px solid deepskyblue; text-align: center;">
                S/N                
            </th>            
            <th style="border: 1px solid deepskyblue;">
                Student's Name                
            </th>
            
            <th style="border: 1px solid deepskyblue; text-align: center;">
               Term 1 Fails                
            </th>
            
            <th style="border: 1px solid deepskyblue; text-align: center;">
                Term 2 Fails                
            </th>
            
            <th style="border: 1px solid deepskyblue; text-align: center;">
                Term 3 Fails                
            </th>
            
           
            
          
        </tr>
    </thead>
    <tbody>
    
    
    <?php
        $a=1;
        while($recrow = mysql_fetch_assoc($recs)){
            $id = $recrow['id'];
            
            $fails1 = mysql_result(mysqli_query("select count(*) from records where stid = '$id' and acyear = '$ayear' and term = '1' and grd = 'F9'"),0);
            $fails2 = mysql_result(mysqli_query("select count(*) from records where stid = '$id' and acyear = '$ayear' and term = '2' and grd = 'F9'"),0);
            $fails3 = mysql_result(mysqli_query("select count(*) from records where stid = '$id' and acyear = '$ayear' and term = '3' and grd = 'F9'"),0);
            
            
            ?>
        <tr>
            <td style="text-align: center;"><input type="checkbox" name="selectchk[]" id="selectchk" value="<?=$id;?>" /></td>
            <td style="text-align: center;"><?=$a;?></td>
            <td><?= $recrow['fname']." ".$recrow['lname']." ".$recrow['oname'];?></td>
            
            
            
            <td style="text-align: center;"><?=$fails1;?></td>
            <td style="text-align: center;"><?=$fails2;?></td>
            <td style="text-align: center;"><?=$fails3;?></td>
          
            </tr>
            <?php
            $a++;
        }
        ?>
    </tbody>
    </table>
</div>

    </div></div>
                   
          
          


    <?php }else{
echo '<center><h2 class="text-muted"><span class="glyphicon glyphicon-warning-sign"></span>No record exist for the filter</h2></center>';
    }?>

     <script type="text/javascript">
$(document).ready(function(){

    
    //--------------------------------------
      $("#checkall").change(function(){
       
        var status = $("#checkall").prop("checked");
     var len = $("input#selectchk").length;
   
     for(var i = 0;i< len;i++){
         
       $("input#selectchk")[i].checked = status;
     } 
       
   });
   
});
</script>