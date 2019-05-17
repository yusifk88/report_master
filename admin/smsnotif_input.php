<?php
include_once 'chck_sub.php';
include_once 'objts/config.php';
include_once 'objts/school.php';
$sch = new school();
if($sch->SMSsub == true) {
    $cf = new config();
    $cf->connect();

    $cls = mysqli_query($cf->con, "select * from classes order by classname ASC");
    $ayear = mysqli_query($cf->con, "select distinct(ayear) from stuinfo");
    $stud = mysqli_query($cf->con, "select id,fname,lname,oname from stuinfo order by fname ASC");

    ?>

    <form>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <label class="control-label" for="cls">Class</label>
                <select id="noticls" class="form-control">
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
                <select id="notiayer" class="we-select form-control">
                    <?php
                    while ($row2 = mysqli_fetch_object($ayear)) {

                        ?>
                        <option><?= $row2->ayear; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <label class="control-label" for="cls">Term</label>
                <select id="notiterm" class="we-select form-control">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                </select>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="md-form">
                    <i class="prefix fa fa-commenting-o"></i>
                    <textarea class="form-control md-textarea" name="notimsg" id="notimsg" cols="30"
                              rows="10"></textarea>
                    <label class="control-label" for="cls">Your Brief Message...</label>
                </div>
                <span class="text-warning">Please not that a single text message is 160 characters and if your message exceeds that it will be sent as multiple messages and that would cost more credit to submit your messages</span>
            </div>
        </div>
    </form>
    <script type="text/javascript">
        function sendnotif() {
            var cls = $("#noticls").val();
            var ayear = $("#notiayer").val();
            var term = $("#notiterm").val();
            var msg = $("#notimsg").val();
            var data = {
                cls: cls,
                ayear: ayear,
                term: term,
                msg: msg
            };
            if (data.cls.length > 0 && data.ayear.length > 0 && data.term.length > 0 && data.msg.length > 0) {
                fullProg();
                $
                    .post("send_SMSnotif.php", data)

                    .done(function (data) {
                        remove_fullprog();
                        getsmsnotifhistory();
                        BootstrapDialog.show({
                            title: "SMS Notification",
                            message: data,
                            buttons: [{
                                label: "Close", cssClass: "btn-bad waves-effects", action: function (d) {
                                    d.close();
                                }
                            }]

                        });

                    })

                    .error(function () {
                        show_error();
                    });
            }
        }
    </script>


    <?php

}else{
    ?>

    <div class="alert bg-warning"><h5><i class="fa fa-warning"></i> You have not subscribed to our SMS plan, please contact us for an SMS plan</h5></div>

    <?php
}

    ?>