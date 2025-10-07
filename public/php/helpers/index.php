<?php

session_start();

include_once("../helpers/MyDatabase.php");
$conexion = new MyDatabase();

$conn = $conexion->getConexion();


$request = $_GET["request"];

switch ($request) {
    case 'login':
        include_once('../controllers/login.php');
        break;
    case 'registrarse':
        include_once('../controllers/registrarse.php');
        break;
    case 'logout':
        include_once('../controllers/logout.php');
        break;
    case 'vista-pokemon':
        include_once('../controllers/pokemonVista.php');
        break;
    case 'agregar-pokemon':
        include_once('../controllers/agregarPokemon.php');
        break;
    case 'editar-pokemon':
        include_once('../controllers/editarPokemon.php');
        break;
    case 'eliminar-pokemon':
        include_once('../controllers/BorrarPokemon.php');
        break;
    case 'buscar-pokemon':
        include_once('../controllers/pokemonBuscado.php');
        break;
    default:
        include_once('../controllers/home.php');
        break;
}