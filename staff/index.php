<?php
session_start();
if (!$_SESSION['uname'] && !$_SESSION['id']) {
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
$dline = mysqli_fetch_object(mysqli_query($cfg->con, "select * from deadline"));
$stafid = $_SESSION['id'];
$frmtes = mysqli_query($cfg->con, "select * from frmmaters where stfid = '$stafid'");
$shm = mysqli_query($cfg->con, "select * from shm where stfid = '$stafid'");
$hm = mysqli_query($cfg->con, "select * from housem where stfid = '$stafid'");
$wof = mysqli_query($cfg->con, "select * from woff where stfid = '$stafid'");
$librian = mysqli_query($cfg->con, "select * from librian where stfid = '$stafid'");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Report Master| Staff</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">
    <meta name="theme-color" content="#17a2b8">
    <link rel="icon" href="img/rmicon.png"/>
    <link href="../admin/css/ui-lightness/jquery-ui-1.10.4.min.css" rel="stylesheet" type="text/css"/>
    <link href="../admin/start/jquery-ui.theme.min.css" rel="stylesheet" type="text/css"/>
    <link href="../admin/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="../admin/css/dropzone.min.css" rel="stylesheet" type="text/css"/>
    <link href="../admin/css/basic.min.css" rel="stylesheet" type="text/css"/>
    <link href="../admin/css/snarl.min.css" rel="stylesheet" type="text/css"/>
    <link href="../admin/css/waves.min.css" rel="stylesheet" type="text/css"/>
    <link href="../admin/css/bootstrap-dialog.min.css" rel="stylesheet"/>
    <link href="../admin/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="../admin/css/mdb.min.css" rel="stylesheet"/>
    <link href="../admin/css/mystyle.css" rel="stylesheet"/>
</head>
<body>
<nav class="navbar navbar-expand-md fixed-top bg-info p-0 ">
    <div class="container-fluid">

        <div class="navbar-header ">
            <a class="navbar-brand hidden-md  ml-3 float-left" id="nav-back" href="#"><i
                        class="fa fa-long-arrow-left text-white"> </i></a>
            <a onclick="return false;" style="overflow: hidden; font-weight: bold;" class="navbar-brand text-white ml-sm-3"
               href="#"><?= $_SESSION['fname'] . " " . $_SESSION['lname'] . " [" . $_SESSION['utype'] . "]"; ?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav ml-auto p-0">
                <?php
                if ($dline->status == "ON") {
                    ?>
                    <li class="nav-item"><a class="nav-link text-white" style="color: red !important;" href="#about">Deadline: <?= $dline->ddate; ?> <i
                                    class="fa fa-clock-o"></i></a></li>
                    <?php
                }
                ?>
                <?php
                    if(mysqli_num_rows($wof)>0){
                        ?>
                        <li class="nav-item text-center" title="Print record entry Log" data-toggle="tooltip"><a
                                    onclick="entrylog(); return false;" style="color: #fff;" href="#" class=" nav-link"><i
                                        class="fa fa-arrow-down"></i><i class="fa fa-arrow-up"></i>
                            </a></li>

                        <?php
                    }
                ?>
                <li class="nav-item"><a class="nav-link text-white" onclick="return false;" id="aboutmnu" href="#about"><i class="fa fa-info-circle"></i></a></li>
                <li class="nav-item"><a class="nav-link text-white" onclick="return false;" id="hlpmnu" href="#Help"><i class="fa fa-question-circle"></i> </a></li>
                <li class="nav-item"><a class="nav-link text-white" onclick="logout(); return false;" href="#logout"><i class="fa fa-sign-out"></i></a></li>
                <?php if (mysqli_num_rows($shm) > 0) {
                    ?>
                    <li class="nav-item"><a class="nav-link text-white" id="searchbtn" href="#" onclick="showsearch(); return false;"><i style="font-weight: bolder;"
                                                                                            class="fa fa-search"></i></a>
                    </li>
                    <?php
                }

                ?>
            </ul>
        </div>

        <?php if (mysqli_num_rows($shm) > 0) {
        ?>
            <button id="searchbtn" onclick="showsearch();" type="button" class="navbar-toggler collapsed"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <i class="fa fa-search text-white"></i>
            </button>

            <?php
                }
                ?>
    </div>
</nav>

<input type="hidden" id="global_stfid" value="<?= $_SESSION['id'] ?>">
<input type="hidden" id="global_usertype" value="<?= $_SESSION['utype'] ?>">
<div class="container-fluid" style="margin-bottom:4em;">
    <!-- start menu -->
    <div class="startmenu" style="display: none;">
        <div class="tile-group">
            <div class="row hidden-xs hidden-sm">
                <div class="col-lg-10 col-md-10">
                    <span class="pull-left tile-group-heading">General</span>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-6">
                    <a href="#/viewassess" style="text-decoration: none;">
                        <div class="tile tile-violet" data-id="#viewassess" data-get="assess">
                            <span class="fa fa-list-alt tile-icon"></span>
                            <p class="title">Manage Assessments</p>
                            <div class="detail visible-lg visible-md font-small">
                                Manage assessment records of students you teach.
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                    <a href="#/myaccount" style="text-decoration: none;">
                        <div class="tile tile-red" data-id="#myaccount" data-get="getaccount">
                            <i class="fa fa-lock tile-icon"></i>
                            <p class="title">My Account</p>
                            <div class="detail visible-lg visible-md font-small">
                                Manage your user account details
                            </div>
                        </div>
                    </a>
                </div>
                <?php
                if (mysqli_num_rows($frmtes) > 0) {
                    ?>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                        <a href="#/mngfrm" style="text-decoration: none;">

                            <div class="tile tile-blue" data-id="#mngfrm" data-get="frmdata">

                                <i class="fa fa-users tile-icon"></i>

                                <p class="title">Manage Form Records</p>

                                <div class="detail visible-lg visible-md font-small">
                                    Manage students' attendance,attitude,interest, etc.
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
                }
                if (mysqli_num_rows($shm) > 0 || mysqli_num_rows($hm) > 0) {
                    ?>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                        <a href="#/viewstuds" style="text-decoration: none;">
                            <div class="tile tile-deepblue" data-id="#viewstuds" data-get="getstud">
                                <i class="fa fa-graduation-cap tile-icon"></i>
                                <p class="title">View Students</p>
                                <div class="detail visible-lg visible-md">
                                    View the students that have been registered in the system
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                        <a href="#/viewexeats" style="text-decoration: none;">

                            <div class="tile tile-grey" data-id="#viewexeats" data-get="exeats">

                                <span class="fa fa-id-card-o tile-icon"></span>

                                <p class="title">Exeat Records</p>

                                <small class="detail hidden-sm font-small">
                                    View exeats only signed by you
                                </small>
                            </div>
                        </a>
                    </div>
                    <?php
                }
                if (mysqli_num_rows($wof) > 0) {
                    ?>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                        <a href="#/allca" style="text-decoration: none;">
                            <div class="tile tile-green" data-id="#allca" data-get="allca">
                                <i class="fa fa-linode tile-icon"></i>
                                <p class="title">Manage All CA Records</p>
                                <div class="detail visible-lg visible-md font-small">
                                    Manage assesment records recorded by various subject teachers
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                        <a href="#/waec" style="text-decoration: none;">
                            <div class="tile tile-green-yellow" data-id="#waec" data-get="waec">
                                <i class="fa fa-balance-scale tile-icon"></i>
                                <p class="title">Manage WAEC Records</p>
                                <div class="detail visible-lg visible-md font-small">
                                    Manage WASSCE results of final year students
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                        <a href="#/graph-class" style="text-decoration: none;">
                            <div class="tile tile-black" data-id="#graph-class" data-get="graphclass">
                                <i class="fa fa-pie-chart tile-icon"></i>
                                <p class="title">Graphical Analysis by Class</p>
                                <div class="detail visible-lg visible-md font-small">
                                    View the graphical representation of waec records under a selected class
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
                }
                if (mysqli_num_rows($librian) > 0) {
                    $libtest = true;
                    ?>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-6">
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

                    <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                        <a href="#/lendbooks" style="text-decoration: none;">
                            <div data-id="#lendbooks" data-get="lendbooks" class="tile tile-orange">
                                <span class="fa fa-handshake-o tile-icon"></span> <sup><i
                                            class="fa fa-history"></i></sup>
                                <p class="title">Lend History</p>
                                <div class="detail visible-lg visible-md">
                                    View List of students with books in their posession
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
                } else {
                    $libtest = false;

                }
                ?>


            </div>
        </div>
    </div>
    <?php
    if (mysqli_num_rows($shm) > 0) {
        ?>

        <div class="mainform content" style="background: transparent; box-shadow: 0 !important;" id="viewexeats">

        </div>
        <div class="mainform content row"
             style="background: transparent; box-shadow: 0 0 0 ; padding: 0; margin-right: 0 !important; margin-left: 0 !important; margin-bottom: 3em; margin-top: 7em;"
             id="schres">
        </div>
        <div class="mainform content row"
             style="background: transparent; box-shadow: 0 0 0 ; padding: 0; margin-right: 0 !important; margin-left: 0 !important; margin-bottom: 3em; margin-top: 3em;"
             id="viewstuds">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin: 0 !important;">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin: 0 !important;">
                        <div class="alert alert-info hidden-print" style="margin: 1px !important; box-shadow: 0 0 2px;">
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 hidden-xs hidden-sm"><h3>View Students
                                        <i class="fa fa-users"></i></h3></div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                                    <button id="filter-btn" class="btn btn-good"
                                            style="color:#fff !important; margin-top:20px !important;" id="filter-btn">
                                        <i class="fa fa-filter "></i>Filter Students
                                    </button>
                                    <button onclick="allprint();" class="btn btn-good hidden-sm hidden-xs"
                                            style="color:#fff !important;"><i class="fa fa-print"></i> Print
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div style="border-bottom: 1px solid #ccc;"></div>
                                </div>
                                <form id="filter-form" style="display: none;">
                                    <div class="row">
                                        <div class="col-lg-2 col-md-2 col-sm-6 col-6">
                                            <label class="control-label text-white">Programe:</label>
                                            <select class="form-control" id="getstud-pro">
                                                <option value="" selected="selected">All</option>
                                                <?php
                                                $de = new Department();
                                                $ds = $de->getdpts();
                                                while ($row1 = mysqli_fetch_assoc($ds)) {
                                                    ?>
                                                    <option value="<?php echo $row1['id']; ?>"><?php echo $row1['depname']; ?> </option>

                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-1 col-md-1 col-sm-2 col-2">
                                            <label style="color:#fff;" class="control-label">Gender</label>
                                            <select id="filter-gender" class="form-control">
                                                <option value="">All</option>
                                                <option value="Female">Female</option>
                                                <option value="Male">Male</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-1 col-md-1 col-sm-3 col-xs-3">
                                            <label style="color: #FFFFFF; " class="control-label">Aca. Year</label>
                                            <select class="form-control" id="getstud-ayear">
                                                <option value="" selected="selected">All</option>
                                                <?php
                                                $cf = new config();
                                                $cf->connect();
                                                $ayear = mysqli_query($cf->con, "select DISTINCT(ayear) from stuinfo ORDER by ayear ASC ");
                                                while ($row1 = mysqli_fetch_assoc($ayear)) {
                                                    ?>
                                                    <option value="<?php echo $row1['ayear']; ?>"><?php echo $row1['ayear']; ?> </option>

                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-1 col-md-1 col-sm-3 col-xs-3">
                                            <label style="color: #FFFFFF; " class="control-label">Form</label>
                                            <select class="form-control" id="getstud-form">
                                                <option value="" selected="selected">All</option>
                                                <option value="1">Form 1</option>
                                                <option value="2">Form 2</option>
                                                <option value="3">Form 3</option>
                                                <option value="4">Form 4</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-1 col-md-1 col-sm-4 col-xs-4">
                                            <label style="color: #FFFFFF; " class="control-label">Class</label>
                                            <select class="form-control" id="getstud-class">
                                                <option value="" selected="selected">All</option>
                                                <?php
                                                $cl = new Rclass();
                                                $cls = $cl->getclasses();
                                                while ($row1 = mysqli_fetch_assoc($cls)) {

                                                    ?>
                                                    <option value="<?php echo $row1['id']; ?>"><?php echo $row1['classname']; ?> </option>

                                                    <?php
                                                }

                                                ?>
                                            </select>

                                        </div>

                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                            <label style="color: #FFFFFF; " class="control-label">House</label>
                                            <select class="form-control" id="getstud-house">
                                                <option value="" selected="selected">All</option>
                                                <?php
                                                $h = new House();
                                                $hus = $h->gethouses();
                                                while ($hs = mysqli_fetch_assoc($hus)) {
                                                    ?>
                                                    <option value="<?php echo $hs['id']; ?>"><?php echo $hs['des']; ?> </option>
                                                    <?php
                                                }

                                                ?>
                                            </select>

                                        </div>

                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                            <label style="color: #FFFFFF; " class="control-label">Gender House</label>
                                            <select class="form-control" id="getstud-ghouse">
                                                <option value="" selected="selected">All</option>
                                                <?php
                                                $ghouse = mysqli_query($cf->con, "select * from houses where house_type <> 'genhouse'");
                                                while ($gh = mysqli_fetch_object($ghouse)) {
                                                    ?>
                                                    <option value="<?= $gh->id; ?>"> <?= $gh->des ?> (<?= $gh->name ?>)</option>
                                                    <?php
                                                }

                                                ?>
                                            </select>

                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                                            <label style="color: #FFFFFF; " for="" class="control-label">Res. Status</label>
                                            <select name="resstatus" id="filter_resstatus" class="form-control">
                                                <option value="">All</option>
                                                <option value="Boarding">Boarding Student</option>
                                                <option value="Day">Day Student</option>
                                            </select>

                                        </div>


                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="stud-list" class="row">
                </div>
            </div>
        </div>
        <?php
    } elseif (mysqli_num_rows($hm) > 0) {
        ?>
        <div class="mainform content" style="background: transparent; box-shadow: 0 !important;" id="viewexeats">

        </div>
        <div class="mainform content row"
             style="background: transparent; box-shadow: 0 0 0 ; padding: 0; margin-right: 0 !important; margin-left: 0 !important; margin-bottom: 3em; margin-top: 7em;"
             id="schres">
        </div>
        <div class="mainform content row"
             style="background: transparent; box-shadow: 0 0 0 ; padding: 0; margin-right: 0 !important; margin-left: 0 !important; margin-bottom: 3em; margin-top: 3em;"
             id="viewstuds">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin: 0 !important;">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin: 0 !important;">
                        <div class="alert alert-info hidden-print" style="margin: 1px !important; box-shadow: 0 0 2px;">
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 hidden-xs hidden-sm"><h3>View Students
                                        <span class="glyphicon glyphicon-user"><span
                                                    class="glyphicon glyphicon-user"></span></h3></div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                                    <button id="filter-btn" class="btn btn-good"
                                            style="color:#fff !important; margin-top:20px !important;" id="filter-btn">
                                        <i class="fa fa-filter "></i>Filter Students
                                    </button>
                                    <button onclick="allprint();" class="btn btn-good hidden-sm hidden-xs"
                                            style="color:#fff !important;"><i class="fa fa-print"></i> Print
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div style="border-bottom: 1px solid #ccc;"></div>
                                </div>
                                <form id="filter-form" class="row" style="display: none;">
                                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
                                        <label style="color: #FFFFFF; " class="control-label">Programe:</label>
                                        <select class="form-control" id="getstud-pro">
                                            <option value="" selected="selected">All</option>
                                            <?php
                                            $de = new Department();
                                            $ds = $de->getdpts();
                                            while ($row1 = mysqli_fetch_assoc($ds)) {
                                                ?>
                                                <option value="<?php echo $row1['id']; ?>"><?php echo $row1['depname']; ?> </option>

                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class=" col-md-1 col-sm-2 col-2">
                                        <label style="color:#fff;" class="control-label">Gender</label>
                                        <select id="filter-gender" class="form-control">
                                            <option value="">All</option>
                                            <option value="Female">Female</option>
                                            <option value="Male">Male</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1 col-sm-3 col-3">
                                        <label style="color: #FFFFFF; " class="control-label">Year</label>
                                        <select class="form-control" id="getstud-ayear">
                                            <option value="" selected="selected">All</option>
                                            <?php
                                            $cf = new config();
                                            $cf->connect();
                                            $ayear = mysqli_query($cf->con, "select DISTINCT(ayear) from stuinfo ORDER by ayear ASC ");
                                            while ($row1 = mysqli_fetch_assoc($ayear)) {
                                                ?>
                                                <option value="<?php echo $row1['ayear']; ?>"><?php echo $row1['ayear']; ?> </option>

                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class=" col-md-1 col-sm-3 col-3">
                                        <label style="color: #FFFFFF; " class="control-label">Form:</label>
                                        <select class="form-control" id="getstud-form">
                                            <option value="" selected="selected">All</option>
                                            <option value="1">Form 1</option>
                                            <option value="2">Form 2</option>
                                            <option value="3">Form 3</option>
                                            <option value="4">Form 4</option>

                                        </select>

                                    </div>
                                    <div class=" col-md-1 col-sm-4 col-xs-4">
                                        <label style="color: #FFFFFF; " class="control-label">Class:</label>
                                        <select class="form-control" id="getstud-class">
                                            <option value="" selected="selected">All</option>
                                            <?php
                                            $cl = new Rclass();
                                            $cls = $cl->getclasses();
                                            while ($row1 = mysqli_fetch_assoc($cls)) {

                                                ?>
                                                <option value="<?php echo $row1['id']; ?>"><?php echo $row1['classname']; ?> </option>

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
                                            $hus = mysqli_query($cf->con, "select houses.* from houses where houses.id in (SELECT hid from housem where stfid = $stfid)");
                                            while ($hs = mysqli_fetch_assoc($hus)) {
                                                ?>
                                                <option value="<?= $hs['id']; ?>"><?= $hs['des']; ?> </option>
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
                                            $ghouse = mysqli_query($cf->con, "select * from houses where house_type <> 'genhouse'");
                                            while ($gh = mysqli_fetch_object($ghouse)) {
                                                ?>
                                                <option value="<?= $gh->id; ?>"> <?= $gh->des ?> (<?= $gh->name ?>)
                                                </option>
                                                <?php
                                            }

                                            ?>
                                        </select>

                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                                        <label style="color: #FFFFFF; " for="" class="control-label">Res. Status</label>
                                        <select name="resstatus" id="filter_resstatus" class="form-control">
                                            <option value="">All</option>
                                            <option value="Boarding">Boarding Student</option>
                                            <option value="Day">Day Student</option>
                                        </select>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="stud-list" class="row">
                </div>
            </div>
        </div>
        <?php
    }
    $woftest = false;
    if (mysqli_num_rows($wof) > 0) {
        $woftest = true;
        ?>
        <div class="mainform content row"
             style="box-shadow: 0 0 2px ; padding: 0; margin-right: 0 !important; margin-left: 0 !important; margin-bottom: 3em;"
             id="waec">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bg-info pt-4" >
                <div class="row">
                    <div class="col-md-6 col-sm-8 col-sm-6 col-12">
                        <div class="md-form">
                            <i class="fa fa-search prefix text-white"></i>
                            <input type="search" id="waec-search" class="form-control text-white" >
                            <label for="" class="text-white">enter name to search..</label>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">
                        <select id="waec-ayear" class="form-control">
                            <?php
                            $years = mysqli_query($cfg->con, "select distinct(ayear) from stuinfo where form = 3");
                            while ($year = mysqli_fetch_object($years)) {
                                ?>
                                <option><?= $year->ayear ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2 col-sm-3 col-3">
                        <button onclick="addwaec();" class="btn btn-warning">ADD
                        </button>

                    </div>
                    <div class="col-md-2 col-3">
                        <button id="waecasaddbtn" data-toggle="dropdown" rolw="button" aria-haspopup="true"
                                aria-expanded="false" class="btn btn-warning btn-sm"
                                style="color: #FFFFFF !important;">PRINT <i class="fa fa-caret-down"></i></button>
                        <ul class="dropdown-menu animated zoomIn" aria-labelledby="asaddbtn">
                            <li class="dropdown-item"><a  onclick="printsubanalysis(); return false;">Subject
                                    Base Analysis</a></li>
                            <li class="dropdown-item"><a  onclick="printproganalysis(); return false;">Programme
                                    Base Analysis</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="waec-content"></div>
        </div>

        <div class="mainform row content"
             style="background: transparent; box-shadow: 0 0 0 ; padding: 0; margin-right: 0 !important; margin-left: 0 !important; margin-bottom: 3em;"
             id="graph-class">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="alert alert-info">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                            <label style="color: #FFFFFF;" for="" class="control-label">Class</label>
                            <select name="chart-class" id="chart-class" class="form-control">
                                <?php
                                $cls = mysqli_query($cfg->con, "select * from classes where id in(select class from stuinfo where form = '3')");
                                while ($row = mysqli_fetch_object($cls)) {
                                    ?>
                                    <option value="<?= $row->id ?>"><?= $row->classname ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                            <label style="color: #FFFFFF;" for="" class="control-label">Academic Year</label>
                            <select name="" id="chart-ayear" class="form-control">
                                <?php
                                $ayear = mysqli_query($cfg->con, "select distinct(ayear) from stuinfo where  form = '3'");
                                while ($row = mysqli_fetch_object($ayear)) {
                                    ?>
                                    <option value="<?= $row->ayear ?>"><?= $row->ayear ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-4">
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
                <div class="card">

                        <div class="row">
                            <div class="col-lg-10 col-md-10 col-10">
                                <div style="width: 100%; height: auto;">
                                    <canvas class="img-fluid" id="chart-canvas"></canvas>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-2">

                                <table class="table table-condensed table-bordered pull-right" style="width: 200px;;">
                                    <tr>
                                        <th class="text-center" colspan="2">Key</th>
                                    </tr>
                                    <tr>
                                        <td>No. Of boys Who passed</td>
                                        <td style="background: rgba(73, 62, 255, 1);">                                          &nbsp;
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
        <?php
    }
    if ($libtest == true) {
        ?>
        <div class="mainform content"
             style="background: transparent; box-shadow: 0 0 0 ; padding: 0;  margin-right: 0 !important; margin-left: 0 !important; margin-bottom: 3em; margin-top: 3em;"
             id="mngbooks">
            <div class="alert alert-info" style="margin: 1px !important;">
                <div class="row">
                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12"><h3>Manage Books <i
                                    class="fa fa-book fa-stack"></i><i class="fa fa-pencil-square-o"></i></h3></div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <div style="border-bottom: 1px solid #ccc;"></div>
                    </div></div>
                    <form id="filter-form" class="row">
                        <div class="col-lg-6 col-md-6 col-sm-8 col-8">
                            <div class="md-form">
                                <i class="fa fa-search prefix text-white"></i>
                                <input type="search" name="" id="book-search" class="form-control text-white" >
                                <label for="" class="control-label text-white" >Search By title,author, shelf or description</label>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-4 col-2">
                            <br>
                            <button onclick="addbook();" type="button" class="btn btn-warning btn-sm">Add <i class="fa fa-plus-square"></i></button>
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-4 col-2">
                            <br>
                            <button data-toggle="dropdown" onclick=""
                                    type="button" class="btn btn-warning btn-sm">Print <i class="fa fa-caret-down"></i></button>
                            <ul class="dropdown-menu animated zoomIn" aria-labelledby="printoptions">
                                <li class="dropdown-item" ><a onclick="printbooklist(); return false;">Book
                                        List</a></li>
                                <li class="dropdown-item" ><a onclick="printDefaulters(); return false;">Defaulters
                                        list</a></li>
                            </ul>
                        </div>
                    </form>

            </div>
            <div style="padding:0 !important;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="book-container">
            </div>
        </div>
        <div class="mainform content"
             style="background: transparent; box-shadow: 0 0 0 ; padding: 0;  margin-right: 0 !important; margin-left: 0 !important; margin-bottom: 3em; margin-top: 3em;"
             id="lendbooks">
            <div class="alert alert-info">
                <div class="row">
                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12"><h3>View Lend History <i class="fa fa-handshake-o"></i><i class="fa fa-history"></i></h3></div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-12">
                        <div style="border-bottom: 1px solid #ccc;"></div>
                    </div></div>
                    <form id="filter-form" class="row">
                        <div class=" col-md-6 col-sm-10 col-10">
                            <div class="md-form">
                                <i class="fa fa-search prefix text-white"></i>
                                <input type="search" name="" id="lend-search" class="form-control text-white" >
                                <label for="lend-search" class="control-label text-white">Search By title,author, shelf or description</label>

                            </div>

                        </div>
                        <div class=" col-md-1 col-sm-2 col-2">
                            <button data-toggle="dropdown" onclick=""

                                    type="button" class="btn btn-warning btn-sm">Print <i class="fa fa-caret-down"></i></button>
                            <ul class="dropdown-menu animated zoomIn" aria-labelledby="printoptions">
                                <li class="dropdown-item" ><a  onclick="printbooklist(); return false;">Book
                                        List</a></li>
                                <li class="dropdown-item" ><a  onclick="printDefaulters(); return false;">Defaulters
                                        list</a></li>
                            </ul>
                        </div>
                    </form>

            </div>
            <div class="col-md-12 col-sm-12 col-12" style="padding:0 !important;" id="lend-container">
            </div>
        </div>
        <?php
    }
    ?>
    <div class="mainform content row"
         style="background: transparent; box-shadow: 0 0 0 ; padding: 0;  margin-right: 0 !important; margin-left: 0 !important; margin-bottom: 3em; margin-top: 3em;"
         id="mngfrm">
        <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin: 0 !important;">
            <div class="alert alert-info" style="margin: 1px !important;">
                <div class="row">
                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12"><h3>Manage Form Records <i class="fa fa-users"></i></h3></div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div style="border-bottom: 1px solid #ccc;"></div>
                    </div>
                    <form id="filter-form" class="col-lg-12 col-md-12 col-sm-12 col-12">

                        <div class="row">
                        <div class=" col-md-3 col-sm-4 col-4">
                            <label style="color: #fff;" class="control-label">Academic Year</label>
                            <select class="form-control" id="frm-ayear">
                                <?php
                                $ayr5 = mysqli_query($cfg->con, "select distinct(ayear) from stuinfo");
                                while ($yearrow5 = mysqli_fetch_object($ayr5)) {
                                    ?>
                                    <option><?= $yearrow5->ayear ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-2 col-2">
                            <label style="color: #fff;" class="control-label">Term</label>
                            <select class="form-control" id="frm-term">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-6 col-6">
                            <label class="control-label" style="color: #fff;">Class</label>
                            <select class="form-control" id="frm_class">
                                <?php
                                $tskcls5 = mysqli_query($cfg->con, "select id,classname from classes where id in (select clid from frmmaters where stfid = '$stfid')");
                                while ($clrow5 = mysqli_fetch_object($tskcls5)) {
                                    ?>
                                    <option value="<?php echo $clrow5->id; ?>"><?php echo $clrow5->classname; ?> </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-4 col-sm-8 col-8">
                            <div class="md-form">
                                <i class="fa fa-search prefix text-white"></i>
                                <input type="search" name="" id="frm-search" class="form-control text-white" >
                                <label for="frm-search" class="control-label text-white">Enter a name to search..</label>

                            </div>

                        </div>
                            <div class=" col-md-1 col-sm-4 col-4">
                                <button onclick="addfrm();"  type="button" class="btn btn-warning btn-sm">Add <i class="fa fa-plus-square"></i></button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="frm-container">
        </div>
    </div>
    <div class="mainform content row"
         style="background: transparent; box-shadow: 0 0 0 ; padding: 0;  margin-right: 0 !important; margin-left: 0 !important; margin-bottom: 3em; margin-top: 3em;"
         id="viewassess">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin: 0 !important;">
            <div class="alert alert-info" style="margin: 1px !important;">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 hidden-sm hidden-xs"><h3>Manage Assessment <span
                                    class="fa fa-list-alt"></span></h3></div>
                    <br>
                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                        <div class="md-form bg-white pl-2">
                            <i class="prefix fa fa-search"></i>
                            <input type="search" class="form-control" id="txtsearch"/>
                            <label for="txtsearch">Search assessment...</label>
                        </div>                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div style="border-bottom: 1px solid #ccc;"></div>
                    </div>
                    <div class="col-md-6 col-12">
                    <form id="filter-form">
                        <div class="row">
                        <div class="col-md-4 col-sm-6 col-6">
                            <label class="control-label" style="color: #FFFFFF;;">Subject:</label>
                            <select class="form-control" id="assess-subjt">
                                <?php
                                $stafid = $_SESSION['id'];
                                $subs = mysqli_query($cfg->con, "select * from subjects where id in (SELECT subid from subas where stfid = '$stafid')");
                                while ($subrow5 = mysqli_fetch_assoc($subs)) {
                                    ?>
                                    <option value="<?php echo $subrow5['id']; ?>"><?php echo $subrow5['subjdesc']; ?> </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-2 col-4">
                            <label class="control-label" style="color: #FFFFFF;;">Year:</label>
                            <select class="form-control" id="assess-ayear">
                                <?php
                                $ayear = mysqli_query($cfg->con, "select distinct(ayear) as ayear from stuinfo");
                                while ($yearrow = mysqli_fetch_object($ayear)) {
                                    ?>
                                    <option value="<?= $yearrow->ayear; ?>"><?= $yearrow->ayear; ?> </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class=" col-md-2 col-sm-2 col-2">
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
                                $cls = mysqli_query($cfg->con, "select * from classes where id in(SELECT clid from subas where stfid = '$stafid' )");
                                while ($clrow5 = mysqli_fetch_assoc($cls)) {
                                    ?>
                                    <option value="<?php echo $clrow5['id']; ?>"><?php echo $clrow5['classname']; ?> </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        </div>
                    </form>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="row">
                    <div class="col-md-3 col-sm-4 col-3">
                        <br>
                        <button id="asaddbtn" data-toggle="dropdown" rolw="button" aria-haspopup="true"
                                aria-expanded="false" class="btn btn-warning btn-sm"
                                style="color: #FFFFFF !important;">ADD <i class="fa fa-caret-down"></i></button>
                        <ul class="dropdown-menu animated zoomIn" aria-labelledby="asaddbtn">
                            <li class="dropdown-item"><a onclick="getclstaks_inputs(); return false;">Class
                                    Test</a></li>
                            <li class="dropdown-item"><a onclick="getclsassing_inputs()">Class Exercise</a></li>
<!--                            <li class="dropdown-item"><a onclick="getclspwork_inputs()">Project Work</a></li>-->
                            <li class="dropdown-item"><a onclick="getclsexam_inputs()">Exam</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 col-sm-4 col-3">
                        <br>
                        <button id="asaddbtn" data-toggle="dropdown" rolw="button" aria-haspopup="true"
                                aria-expanded="false" class="btn btn-warning btn-sm"
                                style="color: #FFFFFF !important;">ADD BATCH</B> <i class="fa fa-caret-down"></i>
                        </button>
                        <ul class="dropdown-menu animated zoomIn" aria-labelledby="asaddbtn">
                            <li class="dropdown-item"><a  onclick="getbatchclstaks_inputs(); return false;">Class
                                    Test</a></li>
                            <li class="dropdown-item"><a onclick="getbatchclsassing_inputs()">Class Exercise</a></li>
<!--                            <li class="dropdown-item"><a onclick="getbatchclspwork_inputs()">Project Work</a></li>-->
                            <li class="dropdown-item"><a onclick="getbatchclsexam_inputs()">Exam</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 col-sm-4 col-3 pt-4 ">
                        <button  title="Reload the content"   data-toggle="tooltip" class="btn rgba-amber-strong text-white btn-sm" id="reloadbtn5"> Reload<i class="fa fa-refresh "></i></button>
                    </div>
                    <div class="col-md-3 sm-4 col-3 pt-3">
                        <button title="Print this assessment" data-toggle="tooltip" class="btn rgba-cyan-strong text-white btn-sm" id="btnprintassess">Print<i class="fa fa-print "></i></button>
                    </div>
                </div>
            </div>
            </div>
                </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="assess-container">
        </div>
    </div>
    <div style="background: transparent; box-shadow: 0 0 0 ; padding: 0;  margin-right: 0 !important; margin-left: 0 !important; margin-bottom: 3em; margin-top: 3em;"
         class="row content mainform" id="myaccount">
        <div id="account-det"></div>
    </div>
    <?php
    if ($woftest == true) {
        ?>
        <div class="mainform content row"
             style="background: transparent; box-shadow: 0 0 0 ; padding: 0;  margin-right: 0 !important; margin-left: 0 !important; margin-bottom: 3em; margin-top: 3em;"
             id="allca">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin: 0 !important;">
                <div class="alert alert-info" style="margin: 1px !important;">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 hidden-sm hidden-xs"><h3>Manage All
                                Assessments <span class="glyphicon glyphicon-list-alt"></span></h3></div>
                        <br>
                        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">

                            <div class="md-form bg-white pl-2">
                                <i class="prefix fa fa-search"></i>
                                <input type="search" class="form-control" id="allcasearch"/>
                                <label for="allcasearch">Search assessment...</label>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div style="border-bottom: 1px solid #ccc;"></div>
                        </div>
                        <form id="filter-form" class="row">
                            <div class="col-md-4  col-6">
                                <label class="control-label" style="color: #FFFFFF;;">Subject:</label>
                                <select class="form-control" id="allca-subjt">
                                    <?php
                                    $c5 = new config();
                                    $c5->connect();
                                    $subs5 = new Subjects();
                                    $sub5 = $subs5->getsubjects(NULL);
                                    while ($subrow5 = mysqli_fetch_assoc($sub5)) {
                                        ?>
                                        <option value="<?php echo $subrow5['id']; ?>"><?php echo $subrow5['subjdesc']; ?> </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-2 col-4">
                                <label class="control-label" style="color: #FFFFFF;;">Year</label>
                                <?php
                                $ys = mysqli_query($c5->con, "select distinct(ayear) from stuinfo order by ayear desc");

                                ?>
                                <select class="form-control" id="allca-ayear">
                                    <?php

                                    while ($ysrow = mysqli_fetch_object($ys)) {
                                        ?>
                                        <option value="<?= $ysrow->ayear ?>"><?= $ysrow->ayear ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-1 col-2">
                                <label class="control-label" style="color: #FFFFFF;">Term:</label>
                                <select class="form-control" id="allca-term">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-12 col-12">
                                <label style="color: #FFFFFF;" class="control-label">Class:</label>
                                <select class="form-control" id="allca_class">
                                    <?php
                                    $tskcl5 = new Rclass();
                                    $tskcls5 = $tskcl5->getclasses();
                                    while ($clrow5 = mysqli_fetch_assoc($tskcls5)) {
                                        ?>
                                        <option value="<?php echo $clrow5['id']; ?>"><?php echo $clrow5['classname']; ?> </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </form>
                        <div class="col-md-2 col-sm-4 col-4">
                            <br>
                            <button onclick="$('#allca_class').change();" style="color:#fff !important; margin-top:5px"
                                    title="Reload the content" data-toggle="tooltip" class="btn btn-warning"> Reload<i
                                        class="fa fa-refresh "></i></button>
                        </div>
                        <div class="col-md-2 col-sm-4 col-4">
                            <br>
                            <button onclick="print_assess();"
                                    style="color:#fff !important; background-color:transparent; margin-top:5px"
                                    title="Print this assessment" data-toggle="tooltip" class="btn btn-warning"
                                    id="btnprintasses">Print<i class="fa fa-print "></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="allca-container"></div>
        </div>
        <?php
    }
    ?>
</div>
<script src="../admin/js/jquery.js" type="text/javascript"></script>
<script src="../admin/js/jquery-ui-1.10.4.min.js" type="text/javascript"></script>
<script src="../admin/js/popper.min.js" type="text/javascript"></script>
<script src="../admin/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../admin/js/bootstrap-dialog.min.js" type="text/javascript"></script>
<script src="../admin/js/dropzone.min.js" type="text/javascript"></script>
<script src="../admin/js/popper.min.js" type="text/javascript"></script>
<script src="../admin/js/snarl.min.js" type="text/javascript"></script>
<script src="../admin/js/waves.min.js" type="text/javascript"></script>
<script src="../admin/js/chart.js" type="text/javascript"></script>
<script src="../admin/js/mdb.min.js" type="text/javascript"></script>
<script src="../admin/js/wejs.js" type="text/javascript"></script>
<script type="text/javascript">
    $(window).on('hashchange', function (e) {
        var rawtag = window.location.hash;
        var target = window.location.hash.replace('/', '');
        localStorage.tget = target;
        testtarget = window.location.hash.replace('#/', '');
        if (testtarget != "regstaf") {
            $(".main-search-cont").slideUp(100);
        }
        if ($(".bootstrap-dialog").length > 0) {
            cloasedlgs();
            window.location = rawtag;
            return false;
        } else {
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
    $(document).ready(function () {
        Waves.init();
        Waves.attach('.tile', ['waves-float', 'waves-light']);

        $("button").tooltip();
        $("li").tooltip();
        $("a").tooltip();

        $("#assess-ayear").change(function () {
            $("#assess_class").change();
        });
        $("#assess-subjt").change(function () {
            $("#assess_class").change();
        });
        $("#assess-term").change(function () {
            $("#assess_class").change();
        });
        $("#reloadbtn5").click(function () {

            $("#assess_class").change();

        });
        //---------------------------
        mkayear();
        var addtest = localStorage.addtest;
        $(".startmenu .col-lg-3, .tile").sortable();
        var d = null;
        $("#dob,#dor").datepicker({
            changeMonth: true,
            changeYear: true,
            showAnim: "slideDown",
            dateFormat: "yy-m-d",
            currentDate: true
        });

        //---------------------------------------------------------------------------------------
        var d = new Date();
        var td = d.getDate();
        var tmon = d.getMonth() + 1;
        var tyea = d.getFullYear();
        $("#dor").val(tyea + "-" + tmon + "-" + td);


        $(".tile").click(function () {
            var target = $(this).attr("data-get");
            localStorage.addtest = target;
            localStorage.dget = target;
            addtest = localStorage.addtest;

        });

        $(".home-btn").click(function () {
            addtest = null;
            closewindow(".content");
        });

        setTimeout(chck_exeat(),3);
    });


    function chck_exeat(){
        $
            .getJSON("check_dueExeat.php")
            .done(function (data) {
                $("#Ex-cont").html(data.value);
                if(Number(data.value)>0){
                    $(".exeat_warning").removeClass('invisible');
                }
            })
            .error(function () {
            });

    }



</script>


</body>
</html>
<div class="search-pane bg-info" style="opacity: 1 !important;">
    <div class="container-fluid rgba-amber-strong">

        <div class="search-header">
            <div class="row">
                <div class="col-md-1 col-1">
                    <button type="button" class="btn btn-sm bg-transparent search-close"><i class="fa fa-remove fa-4x text-white"></i></button>
                </div>
                <div class="col-md-11 col-11">
                    <p class="search-pane-title">SEARCH</p>
                </div>
            </div>
        </div>
    </div>

    <div class="search-input-container">
        <div class="md-form">
            <i class="fa fa-search prefix text-white"></i>
            <input type="search" class="search-box"/>
            <label for="search-box" class="text-white">Search Students...</label>
        </div>
    </div>
    <div class="search-content">
    </div>
</div>

<div class="bg-warning exeat_warning pl-4 animated zoomIn invisible">
    <i class="fa fa-bell "></i>Your have <span id="Ex-cont"></span> exeats due <a onclick="$('.exeat_warning').fadeOut(100)" class="btn btn-link" href="#/viewexeats">View & Manage</a> <button onclick="$('.exeat_warning').fadeOut(100)" class="btn btn-link pull-right">Dismiss</button>
</div>
<!--/dialogs--->