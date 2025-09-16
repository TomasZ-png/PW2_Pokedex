<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrarse</title>
</head>
<body>
    <h1>Bienvenido a Pokedex!</h1>

    <form action="registrarse.php" method="post" enctype="multipart/form-data">
        <label for="nombre">Nombre:</label>
        <input id="nombre" type="text" name="nombre" placeholder="Nombre">
        <label for="correo">Correo:</label>
        <input id="correo" type="text" name="correo" placeholder="Correo">
        <label for="contrasenia">Contraseña:</label>
        <input id="contrasenia" type="password" name="password" placeholder="Contraseña">
        <button type="submit">Registrarse</button>
    </form>

    <?php
        session_start();
        include_once(__DIR__ . "/../../src/Entities/MyDatabase.php");
        $conexion = new MyDatabase();
        $conn = $conexion->getConexion();

        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $nombre = $_POST["nombre"];
            $correo = $_POST["correo"];
            $contrasenia = $_POST["password"];
            $errores = [];

            if(empty($nombre) || empty($correo) || empty($contrasenia)){
                $errores[] = "Todos los campos son obligatorios";
            }else{

                if(strlen($nombre) < 3 || strlen($nombre) > 20 ){
                    $errores[] = "El nombre debe tener al menos entre 3 y 20 caracteres";
                }

                $regex_correo = "/^[\w\-.]+@[\w\-]+(\.[a-zA-Z]{2,4}){1,2}$/";

                if(!preg_match($regex_correo, $correo)){
                    $errores[] = "Correo no valido";
                }

                $regex_contrasenia = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[\w\-.]{8,}$/";

                if(!preg_match($regex_contrasenia, $contrasenia)){
                    $errores[] = "Contraseña no valida";
                }
            }

            if(sizeof($errores) > 0){
                echo implode("<br>", $errores);
            } else {

                $stmt = $conn->prepare("SELECT * FROM usuario WHERE correo = ?");
                $stmt->bind_param("s", $correo);
                $stmt->execute();
                $result = $stmt->get_result();

                if($result->num_rows > 0){
                    echo "El usuario ya existe";
                } else {
                    $stmt2 = $conn->prepare("INSERT INTO usuario (nombre, correo, password, rol) 
                                                    VALUES(?, ?, ?, 'USER')");
                    $stmt2->bind_param("sss", $nombre, $correo, $contrasenia);
                    $result2 = $stmt2->execute();
                    if($result2){
                        echo "El usuario se registro correctamente";

                        $id_usuario = $conn->insert_id;

                        $stmt3 = $conn->prepare("SELECT u.id_usuario, u.rol, u.nombre FROM usuario u WHERE id_usuario = ?");
                        $stmt3->bind_param("i", $id_usuario);
                        $stmt3->execute();
                        $resultado = ($stmt3->get_result())->fetch_assoc();

                        $_SESSION["id_usuario"] = $id_usuario;
                        $_SESSION["rol_usuario"] = $resultado['rol'];
                        $_SESSION["nombre_usuario"] = $resultado['nombre'];
                        header("location: home.php");
                        exit();
                    } else {
                        echo "El usuario no se registro correctamente";
                        header("location: registrarse.php");
                        exit();
                    }
                }
            }
        }


    ?>

</body>
</html>
<?php
