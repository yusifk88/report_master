<?php

/**
 * Created by PhpStorm.
 * User: Godson
 * Date: 4/24/2018
 * Time: 10:08 PM
 */
class myreports extends CI_Controller
{
    function index()
    {

        session_start();
        if (!isset($_SESSION['stindex'])) {
            $this->load->view("login");
        } else {
            $this->load->model("school");
            $this->load->model("utility");
            $data['cls_ratio'] = $this->school->clscore_ratio;
            $data['sba'] = $this->school->sba;
            $data['exam_ratio'] = $this->school->exam_ratio;

            $stid = $_SESSION['stid'];
            $data['stid']=$stid;
            $ayears = $this->db->query("select distinct(acyear) as ayear from records where stid = '$stid' ")->result();
            $data['myyears'] = $ayears;
            $data['active'] = 1;
            $this->load->view("temp/header", $data);
            $this->load->view("reports");
            $this->load->view("temp/footer");
        }
    }


}