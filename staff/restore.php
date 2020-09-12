<div class="col-lg-8 col-md-8 col-lg-offset-2 col-md-offset-2 col-sm-12 col-xs-12">
    <div class="panel panel-info" style="border-radius: 0;">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="alert alert-info">
                        <p class="panel-title">Restore Backup</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">

                    <input type="file" id="restorebtn"/>
                </div>

                <div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">

                    <input placeholder="file path" class="form-control" type="text" readonly="" id="respath"/>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button id="run_res" type="button" class="wb wb-good">Run Restore</button>
                </div>
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function () {

            $("#restorebtn").uploadify({
                'uploader': 'upload-scripts/uploadify2.php',
                'swf': 'upload-scripts/uploadify.swf',

                'folder': '/objts/pics',
                'auto': true,
                'buttonText': 'Choose Backup File',
                'onUploadSuccess': function (file, data, response) {
                    $("#respath").val(file.name);
                }


            });

            $("#run_res").click(function () {

                if (!$("#respath").val()) {
                    $(".dlg-ex").html("No backup file selected");
                    $(".dlg-ex").dialog({
                        modal: true,
                        show: "bounce",
                        hide: "fade",
                        title: "No File Select",
                        buttons: {
                            Ok: function () {
                                $(this).dialog("close");

                            }

                        }


                    });

                } else {
                    showprog();
                    $.get("run_res.php?backup=" + $("#respath").val(), function () {

                    }).done(function () {
                        $.get("backup/restore.php", function () {


                        }).done(function () {


                            finish();

                            $(".dlg-ex").html("Retore completed successful").dialog({

                                modal: true,
                                show: "bounce",
                                hide: "fade",
                                title: "Backup complete",
                                buttons: {
                                    Ok: function () {
                                        $(this).dialog("close");

                                    }

                                }


                            });


                        });


                    });
                }
            });

        });


    </script>