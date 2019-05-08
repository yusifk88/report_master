<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title>SkoolRec|Login</title>
    <link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/css/mdb.min.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/css/dashboard.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/css/font-awesome.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<main class="container pt-5">
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">


    </div>
    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
        <div class="card mt-5 hoverable animated fadeInUp">
    <div class="card-header rgba-cyan-strong text-white">
        <h4>Logon To your Portal</h4>
    </div>
            <div class="card-body">
                <form id="logonform">
                    <div class="md-form">
                        <i class="fa fa-user prefix text-info"></i>
                        <input required type="text" id="materialFormCardNameEx" name="stid" class="form-control">
                        <label for="materialFormCardNameEx" class="font-weight-light">Student ID</label>
                    </div>

                    <div class="md-form">
                        <i class="fa fa-lock prefix text-info"></i>
                        <input required type="password" name="stpassword" id="materialFormCardEmailEx" class="form-control">
                        <label for="materialFormCardEmailEx" class="font-weight-light">Your Password</label>
                    </div>
                    <br>
                    <button id="loginbtn" type="submit" class="btn btn-block rgba-cyan-strong">Login</button>
                </form>
            </div>


        </div>

        <br>
        <center>
            <span class="mt-5 pt-5" id="progcnt"></span>
        </center>

    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <div class="card rgba-orange-strong mt-5 text-white">
            <div class="card-body">
                <center>
                    <i class="fa fa-info-circle fa-5x "></i>
                </center>

                <strong>NOTE:</strong> IF YOU ARE HERE FOR THE FIRST TIME, PLEASE USE YOUR DATE OF BIRTH AS YOUR PASSWORD PLEASE ENTER YOUR DATE OF BIRTH IN THE FORMAT YYY/MM/DD <br> <br>
                PLEASE CONTACT YOUR SENIOR HOUSE MASTER IF YOU CAN'T RECOLLECT YOUR STUDENT ID NUMBER
            </div>
        </div>
    </div>
</div>
</main>
</body>
<script src="<?=base_url()?>assets/js/jquery-3.2.1.min.js"></script>
<script src="<?=base_url()?>assets/js/popper.min.js"></script>
<script src="<?=base_url()?>assets/js/bootstrap.bundle.min.js"></script>
<script src="<?=base_url()?>assets/js/mdb.min.js"></script>
<script>
    $(document).ready(function () {
    $("#logonform").submit(function () {
        let stdata = $("#logonform :input").serializeArray();
        $("#progcnt").html("<i class='fa fa-circle-o-notch fa-spin fa-2x text-info'></i>");
        $("#logonform :input").attr("disabled",true);
        $("#loginbtn").attr("disabled",true);
        $.getJSON("<?=base_url()?>login",stdata)
            .done(function (data) {
                if(data.status == "no"){
                    $("#progcnt").html("<i class='fa fa-bug fa-2x text-danger'>"+data.msg+"</i>");
                    $("#logonform :input").attr("disabled",false);
                    $("#loginbtn").attr("disabled",false);
                }else{
                    console.log(data);
                    window.location="./";
                }
            })
            .fail(function () {
                $("#progcnt").html("<i class='fa fa-bug fa-2x text-danger'> AW!, Something went wrong</i>");
                $("#logonform :input").attr("disabled",false);
                $("#loginbtn").attr("disabled",false);
            });

return false;
    });
    });
</script>
</body>
</html>
