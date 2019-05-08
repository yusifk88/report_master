<?php
include_once("../admin/objts/config.php");
$cf = new config();
$cf->connect();
$st = $_GET['stid'];
$lendtest = mysqli_query($cf->con,"select books_lend.*,books.title from books_lend,books WHERE stid = '$st' and returned = FALSE and books.id = books_lend.bid");
$numbooks = mysqli_num_rows($lendtest);
if($numbooks > 0){
    ?>

    <div class="alert alert-danger">
        <h3>Note</h3>
        This student has <?=$numbooks?> book(s) in His/Her possession that he/she have not returned yet.
        <ul>
        <?php
        while($row = mysqli_fetch_object($lendtest)){
        ?>
    <li><?=$row->title?></li>

        <?php
        }

        ?>
    </ul>
    </div>

    <?php
}else{
    ?>

    <div class="alert alert-info">

        <h3>This student have NO book in his/her possession <i class="fa fa-check"></i></h3>
    </div>
<?php

}