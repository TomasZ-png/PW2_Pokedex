    <?php
    global $conn;
        include_once ('../vistas/LoginVista.php');

        $conn = $conexion->getConexion();

        if(isset($_SESSION["id_usuario"]) || isset($_SESSION["nombre_usuario"]) || isset($_SESSION["rol_usuario"])){
            header("Location: home.php");
            exit();
        }

        if($_SERVER["REQUEST_METHOD"]=="POST"){
            $correo = $_POST["correo"];
            $password = $_POST["password"];

            if(empty($correo) || empty($password)){
                echo "<p class='errores'>*Todos los campos son obligatorios</p>";
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
                    echo "<p class='errores'>*Correo o contraseña incorrectos</p>";
                }
            }
        }

    ?>
