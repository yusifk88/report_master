<?php
include_once("../admin/objts/config.php");
$cf = new config();
$id = $_GET['id'];
$cf->connect();
$lend = mysqli_query($cf->con,"select stuinfo.fname,stuinfo.lname,stuinfo.oname,stuinfo.photo,books_lend.*,books.title from stuinfo,books_lend,books where stuinfo.id = books_lend.stid and books_lend.bid = books.id and books_lend.id = '$id'");
$item = mysqli_fetch_object($lend);
?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="list-group">
            <div class="list-group-item">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <img class="img-fluid img-thumbnail img-rounded" src="../admin/<?=$item->photo?>" alt="<?=$item->fname?> 's photo">
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <strong>Name:</strong> <?=$item->fname ." ".$item->lname." ".$item->oname?>
                            </div>
                            <div class="list-group-item">
                                <strong>Book:</strong> <?=$item->title?>
                            </div>
                            <div class="list-group-item list-group-item-warning">
                                <strong>Lend Date:</strong> <?=$item->lenddate?>
                            </div>
                            <div class="list-group-item list-group-item-danger">
                                <strong>Expected Return Date:</strong> <?=$item->returndate?>
                            </div>

                            <div class="list-group-item list-group-item-success">
                                <label for="" class="form-control-label">Return Date</label>
                                <input id="return_date" type="date" class="form-control" placeholder="selected Date">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
