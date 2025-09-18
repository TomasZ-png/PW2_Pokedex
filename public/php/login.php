<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="\PW2_Pokedex\src\img\favicon.ico">
    <title>Iniciar Sesion</title>
</head>
<body>
<h1>Bienvenido de nuevo!</h1>

<form action="login.php" method="post" enctype="multipart/form-data">
    <label for="correo">Correo:</label>
    <input id="correo" type="text" name="correo" placeholder="Correo">
    <label for="contrasenia">Contraseña:</label>
    <input id="contrasenia" type="password" name="password" placeholder="Contraseña">
    <button type="submit">Iniciar Sesion</button>
</form>

    <?php
        session_start();

        if(isset($_SESSION["id_usuario"]) || isset($_SESSION["nombre_usuario"]) || isset($_SESSION["rol_usuario"])){
            header("Location: home.php");
            exit();
        }

        include_once(__DIR__ . "/../../src/Entities/MyDatabase.php");
        $conexion = new MyDatabase();
        $conn = $conexion->getConexion();

        if($_SERVER["REQUEST_METHOD"]=="POST"){
            $correo = $_POST["correo"];
            $password = $_POST["password"];

            if(empty($correo) || empty($password)){
                echo "<p>Todos los campos son obligatorios</p>";
            } else {
                $stmt = $conexion->prepare("SELECT * FROM usuario WHERE correo = ? AND password = ?");
                $stmt->bind_param("ss", $correo, $password);
                $stmt->execute();
                $result = ($stmt->get_result())->fetch_assoc();

                if($result){
                    $_SESSION["nombre_usuario"] = $result["nombre"];
                    $_SESSION["rol_usuario"] = $result["rol"];
                    $_SESSION["id_usuario"] = $result["id_usuario"];
                    header("location: home.php");
                    exit();
                } else {
                    echo "<p>Correo o contraseña incorrectos</p>";
                }
            }
        }

    ?>

</body>
</html>