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
    <link href="css/ui-lightness/jquery-ui-1.10.4.min.css" rel="stylesheet" type="text/css"/>
    <link href="start/jquery-ui.theme.min.css" rel="stylesheet" type="text/css"/>
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="css/dropzone.min.css" rel="stylesheet" type="text/css"/>
    <link href="css/basic.min.css" rel="stylesheet" type="text/css"/>
    <link href="css/snarl.min.css" rel="stylesheet" type="text/css"/>
    <link href="css/waves.min.css" rel="stylesheet" type="text/css"/>
    <link href="css/bootstrap-dialog.min.css" rel="stylesheet"/>
    <link href="css/bootstrap.min.css" rel="stylesheet"/>
    <link href="css/mdb.min.css" rel="stylesheet"/>
    <link href="css/mystyle.css" rel="stylesheet"/>
</head>
<body>
<input type="hidden" id="global_stfid" value="<?= $_SESSION['ad_id'] ?>">
<input type="hidden" id="global_usertype" value="<?= $_SESSION['ad_utype'] ?>">
<nav class="navbar navbar-expand-md fixed-top bg-info  ">
    <div class="container-fluid">
        <div class="navbar-header" style="transition: .3s ease-in-out !important;">
            <a class="navbar-brand hidden-md mr-4 float-left" id="nav-back" href="#"><i
                        class="fa fa-long-arrow-left text-white"> </i></a>
            <a class="navbar-brand hidden-xs hidden-sm text-white m-0" href="#"
               style="font-weight: bold; color: #fff !important;"
               onclick="return false;"> <?= $_SESSION['ad_fname'] . " " . $_SESSION['ad_lname'] . " [" . $_SESSION['ad_utype'] . "]"; ?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav ml-auto ">
                <li class="nav-item text-center" title="View user activity Log" data-toggle="tooltip"><a
                            onclick="actlog(); return false;" style="color: #fff;" href="#" class=" nav-link"><i
                                class="fa fa-binoculars"></i>
                    </a></li>
                <li class="nav-item text-center" title="Print record entry Log" data-toggle="tooltip"><a
                            onclick="entrylog(); return false;" style="color: #fff;" href="#" class=" nav-link"><i
                                class="fa fa-arrow-down"></i><i class="fa fa-arrow-up"></i>
                    </a></li>
                <li title="Manage deadline" data-toggle="tooltip" class="nav-item text-center text-white"><a
                            onclick="setdeadline(); return false;" href="#" class="nav-link"><i
                                class="fa fa-clock-o text-white"></i>
                    </a></li>
                <li class="nav-item text-center"><a onclick="showinfo(); return false;" class="nav-link text-white"><i
                                class="fa fa-info-circle"></i>
                    </a></li>
                <li class="nav-item text-center text-white"><a id="hlpmnu" onclick="showhelp(); return false;"
                                                               href="#Help" class="nav-link text-white"><i
                                class="fa fa-lightbulb-o text-white"></i> </a></li>
                <li class="nav-item text-center"><a href="#" onclick="logout(); return false;" class="nav-link"><i
                                class="fa fa-sign-out text-white"></i>
                    </a></li>
                <li class="nav-item text-white text-center"><a id="searchbtn" href="#"
                                                               onclick="showsearch(); return false;"
                                                               class="bg-info text-white nav-link"><i
                                style="font-weight: bolder;" class="fa fa-search"></i>

                    </a></li>
            </ul>
        </div>
        <button id="menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                class="navbar-toggler collapsed ml-auto p-0"><i
                    class="fa fa-ellipsis-v navbar-toggler-icon text-white"></i></button>
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
<!--/ top navigation -->
<div class="container-fluid" style="margin-bottom:7em;">
    <div class="row main-search-cont p-2 bg-light hoverable" style="margin-top: 3.5rem; box-shadow: 0 0 3px; ">
        <div class="col-lg-10 col-md-10 col-12 col-sm-12 col-lg-offset-1 col-md-offset-1">
            <div class="md-form">
                <i class="prefix fa fa-search"></i>
                <input id="main-search" type="search" class="form-control main-search"/>
                <label for="main-search">Type a name to search...</label>
            </div>
        </div>
    </div>
    <?=$_SESSION['school_id']?>
    <!-- start menu -->
    <div class="startmenu" style="display: none;">
        <!---fisrt row ------------------------------------------------------------------------>
        <div class="tile-group">
            <div class="row hidden-xs hidden-sm">
                <div class="col-lg-10 col-md-10">
                    <span class="pull-left tile-group-heading">General</span>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                    <a href="#/regstud" style="text-decoration: none;">
                        <div class="tile tile-blue" data-id="#regstud" data-get="student">
                            <i class="fa fa-user tile-icon"></i><i class="fa fa-plus"></i>
                            <p class="title">New student</p>
                            <small class="detail hidden-sm font-small">
                                register new students into the system.
                            </small>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                    <a href="#/regstaf" style="text-decoration: none;">
                        <div class="tile tile-brown" data-id="#regstaf" data-get="staff">
                            <i class="fa fa-users tile-icon"></i>
                            <p class="title">Staff</p>
                            <small class="detail hidden-sm font-small">
                                register new staff that would use the system.
                            </small>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                    <a href="#/regclass" style="text-decoration: none;">
                        <div class="tile tile-red" data-id="#regclass" data-get="classes">
                            <i class="fa fa-home tile-icon"></i>
                            <p class="title">Classes</p>
                            <small class="detail hidden-sm">
                                Register classes that are in the school

                            </small>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                    <a href="#/regdept" style="text-decoration: none;">

                        <div class="tile tile-violet" data-id="#regdept" data-get="depts">
                            <i class="fa fa-star-o tile-icon"></i>
                            <p class="title">Programs</p>
                            <small class="detail hidden-sm font-small">
                                Register the programs that are offered in the school.
                            </small>
                        </div>
                    </a>
                </div>
            </div>

            <!---fisrt row ------------------------------------------------------------------------>
            <!---second row ------------------------------------------------------------------------>

            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                    <a href="#/regsubjts" style="text-decoration: none;">

                        <div class="tile tile-pink" data-id="#regsubjts" data-get="subjts">

                            <i class="fa fa-book tile-icon"></i>

                            <p class="title">Subjects</p>

                            <small class="detail hidden-sm">
                                Register All subjects in the school

                            </small>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                    <a href="#/reghouse" style="text-decoration: none;">

                        <div class="tile tile-green-yellow" data-id="#reghouse" data-get="house">
                            <i class="fa fa-bank tile-icon"></i>
                            <p class="title"> Houses</p>
                            <small class="detail hidden-sm">
                                Register the houses in the school
                            </small>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                    <a href="#/viewstuds" style="text-decoration: none;">

                        <div class="tile tile-deepblue" data-id="#viewstuds" data-get="getstud">
                            <i class="fa fa-users tile-icon"></i>
                            <p class="title">Manage Students</p>
                            <small class="detail hidden-sm">
                                View and manage students' information
                            </small>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                    <a href="#/viewexeats" style="text-decoration: none;">

                        <div class="tile tile-grey" data-id="#viewexeats" data-get="exeats">

                            <span class="fa fa-id-card-o tile-icon"></span>

                            <p class="title">Exeat Records</p>

                            <small class="detail hidden-sm font-small">
                                View exeats signed by house masters/mistresses and the senior house master/mistress
                            </small>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                    <a href="#/viewassess" style="text-decoration: none;">

                        <div class="tile tile-violet" data-id="#viewassess" data-get="assess">

                            <span class="fa fa-line-chart tile-icon"></span>

                            <p class="title">View Assessments</p>

                            <small class="detail hidden-sm">
                                View assessment records such as class task,assignments,project etc.
                            </small>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                    <a href="#smsreport" onclick="" style="text-decoration: none;">
                        <div class="tile tile-grey" data-id="#smsreport" data-get="smsreports">
                            <i class="fa fa-inbox tile-icon"></i><sup><i class="fa fa-mail-forward"></i></sup>
                            <p class="title">Broadcast Reports</p>
                            <small class="detail hidden-sm">
                                send reports to parents through SMS
                            </small>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                    <a href="#smsnotif" onclick="" style="text-decoration: none;">
                        <div class="tile tile-blue" data-id="#smsnotif" data-get="smsnotif">
                            <i class="fa fa-info-circle tile-icon"></i><sup><i class="fa fa-mail-forward"></i></sup>
                            <p class="title">Broadcast Notifications</p>
                            <small class="detail hidden-sm">
                                send a common message to parrents thruogh SMS
                            </small>
                        </div>
                    </a>
                </div>

            </div>

        </div>

        <div class="tile-group">
            <div class="row hidden-xs hidden-sm">
                <div class="col-lg-10 col-md-10">
                    <span class="pull-left tile-group-heading">WAEC Records</span>

                </div>

            </div>


            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                    <a href="#/waec" style="text-decoration: none;">
                        <div class="tile tile-green-yellow" data-id="#waec" data-get="waec">
                            <i class="fa fa-balance-scale tile-icon"></i>
                            <p class="title">Manage WAEC Records</p>
                            <small class="detail hidden-sm">
                                Manage WASSCE results of final year students
                            </small>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                    <a href="#/graph-class" style="text-decoration: none;">
                        <div class="tile tile-black" data-id="#graph-class" data-get="graphclass">
                            <i class="fa fa-pie-chart tile-icon"></i>
                            <p class="title">Graphical Analysis by Class</p>
                            <small class="detail hidden-sm">
                                View the graphical representation of waec records under a selected class
                            </small>
                        </div>
                    </a>
                </div>

            </div>
        </div>
        <div class="tile-group hidden-sm hidden-xs">
            <div class="row hidden-xs hidden-sm">
                <div class="col-lg-10 col-md-10">
                    <span class="pull-left tile-group-heading">Print Documents</span>
                </div>
            </div>
            <!---second row ------------------------------------------------------------------------>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                    <a href="#/print-pool" style="text-decoration: none;">

                        <div class="tile tile-pink" data-id="#print-pool" data-get="printcls">
                            <i class="fa fa-print tile-icon"><sup><i class="fa fa-user"></i></sup></i>
                            <p class="title">Print Class List</p>
                            <small class="detail hidden-sm">
                                Generate and Print list of students in a particular class
                            </small>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                    <a href="#/print-pool" style="text-decoration: none;">
                        <div class="tile tile-blue" data-id="#print-pool" data-get="printprog">
                            <i class="fa fa-print tile-icon"><sup><i class="fa fa-list-alt"></i></sup></i>
                            <p class="title">Print Programe List</p>
                            <small class="detail hidden-sm">
                                Generate and print a list students under a particular programe
                            </small>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                    <a href="#/print-pool" style="text-decoration: none;">
                        <div class="tile tile-red" data-id="#print-pool" data-get="printhse">
                            <i class="fa fa-print tile-icon"><sup><span class="fa fa-home"></span></sup></i>
                            <p class="title">Print House List</p>
                            <small class="detail hidden-sm">
                                Generate and print a list of students under a particular house
                            </small>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                    <a href="#/print-pool" style="text-decoration: none;">

                        <div class="tile tile-brown" data-id="#print-pool" data-get="printsign">
                            <i class="fa fa-print tile-icon"></i>
                            <p class="title">Print sign List</p>
                            <small class="detail hidden-sm">
                                Generate and Print a list of students to be signed against by the students.
                            </small>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                    <a href="#/print-pool" style="text-decoration: none;">
                        <div class="tile tile-orange" data-id="#print-pool" data-get="rep_all">
                            <i class="fa fa-print tile-icon"><sup><i class="fa fa-id-badge"></i></sup></i>
                            <p class="title">Print Report[All]</p>
                            <small class="detail hidden-sm">
                                Generate and Print reports for all students in a particular class
                            </small>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                    <a href="#/print-pool" style="text-decoration: none;">

                        <div class="tile tile-green" data-id="#print-pool" data-get="brdsheet">
                            <i class="fa fa-print tile-icon"><sup><i class="fa fa-list-ul"></i></sup></i>
                            <p class="title">Print Broadsheet</p>
                            <small class="detail hidden-sm">
                                generate and Print a broad performance sheet containing all subjects along with
                                scores...
                            </small>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                    <a href="#/print-pool" style="text-decoration: none;">

                        <div class="tile tile-violet" data-id="#print-pool" data-get="formlst">
                            <i class="fa fa-print tile-icon"><sup><span class="fa fa-file"></span></sup></i>
                            <p class="title">Print Form List</p>
                            <div class="detail visible-lg visible-md">
                                Print a list of students under a specific form
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                    <a href="#/print-pool" style="text-decoration: none;">

                        <div class="tile tile-black" data-id="#print-pool" data-get="scoresht">
                            <i class="fa fa-print tile-icon"><sup><span class="fa fa-file"></span></sup></i>
                            <p class="title">Print Score Sheet</p>
                            <small class="detail visible-lg visible-md">
                                Print a sheet that can be used to gather students' records
                            </small>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                    <a href="#/print-pool" style="text-decoration: none;">

                        <div class="tile tile-red" data-id="#print-pool" data-get="wdraw">
                            <span class="fa fa-print tile-icon"><sup><i class="fa fa-undo"></i></sup></span>
                            <p class="title">Print Withdrawal List</p>
                            <small class="detail visible-lg visible-md">
                                Print a list of students that were withdrawn in an academic year
                            </small>
                        </div>
                    </a>
                </div>


                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                    <a href="#/print-pool" style="text-decoration: none;">
                        <div class="tile tile-green" data-id="#print-pool" data-get="frmres">
                            <span class="fa fa-print tile-icon"><sup><i class="fa fa-area-chart"></i></sup></span>
                            <p class="title">Print form Averages</p>
                            <small class="detail visible-lg visible-md">
                                Print a list of students of a certain form ranked by their general performance for the
                                term
                            </small>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                    <a href="#/print-pool" style="text-decoration: none;">
                        <div class="tile tile-blue" data-id="#print-pool" data-get="clavg">
                            <span class="fa fa-print tile-icon"><sup><i class="fa fa-address-card-o"></i></sup></span>
                            <p class="title">Print Class Averages</p>
                            <small class="detail visible-lg visible-md">
                                Print list of students in a class with their overall averages and ranking
                            </small>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                    <a onclick="print_avgs(); return false;" style="text-decoration: none;">
                        <div class="tile tile-deepblue" data-id="#print-pool" data-get="clavg">
                            <span class="fa fa-print tile-icon"><sup><i class="fa fa-calculator"></i></sup></span>
                            <p class="title">Print Accumulated Averages</p>
                            <small class="detail visible-lg visible-md">
                                Print list of students in a class with their overall averages and ranking
                            </small>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                    <a href="#/print-pool" style="text-decoration: none;">

                        <div class="tile tile-blue" data-id="#print-pool" data-get="genpop">
                            <span class="fa fa-print tile-icon"><sup><i class="fa fa-users"></i></sup></span>
                            <p class="title">Print general Population</p>
                            <small class="detail visible-lg visible-md">
                                Generate and print a list of all students in the school per an academic year
                            </small>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <!--admin tools-->
        <div class="tile-group">
            <div class="row hidden-xs hidden-sm">
                <div class="col-lg-10 col-md-10">
                    <span class="pull-left tile-group-heading">Utilities</span>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                    <a href="#/promtstud" style="text-decoration: none;">
                        <div class="tile tile-violet" data-id="#promtstud" data-get="prmtstud">
                            <i class=" fa fa-user tile-icon"><sup><span class="fa fa-arrow-right"></span></sup></i>
                            <p class="title">Promote Students</p>
                            <small class="detail visible-lg visible-md">
                                Move some group of students to a new class
                            </small>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                    <a href="#/print-pool" style="text-decoration: none;">

                        <div onclick="localStorage.addtest='accounts';" class="tile tile-blue" data-id="#print-pool"
                             data-get="accounts">
                            <span class=" fa fa-user tile-icon"><sup><span class="fa fa-lock"></span></sup></span>
                            <p class="title">User Accounts</p>
                            <small class="detail visible-lg visible-md">
                                Manage login accounts for authorised users
                            </small>
                        </div>
                    </a>
                </div>


            </div>
        </div> <!--  end of admin tools-->
    </div>
    <div class="row">
        <div class="m-auto col-lg-8 col-md-8 col-sm-12 col-12 col-md-offset-2 col-lg-offset-2">
            <div class="mainform content" id="regdept">

            </div>
            <div class="mainform content" id="regclass">

            </div>
            <div class="mainform content" id="regsubjts">
            </div>
            <div class="mainform content" id="reghouse">

            </div>
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
    <div class="row content" id="regstud" style="display: none; margin-top: 1.7em;">
        <div class="col-lg-10 col-md-10 col-sm-12 col-12 col-lg-offset-2 col-md-offset-2">
            <div class="card card-info">
                <div class="card-heading bg-info text-white p-2">
                    <br> REGISTER STUDENT <i class="fa fa-user-plus fa-2x"></i>
                </div>
                <div class="card-body" style="padding: 10px !important;">
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
                </div>
            </div>
        </div>
    </div>

    <div class="mainform content row bg-transparent pl-4" id="viewassess">
        <div class="col-md-12">
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
        <div class="col-lg-12 col-md-12 col-sm-12 col-12 m-0" style="margin-top: -20px !important;"
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
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/jquery-ui-1.10.4.min.js" type="text/javascript"></script>
<script src="js/popper.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/bootstrap-dialog.min.js" type="text/javascript"></script>
<script src="js/dropzone.min.js" type="text/javascript"></script>
<script src="js/snarl.min.js" type="text/javascript"></script>
<script src="js/waves.min.js" type="text/javascript"></script>
<script src="js/chart.js" type="text/javascript"></script>
<script src="js/mdb.min.js" type="text/javascript"></script>
<script src="js/wejs.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function (){
        Waves.init();
        Waves.attach('.tile', ['waves-float', 'waves-light']);
        Waves.attach('button', ['waves-button']);
        $("div.dropzone").dropzone(
            {
                url: "./dropfile.php",
                acceptedFiles: "image/*",
                addRemoveLinks: true,
                dictDefaultMessage: "drop photo here or click to upload",
                dictRemoveFile: "Remove photo",
                resizeWidth: "180",
                resizeHeight: "200",
                resizeMethod: "crop",
                capture: null,
                removedfile: function (file) {
                    $.get("rmphoto.php?file=" + file.name, function () {
                    }).done(function () {
                        $("#photo").val("dpic/photo.jpg");
                        var previewElement;
                        return (previewElement = file.previewElement) != null ?
                            (previewElement.parentNode.removeChild(file.previewElement)) : (void 0);
                    });
                },
                maxFiles: 1,
                accept: function (file, done) {
                    $("#photo").val("temppic/" + file.name);
                    done();
                }
            });
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

        //---------------------------------------------------------------------------------------

        var d = new Date();
        var td = d.getDate();
        var tmon = d.getMonth() + 1;
        var tyea = d.getFullYear();
        $("#dor").val(tyea + "-" + tmon + "-" + td);

        // showstart();

        //-------------------------------------------------------------------------------------------------------------------------
        $("#dept").change(function () {
            if ($("#dept").val() !== "Select") {
                var tmpop = "<option value=''>Getting classes</option>";
                var me = $(this);
                $.get("getclassbydep.php?depid=" + me.val(), null, function (d) {
                    $("#clas").html(d);
                }).done(function (d) {
                });
            } else {
                $("#clas").html("");

            }
        });

        //------------------------------------------------------------------------------------------------------------------------


        //------------------------------------------------------------------------------------------------------------------------

        $(".add-btn").click(function (e) {
            if (addtest === "depts") {
                var temp = "<div class='col-lg-12 col-md-12 col-sm-12 col-12'><form><div class='md-form'><i class='prefix fa fa-star-o'></i>";
                temp += "<input type ='text' class='form-control'  id='depname' />";
                temp += "<label  for ='depname'>Department Name/Description</label></div>";
                temp += "</form></div>";
                BootstrapDialog.show({
                    title: "Add a Program/department",
                    message: temp,
                    buttons: [{
                        label: "SAVE", cssClass: "bg-info text-white", action: function (d) {

                            if ($("#depname").val() === "") {

                                $("#depname").focus();

                            } else {

                                $.get("savedep.php?depname=" + $("#depname").val().toString(), null, function (data) {

                                    getdepts();
                                    $("#depname").val("");
                                    $("#depname").focus();
                                    Snarl.addNotification({
                                        title: "SAVED",
                                        text: "Programe/Department creates successfully",
                                        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle'></i>",
                                        timeout: 3000
                                    });
                                    $(".snarl-notification").addClass('snarl-success');


                                });


                            }


                        }
                    }]


                });


            } else if (addtest === "classes") {

                $.get("adclass_inputs.php", null, function (data) {
                }).done(function (data) {

                    BootstrapDialog.show({
                        title: "Add a class",
                        message: data,
                        buttons: [{
                            label: "SAVE", cssClass: "bg-info text-white", action: function (d) {

                                if (!$("#classname").val()) {
                                    $("#classname").focus();

                                    return false;
                                }


                                $.get("saveclass.php?dpid=" + $("#dep").val() + "&classname=" + $("#classname").val(), null, function (data) {
                                }).done(function (data) {
                                    $("#classname").val("");
                                    $("#classname").focus();
                                    getclass();
                                    Snarl.addNotification({
                                        title: "SAVED",
                                        text: data,
                                        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle'></i>",
                                        timeout: 3000
                                    });
                                    $(".snarl-notification").addClass('snarl-success');


                                });

                            }
                        }]

                    });


                });

            } else if (addtest === "subjts") {
                var temp = "<form><div class='col-lg-12 col-md-12 col-sm-12 col-12'><div class='md-form'><i class='prefix fa fa-book'></i>";
                temp += "<input type ='text' class='form-control'  id='subname' />";
                temp += "<label class='control-label' for ='subname'>Subject Name</label></div>";
                temp += "<label class='control-label' for ='subtype'>Subject Type</label>";
                temp += "<select class='form-control' id='subtype'>";
                temp += "<option>Core Subject</option>";
                temp += "<option>Elective Subject</option>";
                temp += "</select>";
                temp += "</form></div>";
                BootstrapDialog.show({
                    title: "Add a Subject",
                    message: temp,
                    buttons: [{
                        label: "SAVE", cssClass: "btn-good waves-button waves-effect", action: function (d) {
                            if ($("#subname").val() === "") {
                                $("#subname").focus();
                            } else {

                                $.get("savesub.php?subname=" + $("#subname").val().toString() + "&type=" + $("#subtype").val(), null, function (data) {

                                    $("#subname").val("").focus();
                                    getsubjts();
                                    Snarl.addNotification({
                                        title: "SAVED",
                                        text: data,
                                        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle'></i>",
                                        timeout: 3000
                                    });
                                    $(".snarl-notification").addClass('snarl-success');


                                });


                            }

                        }
                    }]

                });


                //---------------------------------------------------adding house
            } else if (addtest === "house") {
                var temp = "<form><div class='col-lg-12 col-md-12 col-sm-12 col-12'><div class='md-form'><i class='prefix fa fa-home'></i>";
                temp += "<input type ='text' class='form-control' id='name' />";
                temp += "<label for ='name'>House Name</label></div><div class='md-form'><i class='prefix fa fa-file-text-o'></i>";
                temp += "<input type='text' class='form-control'  id='des'>";
                temp += "<label class='control-label' for ='subtype'>House Description</label></div>";
                temp += "<label class='control-label' for ='subtype'>House Type</label>";
                temp += "<select id='house-type' class='form-control'>";
                temp += "<option value='genhouse'>General House</option>";
                temp += "<option value='ghouse'>Girls House</option>";
                temp += "<option value='bhouse'>Boys House</option>";
                temp += "</select>";
                temp += "</form></div>";
                BootstrapDialog.show({
                    title: "Create New House",
                    message: temp,

                    buttons: [{
                        label: "SAVE", cssClass: "btn-good waves-button waves-effect", action: function (d) {

                            if ($("#name").val() === "" || $("#des").val() === "") {
                                $("#name").focus();
                            } else {

                                $.get("savehouse.php?name=" + $("#name").val().toString() + "&des=" + $("#des").val() + "&htype=" + $("#house-type").val(), null, function (data) {
                                    gethouses();
                                    $("#name").val("");
                                    $("#des").val("");
                                    $("#name").focus();
                                    Snarl.addNotification({
                                        title: "SAVED",
                                        text: data,
                                        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle'></i>",
                                        timeout: 3000
                                    });
                                    $(".snarl-notification").addClass('snarl-success');

                                });
                            }
                        }
                    }]
                });

            } else if (addtest === "staff") {
                //starting
                var temp = "<form><div class='col-lg-12 col-md-12 col-sm-12 col-12'>";
                temp += "<div class='row'>";
                temp += "<div class='col-lg-6 col-md-6 col-sm-12 col-12'>";
                temp += "<div class='md-form'>";
                temp += "<i class='prefix fa fa-user'></i>";

                temp += "<input type ='text' class='form-control' id='stffname' />";
                temp += "<label for ='stffname'>First Name</label>";
                temp += "</div>";
                temp += "</div>";
                temp += "<div class='col-lg-6 col-md-6 col-sm-12 col-12'>";
                temp += "<div class='md-form'>";
                temp += "<i class='prefix fa fa-user'></i>";
                temp += "<input type='text' class='form-control' id='stflname' />";
                temp += "<label  for ='stflname'>Last Name</label>";
                temp += "</div> </div></div>";
                temp += "<div class='row'>";
                temp += "<div class='col-lg-4 col-md-4 col-sm-12 col-12'>";
                temp += "<label class='control-label' for ='gender'>Gender</label>";
                temp += "<select class='form-control' id='gender'><option>Male</option><option>Female</option></select>";
                temp += "</div>";
                temp += "<div class='col-lg-4 col-md-4 col-sm-12 col-12'>";
                temp += "<div class='md-form'>";
                temp += "<i class='prefix fa fa-phone'></i>";
                temp += "<input type='text' class='form-control' id='cont'><br/>";
                temp += "<label for ='cont'>Contact Number</label>";
                temp += "</div></div>";
                temp += "<div class='col-lg-4 col-md-4 col-sm-12 col-12'>";
                temp += "<label class='control-label' for ='rank'>Rank</label>";
                temp += "<select class='form-control' id='rank'><option value='0'>Senior Sup't</option><option value='1'>Prin. Sup't</option><option value='2'>Assist. Dir. ii</option><option value='3'>Assist. Dir. I</option><option value='4'>Dep. Dir.</option><option value='5'>Dir. II</option><option value='6'>Dir. I</option></select>";
                temp += "</div> </div> <div class='row'>";
                temp += "<div class='col-lg-3 col-md-3 col-sm-12 col-12'>";
                temp += "<div class='md-form'>";
                temp += "<i class='prefix fa fa-id-badge'></i>";
                temp += "<input type='text' class='form-control' id='stfid'><br/>";
                temp += "<label for ='stfid'>Staff ID No.</label>";
                temp += "</div></div>";
                temp += "<div class='col-lg-3 col-md-3 col-sm-12 col-12'>";
                temp += "<div class='md-form'>";
                temp += "<i class='prefix fa fa-calendar-check-o active'></i>";
                temp += "<input type='date' class='form-control' id='sdob' />";
                temp += "<label for ='sdob' class='active'>D.O.B</label>";
                temp += "</div></div>";
                temp += "<div class='col-lg-3 col-md-3 col-sm-12 col-12'>";
                temp += "<div class='md-form'>";
                temp += "<i class='prefix fa fa-hashtag'></i>";
                temp += "<input type='text' class='form-control' id='regno'><br/>";
                temp += "<label for ='regno'>Registered No.</label>";
                temp += "</div></div>";
                temp += "<div class='col-lg-3 col-md-3 col-sm-12 col-12'>";
                temp += "<div class='md-form'>";
                temp += "<i class='prefix fa fa-id-card-o'></i>";
                temp += "<input type='text' class='form-control' id='ssnid'><br/>";
                temp += "<label for ='ssnid'>SSNIT No.</label>";
                temp += "</div></div>";
                temp += "</div>";
                temp += "<div class='row'>";
                temp += "<div class='col-lg-4 col-md-4 col-sm-12 col-12'>";
                temp += "<div class='md-form'>";
                temp += "<i class='prefix fa fa-graduation-cap'></i>";
                temp += "<input type='text' class='form-control' id='aqual'/>";
                temp += "<label for ='aqaul'>Academic Qualification</label>";
                temp += "</div></div>";
                temp += "<div class='col-lg-4 col-md-4 col-sm-12 col-12'>";
                temp += "<div class='md-form'>";
                temp += "<i class='prefix fa fa-star-o'></i>";
                temp += "<input type='text' class='form-control' id='pqual' />";
                temp += "<label  for ='pqual'>Professional Qualification</label>";
                temp += "</div></div>";
                temp += "<div class='col-lg-4 col-md-4 col-sm-12 col-12'>";
                temp += "<div class='md-form'>";
                temp += "<i class='prefix fa fa-calendar'></i>";
                temp += "<input type='date' class='form-control' id='appdate'><br/>";
                temp += "<label class='active' for ='appdate'>Date Of First Appointment</label>";
                temp += "</div> </div> </div>";
                temp += "<div class='row'>";
                temp += "<div class='col-lg-4 col-md-4 col-sm-12 col-12'>";
                temp += "<div class='md-form'>";
                temp += "<i class='prefix fa fa-calendar-plus-o'></i>";
                temp += "<input type='date' class='form-control' id='assdate'><br/>";
                temp += "<label class='active' for ='assdate'>Duty Assumed Date</label>";
                temp += "</div></div>";
                temp += "<div class='col-lg-4 col-md-4 col-sm-12 col-12'>";
                temp += "<div class='md-form'>";
                temp += "<i class='prefix fa fa-bank'></i>";
                temp += "<input type='text' class='form-control' id='bankname'><br/>";
                temp += "<label for ='bankname'>Associated Bank</label>";
                temp += "</div></div> ";
                temp += "<div class='col-lg-4 col-md-4 col-sm-12 col-12'>";
                temp += "<div class='md-form'>";
                temp += "<i class='prefix fa fa-hashtag'></i>";
                temp += "<input type='text' class='form-control' id='accno'><br/>";
                temp += "<label for ='accno'>Account Number</label>";
                temp += "</div></div></div>";
                temp += "<div class='card bg-secondary p-3 text-white'>Account information";
                temp += "<div class='row'>";
                temp += "<div class='col-lg-6 col-md-6 col-sm-12 col-12'>";
                temp += "<div class='md-form'>";
                temp += "<i class='prefix fa fa-user-circle-o'></i>";
                temp += "<input type ='text' class='form-control text-white' id='uname' />";
                temp += "<label class='control-label text-white' for ='uname' >User Name</label>";
                temp += "</div></div>";
                temp += "<div class='col-lg-6 col-md-6 col-sm-12 col-12'>";
                temp += "<div class='md-form'>";
                temp += "<i class='prefix fa fa-asterisk'></i>";
                temp += "<label class='control-label text-white'  for ='upass'>Password</label>";
                temp += "<input type='password' class='form-control' id='upass'>";
                temp += "</div> </div> </div>";
                temp += "<div class='row'>";
                temp += "<div class='col-lg-6 col-md-6 col-sm-12 col-12'>";
                temp += "</div>";
                temp += "<div class='col-lg-6 col-md-6 col-sm-12 col-12'>";
                temp += "<div class='md-form'>";
                temp += "<i class='prefix fa fa-asterisk'></i>";
                temp += "<input type='password' class='form-control' id='cpass'>";
                temp += "<label class='control-label text-white' for ='cpass'>Confirm Password</label>";
                temp += "</div> </div></div>";
                temp += "</form>";
                BootstrapDialog.show({
                    title: "Register Staff",
                    message: temp,
                    size: "size-wide",
                    buttons: [{
                        label: "SAVE", cssClass: "btn bg-info", action: function (d) {

                            if (!($("#upass").val() === $("#cpass").val())) {

                                Snarl.addNotification({
                                    title: "ERROR",
                                    text: "Passwords do not match, please check and try again",
                                    icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                                    timeout: 3000
                                });
                                $(".snarl-notification").addClass('snarl-error');

                                return false;

                            }

                            if (!$("#stffname").val() || !$("#stflname").val() || !$("#cont").val() || !$("#uname").val() || !$("#upass").val() || !$("#cpass").val()) {

                                Snarl.addNotification({
                                    title: "ERROR",
                                    text: "A field is left blank, please check and try again",
                                    icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                                    timeout: 3000
                                });
                                $(".snarl-notification").addClass('snarl-error');
                                return false;
                            } else {

                                var progress = Snarl.addNotification({
                                    title: "PROCCESSING",
                                    text: "Please Wait...",
                                    icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-circle-notch fa-spin'></i>",
                                    timeout: 3000
                                });
                                $(".snarl-notification").addClass('snarl-info');

                                $.get("savestaff.php?fname=" + $("#stffname").val().toString() + "&lname=" + $("#stflname").val() + "&gender=" + $("#gender").val() + "&cont=" + $("#cont").val() + "&uname=" + $("#uname").val() + "&upass=" + $("#upass").val() + "&rank=" + $("#rank").val() + "&stfid=" + $("#stfid").val() + "&sdob=" + $("#sdob").val() + "&regno=" + $("#regno").val() + "&aqual=" + $("#aqual").val() + "&pqual=" + $("#pqual").val() + "&appdate=" + $("#appdate").val() + "&assdate=" + $("#assdate").val() + "&bankname=" + $("#bankname").val() + "&accno=" + $("#accno").val() + "&ssnid=" + $("#ssnid").val(), null, function (data) {


                                }).done(function (data) {
                                    d.close();
                                    getstaff();
                                    Snarl.removeNotification(progress);
                                    Snarl.addNotification({
                                        title: "SAVED",
                                        text: data,
                                        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle'></i>",
                                        timeout: 3000
                                    });
                                    $(".snarl-notification").addClass('snarl-success');


                                }).error(function () {

                                    Snarl.removeNotification(progress);
                                    Snarl.addNotification({
                                        title: "ERROR",
                                        text: "Could not save staff, please try again",
                                        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                                        timeout: 3000
                                    });
                                    $(".snarl-notification").addClass('snarl-error');

                                });


                            }


                        }
                    }, {
                        label: "CANCEL", cssClass: "btn-bad waves-button waves-effect", action: function (d) {

                            d.close();

                        }
                    }]
                });

                //edding
            } else if (addtest === "accounts") {

                //add account-------------------------------------------- 

                var temp = "<form><div class='col-lg-12 col-md-12 col-sm-12 col-12'>";
                temp += "<div class='row'>";
                temp += "<div class='col-lg-6 col-md-6 col-sm-6 col-6'>";
                temp += "<label class='control-label' for ='stffname'>First Name</label>";
                temp += "<input type ='text' class='form-control' placeholder='Enter first Name' id='adfname' />";
                temp += "</div>";
                temp += "<div class='col-lg-6 col-md-6 col-sm-6 col-6'>";
                temp += "<label class='control-label' for ='stflname'>Last Name</label>";
                temp += "<input type='text' class='form-control' placeholder='Enter Last Name' id='adlname' />";
                temp += "</div> </div>";
                temp += "<div class='row'>";
                temp += "<div class='col-lg-6 col-md-6 col-sm-6 col-6'>";
                temp += "<label class='control-label' for ='gender'>Gender</label>";
                temp += "<select class='form-control' id='adgender'><option>Male</option><option>Female</option></select>";
                temp += "</div>";
                temp += "<div class='col-lg-6 col-md-6 col-sm-6 col-6'>";
                temp += "<label class='control-label' for ='cont'>Contact Number</label>";
                temp += "<input type='text' class='form-control' placeholder='Enter admin phone number' id='adcont'><br/>";
                temp += "</div> </div>";
                temp += "<div class='alert alert-info' style='padding:2px;'>Account information <span class='fa fa-hand-down'></span><br/>";
                temp += "<div class='row'>";
                temp += "<div class='col-lg-6 col-md-6 col-sm-6 col-6'>";

                temp += "<label class='control-label' for ='uname'>User Name</label>";
                temp += "<input type ='text' class='form-control' placeholder='Enter user Name' id='aduname' />";
                temp += "</div>";
                temp += "<div class='col-lg-6 col-md-6 col-sm-6 col-6'>";

                temp += "<label class='control-label' for ='upass'>Admin Password</label>";
                temp += "<input type='password' class='form-control' placeholder='Enter admin password' id='adupass'>";
                temp += "</div> </div>";
                temp += "<div class='row'>";
                temp += "<div class='col-lg-6 col-md-6 col-sm-6 col-6'>";
                temp += "</div>";
                temp += "<div class='col-lg-6 col-md-6 col-sm-6 col-6'>";

                temp += "<label class='control-label' for ='cpass'>Confirm admin Password</label>";
                temp += "<input type='password' class='form-control' placeholder='Enter admin password again' id='adcpass'>";
                temp += "</div> </div>";
                temp += "</form>";


                BootstrapDialog.show({
                    title: "Create Admin. Account",
                    message: temp,
                    buttons: [{
                        label: "CREATE", cssClass: "btn-good waves-button waves-effect", action: function (d) {

                            if (!($("#adupass").val() === $("#adcpass").val())) {

                                Snarl.addNotification({
                                    title: "ERROR",
                                    text: "Passwords do not match, please check and try again",
                                    icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                                    timeout: 3000
                                });
                                $(".snarl-notification").addClass('snarl-error');
                                return false;

                            }

                            if (!$("#adfname").val() || !$("#adlname").val() || !$("#adcont").val() || !$("#aduname").val() || !$("#adupass").val() || !$("#adcpass").val()) {

                                Snarl.addNotification({
                                    title: "ERROR",
                                    text: "A field is left blank, please check and try again",
                                    icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                                    timeout: 3000
                                });
                                $(".snarl-notification").addClass('snarl-error');

                                return false;
                            } else {

                                var progress = Snarl.addNotification({
                                    title: "PROCCESSING",
                                    text: "Please Wait...",
                                    icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-circle-notch fa-spin'></i>",
                                    timeout: 3000
                                });
                                $(".snarl-notification").addClass('snarl-info');
                                $.get("adadmin.php?fname=" + $("#adfname").val().toString() + "&lname=" + $("#adlname").val() + "&gender=" + $("#adgender").val() + "&cont=" + $("#adcont").val() + "&uname=" + $("#aduname").val() + "&upass=" + $("#adupass").val(), null, function (data) {
                                }).done(function (data) {
                                    d.close();
                                    getaccounts();
                                    Snarl.removeNotification(progress);
                                    Snarl.addNotification({
                                        title: "ACCOUNT CREATED",
                                        text: data,
                                        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle'></i>",
                                        timeout: 3000
                                    });
                                    $(".snarl-notification").addClass('snarl-success');

                                }).error(function () {
                                    Snarl.removeNotification(progress);
                                    Snarl.removeNotification(progress);
                                    Snarl.addNotification({
                                        title: "ERROR",
                                        text: "Could not creat account, please try again",
                                        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                                        timeout: 3000
                                    });
                                    $(".snarl-notification").addClass('snarl-error');

                                });
                            }


                        }
                    }]
                });


            }


        });

        $(".tile").click(function () {
            var target = $(this).attr("data-get");
            localStorage.addtest = target;
            localStorage.dget = target;
            addtest = localStorage.addtest;

        });


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

        $(".submit-btn").click(function () {
            var ins = $("#frmregdept :input");
            ins = ins.toArray();
            var id = $(this).attr("data-id").toString();
            d = saverecs(id);

        });
        $(".home-btn").click(function () {
            addtest = null;

            closewindow(".content");


        });
    });
</script>
<button class="btn btn-circle floating-right bg-info waves-effect waves-float waves-light add-btn"
        style="display: none;"><i class="fa fa-plus"></i></button>
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