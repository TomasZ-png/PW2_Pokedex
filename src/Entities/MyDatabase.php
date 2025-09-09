<?php

class MyDatabase
{
    private $conexion;

    public function __construct($server, $user, $pass, $database){
        $this->conexion = new mysqli($server, $user, $pass, $database);
    }

    public function query($string){
        $result = $this->conexion->query($string);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function __destruct(){
        $this->conexion->close();
    }

}