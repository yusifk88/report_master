<?php

include_once './objts/config.php';
$cnfg = new config();
$cnfg ->connect();
$id = $_GET['id'];
$sfid = $_GET['sfid'];
mysqli_query("delete from subas where id = '$id'");
 $data = mysqli_query("select subjects.subjdesc,classes.classname,subas.id from subjects,classes,subas  where subas.stfid ='$sfid' and subas.clid=classes.id and subjects.id=subas.subid");
                 
           while ($row = mysql_fetch_assoc($data)) {
                
                ?>
                
            <tr>  
            
                <td>
                    <?php
                        echo $row['id'];
                   ?>
                </td>
                <td>
                    <?php
                        echo $row['subjdesc'];
                    ?>
                </td>
                <td>
                    <?php
                        echo $row['classname'];
                    ?>
                </td>
                
                  <td><span class="glyphicon glyphicon-remove rmsub" title="Unasign this subject" data-del="delsubj.php" data-sfid="<?php echo $id; ?>" data-id="<?php echo $row['id']; ?>" style="color: #F00; cursor: pointer;"></span></td>
                
            </tr>  
                <?php
                
                
            }
            
            ?>
         <script>
         
         $(".rmsub").click(function(){
        
        var id = $(this).attr("data-id");
         var sfid = $(this).attr("data-sfid");
        $(".dlg-ex").html("Are you sure you want to unasign this subject ?");
        $(".dlg-ex").dialog({
            modal:true,
            buttons:{
                Yes:function(){
                    
                     $(this).dialog("close");
                     $.get("rmsub.php?id="+id+"&sfid="+sfid,null,function(data){
                         $("#sub-body").html(data);
                     }); 
                },
                No:function(){
                    
                    
                    $(this).dialog("close");
                }
                
                
            }
            
        });
      
        
        
        
        
    });
    $("span").tooltip();
         
         </script>