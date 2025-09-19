<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/agregarPokemonStyles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css"/>
    <link rel="icon" type="image/png" href="\PW2_Pokedex\src\img\favicon.ico">
    <title>Pokedex - Editar Pokemon</title>
</head>
<body>
<div><a class="volver-btn" href="home.php"><i class="bi bi-arrow-left-short"></i> Volver a inicio</a></div>

<?php

session_start();

if(!isset($_SESSION["rol_usuario"]) || $_SESSION["rol_usuario"] != "ADMIN"){
    header("location: home.php");
}

include_once(__DIR__ . "/../../src/Entities/MyDatabase.php");
$conexion = new MyDatabase();
$conn = $conexion->getConexion();

if(isset($_GET["id_pokemon"])){
    $id_pokemon = $_GET["id_pokemon"];
} else{
    $id_pokemon = "";
}

$stmtBuscar = $conn->prepare("SELECT * FROM pokemones WHERE id_pokemon = ?");
$stmtBuscar->bind_param("i", $id_pokemon);
$stmtBuscar->execute();
$resultado = ($stmtBuscar->get_result())->fetch_assoc();

if($resultado){
    $nombrePokemon = $resultado["nombre"];
    $numeroPokemon = $resultado["numero"];
    $descripcionPokemon = $resultado["descripcion"];
    $tipoPokemon = $resultado["tipo"];
    $imagenPokemon = $resultado["imagen"];
}

if (empty($resultado)){
    $nombrePokemon = "";
    $numeroPokemon = "";
    $descripcionPokemon = "";
    $tipoPokemon = "";
    $imagenPokemon = "";
}

echo '<div class="form-container">
        <div class="formulario">

<h1>Editar Pokemon</h1>
    <div class="form-container">
    <form action="EditarPokemon.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_pokemon" value="'. $id_pokemon.'">
        <label for="numero-pokemon">Numero:</label>
        <input type="number" name="numero" id="numero-pokemon" placeholder="Numero" value="'.$numeroPokemon.'">
        <label for="nombre-pokemon">Nombre:</label>
        <input type="text" name="nombre" id="nombre-pokemon" placeholder="Nombre" value="'.$nombrePokemon.'">
        <label for="tipo-pokemon">Tipo de Pokemon:</label>
        <select id="tipo-pokemon" name="tipo">
            <option value="'.$tipoPokemon.'">'.$tipoPokemon.'</option>
            <option value="Normal">Normal</option>
            <option value="Fuego">Fuego</option>
            <option value="Agua">Agua</option>
            <option value="Planta">Planta</option>
            <option value="Electrico">Eléctrico</option>
            <option value="Hielo">Hielo</option>
            <option value="Lucha">Lucha</option>
            <option value="Veneno">Veneno</option>
            <option value="Tierra">Tierra</option>
            <option value="Volador">Volador</option>
            <option value="Psiquico">Psíquico</option>
            <option value="Bicho">Bicho</option>
            <option value="Roca">Roca</option>
            <option value="Fantasma">Fantasma</option>
            <option value="Dragon">Dragón</option>
            <option value="Siniestro">Siniestro</option>
            <option value="Acero">Acero</option>
            <option value="Hada">Hada</option>
        </select>
        <label for="descripcion-pokemon">Descripcion:</label>
        <textarea name="descripcion" id="descripcion-pokemon" placeholder="Agrega una descripcion a tu Pokemon">'.$descripcionPokemon.'</textarea>
        <label for="imagen-pokemon">Imagen:</label>
        <img STYLE="margin: 10px" width="150px" height="150px" src="../../src/img/' . $imagenPokemon . '" alt="foto pokemon">        
        <input type="file" name="imagen" id="imagen-pokemon" placeholder="Numero" >
        <div class="btn-form">
        <button class="form-button" type="submit"><i class="bi bi-check2-circle"></i> Editar Pokemon</button>
        <a class="form-button" href="home.php"><i class="bi bi-x-circle"></i> Cancelar</a>
        </div>
    </form>';



if($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pokemon = $_POST["id_pokemon"];
    $numero = $_POST["numero"];
    $nombre = $_POST["nombre"];
    $tipo = $_POST["tipo"];
    $descripcion = $_POST["descripcion"];
    $imagen = $_FILES["imagen"];
    $errores = [];

    
    if (empty($numero) || !is_numeric($numero) || $numero <= 0) {
        $errores[] = "Numero invalido";
    }

    if (empty($nombre) || strlen($nombre) < 3) {
        $errores[] = "Nombre vacio o muy corto";
    }

    $tiposAceptados = ["Normal", "Fuego", "Agua", "Planta", "Electrico", "Hielo", "Lucha", "Veneno",
                         "Tierra", "Volador", "Psiquico", "Bicho", "Roca", "Fantasma", "Dragon",
                         "Siniestro", "Acero", "Hada"];

    if (empty($tipo)) {
        $errores[] = "Tipo vacio";
    } else {
        if(!in_array($tipo, $tiposAceptados)) {
            $errores[] = "Tipo de Pokemon no permitido";
        }
    }

    if (empty($descripcion)) {
        $errores[] = "Descripcion vacia";
    }
    
    // --- LÓGICA DE IMAGEN ---
    // Si se sube una imagen, se valida y se actualiza
    $nombreFinalImagen = null;
    $rutaDeImagen = null;
    $imagenSubida = false;

    if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] === UPLOAD_ERR_OK) {
        $nombreImagen = $_FILES["imagen"]["name"];
        $tipoImagen = $_FILES["imagen"]["type"];
        $tamanioImagen = $_FILES["imagen"]["size"];
        $nombreTemporal = $_FILES["imagen"]["tmp_name"];
        $directorio = __DIR__ . "/../../src/img/";
        
        $tamanio_max = 5 * 1024 * 1024;
        $extensiones_permitidas = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];

        if ($tamanioImagen > $tamanio_max) {
            $errores[] = "La imagen no puede superar los 5 MB";
        }
        if (!in_array($tipoImagen, $extensiones_permitidas)) {
            $errores[] = "El tipo de imagen no es permitido";
        }

        if (empty($errores)) {
            $extensionArchivo = strtolower(pathinfo($nombreImagen, PATHINFO_EXTENSION));
            $nombreFinalImagen = $nombre . "." . $extensionArchivo;
            $rutaDeImagen = $directorio . basename($nombreFinalImagen);
            $imagenSubida = true;
        }

    } else if ($_FILES["imagen"]["error"] !== UPLOAD_ERR_NO_FILE) {
        
        $errores[] = "Error al cargar la imagen. Código de error: " . $_FILES["imagen"]["error"];
    }

    if (empty($errores)) {
       
        if ($imagenSubida) {
             move_uploaded_file($nombreTemporal, $rutaDeImagen);
        }
        
        if ($imagenSubida) {
            $stmt2 = $conn->prepare(
                "UPDATE pokemones SET numero = ?, nombre = ?, tipo = ?, descripcion = ?, imagen = ? WHERE id_pokemon = ?");
            $stmt2->bind_param("issssi", $numero, $nombre, $tipo, $descripcion, $nombreFinalImagen, $id_pokemon);
        } else {
            $stmt2 = $conn->prepare(
                "UPDATE pokemones SET numero = ?, nombre = ?, tipo = ?, descripcion = ? WHERE id_pokemon = ?");
            $stmt2->bind_param("isssi", $numero, $nombre, $tipo, $descripcion, $id_pokemon);
        }

        $result = $stmt2->execute();

        if($result){
            echo "<h3>Pokemon editado correctamente</h3>";
        } else {
            echo "<h3>Error al editar al Pokemon</h3>";
        }
    } else {
        echo "<h3>No se pudo editar el Pokemon</h3>";
        echo implode("<br>", $errores);
    }
}
?>

</body>
</html>
