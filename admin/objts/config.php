<?php
namespace APP;
require_once (__DIR__.'/vendor/autoload.php');

class config
{
    public $host = "127.0.0.1";
    public $user = "root";
    public $password = "password";
    public $db = "reportdb";
    public $con;

    public function connect()
    {
        $this->con = mysqli_connect($this->host, $this->user, $this->password);
        mysqli_select_db($this->con, $this->db);
    }

}