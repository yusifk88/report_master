<?php
include_once("../admin/objts/config.php");
$cf = new config();
$cf->connect();
$bid = $_GET['bid'];
$binfo = mysqli_fetch_object(mysqli_query($cf->con,"select * from books WHERE id = '$bid'"));

?>

<form id="editbookfrm">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <input name="upbid" type="hidden" id="upbid" value="<?=$bid?>">
            <label class="control-label">Book Title</label>
            <input placeholder="Enter book title" class="form-control" value="<?=$binfo->title?>" id="upbookTitle" name="upbookTitle" required="" type="text">
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label class="control-label">Author(s)</label>
            <input placeholder="Enter name(s) of author(s) of the book" value="<?=$binfo->author?>" class="form-control" id="upbookAuthor" name="upbookAuthor" required="" type="text">
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label class="control-label">ISBN Number</label>
            <input class="form-control" id="bookISBN" value="<?=$binfo->isbn?>" name="upbookISBN" required="" type="text">
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label class="control-label">Shelf/Location</label>
            <input placeholder="describe the shelf in which the book can be found" value="<?=$binfo->shelf?>" class="form-control" id="upbookShelf" name="upbookShelf" required="" type="text">
        </div><div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <label class="control-label">Number Of Copies</label>
            <input min="1" value="<?=$binfo->copies?>" placeholder="Enter the number of copies of this book" class="form-control" id="upbookQty" name="upbookQty" required="" type="number">
        </div><div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label class="control-label">Custom Description</label>
            <textarea name="upbookDesc" id="bookDesc" class="form-control" placeholder="Describe the book in your own words"><?=$binfo->descrip?></textarea>
        </div>
    </div>
</form>
<script>

    $("form#editbookfrm").submit(function (e) {
        if(!$("#upbookTitle").val()){
            Snarl.addNotification({
                title:"ERROR",
                text:"The title is a required field",
                icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                timeout:4000
            });
            $(".snarl-notification").addClass('snarl-error');
            return false;
        }

        if(!$("#upbookAuthor").val()){
            Snarl.addNotification({
                title:"ERROR",
                text:"The book Author(s) is a required field",
                icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                timeout:4000
            });
            $(".snarl-notification").addClass('snarl-error');
            return false;
        }


        if(!$("#upbookShelf").val()){
            Snarl.addNotification({
                title:"ERROR",
                text:"The shelf is a required field",
                icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                timeout:4000
            });
            $(".snarl-notification").addClass('snarl-error');
            return false;
        }

        if(!$("#upbookQty").val()){
            Snarl.addNotification({
                title:"ERROR",
                text:"The no. of copies is a required field",
                icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                timeout:4000
            });
            $(".snarl-notification").addClass('snarl-error');
            return false;
        }


        var bdata = $("#editbookfrm :input").serializeArray();

        fullProg();

        $
            .post("updatebook.php",bdata)
            .done(function () {
                remove_fullprog();
                Snarl.addNotification({
                    title:"SAVED",
                    text:"Book info updated successfully",
                    icon:"<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle'></i>",
                    timeout:4000
                });
                $(".snarl-notification").addClass('snarl-success');
                getbooks();
                cloasedlgs();
            })

            .error(function () {
                remove_fullprog();
                show_error();
            });

        return false;
    });
</script>
