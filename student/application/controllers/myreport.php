<?php

/**
 * Created by PhpStorm.
 * User: Godson
 * Date: 4/26/2018
 * Time: 12:01 AM
 */
class myreport extends CI_Controller
{

    function index()
    {
        $ayear = $this->input->get("ayear");
        $term = $this->input->get("term");
        $id = $this->input->get("id");
        $this->load->model("school");
        $this->load->model("utility");
        $cls_ratio = $this->school->clscore_ratio;
        $exam_ratio = $this->school->exam_ratio;
        $sba = $this->school->sba;
        $cls = $this->db->query("select DISTINCT(cls) from records WHERE stid='$id' and acyear ='$ayear' and term='$term'")->result()[0]->cls;
        $stinfo = $this->db->query("select fname,lname,oname,photo,fhometown,ftel,mtel,houses.name,classes.classname,stuinfo.class from stuinfo, houses,classes where stuinfo.id = '$id' and house = houses.id and stuinfo.class = classes.id ")->result()[0];
        $myclas = $this->db->query("select * from classes where id ='$cls'")->result()[0];
        $rep1 = $this->db->query("select subjt,subtotl,exam,cvsubtotl,cvexam,totlscore,subjects.subjdesc,post,((subtotl*$cls_ratio)/$sba+(exam*($exam_ratio/100))) as tscore from records,subjects where acyear = '$ayear' and term = '$term' and stid = '$id' and records.subjt = subjects.id and subjects.type = 'Core Subject'")->result();
        $rep2 = $this->db->query("select subjt,subtotl,exam,cvsubtotl,cvexam,totlscore,subjects.subjdesc,grd,remark,post,((subtotl*$cls_ratio)/$sba+(exam*($exam_ratio/100))) as tscore from records,subjects where acyear = '$ayear' and term = '$term' and stid = '$id' and records.subjt = subjects.id and subjects.type = 'Elective Subject'")->result();
        $num_rol = $this->db->query("select distinct(stid) from records where cls = '$cls' and acyear = '$ayear' and term = '$term'")->num_rows();


        $data['rep1'] = $rep1;
        $data['rep2'] = $rep2;
        $data['info'] = $stinfo;
        $data['myclas'] = $myclas;
        $data['ayear'] = $ayear;
        $data['term'] = $term;
        $data['id'] = $id;
        $data['cls_ratio'] = $this->school->clscore_ratio;
        $data['exam_ratio'] = $this->school->exam_ratio;
        $data['sba'] = $this->school->sba;
        $data['num_rol'] = $num_rol;
        $data['schname'] = $this->school->schname;
        $data['schaddress'] = $this->school->schooladdress;
        $data['crest'] = $this->school->logopath;
        $this->load->view("reportView", $data);


    }

}