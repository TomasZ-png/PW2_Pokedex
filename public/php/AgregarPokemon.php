<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/agregarPokemonStyles.css">
    <title>Agregar Pokemon</title>
</head>
<body>
<a href="home.php">Volver a inicio</a>

<main>
<h1>Agregar Pokemon</h1>
    <div class="form-container">
    <form action="AgregarPokemon.php" method="post" enctype="multipart/form-data">
        <label for="numero-pokemon">Numero:</label>
        <input type="number" name="numero" id="numero-pokemon" placeholder="Numero">
        <label for="nombre-pokemon">Nombre:</label>
        <input type="text" name="nombre" id="nombre-pokemon" placeholder="Nombre">
        <label for="tipo-pokemon">Tipo de Pokemon:</label>
        <input type="text" name="tipo" id="tipo-pokemon" placeholder="Tipo">
        <label for="descripcion-pokemon">Descripcion:</label>
        <textarea name="descripcion" id="descripcion-pokemon" placeholder="Agrega una descripcion a tu Pokemon"></textarea>
        <label for="imagen-pokemon">Imagen:</label>
        <input type="file" name="imagen" id="imagen-pokemon" placeholder="Numero">
        <button type="submit">Agregar Pokemon</button>
    </form>

<?php
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $numero = $_POST["numero"];
        $nombre = $_POST["nombre"];
        $tipo = $_POST["tipo"];
        $descripcion = $_POST["descripcion"];
        $imagen = $_FILES["imagen"];
        $errores = [];

        if (empty($numero)) {
            $errores[] = "Numero vacio";
        }

        if (empty($nombre) || strlen($nombre) < 3) {
            $errores[] = "Nombre vacio o muy corto";
        }

        if (empty($tipo) || strlen($tipo) < 3) {
            $errores[] = "Tipo vacio o muy corto";
        }

        if (empty($descripcion)) {
            $errores[] = "Descripcion vacia";
        }

        if (isset($_FILES["imagen"])) {
            $nombreImagen = $_FILES["imagen"]["name"];
            $tipoImagen = $_FILES["imagen"]["type"];
            $tamanioImagen = $_FILES["imagen"]["size"];
            $nombreTemporal = $_FILES["imagen"]["tmp_name"];
            $error = $_FILES["imagen"]["error"];
            $directorio = __DIR__ . "/../../src/img/";
            $erroresImagen = [];

            if ($error !== UPLOAD_ERR_OK) {
                $erroresImagen[] = "Error al cargar la imagen. Código de error: $error";
            }

            if (empty($erroresImagen)) {
                $tamanio_max = 5 * 1024 * 1024;

                if ($tamanioImagen > $tamanio_max) {
                    $erroresImagen[] = "La imagen no puede superar los 5 MB";
                }

                $extensiones_permitidas = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];

                if (!in_array($tipoImagen, $extensiones_permitidas)) {
                    $erroresImagen[] = "El tipo de imagen no es permitido";
                }
            }

            if (!empty($erroresImagen) || !empty($errores)) {
                echo "<h3>No se pudo cargar la imagen</h3>";
                echo implode("<br>", $erroresImagen);
                echo "<br>";
                echo implode("<br>", $errores);
            } else {
                $extensionArchivo = strtolower(pathinfo($nombreImagen, PATHINFO_EXTENSION));
                $nombreFinalImagen = $nombre . "." . $extensionArchivo;
                $rutaDeImagen = $directorio . basename($nombreFinalImagen);

                if (move_uploaded_file($nombreTemporal, $rutaDeImagen)) {
                    echo "imagen subida correctamente";
                } else {
                    echo "la imagen no pudo ser subida correctamente";
                }

                include_once(__DIR__ . "/../../src/Entities/MyDatabase.php");
                $conexion = new MyDatabase();

                $query = "INSERT INTO pokemones (numero, nombre, tipo, descripcion, imagen)
                        VALUES ($numero, '$nombre', '$tipo', '$descripcion', '$nombreFinalImagen')";

                $conexion->query($query);

                echo "Pokemon agregado correctamente";
            }
        } else {
            echo "La imagen esta vacia";
        }
    }
?>
    </div>
</main>
</body>
</html>

