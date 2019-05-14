<?php
include_once './objts/config.php';
include_once './objts/school.php';
$cf = new config();
$cf->connect();
$cls = $_GET['cls'];
$ayear = $_GET['ayear'];
$form = $_GET['form'];


$recs = mysqli_query($cf->con, "select id,fname,lname,oname from stuinfo where ayear = '$ayear' and class='$cls' and form = '$form' order by fname ASC");
$sch = new school();
if (mysqli_num_rows($recs) > 0) {
    ?>
    <div class="card card-info">

        <div class="table-responsive">
            <table class="table table-sm table-hover table-striped table-bordered" id="assess-table">
                <thead class="bg-info text-white">
                <tr>
                    <th>
                        S/N
                    </th>
                    <th>
                        Student's Name
                    </th>

                    <th>
                        Term 1 Fails
                    </th>

                    <th>
                        Term 2 Fails
                    </th>

                    <th>
                        Term 3 Fails
                    </th>
                    <th>
                        Total Fails
                    </th>
                    <th>
                        <center>
                            <div class="form-check">
                                <input type="checkbox" id="checkall" class=" form-check-input"/> <label for="checkall"
                                                                                                        class="form-check-label">Select
                                    All</label>
                            </div>
                        </center>
                    </th>


                </tr>
                </thead>
                <tbody>


                <?php
                $a = 1;
                while ($recrow = mysqli_fetch_assoc($recs)) {
                    $id = $recrow['id'];

                    $fails1 = mysqli_fetch_object(mysqli_query($cf->con, "select count(*) as cn from records where stid = '$id' and acyear = '$ayear' and term = '1' and ((subtotl*$sch->clscore_ratio)/$sch->sba+(exam*($sch->exam_ratio/100))) < 35"))->cn;
                    $fails2 = mysqli_fetch_object(mysqli_query($cf->con, "select count(*) as cn from records where stid = '$id' and acyear = '$ayear' and term = '2' and ((subtotl*$sch->clscore_ratio)/$sch->sba+(exam*($sch->exam_ratio/100))) < 35"))->cn;
                    $fails3 = mysqli_fetch_object(mysqli_query($cf->con, "select count(*) as cn from records where stid = '$id' and acyear = '$ayear' and term = '3' and ((subtotl*$sch->clscore_ratio)/$sch->sba+(exam*($sch->exam_ratio/100))) < 35"))->cn;


                    ?>
                    <tr>
                        <td style="text-align: center;"><?= $a; ?></td>
                        <td><?= $recrow['fname'] . " " . $recrow['lname'] . " " . $recrow['oname']; ?></td>


                        <td style="text-align: center;"><?= $fails1; ?></td>
                        <td style="text-align: center;"><?= $fails2; ?></td>
                        <td style="text-align: center;"><?= $fails3; ?></td>
                        <td style="text-align: center;"><?= ($fails1 + $fails2 + $fails3); ?></td>
                        <td style="text-align: center;"><input type="checkbox" name="selectchk[]" id="selectchk"
                                                               value="<?= $id; ?>"/></td>


                    </tr>
                    <?php
                    $a++;
                }
                ?>
                </tbody>
            </table>
        </div>

    </div>


<?php } else {
    echo '<center><h2 class="text-muted"><span class="glyphicon glyphicon-warning-sign"></span>No record exist for the filter</h2></center>';
} ?>

<script type="text/javascript">
    $(document).ready(function () {


        //--------------------------------------
        $("#checkall").change(function () {

            var status = $("#checkall").prop("checked");
            var len = $("input#selectchk").length;

            for (var i = 0; i < len; i++) {

                $("input#selectchk")[i].checked = status;
            }

        });

    });
</script>