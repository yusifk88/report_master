<html>
<head>
    <?php
    ini_set("max_execution_time",300);

    include("check_session.php");
    require_once ($_SERVER['DOCUMENT_ROOT'].'/report_master/vendor/autoload.php');
    use  APP\config;
    use APP\school;
    $cf = new config();
    $cf->connect();
    $sch = new school();
    $schname = $sch->schname;
    $title = $_GET['title'];
    $ayear = $_GET["ayear"];
    $form = $_GET["form"];
    $huse = $_GET["house"];
    $prog = $_GET["prog"];
    $cls = $_GET["cls"];
    $gender = $_GET['gender'];
    $ghouse = $_GET['ghouse'];
    $resstatus = $_GET['resstatus'];
    $studsql = "select jhsno,shsno,fname,oname,lname,stindex,form,classes.classname,dept.depname,dob,dor,ffname,fhometown,ftel,gender,ayear,houses.des,houses.name,lschool,mfname,mhometown,mtel,photo,res_status,(select name from houses where id = stuinfo.ghouse) as ghouse from stuinfo,classes,dept,houses where stuinfo.class = classes.id and stuinfo.dept = dept.id and stuinfo.house = houses.id and  stuinfo.dept like '$prog%' and stuinfo.class like '$cls%' and stuinfo.house like '$huse%' and stuinfo.form like '$form%' and stuinfo.ayear like '%$ayear%' and stuinfo.gender like '$gender%' and stuinfo.ghouse LIKE '$ghouse%' and stuinfo.res_status like '%$resstatus%' and stuinfo.id not in(SELECT stid from withdraw)  order by fname ASC,fname ASC";
    $studs = mysqli_query($cf->con, $studsql);
    ?>
    <link href="css/bootstrap-print.css" rel="stylesheet">
    <script src="js/jquery.min.js"></script>
    <style type="text/css">
        table th, table td {
            border: 1px solid #000 !important;
            vertical-align: middle !important;
            font-size: 12px;;
        }
        @media print {
            table, th, tr, td {
                border: 1px solid #000 !important;
            }

            * {
                -webkik-print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <button onclick="window.print();" type="button" class="btn btn-primary btn-link hidden-print">PRINT</button>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"
             style="border-bottom: 1px solid black; margin: 5px;">
            <h2><u><strong><?= strtoupper($schname) ?></strong></u></h2>
            <h5><?= strtoupper($sch->schooladdress) ?></h5>
            <h4><strong><?= $title ? strtoupper($title) : "LIST OF STUDENTS" ?></strong></h4>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <table class="table table-condensed table-striped table-hover">
                <thead>
                <tr class="hidden-print">
                    <th></th>
                    <th id="col1">
                        <button class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="col2">
                        <button onclick="rmcol('col2');" class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="col5">
                        <button onclick="rmcol('col5');" class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="col21">
                        <button onclick="rmcol('col21');" class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="col22">
                        <button onclick="rmcol('col22');" class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="col3">
                        <button onclick="rmcol('col3');" class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="col4">
                        <button onclick="rmcol('col4');" class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="col6">
                        <button onclick="rmcol('col6');" class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="col7">
                        <button onclick="rmcol('col7');" class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="col8">
                        <button onclick="rmcol('col8');" class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="col9">
                        <button onclick="rmcol('col9');" class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="col10">
                        <button onclick="rmcol('col10');" class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="col23">
                        <button onclick="rmcol('col23');" class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="colg10">
                        <button onclick="rmcol('colg10');" class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="col11">
                        <button onclick="rmcol('col11');" class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="col12">
                        <button onclick="rmcol('col12');" class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="col13">
                        <button onclick="rmcol('col13');" class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="col14">
                        <button onclick="rmcol('col14');" class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="col15">
                        <button onclick="rmcol('col15');" class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="col16">
                        <button onclick="rmcol('col16');" class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="col17">
                        <button onclick="rmcol('col17');" class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="col18">
                        <button onclick="rmcol('col18');" class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="col19">
                        <button onclick="rmcol('col19');" class="btn btn-xs btn-danger">X</button>
                    </th>
                    <th id="col20">
                        <button onclick="rmcol('col20');" class="btn btn-xs btn-danger">X</button>
                    </th>
                </tr>
                <tr>
                    <th class="hidden-print"></th>
                    <th id="col1" style="text-align: center;">S/N</th>
                    <th id="col2" class="text-center">PHOTO</th>
                    <th id="col5" style="text-align: center;">ID NO.</th>
                    <th id="col21" style="text-align: center;">JHS NO.</th>
                    <th id="col22" style="text-align: center;">SHS NO.</th>
                    <th id="col3">NAME</th>
                    <th id="col4" style="text-align: center;">SEX.</th>
                    <th id="col6" style="text-align: center;">D.O.B</th>
                    <th id="col7" style="text-align: center;">FORM</th>
                    <th id="col8" style="text-align: center;">CLASS</th>
                    <th id="col9" style="text-align: center;">PROGRAM</th>
                    <th id="col10" style="text-align: center;">HOUSE</th>
                    <th id="col23">RESIDENTIAL STATUS</th>
                    <th id="colg10" style="text-align: center;">GENDER HOUSE/HALL</th>
                    <th id="col11" style="text-align: center;">LAST SCHOOL ATTEN.</th>
                    <th id="col12" style="text-align: center;">ACADEMIC YEAR</th>
                    <th id="col13" style="text-align: center;">FATHER'S NAME</th>
                    <th id="col14" style="text-align: center;">FATHER'S HOMETOWN</th>
                    <th id="col15" style="text-align: center;">FATHER'S PHONE NO.</th>
                    <th id="col16">MOTHER'S NAME</th>
                    <th id="col17" style="text-align: center;">MOTHER'S HOMETOWN</th>
                    <th id="col18">MOTHER'S PHONE NO.</th>
                    <th id="col19">REG. DATE</th>
                    <th id="col20" style="text-align: center;">COMMENT/SING.</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (count($studs) > 0) {
                    $i = 1;
                    while ($stud = mysqli_fetch_object($studs)) {
                        ?>
                        <tr>
                            <td class="hidden-print">
                                <button id="rmrow" class="btn btn-xs btn-danger">X</button>
                            </td>
                            <td class="indexcol" id="col1" style="text-align: center;"><?= $i ?></td>
                            <td id="col2">
                                <center><img src="<?= $stud->photo ?>" width="90" hieght="100"/></center>
                            </td>
                            <td id="col5" style="text-align: center;"><?= $stud->stindex ?></td>
                            <td id="col21" style="text-align: center;"><?= $stud->jhsno ?></td>
                            <td id="col22" style="text-align: center;"><?= $stud->shsno ?></td>
                            <td id="col3"><?= strtoupper($stud->fname . " " . $stud->lname . " " . $stud->oname) ?></td>
                            <td id="col4" style="text-align: center;"><?= $stud->gender ?></td>
                            <td id="col6" style="text-align: center;"><?= $stud->dob ?></td>
                            <td id="col7" style="text-align: center;">Form <?= $stud->form ?></td>
                            <td id="col8" style="text-align: center;"><?= $stud->classname ?></td>
                            <td id="col9" style="text-align: center;"><?= $stud->depname ?></td>
                            <td id="col10" style="text-align: center;"><?= $stud->name ?></td>
                            <td id="col23"><?= $stud->res_status ?></td>
                            <td id="colg10"
                                style="text-align: center;"><?= $stud->ghouse ? $stud->ghouse : "None" ?></td>
                            <td id="col11" style="text-align: center;"><?= $stud->lschool ?></td>
                            <td id="col12"><?= $stud->ayear ?></td>
                            <td id="col13"><?= $stud->ffname ?></td>
                            <td id="col14" style="text-align: center;"><?= $stud->fhometown ?></td>
                            <td id="col15"><?= $stud->ftel ?></td>
                            <td id="col16"><?= $stud->mfname ?></td>
                            <td id="col17" style="text-align: center;"><?= $stud->mhometown ?></td>
                            <td id="col18" style="text-align: center;"><?= $stud->mtel ?></td>
                            <td id="col19" style="text-align: center;"><?= $stud->dor ?></td>
                            <td id="col20" style="text-align: center; vertical-align: bottom;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        </tr>

                        <?php
                        $i++;

                    }

                }

                ?>

                </tbody>


            </table>


        </div>

    </div>
    <button onclick="window.print();" type="button" class="btn btn-primary btn-link hidden-print">PRINT</button>

</div>

<script>
    $(document).ready(function () {
        $("button#rmrow").click(function () {
            $(this).parent().parent().remove();

            for (var i = 0; i < $(".indexcol").length; i++) {

                var el = $(".indexcol")[i];
                el.innerHTML = (i + 1);
            }
        });
    });

    function rmcol(colid) {

        var tdid = 'td#' + colid;
        var thid = 'th#' + colid;
        $(tdid).remove();
        $(thid).remove();
    }

</script>
</body>
</html>