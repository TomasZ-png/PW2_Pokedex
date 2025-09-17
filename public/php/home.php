<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/homeStyles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
    <title>Pokedex - inicio</title>
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


    <h3 class="buscar">Buscar Pokemon</h3>
    <form action="pokemonBuscado.php" method="get">
        <input type="text" name="nombre" id="nombre" placeholder="nombre">
        <button type="submit">Buscar</button>
    </form>


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
    <div class="pokemones-container">
<?php

    include_once(__DIR__ . "/../../src/Entities/MyDatabase.php");
    $conexion = new MyDatabase();

    $stmt = $conexion->prepare("SELECT * FROM pokemones");
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){

        $pokemones = $result;

        $tipos_pokemones_logo = ["Planta", "Agua", "Fuego"];

        foreach ($pokemones as $pokemon){
        echo "<div class='pokemon'><a href='pokemonVista.php?id_pokemon=" . $pokemon["id_pokemon"] . "'>";
            echo "<div class='datos-pokemon'>";
            echo "<p class='numero-pokemon'>N°" . $pokemon["numero"] . "</p>";
            echo "<p class='nombre-pokemon'>" . $pokemon["nombre"] . "</p>";
            if(in_array($pokemon["tipo"], $tipos_pokemones_logo)){
                echo "<img width='40px' src='../../src/img-tipo/tipo-" . strtolower($pokemon["tipo"]) . ".png' alt='foto pokemon'></td>";

            }else{
                echo "<p class='tipo-pokemon " . strtolower($pokemon["tipo"]) . "'>" . $pokemon["tipo"] . "</p>";

            }
            echo "</div>";
            echo "<img width='150px' src='../../src/img/" . $pokemon["imagen"] . "' alt='foto pokemon'></td>";
        echo "</a></div>";
        }
    } else {
        echo "<h2>No hay pokemones para mostrar</h2>";
    }
?>
    </div>

    <?php

        if(isset($_SESSION["id_usuario"]) && isset($_SESSION["rol_usuario"]) && $_SESSION["rol_usuario"] == "ADMIN"){
          echo '<a class="agregar-btn" href="AgregarPokemon.php"><i class="bi bi-plus-circle"></i> Agregar Pokemon</a>';
        }
        
        if(isset($_SESSION["id_usuario"]) && isset($_SESSION["rol_usuario"]) && $_SESSION["rol_usuario"] == "ADMIN"){
          echo '<a class="agregar-btn" href="BorrarPokemon.php"><i class="bi bi-plus-circle"></i> Borrar Pokemon</a>';
        }

        if(isset($_SESSION["id_usuario"]) && isset($_SESSION["rol_usuario"]) && $_SESSION["rol_usuario"] == "ADMIN"){
          echo '<a class="agregar-btn" href="EditarPokemon.php"><i class="bi bi-plus-circle"></i> Editar Pokemon</a>';
        }

    ?>
</main>
</body>
</html>


