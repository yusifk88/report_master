<?php
include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$per_page = 20;
$prog = $_GET['prog'];
$cls= $_GET['cls'];
$huse= $_GET['huse'];
$form = $_GET['form'];
$ayear = $_GET['ayear'];
$gender = $_GET['gender'];
$ghouse = $_GET['ghouse'];
$resstatus = $_GET['resstatus'];
$page_query = mysqli_query($cf->con,"select count(*) as studnum from stuinfo where gender like '$gender%' and dept like '%$prog%' and class like '%$cls%' and house like '%$huse%' and form like '%$form%' and ayear like '%$ayear%' and stuinfo.res_status LIKE '%$resstatus%'");
$n = mysqli_fetch_object($page_query);
$pages = ceil($n->studnum/$per_page);
$page = ( isset($_GET['page'])) ? (int) $_GET['page']:1;
$start = ($page-1) * $per_page;
if($ghouse){
$stql = "select stuinfo.id,fname,oname,lname,stindex,form,classes.classname,dept.depname,dob,dor,ffname,fhometown,ftel,gender,ayear,houses.des,houses.name,lschool,mfname,mhometown,mtel,photo,res_status, (SELECT name from houses where id = stuinfo.ghouse) as ghouse from stuinfo,classes,dept,houses where stuinfo.class = classes.id and stuinfo.dept = dept.id and stuinfo.house = houses.id and stuinfo.gender like '$gender%' and  stuinfo.dept like '%$prog%' and stuinfo.class like '%$cls%' and stuinfo.house like '%$huse%' and stuinfo.form like '%$form%' and stuinfo.ayear like '%$ayear%' and stuinfo.ghouse LIKE '%$ghouse%' and stuinfo.res_status LIKE '%$resstatus%' order by ayear DESC ,fname ASC LIMIT ".$start.",". $per_page;
}else{
$stql = "select stuinfo.id,fname,oname,lname,stindex,form,classes.classname,dept.depname,dob,dor,ffname,fhometown,ftel,gender,ayear,houses.des,houses.name,lschool,mfname,mhometown,mtel,photo,res_status, (SELECT name from houses where id = stuinfo.ghouse) as ghouse from stuinfo,classes,dept,houses where stuinfo.class = classes.id and stuinfo.dept = dept.id and stuinfo.house = houses.id and stuinfo.gender like '$gender%' and  stuinfo.dept like '%$prog%' and stuinfo.class like '%$cls%' and stuinfo.house like '%$huse%' and stuinfo.form like '%$form%' and stuinfo.ayear like '%$ayear%' and stuinfo.res_status LIKE '%$resstatus%' order by ayear DESC ,fname ASC LIMIT ".$start.",". $per_page;
}
$studs = mysqli_query($cf->con,$stql);
while ($row = mysqli_fetch_assoc($studs)) {
$id = $row['id'];
$wtest=mysqli_fetch_object(mysqli_query($cf->con,"select * from withdraw WHERE stid = '$id'"));
    ?>
    <div id="row_<?=$row['id']?>" class="col-lg-12 col-md-12 col-sm-12 col-12 mb-2 mb-xs-3" >
        <div class="card hoverable <?=$wtest? 'border-danger':'' ?> ">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-2" id="imgcont_<?=$row['stindex']?>">
                        <img  alt="<?= $row['fname']?>"
                             datasrc="<?= file_exists($row['photo']) ? $row['photo']: 'objts/dpic/photo.jpg' ?>" src ='objts/dpic/photo.jpg' class="img-thumbnail img-fluid img-responsive st-photos"/>
                     </div>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-10"
                         style="margin: 0 !important; padding-left: 0 !important;">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-sm"
                                   style="padding: 0 !important; margin: 0 !important;">
                                <tr>
                                    <th class="th-sm"><?php echo $row['stindex']; ?><br>
                                        <small class="text-muted">ID</small>
                                    </th>

                                   <th class="th-sm">
                                        <?= $row['fname'] . ' ' . $row['lname'] . ' ' . $row['oname']; ?> <br> <small class="text-muted">Name</small>
                                    </th>
                                    <th class="th-sm">
                                  <?php
                                  if($row['res_status'] == 'Boarding Student'){
                                      ?>
                                      <span class=" text-white bg-success p-2">Boarding Student</span>

                                      <?php
                                  }elseif($row['res_status'] == 'Day Student'){

                                      ?>
                                      <span class="text-white p-2 bg-warning">Day Student</span>

                                      <?php
                                  }


                                  ?>

                                    </th>
                                    <th class="th-sm">
                                        <?= $row['gender']; ?> <br> <small class="text-muted">Gender</small>
                                    </th>
                                    <th class="th-sm">
                                        <?php echo $row['dob']; ?> <br> <small class="text-muted">D.O.B</small>
                                    </th>
                                    <th class="th-sm">
                                        <?php echo "Form " . $row['form']; ?> <br> <small class="text-muted">Form</small>
                                    </th>

                                </tr>
                                <tr>
                                    <th class="th-sm"><?php echo $row['name'];?> <br> <small class="text-muted">House</small></th>
                                    <th class="th-sm"><?php echo $row['lschool']; ?> <br> <small class="text-muted">Last Sch.</small> </th>
                                    <th class="th-sm"><?php echo $row['dor']; ?><br> <small class="text-muted">Reg Date</small></th>
                                    <th class="th-sm"><?=$row['ghouse']? $row['ghouse']:'None';?><br> <small class="text-muted">Gender House/Hall</small></th>
                                    <th class="th-sm">
                                        <?= $row["classname"]; ?> <br> <small class="text-muted">Class</small>
                                    </th>
                                    <th class="th-sm">
                                        <?= $row["depname"] ?> <br> <small class="text-muted">Program</small>
                                    </th>

                                </tr>
                                <tr>
                                    <td>
                                        <?php echo $row['ffname']; ?> <br> <small class="text-muted">Father's Name</small>
                                    </td>
                                    <td>
                                        <?php echo $row['fhometown']; ?> <br> <small class="text-muted">Father's Hometown</small>
                                    </td>

                                    <td>
                                        <?php echo $row['ftel']; ?> <br> <small class="text-muted">Father's Tel</small>
                                    </td>

                                    <td>
                                        <?php echo $row['mfname']; ?> <br> <small class="text-muted">Mother's Name</small>
                                    </td>
                                    <td>
                                        <?php echo $row['mhometown']; ?> <br> <small class="text-muted">Mother's Hometown</small>
                                    </td>
                                    <td>
                                        <?php echo $row['mtel']; ?> <br> <small class="text-muted">Motyher's Tel</small>
                                    </td>
                                </tr>
                            </table>
                            </form>
                        </div>
                    </div>
                </div>
            <div class="card-footer bg-white p-0">
                      <i onclick="upstud(<?= $row['id']; ?>, '<?='row_'.$row['id']?>')" title="Edit this student's info." data-toggle='tooltip'
                       id="edstud"
                       style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                       class="fa fa-edit waves-effect waves-circle btn btn-link text-muted"></i>
                    <i onclick="printstud(<?php echo $row['id']; ?>)" data-id="<?php echo $row['id']; ?>"
                       title="Print this student's profile" data-toggle='tooltip' id="printstud"
                       style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                       class="fa fa-print waves-effect waves-circle btn btn-link"></i>
                    <i onclick="Comnt(<?php echo $row['id']; ?>)" data-id="<?php echo $row['id']; ?>"
                       title="Add extra info. to this studen's profile eg. suspension" data-toggle='tooltip'
                       id="printstud"
                       style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                       class="fa fa-comment-o waves-effect waves-circle btn btn-link"></i>

                    <i onclick="printrep(<?php echo $row['id']; ?>)" data-id="<?php echo $row['id']; ?>"
                       title="Print termnal report" data-toggle='tooltip'
                       id="printrep"
                       style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                       class="fa fa-bar-chart-o waves-effect waves-circle btn btn-link"></i>
                    <i onclick="printtransc(<?php echo $row['id']; ?>)" data-id="<?php echo $row['id']; ?>"
                       title="Print Transcript" data-toggle='tooltip'
                       id="printstud"
                       style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                       class="fa fa-line-chart waves-effect waves-circle btn btn-link"></i>

                    <i onclick="resetlogin('<?= $row['stindex']; ?>')"
                       title="Reset this student's login account" data-toggle='tooltip'
                       id="printstud"
                       style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                       class="fa fa-retweet waves-effect waves-circle btn btn-link"></i>

<?php
    if($wtest){
?>
        <i onclick="unwithdraw(<?= $row['id']; ?>)" data-id="<?php echo $row['id']; ?>"
           title="Resume this student back into the school" data-toggle='tooltip'
           style="font-weight: bold; color: red; cursor: pointer; margin: 0 !important; padding: 0 !important;"
           class="fa fa-arrow-circle-o-right waves-circle waves-effect btn btn-link"></i>

<?php
}else{
    ?>
        <i onclick="withdraw(<?= $row['id']; ?>)" data-id="<?php echo $row['id']; ?>"
           title="Withdraw this student from the school" data-toggle='tooltip'
           style="font-weight: bold; color: red; cursor: pointer; margin: 0 !important; padding: 0 !important;"
           class="fa fa-undo waves-circle waves-effect btn btn-link"></i>

    <?php

    }


?>

                <i onclick="exiat(<?=$row['id']; ?>)" data-stid="<?php echo $row['id']; ?>"
                   title="Sign a permission for this student. eg. Exiat" data-toggle='tooltip' id="delstud"
                   style="font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                   class="fa fa-id-card-o btn waves-effect waves-circle btn-link"></i>




                <i onclick="delstud('<?php echo $row['id']; ?>')" data-stid="<?php echo $row['id']; ?>"
                   title="Delete this student" data-toggle='tooltip' id="delstud"
                   style="font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                   class="fa fa-remove btn waves-effect waves-circle btn-link text-danger"></i>



        </div>
        </div>

    </div>
    <?php

}
					$next = $page + 1;
					$prev = $page - 1;

    ?>
    <div class="col-md-4 col-12 mx-auto text-center">

    <?php
					if($page > 1){?>



        <br />
    <a style="cursor:pointer;" class="btn bg-info text-white btn-sm"  onclick="getstud(1)">First page</a>
   <a style="cursor:pointer;" class="btn bg-info text-white btn-sm"  onclick="getstud(<?php echo $prev;?>)">&LessLess;Prev.</a>
    
						<?php
						}
                                                
                    if($pages > 1){
                        ?>

        <select id="cbopage-list" class="form-control">
    
                            <?php
			for($x =1; $x <= $pages; $x++){
	    		?>	
        
            <?php
            if($x === $page){
                ?>
        <option value="<?php echo $x;?>" selected="selected"><?php echo"Page ".$x?></option>    
            
                <?php
            }else{
                ?>
                
                <option value="<?php echo $x;?>" ><?php echo"Page ".$x?></option>    
     
        
                <?php
            }
            
            
            ?>
            <?php   
            }
            }  ?>
        
        </select>
        <?php
        
							if(($page < $pages)){
								?>
                                <br />
       <a style="cursor:pointer;" class="btn bg-info text-white btn-sm"  onclick="getstud(<?php echo $next;?>)">Next &GreaterGreater;</a>
   <a style="cursor:pointer;" class="btn bg-info text-white btn-sm"  onclick="getstud(<?php echo $pages;?>)">Last Page</a>
								<?php
								}
				
					
?>
    </div>

<script>

    $('#cbopage-list').change(function(){
        var page = $(this).val();
        getstud(page);
    });
    $("i").tooltip();
    var cachename = 'imgv1.0';
    var cachedimg =[];
    $(".st-photos").each(function (key,obj) {
        obj.src = $(obj).attr('datasrc');

        cachedimg[key] =$(obj).attr('datasrc');
//        caches.match($(obj).attr('datasrc')).then(function (responds) {
//           if(responds){
//               obj.src = responds.url.replace("http://localhost/online/report/admin/","");
//
//           } else{
//           obj.src = $(obj).attr('datasrc');
//           }
//
//        });
    });
    caches.open(cachename).then(function(cache){
        return cache.addAll(cachedimg);

    })
</script>
