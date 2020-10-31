<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
use APP\Staff;
use APP\config;
$stf = new Staff();
$cfg = new config();
$cfg->connect();
$stfid = $_GET['id'];
$stinfo = mysqli_fetch_object(mysqli_query($cfg->con, "select * from staff where id = '$stfid'"));
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border-bottom: 1px solid #cccccc; padding-bottom: 5px;">
        <form action="addfrm.php" id="addfrm">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <label class="control-label">Tutors' Name</label>
                    <input class="form-control" readonly type="text"
                           value="<?= $stinfo->fname . " " . $stinfo->lname ?>">
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <input type="hidden" id="stfid" name="stfid" value="<?= $_GET['id']; ?>"/>
                    <label class="control-label">Class</label>
                    <select name="cls" id="cls" class="form-control">
                        <?php
                        $clses = mysqli_query($cfg->con, "select * from classes WHERE id not in (SELECT clid FROM frmmaters)");
                        while ($row = mysqli_fetch_object($clses)) {
                            ?>
                            <option value="<?= $row->id; ?>"><?= $row->classname; ?></option>
                            <?php
                        }
                        ?>
                    </select> <br>
                </div>
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <button onclick="mkfrm()" id="btnaddfrm" type="button" class="btn btn-primary">Add <i
                                class="fa fa-plus-square-o"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive" style="background-color: #FFFFFF !important;">
            <?php
            $stfclasses = mysqli_query($cfg->con, "SELECT classes.classname,frmmaters.id from classes,frmmaters where frmmaters.stfid = '$stfid' and classes.id = frmmaters.clid");

            ?>
            <table class="table table-hover table-sm table-striped">
                <thead>
                <tr>
                    <th>Class</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody id="frmlist">
                <?php
                while ($row2 = mysqli_fetch_object($stfclasses)) {
                    ?>
                    <tr id="frm_row<?= $row2->id ?>">
                        <td><?= $row2->classname; ?></td>
                        <td><i onclick="remfrmm(<?= $row2->id; ?>)" style="cursor: pointer;" data-toggle="tooltip"
                               title="Remove" class="fa fa-remove text-danger waves-effect waves-circle"></i></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>

        </div>
    </div>
</div>