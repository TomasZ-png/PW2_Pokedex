<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/agregarPokemonStyles.css">
    <title>Pokedex - Editar Pokemon</title>
</head>
<body>
<a href="home.php">Volver a inicio</a>


<h1>Editar Pokemon</h1>
    <div class="form-container">
    <form action="" method="post" enctype="multipart/form-data">
        <label for="numero-pokemon">Numero:</label>
        <input type="number" name="numero" id="numero-pokemon" placeholder="Numero">
        <label for="nombre-pokemon">Nombre:</label>
        <input type="text" name="nombre" id="nombre-pokemon" placeholder="Nombre">
        <label for="tipo-pokemon">Tipo de Pokemon:</label>
        <select id="tipo-pokemon" name="tipo">
            <option value="" disabled selected>-- Seleccione el tipo de Pokemon --</option>
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
        <textarea name="descripcion" id="descripcion-pokemon" placeholder="Agrega una descripcion a tu Pokemon"></textarea>
        <label for="imagen-pokemon">Imagen:</label>
        <input type="file" name="imagen" id="imagen-pokemon" placeholder="Numero">
        <button type="submit">Editar Pokemon</button>
    </form>
    
</body>
</html>




<?php

session_start();

if(!isset($_SESSION["rol_usuario"]) && $_SESSION["rol_usuario"] != "ADMIN"){
    header("location: home.php");
}

include_once(__DIR__ . "/../../src/Entities/MyDatabase.php");
$conexion = new MyDatabase();
$conn = $conexion->getConexion();

if($_SERVER["REQUEST_METHOD"] == "POST") {
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
            $stmt2->bind_param("issssi", $numero, $nombre, $tipo, $descripcion, $nombreFinalImagen, $id);
        } else {
            
            $stmt2 = $conn->prepare(
                "UPDATE pokemones SET numero = ?, nombre = ?, tipo = ?, descripcion = ? WHERE id_pokemon = ?");
            $stmt2->bind_param("isssi", $numero, $nombre, $tipo, $descripcion, $id);
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