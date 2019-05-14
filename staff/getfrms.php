<?php
include_once '../admin/objts/config.php';
include_once '../admin/objts/school.php';
$cf = new config();
$cf->connect();
$cls = $_GET['cls'];
$ayear = $_GET['ayear'];
$term = $_GET['term'];
$search = $_GET['search'];
$per_page = 50;
$page_query = mysqli_query($cf->con, "select count(frmass.id) as cn from frmass,stuinfo where frmass.stid = stuinfo.id and frmass.term = '$term' and frmass.ayear='$ayear' and frmass.cls = '$cls' and (stuinfo.fname LIKE '%$search%' or stuinfo.lname LIKE '%$search%')");
$pages = ceil(mysqli_fetch_object($page_query)->cn / $per_page);
$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $per_page;
$recs = mysqli_query($cf->con, "select frmass.stid,frmass.term,frmass.ayear,frmass.id,stuinfo.fname,stuinfo.lname,stuinfo.oname,frmass.attdance,frmass.attnded,frmass.cnduct,frmass.attitude,frmass.interest,frmass.remark from frmass,stuinfo where frmass.stid = stuinfo.id and frmass.term = '$term' and frmass.ayear='$ayear' and frmass.cls = '$cls' and (stuinfo.fname LIKE '%$search%' or stuinfo.lname LIKE '%$search%' or stuinfo.oname LIKE '%$search%') order by stuinfo.fname LIMIT " . $start . "," . $per_page);
$sch = new school();
if (mysqli_num_rows($recs) > 0) {
    ?>
    <div class="card">
            <div class="table-responsive">
                <table class="table table-sm table-hover table-striped table-bordered" id="assess-table">
                    <thead class="bg-info text-white">
                    <tr>
                        <th >
                            S/N
                        </th>
                        <th >
                            Student's Name
                        </th>
                        <th >
                            Total Attendance
                        </th>

                        <th >
                            Total Attended
                        </th>

                        <th >
                            Conduct
                        </th>

                        <th >
                            Interest
                        </th>

                        <th >
                            Remark
                        </th>

                        <th colspan="2" >
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody id="assess-content">
                    <?php
                    $a = 1;
                    while ($recrow = mysqli_fetch_assoc($recs)) {
                        ?>
                        <tr id="frm_row<?= $recrow['id'] ?>">
                            <td><?= $a; ?></td>
                            <td><?= $recrow['fname'] . " " . $recrow['lname'] . " " . $recrow['oname']; ?></td>
                            <td style="text-align: center; vertical-align: middle;"><?= $recrow['attdance']; ?></td>
                            <td style="text-align: center; vertical-align: middle;"><?= $recrow['attnded']; ?></td>
                            <td style="text-align: center; vertical-align: middle;"><?= $recrow['cnduct']; ?></td>
                            <td style="text-align: center; vertical-align: middle;"><?= $recrow['interest']; ?></td>
                            <td style="text-align: center; vertical-align: middle;"><?= $recrow['remark']; ?></td>
                            <td style="text-align: center; vertical-align: middle;"><i data-toggle='tooltip'
                               onclick="updatefrm(<?= $recrow['id'] ?>,<?= $recrow['stid'] ?>,<?= $recrow['term'] ?>,'<?= $recrow['ayear']; ?>')"
                               title="Make changes to this record"
                               style="color: deepskyblue; cursor: pointer;"
                               class="fa fa-edit waves-effect waves-circle"></i>
                            </td>
                            <td style="text-align: center; vertical-align: middle;"><i data-toggle='tooltip'
                               onclick="delfrm(<?= $recrow['id']; ?>)"
                               title="Delete this record permanently"
                               style="color: red; cursor: pointer;"
                               class="fa fa-remove waves-effect waves-circle"></i>
                            </td>
                        </tr>
                        <?php
                        $a++;
                    }
                    ?>
                    </tbody>
                </table>

        </div>
    </div>
    <?php
    $next = $page + 1;
    $prev = $page - 1;
    if ($page > 1) {
        ?>
        <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <nav>
        <ul class="pager">
        <li><a style="cursor:pointer;" onclick="assess_page(1);">&LessLess;&LessLess; First page</a></li>
        <li><a style="cursor:pointer;" onclick="assess_page(<?= $prev; ?>);">&LessLess; Prev.</a></li>
        <?php
    }
if ($pages > 1){
    ?>
    <nav>
    <ul class="pager">

    <li class="next">
    <select id="cbopage-list2" class="we-select">

    <?php
    for ($x = 1; $x <= $pages; $x++) {
        ?>

        <?php
        if ($x === $page) {
            ?>
            <option value="<?php echo $x; ?>" selected="selected"><?php echo "Page " . $x ?></option>

            <?php
        } else {
            ?>

            <option value="<?= $x; ?>"><?php echo "Page " . $x ?></option>


            <?php
        }


        ?>
        <?php
    }
} ?>

    </select></li>
    <?php

    if (($page < $pages)) { ?>

        <li><a style="cursor:pointer;" onclick="assess_page(<?= $next; ?>)">Next &GreaterGreater;</a></li>
        <li><a style="cursor:pointer;" onclick="assess_page(<?= $pages; ?>)">Last Page
                &GreaterGreater;&GreaterGreater; </a></li>
        <?php
    }
    ?>



    </ul>
    </nav>
    </div>
    </div>

<?php } else {
    echo '<center><h2 class="text-muted"><span class="glyphicon glyphicon-warning-sign"></span>No record exist for the filter</h2></center>';
} ?>

<script type="text/javascript">
    function updatefrm(id, stid, term, ayear) {

            BootstrapDialog.show({
                title: "Update Form Record",
                message: "<div id='frm-cont'></div>",
                size: "size-wide",
                buttons: [{
                    label: "Update", cssClass: "bg-info", action: function (d) {
                        fullProg();
                        $.get("upfrm.php?id=" + $("#upfrmid").val() + "&attndance=" + $("#upfrmattndance").val() + "&attnded=" + $("#upfrmattnded").val() + "&cnduct=" + $("#upfrmcnduct").val() + "&interest=" + $("#upfrminterest").val() + "&remark=" + $("#upfrmremark").val() + "&ayear=" + $("#frm-ayear").val() + "&term=" + $("#frm-term").val(), function (data) {
                            $("#frm_class").change();
                            d.close();
                        });

                        remove_fullprog();
                    }

                }],
                onshown:function(){
                    showprogress('frm-cont');
                    $.get("getfrmupdate.php?id=" + id + "&term=" + term + "&ayear=" + ayear + "&stid=" + stid, function (data) {
                    })
                        .done(function (data) {

                            $("#frm-cont").html(data);

                        })
                        .error(function () {
                           show_error();
                           cloasedlgs();

                        });

                }
            });

    }

    //-----------------------------------------------------------------------------------
    function delfrm(id) {

        BootstrapDialog.show({
            title: "Confirm Close",
            message: "This record will be permanently removed from the server, proceed?",
            buttons: [{
                label: "DELETE", cssClass: "btn-outline-danger", action: function (d) {
                    fullProg();
                    $.get("delfrm.php?id=" + id, function () {

                    }).done(function () {
                        remove_fullprog();
                        $("#frm_row" + id).fadeOut(100).remove();
                        d.close();
                    });
                }
            }]
        });

    }

    function assess_page(p) {
        showprogress('frm-container');
        $.get("getfrms.php?cls=" + $("#frm_class").val() + "&ayear=" + $("#frm-ayear").val() + "&term=" + $("#frm-term").val() + "&page=" + p + "&search=" + $("#frm-search").val(), function (data) {
            $("#frm-container").hide();
            $("#frm-container").html(data);
        }).done(function () {
            $("#frm-container").fadeIn(300);
            finish();
        });
    }

    function deslelect() {

        $("tbody tr").css("background-color", "#fff");
        $("tbody tr").css("color", "#000");
    }

    function select(elmt) {

        $(elmt).parent().css("background-color", "green");
        $(elmt).parent().css("color", "#fff");
        $(elmt).trigger("create");
    }

    $(document).ready(function () {
        $("td").mousedown(function () {
            deslelect();
            select(this);
        });
        $("td").mouseup(function () {
            select(this);


        });
        //------------------------------------------
        $("#attndance,#attnded").keypress(function (e) {

            if (!((e.which >= 47 && e.which <= 58) || e.which === 8 || e.which === 0)) {
                e.preventDefault();

            }
        });
        //-----------------------------------------
        $("#cbopage-list2").change(function () {
            var page = $(this).val();
            assess_page(page);

        });
        $("span").tooltip();

    });
</script>