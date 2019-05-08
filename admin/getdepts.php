<?php
include_once './objts/config.php';
include_once './objts/department.php';


$dept = new Department();

$data = $dept->getdpts();
?>

<div class="card">
    <div class="card-header bg-info text-white">
        <p class="card-title">List of Departments</p>
    </div>


<div class="table-responsive text-nowrap">
        <table class="table table-hover table-striped">
        <thead class="bg-info text-white">
            <tr>
                <th>S/N</th>
                <th>Description</th>
                <th>Date of Entry</th>
                <th colspan="2">Actions</th>
            </tr>
            
        </thead>  
        
        
        <tbody>
            <?php
            $i = 1;
            while ($row = mysqli_fetch_assoc($data)) {
                
                ?>
                
            <tr id="row_<?=$row['id']?>">
            
                <td>
                    <?= $i?>
                </td>
                <td>
                    <?php
                        echo $row['depname'];
                    ?>
                </td>
                <td>
                    <?php
                        echo $row['dentry'];
                    ?>
                </td>
                
                <td><i class="fa fa-edit waves-effect waves-circle editicon" title="Edit this department" data-input="<?php echo "$row[depname]";?>" data-id="<?php echo $row['id']; ?>" style="color: deepskyblue; cursor: pointer;"></i></td>
                <td><i class="fa fa-remove waves-effect waves-circle delicon" title="Delete this department" data-del="deldept.php" data-id="<?php echo $row['id']; ?>" style="color: #F00; cursor: pointer;"></i></td>
                
            </tr>    
            
       
            
            
                <?php
                $i++;
                
                
            }
            
            
            ?>


            
             <script>
                 
                 $(".editicon").click(function(){
                     var me = $(this);
                     var temp="<form> <div class='col-lg-12 col-md-12 col-xs-12 col-sm-12'><div class='md-form'><i class='prefix fa fa-star-o active'></i>";
                     temp+="<input type='text' id='depname' class='form-control' value='"+me.attr("data-input").toString()+"'/>";
                     temp+="<label class='active' for='depname'>Department name/description</label>";
                     temp+="</div></div></form>";
                     BootstrapDialog.show({
                         title:"Update Department",
                         message:temp,
                         buttons:[{label:"UPDATE",cssClass:"bg-info text-white",action:function(d){

                            if($("#depname").val().length<1){
                                $("#depname").focus();
                            }else {
                                d.close();

                                $.get("updatedep.php?id=" + me.attr("data-id") + "&depname=" + $("#depname").val().toString(), null, function (data) {

                                }).done(function (data) {
                                    getdepts();

                                    Snarl.addNotification({
                                        title: "UPDATED",
                                        text: data,
                                        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle-o'></i>",
                                        timeout: 3000
                                    });
                                    $(".snarl-notification").addClass('snarl-success');
                                });
                            }
                         }}]
                     });
                 });
                 
                 //==========================================================================================
            $(".delicon").click(function(){
            var me = $(this);
                BootstrapDialog.show({
                    title:"Confirm Delete",
                    message:"This will affect all classes under this department including their students, PROCEED?",
                    buttons:[{label:"DELETE",cssClass:"btn-danger",action:function(d){
                        d.close();
                        $.get(me.attr("data-del")+"?id="+me.attr("data-id"),null,function(data){
                        }).done(function(){

                            var viewid = "#row_"+me.attr('data-id');
                            $(viewid).fadeOut(200,function(){
                                $(viewid).remove();
                            });
                        });
                    }}]
                });
                $(".modal-backdrop").addClass("backdrop-light");
            });
        $("i").tooltip();
        
        </script>
        </tbody>
        </table>
</div>

</div>






