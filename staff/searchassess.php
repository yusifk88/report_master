<?php
include_once './objts/config.php';
include_once './objts/school.php';
$cf = new config();
$cf->connect();
$cls = $_GET['cls'];
$ayear = $_GET['ayear'];
$term = $_GET['term'];
$subjt = $_GET['subjt'];
$stname = $_GET['stname'];

$recs = mysqli_query($cf->con, "select records.id,stuinfo.fname,stuinfo.lname,stuinfo.oname,classes.classname,records.term,records.acyear,subjects.subjdesc,ta1,ta2,ta3,ta4,hw1,hw2,hw3,hw4,pw1,pw2,subtotl,cvsubtotl,exam,cvexam,totlscore,grd,remark,post from records,stuinfo,classes,subjects where records.subjt = subjects.id and records.cls = classes.id and records.stid = stuinfo.id and records.term = '$term' and records.acyear='$ayear' and records.subjt = '$subjt' and records.cls = '$cls' and(stuinfo.fname like '%$stname%' or stuinfo.lname like '%$stname%') order by stuinfo.fname");
$sch = new school();
?>
<div class="panel panel-info">
    <div class="panel-body">
        <div class="table-responsive">

            <table class="table table-condensed table-hover table-striped table-bordered" id="assess-table">
                <thead>
                <tr style="background-color: deepskyblue; color: #fff;">
                    <th style="border: 1px solid deepskyblue;">
                        S/N

                    </th>

                    <th style="border: 1px solid deepskyblue;">
                        Student's Name

                    </th>


                    <th colspan="4" style="text-align: center; border: 1px solid deepskyblue;">
                        Class Task

                    </th>

                    <th colspan="4" style="text-align: center; border: 1px solid deepskyblue;">
                        Home Work

                    </th>

                    <th colspan="2" style="text-align: center; border: 1px solid deepskyblue;">
                        Proj. Work

                    </th>
                    <th style="text-align: center; border: 1px solid deepskyblue;">
                        SBA

                    </th>
                    <th style="text-align: center; border: 1px solid deepskyblue;">
                        SBA(<?= $sch->clscore_ratio . "%"; ?>)

                    </th>
                    <th style="text-align: center; border: 1px solid deepskyblue;">
                        Exam(100%)

                    </th>
                    <th style="text-align: center; border: 1px solid deepskyblue;">
                        Exam(<?= $sch->exam_ratio . "%"; ?>)

                    </th>
                    <th style="text-align: center; border: 1px solid deepskyblue;">
                        Total Score

                    </th>
                    <th style="text-align: center; border: 1px solid deepskyblue;">
                        Grade

                    </th>
                    <th style="text-align: center; border: 1px solid deepskyblue;">
                        Remark

                    </th>
                    <th style="text-align: center; border: 1px solid deepskyblue;">
                        Pos.

                    </th>
                    <th colspan="2" style="text-align: center; border: 1px solid deepskyblue;">
                        Action

                    </th>


                </tr>

                </thead>
                <tbody id="assess-content">


                <?php
                $a = 1;
                while ($recrow = mysqli_fetch_assoc($recs)) {
                    ?>
                    <tr>

                        <td><?= $a; ?></td>
                        <td><?= $recrow['fname'] . " " . $recrow['lname'] . " " . $recrow['oname']; ?></td>
                        <td style="text-align: center;"><?= $recrow['ta1']; ?></td>
                        <td style="text-align: center;"><?= $recrow['ta2']; ?></td>
                        <td style="text-align: center;"><?= $recrow['ta3']; ?></td>
                        <td style="text-align: center;"><?= $recrow['ta4']; ?></td>
                        <td style="text-align: center;"><?= $recrow['hw1']; ?></td>
                        <td style="text-align: center;"><?= $recrow['hw2']; ?></td>
                        <td style="text-align: center;"><?= $recrow['hw3']; ?></td>
                        <td style="text-align: center;"><?= $recrow['hw4']; ?></td>
                        <td style="text-align: center;"><?= $recrow['pw1']; ?></td>
                        <td style="text-align: center;"><?= $recrow['pw2']; ?></td>
                        <td style="text-align: center;"><?= $recrow['subtotl']; ?></td>
                        <td style="text-align: center;"><?= $recrow['cvsubtotl']; ?></td>
                        <td style="text-align: center;"><?= $recrow['exam']; ?></td>
                        <td style="text-align: center;"><?= $recrow['cvexam']; ?></td>
                        <td style="text-align: center;"><?= $recrow['totlscore']; ?></td>
                        <td style="text-align: center;"><?= $recrow['grd']; ?></td>
                        <td style="text-align: center;"><?= $recrow['remark']; ?></td>
                        <td style="text-align: center;"><?= $recrow['post']; ?></td>
                        <td><span data-toggle='tooltip' onclick="updateassess(<?= $recrow['id']; ?>)"
                                  title="Make changes to this record" style="color: deepskyblue; cursor: pointer;"
                                  class="glyphicon glyphicon-edit"></span></td>
                        <td><span data-toggle='tooltip' onclick="delass(<?= $recrow['id']; ?>)"
                                  title="Delete this record permanently" style="color: red; cursor: pointer;"
                                  class="glyphicon glyphicon-trash"></span></td>

                    </tr>


                    <?php
                    $a++;

                }


                ?>


                </tbody>
            </table>
        </div>
    </div>
</div>


<script>


    function delass(id) {
        $(".dlg-ex").html("This record will be permanently removed from the server, proceed?").dialog({
            modal: true,
            show: "bounce",
            hide: "fade",
            buttons: {
                No: function () {

                    $(this).dialog("close");
                },
                Yes: function () {
                    $.get("delass.php?id=" + id, function (data) {


                    }).done(function () {
                        $(".dlg-ex").dialog("close");
                        $("#assess_class").change();


                    });

                }

            }


        });


    }

    function assess_page(p) {

        $.get("getassess.php?cls=" + $(this).val() + "&ayear=" + $("#assess-ayear").val() + "&term=" + $("#assess-term").val() + "&subjt=" + $("#assess-subjt").val(), function (data) {
            $("#assess-container").hide();
            $("#assess-container").html(data);
            alert(data);
        }).done(function () {


            $("#assess-container").effect("drop", {mode: "show", direction: "left", height: "toggle"}, 500);

        });


    }

    $(document).ready(function () {
        $("span").tooltip();
        //$("#assess-table").dataTable();
    });


</script>