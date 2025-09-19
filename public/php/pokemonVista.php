<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/vista-pokemon.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="\PW2_Pokedex\src\img\favicon.ico">
    <title>Pokedex - Pokemon</title>
</head>
<body>
<main>

    <div class="header-arriba">
        <div class="titulo-logo-container">
            <div class="imagen-contenedor">
                <a href="home.php"><img class="logo" src="../../src/img/logo-pokebola.png" alt="logo pokebola"></a>
            </div>
            <div class="titulo-container">
                <h1>Pokédex</h1>
            </div>
        </div>

        <div class="header-buttons">
            <?php
            session_start();
            if(isset($_SESSION["id_usuario"])){
                echo '<a class="header-user" href="">' . $_SESSION["nombre_usuario"] . ' <i class="bi bi-person-circle"></i> <i class="bi bi-caret-down-fill"></i> </a>';
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
    <div class="pokemon-container">
        <?php

        include_once(__DIR__ . "/../../src/Entities/MyDatabase.php");
        $conexion = new MyDatabase();
        $conn = $conexion->getConexion();

        $id_pokemon = $_GET["id_pokemon"];

        $stmt = $conn->prepare("SELECT * FROM pokemones WHERE id_pokemon = ?");
        $stmt->bind_param("i", $id_pokemon);
        $stmt->execute();
        $result = ($stmt->get_result())->fetch_assoc();

        if ($result) {
            $tipos_pokemones_logo = ["Planta", "Agua", "Fuego"];

            echo "<div class='pokemon'>";
                echo "<img  src='../../src/img/" . $result["imagen"] . "' alt='foto pokemon'></td>";
                echo "<div class='datos-pokemon'>";
                    echo "<p class='numero-pokemon'>N°" . $result["numero"] . "</p>";
                    echo "<p class='nombre-pokemon'>" . $result["nombre"] . "</p>";
                    echo "<p class='descripcion-pokemon'>" . $result["descripcion"] . "</p>";
                    if(in_array($result["tipo"], $tipos_pokemones_logo)){
                        echo "<img width='40px' src='../../src/img-tipo/tipo-" . strtolower($result["tipo"]) . ".png' alt='foto pokemon'></td>";
                    }else{
                        echo "<p class='tipo-pokemon " . strtolower($result["tipo"]) . "'>" . $result["tipo"] . "</p>";
                    }
                echo "</div>";
            echo "</a></div>";

        } else {
            echo "El pokemon de id: ". $id_pokemon." no existe";
        }

        ?>
    </div>

    <?php
        if(isset($_SESSION["id_usuario"]) && isset($_SESSION["rol_usuario"]) && $_SESSION["rol_usuario"] == "ADMIN"){
            echo '<div style="display: flex; gap: 10px"><a class="agregar-btn" href="EditarPokemon.php?id_pokemon=' . $result["id_pokemon"] . '"><i class="bi bi-pencil"></i> Modificar Pokemon</a>';
            echo '<a class="agregar-btn" href="BorrarPokemon.php?id_pokemon=' . $result["id_pokemon"] . '"><i class="bi bi-trash"></i> Eliminar Pokemon</a></div>';
        }
    ?>
</main>
</body>
</html>