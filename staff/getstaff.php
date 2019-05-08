<?php
include_once './objts/config.php';
include_once './objts/staff.php';

$stf = new Staff();
$d = $stf->getstaff();
if(mysqli_num_rows($d)>0){
while ($row = mysql_fetch_assoc($d)) {
    ?>
<div class="row" style="margin: 0 !important;">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="panel panel-info" style="margin: 0 !important;">
            <div class="panel-body">
                <table class="table table-condensed table-hover table-striped">
                    <tr>
                        <th>Full Name:</th>
                        <td><?php echo $row['fname']." ".$row['lname']; ?></td>                        
                    </tr>                    
                    <tr>
                        <th>Gender:</th>
                        <td><?php echo $row['gender']; ?></td>                                             
                    </tr>                    
                    <tr>
                        <th>Contact:</th>
                        <td><?php echo $row['contact']; ?></td>                  
                        
                    </tr>                    
                </table> 
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 sub-info <?php echo "sub-inf-".$row['id']; ?>" style="display: none;">
                <?php
                $id = $row['id'];
               $data = mysqli_query("select subjects.subjdesc,classes.classname,subas.id from subjects,classes,subas  where subas.stfid ='$id' and subas.clid=classes.id and subjects.id=subas.subid");
                
                
                ?>
                   <div class="alert alert-info">Subject/Classes Taught</div>
                    <div class="table-responsive">
        <table class="table table-condensed table-hover table-striped">
        <thead>
            <tr>
                <th>ID</th>    
                <th>Subject</th>
                <th>Class</th>
                <th>Actions</th>
            </tr>
            
        </thead>  
        
        
        <tbody id="sub-body">
            <?php
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
            
             </tbody>
        
        </table></div>
                    
                    
                    
                </div>
                
            </div>
            
            <div class="panel-footer">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <span title="Edit this staff's info" data-id="<?php echo $id;?>" class="glyphicon glyphicon-edit editicon4" style="color: deepskyblue; cursor: pointer;"></span>
                        <span class="glyphicon glyphicon-book asub" data-id="<?php echo $id;?>" title="Assign subjects to this staff" style="color: deepskyblue; cursor: pointer;"><sup><span class="glyphicon glyphicon-plus"></span></sup></span>
                        <span class="glyphicon glyphicon-trash delstaff" title="Delete this staff" data-id="<?php echo $id;?>" style="color:red; cursor: pointer;"></span>
                        <span data-show="<?php echo (".sub-inf-".$id); ?>" class="glyphicon glyphicon-list pull-right sub-show" title="View details about this staff" style="color: deepskyblue; cursor: pointer;"><sub><span class="glyphicon glyphicon-arrow-down"></span></sub></span>
                    </div>
                    
                    
                </div>
                
            </div>
            
        </div>
        
    </div>
    
    
    
    
    
</div>
    
    
    
    
    
    <?php
    
}
}  else {
    
?>
    
<p><h1 class="text-muted" style="text-align: center; margin-top: 5em;">No staff registered at the moment <span class="glyphicon glyphicon-warning-sign"></span></h1></p>
    
    
  <?php  
    
}

?>


<script>
    $(".editicon4").click(function(){
        var editbtn = $(this);
         $.get("get_up_inputs.php?id="+editbtn.attr("data-id"),null,function(data){
             $(".dlg-ex").html(data);
        }).done(function(){
            $(".dlg-ex").dialog({
                modal:true,
                show:'drop',
                hide: 'fade',
                buttons:{
                    Update:function(){
                               if(!$("#upfname,#uplname,#upcontact").val()){
                                   return false;
                               }
                               
                               
$.get("updatestaff.php?id="+editbtn.attr("data-id")+"&fname="+$("#upfname").val()+"&lname="+$("#uplname").val()+"&gender="+$("#upgender").val()+"&contact="+$("#upcontact").val(),null,function(data){
     $(".dlg-ex").html(data);
}).done(function(){
    $(".dlg-ex").dialog({
        modal:true,
          show:'bounce',
          hide: 'fade',
        show:'bounce',
        buttons:{
          Ok:function(){
              $(".dlg-ex").dialog("close");
              $(this).dialog("close");
              getstaff(); 
          }  
        }
    });
});
                   
                    },
      Cancel:function(){
                        $(this).dialog("close");
            }                  
                    
                }
            });
        });
        
    });
    
    //---------------------------------------------------------------------------------------------------------------------------
    
    $(".rmsub").click(function(){
        var bt = $(this);
        var id = $(this).attr("data-id");
         var sfid = $(this).attr("data-sfid");
        $(".dlg-ex").html("Are you sure you want to unasign this subject ?");
        $(".dlg-ex").dialog({
            modal:true,
              show:'bounce',
                hide: 'fade',
            buttons:{
                Yes:function(){
                    
                     $(this).dialog("close");
                     $.get("rmsub.php?id="+id+"&sfid="+sfid,null,function(data){
                        
                     }).done(function(){
                         
                         bt.parent().parent().remove();
                     }); 
                },
                No:function(){
                    
                    
                    $(this).dialog("close");
                }
                
                
            }
            
        });
      
        
        
        
        
    });
    
    
    
    //--------------------------------------------------------------------------------------------------------------------------
    $(".sub-show").click(function(){
        
        $show_id = $(this).attr("data-show");
           $($show_id).slideToggle(500);
        
    });
    
    //------------------------------------------------------------------------------------------------------------------------
     $(".asub").click(function(data){
        var me = $(this);
        $.get("subcls.php",null,function(data){
            
            $(".adddlg").html(data);
            
            
        }).done(function(){
            
            $(".adddlg").dialog({
                  show:'drop',
                hide: 'fade',
                modal:true,
                buttons:{
                    Save:function(){
                        $.get("assignsubs.php?sfid="+me.attr("data-id")+"&subid="+$("#sub").val()+"&clsid="+$("#cls").val(),null,function(data){
                            
                            $(".dlg-ex").html(data);
                            
                        }).done(function(){
                            
                            $(".dlg-ex").dialog({
                                modal:true,
                                buttons:{
                                    Ok:function(){
                                        $(this).dialog("close");
                                        getstaff();
                                        
                                        
                                    }
                                    
                                }
                                
                                
                            });
                            
                            
                        });
                        
                        
                        
                    },
                    Close:function(){
                        
                        $(this).dialog("close");
                        
                        
                        
                    }
                    
                    
                    
                }
                
                
                
            });
            
            
            
            
            
        });
        
        
        
        
        
    });
    
    
    
    
    //----------------------------------------------------------------------------------------------------------------------
     $(".delstaff").click(function(){
        var me = $(this);
        $(".dlg-ex").html("Are you sure you want to delete this staff");
      $(".dlg-ex").dialog({
          modal:true,
            show:'bounce',
                hide: 'fade',
          buttons:{
              Yes:function(){
                $.get("delstaff.php?id="+me.attr("data-id"),null,function(data){
                                       
                    $(".dlg-ex").html(data);
                    
                    
                }).done(function(data){
                    $(".dlg-ex").dialog({
                        modal:true,
                        buttons:{
                            Ok:function(){
                                $(this).dialog("close");
                                getstaff();
                                
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
//=============================================================================================================

$("span").tooltip();

</script>

