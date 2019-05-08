<div class="col-lg-8 col-md-8 col-lg-offset-2 col-md-offset-2 col-sm-12 col-xs-12">
    <div class="panel panel-info" style="border-radius: 0;">
        <div class="panel-body">            
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="alert alert-info">                        
                        <p class="panel-title">Restore Backup</p>
                    </div>
                </div>                
            </div>           
            
            <div class="row">
                <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
                 <div id="rest_zone" style="width: 150px; height: 50px;  margin-left: 10px; border: thin dashed deepskyblue;"></div>
                    Drop backup file here or click to upload
                 </div>
                <div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
                    
                    <input placeholder="file path" class="form-control" type="text" readonly="" id="respath" />
                </div>
        </div>
            </div> 

        <div class="panel-footer">            
              <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button id="run_res" type="button" class="btn btn-good waves-effect waves-button" >Run Restore</button>                    
                </div>                
            </div>            
        </div>
    </div>
    <script>
    
    $(document).ready(function(){
        $("div#rest_zone").dropzone(
            { url: "./dropfile2.php",
                acceptedFiles: ".zip",
                addRemoveLinks:true,
                dictDefaultMessage:"drop Backup File here or click to upload",
                maxFiles:1,
                maxFilesize:20000,
                accept:function(file,done){
                    $("#respath").val(file.name);
                    done();
                }

            });
     
     $("#run_res").click(function(){
         if(!$("#respath").val()){
           Snarl.addNotification({
                        title:"ERROR",
                        text:"No backup file selected",
                        icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                        timeout:3000
                    });
                    $(".snarl-notification").addClass('snarl-error');
        }else{
        var progress = Snarl.addNotification({
                          title:"Please Wait...",
                          text:"Restoring backup data",
                          icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-circle-o-notch fa-spin'></i>",
                          timeout:null
                      });
                      $(".snarl-notification").addClass('snarl-info');
         $.get("run_res.php?backup="+$("#respath").val(),function(){            
             
         }).done(function(){
             $.get("backup/restore.php",function(){
                 
                 
             }).done(function(){
				 Snarl.removeNotification(progress);
         Snarl.addNotification({
                        title:"RESTORE",
                        text:"Retore completed successful",
                        icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle'></i>",
                        timeout:3000
                    });
                    $(".snarl-notification").addClass('snarl-success'); 
                 
                 
             });
             
             
             });
        }     
         });         
          
     }); 

   
    
    </script>