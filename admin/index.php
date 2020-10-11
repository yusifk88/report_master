<?php
include_once './objts/school.php';
$sch = new school();
session_start();
    if (!$_SESSION['ad_uname'] && !$_SESSION['ad_upass'] && !$_SESSION['ad_id'] && (!$_SESSION['school_id'] || $_SESSION['school_id'] != $sch->code)) {
        header("location:../");
    }
include_once './objts/config.php';
include_once './objts/department.php';
include_once './objts/house.php';
include_once './objts/rclass.php';
include './objts/subjects.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Report Master</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">
    <meta name="theme-color" content="#17a2b8">
    <link rel="icon" href="img/rmicon.png"/>
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="css/dropzone.min.css" rel="stylesheet" type="text/css"/>
    <link href="css/basic.min.css" rel="stylesheet" type="text/css"/>
    <link href="css/snarl.min.css" rel="stylesheet" type="text/css"/>
    <link href="css/waves.min.css" rel="stylesheet" type="text/css"/>
    <link href="css/bootstrap-dialog.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <script src="assets/js/plugin/webfont/webfont.min.js"></script>

    <link href="css/atlantis.min.css" rel="stylesheet" type="text/css"/>

    <link href="css/mystyle.css" rel="stylesheet"/>
    <link href="css/wecss.css" rel="stylesheet"/>
    <script>
        WebFont.load({
            google: {"families":["Lato:300,400,700,900"]},
            custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['/admin/assets/css/fonts/fonts.min.css']},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
</head>
<body class="bg-grey2">
<input type="hidden" id="global_stfid" value="<?= $_SESSION['ad_id'] ?>">
<input type="hidden" id="global_usertype" value="<?= $_SESSION['ad_utype'] ?>">
<!--/ top navigation -->
<div class="wrapper" style="margin-bottom:7em;">
    <div class="main-header">

        <!-- Logo Header -->
        <div class="logo-header bg-white">

            <a href="/#" class="logo">
                <img src="img/rmicon.png" alt="navbar brand" class="navbar-brand">
            </a>
            <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
						<i class="icon-menu"></i>
					</span>
            </button>
            <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="icon-menu"></i>
                </button>
            </div>
        </div>
        <!-- End Logo Header -->


    <nav class="navbar navbar-header navbar-expand-lg bg-white">
        <div class="container-fluid">
            <div class="navbar-header" style="transition: .3s ease-in-out !important;">
                <a class="navbar-brand hidden-md mr-4 float-left" id="nav-back" href="#">
                    <i class="fa fa-long-arrow-left text-white"> </i></a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav ml-auto ">
                    <li class="nav-item text-center" title="View user activity Log" data-toggle="tooltip">
                        <a
                                onclick="actlog(); return false;" style="color: #fff;" href="#" class="nav-link text-primary"><i
                                    class="fa fa-binoculars"></i>
                        </a></li>
                    <li class="nav-item text-center" title="Print record entry Log" data-toggle="tooltip"><a
                                onclick="entrylog(); return false;" style="color: #fff;" href="#" class="nav-link text-primary"><i
                                    class="fa fa-arrow-down"></i><i class="fa fa-arrow-up"></i>
                        </a></li>
                    <li title="Manage deadline" data-toggle="tooltip" class="nav-item text-center"><a
                                onclick="setdeadline(); return false;" href="#" class="nav-link text-primary"><i
                                    class="fa fa-clock-o text-primary"></i>
                        </a></li>
                    <li class="nav-item text-center"><a onclick="showinfo(); return false;" class="nav-link text-primary"><i
                                    class="fa fa-info-circle"></i>
                        </a></li>
                    <li class="nav-item text-center"><a id="hlpmnu" onclick="showhelp(); return false;"
                                                                   href="#Help" class="nav-link text-primary"><i
                                    class="fa fa-lightbulb-o"></i> </a></li>
                    <li class="nav-item text-center"><a href="#" onclick="logout(); return false;" class="nav-link text-primary"><i
                                    class="fa fa-sign-out text-primary"></i>
                        </a></li>
                    <li class="nav-item text-white text-center"><a id="searchbtn" href="#"
                                                                   onclick="showsearch(); return false;"
                                                                   class=" text-primary nav-link"><i
                                    style="font-weight: bolder;" class="fa fa-search"></i>

                        </a></li>
                </ul>
            </div>
            <button id="menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                    class="navbar-toggler collapsed ml-auto p-0"><i
                        class="fa fa-ellipsis-v navbar-toggler-icon text-primary"></i></button>
            <ul class="dropdown-menu animated zoomIn" style="transition: 0.1s ease-in-out !important;"
                aria-labelledby="menu">
                <li class="dropdown-item" title="Manage deadline" data-toggle="tooltip"><a
                            onclick="actlog(); return false;" href="#">View User Activity Log</a>
                </li>
                <li class="dropdown-item" title="Manage deadline" data-toggle="tooltip"><a
                            onclick="entrylog(); return false;" href="#">View Entry Log</a>
                </li>
                <li class="dropdown-item" title="Manage deadline" data-toggle="tooltip"><a
                            onclick="setdeadline(); return false;" href="#">Set Deadline</i></a></li>
                <li class="dropdown-item"><a onclick="showinfo(); return false;" href="#">System Info.</a></li>
                <li class="dropdown-item"><a onclick="showhelp(); return false;" href="#Help">Tech Assistance </a></li>
                <li class="dropdown-item"><a href="#" onclick="logout(); return false;">Log Out</a></li>
            </ul>

            <button id="searchbtn" onclick="showsearch();" type="button" class="navbar-toggler collapsed"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <i class="fa fa-search text-white"></i>
            </button>
        </div>
    </nav>

</div>
    <!-- Sidebar -->
    <div class="sidebar sidebar-style-2" data-background-color="light">
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
            <div class="sidebar-content">
                <div class="user">
                    <div class="avatar-sm float-left mr-2">
                        <img src="assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle">
                    </div>
                    <div class="info">
                        <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
								<span>
									Hizrian
									<span class="user-level">Administrator</span>
									<span class="caret"></span>
								</span>
                        </a>
                        <div class="clearfix"></div>

                        <div class="collapse in" id="collapseExample">
                            <ul class="nav">
                                <li>
                                    <a href="#/profile">
                                        <span class="link-collapse">My Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#edit">
                                        <span class="link-collapse">Edit Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#settings">
                                        <span class="link-collapse">Settings</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <ul class="nav nav-primary">


                    <li class="nav-item active text-center">
                        <a href="#/" class="collapsed text-center" aria-expanded="false">
                            <i class="fa fa-dashboard"></i>
                            <p>Dashboard</p>
                        </a>

                    </li>
                    <li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
                        <h4 class="text-section">Students</h4>
                    </li>
                    <li class="nav-item">
                        <a href="#/regstud">
                            <i class="fa fa-user-plus"></i>
                            <p>Register Student</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a  href="#/viewstuds">
                            <i class="fa fa-users"></i>
                            <p>Manage Students</p>
                        </a>
                    </li>



                    <li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
                        <h4 class="text-section">Staff</h4>
                    </li>

                    <li class="nav-item">
                        <a href="#/regstaf">
                            <i class="fa fa-users"></i>
                            <p>Manage Staff</p>
                        </a>
                    </li>



                    <li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
                        <h4 class="text-section">Structures</h4>
                    </li>
                    <li class="nav-item">
                        <a  href="#/regdept">
                            <i class="fa fa-clone"></i>
                            <p>Programes</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a  href="#/regclass">
                            <i class="fa fa-cubes"></i>
                            <p>Classes</p>
                        </a>
                    </li>



                    <li class="nav-item">
                        <a  href="#/reghouse">
                            <i class="fa fa-home"></i>
                            <p>Houses</p>
                        </a>
                    </li>


                    <li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
                        <h4 class="text-section">Academics</h4>
                    </li>
                    <li class="nav-item">
                        <a href="#/regsubjts">
                            <i class="fa fa-book"></i>
                            <p>Subjects</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#/viewassess">
                            <i class="fa fa-bar-chart"></i>
                            <p>Assessments</p>
                        </a>
                    </li>



                    <li class="nav-item">
                        <a data-toggle="collapse" href="#/waec">
                            <i class="fa fa-line-chart"></i>
                            <p>WAEC Records</p>
                        </a>
                    </li>


                    <li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
                        <h4 class="text-section">Reports</h4>
                    </li>
                    <li class="nav-item">
                        <a href="#base">
                            <i class="fa fa-list"></i>
                            <p>Class List</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#base">
                            <i class="fa fa-list-alt"></i>
                            <p>Programe List</p>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a href="#base">
                            <i class="fa fa-list-ol"></i>
                            <p>House List</p>
                        </a>
                    </li>



                    <li class="nav-item">
                        <a data-toggle="collapse" href="#base">
                            <i class="fa fa-th-list"></i>
                            <p>Sign List</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a data-toggle="collapse" href="#base">
                            <i class="fa fa-th-list"></i>
                            <p>Form List</p>
                        </a>
                    </li>






                    <li class="mx-4 mt-2">
                        <a  class="btn btn-primary btn-block"><span class="btn-label mr-2"> <i class="fa fa-heart"></i> </span>Buy Pro</a>
                    </li>


                </ul>


            </div>
        </div>
    </div>
    <!-- End Sidebar -->

    <div class="main-panel">

        <div class="container-fluid pt-5">


    <div class="row main-search-cont p-2 bg-light hoverable" style="margin-top: 3.5rem; box-shadow: 0 0 3px; ">
        <div class="col-lg-10 col-md-10 col-12 col-sm-12 col-lg-offset-1 col-md-offset-1">
            <div class="md-form">
                <i class="prefix fa fa-search"></i>
                <input id="main-search" type="search" class="form-control main-search"/>
                <label for="main-search">Type a name to search...</label>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="m-auto col-lg-12 col-md-12 col-sm-12 col-12 col-md-offset-2 col-lg-offset-2">


            <!--main router view-->
           <div class="w-100" id="maincontent">


           </div>
            <!--/main router view-->


        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="mainform content" style="background: transparent; box-shadow: 0 !important;" id="viewexeats">

            </div>

            <div class="mainform content" style="background: transparent; box-shadow: 0 !important;" id="regstaf">
            </div>
        </div>
    </div>
    <div class="mainform content row"
         style="background: transparent; box-shadow: 0 0 0 ; padding: 0; margin-right: 0 !important; margin-left: 0 !important; margin-bottom: 3em;"
         id="viewstuds">
        <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin: 0 !important;">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="alert alert-info hidden-print" style="margin: 1px !important; box-shadow: 0 0 5px;">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-12 col-12 hidden-xs hidden-sm"><h3>View Students <span
                                            class="fa fa-user"><span class="fa fa-user"></span></h3></div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                                <button id="filter-btn" class="btn btn-good"
                                        style="color:#fff !important; margin-top:20px !important;" id="filter-btn"><i
                                            class="fa fa-filter "></i>Filter Students
                                </button>
                                <button onclick="allprint();" class="btn btn-good hidden-sm hidden-xs"
                                        style="color:#fff !important;"><i class="fa fa-print"></i> Print
                                </button>
                            </div>
                        </div>
                        <form id="filter-form" style="display: none;">
                            <div class="row">
                                <div class=" col-md-2 col-sm-4 col-4">
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
                                <div class="col-lg-1 col-md-1 col-sm-3 col-3">
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
                                <div class="col-lg-1 col-md-1 col-sm-3 col-3">
                                    <label style="color: #FFFFFF; " class="control-label">Form</label>
                                    <select class="form-control" id="getstud-form">
                                        <option value="" selected="selected">All</option>
                                        <option value="1">Form 1</option>
                                        <option value="2">Form 2</option>
                                        <option value="3">Form 3</option>
                                        <option value="4">Form 4</option>
                                    </select>
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-3 col-3">
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

                                <div class="col-lg-2 col-md-2 col-sm-3 col-3">
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

                                <div class="col-lg-2 col-md-2 col-sm-3 col-3">
                                    <label style="color: #FFFFFF; " class="control-label">Gend. House</label>
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
                                <div class="col-lg-2 col-md-2 col-sm-3 col-3">
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
            <div id="stud-list" class="row">


            </div>
        </div>
    </div><!--col-*-->
    <div class="row " id="regstud" style="display: none; margin-top: 1.7em;">
        <div class="col-lg-10 col-md-10 col-sm-12 col-12 col-lg-offset-2 col-md-offset-2">
            <div class="card">
                <div class="card-heading bg-info text-white p-2">
                    <br> REGISTER STUDENT <i class="fa fa-user-plus fa-2x"></i>
                </div>
                <div class="card-body" style="padding: 10px !important;">

                    <?php
                        if(!$sch->sub_expired()){
                    ?>

                    <div class="alert bg-warning">
                        <h4><i class="fa fa-warning"></i> Please make sure to select the correct academic year to prevent misplacing students  </h4>

                    </div>
                    <form method="post" action="regstud.php" id="frmregstud" class="form">


                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                <br><br><br>
                                <label class="control-label" for="index">ID</label>
                                <input readonly="" id="index" name="index"
                                       style="background-color: #17a2b8; color: #FFF; text-align: center;" type="text"
                                       class="form-control input-lg" required="required"
                                       placeholder="identification number"/>
                            </div>
                            <input type="hidden" value="dpic/photo.jpg" name="photo" id="photo" required="required"/>
                            <div class="col-lg-3 col-md-3 col-sm-8 col-12 pull-right ml-auto">
                                <div class="dropzone waves-effect waves-ripple"></div>
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="md-form">
                                    <i class="fa fa-hashtag prefix grey-text"></i>
                                    <input type="text" name="jhsno" id="jhsno" class="form-control">
                                    <label for="jhsno">JHS No.</label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">


                                <div class="md-form">
                                    <i class="fa fa-hashtag prefix grey-text"></i>
                                    <input type="text" name="shsno" id="shsno" class="form-control">
                                    <label for="shsno">SHS No.</label>
                                </div>


                            </div>

                        </div>
                        <div class="row">

                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="md-form">
                                    <i class="fa fa-user prefix grey-text"></i>
                                    <input required type="text" name="fname" id="fname" class="form-control">
                                    <label for="fname">SurName</label>
                                </div>

                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">

                                <div class="md-form">
                                    <i class="fa fa-user prefix grey-text"></i>
                                    <input required type="text" name="lname" id="lname" class="form-control">
                                    <label for="lname">Last Name</label>
                                </div>
                            </div>


                        </div>
                        <!--second row -->
                        <div class="row">

                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="md-form">
                                    <i class="fa fa-user prefix grey-text"></i>
                                    <input required type="text" name="oname" id="oname" class="form-control">
                                    <label for="oname">Other Name(s)</label>
                                </div>

                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">

                                        <label class="control-label" for="gender">Gender</label>

                                        <select class="form-control we-select" id="gender" name="gender">

                                            <option>Male</option>
                                            <option>Female</option>

                                        </select>


                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="md-form">
                                            <i class="fa fa-calendar-check-o prefix grey-text"></i>
                                            <input required type="date" name="dob" id="dob" class="form-control">
                                            <label class="active" for="dob">Date Of Birth</label>
                                        </div>

                                    </div>
                                </div>

                            </div>


                        </div>

                        <!---- third row-->
                        <div class="row">

                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                        <label class="control-label" for="dept">Department <span style="color: #F00;"
                                                                                                 class="fa fa-asterisk"></span></label>
                                        <select class="form-control we-select" name="dept" id="dept">

                                            <?php
                                            $dpt = new Department();
                                            $d = $dpt->getdpts();
                                            while ($row = mysqli_fetch_assoc($d)) {
                                                ?>
                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['depname']; ?></option>

                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                        <label class="control-label" for="form">
                                            Form
                                        </label>
                                        <select class="form-control" name="form" id="form">
                                            <option value="1">Form 1</option>
                                            <option value="2">Form 2</option>
                                            <option value="3">Form 3</option>
                                            <option value="4">Form 4</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="md-form">
                                            <i class="fa fa-home prefix grey-text"></i>
                                            <input required type="text" class="form-control" readonly id="hse_alt">
                                            <label class="active" for="hse_alt">House</label>
                                            <input required type="hidden" name="hse" id="hse" class="form-control">
                                        </div>

                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">

                                        <div class="md-form">
                                            <i class="fa fa-calendar-o prefix grey-text"></i>
                                            <input value="<?= date('mm/dd/yyyy') ?>" required type="date" name="dor"
                                                   id="dor" class="form-control">
                                            <label class="active" for="dor">Registeration Date</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                                <label for="" class="control-label">Gender House/Hall</label>
                                <select name="ghouse" id="ghouse" class="form-control">
                                    <option value="0">None</option>

                                    <?php
                                    $ghouse = mysqli_query($cf->con, "select * from houses where house_type <> 'genhouse'");

                                    while ($rh = mysqli_fetch_object($ghouse)) {
                                        ?>
                                        <option value="<?= $rh->id ?>"><?= $rh->des ?> (<?= $rh->name ?>)</option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                                <label class="control-label" for="clas">Class <span style="color: #F00;"
                                                                                    class="fa fa-asterisk"></span></label>
                                <select required="required" class="form-control we-select" name="cls" id="clas">
                                    <?php
                                    $cls = new Rclass();
                                    $clases = $cls->getclasses();
                                    while ($row = mysqli_fetch_assoc($clases)) {
                                        ?>
                                        <option value="<?php echo($row['id']); ?>"> <?php echo($row['classname']); ?> </option>

                                        <?php
                                    }

                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                                <label class="control-label" for="ayear">Academic Year <span style="color: #F00;"
                                                                                             class="fa fa-asterisk"></span></label>
                                <select class="form-control" name="ayear" id="ayear">
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                                <label class="control-label" for="lschool">Residential Status <span style="color: #F00;"
                                                                                                    class="fa fa-asterisk"></span></label>
                                <select class="form-control" name="reststatus" id="restatus">
                                    <option selected value="Boarding Student">Boarding Student</option>
                                    <option value="Day Student">Day Student</option>
                                </select>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                <div class="md-form">
                                    <i class="fa fa-caret-left prefix grey-text"></i>
                                    <input type="text" name="lsch" required="required" id="lschool"
                                           class="form-control"/>
                                    <label for="lschool">Last School Attended </label>
                                </div>
                            </div>

                        </div>
                        <br/>
                        <div style="padding: 0;" class="p-2 bg-warning text-white"><p class="text-muted">
                            <h3>Parent/Guidiant's Information <i class="fa fa-caret-down"></i></h3> </p></div>
                        <!---- row for parent's information-->
                        <div class="row" style="border-bottom: thin solid #17a2b8">
                            <!----father's information-->
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">

                                <div class="card card-warning">
                                    <div class="card-heading p-2 bg-info text-white">Father's information</div>
                                    <div class="card-body" style="padding: 5px;">

                                        <div class="md-form">
                                            <i class="fa fa-user prefix grey-text"></i>
                                            <input class="form-control" type="text" required="required" name="fthname"
                                                   id="fthname"/>
                                            <label for="fthname">Father's Full Name <span style="color: #F00;"
                                                                                          class="fa fa-asterisk"></span></label>
                                        </div>

                                        <div class="md-form">
                                            <i class="fa fa-address-book-o prefix grey-text"></i>
                                            <input class="form-control" type="text" required="required" name="fhtown"
                                                   id="fhtown"/>
                                            <label for="fhtown">Father's Home Town <span style="color: #F00;"
                                                                                         class="fa fa-asterisk"></span></label>
                                        </div>
                                        <div class="md-form">
                                            <i class="fa fa-phone prefix grey-text"></i>

                                            <input class="form-control" type="tel" required="required" name="pthtel"
                                                   id="pthtel"/>
                                            <label for="pthtel">Father's Phone Number</label>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--mother's information-->
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">

                                <div class="card card-default">
                                    <div class="card-heading p-2 bg-success text-white">Mother's information</div>
                                    <div class="card-body" style="padding: 5px;">
                                        <div class="md-form">
                                            <i class="fa fa-user prefix grey-text"></i>
                                            <input class="form-control" type="text" required="required" name="mthname"
                                                   id="mthname"/>
                                            <label for="mthname">Mother's Full Name </label>
                                        </div>

                                        <div class="md-form">
                                            <i class="fa fa-address-book-o prefix grey-text"></i>
                                            <input class="form-control" type="text" required="required" name="mtown"
                                                   id="mtown"/>
                                            <label class="control-label" for="mtown">Mother's Home Town</label>

                                        </div>

                                        <div class="md-form">
                                            <i class="fa fa-phone prefix grey-text"></i>

                                            <input class="form-control" type="tel" name="mthtel" id="mthtel"/>
                                            <label class="control-label" for="mthtel">Mother's Phone Number</label>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type='submit' class="btn bg-info" id="btnregstud">Save</button>

                        <button type="button" id="clearbtn" class="btn btn-danger">Clear All</button>

                    </form>

                <?php
                }else{

                            ?>

                            <h3 class="text-danger">Sorry, you cannot have access to this component at the moment, your portal subscription is over</h3>
                            <?php
                }

                ?>
                </div>
            </div>
        </div>
    </div>

    <div class="mainform content row bg-transparent pl-4" id="viewassess">
        <div class="col-md-12" id="assess_header">
            <div class="alert alert-info">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-12 col-12 hidden-sm hidden-xs pt-3">
                        <h3>Manage Assessment</h3>
                    </div>
                    <br>
                    <div class="col-md-9 col-12">
                        <div class="md-form bg-white pl-2">
                            <i class="prefix fa fa-search"></i>
                            <input type="search" class="form-control" id="txtsearch"/>
                            <label for="txtsearch">Search assessment...</label>
                        </div>
                    </div>
                </div>
                <form id="filter-form">
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-6 col-8">
                            <label class="control-label" style="color: #FFFFFF;">Subject:</label>
                            <select class="form-control" id="assess-subjt">
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
                        <div class="col-lg-2 col-md-2 col-sm-2 col-4">
                            <label class="control-label" style="color: #FFFFFF;;">Year:</label>
                            <select class="form-control" id="assess-ayear">
                            </select>
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-1 col-4">
                            <label class="control-label" style="color: #FFFFFF;">Term:</label>
                            <select class="form-control" id="assess-term">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 col-8">
                            <label style="color: #FFFFFF;" class="control-label">Class:</label>
                            <select class="form-control" id="assess_class">
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
                        <div class="col-lg-1 col-md-1 col-sm-4 col-6">
                            <br>
                            <button title="Reload the content" data-toggle="tooltip" class="btn btn-warning btn-sm"
                                    id="reloadbtn5"> Reload <i class="fa fa-refresh "></i></button>
                        </div>
                        <div class="col-lg-1 col-md-1 sm-4 col-6">
                            <br>
                            <button title="Print this assessment" data-toggle="tooltip" class="btn btn-warning btn-sm"
                                    id="btnprintassess">Print <i class="fa fa-print "></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-12 m-0"
             style="margin-top: -20px !important;"
             id="assess-container">
        </div>
    </div>
    <div class="mainform content row"
         style="background: #fff; box-shadow: 0 0 2px ; padding: 0; margin-right: 0 !important; margin-left: 0 !important; margin-bottom: 3em;"
         id="waec">
        <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="background-color: #17a2b8; padding: 10px;">
            <div class="row">
                <div class=" col-md-6 col-sm-8 col-sm-6 col-6">
                    <div class="md-form">
                        <i class="prefix fa fa-search text-white"></i>
                        <input type="search" id="waec-search" class="form-control text-white">
                        <label for="waec-search" class="form-control-label text-white">enter name to search..</label>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">
                    <select id="waec-ayear" class="form-control">
                        <?php
                        $years = mysqli_query($cf->con, "select distinct(ayear) from stuinfo where form = 3");
                        while ($year = mysqli_fetch_object($years)) {
                            ?>
                            <option><?= $year->ayear ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">
                    <button onclick="addwaec();" class="btn btn-good"
                            style="color: #FFFFFF !important; font-weight: bold; border: 1px solid #fff;">ADD
                    </button>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">
                    <button id="asaddbtn" data-toggle="dropdown" rolw="button" aria-haspopup="true"
                            aria-expanded="false" class="btn btn-good waves-effect waves-button"
                            style="color: #FFFFFF !important;">PRINT <i class="fa fa-caret-down"></i></button>
                    <ul class="dropdown-menu animated zoomIn" aria-labelledby="asaddbtn">
                        <li class="dropdown-item text-muted" style="cursor:pointer;"><a class="text-muted" href="#"
                                                                                        onclick="printsubanalysis(); return false;">Subject
                                Base Analysis</a></li>
                        <li class="dropdown-item text-muted" style="cursor:pointer;"><a class="text-muted" href="#"
                                                                                        onclick="printproganalysis(); return false;">Programme
                                Base Analysis</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="waec-content"></div>
    </div>

    <div class="mainform content row"
         style="background: transparent; box-shadow: 0 0 0 ; padding: 0; margin-right: 0 !important; margin-left: 0 !important; margin-bottom: 3em;"
         id="print-pool">
    </div>
    <div class="mainform content row"
         style="background: transparent; box-shadow: 0 0 0 ; padding: 0; margin-right: 0 !important; margin-left: 0 !important; margin-bottom: 3em; margin-top: 7em;"
         id="schres">
    </div>
    <div class="mainform row content"
         style="background: transparent; box-shadow: 0 0 0 ; padding: 0; margin-right: 0 !important; margin-left: 0 !important; margin-bottom: 3em; margin-top: 4em !important;"
         id="graph-class">
        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="alert alert-info">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                        <label style="color: #FFFFFF;" for="" class="control-label">Class</label>
                        <select name="chart-class" id="chart-class" class="form-control">
                            <?php
                            $cls = mysqli_query($cf->con, "select * from classes where id in(select class from stuinfo where form = '3')");
                            while ($row = mysqli_fetch_object($cls)) {
                                ?>
                                <option value="<?= $row->id ?>"><?= $row->classname ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                        <label style="color: #FFFFFF;" for="" class="control-label">Academic Year</label>
                        <select name="" id="chart-ayear" class="form-control">
                            <?php
                            $ayear = mysqli_query($cf->con, "select distinct(ayear) from stuinfo where  form = '3'");
                            while ($row = mysqli_fetch_object($ayear)) {
                                ?>
                                <option value="<?= $row->ayear ?>"><?= $row->ayear ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-6">
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
        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card card-default">
                <div class="card-body">
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
                                    </td>
                                </tr>
                                <tr>
                                    <td>No. Of Girls Who passed</td>
                                    <td style="background: rgba(21, 255, 25, 1);">
                                     </td>
                                </tr>
                                <tr>
                                    <td>No. Of Boys Who Failed</td>
                                    <td style="background: rgba(255, 21, 24, 1);">
                                       &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td>No. Of Girls Who Failed</td>
                                    <td style="background: rgba(255, 140, 31, 1);">
                                      </td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mainform content row"
         style="background: transparent; box-shadow: 0 0 0 ; padding: 0;  margin-right: 0 !important; margin-left: 0 !important; margin-bottom: 3em; margin-top: 1.7em;"
         id="promtstud">
        <form id="frmpromotstud">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="margin: 0 !important;">
                <div class="alert bg-warning">
                    <h4><i class="fa fa-warning"></i> Please promote seniors first before juniors to prevent mix-up of students. </h4>
                    <h4><i class="fa fa-warning"></i> please make sure you select the correct destination academic year, form and classs before clicking to promote </h4>
                </div>
                <div class="alert alert-info" style="margin: 1px !important;">
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-12 col-12 col-lg-offset-2 col-md-offset-2">
                            <h3 class="text-danger">FROM:</h3>
                        </div>
                        <!------------------------------------------------------->
                        <div class="col-lg-2 col-md-2 col-sm-8 col-xs-8">
                            <label style="color:#fff;" class="control-label">Class:</label>
                            <select class="form-control" id="prmfrom_class" name="prmfrom_class">
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
                        <div class="col-lg-2 col-md-2 col-sm-8 col-xs-8">
                            <label style="color:#fff;" class="control-label">Form</label>
                            <select name="prmfrom_form" class="form-control" id="prmfrom-form">
                                <option value="1">Form 1</option>
                                <option value="2">Form 2</option>
                                <option value="3">Form 3</option>
                                <option value="4">Form 4</option>
                            </select>
                        </div>
                          <div class="col-lg-2 col-md-2 col-sm-8 col-xs-8">
                            <label style="color:#fff;" class="control-label">Academic Year:</label>
                            <select name="prmfrom_ayear" class="form-control" id="prmfrom-ayear">
                                <?php
                                $conf = new config();
                                $conf->connect();
                                $ayer5 = mysqli_query($conf->con, "select distinct(ayear) from stuinfo");
                                while ($yearrow5 = mysqli_fetch_object($ayer5)) {
                                    ?>
                                    <option><?= $yearrow5->ayear ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                            <button onclick="$('#prmfrom_class').change(); return false;" class="btn waves-button">
                                Load
                            </button>
                        </div>
                    </div>
                    <!--end of from filter-->
                    <div style="border-bottom: 1px solid #ccc; margin: 1px;"></div>
                    <div class="row">
                        <div style="color:#fff;"
                             class="col-lg-2 col-md-2 col-sm-12 col-12 col-lg-offset-2 col-md-offset-2">
                            <h3 class="text-info">TO:</h3>
                        </div>
                        <!------------------------------------------------------->
                        <div class="col-lg-2 col-md-2 col-sm-8 col-xs-8">
                            <label style="color:#fff;" class="control-label">Class:</label>
                            <select name="prmto_class" class="form-control" id="prmto_class">
                                <?php
                                $tskcl5 = new Rclass();
                                $tskcls5 = $tskcl5->getclasses();
                                while ($clrow5 = mysqli_fetch_object($tskcls5)) {
                                    ?>
                                    <option value="<?= $clrow5->id; ?>"><?= $clrow5->classname; ?> </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <!----------------------------->
                        <!--------------------------------------->
                        <div class="col-lg-2 col-md-2 col-sm-8 col-xs-8">
                            <label style="color:#fff;" class="control-label">Form</label>
                            <select name="prmto_form" class="form-control" id="prmto-form">
                                <option value="1">Form 1</option>
                                <option value="2">Form 2</option>
                                <option value="3">Form 3</option>
                                <option value="4">Form 4</option>
                            </select>
                        </div>
                        <!----------------------------------->
                        <!------------------------>
                        <div class="col-lg-2 col-md-2 col-sm-8 col-xs-8">
                            <label style="color:#fff;" class="control-label">Academic Year:</label>
                            <select name="prmto_ayear" class="form-control" id="prmtoyear">
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-8 col-xs-8">
                            <button type="button" onclick="promotstuds();" class="wb wb-good"
                                    style="color:#FFFFFF; border-color: #FFFFFF;;">Promote <span
                                        class="fa fa-arrow-right"></span></button>
                       </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-12" id="promt-container">
                <center><h3 class="text-muted"><i class="fa fa-filter"></i> Please filter students to promote or click
                        the load button</h3></center>
            </div>
        </form>
    </div>
    <div class="mainform content row"
         style="background: transparent; box-shadow: 0 0 0 ; padding: 0; margin-right: 0 !important; margin-left: 0 !important;"
         id="print-pool">
    </div>
    <div class="mainform content row"
         style="background: transparent; box-shadow: 0 0 0 ; padding: 0; margin-right: 0 !important; margin-left: 0 !important;"
         id="smsreport">
        <div class="row" style="background-color: #17a2b8;">
            <div class="col-lg-8 col-md-8 col-sm-10 col-xs-10" style="color: #FFFFFF;">
                <br>
                <h4><i class="fa fa-history"></i> SMS Report History</h4>

            </div>
            <div class="col-lg-4 col-md-4 col-sm-2 col-xs-2" style="color: #FFFFFF;">
                <br>
                <button onclick="sendSMSreport();" class="btn pull-right waves-effect waves-light"
                        style="background-color: #17a2b8; border:1px solid #FFFFFF;">Send New<i
                            class="fa fa-send-o"></i></button>
            </div>
        </div>
        <div id="smsreport-cont"></div>
    </div>
    <div class="mainform content row"
         style="background: transparent; box-shadow: 0 0 0 ; padding: 0; margin-right: 0 !important; margin-left: 0 !important;"
         id="smsnotif">
        <div class="row" style="background-color: #17a2b8;">
            <div class="col-lg-8 col-md-8 col-sm-10 col-xs-10" style="color: #FFFFFF;">
                <br>
                <h4><i class="fa fa-info-circle"></i><sup><i class="fa fa-history"></i></sup> SMS Notification History
                </h4>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-2 col-xs-2" style="color: #FFFFFF;">
                <br>
                <button onclick="sendSMSnotif();" class="btn pull-right waves-effect waves-light"
                        style="background-color: #17a2b8; border:1px solid #FFFFFF;">Send New<i
                            class="fa fa-send-o"></i></button>
            </div>
        </div>
        <div id="smsnotif-cont"></div>
    </div>
        </div>

    </div>







</div>
<script src="assets/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="js/popper.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/bootstrap-dialog.min.js" type="text/javascript"></script>
<script src="js/dropzone.min.js" type="text/javascript"></script>
<script src="js/snarl.min.js" type="text/javascript"></script>
<script src="js/waves.min.js" type="text/javascript"></script>
<script src="js/chart.js" type="text/javascript"></script>
<script src="js/mdb.min.js" type="text/javascript"></script>
<script src="js/wejs.js" type="text/javascript"></script>
<?php
    if(!$sch->sub_expired()){
        ?>
        <button class="btn btn-circle floating-right bg-info waves-effect waves-float waves-light add-btn"
                style="display: none;"><i class="fa fa-plus"></i></button>

        <?php
    }

?>


<script type="text/javascript">

    //App routes

    const routes = [
        {
            route:'/regdept',
            callback: function () {
                return getdepts();

            },
            showBtn:true
        },

        {
            route:'/regclass',
            callback: function () {
                return getclass();

            },
            showBtn:true
        },

        {
            route:'/regsubjts',
            callback: function () {
                return  getsubjts();

            },
            showBtn:true
        },
        {
            route:'/reghouse',
            callback: function () {
                return gethouses();
            },
            showBtn:true
        },
        {
            route:'/regstaf',
            callback: function () {
                return  getstaff();
            },
            showBtn:true
        },
        {
            route:'/regstud',
            callback: function () {
                return regstud();
            },
            showBtn:false
        },
        {
            route:'/viewstuds',
            callback: function () {
                return  getstud(1);
            },
            showBtn:false
        },
        {
            route:'/viewexeats',
            callback: function () {
                return get_exeats();
            },
            showBtn:false
        },
        {
            route:'/viewassess',
            callback: function () {
                return getass();
            },
            showBtn:false
        },
        {
            route:'/viewassess',
            callback: function () {
                return false;
            },
            showBtn:false
        },

        {
            route:'/smsreport',
            callback: function () {
                return  getsmshistory();
            },
            showBtn:false
        },
        {
            route:'/smsnotif',
            callback: function () {
                return  getsmsnotifhistory();
            },
            showBtn:false
        },
        {
            route:'/waec',
            callback: function () {
                return getwaec();
            },
            showBtn:false
        },
        {
            route:'/graph-class',
            callback: function () {
                return false;
            },
            showBtn:false
        },

        {
            route:'/graph-class',
            callback: function () {
                return false;
            },
            showBtn:false
        },

    ];

    //

    function fireRoute(target) {

        let current_route = routes.filter(function (route) {
            return route.route === target;
        });
        if ( current_route.length > 0 ){
            document.getElementById('maincontent').innerHTML = document.getElementById('loading').innerHTML;
            let routBlock = current_route[0];

        //fire the route action
            routBlock.callback();

        //show the add button if true
            if(routBlock.showBtn) {
                $(".add-btn").fadeIn(100);

            }else{
                $(".add-btn").fadeOut(100);
            }
        }else{
            show_404();
        }
    }

    $(window).ready(function(){

        $(window).on('hashchange', function (e) {
            const rawtag = window.location.hash;
            const target = window.location.hash.replace('#', '');
            localStorage.tget = target;
            fireRoute(target);

        }).trigger('hashchange');
    });






</script>


<!--loader-->
<div id="loading" class="d-none container" >

<div class='container pt-5' style="margin-top: 300px" >
    <div class='loading'>
        <div class='loader--dot'></div>
        <div class='loader--dot'></div>
        <div class='loader--dot'></div>
        <div class='loader--dot'></div>
        <div class='loader--dot'></div>
        <div class='loader--dot'></div>
        <div class='loader--text'></div>
    </div>
</div>
</div>
<!--loader-->


</body>
</html>
<!-- dialogs ---->
<div class="search-pane bg-info" style="opacity: 1 !important;">
    <div class="container-fluid rgba-amber-strong">
        <div class="search-header">
            <div class="row">
                <div class="col-md-1 col-1">
                    <button type="button" class="btn btn-bad btn-sm search-close"><i
                                class="fa fa-remove fa-4x text-white"></i></button>
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