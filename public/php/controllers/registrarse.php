<?php
        include_once ('../vistas/RegistrarseVista.php');

        if(isset($_SESSION["id_usuario"]) || isset($_SESSION["nombre_usuario"]) || isset($_SESSION["rol_usuario"])){
            header("Location: home.php");
            exit();
        }

        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $nombre = $_POST["nombre"];
            $correo = $_POST["correo"];
            $contrasenia = $_POST["password"];
            $errores = [];

            if(empty($nombre) || empty($correo) || empty($contrasenia)){
                $errores[] = "<p class='errores'>*Todos los campos son obligatorios</p>";
            }else{

                if(strlen($nombre) < 3 || strlen($nombre) > 20 ){
                    $errores[] = "<p class='errores'>*El nombre debe tener al menos entre 3 y 20 caracteres</p>";
                }

                $regex_correo = "/^[\w\-.]+@[\w\-]+(\.[a-zA-Z]{2,4}){1,2}$/";

                if(!preg_match($regex_correo, $correo)){
                    $errores[] = "<p class='errores'>*Correo no valido</p>";
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
                    echo "<p class='errores'>*El usuario ya existe</p>";
                } else {
                    $stmt2 = $conn->prepare("INSERT INTO usuario (nombre, correo, password, rol) 
                                                    VALUES(?, ?, ?, 'USER')");
                    $stmt2->bind_param("sss", $nombre, $correo, $contrasenia);
                    $result2 = $stmt2->execute();
                    if($result2){
                        echo "<p>El usuario se registro correctamente</p>";

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
                        echo "<p class='errores'>*El usuario no se registro correctamente</p>";
                        header("location: registrarse.php");
                        exit();
                    }
                }
            }
        }