<?php

/**
 * Created by PhpStorm.
 * User: Godson
 * Date: 4/30/2018
 * Time: 3:19 PM
 */
class myprofile extends CI_Controller
{

    function index(){

        session_start();
        if(!isset($_SESSION['stindex'])){
            $this->load->view("login");
        }else{
            $data['active'] = 0;
            $myid = $_SESSION['stid'];
            $myinfo = $this->db->query("select stuinfo.*,stuinfo.id as stid,classes.classname,houses.name,dept.depname,houses.des from stuinfo,classes,dept,houses WHERE stuinfo.id = '$myid' and stuinfo.class=classes.id and stuinfo.dept = dept.id and stuinfo.house=houses.id")->result()[0];
            $data['myinfo'] =$myinfo;
            $this->load->view("temp/header",$data);
            $this->load->view("myprofile");
            $this->load->view("temp/footer");
        }
    }
    function printprofile(){
        $this->load->model("school");
        $this->load->model("utility");
        $myid = $this->input->get('id');
        $myinfo = $this->db->query("select stuinfo.*,stuinfo.id as stid,classes.classname,houses.name,dept.depname,houses.des from stuinfo,classes,dept,houses WHERE stuinfo.id = '$myid' and stuinfo.class=classes.id and stuinfo.dept = dept.id and stuinfo.house=houses.id")->result()[0];
        $cmnt = $this->db->query("select * from ginfo WHERE stid = '$myid' order BY id DESC ")->result();
        $data['myinfo'] = $myinfo;
        $data['crest'] = $this->school->logopath;
        $data['schname'] = $this->school->schname;
        $data['address'] = $this->school->schooladdress;
        $data['cmnt'] = $cmnt;
        $this->load->view("profile",$data);
    }


    function createacnt(){
        session_start();
        $myindex = $this->input->post("myindex");
        $newpass = md5($this->db->escape_str($this->input->post("newpass")));
        $test = $this->db->query("select * from stlogin where stindex = '$myindex'")->num_rows();
        if($test <1){

            $this->db->query("insert into stlogin(stindex,stpassword) VALUES('$myindex','$newpass')");
        }else{

          $this->db->query("update stlogin set stpassword = '$newpass' where stindex = '$myindex'");

        }




        session_destroy();
    }
}