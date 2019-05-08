<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title>SkoolRec|Student;s Portal</title>
    <link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/css/mdb.min.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/css/dashboard.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark sticky-top rgba-cyan-strong p-0">
    <a class="navbar-brand waves-effect pull-left waves-light col-sm-3 col-md-2 mr-0" style="vertical-align: middle; width: auto;" onclick="toggle_sidebar(); return false;" href="#"><i id="nav-btn" class="fa fa-long-arrow-left fa-2x text-white"></i></a>

    <a onclick="return false;" data-container="body" data-html="true" data-toggle="popover" data-placement="top" data-content="<div class='card animated fadeInUp'><img class='card-img-top' src='<?= str_replace("student/",'',base_url())?>admin/<?=$_SESSION['photo']?>'><div class='card-body'><a class='btn btn-block btn-clear rgba-cyan-strong waves-effect waves-light' href='<?=base_url()?>myprofile'> <i class='fa fa-gear'> </i>My Profile</a><br/><br/> <a class='btn btn-block btn-danger waves-effect waves-light' data-toggle='modal' data-target='#logoutmodal'> <i class='fa fa-sign-out'> </i>Log Out</a> </div></div>" class="navbar-brand col-sm-3 pull-right text-right waves-effect waves-light"  href="#" style="vertical-align: middle; width: auto;"><span class="hidden-sm"><?=$_SESSION['fname']." ".$_SESSION['lname']." ".$_SESSION['oname']?></span> <img class="img img-circle img-fluid m-1" src="<?= str_replace("student/",'',base_url())?>admin/<?=$_SESSION['photo']?>"></a>

<!--    <ul class="navbar-nav px-3 pull-right">-->
<!--        <li class="nav-item">-->
<!--        </li>-->
<!--    </ul>-->
</nav>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 col-sm-3 col-xs-3 sidebar bg-white card hoverable" id="sidebar">
            <div class="sidebar-sticky pt-5">
                <ul class="nav  flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?=($active == 0)?'active':''?> btn btn-block " href="<?=base_url()?>">
                            <i class="fa fa-dashboard fa-2x text-info">
                            Dashboard <span class="sr-only">(current)</span>
                            </i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-block <?=($active == 1)?'active':''?>  " href="myreports">

                            <i class="fa fa-files-o fa-2x text-info">
                                My Reports
                            </i>
                        </a>
                    </li>
                    </ul>
            </div>
        </nav>
        <main class="padding-left col-lg-12 col-md-12 col-sm-12 col-xs-12 pb-3" id="main-content">
            <input id="global_id" type="hidden" value="<?=$_SESSION['stid']?>">


            <div id="logoutmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLiveLabel">Confirm Log Out</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to log out of your portal?</p>
                            <a type="button" href="logout" class="btn btn-danger">Log Out</a>

                        </div>
                    </div>
                </div>
            </div>