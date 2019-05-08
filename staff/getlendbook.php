<?php
include_once("../admin/objts/config.php");
$cf = new config();
$cf->connect();
$bid = $_GET['bid'];
$book = mysqli_fetch_object(mysqli_query($cf->con,"select * from books where id='$bid'"));
$lends = mysqli_fetch_object(mysqli_query($cf->con,"select count(*) as cn from books_lend where bid ='$bid' and returned = false "))->cn;
$studs = mysqli_query($cf->con,"select * from stuinfo order BY fname");
?>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <label for="" class="form-check-label">Lend Date</label>
        <input type="date" id="lendstart" placeholder="Select date" class="form-control">
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <label for="" class="form-check-label">Return Date</label>
        <input type="date" id="lendend" placeholder="Select date" class="form-control">
    </div>
</div>

<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <div class="list-group list-group-flush">
            <div class="list-group-item" style="cursor: pointer;">
            <input id="lendsearch" type="search"  class="form-control" placeholder="search students by first name or last name">
            </div>
            <div id="lendstcont" style="max-height: 800px; overflow: auto;">
    <?php
    while($row = mysqli_fetch_object($studs)){
    ?>
        <div onclick="selectstud(<?=$row->id?>)" class="list-group-item st-item waves-effect waves-light" style="cursor: pointer;">
            <img height="70" width="60" src="../admin/<?=$row->photo?>" alt=""> <?=$row->fname?> <?=$row->lname?> <?=$row->oname?> <br>
            <button onclick="printstud(<?=$row->id; ?>)" class="btn btn-good waves-effect">View Details</button>
        </div>
    <?php
    }
    ?>
        </div>

        </div>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
        <div class="list-group list-group-flush">
            <input type="hidden" id="bid" value="<?=$bid?>">
            <div class="list-group-item">
                <strong>Title: </strong> <?=$book->title?>
            </div>
            <div class="list-group-item">
                <strong>Author: </strong> <?=$book->author?>
            </div>
            <div class="list-group-item">
                <strong>Shelf: </strong> <?=$book->shelf?>
            </div>
            <div class="list-group-item">
                <strong>Available Copies:</strong> <?=$book->copies-($book->nummising+$book->numdamaged+$lends)?>
            </div>
            <div class="list-group-item">
                <strong>Copies:</strong> <?=$book->copies?>
            </div>
            <div class="list-group-item">
                <strong>Missing Copies:</strong> <?=$book->nummising?>
            </div>
            <div class="list-group-item">
                <strong>Damaged Copies:</strong> <?=$book->numdamaged?>
            </div>
        </div>

        <div id="stlend_status" class="list-group-item">


        </div>
        </div>
        <input type="hidden" id="selected_id">
    </div>
</div>
<script>
    $("#lendsearch").keyup(function () {
    var search = $(this).val();
    showprogress("lendstcont");
        $
            .get("search_lend.php?lendsearch="+search)
            .done(function (list) {
                $("#lendstcont").html(list);
            });
        $("#selected_id").val("");
    });


    $("div.st-item").click(function () {
        $(".st-item").removeClass("st-selected");
        $(this).addClass("st-selected");
    });
</script>