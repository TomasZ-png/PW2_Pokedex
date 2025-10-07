
<?php
        if(!isset($_SESSION["rol_usuario"]) && $_SESSION["rol_usuario"] != "ADMIN"){
            header("location: home.php");
        }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $numero = $_POST["numero"];
        $nombre = $_POST["nombre"];
        $tipo = $_POST["tipo"];
        $descripcion = $_POST["descripcion"];
        $imagen = $_FILES["imagen"];
        $errores = [];


        if (empty($numero) || !is_numeric($numero) || $numero <= 0) {
            $errores[] = "Numero invalido";
        } else {
            $stmt = $conn->prepare("SELECT * FROM pokemones WHERE numero = ?");
            $stmt->bind_param("i", $numero);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows > 0) {
                $errores[] = "El numero $numero ya existe";
            }
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
                echo "<h3>No se pudo agregar el Pokemon</h3>";
                echo implode("<br>", $erroresImagen);
                echo "<br>";
                echo implode("<br>", $errores);
            } else {
                $extensionArchivo = strtolower(pathinfo($nombreImagen, PATHINFO_EXTENSION));
                $nombreFinalImagen = $nombre . "." . $extensionArchivo;
                $rutaDeImagen = $directorio . basename($nombreFinalImagen);

                if (move_uploaded_file($nombreTemporal, $rutaDeImagen)) {

                    $stmt2 = $conn->prepare(
                            "INSERT INTO pokemones (numero, nombre, tipo, descripcion, imagen)VALUES(?, ?, ?, ?, ?)");

                    $stmt2->bind_param("issss", $numero, $nombre, $tipo, $descripcion, $nombreFinalImagen);
                    $result = $stmt2->execute();

                    if($result){
                        echo "<h3>Pokemon agregado correctamente</h3>";
                    } else {
                        echo "<h3>Error al agregar al Pokemon</h3>";
                    }

                } else {
                    echo "la imagen no pudo ser subida correctamente";
                }
            }
        } else {
            echo "La imagen esta vacia";
        }
    }

    include_once('../vistas/AgregarPokemonVista.php');