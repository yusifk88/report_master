<?php

include_once './objts/config.php';
include_once './objts/rclass.php';
$clss = new Rclass();
$d=$clss->getclasses();
?>
<div class="alert alert-info"><strong>List of Classes</strong></div>
<div class="table-responsive">
    
    <table class="table table-condensed table-striped table-hover">
        
        <thead>
            <tr>
                <th>ID</th>
                <th>Class Name</th>
                <th>Department</th>
                <th colspan="2">Action</th>
            </tr>
            
            
        </thead>
        
        <tbody>
            <?php
            while ($row = mysql_fetch_assoc($d)) {
                ?>
            <tr>
        <td><?php echo $row['id']; ?>  </td>
        <td><?php echo $row['classname']; ?>  </td>
        <td><?php echo $row['depname']; ?>  </td>
              
        <td><span title="Edit this class" data-get="<?php echo $row['classname'];?>" data-dpid="<?php echo $row['dpid'];?>"style="color: deepskyblue; cursor: pointer;" class="glyphicon glyphicon-edit editicon1" data-id="<?php echo $row['id'];?>"> </span></td>
        <td><span title="Delete this class" style="color: red; cursor: pointer;" class="glyphicon glyphicon-trash delicon" data-id="<?php echo $row['id'];?>"> </span></td>
            </tr>
                <?php
                
            }
            
            ?>
            
        </tbody>
        
    </table>
    
</div>
<script>
    
    $(".editicon1").click(function(){
       
       var me =$(this);
       $.get("class_updat_input.php?id="+me.attr("data-id")+"&dpid="+me.attr("data-dpid")+"&classname="+me.attr("data-get"),null,function(data){
           $(".dlg-ex").html(data);
           
           
       }).done(function(){
           $(".dlg-ex").dialog({
               modal:true,
                 show:'drop',
                hide: 'fade',
               buttons:{
                   Update:function(){
                       
                       if(!$("#classname1").val()){
                           $("#classname1").focus();
                           return false;
                           
                           
                       }
                       
                       $.get("updateclass.php?id="+me.attr("data-id")+"&classname="+$("#classname1").val()+"&dpid="+$("#dept1").val(),null,function(data){
                          
                          
                          $(".dlg-ex").html(data);
                                                    
                          
                       }).done(function(data){
                           
                           $(".dlg-ex").dialog({
                               modal:true,
                                 show:'drop',
                                 hide: 'fade',
                               buttons:{
                                   Ok:function(){
                                       $(this).dialog("close");
                                       getclass();
                                       
                                       
                                   }
                                   
                               }
                               
                               
                           });
                           
                       });
                       
                       
                   },Cancel:function(){
                       $(this).dialog("close");
                   }
                   
                   
                   
               }
               
               
               
           });
           
           
           
       });
        
        
    });
    //--------------------------------------------------------------------------------------------------------------------------
    $(".delicon").click(function(){
        var me = $(this);
        $(".dlg-ex").html("Are you sure you want to delete this class");
      $(".dlg-ex").dialog({
          modal:true,
            show:'bounce',
            hide: 'fade',
          buttons:{
              Yes:function(){
                $.get("delclass.php?id="+me.attr("data-id"),null,function(data){
                                       
                    $(".dlg-ex").html(data);
                    
                    
                }).done(function(data){
                    $(".dlg-ex").dialog({
                        modal:true,
                        buttons:{
                            Ok:function(){
                                $(this).dialog("close");
                                getclass();
                                
                            }
                            
                            
                        }
                        
                        
                        
                    });
                });  
                  
              },No:function(){
                  
                  $(this).dialog("close");
                  
                  
              }
              
              
              
          }
          
          
          
          
      });  
        
        
    });
    //==========================================================================================================================
$("span").tooltip();
</script>

<?php

while ($row = mysql_fetch_assoc($d)) {
    
    
    
    
    
    
    
    
}
