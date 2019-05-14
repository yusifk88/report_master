<?php

class config
{
    var $host = "localhost";
    var $user = "root";
    var $password = "";
    var $db = "reportdb";
    var $con;

    public function connect()
    {
        $this->con = mysqli_connect($this->host, $this->user, $this->password);
        mysqli_select_db($this->con, $this->db);
    }

}