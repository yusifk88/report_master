<?php
include_once 'objts/config.php';
include_once 'objts/school.php';
$sch = new school();
if($sch->SMSsub == true){
$cf = new config();
$cf->connect();
$cls = mysqli_query($cf->con, "select * from classes order by classname ASC");
$ayear = mysqli_query($cf->con, "select distinct(acyear) from records");
$stud = mysqli_query($cf->con, "select id,fname,lname,oname from stuinfo order by fname ASC");
?>
<form>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <label class="control-label" for="cls">Class</label>
            <select id="SMScls" class="form-control">
                <?php
                while ($row = mysqli_fetch_object($cls)) {
                    ?>
                    <option value="<?= $row->id; ?>"><?= $row->classname; ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>
    <div class="row">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <label class="control-label" for="cls">Academic Year</label>
            <select id="SMSayer" class="we-select form-control">
                <?php
                while ($row2 = mysqli_fetch_object($ayear)) {

                    ?>
                    <option><?= $row2->acyear; ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <label class="control-label" for="cls">Term</label>
            <select id="SMSterm" class="we-select form-control">
                <option>1</option>
                <option>2</option>
                <option>3</option>
            </select>
        </div>

    </div>
</form>
<script type="text/javascript">
    function sendreports() {
        var cls = $("#SMScls").val();
        var ayear = $("#SMSayer").val();
        var term = $("#SMSterm").val();

        var data = {
            cls: cls,
            ayear: ayear,
            term: term
        };
        fullProg();

        $
            .post("send_SMSreports.php", data)

            .done(function (data) {
                remove_fullprog();
                getsmshistory();
                BootstrapDialog.show({
                    title: "SMS Reports",
                    message: data,
                    buttons: [{
                        label: "Close", cssClass: "btn-danger", action: function (d) {
                            d.close();
                        }
                    }]

                });

            })

            .error(function () {

                show_error();
            });
    }
</script>

<?php
}else{
    ?>


    <div class="alert bg-warning"><h5><i class="fa fa-warning"></i> You have not subscribed to our SMS plan, please contact for us an SMS plan to broadcast your reports</h5></div>


    <?php
}
?>
