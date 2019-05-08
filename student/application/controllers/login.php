<?php


class login extends CI_Controller
{
    function index(){
$stid = $this->db->escape_str($this->input->get("stid"));
$stpassword = $this->db->escape_str($this->input->get("stpassword"));
$stinfo = $this->db->query("select * from stuinfo WHERE stindex = '$stid'")->result();

$login = $this->db->query("select * from stlogin WHERE stindex = '$stid'")->result();
        if(count($login)>0){
    foreach($login as $l){
    if($l->stpassword == md5($stpassword)){
        session_start();
        $_SESSION['stindex'] = $stid;
        $_SESSION['stpassword'] = $stpassword;
        $_SESSION['stdob'] = $stinfo[0]->dob;
        $_SESSION['fname'] = $stinfo[0]->fname;
        $_SESSION['lname'] = $stinfo[0]->lname;
        $_SESSION['oname'] = $stinfo[0]->oname;
        $_SESSION['photo'] = $stinfo[0]->photo;
        $_SESSION['stid'] = $stinfo[0]->id;
        header("content-type:application/json");
        echo('{
            "status":"ok"
            }
        ');
    }else{

            header("content-type:application/json");
            echo('{
            "status":"no",
            "msg":"Your password is incorrect, please check and try again"
            }
        ');


    }
    }
    }else{
        if(count($stinfo)>0){
            if($stpassword == $stinfo[0]->dob){
                 session_start();
                $_SESSION['stindex'] = $stid;
                $_SESSION['stpassword'] = $stpassword;
                $_SESSION['stdob'] = $stpassword;
                $_SESSION['fname'] = $stinfo[0]->fname;
                $_SESSION['lname'] = $stinfo[0]->lname;
                $_SESSION['oname'] = $stinfo[0]->oname;
                $_SESSION['photo'] = $stinfo[0]->photo;
                $_SESSION['stid'] = $stinfo[0]->id;

                header("content-type:application/json");
                echo('{
            "status":"ok"
            }'
            );
            }else{
            header("content-type:application/json");
            echo('{
            "status":"no",
            "msg":"Your password is incorrect, please check and try again"
            }
        ');
        }

        }else{
            header("content-type:application/json");
            echo('{
        "status":"no",
        "msg":"Sorry, your ID could not be found"
        }
        ');

        }}

    }

}