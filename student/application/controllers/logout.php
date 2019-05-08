<?php

/**
 * Created by PhpStorm.
 * User: Godson
 * Date: 4/30/2018
 * Time: 12:24 AM
 */
class logout extends CI_Controller
{
    function index(){

        session_start();
        session_destroy();
        header("location:".base_url());


    }

}