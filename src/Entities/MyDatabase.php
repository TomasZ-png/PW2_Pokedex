<?php

class MyDatabase
{
    private $conexion;

    public function __construct(){
        $config = parse_ini_file(__DIR__ . "/../../config/config.ini");
        $this->conexion = new mysqli(
            $config["server"],
            $config["user"],
            $config["pass"],
            $config["database"]
        );

        if($this->conexion->connect_error){
            echo "Error al conectar con la base de datos." . $this->conexion->connect_error;
        }
    }

    public function query($string){
        $result = $this->conexion->query($string);

        if($result === false){
            die("Error en la consulta. " . $this->conexion->error);
        }

        if($result instanceof mysqli_result){
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return $result;
        }
    }

    public function prepare($string){
        return $this->conexion->prepare($string);
    }

    public function getConexion()
    {
        return $this->conexion;
    }

    public function __destruct(){
        $this->conexion->close();
    }

}