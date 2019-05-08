<?php
session_start();
if(!$_SESSION['uname'] && !$_SESSION['id']){    
    header("location:../");
}
include_once '../admin/objts/config.php';
include_once '../admin/objts/department.php';
include_once '../admin/objts/house.php';
include_once '../admin/objts/rclass.php';
include '../admin/objts/subjects.php';
include_once '../admin/objts/school.php';
$cfg = new config();
$cfg->connect();
$stfid = $_SESSION['id'];
$dline = mysqli_fetch_object(mysqli_query($cfg->con,"select * from deadline"));
$stafid = $_SESSION['id'];
$frmtes = mysqli_query($cfg->con,"select * from frmmaters where stfid = '$stafid'");
$shm = mysqli_query($cfg->con,"select * from shm where stfid = '$stafid'");
$hm = mysqli_query($cfg->con,"select * from housem where stfid = '$stafid'");
$wof = mysqli_query($cfg->con,"select * from woff where stfid = '$stafid'");
$librian = mysqli_query($cfg->con,"select * from librian where stfid = '$stafid'");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Report Master| Staff</title>
        <meta charset="UTF-8">
       <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">
        <link rel="icon" href="img/rmicon.png" />
        <link href="../admin/css/ui-lightness/jquery-ui-1.10.4.min.css" rel="stylesheet" type="text/css"/>
        <link href="../admin/start/jquery-ui.theme.min.css" rel="stylesheet" type="text/css"/>
        <link href="../admin/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="../admin/css/dropzone.min.css" rel="stylesheet" type="text/css"/>
        <link href="../admin/css/basic.min.css" rel="stylesheet" type="text/css"/>
        <link href="../admin/css/snarl.min.css" rel="stylesheet" type="text/css"/>
        <link href="../admin/css/waves.min.css" rel="stylesheet" type="text/css"/>
        <link href="../admin/css/bootstrap-dialog.min.css" rel="stylesheet" />
        <link href="../admin/css/bootstrap.min.css" rel="stylesheet" />
        <link href="../admin/css/mystyle.css" rel="stylesheet" />
        <script src="../admin/js/snarl.min.js" type="text/javascript"></script>
        <script src="../admin/js/jquery.js" type="text/javascript"></script>
        <script src="../admin/js/jquery-ui-1.10.4.min.js" type="text/javascript"></script>
        <script src="../admin/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../admin/js/bootstrap-dialog.min.js" type="text/javascript"></script>
        <script src="../admin/js/dropzone.min.js" type="text/javascript"></script>
        <script src="../admin/js/waves.min.js" type="text/javascript"></script>
        <script src="../admin/js/chart.js" type="text/javascript"></script>
        <script src="../admin/js/wejs.js" type="text/javascript"></script>
      </head>
      <body>
     <nav class="navbar navbar-fixed-top">
      <div class="container">
          <input type="hidden" id="global_stfid" value="<?=$_SESSION['id']?>">
          <input type="hidden" id="global_usertype" value="<?=$_SESSION['utype']?>">
        <div class="navbar-header">
            <a class="navbar-brand hidden-md hidden-lg" id="nav-back" href="#" style="padding-top: 15px !important;"><i class="fa fa-long-arrow-left"> </i></a>
            <a onclick="return false;"  style="overflow: hidden; font-weight: bold;" class="navbar-brand" href="#"><?=$_SESSION['fname']." ".$_SESSION['lname']." [".$_SESSION['utype']."]";?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
              <?php
                if($dline->status =="ON") {
                    ?>
                    <li ><a style="color: red !important;" href="#about">Deadline: <?= $dline->ddate; ?> <i
                                class="fa fa-clock-o"></i></a></li>
                    <?php
                }
              ?>
              <li><a onclick="return false;" id="aboutmnu" href="#about"><i class="fa fa-info-circle"></i></a></li>
              <li><a onclick="return false;" id="hlpmnu" href="#Help"><i class="fa fa-question-circle"></i> </a></li>
              <li><a onclick="logout(); return false;" href="#logout"><i class="fa fa-sign-out"></i></a></li>
              <?php if(mysqli_num_rows($shm)>0){
              ?>
              <li><a id="searchbtn" href="#" onclick="showsearch(); return false;"><i style="font-weight: bolder;" class="fa fa-search"></i></a></li>
              <?php
              }

              ?>
          </ul>
        </div>
      </div>
    </nav>
       <div class="container-fluid" style="margin-bottom:4em;">
            <!-- start menu -->           
            <div class="startmenu" style="display: none !important;">
                <div class="tile-group">
                          <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                        <a href="#/viewassess" style="text-decoration: none;">
                        <div class="tile tile-violet" data-id="#viewassess" data-get="assess">
                            <span class="glyphicon glyphicon-list-alt tile-icon"></span>
                            
                            <p class="title" >Manage Assessments</p>
                           
                            <div class="detail visible-lg visible-md">
                                Save,view and edit assessment records of students that you teach.
                            </div>
                        </div>
                            </a>
                    </div>
                      <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                        <a href="#/myaccount" style="text-decoration: none;">
                        <div class="tile tile-red" data-id="#myaccount" data-get="getaccount">
                            <i class="fa fa-lock tile-icon"></i>
                            <p class="title" >My Account</p>
                            <div class="detail visible-lg visible-md">
                            Manage your user account details
                            </div>
                        </div>
                            </a>
                    </div>
                       <?php
                       if(mysqli_num_rows($frmtes)>0){
                        ?>
                           <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                               <a href="#/mngfrm" style="text-decoration: none;">

                               <div class="tile tile-blue" data-id="#mngfrm" data-get="frmdata">

                                   <i class="fa fa-users tile-icon"></i>

                                   <p class="title" >Manage Form Records</p>

                                   <div class="detail visible-lg visible-md">
                                       Manage students' attendance,attitude,interest, etc.
                                   </div>
                               </div>
                                   </a>
                           </div>
                          <?php
                       }
                       if(mysqli_num_rows($shm)>0 || mysqli_num_rows($hm)>0){
                        ?>
                           <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                               <a href="#/viewstuds" style="text-decoration: none;">
                                   <div class="tile tile-deepblue" data-id="#viewstuds" data-get="getstud">
                                       <span class="glyphicon glyphicon-education tile-icon"></span>
                                       <p class="title">View Students</p>
                                       <div class="detail visible-lg visible-md">
                                           View the students that have been registered in the system
                                       </div>
                                   </div>
                               </a>
                           </div>
                           <?php
                       }
                       if(mysqli_num_rows($wof)>0){
                    ?>
                                  <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                       <a href="#/allca" style="text-decoration: none;">
                                           <div class="tile tile-green" data-id="#allca" data-get="allca">
                                               <i class="fa fa-linode tile-icon"></i>
                                               <p class="title">Manage All CA Records</p>
                                               <div class="detail visible-lg visible-md">
                                                   Manage assesment records recorded by various subject teachers
                                               </div>
                                           </div>
                                       </a>
                                   </div>
                                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                       <a href="#/waec" style="text-decoration: none;">
                                           <div class="tile tile-green-yellow" data-id="#waec" data-get="waec">
                                               <i class="fa fa-balance-scale tile-icon"></i>
                                               <p class="title">Manage WAEC Records</p>
                                               <div class="detail visible-lg visible-md">
                                                   Manage WASSCE results of final year students
                                               </div>
                                           </div>
                                       </a>
                                   </div>
                                   <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                       <a href="#/graph-class" style="text-decoration: none;">
                                           <div class="tile tile-black" data-id="#graph-class" data-get="graphclass">
                                               <i class="fa fa-pie-chart tile-icon"></i>
                                               <p class="title">Graphical Analysis by Class</p>
                                               <div class="detail visible-lg visible-md">
                                                   View the graphical representation of waec records under a selected class
                                               </div>
                                           </div>
                                       </a>
                                   </div>
                       <?php
                       }
                       if(mysqli_num_rows($librian)>0){
                           $libtest = true;
                       ?>
                           <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                               <a href="#/mngbooks" style="text-decoration: none;">
                                   <div class="tile tile-grey" data-id="#mng-books" data-get="mng-books">
                                       <i class="fa fa-book tile-icon"></i>
                                       <p class="title">Manage Library Books</p>
                                       <div class="detail visible-lg visible-md">
                                           View and manage books in the library
                                       </div>
                                   </div>
                               </a>
                           </div>

                           <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                               <a href="#/lendbooks" style="text-decoration: none;">
                                   <div data-id="#lendbooks" data-get="lendbooks" class="tile tile-orange">
                                       <span class="fa fa-handshake-o tile-icon"></span> <sup><i class="fa fa-history"></i></sup>
                                       <p class="title">Lend History</p>
                                       <div class="detail visible-lg visible-md">
                                           View List of students with books in their posession
                                       </div>
                                   </div>
                               </a>
                           </div>
                       <?php
                       }else{
                       $libtest = false;

                       }
                      ?>
                      <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                          <a href="../admin/report_master.apk" style="text-decoration: none;">
                          <div class="tile tile-green">
                              <span class="fa fa-android tile-icon"></span>
                              <p class="title">Download Android App</p>
                              <div class="detail visible-lg visible-md">
                                  Get the android version of this system for your smart phone
                              </div>
                          </div>
                      </a>
                  </div>

                </div>
            </div>
        </div>
       <?php
            if(mysqli_num_rows($shm)>0){
           ?>
                <div class="mainform content row" style="background: transparent; box-shadow: 0 0 0 ; padding: 0; margin-right: 0 !important; margin-left: 0 !important; margin-bottom: 3em; margin-top: 7em;" id="schres">
                </div>
                <div class="mainform content row" style="background: transparent; box-shadow: 0 0 0 ; padding: 0; margin-right: 0 !important; margin-left: 0 !important; margin-bottom: 3em; margin-top: 3em;" id="viewstuds">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin: 0 !important;">
                        <div class="row" >
                            <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin: 0 !important;">
                                <div class="alert alert-info hidden-print" style="margin: 1px !important; box-shadow: 0 0 2px;">
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 hidden-xs hidden-sm"><h3>View Students <span class="glyphicon glyphicon-user"><span class="glyphicon glyphicon-user"></span></h3></div><div class="col-lg-4 col-md-4 col-sm-4 col-xs-6"><button id="filter-btn" class="btn btn-good" style="color:#fff !important; margin-top:20px !important;" id="filter-btn"><i  class="fa fa-filter "></i>Filter Students</button>
                                            <button onclick="allprint();" class="btn btn-good hidden-sm hidden-xs" style="color:#fff !important;"><i class="fa fa-print"></i> Print</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
                                            <div style="border-bottom: 1px solid #ccc;"></div>
                                        </div>
                                        <form id="filter-form" style="display: none;">
                                            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
                                                <label style="color: #FFFFFF; " class="control-label">Programe:</label>
                                                <select class="form-control" id="getstud-pro">
                                                    <option value="" selected="selected">All</option>
                                                    <?php
                                                    $de = new Department();
                                                    $ds = $de->getdpts();
                                                    while ($row1 = mysqli_fetch_assoc($ds)) {
                                                        ?>
                                                        <option value="<?php echo $row1['id'];?>"><?php echo $row1['depname'];?> </option>

                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-1 col-md-1 col-sm-2 col-xs-2">
                                                <label style="color:#fff;" class="control-label">Gender</label>
                                                <select id="filter-gender" class="form-control">
                                                    <option value="">All</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Male">Male</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">
                                                <label style="color: #FFFFFF; " class="control-label">Aca. Year</label>
                                                <select class="form-control" id="getstud-ayear">
                                                    <option value="" selected="selected">All</option>
                                                    <?php
                                                    $cf = new config();
                                                    $cf->connect();
                                                    $ayear =  mysqli_query($cf->con,"select DISTINCT(ayear) from stuinfo ORDER by ayear ASC ");
                                                    while ($row1 = mysqli_fetch_assoc($ayear)) {
                                                        ?>
                                                        <option value="<?php echo $row1['ayear'];?>"><?php echo $row1['ayear'];?> </option>

                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-1 col-md-1 col-sm-3 col-xs-3">
                                                <label style="color: #FFFFFF; " class="control-label">Form:</label>
                                                <select class="form-control" id="getstud-form">
                                                    <option value="" selected="selected">All</option>
                                                    <option value="1">Form 1</option>
                                                    <option value="2">Form 2</option>
                                                    <option value="3">Form 3</option>
                                                    <option value="4">Form 4</option>

                                                </select>

                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                <label style="color: #FFFFFF; " class="control-label">Class:</label>
                                                <select class="form-control" id="getstud-class">
                                                    <option value="" selected="selected">All</option>
                                                    <?php
                                                    $cl = new Rclass();
                                                    $cls = $cl->getclasses();
                                                    while ($row1 = mysqli_fetch_assoc($cls)) {

                                                        ?>
                                                        <option value="<?php  echo $row1['id'];?>"><?php  echo $row1['classname'];?> </option>

                                                        <?php
                                                    }

                                                    ?>
                                                </select>

                                            </div>

                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                <label style="color: #FFFFFF; " class="control-label">House:</label>
                                                <select class="form-control" id="getstud-house">
                                                    <option value="" selected="selected">All</option>
                                                    <?php
                                                    $h = new House();
                                                    $hus = $h->gethouses();
                                                    while ($hs = mysqli_fetch_assoc($hus)) {
                                                        ?>
                                                        <option value="<?php echo $hs['id'];?>"><?php echo $hs['des'];?> </option>
                                                        <?php
                                                    }

                                                    ?>
                                                </select>

                                            </div>

                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                <label style="color: #FFFFFF; " class="control-label">Gender House:</label>
                                                <select class="form-control" id="getstud-ghouse">
                                                    <option value="" selected="selected">All</option>
                                                    <?php
                                                    $ghouse = mysqli_query($cf->con,"select * from houses where house_type <> 'genhouse'");
                                                    while ($gh = mysqli_fetch_object($ghouse)) {
                                                        ?>
                                                        <option value="<?= $gh->id;?>"> <?=$gh->des?> (<?=$gh->name?>) </option>
                                                        <?php
                                                    }

                                                    ?>
                                                </select>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="stud-list" class="row">
                        </div>
                    </div></div>
           <?php
           }elseif(mysqli_num_rows($hm)>0){
            ?>

                <div class="mainform content row" style="background: transparent; box-shadow: 0 0 0 ; padding: 0; margin-right: 0 !important; margin-left: 0 !important; margin-bottom: 3em; margin-top: 7em;" id="schres">
                </div>
                <div class="mainform content row" style="background: transparent; box-shadow: 0 0 0 ; padding: 0; margin-right: 0 !important; margin-left: 0 !important; margin-bottom: 3em; margin-top: 3em;" id="viewstuds">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin: 0 !important;">
                        <div class="row" >
                            <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin: 0 !important;">
                                <div class="alert alert-info hidden-print" style="margin: 1px !important; box-shadow: 0 0 2px;">
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 hidden-xs hidden-sm"><h3>View Students <span class="glyphicon glyphicon-user"><span class="glyphicon glyphicon-user"></span></h3></div><div class="col-lg-4 col-md-4 col-sm-4 col-xs-6"><button id="filter-btn" class="btn btn-good" style="color:#fff !important; margin-top:20px !important;" id="filter-btn"><i  class="fa fa-filter "></i>Filter Students</button>
                                            <button onclick="allprint();" class="btn btn-good hidden-sm hidden-xs" style="color:#fff !important;"><i class="fa fa-print"></i> Print</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
                                            <div style="border-bottom: 1px solid #ccc;"></div>
                                        </div>
                                        <form id="filter-form" style="display: none;">
                                            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
                                                <label style="color: #FFFFFF; " class="control-label">Programe:</label>
                                                <select class="form-control" id="getstud-pro">
                                                    <option value="" selected="selected">All</option>
                                                    <?php
                                                    $de = new Department();
                                                    $ds = $de->getdpts();
                                                    while ($row1 = mysqli_fetch_assoc($ds)) {
                                                        ?>
                                                        <option value="<?php echo $row1['id'];?>"><?php echo $row1['depname'];?> </option>

                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-1 col-md-1 col-sm-2 col-xs-2">
                                                <label style="color:#fff;" class="control-label">Gender</label>
                                                <select id="filter-gender" class="form-control">
                                                    <option value="">All</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Male">Male</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">
                                                <label style="color: #FFFFFF; " class="control-label">Aca. Year</label>
                                                <select class="form-control" id="getstud-ayear">
                                                    <option value="" selected="selected">All</option>
                                                    <?php
                                                    $cf = new config();
                                                    $cf->connect();
                                                    $ayear =  mysqli_query($cf->con,"select DISTINCT(ayear) from stuinfo ORDER by ayear ASC ");
                                                    while ($row1 = mysqli_fetch_assoc($ayear)) {
                                                        ?>
                                                        <option value="<?php echo $row1['ayear'];?>"><?php echo $row1['ayear'];?> </option>

                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-1 col-md-1 col-sm-3 col-xs-3">
                                                <label style="color: #FFFFFF; " class="control-label">Form:</label>
                                                <select class="form-control" id="getstud-form">
                                                    <option value="" selected="selected">All</option>
                                                    <option value="1">Form 1</option>
                                                    <option value="2">Form 2</option>
                                                    <option value="3">Form 3</option>
                                                    <option value="4">Form 4</option>

                                                </select>

                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                <label style="color: #FFFFFF; " class="control-label">Class:</label>
                                                <select class="form-control" id="getstud-class">
                                                    <option value="" selected="selected">All</option>
                                                    <?php
                                                    $cl = new Rclass();
                                                    $cls = $cl->getclasses();
                                                    while ($row1 = mysqli_fetch_assoc($cls)) {

                                                        ?>
                                                        <option value="<?php  echo $row1['id'];?>"><?php  echo $row1['classname'];?> </option>

                                                        <?php
                                                    }

                                                    ?>
                                                </select>

                                            </div>

                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                <label style="color: #FFFFFF; " class="control-label">House:</label>
                                                <select class="form-control" id="getstud-house">
                                                    <?php
                                                    $h = new House();
                                                    $hus = mysqli_query($cf->con,"select houses.* from houses where houses.id in (SELECT hid from housem where stfid = $stfid)");
                                                    while ($hs = mysqli_fetch_assoc($hus)) {
                                                        ?>
                                                        <option value="<?= $hs['id'];?>"><?=$hs['des'];?> </option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>

                                            </div>

                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                                <label style="color: #FFFFFF; " class="control-label">Gender House:</label>
                                                <select class="form-control" id="getstud-ghouse">
                                                    <option value="" selected="selected">All</option>
                                                    <?php
                                                    $ghouse = mysqli_query($cf->con,"select * from houses where house_type <> 'genhouse'");
                                                    while ($gh = mysqli_fetch_object($ghouse)) {
                                                        ?>
                                                        <option value="<?= $gh->id;?>"> <?=$gh->des?> (<?=$gh->name?>) </option>
                                                        <?php
                                                    }

                                                    ?>
                                                </select>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="stud-list" class="row">
                        </div>
                    </div></div>
            <?php
            }
       $woftest = false;
           if(mysqli_num_rows($wof)>0){
            $woftest = true;
           ?>
               <div class="mainform content row" style="background: #fff; box-shadow: 0 0 2px ; padding: 0; margin-right: 0 !important; margin-left: 0 !important; margin-bottom: 3em;" id="waec">
                   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color: deepskyblue; padding: 10px;">
                       <div class="row">
                           <div class="col-lg-8 col-md-8 col-sm-8 col-sm-6 col-xs-6">
                               <input type="search" id="waec-search" class="form-control" placeholder="enter name to search..">
                           </div>
                           <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">
                               <select id="waec-ayear" class="form-control">
                                   <?php
                                   $years = mysqli_query($cfg->con,"select distinct(ayear) from stuinfo where form = 3");
                                   while($year = mysqli_fetch_object($years)){
                                       ?>
                                       <option><?=$year->ayear?></option>
                                       <?php
                                   }
                                   ?>
                               </select>
                           </div>
                           <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">
                               <button onclick="addwaec();" class="btn btn-good" style="color: #FFFFFF !important; font-weight: bold; border: 1px solid #fff;">ADD</button>
                               <button id="waecasaddbtn" data-toggle="dropdown" rolw="button" aria-haspopup="true" aria-expanded="false" class="btn btn-good waves-effect waves-button" style="color: #FFFFFF !important;">PRINT <i class="fa fa-caret-down"></i> </button>
                               <ul class="dropdown-menu" aria-labelledby="asaddbtn" >
                                   <li style="cursor:pointer;"><a href="#" onclick="printsubanalysis(); return false;">Subject Base Analysis</a></li>
                                   <li style="cursor:pointer;"><a href="#" onclick="printproganalysis(); return false;">Programme Base Analysis</a></li>
                               </ul>
                           </div>
                       </div>
                   </div>
                   <div id="waec-content"></div></div>
               <div class="mainform row content" style="background: transparent; box-shadow: 0 0 0 ; padding: 0; margin-right: 0 !important; margin-left: 0 !important; margin-bottom: 3em; margin-top: 4em !important;" id="graph-class">
                   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                       <div class="alert alert-info">
                           <div class="row">
                               <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                                   <label style="color: #FFFFFF;" for="" class="control-label">Class</label>
                                   <select name="chart-class" id="chart-class" class="form-control">
                                       <?php
                                       $cls = mysqli_query($cfg->con,"select * from classes where id in(select class from stuinfo where form = '3')");
                                       while($row = mysqli_fetch_object($cls)){
                                           ?>
                                           <option value="<?=$row->id?>"><?=$row->classname?></option>
                                           <?php
                                       }
                                       ?>
                                   </select>
                               </div>
                               <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                                   <label style="color: #FFFFFF;" for="" class="control-label">Academic Year</label>
                                   <select name="" id="chart-ayear" class="form-control">
                                       <?php
                                       $ayear = mysqli_query($cfg->con,"select distinct(ayear) from stuinfo where  form = '3'");
                                       while($row = mysqli_fetch_object($ayear)){
                                           ?>
                                           <option value="<?=$row->ayear?>"><?=$row->ayear?></option>
                                           <?php
                                       }
                                       ?>
                                   </select>
                               </div>
                               <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                                   <label for="" style="color: #FFFFFF;" class="control-label">Chart Type</label>
                                   <select name="" id="chartType" class="form-control">
                                       <option value="bar">Bar Chart</option>
                                       <option value="polarArea">Polar Area</option>
                                       <option value="line">Line Chart</option>
                                       <option value="radar">Radar</option>
                                       <option value="doughnut">Doughnut</option>
                                       <option value="pie">Pie Chart</option>
                                   </select>

                               </div>

                           </div>
                       </div>
                   </div>
                   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                       <div class="panel panel-default" >
                           <div class="panel-body">
                               <div class="row">
                                   <div class="col-lg-10 col-md-10">
                                       <div style="width: 1100px; height: 600px;">
                                           <canvas id="chart-canvas"></canvas>
                                       </div>
                                   </div>
                                   <div class="col-lg-2 col-md-2">

                                       <table class="table table-condensed table-bordered pull-right" style="width: 200px;;">
                                           <tr>
                                               <th class="text-center" colspan="2">Key</th>
                                           </tr>
                                           <tr>
                                               <td>No. Of boys Who passed</td>
                                               <td style="background: rgba(73, 62, 255, 1);">
                                                   &nbsp;
                                                   &nbsp;
                                                   &nbsp;
                                               </td>
                                           </tr>
                                           <tr>
                                               <td>No. Of Girls Who passed</td>
                                               <td style="background: rgba(21, 255, 25, 1);">
                                                   &nbsp;
                                                   &nbsp;
                                                   &nbsp;
                                               </td>
                                           </tr>
                                           <tr>
                                               <td>No. Of Boys Who Failed</td>
                                               <td style="background: rgba(255, 21, 24, 1);">
                                                   &nbsp;
                                                   &nbsp;
                                                   &nbsp;
                                               </td>
                                           </tr>
                                           <tr>
                                               <td>No. Of Girls Who Failed</td>
                                               <td style="background: rgba(255, 140, 31, 1);">
                                                   &nbsp;
                                                   &nbsp;
                                                   &nbsp;
                                               </td>
                                           </tr>

                                       </table>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
               <?php
                    }
                 if($libtest == true){
                ?>
                  <div class="mainform content" style="background: transparent; box-shadow: 0 0 0 ; padding: 0;  margin-right: 0 !important; margin-left: 0 !important; margin-bottom: 3em; margin-top: 3em;" id="mngbooks">
                          <div class="alert alert-info" style="margin: 1px !important;">
                              <div class="row">
                                  <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12"><h3>Manage Books <i class="fa fa-book fa-stack"></i><i class="fa fa-pencil-square-o"></i></h3></div>
                              </div>
                              <div class="row">
                                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
                                      <div style="border-bottom: 1px solid #ccc;"></div>
                                  </div>
                                  <form id="filter-form">
                                      <div class="col-lg-6 col-md-6 col-sm-8 col-xs-8">
                                          <label for="" class="control-label"></label>
                                          <input type="search" name="" id="book-search" class="form-control" placeholder="Search By title,author, shelf or description">
                                      </div>
                                      <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                          <br>
                                          <button onclick="addbook();" style="border:1px solid #fff; color:#fff; background-color:transparent;" type="button" class="wb">Add <i class="fa fa-plus-square"></i> </button>
                                      </div>
                                      <div class="col-lg-1 col-md-1 col-sm-4 col-xs-4">
                                          <br>
                                          <button data-toggle="dropdown" onclick="" style="border:1px solid #fff; color:#fff; background-color:transparent;" type="button" class="wb">Print <i class="fa fa-caret-down"></i> </button>
                                          <ul class="dropdown-menu" aria-labelledby="printoptions" >
                                              <li style="cursor:pointer;"><a href="#" onclick="printbooklist(); return false;">Book List</a></li>
                                              <li style="cursor:pointer;"><a href="#" onclick="printDefaulters(); return false;">Defaulters list</a></li>
                                          </ul>
                                      </div>
                                      <!----------------------------->
                                  </form>
                              </div>
                          </div>
                      <div style="padding:0 !important;"  class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="book-container">


                      </div>
                  </div>




                     <div class="mainform content" style="background: transparent; box-shadow: 0 0 0 ; padding: 0;  margin-right: 0 !important; margin-left: 0 !important; margin-bottom: 3em; margin-top: 3em;" id="lendbooks">
                          <div class="alert alert-info" style="margin: 1px !important;">
                              <div class="row">
                                  <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12"><h3>View Lend History <i class="fa fa-handshake-o"></i><i class="fa fa-history"></i></h3></div>
                              </div>
                              <div class="row">
                                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
                                      <div style="border-bottom: 1px solid #ccc;"></div>
                                  </div>
                                  <form id="filter-form">
                                      <div class="col-lg-6 col-md-6 col-sm-10 col-xs-10">
                                          <label for="" class="control-label"></label>
                                          <input type="search" name="" id="lend-search" class="form-control" placeholder="Search By title,author, shelf or description">
                                      </div>

                                      <div class="col-lg-1 col-md-1 col-sm-2 col-xs-2">
                                          <br>
                                          <button data-toggle="dropdown" onclick="" style="border:1px solid #fff; color:#fff; background-color:transparent;" type="button" class="wb">Print <i class="fa fa-caret-down"></i> </button>
                                          <ul class="dropdown-menu" aria-labelledby="printoptions" >
                                              <li style="cursor:pointer;"><a href="#" onclick="printbooklist(); return false;">Book List</a></li>
                                              <li style="cursor:pointer;"><a href="#" onclick="printDefaulters(); return false;">Defaulters list</a></li>
                                          </ul>
                                      </div>
                                      <!----------------------------->
                                  </form>
                              </div>
                          </div>
                      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:0 !important;" id="lend-container">


                      </div>
                  </div>
                   <?php
                   }
               ?>
            <div class="mainform content row" style="background: transparent; box-shadow: 0 0 0 ; padding: 0;  margin-right: 0 !important; margin-left: 0 !important; margin-bottom: 3em; margin-top: 3em;" id="mngfrm">
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin: 0 !important;">
                   <div class="alert alert-info" style="margin: 1px !important;">
                       <div class="row">
                           <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12"><h3>Manage Form Records <i class="fa fa-users"></i></h3></div>
                       </div>
                       <div class="row">
                           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
                               <div style="border-bottom: 1px solid #ccc;"></div>
                           </div>
                           <form id="filter-form">
                               <!--------------------------------------->
                               <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                   <label style="color: #fff;" class="control-label">Academic Year:</label>
                                   <select class="form-control" id="frm-ayear">
                                       <?php
                                       $ayr5 = mysqli_query($cfg->con,"select distinct(ayear) from stuinfo");
                                       while($yearrow5 = mysqli_fetch_object($ayr5)){
                                           ?>
                                           <option><?= $yearrow5->ayear?></option>
                                           <?php
                                       }
                                       ?>
                                   </select>
                               </div>
                               <!--------------------------------------->
                               <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                   <label style="color: #fff;" class="control-label">Term:</label>
                                   <select class="form-control" id="frm-term">
                                       <option>1</option>
                                       <option>2</option>
                                       <option>3</option>
                                   </select>
                               </div>
                               <!------------------------------------------------------->
                               <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
                                   <label class="control-label" style="color: #fff;">Class:</label>
                                   <select class="form-control" id="frm_class">
                                       <?php
                                       $tskcls5 = mysqli_query($cfg->con,"select id,classname from classes where id in (select clid from frmmaters where stfid = '$stfid')");
                                       while ($clrow5 = mysqli_fetch_object($tskcls5)) {
                                           ?>
                                           <option value="<?php echo $clrow5->id;?>"><?php echo $clrow5->classname;?> </option>
                                           <?php
                                       }
                                       ?>
                                   </select>
                               </div>
                               <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8">
                                   <label for="" class="control-label"></label>
                                   <input type="search" name="" id="frm-search" class="form-control" placeholder="Enter a name to search..">
                               </div>

                               <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                   <br>
                                   <button onclick="addfrm();" style="border:1px solid #fff; color:#fff; background-color:transparent;" type="button" class="wb">Add <i class="fa fa-plus-square"></i> </button>
                               </div>
                               <!----------------------------->
                           </form>
                       </div>
                   </div>
               </div>
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="frm-container">
               </div>
           </div>
        <div class="mainform content row" style="background: transparent; box-shadow: 0 0 0 ; padding: 0;  margin-right: 0 !important; margin-left: 0 !important; margin-bottom: 3em; margin-top: 3em;" id="viewassess">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin: 0 !important;">
        <div class="alert alert-info" style="margin: 1px !important;">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 hidden-sm hidden-xs"><h3>Manage Assessment <span class="glyphicon glyphicon-list-alt"></span></h3></div>
                <br>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <input type="text" class="form-control" placeholder="Search assessment..." id="txtsearch" />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
                    <div style="border-bottom: 1px solid #ccc;"></div>
                </div>
                <form id="filter-form">
                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
                        <label class="control-label" style="color: #FFFFFF;;">Subject:</label>
                        <select class="form-control" id="assess-subjt">
                            <?php
                            $stafid = $_SESSION['id'];
                            $subs = mysqli_query($cfg->con,"select * from subjects where id in (SELECT subid from subas where stfid = '$stafid')");

                            while ($subrow5 = mysqli_fetch_assoc($subs)) {
                                ?>
                                <option value="<?php echo $subrow5['id'];?>"><?php  echo $subrow5['subjdesc'];?> </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
                        <label class="control-label" style="color: #FFFFFF;;">Academic Year:</label>
                        <select class="form-control" id="assess-ayear">
                            <?php
                            $ayear = mysqli_query($cfg->con,"select distinct(ayear) as ayear from stuinfo");
                            while ($yearrow = mysqli_fetch_object($ayear)) {
                                ?>
                                <option value="<?= $yearrow->ayear;?>"><?= $yearrow->ayear;?> </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-2 col-xs-2">
                        <label class="control-label" style="color: #FFFFFF;">Term:</label>
                        <select class="form-control" id="assess-term">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                        <label style="color: #FFFFFF;" class="control-label">Class:</label>
                        <select class="form-control" id="assess_class">
                            <?php
                           $cls = mysqli_query($cfg->con,"select * from classes where id in(SELECT clid from subas where stfid = '$stafid' )");
                            while ($clrow5 = mysqli_fetch_assoc($cls)) {
                                ?>
                                <option value="<?php  echo $clrow5['id'];?>"><?php  echo $clrow5['classname'];?> </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </form>
                <div class="col-lg-1 col-md-1 col-sm-4 col-xs-4">
                    <br>
                    <button id="asaddbtn" data-toggle="dropdown" rolw="button" aria-haspopup="true" aria-expanded="false" class="btn btn-good waves-effect waves-button" style="color: #FFFFFF !important;">ADD <i class="fa fa-caret-down"></i> </button>
                    <ul class="dropdown-menu" aria-labelledby="asaddbtn" >
                        <li style="cursor:pointer;"><a href="#" onclick="getclstaks_inputs(); return false;">Class Test</a></li>
                        <li style="cursor:pointer;"><a onclick="getclsassing_inputs()">Class Exercise</a></li>
<!--                        <li style="cursor:pointer;"><a onclick="getclspwork_inputs()">Project Work</a></li>-->
                        <li style="cursor:pointer;"><a onclick="getclsexam_inputs()">Exam</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                    <br>
                    <button id="asaddbtn" data-toggle="dropdown" rolw="button" aria-haspopup="true" aria-expanded="false" class="btn btn-good waves-effect waves-button" style="color: #FFFFFF !important;">ADD BATCH</B> <i class="fa fa-caret-down"></i> </button>
                    <ul class="dropdown-menu" aria-labelledby="asaddbtn" >
                        <li style="cursor:pointer;"><a href="#" onclick="getbatchclstaks_inputs(); return false;">Class Test</a></li>
                        <li style="cursor:pointer;"><a onclick="getbatchclsassing_inputs()">Class Exercise</a></li>
<!--                        <li style="cursor:pointer;"><a onclick="getbatchclspwork_inputs()">Project Work</a></li>-->
                        <li style="cursor:pointer;"><a onclick="getbatchclsexam_inputs()">Exam</a></li>
                    </ul>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-4 col-xs-4">
                    <br>
                    <button style="color:#fff !important; margin-top:5px" title="Reload the content" data-toggle="tooltip" class="btn btn-good" id="reloadbtn5"> Reload<i  class="fa fa-refresh "></i></button>
                </div><div class="col-lg-1 col-md-1 sm-4 col-xs-4">
                    <br>
                    <button style="color:#fff !important; background-color:transparent; margin-top:5px" title="Print this assessment" data-toggle="tooltip" class="btn btn-good" id="btnprintassess">Print<i  class="fa fa-print "></i></button>                             </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="assess-container">
    </div>
    </div>
   <div  style="background: transparent; box-shadow: 0 0 0 ; padding: 0;  margin-right: 0 !important; margin-left: 0 !important; margin-bottom: 3em; margin-top: 3em;" class="row content mainform" id="myaccount">
    <div id="account-det"></div>
   </div>

           <?php
           if($woftest==true){

           ?>

    <div class="mainform content row" style="background: transparent; box-shadow: 0 0 0 ; padding: 0;  margin-right: 0 !important; margin-left: 0 !important; margin-bottom: 3em; margin-top: 3em;" id="allca">
           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin: 0 !important;">
               <div class="alert alert-info" style="margin: 1px !important;">
                   <div class="row">
                           <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 hidden-sm hidden-xs"><h3>Manage All Assessments <span class="glyphicon glyphicon-list-alt"></span></h3></div>
                           <br>
                           <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                               <input type="text" class="form-control" placeholder="Search assessment..." id="allcasearch" />
                           </div>
                       </div>
                       <div class="row">
                           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
                               <div style="border-bottom: 1px solid #ccc;"></div>
                           </div>
                           <form id="filter-form">
                               <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
                                   <label class="control-label" style="color: #FFFFFF;;">Subject:</label>
                                   <select class="form-control" id="allca-subjt">
                                       <?php
                                       $c5 = new config();
                                       $c5->connect();
                                       $subs5 = new Subjects();
                                       $sub5 = $subs5->getsubjects(NULL);
                                       while ($subrow5 = mysqli_fetch_assoc($sub5)) {
                                           ?>
                                           <option value="<?php echo $subrow5['id'];?>"><?php  echo $subrow5['subjdesc'];?> </option>
                                           <?php
                                       }
                                       ?>
                                   </select>
                               </div>


                               <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
                                   <label class="control-label" style="color: #FFFFFF;;">Academic Year:</label>
                                   <?php
                                        $ys = mysqli_query($c5->con,"select distinct(ayear) from stuinfo order by ayear desc");

                                   ?>
                               <select class="form-control" id="allca-ayear">
                                   <?php

                                    while($ysrow = mysqli_fetch_object($ys)){
                                        ?>
                                        <option value="<?=$ysrow->ayear?>"><?=$ysrow->ayear?></option>
                                        <?php
                                    }
                                   ?>
                               </select>
                               </div>
                               <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                                   <label class="control-label" style="color: #FFFFFF;">Term:</label>
                                   <select class="form-control" id="allca-term">
                                       <option>1</option>
                                       <option>2</option>
                                       <option>3</option>
                                   </select>
                               </div>
                               <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                   <label style="color: #FFFFFF;" class="control-label">Class:</label>
                                   <select class="form-control" id="allca_class">
                                       <?php
                                       $tskcl5 = new Rclass();
                                       $tskcls5 = $tskcl5->getclasses();
                                       while ($clrow5 = mysqli_fetch_assoc($tskcls5)) {
                                           ?>
                                           <option value="<?php  echo $clrow5['id'];?>"><?php  echo $clrow5['classname'];?> </option>
                                           <?php
                                       }

                                       ?>
                                   </select>
                               </div>
                           </form>

                           <!--
                                                     <div class="col-lg-1 col-md-1 col-sm-4 col-xs-4">
                                                        <br>-->
                           <!--                                 <button id="asaddbtn" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" class="btn btn-good waves-effect waves-button" style="color: #FFFFFF !important;">ADD <i class="fa fa-caret-down"></i> </button>-->
                           <!--                                 <ul class="dropdown-menu" aria-labelledby="asaddbtn" >-->
                           <!--                                     <li style="cursor:pointer;"><a href="#" onclick="getclstaks_inputs(); return false;">Class Task</a></li>-->
                           <!--                                     <li style="cursor:pointer;"><a onclick="getclsassing_inputs()">Assignment</a></li>-->
                           <!--                                     <li style="cursor:pointer;"><a onclick="getclspwork_inputs()">Project Work</a></li>-->
                           <!--                                     <li style="cursor:pointer;"><a onclick="getclsexam_inputs()">Exam</a></li>-->
                           <!--


                                                        </div>



                                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                           <!--                                 <br>-->
                           <!--                                 <button id="asaddbtn" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" class="btn btn-good waves-effect waves-button" style="color: #FFFFFF !important;">ADD BATCH</B> <i class="fa fa-caret-down"></i> </button>-->
                           <!--                                 <ul class="dropdown-menu" aria-labelledby="asaddbtn" >-->
                           <!--                                     <li style="cursor:pointer;"><a href="#" onclick="getbatchclstaks_inputs(); return false;">Class Task</a></li>-->
                           <!--                                     <li style="cursor:pointer;"><a onclick="getbatchclsassing_inputs()">Assignment</a></li>-->
                           <!--                                     <li style="cursor:pointer;"><a onclick="getbatchclspwork_inputs()">Project Work</a></li>-->
                           <!--                                     <li style="cursor:pointer;"><a onclick="getbatchclsexam_inputs()">Exam</a></li>-->
                           <!--
                           </ul>
                           </div>
                           -->
                           <div class="col-lg-1 col-md-1 col-sm-4 col-xs-4">
                               <br>
                               <button onclick="$('#allca_class').change();" style="color:#fff !important; margin-top:5px" title="Reload the content" data-toggle="tooltip" class="btn btn-good" > Reload<i  class="fa fa-refresh "></i></button>
                           </div><div class="col-lg-1 col-md-1 sm-4 col-xs-4">
                               <br>
                               <button onclick="print_assess();" style="color:#fff !important; background-color:transparent; margin-top:5px" title="Print this assessment" data-toggle="tooltip" class="btn btn-good" id="btnprintasses">Print<i  class="fa fa-print "></i></button>                             </div>
                       </div>
                   </div>
               </div>
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="allca-container">



               </div>
           </div>

<?php

}


?>










</div>
<a href="#" class="hidden-sm hidden-xs btn btn-circle floating-left btn-bg-good waves-effect waves-light home-btn"><i class="fa fa-home"></i></a>
        <script type="text/javascript">
            $(document).ready(function(){
                Waves.init();
                Waves.attach('.fa', ['waves-circle']);
                Waves.attach('.tile', ['waves-float','waves-light']);
                Waves.attach('button', ['waves-button']);
                $("div.dropzone").dropzone(
                    { url: "./dropfile.php",
                        acceptedFiles: "image/*",
                        addRemoveLinks:true,
                        dictDefaultMessage:"drop photo here or click to upload",
                        dictRemoveFile:"Remove photo",
                        resizeWidth:"180",
                        resizeHeight:"200",
                        resizeMethod:"crop",
                        capture:null,
                        removedfile:function(file){
                            $.get("rmphoto.php?file=" +file.name,function(){}).done(function(){
                                $("#photo").val("dpic/photo.jpg");
                                var previewElement;
                                return (previewElement = file.previewElement)!= null ?
                                    (previewElement.parentNode.removeChild(file.previewElement)) :(void 0);
                            });
                        },
                        maxFiles:1,
                        accept:function(file,done){
                            $("#photo").val("temppic/"+file.name);
                            done();
                        }
                    });
                $("button").tooltip();
                $("li").tooltip();
                $("a").tooltip();
                $("#assess-ayear").change(function(){
                    $("#assess_class").change();
                });
                $("#assess-subjt").change(function(){
                    $("#assess_class").change();
                });
                $("#assess-term").change(function(){
                    $("#assess_class").change();
                });
                $("#reloadbtn5").click(function(){

                    $("#assess_class").change();

                });
                //---------------------------
                mkayear();
                var addtest = localStorage.addtest;
                $(".startmenu .col-lg-3, .tile").sortable();
                var d = null;
                $("#dob,#dor").datepicker({
                    changeMonth:true,
                    changeYear:true,
                    showAnim:"slideDown",
                    dateFormat:"yy-m-d",
                    currentDate:true
                });

                //---------------------------------------------------------------------------------------
                var d = new Date();
                var td = d.getDate();
                var tmon = d.getMonth()+1;
                var tyea = d.getFullYear();
                $("#dor").val(tyea+"-"+tmon+"-"+td);


                // showstart();


                //-------------------------------------------------------------------------------------------------------------------------
                $("#dept").change(function(){
                    if($("#dept").val()!=="Select"){
                        var tmpop ="<option>Getting classes</option>";
                        var me = $(this);
                        $.get("getclassbydep.php?depid="+me.val(),null,function(d){
                            $("#clas").html(d);
                        }).done(function(d){
                        });
                    } else{
                        $("#clas").html("");
                    }
                });

                //------------------------------------------------------------------------------------------------------------------------
                $(".add-btn").click(function(e){
                    if(addtest === "depts"){
                        var temp ="<form><div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>";
                        temp+="<label class='control-label' for ='depname'>Department Name/Description</label>";
                        temp+="<input type ='text' class='form-control' placeholder='Enter department description' id='depname' />";
                        temp+="</form></div>";
                        BootstrapDialog.show({
                            title:"Add a Program/department",
                            message:temp,
                            buttons:[{label:"SAVE",cssClass:"btn-good waves-button waves-effect",action:function(d){

                                if($("#depname").val()===""){

                                    $("#depname").focus();

                                }else{

                                    $.get("savedep.php?depname="+$("#depname").val().toString(),null, function(data){

                                        getdepts();
                                        $("#depname").val("");
                                        $("#depname").focus();
                                        Snarl.addNotification({
                                            title:"SAVED",
                                            text:"Programe/Department creates successfully",
                                            icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle'></i>",
                                            timeout:3000
                                        });
                                        $(".snarl-notification").addClass('snarl-success');



                                    });



                                }


                            }}]


                        });






                    }else if(addtest==="classes"){

                        $.get("adclass_inputs.php",null,function(data){
                        }).done(function(data){

                            BootstrapDialog.show({
                                title:"Add a class",
                                message:data,
                                buttons:[{label:"SAVE",cssClass:"btn-good waves-button waves-effect",action:function(d){

                                    if(!$("#classname").val()){
                                        $("#classname").focus();

                                        return false;
                                    }


                                    $.get("saveclass.php?dpid="+$("#dep").val()+"&classname="+$("#classname").val(),null,function(data){
                                    }).done(function(data){
                                        $("#classname").val("");
                                        $("#classname").focus();
                                        getclass();
                                        Snarl.addNotification({
                                            title:"SAVED",
                                            text:data,
                                            icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle'></i>",
                                            timeout:3000
                                        });
                                        $(".snarl-notification").addClass('snarl-success');



                                    });

                                }}]

                            });



                        });

                    }else if(addtest==="subjts") {
                        var temp ="<form><div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>";
                        temp+="<label class='control-label' for ='subname'>Subject Name</label>";
                        temp+="<input type ='text' class='form-control' placeholder='Enter subject description' id='subname' />";
                        temp+="<label class='control-label' for ='subtype'>Subject Type</label>";
                        temp+="<select class='form-control' id='subtype'>";
                        temp+="<option>Core Subject</option>";
                        temp+="<option>Elective Subject</option>";
                        temp+="</select>";
                        temp+="</form></div>";
                        BootstrapDialog.show({
                            title:"Add a Subject",
                            message:temp,
                            buttons:[{label:"SAVE",cssClass:"btn-good waves-button waves-effect",action:function(d){
                                if($("#subname").val()===""){
                                    $("#subname").focus();
                                }else{

                                    $.get("savesub.php?subname="+$("#subname").val().toString()+"&type="+$("#subtype").val(),null, function(data){

                                        $("#subname").val("").focus();
                                        getsubjts();
                                        Snarl.addNotification({
                                            title:"SAVED",
                                            text:data,
                                            icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle'></i>",
                                            timeout:3000
                                        });
                                        $(".snarl-notification").addClass('snarl-success');


                                    });


                                }

                            }}]

                        });


                        //---------------------------------------------------adding house
                    }else if(addtest==="house"){

                        var temp ="<form><div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>";
                        temp+="<label class='control-label' for ='name'>House Name</label>";
                        temp+="<input type ='text' class='form-control' placeholder='Enter house Name' id='name' />";
                        temp+="<label class='control-label' for ='subtype'>House Description</label>";
                        temp+="<input type='text' class='form-control' placeholder='Enter description' id='des'>";
                        temp+="</form></div>";
                        BootstrapDialog.show({
                            title:"Create New House",
                            message:temp,

                            buttons:[{label:"SAVE",cssClass:"btn-good waves-button waves-effect",action:function(d){

                                if($("#name").val()==="" || $("#des").val()===""){
                                    $("#name").focus();
                                }else{

                                    $.get("savehouse.php?name="+$("#name").val().toString()+"&des="+$("#des").val(),null, function(data){
                                        gethouses();
                                        $("#name").val("");
                                        $("#des").val("");
                                        $("#name").focus();
                                        Snarl.addNotification({
                                            title:"SAVED",
                                            text:data,
                                            icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle'></i>",
                                            timeout:3000
                                        });
                                        $(".snarl-notification").addClass('snarl-success');

                                    });
                                }
                            }}]
                        });

                    }else if(addtest === "staff"){
                        //starting
                        var temp ="<form><div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>";
                        temp+="<div class='row'>";
                        temp+="<div class='col-lg-6 col-md-6 col-sm-12 col-xs-12'>";
                        temp+="<label class='control-label' for ='stffname'>First Name</label>";
                        temp+="<input type ='text' class='form-control' placeholder='Enter first Name' id='stffname' />";
                        temp+="</div>";
                        temp+="<div class='col-lg-6 col-md-6 col-sm-12 col-xs-12'>";
                        temp+="<label class='control-label' for ='stflname'>Last Name</label>";
                        temp+="<input type='text' class='form-control' placeholder='Enter Last Name' id='stflname' />";
                        temp+="</div> </div>";
                        temp+="<div class='row'>";
                        temp+="<div class='col-lg-4 col-md-4 col-sm-12 col-xs-12'>";
                        temp+="<label class='control-label' for ='gender'>Gender</label>";
                        temp+="<select class='form-control' id='gender'><option>Male</option><option>Female</option></select>";
                        temp+="</div>";
                        temp+="<div class='col-lg-4 col-md-4 col-sm-12 col-xs-12'>";
                        temp+="<label class='control-label' for ='cont'>Contact Number</label>";
                        temp+="<input type='text' class='form-control' placeholder='Enter staff phone number' id='cont'><br/>";
                        temp+="</div>" ;
                        temp+="<div class='col-lg-4 col-md-4 col-sm-12 col-xs-12'>";
                        temp+="<label class='control-label' for ='rank'>Rank</label>";
                        temp+="<select class='form-control' id='rank'><option>Senior Sup't</option><option>Prin. Sup't</option><option>Assist. Dir. ii</option><option>Assist. Dir. I</option><option>Dep. Dir.</option><option>Dir. II</option><option>Dir. I</option></select>";
                        temp+="</div> </div> <div class='row'>";
                        temp+="<div class='col-lg-3 col-md-3 col-sm-12 col-xs-12'>";
                        temp+="<label class='control-label' for ='stfid'>Staff ID No.</label>";
                        temp+="<input type='text' class='form-control' placeholder='Enter staff ID' id='stfid'><br/>";
                        temp+="</div>";
                        temp+="<div class='col-lg-3 col-md-3 col-sm-12 col-xs-12'>";
                        temp+="<label class='control-label' for ='sdob'>D.O.B</label>";
                        temp+="<input type='date' class='form-control' id='sdob' placeholder='Select date of birth'/>";
                        temp+="</div>";
                        temp+="<div class='col-lg-3 col-md-3 col-sm-12 col-xs-12'>";
                        temp+="<label class='control-label' for ='regno'>Registered No.</label>";
                        temp+="<input type='text' class='form-control' placeholder='Enter registered no.' id='regno'><br/>";
                        temp+="</div>";
                        temp+="<div class='col-lg-3 col-md-3 col-sm-12 col-xs-12'>";
                        temp+="<label class='control-label' for ='stfid'>SSNIT No.</label>";
                        temp+="<input type='text' class='form-control' placeholder='Enter SSNIT Number' id='ssnid'><br/>";
                        temp+="</div>";
                        temp+= "</div>";
                        temp+="<div class='row'>";
                        temp+="<div class='col-lg-4 col-md-4 col-sm-12 col-xs-12'>";
                        temp+="<label class='control-label' for ='aqaul'>Academic Qualification</label>";
                        temp+="<input type='text' class='form-control' placeholder='Enter Qualification' id='aqual'><br/>";
                        temp+="</div>";
                        temp+="<div class='col-lg-4 col-md-4 col-sm-12 col-xs-12'>";
                        temp+="<label class='control-label' for ='pqual'>Professional Qualification</label>";
                        temp+="<input type='text' class='form-control' id='pqual' placeholder='Enter qualification'/>";
                        temp+="</div>";
                        temp+="<div class='col-lg-4 col-md-4 col-sm-12 col-xs-12'>";
                        temp+="<label class='control-label' for ='appdate'>Date Of First Appointment</label>";
                        temp+="<input type='date' class='form-control' placeholder='Enter Appointment date' id='appdate'><br/>";
                        temp+="</div> </div>";
                        temp+="<div class='row'>";
                        temp+="<div class='col-lg-4 col-md-4 col-sm-12 col-xs-12'>";
                        temp+="<label class='control-label' for ='assdate'>Assumption Of Duty (Date)</label>";
                        temp+="<input type='date' class='form-control' placeholder='select Date' id='assdate'><br/>";
                        temp+="</div>";
                        temp+="<div class='col-lg-4 col-md-4 col-sm-12 col-xs-12'>";
                        temp+="<label class='control-label' for ='bankname'>Associated Bank</label>";
                        temp+="<input type='text' class='form-control' placeholder='Enter Bank Name' id='bankname'><br/>";
                        temp+="</div> ";
                        temp+="<div class='col-lg-4 col-md-4 col-sm-12 col-xs-12'>";
                        temp+="<label class='control-label' for ='accno'>Account Number</label>";
                        temp+="<input type='text' class='form-control' placeholder='Enter Bank Name' id='accno'><br/>";
                        temp+="</div></div>";
                        temp+="<div class='alert alert-info' style='padding:2px;'>Account information <span class='glyphicon glyphicon-hand-down'></span><br/>";
                        temp+="<div class='row'>";
                        temp+="<div class='col-lg-6 col-md-6 col-sm-12 col-xs-12'>";

                        temp+="<label class='control-label' for ='uname' style='color: #FFFFFF;'>User Name</label>";
                        temp+="<input type ='text' class='form-control' placeholder='Enter user Name' id='uname' />";
                        temp+="</div>";
                        temp+="<div class='col-lg-6 col-md-6 col-sm-12 col-xs-12'>";

                        temp+="<label class='control-label' style='color: #FFFFFF;' for ='upass'>Password</label>";
                        temp+="<input type='password' class='form-control' placeholder='Enter staff password' id='upass'>";
                        temp+="</div> </div>";
                        temp+="<div class='row'>";
                        temp+="<div class='col-lg-6 col-md-6 col-sm-12 col-xs-12'>";
                        temp+="</div>";
                        temp+="<div class='col-lg-6 col-md-6 col-sm-12 col-xs-12'>";
                        temp+="<label class='control-label' style='color: #FFFFFF;' for ='cpass'>Confirm Password</label>";
                        temp+="<input type='password' class='form-control' placeholder='Enter staff password again' id='cpass'>";
                        temp+="</div> </div>";
                        temp+="</form>";
                        BootstrapDialog.show({
                            title:"Register Staff",
                            message:temp,
                            size:"size-wide",
                            buttons:[{label:"SAVE",cssClass:"btn-good waves-button waves-effect",action:function(d){

                                if(!($("#upass").val()=== $("#cpass").val())){

                                    Snarl.addNotification({
                                        title:"ERROR",
                                        text:"Passwords do not match, please check and try again",
                                        icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                                        timeout:3000
                                    });
                                    $(".snarl-notification").addClass('snarl-error');

                                    return false;

                                }

                                if(!$("#stffname").val() || !$("#stflname").val() || !$("#cont").val() || !$("#uname").val() || !$("#upass").val() || !$("#cpass").val() ){

                                    Snarl.addNotification({
                                        title:"ERROR",
                                        text:"A field is left blank, please check and try again",
                                        icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                                        timeout:3000
                                    });
                                    $(".snarl-notification").addClass('snarl-error');
                                    return false;
                                }else{

                                    var progress = Snarl.addNotification({
                                        title:"PROCCESSING",
                                        text:"Please Wait...",
                                        icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-circle-notch fa-spin'></i>",
                                        timeout:3000
                                    });
                                    $(".snarl-notification").addClass('snarl-info');

                                    $.get("savestaff.php?fname="+$("#stffname").val().toString()+"&lname="+$("#stflname").val()+"&gender="+$("#gender").val()+"&cont="+$("#cont").val()+"&uname="+$("#uname").val()+"&upass="+$("#upass").val()+"&rank="+$("#rank").val()+"&stfid="+$("#stfid").val()+"&sdob="+$("#sdob").val()+"&regno="+$("#regno").val()+"&aqual="+$("#aqual").val()+"&pqual="+$("#pqual").val()+"&appdate="+$("#appdate").val()+"&assdate="+$("#assdate").val()+"&bankname="+$("#bankname").val()+"&accno="+$("#accno").val()+"&ssnid="+$("#ssnid").val(),null, function(data){


                                    }).done(function(data){
                                        d.close();
                                        getstaff();
                                        Snarl.removeNotification(progress);
                                        Snarl.addNotification({
                                            title:"SAVED",
                                            text:data,
                                            icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle'></i>",
                                            timeout:3000
                                        });
                                        $(".snarl-notification").addClass('snarl-success');


                                    }).error(function(){

                                        Snarl.removeNotification(progress);
                                        Snarl.addNotification({
                                            title:"ERROR",
                                            text:"Could not save staff, please try again",
                                            icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                                            timeout:3000
                                        });
                                        $(".snarl-notification").addClass('snarl-error');

                                    });



                                }


                            }},{label:"CANCEL",cssClass:"btn-bad waves-button waves-effect",action:function(d){

                                d.close();

                            }}]
                        });

                        //edding
                    }else if(addtest === "accounts"){

                        //add account--------------------------------------------

                        var temp ="<form><div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>";
                        temp+="<div class='row'>";
                        temp+="<div class='col-lg-6 col-md-6 col-sm-6 col-xs-6'>";
                        temp+="<label class='control-label' for ='stffname'>First Name</label>";
                        temp+="<input type ='text' class='form-control' placeholder='Enter first Name' id='adfname' />";
                        temp+="</div>";
                        temp+="<div class='col-lg-6 col-md-6 col-sm-6 col-xs-6'>";
                        temp+="<label class='control-label' for ='stflname'>Last Name</label>";
                        temp+="<input type='text' class='form-control' placeholder='Enter Last Name' id='adlname' />";
                        temp+="</div> </div>";
                        temp+="<div class='row'>";
                        temp+="<div class='col-lg-6 col-md-6 col-sm-6 col-xs-6'>";
                        temp+="<label class='control-label' for ='gender'>Gender</label>";
                        temp+="<select class='form-control' id='adgender'><option>Male</option><option>Female</option></select>";
                        temp+="</div>";
                        temp+="<div class='col-lg-6 col-md-6 col-sm-6 col-xs-6'>";
                        temp+="<label class='control-label' for ='cont'>Contact Number</label>";
                        temp+="<input type='text' class='form-control' placeholder='Enter admin phone number' id='adcont'><br/>";
                        temp+="</div> </div>";
                        temp+="<div class='alert alert-info' style='padding:2px;'>Account information <span class='glyphicon glyphicon-hand-down'></span><br/>";
                        temp+="<div class='row'>";
                        temp+="<div class='col-lg-6 col-md-6 col-sm-6 col-xs-6'>";

                        temp+="<label class='control-label' for ='uname'>User Name</label>";
                        temp+="<input type ='text' class='form-control' placeholder='Enter user Name' id='aduname' />";
                        temp+="</div>";
                        temp+="<div class='col-lg-6 col-md-6 col-sm-6 col-xs-6'>";

                        temp+="<label class='control-label' for ='upass'>Admin Password</label>";
                        temp+="<input type='password' class='form-control' placeholder='Enter admin password' id='adupass'>";
                        temp+="</div> </div>";
                        temp+="<div class='row'>";
                        temp+="<div class='col-lg-6 col-md-6 col-sm-6 col-xs-6'>";
                        temp+="</div>";
                        temp+="<div class='col-lg-6 col-md-6 col-sm-6 col-xs-6'>";

                        temp+="<label class='control-label' for ='cpass'>Confirm admin Password</label>";
                        temp+="<input type='password' class='form-control' placeholder='Enter admin password again' id='adcpass'>";
                        temp+="</div> </div>";
                        temp+="</form>";
                        BootstrapDialog.show({
                            title:"Create Admin. Account",
                            message:temp,
                            buttons:[{label:"CREATE",cssClass:"btn-good waves-button waves-effect",action:function(d){

                                if(!($("#adupass").val()=== $("#adcpass").val())){

                                    Snarl.addNotification({
                                        title:"ERROR",
                                        text:"Passwords do not match, please check and try again",
                                        icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                                        timeout:3000
                                    });
                                    $(".snarl-notification").addClass('snarl-error');
                                    return false;

                                }

                                if(!$("#adfname").val() || !$("#adlname").val() || !$("#adcont").val() || !$("#aduname").val() || !$("#adupass").val() || !$("#adcpass").val()){

                                    Snarl.addNotification({
                                        title:"ERROR",
                                        text:"A field is left blank, please check and try again",
                                        icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                                        timeout:3000
                                    });
                                    $(".snarl-notification").addClass('snarl-error');

                                    return false;
                                }else{

                                    var progress = Snarl.addNotification({
                                        title:"PROCCESSING",
                                        text:"Please Wait...",
                                        icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-circle-notch fa-spin'></i>",
                                        timeout:3000
                                    });
                                    $(".snarl-notification").addClass('snarl-info');
                                    $.get("adadmin.php?fname="+$("#adfname").val().toString()+"&lname="+$("#adlname").val()+"&gender="+$("#adgender").val()+"&cont="+$("#adcont").val()+"&uname="+$("#aduname").val()+"&upass="+$("#adupass").val(),null, function(data){
                                    }).done(function(data){
                                        d.close();
                                        getaccounts();
                                        Snarl.removeNotification(progress);
                                        Snarl.addNotification({
                                            title:"ACCOUNT CREATED",
                                            text:data,
                                            icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle'></i>",
                                            timeout:3000
                                        });
                                        $(".snarl-notification").addClass('snarl-success');

                                    }).error(function(){
                                        Snarl.removeNotification(progress);
                                        Snarl.removeNotification(progress);
                                        Snarl.addNotification({
                                            title:"ERROR",
                                            text:"Could not creat account, please try again",
                                            icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                                            timeout:3000
                                        });
                                        $(".snarl-notification").addClass('snarl-error');

                                    });
                                }



                            }}]
                        });



                    }




                });

                $(".tile").click(function(){
                    var target = $(this).attr("data-get");
                    localStorage.addtest = target;
                    localStorage.dget = target;
                    addtest = localStorage.addtest;

                });


                $(window).on('hashchange', function(e){
                    var rawtag = window.location.hash;
                    var target = window.location.hash.replace('/','');
                    localStorage.tget = target;
                    testtarget = window.location.hash.replace('#/','');
                    if(testtarget != "regstaf"){
                        $(".main-search-cont").slideUp(100);
                    }
                    if($(".bootstrap-dialog").length>0){
                        window.location = rawtag;
                        cloasedlgs();

                        return false;
                    }else {
                        if (window.location.hash && testtarget) {
                            $("#nav-back").fadeIn(200);
                            var dget = localStorage.dget;
                            performshow(target, dget);
                        } else {
                            $("#nav-back").fadeOut(200);
                            $(".content").hide(1);
                            showstart();
                        }
                    }


                }).trigger('hashchange');

                $(".submit-btn").click(function(){
                    var ins = $("#frmregdept :input");
                    ins = ins.toArray();
                    var id = $(this).attr("data-id").toString();
                    d = saverecs(id);

                });
                $(".home-btn").click(function(){
                    addtest=null;

                    closewindow(".content");


                });
            });
        </script>


    </body>
</html>
<div class="search-pane">
    <div class="search-header">
        <button type="button" class="btn btn-bad waves-effect waves-circle waves-light waves-float pull-left search-close" style="border: none; font-weight: bold; font-size: 22px; color: #fff;">&times;</button>
        <p class="search-pane-title">SEARCH</p>
    </div>
    <div class="search-input-container">
        <input type="search" class="search-box" placeholder="Search..." />
    </div>
    <div class="search-content">
    </div>
</div>

<!--/dialogs--->