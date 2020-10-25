<?php
namespace APP;


class DB
{
    private $connection;

    public function __construct()
    {
        $cn = new config();
        $cn->connect();;
        $this->connection = $cn->con;

    }

    public static function select(string $query){
        try {
            $cn = new config();
            $cn->connect();;
            $items = mysqli_query($cn->con,$query);
            return mysqli_fetch_object($items);
        }catch (Exception $e){

            throw new Exception($e->getMessage());
        }


    }

}