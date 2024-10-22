jQuery.fn.redraw = function () {
    return this.hide(0, function () {
        $(this).show(100);
    });

};

function cloasedlgs() {

    $.each(BootstrapDialog.dialogs, function (valu, key) {
        key.close();
    });
}


function remove_fullprog() {

    $(".we-overlay").fadeOut(100);
    $(".we-overlay").remove();
}


function actlog() {
    window.open("actlog.php?limit=500", "User activity log", "outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");
}


function entrylog() {

    BootstrapDialog.show({
        title: "Print Entry Log",
        message: "<div id='entrylogcont'></div>",
        onshown: function () {
            showprogress("entrylogcont");
            $
                .get("printentrylog.php")
                .done(function (data) {
                    $("#entrylogcont").html(data);
                })
                .error(function () {
                    show_error();
                    cloasedlgs();
                });
        },
        buttons: [{
            label: "Preview & Print", cssClass: "bg-info", action: function (d) {
                var term = $("#entry_term").val();
                var year = $("#entry_year").val();

                window.open("entrylog.php?year=" + year + "&term=" + term, "Record entry log", "outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");


            }
        }]

    });


}

var subasignments = [];


function getsubas() {

    var Gstfid = $("#global_stfid").val();
    $.getJSON("subasJSON.php?stfid=" + Gstfid, function (data) {

        subasignments = data;
    });
}


function fullProg() {
    $("body").append("<div class='we-overlay'><i class='fa fa-circle-o we-spin fa-4x' style='margin-top: 20%;'></i></div>");
}

function allprint() {

    var temp = "<div class='row'>";
    temp += "<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>";
    temp += "<textarea placeholder='Enter a custom title for this document' class='form-control' id='print-title'></textarea>";
    temp += "</div>";
    temp += "</div>";
    BootstrapDialog.show({
        title: "Enter a custom title",
        message: temp,
        buttons: [{
            label: "Preview & Print", cssClass: "btn-good waves-effect waves-button", action: function () {
                window.open("allprint.php?ayear=" + $("#getstud-ayear").val() + "&form=" + $("#getstud-form").val() + "&cls=" + $("#getstud-class").val() + "&house=" + $("#getstud-house").val() + "&prog=" + $("#getstud-pro").val() + "&title=" + $("#print-title").val() + "&gender=" + $("#filter-gender").val() + "&ghouse=" + $("#getstud-ghouse").val() + "&resstatus=" + $("#filter_resstatus").val(), "All Print List", "outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");


            }
        }]

    });


}


function cloasedlgs() {


    $.each(BootstrapDialog.dialogs, function (valu, key) {

        key.close();


    });


}

function showsearch() {
    if (testtarget == "regstaf") {

        $(".main-search-cont").slideToggle(200);
    } else {

        $(".search-pane").effect("drop", {mode: "show", direction: "right", height: "toggle"}, 500);
    }
}

function getclstaks_inputs() {

            BootstrapDialog.show({
                title: "Enter Class Test Records",
                message: "<div id='task-cont'></div>",
                size: "size-wide",
                closable: false,
                buttons: [{
                    label: "SAVE",
                    cssClass: "btn rgba-cyan-strong",
                    action: function (d) {

                        savtask();

                    }
                }, {
                    label: "CLOSE",
                    cssClass: "btn btn-outline-danger",
                    action: function (d) {

                        d.close();
                    }
                }],
                onshown:function(){
                    showprogress('task-cont');
                    $.get("gettaskinputs.php?cls=" + $("#assess_class").val() + "&ayear=" + $("#assess-ayear").val() + "&term=" + $("#assess-term").val() + "&subjt=" + $("#assess-subjt").val() + "&stid=", function (data) {

                    })
                        .done(function (data) {
                            $("#task-cont").html(data);

                        })
                        .error(function () {

                            Snarl.addNotification({
                                title: "ERROR",
                                text: "Could not process data, please try again",
                                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                                timeout: 8000
                            });
                            $(".snarl-notification").addClass('snarl-error');

                            cloasedlgs();
                        });
                }
            });


}


function getbatchclstaks_inputs() {
            BootstrapDialog.show({
                title: "Enter Batch Class Task Records",
                message: "<div id='btask-cont'></div>",
                size: "size-wide",
                closable: false,
                buttons: [{
                    label: "SAVE",
                    cssClass: "rgba-cyan-strong",
                    action: function (d) {
                        savtask();
                    }
                }, {
                    label: "CLOSE",
                    cssClass: "btn-outline-danger",
                    action: function (d) {

                        BootstrapDialog.show({
                           title:"Confirm Close",
                           message:"If you have unsaved inputs please save them. This action will discard this window without saving your records, PROCEED?",
                           buttons:[{label:"YES",cssClass:"btn-outline-danger",action:function(){cloasedlgs();}},{label:'NO',cssClass:'rgba-cyan-strong',action:function(d){d.close();}}]

                        });


                    }
                }],
                onshown:function () {
                    showprogress('btask-cont');

                    $.get("getbatchtaskinputs.php?cls=" + $("#assess_class").val() + "&ayear=" + $("#assess-ayear").val() + "&term=" + $("#assess-term").val() + "&subjt=" + $("#assess-subjt").val() + "&stid=", function (data) {

                    })
                        .done(function (data) {
                            $("#btask-cont").html(data);
                        })
                        .error(function () {

                            Snarl.addNotification({
                                title: "ERROR",
                                text: "Could not process data, please try again",
                                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                                timeout: 8000
                            });
                            $(".snarl-notification").addClass('snarl-error');


                        });


                }
            });

}


function getclsassing_inputs() {
            BootstrapDialog.show({
                title: "Enter Class Exercise Records",
                message: "<div id='hw-cont'></div>",
                size: "size-wide",
                closable: false,
                buttons: [{
                    label: "SAVE",
                    cssClass: "btn rgba-cyan-strong",
                    action: function (d) {
                        savhwork();
                    }
                }, {
                    label: "CLOSE",
                    cssClass: "btn btn-outline-danger",
                    action: function (d) {

                        d.close();
                    }
                }],
                onshown:function(){
                    showprogress('hw-cont');
                    $.get("getstudinputs-hw.php?cls=" + $("#assess_class").val() + "&ayear=" + $("#assess-ayear").val() + "&term=" + $("#assess-term").val() + "&subjt=" + $("#assess-subjt").val() + "&stid=", function (data) {

                    })
                        .done(function (data) {

                            $("#hw-cont").html(data);
                        })
                        .error(function () {
                            Snarl.addNotification({
                                title: "ERROR",
                                text: "Could not process data, please try again",
                                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                                timeout: 8000
                            });
                            $(".snarl-notification").addClass('snarl-error');
                            cloasedlgs();
                        });

                }
            });


}


function getbatchclsassing_inputs() {

            BootstrapDialog.show({
                title: "Enter Batch Class Exercise Records",
                message: "<div id='hw-cont'></div>",
                size: "size-wide",
                closable: false,
                buttons: [{
                    label: "SAVE",
                    cssClass: "rgba-cyan-strong",
                    action: function (d) {
                        savhwork();
                    }
                }, {
                    label: "ClOSE",
                    cssClass: "btn-outline-danger",
                    action: function (d) {

                        BootstrapDialog.show({
                            title:"Confirm Close",
                            message:"If you have unsaved inputs please save them. This action will discard this window without saving your records, PROCEED?",
                            buttons:[{label:"YES",cssClass:"btn-outline-danger",action:function(){cloasedlgs();}},{label:'NO',cssClass:'rgba-cyan-strong',action:function(d){d.close();}}]

                        });


                    }
                }],
                onshown:function(){
                    showprogress('hw-cont');

                    $.get("getbatchstudinputs-hw.php?cls=" + $("#assess_class").val() + "&ayear=" + $("#assess-ayear").val() + "&term=" + $("#assess-term").val() + "&subjt=" + $("#assess-subjt").val() + "&stid=", function (data) {

                    })
                        .done(function (data) {
                            $("#hw-cont").html(data);

                        })
                        .error(function () {
                            Snarl.addNotification({
                                title: "ERROR",
                                text: "Could not process data, please try again",
                                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                                timeout: 8000
                            });
                            $(".snarl-notification").addClass('snarl-error');
                        });

                }
            });

}

function getclspwork_inputs() {
            BootstrapDialog.show({
                title: "Enter Project Work Records",
                message: "<div id='pwork-cont'></div>",
                size: "size-wide",
                closable: false,
                buttons: [{
                    label: "SAVE",
                    cssClass: "btn rgba-cyan-strong",
                    action: function (d) {

                        savpwork();

                    }
                }, {
                    label: "CLOSE",
                    cssClass: "btn-outline-danger",
                    action: function (d) {

                        d.close();
                    }
                }],
                onshown:function () {
                    showprogress('pwork-cont');
                    $.get("getstudinputs-pw.php?cls=" + $("#assess_class").val() + "&ayear=" + $("#assess-ayear").val() + "&term=" + $("#assess-term").val() + "&subjt=" + $("#assess-subjt").val() + "&stid=", function (data) {

                    })
                        .done(function (data) {
                            $("#pwork-cont").html(data);
                        })
                        .error(function () {
                            Snarl.addNotification({
                                title: "ERROR",
                                text: "Could not process data, please try again",
                                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                                timeout: 8000
                            });
                            $(".snarl-notification").addClass('snarl-error');
                            cloasedlgs();
                        });
                }
            });


}

function getMyaccount() {
    showprogress("account-det");
    $.get("getaccount.php", function (data) {

        $("#account-det").html(data);
    });
}


function skipstud2(page) {
    var sid = $("#stname").val();
    $.get("getstudinputs-hw.php?page=" + page + "&cls=" + $("#assess_class").val() + "&ayear=" + $("#assess-ayear").val() + "&term=" + $("#assess-term").val() + "&subjt=" + $("#assess-subjt").val() + "&stid=" + sid, function (data) {
        $("div#hw-cont").hide();
        $("div#hw-cont").html(data);
        $("div#hw-cont").fadeIn(100);
    });
}


function savhwork() {
    var stid = $("#stid2").val();
    var hw1 = $("#hw1").val();
    var hw2 = $("#hw2").val();
    var hw3 = $("#hw3").val();
    var hw4 = $("#hw4").val();
    var totl = $("#hwtotl").val();
    var cls = $("#assess_class").val();
    var term = $("#assess-term").val();
    var ayear = $("#assess-ayear").val();
    var sub = $("#assess-subjt").val();
    if (Number(totl) === 0) {
        $("#hw1").focus();
    } else if (Number(totl) > 40) {
        Snarl.addNotification({
            title: "ERROR",
            text: "Assignment records should sum up to a maximum of 40, please check and try again",
            icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
            timeout: 3000
        });
        $(".snarl-notification").addClass('snarl-error');
    } else {
        var progress = Snarl.addNotification({
            title: "Please Wait...",
            text: "Saving Assignment record",
            icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-circle-o-notch fa-spin'></i>",
            timeout: null
        });
        $(".snarl-notification").addClass('snarl-info');

        $.get("savehwork.php?stid=" + stid + "&hw1=" + hw1 + "&hw2=" + hw2 + "&hw3=" + hw3 + "&hw4=" + hw4 + "&totl=" + totl + "&term=" + term + "&cls=" + cls + "&ayear=" + ayear + "&sub=" + sub, function (data) {
        }).done(function (data) {
            $("#assess-subjt").change();
            Snarl.removeNotification(progress);
            Snarl.addNotification({
                title: "SAVED",
                text: data,
                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle-o'></i>",
                timeout: 3000
            });
            $(".snarl-notification").addClass('snarl-success');
            skipstud2(1);
        });


    }


}


function getbatchclspwork_inputs() {
            BootstrapDialog.show({
                title: "Enter Project Work Records",
                message: "<div id='pwork-cont'></div>",
                size: "size-wide",
                closable: false,
                buttons: [{
                    label: "SAVE",
                    cssClass: "rgba-cyan-strong",
                    action: function (d) {

                        savpwork();

                    }
                }, {
                    label: "CLOSE",
                    cssClass: "btn-outline-danger",
                    action: function (d) {


                        BootstrapDialog.show({
                            title:"Confirm Close",
                            message:"If you have unsaved inputs please save them. This action will discard this window without saving your records, PROCEED?",
                            buttons:[{label:"YES",cssClass:"btn-outline-danger",action:function(){cloasedlgs();}},{label:'NO',cssClass:'rgba-cyan-strong',action:function(d){d.close();}}]

                        });

                    }
                }],
                onshown:function () {
                    showprogress("pwork-cont");
                    $.get("getbatchstudinputs-pw.php?cls=" + $("#assess_class").val() + "&ayear=" + $("#assess-ayear").val() + "&term=" + $("#assess-term").val() + "&subjt=" + $("#assess-subjt").val() + "&stid=", function (data) {

                    })
                        .done(function (data) {
                            $("#pwork-cont").html(data);
                        })
                        .error(function () {
                            Snarl.addNotification({
                                title: "ERROR",
                                text: "Could not process data, please try again",
                                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                                timeout: 8000
                            });
                            $(".snarl-notification").addClass('snarl-error');
                        });
                }
            });


}

function getclsexam_inputs() {

            BootstrapDialog.show({
                title: "Enter Exam Records",
                message: "<div id='exam-cont'></div>",
                size: "size-wide",
                closable: false,
                buttons: [{
                    label: "SAVE",
                    cssClass: "rgba-cyan-strong",
                    action: function (d) {
                        savexam();
                    }
                }, {
                    label: "CLOSE",
                    cssClass: "btn-outline-danger",
                    action: function (d) {
                        d.close();
                    }
                }],
                onshown:function () {
                    showprogress('exam-cont');
                    $.get("getstudinputs-exam.php?cls=" + $("#assess_class").val() + "&ayear=" + $("#assess-ayear").val() + "&term=" + $("#assess-term").val() + "&subjt=" + $("#assess-subjt").val() + "&stid=", function (data) {

                    })
                        .done(function (data) {

                            $("#exam-cont").html(data);

                        })
                        .error(function () {
                            Snarl.addNotification({
                                title: "ERROR",
                                text: "Could not process data, please try again",
                                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                                timeout: 8000
                            });
                            $(".snarl-notification").addClass('snarl-error');
                            cloasedlgs();
                        });
                        }

            });


}

function getbatchclsexam_inputs() {

            BootstrapDialog.show({
                title: "Enter Exam Records",
                message: "<div id='exam-cont'></div>",
                size: "size-wide",
                closable: false,
                buttons: [{
                    label: "SAVE",
                    cssClass: "rgba-cyan-strong",
                    action: function (d) {
                        savexam();
                    }
                }, {
                    label: "CLOSE",
                    cssClass: "btn-outline-danger",
                    action: function (d) {



                        BootstrapDialog.show({
                            title:"Confirm Close",
                            message:"If you have unsaved inputs please save them. This action will discard this window without saving your records, PROCEED?",
                            buttons:[{label:"YES",cssClass:"btn-outline-danger",action:function(){cloasedlgs();}},{label:'NO',cssClass:'rgba-cyan-strong',action:function(d){d.close();}}]

                        });



                    }
                }],
                onshown:function(){
                    showprogress("exam-cont");

                    $.get("getbatchstudinputs-exam.php?cls=" + $("#assess_class").val() + "&ayear=" + $("#assess-ayear").val() + "&term=" + $("#assess-term").val() + "&subjt=" + $("#assess-subjt").val() + "&stid=", function (data) {

                    })
                        .done(function (data) {

                            $("#exam-cont").html(data);

                        })
                        .error(function () {
                            Snarl.addNotification({
                                title: "ERROR",
                                text: "Could not process data, please try again",
                                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                                timeout: 8000
                            });
                            $(".snarl-notification").addClass('snarl-error');
                        });
                }
            });


}


function setdeadline() {

    BootstrapDialog.show({
        title: "Set deadline",
        message: "<div id='dead-cont'></div>",
        buttons: [{
            label: "SET DEADLINE",
            cssClass: "bg-info",
            action: function (d) {
                d.close();
                $("#deadfrm").submit();
            }
        }],
        onshown: function () {
            showprogress('dead-cont');
            $.get("getdead.php").done(function (data) {
                $("#dead-cont").html(data);

            });
        }

    });
}


function getaccounts() {
    showprogress("print-pool");
    $.get("accounts.php", function (data) {
    }).done(function (data) {
        $("#print-pool").html(data);
        finish();
    });
}


function logout() {
    BootstrapDialog.show({
        title: "Confirm Log Out",
        message: "Are you sure you want to log out ?",
        buttons: [{
            label: "LOG OUT",
            cssClass: "btn-danger",
            action: function () {

                window.location = "../";
            }
        }]
    });

}


//------------------------------------
function showres(id) {
    fullProg();
    $.get("get_schstud.php?id=" + id, function () {
        $(".search-close").click();
    }).done(function (data) {
        $(".startmenu,.content").effect("drop", {mode: "hide", direction: "left"}, 500, function () {
            $("#schres").html(data);

            remove_fullprog();

            $("#schres").effect("drop", {mode: "show", direction: "left", height: "toggle"}, 500);
        });

    });

}

//---------------------------------------------------------------------------_________________________
function backup() {
    var progress = Snarl.addNotification({
        title: "Please Wait...",
        text: "Garthering Your data",
        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-circle-o-notch fa-spin'></i>",
        timeout: null
    });
    $(".snarl-notification").addClass('snarl-info');

    $.get("backup/backup.php", function (d) {


    }).done(function (d) {
        Snarl.removeNotification(progress);
        Snarl.addNotification({
            title: "BACK UP COMPLETE",
            text: "Downloading backup file...",
            icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle-o'></i>",
            timeout: 3000
        });
        $(".snarl-notification").addClass('snarl-success');

        window.location = "backup/backup.zip";


    });


}

function restore() {
    $.get("restore.php", function (data) {
        $("#print-pool").html(data);


    });

}


function promotstuds() {
    var data = $("#frmpromotstud :input").serializeArray();
    if (data.length <= 6) {
        Snarl.addNotification({
            title: "NO RECORD",
            text: "No students selected for promotion, plaese select some students",
            icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
            timeout: 3000
        });
        $(".snarl-notification").addClass('snarl-error');


    } else {

        if ($("#prmfrom_class").val() === $("#prmto_class").val()) {
            Snarl.addNotification({
                title: "ERROR",
                text: "You can not promote students from a class to the same class ",
                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                timeout: 3000
            });
            $(".snarl-notification").addClass('snarl-error');
            exit();

        }
        if ($("#prmto-form").val() === $("#prmfrom-form").val()) {
            Snarl.addNotification({
                title: "ERROR",
                text: "You can not promote students from a form to the same form " + $("#prmto-form").val() + " from " + $("#prmfrom-form").val(),
                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                timeout: 3000
            });
            $(".snarl-notification").addClass('snarl-error');
            exit();

        }

        if ($("#prmfrom-ayear").val() === $("#prmtoyear").val()) {
            Snarl.addNotification({
                title: "ERROR",
                text: "You can not promote students from an academic year to the same academic year",
                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                timeout: 3000
            });
            $(".snarl-notification").addClass('snarl-error');
            exit();

        }
        showprog();
        $.post("promote.php", data, function (d) {

        }).done(function (d) {
            finish();
            BootstrapDialog.show({
                title: "Promotion",
                message: d,
                buttons: [{
                    label: "PRINT LIST",
                    cssClass: "btn btn-good waves-button waves-effect",
                    action: function () {

                        window.open("promotionlist.php?frmayear=" + $("#prmfrom-ayear").val() + "&frmform=" + $("#prmfrom-form").val() + "&frmcls=" + $("#prmfrom_class").val() + "&tocls=" + $("#prmto_class").val() + "&toayear=" + $("#prmtoyear").val() + "&toform=" + $("#prmto-form").val(), "Promotion list", "outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");


                    }
                }, {
                    label: "CLOSE",
                    cssClass: "btn btn-bad waves-button waves-effect",
                    action: function (d) {
                        d.close();
                    }
                }]
            });


        });

    }
}


function print_transcrpt() {
    showprogress("print-pool");

    $.get("print_transcrpt.php", function (data) {
        $("#print-pool").html(data);
    });
}

//----------------------------------------------------------------------------------------------
function print_scoresht() {
    showprogress("print-pool");

    $.get("print_scoresht.php", function (data) {
        $("#print-pool").html(data);
    });
}

//----------------------------------------------------------------------------------------------

function print_formlst() {
    showprogress("print-pool");

    $.get("print_formlst.php", function (data) {
        $("#print-pool").html(data);
    });
}

//----------------------------------------------------------------------------------------------
function print_sign() {
    showprogress("print-pool");

    $.get("print_sign.php", function (data) {
        $("#print-pool").html(data);
    });
}

//----------------------------------------------------------------------------------------------
function print_brdsheet() {
    showprogress("print-pool");

    $.get("print_brdsheet.php", function (data) {
        $("#print-pool").html(data);
    });
}

//----------------------------------------------------------------------------------------------
function print_rep_one() {
    showprogress("print-pool");

    $.get("print_rep_one.php", function (data) {
        $("#print-pool").html(data);
    });
}

//----------------------------------------------------------------------------------------------
function print_rep_all() {
    showprogress("print-pool");
    $.get("print_rep_all.php", function (data) {
        $("#print-pool").html(data);
    });
}

//-----------------------------------------------------------------------------------------------
function print_cls() {
    showprogress("print-pool");
    $.get("print_cls.php", function (data) {
        $("#print-pool").html(data);
    });
}

//------------------------------------------------------------------------------------------------
function print_prog() {
    showprogress("print-pool");

    $.get("print_prog.php", function (data) {
        $("#print-pool").html(data);
    });
}

//------------------------------------------------------------------------------------------------
function print_hse() {
    showprogress("print-pool");

    $.get("print_hse.php", function (data) {
        $("#print-pool").html(data);
    });
}

//----------------------------------------------------------------------------------------------
function mkayear() {
    var mydt = new Date();
    var curyear = mydt.getFullYear();
    curyear -= 10;
    var opt = "";
    var prevyear = 0;
    var nexyear = 0;
    var i = 0;
    for (i = 1; i <= 20; i++) {
        var prevyear = curyear;
        var nexyear = prevyear + 1;
        if (prevyear === mydt.getFullYear()) {
            opt += "<option selected>" + prevyear + "/" + nexyear + "</option>";
        } else {
            opt += "<option>" + prevyear + "/" + nexyear + "</option>";
        }
        curyear++;
    }


    $("#ayear").html(opt);
    $("#prmtoyear").html(opt);
}

//-------------------------------------------------------------------------------------------------
function getid() {
    //var noty = Snarl.addNotification({
    //    title: "Please Wait..",
    //    text: "Checking for ID duplication",
    //    icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
    //    timeout: 3000
    //});
    $("#frmregstud :input").attr('disabled', true);
    $.get("getindex.php", null, function (id) {
    }).done(function (id) {
        $("#frmregstud :input").attr('disabled', false);
        $("#index").val(id);
        if ($("#index").val() != id) {
            $("#index").val(id);
        }
    });
}

function getid_BeforeSave() {
    //var noty = Snarl.addNotification({
    //    title: "Please Wait..",
    //    text: "Checking for ID duplication",
    //    icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
    //    timeout: 3000
    //});
    $.get("getindex.php", null, function (id) {
    }).done(function (id) {
        $("#index").val(id);
        if ($("#index").val() != id) {
            $("#index").val(id);
        }
    });
}

//=========================================================================================
function getdepts() {
    showprogress("regdept");
    $.get("getdepts.php", null, function (data) {
        $("#regdept").html(data);
    }).done(function () {
        finish();

    });
}

//--------------------------------------------------------------------------------------------------
function getclass() {
    showprogress("regclass");

    $.get("getclass.php", function (data) {


    }).done(function (data) {

        $("#regclass").html(data);
        finish();

    });

}

//=================================================================================================
//--------------------------------------------------------------------------------------------------
function getsubjts() {
    showprogress("regsubjts");

    $.get("getsubjts.php", null, function (data) {


        $("#regsubjts").html(data);


    }).done(function () {
        finish();
    });
}

//=====================================================================================================
function gethouses() {
    showprogress("reghouse");
    $.get("gethouse.php", null, function (data) {
        $("#reghouse").html(data);
    }).done(function () {
        finish();
    });
}

//====================================================================================================
function getstaff() {
    showprogress("regstaf");
    $.get("getstaff.php?search=" + $(".main-search").val(), null, function (data) {
        $("#regstaf").html(data);
    }).done(function () {
        finish();
    });
}

//=================================================================================================


//---------------------------------------------------------------------------------------------------
function getstud(page) {
    showprogress("stud-list");
    var prog = $("#getstud-pro").val();
    var cls = $("#getstud-class").val();
    var huse = $("#getstud-house").val();
    var fm = $("#getstud-form").val();
    var ay = $("#getstud-ayear").val();
    var gn = $("#filter-gender").val();
    var gh = $("#getstud-ghouse").val();
    var resstatus = $("#filter_resstatus").val();
    if (page === 'undefined') {
        var url = "getstuds.php?prog=" + prog + "&cls=" + cls + "&huse=" + huse + "&form=" + fm + "&ayear=" + ay + "&gender=" + gn + "&ghouse=" + gh + "&resstatus=" + resstatus;
        $.get(url, function () {
            $("#viewstuds").html(" ");
            $(".panel-body").redraw();
        }).done(function (data) {
            finish();
            $('#viewstuds').html(data);
        });
    } else {
        var url = "getstuds.php?page=" + page + "&prog=" + prog + "&cls=" + cls + "&huse=" + huse + "&form=" + fm + "&ayear=" + ay + "&gender=" + gn + "&ghouse=" + gh + "&resstatus=" + resstatus;
        $.get(url, function (data) {
            $('#stud-list').html("");
            $(".panel-body").redraw();
            $('#stud-list').html(data);
        }).done(function () {
            finish();
        });
    }
}

//--------------------------------------------------------------------
//function getstud(){
//    showprog();
//   
//    $.get('getstuds.php',function(data){
//        $('#viewstuds').html(data);
//        
//    }).done(function(){
//        finish();
//        
//        
//    });
//    
//  
//        
//           $.get('getstuds.php',function(data){
//        $('#viewstuds').html(data);
//        
//    }).done(function(){
//        finish();
//        
//        
//    });
//        
//        
//    
//    
//}


//=================================================================================================
function showstart() {
    $(".add-btn").fadeOut(100);
    $(".startmenu").effect("drop", {mode: "show", direction: "left"}, 200);
}

//--------------------------------------------------------------------------------------------------
function performshow(id, target) {
    window.requestAnimationFrame(function () {
        var strid = id.toString();
        $(".startmenu").effect("drop", {mode: "hide", direction: "left"}, 200, function () {
            $(strid).effect("drop", {mode: "show", direction: "left"}, 500, function () {
                if (target === "depts") {
                    $(".add-btn").fadeIn(100);
                    getdepts();
                } else if (target === "classes") {
                    $(".add-btn").fadeIn(100);
                    getclass();
                } else if (target === "subjts") {
                    $(".add-btn").fadeIn(100);
                    getsubjts();
                } else if (target === "house") {
                    $(".add-btn").fadeIn(100);
                    gethouses();
                } else if (target === "staff") {
                    $(".add-btn").fadeIn(100);
                    getstaff();
                } else if (target === "student") {
                    resetform();
                    getid();
                } else if (target === 'getstud') {
                    $("#getstud-pro").change();
                } else if (target === 'clstask') {
                } else if (target === 'assess') {
                    $("#assess_class").change();
                } else if (target === 'printcls') {
                    print_cls();
                } else if (target === 'printprog') {
                    print_prog();
                } else if (target === 'printhse') {
                    print_hse();
                } else if (target === 'printsign') {
                    print_sign();
                } else if (target === 'rep_one') {
                    print_rep_one();
                } else if (target === 'rep_all') {
                    print_rep_all();
                } else if (target === 'brdsheet') {
                    print_brdsheet();
                } else if (target === 'formlst') {
                    print_formlst();
                } else if (target === 'scoresht') {
                    print_scoresht();
                } else if (target === 'transrpt') {
                    print_transcrpt();
                } else if (target === 'backup') {
                    backup();
                } else if (target === 'restore') {
                    restore();
                } else if (target === 'accounts') {
                    getaccounts();
                } else if (target === 'wdraw') {
                    print_widraw();
                } else if (target === 'frmres') {
                    print_frmres();
                } else if (target === 'clavg') {
                    print_clavg();
                } else if (target === 'genpop') {
                    print_genpop();
                } else if (target === 'waec') {
                    getwaec();
                } else if (target === 'graphclass') {
                    $("#chart-ayear").change();
                } else if (target === 'getaccount') {
                    getMyaccount();
                } else if (target === "frmdata") {
                    $("#frm_class").change();
                } else if (target === "smsreports") {
                    getsmshistory();
                } else if (target === 'smsnotif') {

                    getsmsnotifhistory();
                } else if (target === 'allca') {
                    $("#allca_class").change();
                } else if (target == 'mng-books') {
                    getbooks();
                } else if (target == 'lendbooks') {
                    getlendbooks();

                } else if (target == 'exeats') {


                    get_exeats();
                }

            });
        });


    });


}

//end of performshow function
//-------------------------------------------------------------------------------------------------------------------------
function getlendbooks() {
    showprogress("lend-container");

    var search = $("#lend-search").val();
    $
        .get("getlendbooks.php?search=" + search)
        .done(function (list) {
            $("#lend-container").html(list);
        })
        .error(function () {
            show_error();
        });
}

function getsmsnotifhistory() {
    showprogress("smsnotif-cont");
    $
        .get("getsmsnotifhistory.php")
        .done(function (data) {
            $("#smsnotif-cont").html(data);

        })
        .error(function () {
            show_error();
        });


}

function get_exeats() {
    showprogress('viewexeats');

    $
        .get("getexeats.php")
        .done(function (data) {

            $("#viewexeats").html(data);
        })
        .error(function () {
            show_error();

        });


}

function mark_ex(id) {
    let tmp = "<div class='md-form'><i class='fa fa-comments prefix'></i><textarea name='' id='ex-comm' rows='5' class='form-control md-textarea'></textarea><label class='form-control-label '>Leave a comment on this exeat...</label></div>";
    BootstrapDialog.show({
        title: "Mark Exeat As Done",
        message: tmp,
        buttons: [{
            label: "Mark As Done", cssClass: 'bg-info text-white', action: function (d) {
                var cmm = $("#ex-comm").val();

                $
                    .get("mark_ex.php?stid=" + id + "&cmm=" + cmm)
                    .done(function () {
                        d.close();
                        var exid = "#exeat_" + id;

                        $(exid).fadeOut(100).remove();
                        $("search_ex").keyup();
                    })
                    .error(function () {
                        show_error();
                    });

            }
        }]

    });


}

function sendSMSnotif() {

    BootstrapDialog.show({
        title: "Broadcast SMS Reports",
        message: "<div id='smsinfo-cont'></div>",
        closable: false,
        buttons: [{
            label: "Cancel", cssClass: "btn-danger", action: function (d) {
                d.close();
            }
        }, {
            label: "Broadcast", cssClass: "bg-info", action: function () {

                sendnotif();
            }
        }],
        onshown: function () {
            showprogress("smsinfo-cont");
            $
                .get("smsnotif_input.php")
                .done(function (data) {


                    $("#smsinfo-cont").html(data);
                })
                .error(function () {
                    remove_fullprog();
                    show_error();

                });

        }

    });


}


function getsmshistory() {
    showprogress("smsreport-cont");
    $
        .get("getsmshistory.php")
        .done(function (data) {
            $("#smsreport-cont").html(data);
        })

        .error(function () {
            show_error();

        });
}

function getwaec() {
    showprogress("waec-content");
    var search = $("#waec-search").val();
    var ayear = $("#waec-ayear").val();
    $
        .get("getwaec.php?search=" + search + "&ayear=" + ayear)
        .done(function (data) {
            $("#waec-content").html(data);
            finish();
        })
        .error(function () {
            show_error();
        });
}


function print_genpop() {
    showprogress("print-pool");

    $
        .get("print_genpop.php", function (data) {
        })
        .error(function () {
            $("#print-pool").html("<h2 class='text-danger text-center'>could not process data, you seem to be off the network <i class='fa fa-chain-broken'></i> </h2>");
        })
        .done(function (data) {
            $("#print-pool").html(data);
        });
}

//------------------------------------------------------------------------------------------------------------------------------
function show_error() {
    Snarl.addNotification({
        title: "ERROR",
        text: "COULD NOT CONNECT TO SERVER, PLEASE CHECK AND TRY AGAIN",
        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
        timeout: 8000
    });
    $(".snarl-notification").addClass('snarl-error');
}

//-----------------------------------------------------------------------------------------------------------------------------
function print_clavg() {
    showprogress("print-pool");
    $
        .get("print_clavg.php", function () {
        })
        .error(function () {
            $("#print-pool").html("<h2 class='text-danger text-center'>could not process data, you seem to be off the network <i class='fa fa-chain-broken'></i> </h2>");
        })
        .done(function (data) {

            $("#print-pool").html(data);
        });
}

function getheaders() {
    $.get("assayear.php", function (data) {
        $("#assess-ayear").html(data);

    }).done(function () {

        $.get("asscls.php", function (data) {

            $("#assess_class").html(data);
        }).done(function () {

            $("#assess-subjt").change();
        });
    });


}

//------------------------------------------------------------------------

function print_avgs() {

    BootstrapDialog.show({
        message: "<div id='avgdlg-cont'></div>",
        title: "Print Accumulated averages",
        buttons: [{
            label: "Preview & Print", cssClass: "bg-info", action: function (d) {
                var ayear = $("#acayear").val();
                var cls = $("#acclas").val();
                var actitle = $("#actitle").val();
                window.open("printacavgs.php?ayear=" + ayear + "&cls=" + cls + "&title=" + actitle, "All Print List", "outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");

            }
        }],
        onshown: function () {
            showprogress("avgdlg-cont");
            $

                .get("acavginputs.php", function (data) {


                }).error(function () {
                show_error();
                cloasedlgs();

            }).done(function (data) {

                $("#avgdlg-cont").html(data);
            });

        }

    });

}

function print_frmres() {
    showprogress("print-pool");
    $
        .get("print_frmres.php", function () {
        })

        .error(function () {
            $("#print-pool").html("<h2 class='text-danger text-center'>could not process data, you seem to be off the network <i class='fa fa-chain-broken'></i> </h2>");
        })

        .done(function (data) {

            $("#print-pool").html(data);
        });

}

function print_widraw() {
    showprogress("print-pool");
    $.get("print_widraw.php", function (data) {

        $("#print-pool").html(data);

    });

}

function closewindow(id) {
    $(id).effect("drop", {mode: "hide", direction: "left", height: "toggle"}, 500, function () {
        showstart();

    });
}

var d;

function showprog() {
    if (Snarl.d != null) {
        Snarl.addNotification({
            title: "Please Wait...",
            text: "Processing...",
            icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-circle-o-notch fa-spin'></i>",
            timeout: null

        });
        $(".snarl-notification").addClass('snarl-info');

    }
}

function finish() {
    setTimeout(function () {
        $.each(Snarl.notifications, function (key, val) {
            var id = "#snarl-notification-" + key;
            $(id).fadeOut(200);
        });
    }, 900);
}

//function finish_dlg(msg, title) {
//    $(".dlg").title = title;
//    $(".dlg").html(msg);
//    //=================================================================================================
//    $(".dlg").dialog({
//        width: "60%",
//        height: "auto",
//        modal: true,
//        buttons: {
//            Ok: function() {
//                $(this).dialog("close");
//            }
//        }
//    });
//}

function finishsave(msg, title) {
    var text = 'student saved successfully';
    if (msg === 'saved') {
        resetform();
    } else if (msg === 'blank-true') {
        var text = 'Some field(s) are left blank, please complete your entry';
    } else {
        var text = 'ID number in use or Could not move passport picture, please check and try again';
    }
    finish();
    finish_dlg(text, title);
}

//------------------------------------------------------------------------------------------------------
function resetform() {
    $("#dept").change();
    $("#photo").val("dpic/photo.jpg");
    $("#fhtown,#fname,#lname,#oname,#lschool,#fhtown,#fthname,#dob,#mthname,#mthtel,#mtown,#pthtel").val('');
    var tmp = "<img class='img-responsive img-rounded img-thumbnail' src='img/photo.jpg' />";
    $("#imgcont").fadeOut(function () {
        $("#imgcont").html(tmp);
        $("#imgcont").fadeIn(500);
    });
    get_ranhous();
}

function get_ranhous() {
    $.getJSON("getrndhuse.php", function (hus) {
        $("#hse").val(hus.id);
        $("#hse_alt").val(hus.name);
    });
}

var d;


function saverecs(form_id) {
    $(form_id).submit(function () {
        return false;
    });
    var progress = Snarl.addNotification({
        title: "PROCESSING",
        text: "Please Wait...",
        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-circle-o-notch fa-spin'></i>",
        timeout: 3000
    });
    $(".snarl-notification").addClass('snarl-info');

    $.post($(form_id).attr("action"), $(form_id + " :input").serializeArray(), function (data) {
    }).done(function (data) {

    }).done(function () {
        resetform();
        get_ranhous();
        getid();
        Snarl.removeNotification(progress);
        Snarl.addNotification({
            title: "SAVED",
            text: "Student registered successfully",
            icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle'></i>",
            timeout: 3000
        });
        $(".snarl-notification").addClass('snarl-success');
    }).error(function () {
        Snarl.removeNotification(progress);
        Snarl.addNotification({
            title: "ERROR",
            text: "Something went wrong, could not save student",
            icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-remove'></i>",
            timeout: 3000
        });
        $(".snarl-notification").addClass('snarl-error');
    });

    return false;
}

function refresh() {
    $(window).trigger("hashchange");
}

function print_assess() {

    window.open("print_assess.php?ayear=" + $("#allca-ayear").val() + "&term=" + $("#allca-term").val() + "&subjt=" + $("#allca-subjt").val() + "&cls=" + $("#allca_class").val(), "Continuous assessment", "outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");


}


function showhelp() {
    BootstrapDialog.show({
        title: "Tech. Assisstance",
        message: "<blockquote class='blockquote text-muted' style='font-style: italic;'>IF TECHNOLOGY WAS PERFECT, INVENTION WOULD HALT'</blockquote>Incase of anything concerning the system, please contact us on.<br /><strong>Mobile:</strong>+233242044493<br /><strong>E-Mail:</strong>info@skoolrec.com <br/><i>THANK YOU!</i> <i>Website: <a href='https://skoolrec.com' target='_blank'>www.skoolrec.com</a></i>  "

    });
}

function showinfo() {
    BootstrapDialog.show({
        title: "System Information",
        message: " <center><h3>REPORT MASTER 7.0(Rebirth)</h3></center><br/>A PRODUCT OF SKOOLREC LLC<br /><span class='text-muted' style='border-top: 1px solid #ccc;'>Report master is a students' information/results processing system designed for senior high schools in Ghana This system was designed with the intention of speeding up work,simplifying the process,persistent data storage, ease of data access and so on in mind.<br /><strong><u>*Features*</u></strong><br/><ul><li>Accept Students' information</li><li>Accept raw students' assessment records</li><li>Calculate and convert students' assessment records according to schools grading ratios</li><li>Determine grades and remarks for students' assessment</li><li>Position student per term academic year and class</li><li>Determine overall average/position of students for each term </li><li>Generate:student's profile,class list,program list,house list,Feeding Sign List,Form List Termly assessment reports,score sheets,broadsheet,transcript,continuous assessment and so on for printing</li><li>Persistent data storage for future use</li><li>Ease of access over Wi-Fi/Ethernet and even On Smart Phones</li> <li>And many more...</li></ul></span>"

    });
}


function skipstud(page) {
    var sid = $("#stname").val();
    $.get("gettaskinputs.php?page=" + page + "&cls=" + $("#assess_class").val() + "&ayear=" + $("#assess-ayear").val() + "&term=" + $("#assess-term").val() + "&subjt=" + $("#assess-subjt").val() + "&stid=" + sid, function (data) {
        $("div#task-cont").hide();
        $("div#task-cont").html(data);
        $("div#task-cont").fadeIn(100);
    });

}

function savtask() {
    var stid = $("#stid").val();
    var ta1 = $("#ta1").val();
    var ta2 = $("#ta2").val();
    var ta3 = $("#ta3").val();
    var ta4 = $("#ta4").val();
    var totl = $("#totl").val();
    var cls = $("#assess_class").val();
    var term = $("#assess-term").val();
    var ayear = $("#assess-ayear").val();
    var sub = $("#assess-subjt").val();
    if (Number(totl) === 0) {
        $("#ta1").focus();
    } else if (Number(totl) > 40) {
        Snarl.addNotification({
            title: "ERROR",
            text: "Class Task records should sum up to a maximum of 40, please check and try again",
            icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
            timeout: 3000
        });
        $(".snarl-notification").addClass('snarl-error');
    } else {
        var progress = Snarl.addNotification({
            title: "Please Wait...",
            text: "Saving class task record",
            icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-circle-o-notch fa-spin'></i>",
            timeout: null
        });
        $(".snarl-notification").addClass('snarl-info');

        $.get("savetask.php?stid=" + stid + "&ta1=" + ta1 + "&ta2=" + ta2 + "&ta3=" + ta3 + "&ta4=" + ta4 + "&totl=" + totl + "&term=" + term + "&cls=" + cls + "&ayear=" + ayear + "&sub=" + sub, function (data) {
        }).done(function (data) {
            $("#assess-subjt").change();
            Snarl.removeNotification(progress);
            Snarl.addNotification({
                title: "SAVED",
                text: data,
                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle-o'></i>",
                timeout: 3000
            });
            $(".snarl-notification").addClass('snarl-success');
            skipstud(1);
        });

    }


}

function mkfrm() {
    showprog();
    var data = {
        stfid: $("#stfid").val(),
        cls: $("#cls").val()
    };
    data = $("#addfrm :input").serializeArray();
    $.post("addfrm.php", data, function () {
    }).done(function (d) {
        getfrmlist(data.stfid);
        Snarl.addNotification({
            title: "ADDED",
            text: d,
            icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle-o'></i>",
            timeout: 8000
        });
        $(".snarl-notification").addClass('snarl-success');
    });

    return false;
}

function getfrmlist(id) {
    $.get("getfrmm.php?id=" + id, function (data) {
        $("#frmlist").html(data);
    });
}

function hmasters() {

    window.open("hmstaff.php", "List Of house masters", "outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");
}

function fmasters() {

    window.open("fmstaff.php", "List Of form masters", "outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");
}

function substf() {

    window.open("substf.php", "List Of subject teachers", "outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");
}

function delhm(id) {

    BootstrapDialog.show({
        title: "Confirm Remove",
        message: "This will prevent this teacher from seeing students in this house, PROCEED?",
        buttons: [{
            label: "REMOVE", cssClass: "btn-danger", action: function (d) {
                $.get("delhm.php?id=" + id, function () {
                    var row = "#house-row" + id;
                    $(row).remove();
                    d.close();

                })
            }
        }]

    })


}

function remfrmm(id) {
    BootstrapDialog.show({
        title: "Confirm Delete",
        message: "Are you sure you want to unassign this class from this staff",
        buttons: [{
            label: "DELETE", cssClass: "btn-bad waves-effect waves-button", action: function (d) {
                d.close();
                $.get("remfrmm.php?id=" + id, function () {

                }).done(function (data) {
                    var el = "#frm_row" + id;
                    $(el).fadeOut(100).remove();
                    Snarl.removeNotification(progress);
                    Snarl.addNotification({
                        title: "DELETE",
                        text: "Class unassigned successfully",
                        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle-o'></i>",
                        timeout: 3000
                    });
                    $(".snarl-notification").addClass('snarl-success');
                });


            }
        }]
    });


}


$(document).ready(function () {


    $("div#image_cont").dropzone(
        {
            url: "./dropfile.php",
            acceptedFiles: "image/*",
            addRemoveLinks: true,
            dictDefaultMessage: "drop photo here or click to upload",
            dictRemoveFile: "Remove photo",
            resizeWidth: "180",
            resizeHeight: "200",
            resizeMethod: "crop",
            maxFiles: 1,
            accept: function (file, done) {
                $("#picpath").val("temppic/" + file.name);
                done();
            }


        });


    $("form#addfrm").submit(function () {
        showprog();
        var data = $("form#addfrm :input").serializeArray();
        var url = $("form#addfrm").attr("action");
        $.post("addfrm.php", data, function () {

        }).done(function (data) {
            getfrmlist();
            Snarl.addNotification({
                title: "ADDED",
                text: data,
                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle-o'></i>",
                timeout: 800
            });
            $(".snarl-notification").addClass('snarl-success');
        });

        return false;
    });


    $("div.st-item").click(function () {

        $(".st-item").removeClass("st-selected");
        $(this).addClass("st-selected");

    });

    $("#book-search").keyup(function () {
        getbooks();
    });

    $("#lend-search").keyup(function () {
        getlendbooks();
    });

    $("#allcasearch").keyup(function () {
        $("#allca_class").change();
    });


    $("#frm_class").change(function () {
        showprogress('frm-container');
        $.get("getfrms.php?cls=" + $(this).val() + "&ayear=" + $("#frm-ayear").val() + "&term=" + $("#frm-term").val() + "&search=" + $("#frm-search").val(), function (data) {
        }).done(function (data) {
            $("#frm-container").hide();
            $("#frm-container").html(data);
            $("#frm-container").effect("drop", {mode: "show", direction: "left", height: "toggle"}, 500);
        });
    });
    $("#frm-search").keyup(function () {
        $("#frm_class").change();
    });
    $("#frm-ayear").change(function () {

        $("#frm_class").change();
    });
    $("#frm-term").change(function () {
        $("#frm_class").change();
    });
    $("#chartType").change(function () {
        $("#chart-class").change();
    });
    $("#chart-ayear").change(function () {
        $("#chart-class").change();
    });
    $("#chart-class").change(function () {
        fullProg();
        var options = {
            "type": "bar",
            "data": {
                "datasets": [
                    {
                        "label": "No. Of boys who passed ",
                        "fill": true,
                        "backgroundColor": [
                            "rgba(73, 62, 255, 0.5)",
                            "rgba(73, 62, 255, 0.5)",
                            "rgba(73, 62, 255, 0.5)",
                            "rgba(73, 62, 255, 0.5)",
                            "rgba(73, 62, 255, 0.5)",
                            "rgba(73, 62, 255, 0.5)",
                            "rgba(73, 62, 255, 0.5)",
                            "rgba(73, 62, 255, 0.5)",
                            "rgba(73, 62, 255, 0.5)",
                            "rgba(73, 62, 255, 0.5)",
                            "rgba(73, 62, 255, 0.5)",
                            "rgba(73, 62, 255, 0.5)",
                            "rgba(73, 62, 255, 0.5)",
                            "rgba(73, 62, 255, 0.5)",
                            "rgba(73, 62, 255, 0.5)",
                            "rgba(73, 62, 255, 1)"
                        ],
                        "borderColor": [
                            "rgba(123, 62, 255, 1)"
                        ],
                        "borderWidth": 3
                    },
                    {
                        "label": "No. Of Girls who passed ",
                        "fill": true,
                        "backgroundColor": [
                            "rgba(21, 255, 25, 0.5)",
                            "rgba(21, 255, 25, 0.5)",
                            "rgba(21, 255, 25, 0.5)",
                            "rgba(21, 255, 25, 0.5)",
                            "rgba(21, 255, 25, 0.5)",
                            "rgba(21, 255, 25, 0.5)",
                            "rgba(21, 255, 25, 0.5)",
                            "rgba(21, 255, 25, 0.5)",
                            "rgba(21, 255, 25, 0.5)",
                            "rgba(21, 255, 25, 0.5)",
                            "rgba(21, 255, 25, 0.5)",
                            "rgba(21, 255, 25, 0.5)",
                            "rgba(21, 255, 25, 0.5)",
                            "rgba(21, 255, 25, 0.5)"
                        ],
                        "borderColor": [
                            "rgba(21, 255, 25, 1)",

                        ],
                        "borderWidth": 3
                    }, {
                        "label": "No. Of boys who failed ",
                        "fill": true,
                        "backgroundColor": [
                            "rgba(255, 21, 24, 1)",
                            "rgba(255, 21, 24, 1)",
                            "rgba(255, 21, 24, 1)",
                            "rgba(255, 21, 24, 1)",
                            "rgba(255, 21, 24, 1)",
                            "rgba(255, 21, 24, 1)",
                            "rgba(255, 21, 24, 1)",
                            "rgba(255, 21, 24, 1)",
                            "rgba(255, 21, 24, 1)",
                            "rgba(255, 21, 24, 1)",
                            "rgba(255, 21, 24, 1)",
                            "rgba(255, 21, 24, 1)",
                            "rgba(255, 21, 24, 1)",
                            "rgba(255, 21, 24, 1)",
                            "rgba(255, 21, 24, 1)",
                            "rgba(255, 21, 24, 1)"

                        ],
                        "borderColor": [
                            "rgba(255, 21, 24, 1)"

                        ],
                        "borderWidth": 3
                    }, {
                        "label": "No. Of Girls who failed ",
                        "fill": true,
                        "backgroundColor": [
                            "rgba(255, 140, 31, 1)",
                            "rgba(255, 140, 31, 1)",
                            "rgba(255, 140, 31, 1)",
                            "rgba(255, 140, 31, 1)",
                            "rgba(255, 140, 31, 1)",
                            "rgba(255, 140, 31, 1)",
                            "rgba(255, 140, 31, 1)",
                            "rgba(255, 140, 31, 1)",
                            "rgba(255, 140, 31, 1)",
                            "rgba(255, 140, 31, 1)",
                            "rgba(255, 140, 31, 1)",
                            "rgba(255, 140, 31, 1)",
                            "rgba(255, 140, 31, 1)",
                            "rgba(255, 140, 31, 1)",
                            "rgba(255, 140, 31, 1)",
                            "rgba(255, 140, 31, 1)",
                            "rgba(255, 140, 31, 1)",
                            "rgba(255, 140, 31, 1)"

                        ],
                        "borderColor": [
                            "rgba(255, 140, 31, 1)"
                        ],
                        "borderWidth": 3
                    }


                ]
            },
            "options": {
                legend: {
                    display: true,
                    labels: {
                        fontColor: 'rgb(255, 99, 132)'
                    }
                },
                responsive: true,
                tooltips: {
                    mode: 'index',
                    intersect: false
                },
                "scales": {
                    "yAxes": [{
                        "ticks": {
                            "beginAtZero": true
                        }
                    }],
                    "xAxes": [{
                        "ticks": {
                            "beginAtZero": true
                        }
                    }]
                }
            }
        };

        var ayear = $("#chart-ayear").val();
        var cls = $("#chart-class").val();
        $.getJSON("getchart_value.php?ayear=" + ayear + "&class=" + cls, function (data) {
            if (myBarChart) {
                myBarChart.destroy();
            }
            options.type = $("#chartType").val();
            options.data.labels = data.labels;
            options.data.datasets[0].data = data.malePass;
            options.data.datasets[1].data = data.femalepass;
            options.data.datasets[2].data = data.maleFail;
            options.data.datasets[3].data = data.femalefail;
            var ctx = document.getElementById("chart-canvas").getContext("2d");
            var myBarChart = new Chart(ctx, options);
            remove_fullprog();

        });


    });

    $("#waec-search").keyup(function () {
        refresh();
    });


    $("#waec-ayear").change(function () {

        refresh();
    });


    $(".main-search").keyup(function () {
        getstaff();

    });


    getheaders();
    resetform();
    $("#getstud-pro").change(function () {
        getstud(1);
    });


    $("#filter_resstatus").change(function () {
        $("#getstud-pro").change();

    });
    $("#getstud-ghouse").change(function () {
        $("#getstud-pro").change();

    });
    $("#getstud-class").change(function () {
        $("#getstud-pro").change();

    });

    $("#filter-gender").change(function () {
        $("#getstud-pro").change();

    });

    $("#getstud-form").change(function () {
        $("#getstud-pro").change();

    });

    $("#getstud-house").change(function () {
        $("#getstud-pro").change();
    });


    $("#getstud-ayear").change(function () {
        $("#getstud-pro").change();
    });
    $("i").tooltip();

    //-----------------------------------------------------------------------------------


    $(".search-box").keyup(function () {
        $(".search-content").html("<center><span style='color: #FC3; font-style: italic; text-align: center; font-weight: bold;'>Searching...</span></center>");
        $.get("search.php?keyword=" + $(this).val(), function (data) {

        }).done(function (data) {
            $(".search-content").hide();
            $(".search-content").html(data);
            $(".search-content").fadeIn(500);
        });

    });

    $(".search-close").click(function () {
        $(".search-pane").effect("drop", {mode: "hide", direction: "right", height: "toggle"}, 500);

    });


    $("#checkall").change(function () {
        var status = $("#checkall").prop("checked");
        var selects = $("#selectchk");
        for (var i = 0; i < selects.length; i++) {
            selects[i].checked = status;
        }
    });


    $("#btnprintassess").click(function () {
        window.open("print_assess.php?ayear=" + $("#assess-ayear").val() + "&term=" + $("#assess-term").val() + "&subjt=" + $("#assess-subjt").val() + "&cls=" + $("#assess_class").val(), "Continuous assessment", "outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");
    });

    //---------------------------------

    $("#txtsearch").keyup(function () {
        $("#assess_class").change();

    });

    //-----------------------------------------------

    $("#allca_class").change(function () {
        var cls = $("#allca_class").val();
        var subjt = $("#allca-subjt").val();
        var allcasearch = $("#allcasearch").val();
        showprogress("allca-container");
        $.get("getallca.php?cls=" + cls + "&ayear=" + $("#allca-ayear").val() + "&term=" + $("#allca-term").val() + "&subjt=" + subjt + "&search=" + allcasearch, function (data) {
            $("#allca-container").hide();
            $("#allca-container").html(data);
        }).done(function (data) {
            $("#allca-container").effect("drop", {
                mode: "show",
                direction: "left",
                height: "toggle"
            }, 500);
            finish();
        });

    });
    $("#allca-ayear").change(function () {
        $("#allca_class").change();
    });

    $("#allca-term").change(function () {
        $("#allca_class").change();
    });

    $("#allca-subjt").change(function () {
        $("#allca_class").change();
    });
    $("#assess_class").change(function () {
        var cls = $("#assess_class").val();
        var subjt = $("#assess-subjt").val();
        if ($("#global_usertype").val() == 'staff') {

            $("button#asaddbtn").attr("disabled", true);
            $("button#btnprintassess").attr("disabled", true);
            var progress = Snarl.addNotification({
                title: "PROCCESSING",
                text: "Please Wait...",
                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-circle-o-notch fa-spin'></i>",
                timeout: null
            });
            $(".snarl-notification").addClass('snarl-info');
            $
                .getJSON("testsubasJSON.php?id=" + $("#global_stfid").val() + "&subjt=" + subjt + "&cls=" + cls)
                .done(function (d) {
                    if (d) {

                        $("button#asaddbtn").attr("disabled", false);
                        $("button#btnprintassess").attr("disabled", false);
                        Snarl.removeNotification(progress);
                        showprogress("assess-container");
                        $.get("getassess.php?cls=" + cls + "&ayear=" + $("#assess-ayear").val() + "&term=" + $("#assess-term").val() + "&subjt=" + $("#assess-subjt").val() + "&key=" + $("#txtsearch").val(), function (data) {
                            $("#assess-container").hide();
                            $("#assess-container").html(data);
                        }).done(function (data) {
                            $("#assess-container").effect("drop", {
                                mode: "show",
                                direction: "left",
                                height: "toggle"
                            }, 500);
                            finish();
                        });
                    } else {
                        $("#assess-container").html("");
                        Snarl.removeNotification(progress);
                        Snarl.addNotification({
                            title: "ERROR",
                            text: "You do not teach this subject in the selected class",
                            icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                            timeout: 8000
                        });
                        $(".snarl-notification").addClass('snarl-error');
                    }
                })
                .error(function () {
                    show_error();
                });
        } else {

            showprogress("assess-container");
            $.get("getassess.php?cls=" + cls + "&ayear=" + $("#assess-ayear").val() + "&term=" + $("#assess-term").val() + "&subjt=" + $("#assess-subjt").val() + "&key=" + $("#txtsearch").val(), function (data) {
                $("#assess-container").hide();
                $("#assess-container").html(data);
            }).done(function (data) {
                $("#assess-container").effect("drop", {
                    mode: "show",
                    direction: "left",
                    height: "toggle"
                }, 500);
                finish();
            });


        }
    });
    //-----------------------------------------------
    $("#prmfrom_class").change(function () {
        showprogress("promt-container");
        $.get("promolist.php?cls=" + $(this).val() + "&ayear=" + $("#prmfrom-ayear").val() + "&form=" + $("#prmfrom-form").val(), function (data) {
            $("#promt-container").hide();
            $("#promt-container").html(data);
        }).done(function (data) {


            $("#promt-container").effect("drop", {mode: "show", direction: "left", height: "toggle"}, 500);
            finish();
        });
    });
    $("#prmfrom-form").change(function () {
        $("#prmfrom_class").change();

    });
    $("#prmfrom-ayear").change(function () {
        $("#prmfrom_class").change();

    });
    //----------------------------

    //----------------------------------------
    $("#filter-btn").click(function () {
        $("#filter-form").slideToggle(500);
    });
    //-------------------------------------
    $("#btnregstud").click(function (e) {
        getid_BeforeSave();
        if (!$("#photo").val()) {
            Snarl.addNotification({
                title: "ERROR",
                text: "Passport picture not selected, please select a passport picture",
                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                timeout: 3000
            });
            $(".snarl-notification").addClass('snarl-error');
            return false;
        }
        saverecs("#frmregstud");
    });
    //===========================================
    $('#clearbtn').click(function () {
        BootstrapDialog.show({
            title: "Confirm Clear",
            message: "Are you sure you want to clear all inputs on the form ?",
            buttons: [{
                label: "CLEAR",
                cssClass: "btn btn-bad waves-effect waves-button",
                action: function (d) {
                    d.close();
                    resetform();

                }
            }]


        });
    });
});

//--------------------------------------------------------------------------------------

function addwaec() {


    BootstrapDialog.show({
        title: "Add Record",
        message: "<div id='addweac-cont'></div>",
        closable: false,
        buttons: [{
            label: "SAVE", cssClass: "bg-info", action: function (d) {
                d.close();
                $("form#frmsavewaec").submit();

            }
        },
            {
                label: "CANCEL", cssClass: "btn-danger", action: function (d) {
                    d.close();
                }
            }],
        onshown: function () {
            showprogress('addweac-cont');
            $
                .get("addwaecinputs.php?ayear=" + $("#waec-ayear").val())
                .done(function (data) {
                    $("#addweac-cont").html(data);

                });
        }

    });


}

function printsubanalysis() {
    var ayear = $("#waec-ayear").val();
    window.open("subanalysis.php?ayear=" + ayear, "WARC SUBJECT BASE ANALYSIS", "outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");
}

function printproganalysis() {

    $.get("waecayear.php", function (data) {

        BootstrapDialog.show({
            title: "Preview and print Analysis",
            message: data,
            buttons: [{
                label: "Preview & Print", cssClass: "btn-good waves-effect", action: function () {
                    var ayear = $("#waec-ayear").val();
                    var prog = $("#anprog").val();
                    window.open("proganalysis.php?ayear=" + ayear + "&prog=" + prog, "WARC PROGRAME BASE ANALYSIS", "outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");

                }
            }]

        });


    });

}

function recievebook(id) {
    BootstrapDialog.show({
        title: "Receive Book",
        message: "<div id='rb-container'></div>",
        onshown: function () {
            showprogress("rb-container");
            $
                .get("rbook.php?id=" + id)
                .done(function (item) {
                    $("#rb-container").html(item);
                })
                .error(function () {
                    show_error();
                    cloasedlgs();
                });
        },
        buttons: [{
            label: "RECEIVE", cssClass: "bg-info", action: function (d) {
                var returndate = $("#return_date").val();
                var data = {lid: id, return_date: returndate};
                if (returndate) {
                    fullProg();
                    $
                        .post("receive_book.php", data)
                        .done(function () {
                            remove_fullprog();
                            cloasedlgs();
                            getlendbooks();
                        })
                        .error(function () {
                            show_error();
                            remove_fullprog();
                        });
                } else {
                    $("#return_date").focus();
                }
            }
        }, {
            label: "CANCEL", cssClass: "btn-outline-danger", action: function (d) {
                d.close();
            }
        }]
    });
}

function dellend(id, rowid) {
    BootstrapDialog.show(
        {
            title: "Confirm Delete",
            message: "Are you sure you want to delete this record ?",
            buttons: [{
                label: 'DELETE', cssClass: 'btn-danger', action: function (d) {
                    fullProg();

                    $
                        .get("dellend.php?id=" + id)
                        .done(function () {
                            remove_fullprog();
                            var row = '#' + rowid;
                            $(row).remove();
                            d.close();
                        })
                        .error(function () {
                            remove_fullprog();
                            show_error();
                        });

                }
            }]

        }
    );
}


function addfrm() {

        BootstrapDialog.show({
            title: "Add Form Records",
            message: "<div id='frm-cont'></div>",
            closable: false,
            size: "size-wide",
            buttons: [{
                label: "Save", cssClass: "rgba-cyan-strong", action: function (d) {
                    savefrm();
                }
            }, {
                label: "Cancel", cssClass: "btn-outline-danger", action: function (d) {
                    d.close();
                }
            }],
            onshown:function(){
                showprogress('frm-cont');
                $.get("addfrm.php?cls=" + $("#frm_class").val() + "&term=" + $("#frm-term").val() + "&ayear=" + $("#frm-ayear").val(), function (data) {
                }).done(function (data) {

                $("#frm-cont").html(data);
                }).
                    error(function () {


                        show_error();
                        cloasedlgs();

                });

            }


        });


}

function respass(id, stname) {


    let temp = "<div class='alert bg-info text-white'>" + stname + "</div>";
    temp += "<div class='md-form'> <i class='prefix fa fa-asterisk'></i>";
    temp += "<input type='password' class='form-control' id='stpass' name='stpass'>";
    temp += "<label for='stpass'>Create New Password</label>";
    temp += "<div class='md-form'>";
    temp += "<div class='md-form'> <i class='prefix fa fa-asterisk'></i>";
    temp += "<input type='password' class='form-control' id='stcpass' name='stcpass'>";
    temp += "<label for='stcpass'>Confirm New Password</label>";
    temp += "<div class='md-form'>";
    BootstrapDialog.show({
        title: "Reset Password",
        message: temp,
        buttons: [{
            label: "Reset", cssClass: 'bg-info', action: function () {
                let stpass = $("#stpass").val();
                let stcpass = $("#stcpass").val();
                if (stpass.length < 1 && stcpass.length < 1) {
                    $("#stpass").focus();
                } else if (stcpass != stpass) {
                    Snarl.addNotification({
                        title: "ERROR",
                        text: "Passwords are not the same, please confirm password",
                        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                        timeout: 3000
                    });
                    $(".snarl-notification").addClass('snarl-error');
                } else {

                    $
                        .get("do_reset.php?id=" + id + "&new_pass=" + stcpass)
                        .done(function () {
                            Snarl.addNotification({
                                title: "RESET",
                                text: "Your new password has been set",
                                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check'></i>",
                                timeout: 3000
                            });
                            $(".snarl-notification").addClass('snarl-success');
                            cloasedlgs();
                        })
                        .error(function () {
                            Snarl.addNotification({
                                title: "ERROR",
                                text: "Server communication error, please check your connection",
                                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-chain-broken'></i>",
                                timeout: 3000
                            });
                            $(".snarl-notification").addClass('snarl-error');
                        });

                }

            }
        }]

    });


}


function refresh_frm() {
    showprogress("frm-cont");

    $.get("addfrm.php?cls=" + $("#frm_class").val() + "&term=" + $("#frm-term").val() + "&ayear=" + $("#frm-ayear").val(), function (data) {

    }).done(function (data) {
        $("#frm-cont").html(data);

    });


}

function mkhm() {
    var data = {
        stfid: $("#stfid").val(),
        house: $("#houses").val()

    };
    $

        .post("mkhm.php", data)
        .done(function () {
            Snarl.addNotification({
                title: "SUCCESSFUL",
                text: "Your house assignment was successful",
                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle'></i>",
                timeout: 3000
            });
            $(".snarl-notification").addClass('snarl-success');
        })
        .error(function () {
            Snarl.addNotification({
                title: "ERROR",
                text: "Sorry we could not assign the house",
                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                timeout: 3000
            });
            $(".snarl-notification").addClass('snarl-error');

        });

}

function housem(stfid) {
    $

        .get("addhouse.php?id=" + stfid)
        .done(function (data) {

            BootstrapDialog.show({
                title: "Manage house master",

                message: data,
                buttons: [
                    {
                        label: "SAVE", cssClass: "btn bg-info", action: function () {
                            mkhm();
                            cloasedlgs();
                        }
                    },
                    {
                        label: "CANCEL", cssClass: "btn btn-danger", action: function (d) {
                            d.close();
                        }
                    }]

            });


        })
        .error(function () {


        });


}

function rmshm(id) {
    BootstrapDialog.show({
        title: "Confirm Remove",
        message: "This will prevent this staff from managing student's information like comments, PROCEED?",
        buttons: [{
            label: "REMOVE", cssClass: "btn-danger", action: function (d) {
                $.get("rmshm.php?id=" + id, function () {
                    cloasedlgs();

                })
            }
        }]

    })
}

function mkshm(id) {
    $
        .get("mkshm.php?id=" + id)
        .done(function () {
            Snarl.addNotification({
                title: "SUCCESSFUL",
                text: "Your duty assignment was successful",
                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle'></i>",
                timeout: 3000
            });
            $(".snarl-notification").addClass('snarl-success');
        })
        .error(function () {
            Snarl.addNotification({
                title: "ERROR",
                text: "Sorry we could not assign the duty",
                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                timeout: 3000
            });
            $(".snarl-notification").addClass('snarl-error');

        });
    cloasedlgs();

}

function addshm(stfid) {
    $

        .get("addshm.php?id=" + stfid)
        .done(function (data) {

            BootstrapDialog.show({
                title: "Manage senior house master",

                message: data,
                buttons: [
                    {
                        label: "CANCEL", cssClass: "btn btn-danger", action: function (d) {
                            d.close();
                        }
                    }]

            });


        })
        .error(function () {


        });


}

function rmwof(id) {
    BootstrapDialog.show({
        title: "Confirm Remove",
        message: "This will prevent this staff from managing academic records, PROCEED?",
        buttons: [{
            label: "REMOVE", cssClass: "btn-danger", action: function (d) {
                $.get("rmwof.php?id=" + id, function () {
                    cloasedlgs();

                })
            }
        }]

    })
}


function mkwof(id) {
    $
        .get("addwo.php?id=" + id)
        .done(function () {
            Snarl.addNotification({
                title: "SUCCESSFUL",
                text: "Your duty assignment was successful",
                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle'></i>",
                timeout: 3000
            });
            $(".snarl-notification").addClass('snarl-success');
        })
        .error(function () {
            Snarl.addNotification({
                title: "ERROR",
                text: "Sorry we could not assign the duty",
                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                timeout: 3000
            });
            $(".snarl-notification").addClass('snarl-error');

        });
    cloasedlgs();

}

function mkwo(stfid) {
    $

        .get("mkwo.php?id=" + stfid)
        .done(function (data) {
            BootstrapDialog.show({
                title: "Manage WAEC/Exam Officer",
                message: data,
                buttons: [
                    {
                        label: "CANCEL", cssClass: "btn-danger", action: function (d) {
                            d.close();
                        }
                    }]
            });
        })
        .error(function () {

        });
}


function showprogress(view) {
    var viewid = "#" + view;
    var prog = "<img style='width: 100%; height: auto;' src='../admin/img/listloader.gif' alt=''>";
    $(viewid).html(prog);
}


function sendSMSreport() {
    BootstrapDialog.show({
        title: "Broadcast SMS Reports",
        message: "<div id='smscont'></div>",
        buttons: [{
            label: "Cancel", cssClass: "btn-danger", action: function (d) {
                d.close();
            }
        }, {
            label: "Broadcast", cssClass: "bg-info text-white", action: function () {

                sendreports();
            }
        }],
        onshown: function () {

            showprogress("smscont");
            $
                .get("smsreport_input.php")
                .done(function (data) {
                    $("#smscont").html(data);
                })
                .error(function () {
                    show_error();
                    cloasedlgs();

                });
        }


    });

}


/*staff stuff*/

function getbooks() {
    showprogress("book-container");

    $
        .get("getbooks.php?search=" + $("#book-search").val(), function (data) {

        })
        .done(function (books) {
            $("#book-container").html(books);
        })
        .error(function () {

            show_error();
        });


}

function addbook() {
    var booktemp = "<div class='col-lg-6 col-md-6 col-sm-12 col-xs-12'>";
    booktemp += "<label class='control-label'>Book Title</label>";
    booktemp += "<input placeholder='Enter book title' type='text' class='form-control' id='bookTitle' name='bookTitle' required />";
    booktemp += "</div>";
    booktemp += "<div class='col-lg-6 col-md-6 col-sm-12 col-xs-12'>";
    booktemp += "<label class='control-label'>Author(s)</label>";
    booktemp += "<input placeholder='Enter name(s) of author(s) of the book' type='text' class='form-control' id='bookAuthor' name='bookAuthor' required />";
    booktemp += "</div>";
    booktemp += "<div class='col-lg-6 col-md-6 col-sm-12 col-xs-12'>";
    booktemp += "<label class='control-label'>ISBN Number</label>";
    booktemp += "<input type='text' class='form-control' id='bookISBN' name='bookISBN' required />";
    booktemp += "</div>";
    booktemp += "<div class='col-lg-6 col-md-6 col-sm-12 col-xs-12'>";
    booktemp += "<label class='control-label'>Shelf/Location</label>";
    booktemp += "<input type='text' placeholder='describe the shelf in which the book can be found' class='form-control' id='bookShelf' name='bookShelf' required />";
    booktemp += "</div>";
    booktemp += "<div class='col-lg-6 col-md-6 col-sm-12 col-xs-12'>";
    booktemp += "<label class='control-label'>Number Of Copies</label>";
    booktemp += "<input min='1' type='number' placeholder='Enter the number of copies of this book' class='form-control' id='bookQty' name='bookQty' required />";
    booktemp += "</div>";
    booktemp += "<div class='col-lg-6 col-md-6 col-sm-12 col-xs-12'>";
    booktemp += "<label class='control-label'>Custom Description</label>";
    booktemp += "<textarea name='bookDesc' id='bookDesc' class='form-control' placeholder='Describe the book in your own words'></textarea>";
    BootstrapDialog.show({
        title: "Add a new book",
        size: "size-wide",
        message: "<form id='addbookfrm'><div class='row'>" + booktemp + "</div></form>",
        buttons: [{
            label: "Save", cssClass: "btn-good waves-effect", action: function () {
                var bookinfo = {
                    title: $("#bookTitle").val(),
                    author: $("#bookAuthor").val(),
                    ISBN: $("#bookISBN").val(),
                    shelf: $("#bookShelf").val(),
                    copies: $("#bookQty").val(),
                    desc: $("#bookDesc").val()
                };

                if (bookinfo.title.length > 0 && bookinfo.author.length > 0 && bookinfo.shelf.length > 0 && bookinfo.copies.length > 0) {
                    fullProg();

                    $
                        .post("savebook.php", bookinfo)
                        .done(function () {
                            getbooks();

                            $("#bookTitle").val("");
                            $("#bookAuthor").val("");
                            $("#bookISBN").val("");
                            $("#bookShelf").val("");
                            $("#bookQty").val("");
                            $("#bookDesc").val("");
                            remove_fullprog();
                            Snarl.addNotification({
                                title: "SAVED",
                                text: "Book saved successfully",
                                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle'></i>",
                                timeout: 4000
                            });
                            $(".snarl-notification").addClass('snarl-success');

                        })
                        .error(function () {
                            remove_fullprog();
                            show_error();
                        });
                } else {
                    Snarl.addNotification({
                        title: "INVALID ENTRY",
                        text: "You missed a required field, please check and try again",
                        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                        timeout: 4000
                    });
                    $(".snarl-notification").addClass('snarl-error');


                }
            }
        }, {
            label: "Close", cssClass: "btn-bad waves-effect", action: function (d) {
                d.close();
            }
        }]

    });


}


function mkmissing(id, title, copies, nummissing) {

    var tmp = "<div class='row'>";
    tmp += "<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>";
    tmp += "<div class='list-group'>";
    tmp += "<div class='list-group-item'>";
    tmp += "<strong>Book Title: </strong>";
    tmp += title;
    tmp += "</div>";
    tmp += "<div class='list-group-item'>";
    tmp += "<strong>No. Copies: </strong>";
    tmp += copies;
    tmp += "</div>";
    tmp += "<div class='list-group-item'>";
    tmp += "<label class='form-control-label'>No. Damaged Copies: </label>";
    tmp += "<input class='form-control' type='number' id='input_numissing' value='" + nummissing + "'/>";
    tmp += "</div>";
    tmp += "</div>";
    tmp += "</div>";
    tmp += "</div>";
    BootstrapDialog.show({
        title: "Record Missing copies",
        message: tmp,
        buttons: [{
            label: "SAVE", cssClass: "btn-good waves-effect", action: function (d) {
                var missing = $("#input_numissing").val();

                BootstrapDialog.show({
                    title: "Confirm Save",
                    message: "Do you want to save " + missing + " number of copies missing for this book?",
                    buttons: [{
                        label: "SAVE", cssClass: "btn-good waves-effect", action: function () {
                            fullProg();

                            var data = {
                                id: id,
                                misingnum: missing
                            };
                            $
                                .post("save_misibgBooks.php", data)
                                .done(function () {
                                    remove_fullprog();
                                    cloasedlgs();
                                    getbooks();

                                })
                                .error(function () {

                                });
                        }
                    }, {
                        label: "CANCEL", cssClass: "btn-bad waves-effect", action: function () {
                            cloasedlgs();
                        }
                    }]
                });
            }
        }]

    });
}


function mkdamaged(id, title, copies, numdamged) {
    var tmp = "<div class='row'>";
    tmp += "<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>";
    tmp += "<div class='list-group'>";
    tmp += "<div class='list-group-item'>";
    tmp += "<strong>Book Title: </strong>";
    tmp += title;
    tmp += "</div>";
    tmp += "<div class='list-group-item'>";
    tmp += "<strong>No. Copies: </strong>";
    tmp += copies;
    tmp += "</div>";
    tmp += "<div class='list-group-item'>";
    tmp += "<label class='form-control-label'>No. Damaged Copies: </label>";
    tmp += "<input class='form-control' type='number' id='input_numdamge' value='" + numdamged + "'/>";
    tmp += "</div>";
    tmp += "</div>";
    tmp += "</div>";
    tmp += "</div>";
    BootstrapDialog.show({
        title: "Record Damaged copies",
        message: tmp,
        buttons: [{
            label: "SAVE", cssClass: "btn-good waves-effect", action: function (d) {
                var damaged = $("#input_numdamge").val();
                BootstrapDialog.show({
                    title: "Confirm Save",
                    message: "Do you want to save " + damaged + " number of copies damaged for this book?",
                    buttons: [{
                        label: "SAVE", cssClass: "btn-good waves-effect", action: function () {
                            fullProg();
                            var data = {
                                id: id,
                                damagednum: damaged
                            };
                            $
                                .post("save_damageBooks.php", data)
                                .done(function () {
                                    remove_fullprog();
                                    cloasedlgs();
                                    getbooks();
                                })
                                .error(function () {
                                });
                        }
                    }, {
                        label: "CANCEL", cssClass: "btn-bad waves-effect", action: function () {
                            cloasedlgs();
                        }
                    }]
                });
            }
        }]
    });
}


function printbooklist() {

    window.open("booklist.php", "Book List", "outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");
}

function editbook(id) {
    BootstrapDialog.show({
        title: "Edit book Info",
        message: "<div id='editbook-cont'></div>",
        size: 'size-wide',

        onshown: function () {
            showprogress("editbook-cont");

            $
                .get("editbook_input.php?bid=" + id)
                .done(function (editwin) {
                    $("#editbook-cont").html(editwin);
                })
                .error(function () {
                    cloasedlgs();
                    show_error();
                })
        },
        buttons: [{
            label: "UPDATE", cssClass: "btn-good waves-effect", action: function (d) {
                $("form#editbookfrm").submit();


            }
        }]
    })

}


function printDefaulters() {

    window.open("defaulters.php", "Defaulters List", "outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");

}


function lendbook(bid) {
    var lenddlg = BootstrapDialog.show({
        title: "Lend this book to a student",
        message: "<div id='lendcont' style='transition: 3ms ease-in-out;'></div>",
        size: "size-wide",
        onshown: function () {
            showprogress("lendcont");
            $
                .get("getlendbook.php?bid=" + bid)
                .done(function (data) {
                    $("#lendcont").html(data);
                })
                .error(function () {
                    cloasedlgs();
                    show_error();
                });
        },
        buttons: [{
            label: "SAVE", cssClass: "btn-good waves-effect", action: function (d) {
                var stid = $("#selected_id").val();
                var bid = $("#bid").val();
                var startdate = $("#lendstart").val();
                var enddate = $("#lendend").val();

                if (!stid) {

                    Snarl.addNotification({
                        title: "ERROR",
                        text: "You have not selected a student",
                        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                        timeout: 4000
                    });
                    $(".snarl-notification").addClass('snarl-error');
                    return false;
                }
                if (!startdate || !enddate) {

                    Snarl.addNotification({
                        title: "ERROR",
                        text: "You have NOT selected interval for lend period",
                        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                        timeout: 4000
                    });
                    $(".snarl-notification").addClass('snarl-error');
                    return false;
                }
                var lendinfo = {
                    stid: stid,
                    bid: bid,
                    start: startdate,
                    end: enddate
                };

                fullProg();
                $
                    .post("savelend.php", lendinfo)
                    .done(function () {
                        d.close();
                        remove_fullprog();
                        Snarl.addNotification({
                            title: "SAVED",
                            text: "The book was successfully lent to the selected student",
                            icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle'></i>",
                            timeout: 4000
                        });
                        $(".snarl-notification").addClass('snarl-success');

                    })
                    .error(function () {
                        show_error();
                    });

            }
        }, {
            label: "CANCEL", cssClass: "btn-bad waves-effect", action: function (d) {
                d.close();
            }
        }],
        closable: false
    });
}


function selectstud(id) {

    $("#selected_id").val(id);

    $.get("getlendst.php?stid=" + id, function (data) {

        $("#stlend_status").html(data);


    });
}

function mkmissing(id, title, copies, nummissing) {
    var tmp = "<div class='row'>";
    tmp += "<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>";
    tmp += "<div class='list-group'>";
    tmp += "<div class='list-group-item'>";
    tmp += "<strong>Book Title: </strong>";
    tmp += title;
    tmp += "</div>";
    tmp += "<div class='list-group-item'>";
    tmp += "<strong>No. Copies: </strong>";
    tmp += copies;
    tmp += "</div>";
    tmp += "<div class='list-group-item'>";
    tmp += "<label class='form-control-label'>No. Missing Copies: </label>";
    tmp += "<input class='form-control' type='number' id='input_numissing' value='" + nummissing + "'/>";
    tmp += "</div>";
    tmp += "</div>";
    tmp += "</div>";
    tmp += "</div>";
    BootstrapDialog.show({
        title: "Record Missing copies",
        message: tmp,
        buttons: [{
            label: "SAVE", cssClass: "btn-good waves-effect", action: function (d) {
                var missing = $("#input_numissing").val();
                BootstrapDialog.show({
                    title: "Confirm Save",
                    message: "Do you want to save " + missing + " number of copies missing for this book?",
                    buttons: [{
                        label: "SAVE", cssClass: "btn-good waves-effect", action: function () {
                            fullProg();
                            var data = {
                                id: id,
                                misingnum: missing
                            };
                            $
                                .post("save_misibgBooks.php", data)
                                .done(function () {
                                    remove_fullprog();
                                    cloasedlgs();
                                    getbooks();
                                })
                                .error(function () {
                                });
                        }
                    }, {
                        label: "CANCEL", cssClass: "btn-bad waves-effect", action: function () {
                            cloasedlgs();
                        }
                    }]
                });
            }
        }]
    });
}

function delbook(id, tr) {
    BootstrapDialog.show({
        title: "Confirm Delete",
        message: "Are you sure you want to delete this book permanently?",
        buttons: [{
            label: "DELETE", cssClass: "btn-bad waves-effect", action: function (d) {
                var row = "#" + tr;
                fullProg();
                $
                    .get("delbook.php?bid=" + id)
                    .done(function () {
                        remove_fullprog();
                        d.close();
                        $(row).remove();
                    })
                    .error(function () {
                        d.close();
                        remove_fullprog();
                        show_error();
                    });
            }
        }]
    });
}

function rmlibrian(id) {
    BootstrapDialog.show({
        title: "Confirm Remove",
        message: "This will prevent this staff from managing books in the library, PROCEED?",
        buttons: [{
            label: "REMOVE", cssClass: "btn-danger", action: function (d) {
                $.get("rmlib.php?id=" + id, function () {
                    cloasedlgs();

                })
            }
        }]

    })
}


function mklibrian(id) {
    $
        .get("mklib.php?id=" + id)
        .done(function () {
            Snarl.addNotification({
                title: "SUCCESSFUL",
                text: "Your duty assignment was successful",
                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle'></i>",
                timeout: 3000
            });
            $(".snarl-notification").addClass('snarl-success');
        })
        .error(function () {
            Snarl.addNotification({
                title: "ERROR",
                text: "Sorry we could not assign the duty",
                icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                timeout: 3000
            });
            $(".snarl-notification").addClass('snarl-error');

        });
    cloasedlgs();

}

function mklib(id) {
    fullProg();
    $.get("mklibfrm.php?id=" + id, function (data) {
    }).done(function (data) {
        remove_fullprog();
        BootstrapDialog.show({
            title: "Make this Staff the Librarian",
            message: data,
            buttons: [{
                label: "DONE", cssClass: "bg-info", action: function (d) {
                    d.close();
                }
            }]
        });
    }).error(function () {
        show_error();
    });
}

function mkform(id) {
    fullProg();
    $.get("getfrmmst.php?id=" + id, function (data) {
    }).done(function (data) {
        remove_fullprog();
        BootstrapDialog.show({
            title: "Manage Extra Duties",
            message: data,
            buttons: [{
                label: "DONE", cssClass: "btn bg-info", action: function (d) {
                    d.close();
                }
            }]
        });
    }).error(function () {
        show_error();
    });
}

function printstf(id) {
    window.open("staffprf.php?id=" + id, "Staff Profile", "outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");
}

function refresh_onestaff(id) {
    showprogress("row_" + id);
    $
        .get("refresh_onestaff.php?id=" + id)
        .done(function (data) {
            $("#row_" + id).html(data);
        });
}

function upstaff(id) {

        BootstrapDialog.show({
            title: "Update Staff Info.",
            message: "<div id='stf-cont'></div>",
            buttons: [{
                label: "UPDATE", cssClass: "btn bg-info", action: function (d) {
                    if (!$("#upfname,#uplname,#upcontact").val()) {
                        return false;
                    }
                    d.close();
                    var progress = Snarl.addNotification({
                        title: "Please Wait...",
                        text: "Updating Staff Info.",
                        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-circle-o-notch fa-spin'></i>",
                        timeout: null
                    });
                    $(".snarl-notification").addClass('snarl-info');
                    $.get("updatestaff.php?id=" + id + "&fname=" + $("#upfname").val() + "&lname=" + $("#uplname").val() + "&gender=" + $("#upgender").val() + "&contact=" + $("#upcontact").val() + "&rank=" + $("#uprank").val() + "&stfid=" + $("#upstfid").val() + "&dob=" + $("#updob").val() + "&regno=" + $("#upregno").val() + "&aqual=" + $("#upaqual").val() + "&pqual=" + $("#uppqual").val() + "&appdate=" + $("#upappdate").val() + "&assdate=" + $("#upassdate").val() + "&bank=" + $("#upbank").val() + "&accno=" + $("#upaccno").val() + "&ssnid=" + $('#upssnid').val(), function (data) {
                    }).done(function () {
                        Snarl.removeNotification(progress);
                        refresh_onestaff(id);
                    });
                }
            }, {
                label: "CANCEL", cssClass: "btn-bad waves-effect waves-button", action: function (d) {
                    d.close()
                }
            }],
            closable: false,
            size: "size-wide",
            onshown:function () {
                showprogress("stf-cont");
                $.get("get_up_inputs.php?id=" + id, null, function (data) {
                }).done(function (data) {
                    $("#stf-cont").html(data);

                }).error(function () {
                    show_error();
                    cloasedlgs();

                });
            }

        });

}


function rmsub(sfid, id) {
    BootstrapDialog.show({
        title: "Confirm Delete",
        message: "Do you want to Unasign this subject/class?",
        type: 'danger',
        buttons: [{
            label: "REMOVE", cssClass: "btn btn-danger", action: function (d) {
                d.close();
                fullProg();
                $.get("rmsub.php?id=" + id + "&sfid=" + sfid, null, function (data) {
                }).done(function () {
                    remove_fullprog();
                    var rowid = "#sub_" + id;
                    $(rowid).remove();
                });
            }
        }]
    });
    $(".modal-backdrop").addClass("backdrop-light");
}


function show_sub(id) {
    $show_id = ".sub-inf-" + id;
    $($show_id).slideToggle(500);
}


function refresh_subs(id) {
    showprogress("sub-body" + id);
    $.get("staff_sublist.php?id=" + id, function (data) {
        $("#sub-body" + id).html(data);
    });
}

function asub(id) {
    fullProg();
    $.get("subcls.php", null, function (data) {
    }).done(function (data) {
        remove_fullprog();
        BootstrapDialog.show({
            title: "Assing Subjects/Classes To Staff",
            message: data,
            buttons: [{
                label: "ASSIGN", cssClass: "btn bg-info", action: function (d) {
                    d.close();
                    $.get("assignsubs.php?sfid=" + id + "&subid=" + $("#sub").val() + "&clsid=" + $("#cls").val(), null, function (data) {
                    }).done(function (data) {
                        refresh_subs(id);
                        Snarl.addNotification({
                            title: "ASSIGNED",
                            text: data,
                            icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle-o'></i>",
                            timeout: 8000
                        });
                        $(".snarl-notification").addClass('snarl-success');
                    });
                }
            }]
        });
    }).error(function () {
        show_error();
    });
}


function delstaff(id) {
    BootstrapDialog.show({
        title: "Confirm Delete",
        message: "Are you sure you want to delete this staff",
        type: 'TYPE_DANGER',
        buttons: [{
            label: "DELETE", cssClass: "btn-danger", action: function (d) {
                d.close();
                fullProg();
                $.get("delstaff.php?id=" + id, null, function (data) {
                }).done(function (data) {
                    remove_fullprog();
                    var rowid = "#row_" + id;
                    $(rowid).fadeOut(500, function () {
                        $(rowid).remove();
                    });
                    Snarl.addNotification({
                        title: "DELETE",
                        text: data,
                        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle-o'></i>",
                        timeout: 3000
                    });
                    $(".snarl-notification").addClass('snarl-success');
                });
            }
        }]
    });
    $(".modal-backdrop").addClass("backdrop-light");
}


function print_staff() {
    window.open("stafflist.php", "List Of staff", "outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");
}


/*student stuff*/

function resetlogin(id) {
    BootstrapDialog.show({
        title: "Confirm Reset",
        message: "Are you sure you want to reset this student account?, this will delete his/her account and require his/her date of birth to log into his/her portal",
        buttons: [{
            label: "RESET", cssClass: "btn-bad", action: function (d) {
                fullProg();
                $.get("reset_studacc.php?id=" + id, function () {
                    remove_fullprog();
                    Snarl.addNotification({
                        title: "RESET ACCOUNT",
                        text: "the account was successfully reset",
                        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle-o'></i>",
                        timeout: 3000
                    });
                    $(".snarl-notification").addClass('snarl-success');
                    d.close();
                });
            }
        }]
    });
}

function printtransc(id) {
    window.open("transcript.php?id=" + id, "Transcript", "outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");
}

function printrep(id) {
    BootstrapDialog.show({
        title: "Print termnal report for this student",
        message: "<div id='trep-cont'></div>",
        onshown: function () {
            showprogress('trep-cont');
            $.get("print_rep_one.php?stid=" + id, function (data) {
                $("#trep-cont").html(data);
            });
        },
        buttons: [{
            label: "VIEW & PRINT", cssClass: "bg-info", action: function (d) {
                $.getJSON("cnt_rep.php?id=" + id + "&ayear=" + $("#ayer5").val() + "&term=" + $("#term").val(), function (dataobj) {
                    if (dataobj.count_val === 0) {
                        Snarl.addNotification({
                            title: "NO RECORD",
                            text: "No records found for this student for the selected academic year and term",
                            icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                            timeout: 8000
                        });
                        $(".snarl-notification").addClass('snarl-error');
                    } else {
                        window.open("rep_one.php?ayear=" + $("#ayer5").val() + "&id=" + id + "&term=" + $("#term").val(), "Termnal Report", "outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");
                    }
                });

            }
        }]
    });
}


function single_refresh(id, row) {
    var rowid = row;
    showprogress(rowid);
    $
        .get("single_refresh.php?id=" + id, function (data) {
            $('#' + rowid).html(data);
        });
}


function unwithdraw(id) {
    BootstrapDialog.show({
        title: "Confirm Resume",
        message: "Do you want to resume this student into the school?",
        buttons: [{
            label: "RESUME", cssClass: "bg-info", action: function (d) {
                d.close();
                fullProg();
                $.get("uw.php?id=" + id, function () {
                }).done(function () {
                    remove_fullprog();
                    var rowid = "row_" + id;
                    single_refresh(id, rowid);
                    Snarl.addNotification({
                        title: "RESUMED",
                        text: "Student Resumed successfully",
                        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle-o'></i>",
                        timeout: 3000
                    });
                    $(".snarl-notification").addClass('snarl-success');
                });
            }
        }]

    });

}

function exiat(id) {
    BootstrapDialog.show({
        title: "Manage Exeats for this student",
        message: "<div id='exiat-cont'></div>",
        size: "size-wide",
        onshown: function () {
            showprogress("exiat-cont");

            $
                .get("exiat_form.php?id=" + id)
                .done(function (data) {

                    $("#exiat-cont").html(data);

                })
                .error(function () {
                    show_error();
                    cloasedlgs();
                });

        },
        buttons: [{
            label: "CLOSE", cssClass: "btn-danger", action: function (d) {
                d.close();
            }
        }]
    });
}

function withdraw(id) {

    BootstrapDialog.show({
        title: "Withdraw This student",
        message: "<div id='w-cont'></div>",
        size: "size-wide",
        onshown: function () {
            showprogress("w-cont");
            $.get("wfrm.php?id=" + id, function (data) {
            }).done(function (data) {
                $("#w-cont").html(data);


            }).error(function () {
                show_error();
                cloasedlgs();
            });
        },
        buttons: [{
            label: "WITHDRAW", cssClass: "btn-danger", action: function (d) {
                if (!$("#wresn").val()) {
                    $("#wresn").focus();
                } else if (!$("#wdate").val()) {
                    $("#wdate").focus();
                } else {
                    d.close();
                    $("#wfrm").submit();
                }
            }
        }]
    });

}


function Comnt(id) {

    BootstrapDialog.show({
        title: "Manage Comments Under This Student",
        message: "<div id='cm-cont'></div>",
        size: "size-wide",
        closable: false,
        onshown: function () {
            showprogress('cm-cont');
            $.get("getcomnts.php?id=" + id, function (data) {
            }).done(function (data) {

                $("#cm-cont").html(data);
            }).error(function () {
                show_error();
                cloasedlgs();
            });
        },
        buttons: [{
            label: "CLOSE", cssClass: "btn-danger", action: function (d) {
                d.close();
            }
        }]
    });


}


function upstud(id, row) {
    BootstrapDialog.show({
        title: "Update Student's Info.",
        message: "<div id='upstud-cont'></div>",
        size: "size-wide",
        closable: false,
        buttons: [{
            label: "UPDATE", cssClass: "bg-info", action: function (d) {
                if (!$("#upfname").val()) {
                    Snarl.addNotification({
                        title: "MISSING INPUT",
                        text: "First name not entered, please check and try again",
                        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                        timeout: 8000
                    });
                    $(".snarl-notification").addClass('snarl-error');
                } else if (!$("#uplname").val()) {
                    Snarl.addNotification({
                        title: "MISSING INPUT",
                        text: "Last name not entered, please check and try again",
                        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                        timeout: 8000
                    });
                    $(".snarl-notification").addClass('snarl-error');
                } else if (!$("#upffname").val()) {
                    Snarl.addNotification({
                        title: "MISSING INPUT",
                        text: "Father's name not entered, please check and try again",
                        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                        timeout: 8000
                    });
                    $(".snarl-notification").addClass('snarl-error');
                } else if (!$("#upfhometown").val()) {
                    Snarl.addNotification({
                        title: "MISSING INPUT",
                        text: "Father's hometown not entered, please check and try again",
                        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                        timeout: 8000
                    });
                    $(".snarl-notification").addClass('snarl-error');
                } else if (!$("#upftel").val()) {
                    Snarl.addNotification({
                        title: "MISSING INPUT",
                        text: "Father's Tel. not entered, please check and try again",
                        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                        timeout: 8000
                    });
                    $(".snarl-notification").addClass('snarl-error');
                } else if (!$("#upmname").val()) {
                    Snarl.addNotification({
                        title: "MISSING INPUT",
                        text: "Mother's name not entered, please check and try again",
                        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                        timeout: 8000
                    });
                    $(".snarl-notification").addClass('snarl-error');
                } else if (!$("#upmhometown").val()) {
                    Snarl.addNotification({
                        title: "MISSING INPUT",
                        text: "Mother's Hometown not entered, please check and try again",
                        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-bug'></i>",
                        timeout: 8000
                    });
                    $(".snarl-notification").addClass('snarl-error');
                } else {
                    var progress = Snarl.addNotification({
                        title: "Please Wait...",
                        text: "Updating Student's Info.",
                        icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-circle-o-notch fa-spin'></i>",
                        timeout: null
                    });
                    $(".snarl-notification").addClass('snarl-info');
                    var data = $("#stud_upform :input").serializeArray();
                    $.post("upstud_script.php", data, function (d) {
                    }).done(function () {
                        var stid = $("#upid").val();
                        var imgcont = "#imgcont_" + $("#upindex").val();
                        var stpic = $("#picpath").val();
                        d.close();
                        single_refresh(id, row);
                        Snarl.removeNotification(progress);
                        Snarl.addNotification({
                            title: "UPDATED",
                            text: "Student's Info. Updated Successfully",
                            icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle-o'></i>",
                            timeout: 3000
                        });
                        $(".snarl-notification").addClass('snarl-success');
                    });
                }
            }
        },
            {
                label: "CANCEL", cssClass: "btn-bad waves-button waves-effect", action: function (d) {
                    d.close();
                }
            }
        ],
        onshown: function () {
            showprogress("upstud-cont");
            $.get("upstud_inputs.php?id=" + id, function (data) {
            }).done(function (data) {
                $("#upstud-cont").html(data);
            }).error(function () {
                cloasedlgs();
                show_error();
            });
        }
    });

}


function printstud(id) {
    window.open("studprofile.php?id=" + id, "Student's Profile", "outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");
}

function delstud(id) {
    BootstrapDialog.show({
        title: "Confirm Delete",
        message: "Are you sure you want to delete this student's info. from the system",
        buttons: [{
            label: "DELETE", cssClass: "btn-bad waves-effect waves-button", action: function (d) {
                d.close();
                $.get("delstud.php?id=" + id, function (data) {
                }).done(function () {
                    var rowid = "#row_" + id;
                    $(rowid).fadeOut(200, function () {
                        $(rowid).remove();
                    });
                    if ($('#cbopage-list').index($('#cbopage-list')) > -1) {
                        Snarl.addNotification({
                            title: "DELETE",
                            text: "Student Deleted successfully",
                            icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle-o'></i>",
                            timeout: 3000
                        });
                        $(".snarl-notification").addClass('snarl-success');
                    } else {
                        Snarl.addNotification({
                            title: "DELETE",
                            text: "Student Deleted successfully",
                            icon: "<i style='margin: 0 !important; height: auto !important; width: auto !important; line-height: normal !important;' class='fa fa-check-circle-o'></i>",
                            timeout: 3000
                        });
                        $(".snarl-notification").addClass('snarl-success');
                    }
                });
            }
        }]

    });

    $(".modal-backdrop").addClass("backdrop-light");
}

//--------------------------------------------------------------------------------