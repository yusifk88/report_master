<?php
include_once("objts/config.php");
$cf = new config();
$cf->connect();
$search = $_GET['search'];
$lends = mysqli_query($cf->con,"select stuinfo.fname,stuinfo.lname,stuinfo.oname,stuinfo.id as stid,books.id as bkid, books.title , books_lend.* from stuinfo, books_lend,books where books_lend.stid =  stuinfo.id and books.id = books_lend.bid and (stuinfo.fname LIKE '%$search%' or stuinfo.lname LIKE '%$search%' or stuinfo.oname LIKE'%$search%' or books.title LIKE '%$search%') ORDER by lenddate DESC , returned ASC ");
if(mysqli_num_rows($lends)>0){    ?>
    <div class="panel panel-info">
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-condensed table-hover">
                    <thead style="background-color: deepskyblue; color: #FFFFFF;
        ">
                    <tr>
                        <th>S/N</th>
                        <th>Student</th>
                        <th>Book</th>
                        <th>Lend Date</th>
                        <th>Expected Return Date</th>
                        <th>Return Status</th>
                        <th>Return Date</th>
                        <th colspan="5">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i=1;
                    while($l = mysqli_fetch_object($lends)){
                        ?>
                        <tr class="<?=$l->returned?'success':'danger'?>" id="lrow_<?=$l->id?>">
                            <td><?=$i?></td>
                            <td><a href="" onclick="printstud(<?=$l->stid?>); return false;"><?=$l->fname." ". $l->lname." ".$l->oname?></a></td>
                            <td><?=$l->title?></td>
                            <td><?=$l->lenddate?></td>
                            <td><?=$l->returndate?></td>
                            <td><?=$l->returned? "Returned":"Not Returned"?></td>
                            <td><?=$l->date_returned?></td>
                            <?php
                                if($l->returned){
                                    ?>
                                    <td><i class="fa fa-check-circle text-success" ></i></td>
                                    <?php
                                }else{
                                    ?>
                                    <td><i onclick="recievebook(<?=$l->id?>)" title="Collect this book" class="fa fa-arrow-right waves-effect text-success" ></i></td>
                                    <?php
                                }
                            ?>
                            <td><i onclick="dellend(<?=$l->id?>,'lrow_<?=$l->id?>')" title="Delete this record" class="fa fa-remove waves-effect text-danger" ></i></td>
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