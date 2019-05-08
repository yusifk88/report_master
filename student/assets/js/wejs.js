
var shown =true;
function toggle_sidebar(){

    if(shown == true){
        $("#nav-btn").addClass('spin-once');
        $("#nav-btn").removeClass('spin-reverse');
$("#main-content").removeClass('padding-left');
$("#nav-btn").removeClass('fa-long-arrow-left');
$("#nav-btn").addClass('fa-bars');

        $("#sidebar").transition({x:"-100%"});
        shown =false;

    }else{
        $("#nav-btn").removeClass('spin-once');
        $("#nav-btn").addClass('spin-reverse');
        $("#nav-btn").addClass('fa-long-arrow-left');
        $("#nav-btn").removeClass('fa-bars');
        $("#main-content").addClass('padding-left');
        $("#sidebar").transition({x:"0.6%"});
        shown =true;


    }


}

function get_pergraph(){
    var stindex = $("#global_id").val();


    var options =     {
        "type": "line",
        "data": {
            "datasets": [

                {"label": "",
                    "fill": true,
                    "backgroundColor": [



                    ],
                    "borderColor": [


                    ],
                    "borderWidth": 1
                }

            ]
        },
        "options": {
            legend: {
                display: false,
                labels: {
                    fontColor: 'rgb(255, 99, 132)'
                }},
            responsive: false,
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
                        "beginAtZero": false
                    }
                }]
            }
        }
    };



    $.getJSON("./home/get_graph?id="+stindex)

    .done(function (graph) {

            options.type = "bar";
            options.data.labels = graph.labels;
            options.data.datasets[0].data = graph.avg;
            var ctx = document.getElementById("perf_graph").getContext("2d");
            var myparf = new Chart(ctx,options);
    });
}


function preview_rep(year,term,id){
 window.open("./myreport?ayear=" + year + "&term=" + term + "&id=" + id ,"My report"+year+" Term"+term, "outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");
}


function print_profile(id){
    window.open("./myprofile/printprofile?id=" + id,"my profile"+id, "outerHeight=800px,outerWidth=800px,innerHeight=750px,innerWidth=750px,menubar=yes,scrollbars=yes");

}

$(document).ready(function () {
    get_pergraph();
    $('[data-toggle="popover"]').popover();
    $("#accntfrm").submit(function () {
        let data = $("#accntfrm :input").serializeArray();
var newpass = $("#mypass").val();
var cnewpass = $("#cmypass").val();
      if(newpass == cnewpass){
          $("#accntbtn").attr("disabled", true);
          $("#accntfrm :input").attr("disabled", true);
          $("#progcont").html("<i class='fa fa-circle-o-notch fa-spin fa-2x text-info'></i>");
        $.post("./myprofile/createacnt",data)
              .fail(function(){
                $("#accntbtn").attr("disabled", false);
                $("#accntfrm :input").attr("disabled", false);
                $("#progcont").html("<i class='fa fa-sad-face fa-2x text-danger'> Aw!, something went wrong, please check and try again</i>");
              })
            .done(function () {
                $("#accntbtn").attr("disabled", false);
                $("#accntfrm :input").attr("disabled", false);
                $("#progcont").html("<i class='fa fa-check fa-2x text-info'>Your password has been changed successfully</i>");
           window.location = "./";
            });

      }else{

          $("#accntbtn").attr("disabled", false);
          $("#accntfrm :input").attr("disabled", false);
          $("#progcont").html("<i class='fa fa-sad-face fa-2x text-danger'> Aw!, Your passwords are not the same</i>");

      }

        return false;
    });
});
