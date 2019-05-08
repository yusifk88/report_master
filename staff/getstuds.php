<?php
include_once 'objts/config.php';
$cf = new config();
$cf->connect();
$per_page = 50;
$prog = $_GET['prog'];
$cls= $_GET['cls'];
$huse= $_GET['huse'];
$form = $_GET['form'];
$ayear = $_GET['ayear'];
$gender = $_GET['gender'];
$ghouse = $_GET['ghouse'];
$page_query = mysqli_query($cf->con,"select count(*) as studnum from stuinfo where gender like '$gender%' and dept like '%$prog%' and class like '%$cls%' and house like '%$huse%' and form like '%$form%' and ayear like '%$ayear%' ");
$n = mysqli_fetch_object($page_query);
$pages = ceil($n->studnum/$per_page);
$page = ( isset($_GET['page'])) ? (int) $_GET['page']:1;
$start = ($page-1) * $per_page;

if($ghouse){
$stql = "select stuinfo.id,fname,oname,lname,stindex,form,classes.classname,dept.depname,dob,dor,ffname,fhometown,ftel,gender,ayear,houses.des,houses.name,lschool,mfname,mhometown,mtel,photo, (SELECT name from houses where id = stuinfo.ghouse) as ghouse from stuinfo,classes,dept,houses where stuinfo.class = classes.id and stuinfo.dept = dept.id and stuinfo.house = houses.id and stuinfo.gender like '$gender%' and  stuinfo.dept like '%$prog%' and stuinfo.class like '%$cls%' and stuinfo.house like '%$huse%' and stuinfo.form like '%$form%' and stuinfo.ayear like '%$ayear%' and stuinfo.ghouse LIKE '%$ghouse%' order by ayear DESC ,fname ASC LIMIT ".$start.",". $per_page;
}else{

    $stql = "select stuinfo.id,fname,oname,lname,stindex,form,classes.classname,dept.depname,dob,dor,ffname,fhometown,ftel,gender,ayear,houses.des,houses.name,lschool,mfname,mhometown,mtel,photo, (SELECT name from houses where id = stuinfo.ghouse) as ghouse from stuinfo,classes,dept,houses where stuinfo.class = classes.id and stuinfo.dept = dept.id and stuinfo.house = houses.id and stuinfo.gender like '$gender%' and  stuinfo.dept like '%$prog%' and stuinfo.class like '%$cls%' and stuinfo.house like '%$huse%' and stuinfo.form like '%$form%' and stuinfo.ayear like '%$ayear%' order by ayear DESC ,fname ASC LIMIT ".$start.",". $per_page;

}
$studs = mysqli_query($cf->con,$stql);
while ($row = mysqli_fetch_assoc($studs)) {
$id = $row['id'];
$wtest=mysqli_query($cf->con,"select * from withdraw WHERE stid = '$id'");
if(mysqli_num_rows($wtest)<1) {
    ?>
    <div id="row_<?=$row['id']?>" class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin:0 !important;">
        <div class="panel panel-default" style="margin:0 !important; margin-bottom: 2px !important; border-radius: 0 !important;">
            <div class="panel-body" style="padding: 0 !important; margin: 0 !important;">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3" style="margin: 0 !important;  text-align: center !important; padding-right: 0 !important; " id="imgcont_<?=$row['stindex']?>">
                        <img style="max-height: 170px; border-radius: 0 !important; " alt="<?= $row['fname']?>"
                             datasrc="<?="../admin/".$row['photo'] ?>" src ='../admin/objts/dpic/photo.jpg' class="img-thumbnail img-responsive st-photos"/>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-9"
                         style="margin: 0 !important; padding-left: 0 !important;">
                        <div class="table-responsive" style="margin: 0 !important; padding: 0 !important;">
                            <table class="table table-striped table-condensed"
                                   style="padding: 0 !important; margin: 0 !important;">
                                <tr>
                                    <th style="text-align: right;">ID:</th>
                                    <td><?php echo $row['stindex']; ?></td>

                                    <th style="text-align: right;">Name:</th>
                                    <td colspan='3'>
                                        <?php echo $row['fname'] . ' ' . $row['lname'] . ' ' . $row['oname']; ?>
                                    </td>
                                    <th style="text-align: right;">Gender:</th>
                                    <td>
                                        <?= $row['gender']; ?>
                                </tr>
                                <tr>
                                    <th style="text-align: right;">D.O.B:</th>
                                    <td>
                                        <?php echo $row['dob']; ?>
                                    </td>
                                    <th style="text-align: right;">Form:</th>
                                    <td>
                                        <?php echo "Form " . $row['form']; ?>
                                    </td>
                                    <th style="text-align: right;">Program:</th>
                                    <td>
                                        <?= $row["depname"] ?>
                                    </td>
                                    <th style="text-align: right;">Class</th>
                                    <td>
                                        <?= $row["classname"]; ?>
                                    </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="text-align: right;">House:</th>
                                    <td><?php echo $row['name']; ?></td>
                                    <th style="text-align: right;">Last Sch.:</th>
                                    <td><?php echo $row['lschool']; ?> </td>
                                    <th style="text-align: right;">Reg. Date:</th>
                                    <td><?php echo $row['dor']; ?></td>
                                    <th>Gender House</th>
                                    <td><?=$row['ghouse']? $row['ghouse']:'None';?></td>
                                </tr>
                                <tr>
                                    <th style="text-align: right;">Father's Name:</th>
                                    <td colspan='3'>
                                        <?php echo $row['ffname']; ?>
                                    </td>
                                    <th style="text-align: right;">Father's Hometown:</th>
                                    <td>
                                        <?php echo $row['fhometown']; ?>
                                    </td>
                                    <th style="text-align: right;">Father's Tel.:</th>
                                    <td>
                                        <?php echo $row['ftel']; ?>

                                    </td>
                                </tr>
                                <tr>
                                    <th style="text-align: right;">Mother's Name:</th>
                                    <td colspan='3'>
                                        <?php echo $row['mfname']; ?>
                                    </td>
                                    <th style="text-align: right;">Mother's Hometown:</th>
                                    <td>
                                        <?php echo $row['mhometown']; ?>


                                    </td>
                                    <th style="text-align: right;">Mother's Tel.:</th>
                                    <td>
                                        <?php echo $row['mtel']; ?>

                                    </td>
                                </tr>
                            </table>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer hidden-print"
                 style=" padding: 0 !important; margin-top: 0!important; height: 2em !important;  padding-left: 10px !important;">
                <i onclick="upstud(<?= $row['id']; ?>, '<?='row_'.$row['id']?>')" title="Edit this student's info." data-toggle='tooltip'
                      id="edstud"
                      style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="fa fa-edit waves-effect waves-circle btn btn-link"></i> 
                <i onclick="printstud(<?php echo $row['id']; ?>)" data-id="<?php echo $row['id']; ?>"
                      title="Print this student's profile" data-toggle='tooltip' id="printstud"
                      style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="fa fa-print waves-effect waves-circle btn btn-link"></i>
                <i onclick="Comnt(<?php echo $row['id']; ?>)" data-id="<?php echo $row['id']; ?>"
                      title="Add extra info. to this studen's profile eg. suspension" data-toggle='tooltip'
                      id="printstud"
                      style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="fa fa-comment waves-effect waves-circle btn btn-link"></i>
					  
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


                <i onclick="withdraw(<?= $row['id']; ?>)" data-id="<?php echo $row['id']; ?>"
                      title="Withdraw this student from the school" data-toggle='tooltip'
                      style="font-weight: bold; color: red; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="fa fa-undo waves-circle waves-effect btn btn-link"></i>

                <i onclick="delstud('<?php echo $row['id']; ?>')" data-stid="<?php echo $row['id']; ?>"
                      title="Delete this student" data-toggle='tooltip' id="delstud"
                      style="color: red; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="fa fa-remove btn waves-effect waves-circle btn-link"></i>
            </div>
        </div>


    </div>


    <?php
}else{

?>

<div id="row_<?=$row['id']?>" class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin:0 !important;">
        <div class="panel panel-default"
             style="margin:0 !important; margin-bottom: 2px !important; border-radius: 0 !important;">
            <div class="panel-body" style="padding: 0 !important; margin: 0 !important;">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3"
                         style="margin: 0 !important;  text-align: center !important; padding-right: 0 !important; ">
                        <img style="max-height: 170px; border-radius: 0 !important; " alt="<?php echo $row['fname']; ?>"
                             src="<?php echo $row['photo'] ?>" class="img-thumbnail img-responsive"/>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-9"
                         style="margin: 0 !important; padding-left: 0 !important;">
                        <div class="table-responsive text-danger" style="margin: 0 !important; padding: 0 !important;">
                            <table class="table table-striped table-bordered table-condensed"
                                   style="padding: 0 !important; margin: 0 !important;">
                                <tr>

                                    <th style="text-align: right;">ID:</th>
                                    <td><?php echo $row['stindex']; ?></td>

<th style="text-align: right;">Name:</th>
<td colspan='3'>
    <?php echo $row['fname'] . ' ' . $row['lname'] . ' ' . $row['oname']; ?>

</td>


<th style="text-align: right;">Gender:</th>
<td>
    <?= $row['gender']; ?>
    </tr>
    <tr>


        <th style="text-align: right;">D.O.B:</th>
        <td>
            <?php echo $row['dob']; ?>
        </td>
        <th style="text-align: right;">Form:</th>
        <td>
            <?php echo "Form " . $row['form']; ?>

        </td>

        <th style="text-align: right;">Program:</th>
        <td>
            <?= $row["depname"] ?>


        </td>
        <th style="text-align: right;">Class</th>
        <td>


            <?= $row["classname"]; ?>


            </select>

        </td>

    </tr>

    <tr>
        <th style="text-align: right;">House:</th>
        <td colspan='2'><?php echo $row['name']; ?></td>
        <th style="text-align: right;">Last Sch.:</th>
        <td colspan='2'><?php echo $row['lschool']; ?> </td>
        <th style="text-align: right;">Reg. Date:</th>
        <td><?php echo $row['dor']; ?></td>
    </tr>

    <tr>
        <th style="text-align: right;">Father's Name:</th>
        <td colspan='3'>
            <?php echo $row['ffname']; ?>
        </td>
        <th style="text-align: right;">Father's Hometown:</th>
        <td>
            <?php echo $row['fhometown']; ?>
        </td>
        <th style="text-align: right;">Father's Tel.:</th>
        <td>
            <?php echo $row['ftel']; ?>

        </td>
    </tr>
    <tr>
        <th style="text-align: right;">Mother's Name:</th>
        <td colspan='3'>
            <?php echo $row['mfname']; ?>
        </td>
        <th style="text-align: right;">Mother's Hometown:</th>
        <td>
            <?php echo $row['mhometown']; ?>


        </td>
        <th style="text-align: right;">Mother's Tel.:</th>
        <td>
            <?php echo $row['mtel']; ?>

        </td>
    </tr>
    </table>
    </form>

    </div>
    </div>
    </div>
    </div>
    <div class="panel-footer"
         style=" padding: 0 !important; margin-top: 0!important; height: 2em !important;  padding-left: 10px !important;">
                <i onclick="upstud(<?= $row['id']; ?>)" title="Edit this student's info." data-toggle='tooltip'
                      id="edstud"
                      style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="fa fa-edit  waves-effect waves-circle btn btn-link"></i>
                <i onclick="printstud(<?php echo $row['id']; ?>)" data-id="<?php echo $row['id']; ?>"
                      title="Print this student's profile" data-toggle='tooltip' id="printstud"
                      style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="fa fa-print waves-effect waves-circle btn btn-link"></i>
                <i onclick="Comnt(<?php echo $row['id']; ?>)" data-id="<?php echo $row['id']; ?>"
                      title="Add extra info. to this studen's profile eg. suspension" data-toggle='tooltip'
                      id="printstud"
                      style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="fa fa-comment waves-effect waves-circle btn btn-link"></i>
					  
					  
					  <i onclick="printrep(<?=$row['id']; ?>)" data-id="<?php echo $row['id']; ?>"
                      title="Print termnal report" data-toggle='tooltip'
                      id="printstud"
                      style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="fa fa-bar-chart-o waves-effect waves-circle btn btn-link"></i> 
					  
					  <i onclick="printtransc(<?= $row['id']; ?>)" data-id="<?php echo $row['id']; ?>"
                      title="Print Transcript" data-toggle='tooltip'
                      id="printstud"
                      style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="fa fa-line-chart waves-effect waves-circle btn btn-link"></i>

                      <i onclick="resetlogin('<?= $row['stindex']; ?>')"
                      title="Reset this student's login account" data-toggle='tooltip'
                      id="printstud"
                      style="color: deepskyblue; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="fa fa-line-chart waves-effect waves-circle btn btn-link"></i>

                <i onclick="unwithdraw(<?=$row['id']; ?>)" data-id="<?php echo $row['id']; ?>"
                      title="Resume this student back to the school" data-toggle='tooltip'
                      style="font-weight: bold; color: deepskyblue; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="fa fa-plus-square waves-effect waves-circle btn btn-link"></i>

                <i onclick="delstud('<?=$row['id']; ?>')" data-stid="<?php echo $row['id']; ?>"
                      title="Delete this student" data-toggle='tooltip' id="delstud"
                      style="color: red; font-weight: bold; cursor: pointer; margin: 0 !important; padding: 0 !important;"
                      class="fa fa-remove waves-effect waves-circle btn btn-link"></i>
    </div>
    </div>
    </div>
<?php
}
}
					$next = $page + 1;
					$prev = $page - 1;
					if($page > 1){?>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

    <nav>
        <br />
<ul class="pager">
    <li><a style="cursor:pointer;"  onclick="getstud(1)">First page</a></li>
    <li><a style="cursor:pointer;" onclick="getstud(<?php echo $prev;?>)">&LessLess;Prev.</a></li>
    
						<?php
						}
                                                
                    if($pages > 1){
                        ?>
    <nav>
            <ul class="pager">
      
    <li class="next">
        <select id="cbopage-list" class="we-select">
    
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
        
        </select></li>
        <?php
        
							if(($page < $pages)){
								?>
                                <br />
        <li><a style="cursor:pointer;" onclick="getstud(<?php echo $next;?>)">Next &GreaterGreater;</a></li>	
    <li><a style="cursor:pointer;" onclick="getstud(<?php echo $pages;?>)">Last Page</a></li>
								<?php
								}
				
					
?>
    
    
   
</ul>
    </nav>
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
