<?php

class config
{
    var $host = "10.0.0.100";
    var $user = "skull";
    var $password = "Myname@032102726042_oracle_db";
    var $db = "q_db";
    var $con;

    public function connect()
    {
        $this->con = mysqli_connect($this->host, $this->user, $this->password);
        mysqli_select_db($this->con, $this->db);
    }

}