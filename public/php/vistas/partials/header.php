<div class="header-arriba">
    <div class="titulo-logo-container">
        <div class="imagen-contenedor">
            <a href="../../controllers/home.php"><img class="logo" src="../../../../src/img/logo-pokebola.png" alt="logo pokebola"></a>
        </div>
        <div class="titulo-container">
            <h1>Pokédex</h1>
        </div>
    </div>

    <div class="header-buttons">
        <?php
        if(!isset($_SESSION["id_usuario"])){
//            header("Location: login.php");
//            exit;
        } elseif(isset($_SESSION["id_usuario"])){
            echo '<input type="checkbox" id="user-dropdown-toggle" class="dropdown-toggle">';
            echo '<label for="user-dropdown-toggle" class="header-user">' . $_SESSION["nombre_usuario"] . ' <i class="bi bi-person-circle"></i> <i class="bi bi-caret-down-fill"></i></label>';
            echo '<ul class="header-dropdown">
                    <li><a href="logout.php"><i class="bi bi-box-arrow-left"></i> Cerrar sesión</a></li>
                </ul>';
        } else {
            echo '<ul>
                        <li><a class="header-btn" href="registrarse.php">Registrarse</a></li>
                        <li><a class="header-btn" href="login.php">Iniciar Sesion</a></li>
                    </ul>';
        }
        ?>
    </div>
</div>