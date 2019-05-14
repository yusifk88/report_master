<?php
foreach ($myyears as $y) {
    $term_1_rep1 = $this->db->query("select cls,subjt,subtotl,exam,cvsubtotl,cvexam,totlscore,subjects.subjdesc,post,((subtotl*$cls_ratio)/$sba+(exam*($exam_ratio/100))) as tscore from records,subjects where acyear = '$y->ayear' and term = '1' and stid = '$stid' and records.subjt = subjects.id order by subjects.type ASC ")->result();
    $term_2_rep1 = $this->db->query("select cls,subjt,subtotl,exam,cvsubtotl,cvexam,totlscore,subjects.subjdesc,post,((subtotl*$cls_ratio)/$sba+(exam*($exam_ratio/100))) as tscore from records,subjects where acyear = '$y->ayear' and term = '2' and stid = '$stid' and records.subjt = subjects.id order by subjects.type ASC ")->result();
    $term_3_rep1 = $this->db->query("select cls,subjt,subtotl,exam,cvsubtotl,cvexam,totlscore,subjects.subjdesc,post,((subtotl*$cls_ratio)/$sba+(exam*($exam_ratio/100))) as tscore from records,subjects where acyear = '$y->ayear' and term = '3' and stid = '$stid' and records.subjt = subjects.id order by subjects.type ASC ")->result();
    ?>
    <div id="accordion" class="mt-5">
        <div class="card mt-5">
            <div class="card-header" id="heading">
                <h6 class="mb-0">
                    <button class="btn btn-link text-info " data-toggle="collapse"
                            data-target="#collapse<?= $y->ayear ?>"
                            aria-expanded="true" aria-controls="collapse">
                        <strong class="text-info"><?= $y->ayear ?></strong>
                        <strong> <i class="fa fa-angle-down text-info fa-3x"></i> </strong>
                    </button>
                </h6>
            </div>
            <div id="collapse<?= $y->ayear ?>" class="collapse" aria-labelledby="heading" data-parent="#accordion">
                <div class="card-body">
                    <?php
                    if (count($term_1_rep1) > 0) {
                        ?>
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="card animated fadeInUp">
                                    <div class="card-header bg-white">
                                        <span class="label bg-info p-4 text-white rased">1<sup>ST</sup> TERM</span>
                                        <button onclick="preview_rep('<?= $y->ayear ?>','1',<?= $stid ?>);"
                                                class="btn btn-info pull-right">Preview & Print
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover table-condensed">
                                                <thead>
                                                <tr class="text-info">
                                                    <th>SUBJECT</th>
                                                    <th class="text-center">SBA(30%)</th>
                                                    <th class="text-center">EXAM(70%)</th>
                                                    <th class="text-center">TOTAL MARK</th>
                                                    <th class="text-center">GRADE</th>
                                                    <th class="text-center">REMARK</th>
                                                    <th class="text-center">SUB POS.</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $tscore1 = 0;
                                                $numsb1 = 0;
                                                $cls_ratio = $this->utility->clscore_ratio;
                                                $sba = $this->utility->sba;
                                                $exam_ratio = $this->utility->exam_ratio;
                                                foreach ($term_1_rep1 as $rep) {
                                                    $cvsubtotal = (($cls_ratio / $sba) * $rep->subtotl);
                                                    $cvexam = (($exam_ratio / 100) * $rep->exam);
                                                    $totlscore = ($cvsubtotal + $cvexam);
                                                    $tscore1 += $rep->tscore;
                                                    $numsb1++;
                                                    $subpost = 0;
                                                    $pos = $this->db->query("select (((subtotl*$cls_ratio)/$sba)+(exam*($exam_ratio/100))) as tscore,stid from records where cls = '$rep->cls' and acyear = '$y->ayear' and term = '1' and records.subjt ='$rep->subjt' ORDER BY tscore DESC")->result();
                                                    foreach ($pos as $p) {
                                                        $subpost++;
                                                        if ($p->stid == $stid) {

                                                            break;
                                                        }
                                                    }
                                                    ?>

                                                    <tr>
                                                        <td><?= $rep->subjdesc ?></td>
                                                        <td class="text-center"><?= $cvsubtotal ?></td>
                                                        <td class="text-center"><?= $cvexam ?></td>
                                                        <td class="text-center"><?= $totlscore ?></td>
                                                        <td class="text-center"><?= $this->utility->getgrd($totlscore) ?></td>
                                                        <td class="text-center"><?= $this->utility->getremark($totlscore) ?></td>
                                                        <td class="text-center"
                                                            style="text-align: center;"><?= $this->utility->addsufix($subpost) ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    if (count($term_2_rep1) > 0) {
                        ?>
                        <div class="row mt-4">
                            <div class="col-lg-12 col-md-12">
                                <div class="card animated fadeInUp">
                                    <div class="card-header bg-white">
                                        <span class="label rgba-orange-strong p-4 text-white">2<sup>ND</sup> TERM</span>
                                        <button onclick="preview_rep('<?= $y->ayear ?>','2',<?= $stid ?>);"
                                                class="btn btn-info pull-right">Preview & Print
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover table-condensed">
                                                <thead>
                                                <tr class="text-warning">
                                                    <th>SUBJECT</th>
                                                    <th class="text-center">SBA(30%)</th>
                                                    <th class="text-center">EXAM(70%)</th>
                                                    <th class="text-center">TOTAL MARK</th>
                                                    <th class="text-center">GRADE</th>
                                                    <th class="text-center">REMARK</th>
                                                    <th class="text-center">SUB POS.</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $tscore1 = 0;
                                                $numsb1 = 0;
                                                foreach ($term_2_rep1 as $rep) {
                                                    $cvsubtotal = (($cls_ratio / $sba) * $rep->subtotl);
                                                    $cvexam = (($exam_ratio / 100) * $rep->exam);
                                                    $totlscore = ($cvsubtotal + $cvexam);
                                                    $tscore1 += $rep->tscore;
                                                    $numsb1++;
                                                    $subpost2 = 0;
                                                    $pos2 = $this->db->query("select (((subtotl*$cls_ratio)/$sba)+(exam*($exam_ratio/100))) as tscore,stid from records where cls = '$rep->cls' and acyear = '$y->ayear' and term = '2' and records.subjt ='$rep->subjt' ORDER BY tscore DESC")->result();
                                                    foreach ($pos2 as $p) {
                                                        $subpost2++;
                                                        if ($p->stid == $stid) {

                                                            break;
                                                        }
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td><?= $rep->subjdesc ?></td>
                                                        <td class="text-center"><?= $cvsubtotal ?></td>
                                                        <td class="text-center"><?= $cvexam ?></td>
                                                        <td class="text-center"><?= $totlscore ?></td>
                                                        <td class="text-center"><?= $this->utility->getgrd($totlscore) ?></td>
                                                        <td class="text-center"><?= $this->utility->getremark($totlscore) ?></td>
                                                        <td class="text-center"
                                                            style="text-align: center;"><?= $this->utility->addsufix($subpost2) ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php

                    }
                    if (count($term_3_rep1) > 0) {
                        ?>
                        <div class="row mt-4">
                            <div class="col-lg-12 col-md-12">
                                <div class="card animated fadeInUp">
                                    <div class="card-header bg-white">
                                        <span class="label rgba-indigo-strong p-4 text-white">3<sup>RD</sup> TERM</span>
                                        <button onclick="preview_rep('<?= $y->ayear ?>','3',<?= $stid ?>);"
                                                class="btn btn-info pull-right">Preview & Print
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover table-condensed">
                                                <thead>
                                                <tr style="color: rgba(63, 81, 181, 0.7);">
                                                    <th>SUBJECT</th>
                                                    <th class="text-center">SBA(30%)</th>
                                                    <th class="text-center">EXAM(70%)</th>
                                                    <th class="text-center">TOTAL MARK</th>
                                                    <th class="text-center">GRADE</th>
                                                    <th class="text-center">REMARK</th>
                                                    <th class="text-center">SUB POS.</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $tscore1 = 0;
                                                $numsb1 = 0;
                                                foreach ($term_3_rep1 as $rep) {
                                                    $cvsubtotal = (($cls_ratio / $sba) * $rep->subtotl);
                                                    $cvexam = (($exam_ratio / 100) * $rep->exam);
                                                    $totlscore = ($cvsubtotal + $cvexam);
                                                    $tscore1 += $rep->tscore;
                                                    $numsb1++;
                                                    $subpost3 = 0;
                                                    $pos3 = $this->db->query("select (((subtotl*$cls_ratio)/$sba)+(exam*($exam_ratio/100))) as tscore,stid from records where cls = '$rep->cls' and acyear = '$y->ayear' and term = '3' and records.subjt ='$rep->subjt' ORDER BY tscore DESC")->result();
                                                    foreach ($pos3 as $p3) {
                                                        $subpost++;
                                                        if ($p3->stid == $stid) {

                                                            break;
                                                        }
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td><?= $rep->subjdesc ?></td>
                                                        <td class="text-center"><?= $cvsubtotal ?></td>
                                                        <td class="text-center"><?= $cvexam ?></td>
                                                        <td class="text-center"><?= $totlscore ?></td>
                                                        <td class="text-center"><?= $this->utility->getgrd($totlscore) ?></td>
                                                        <td class="text-center"><?= $this->utility->getremark($totlscore) ?></td>
                                                        <td class="text-center"
                                                            style="text-align: center;"><?= $this->utility->addsufix($subpost3) ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                </div>
            </div>
        </div>

    </div>


    <?php

}

?>

<script>


</script>
