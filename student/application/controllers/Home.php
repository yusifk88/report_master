<?php

class Home extends CI_Controller
{
function index(){
        session_start();
 if(!isset($_SESSION['stindex'])){
            $this->load->view("login");
 }else{
     $data['active'] = 0;
     $this->load->model("utility");
     $myid = $_SESSION['stid'];
            $myyears = $this->db->query("select distinct(acyear)as ayear from records where stid = '$myid'");
            $myterms = 0;
     $mycmments = $this->db->query("select * from ginfo where stid ='$myid'")->result();
     $frmrecs = $this->db->query("select * from frmass where stid ='$myid'")->result();
     $years =0;
     $ayears = $myyears->result();
            foreach($ayears as $my){
                $termcnt = $this->db->query("select distinct(term) from records where stid='$myid' and acyear='$my->ayear'")->num_rows();
                $myterms+=$termcnt;
                $years++;
            }
            $data['numyears'] = $years;
            $data['numterms'] = $myterms;
            $data['comments'] = $mycmments;
            $data['frmrecs'] = $frmrecs;
            $this->load->view("temp/header",$data);
            $this->load->view("dashboard");
            $this->load->view("temp/footer");
 }

}



    function get_graph(){
        session_start();
        $this->load->model("utility");
        $this->load->model("school");
        $myid = $_SESSION['stid'];
        $mysubs = $this->db->query("select * from subjects where id in(select DISTINCT(subjt) from records where stid = '$myid' ) ORDER BY subjdesc ASC")->result();
        $i =0;
        $subarr=array();
        $avgarr = array();
        $cls_ratio = $this->school->clscore_ratio;
        $sba = $this->school->sba;
        $exam_ratio = $this->school->exam_ratio;
        foreach($mysubs as $sub){
            $cntsm = 0;
            $ayear = $this->db->query("select distinct(acyear) as ayear from records where stid = '$myid' AND subjt='$sub->id'")->result();
            foreach($ayear as $y){
                $cnt = $this->db->query("select distinct(term) from records where subjt = '$sub->id' and stid = '$myid' and acyear ='$y->ayear'")->num_rows();
                $cntsm+= $cnt;
            }
        $rep = $this->db->query("select sum((subtotl*$cls_ratio)/$sba+(exam*($exam_ratio/100))) as sm from records where stid = '$myid' and subjt = '$sub->id' ")->result();
        $subarr[$i] = $sub->subjdesc;
        $sub_sum = $rep[0]->sm;
        $avgarr[$i] = number_format($sub_sum/$cntsm,1);
        $i++;
        }
        $data = (object)[
            "labels"=>$subarr,
            "avg"=>$avgarr
        ];
        header("content-type:application/json");
        echo(json_encode($data));
    }

}