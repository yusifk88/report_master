<?php
include_once("objts/config.php");
$cf = new config();
$cf->connect();
$search = $_GET['search'];
$books = mysqli_query($cf->con,"select * from books where title LIKE'%$search%' or author like '%$search%' or shelf like '%$search%' or descrip like '%$search%'");
if(mysqli_num_rows($books)>0){    ?>
    <div class="panel panel-info">
    <div class="panel-body">
    <div class="table-responsive">
    <table class="table table-striped table-condensed">
        <thead style="background-color: deepskyblue; color: #FFFFFF;
        ">
        <tr>
            <th>S/N</th>
            <th>Book Title</th>
            <th>Author</th>
            <th>Description</th>
            <th>ISBN No.</th>
            <th>Shelf</th>
            <th>Copies</th>
            <th>No. Good Copies</th>
            <th>No. Damaged</th>
            <th>No. Missing</th>
            <th colspan="5">Actions</th>
        </tr>
        </thead>
<tbody>
    <?php
    $i=1;
    while($b = mysqli_fetch_object($books)){
        ?>
        <tr id="row_<?=$b->id?>">
         <td><?=$i?></td>
         <td><?=$b->title?></td>
         <td><?=$b->author?></td>
         <td><?=$b->descrip?></td>
         <td><?=$b->isbn?></td>
         <td><?=$b->shelf?></td>
         <td><?=$b->copies?></td>
         <td><?=$b->copies-($b->numdamaged+$b->nummising)?></td>
         <td><?=$b->numdamaged?></td>
         <td><?=$b->nummising?></td>
         <td><i onclick="editbook(<?=$b->id?>)" title="Edit this book's details" class="fa fa-edit waves-effect" style="color:deepskyblue"></i></td>
         <td><i onclick="lendbook(<?=$b->id?>)" title="Lend this book to a student" class="fa fa-handshake-o waves-effect" style="color:deepskyblue"></i></td>
         <td><i onclick="mkdamaged(<?=$b->id?>,'<?=str_replace("'","",$b->title)?>',<?=$b->copies?>,<?=$b->numdamaged?>)" title="Record damaged copies" class="fa fa-chain-broken waves-effect text-warning"></i></td>
         <td><i onclick='mkmissing(<?=$b->id?>,"<?=str_replace("'","",$b->title)?>",<?=$b->copies?>,<?=$b->nummising?>)' title="Record missing copies" class="fa fa-warning waves-effect text-warning" ></i></td>
         <td><i onclick="delbook(<?=$b->id?>,'row_<?=$b->id?>')" title="Delete this book" class="fa fa-remove waves-effect text-danger" ></i></td>
        </tr>
    <?php
$i++;
}
 ?>
</tbody>
</table>
    </div>
    </div>
    </div>
<?php
}else{
    ?>
    <div class="alert alert-warning text-center"><i class="fa fa-warning fa-3x"></i><h3>No books found </h3></div>
    <?php
}
?>

<script>
    $("i").tooltip();
</script>