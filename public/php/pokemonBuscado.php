<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/homeStyles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="\PW2_Pokedex\src\img\favicon.ico">
    <title>Pokedex - Buscar Pokemon</title>
</head>
<body>

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
    
</body>
</html>




<?php

include_once(__DIR__ . "/../../src/Entities/MyDatabase.php");
$conexion = new MyDatabase();
$pokemones = []; // Inicializamos el array de pokemones vacío

// aca buscamos por nombre
if (isset($_GET["nombre"]) && $_GET["nombre"] != "") {
    $nombre = $_GET["nombre"];
    $stmt = $conexion->prepare("SELECT * FROM pokemones WHERE nombre = '$nombre'");
    $stmt->execute();
    $result = $stmt->get_result();
    
    // si no encuentra resultados
    if (mysqli_num_rows($result) == 0) {
        echo "<p>No se encontró el pokemon: '$nombre'. Mostrando todos los pokemones:</p>";
        $stmt = $conexion->prepare("SELECT * FROM pokemones");
        $stmt->execute();
        $result = $stmt->get_result();
    }else{
        echo "<p>Pokemon encontrado!</p>";
        $pokemones = mysqli_fetch_all($result, MYSQLI_ASSOC);

//MOSTRAMOS LOS POKEMONES
$tipos_pokemones_logo = ["Planta", "Agua", "Fuego"];

foreach ($pokemones as $pokemon) {
    
            echo "<div class='pokemon'>";
                echo "<img  src='../../src/img/" . $pokemon["imagen"] . "' alt='foto pokemon'></td>";
                echo "<div class='datos-pokemon'>";
                    echo "<p class='numero-pokemon'>N°" . $pokemon["numero"] . "</p>";
                    echo "<p class='nombre-pokemon'>" . $pokemon["nombre"] . "</p>";
                    echo "<p class='descripcion-pokemon'>" . $pokemon["descripcion"] . "</p>";
                    if(in_array($pokemon["tipo"], $tipos_pokemones_logo)){
                        echo "<img width='40px' src='../../src/img-tipo/tipo-" . strtolower($pokemon["tipo"]) . ".png' alt='foto pokemon'></td>";
                    }else{
                        echo "<p class='tipo-pokemon " . strtolower($pokemon["tipo"]) . "'>" . $pokemon["tipo"] . "</p>";
                    }
                echo "</div>";
            echo "</a></div>";
}
    }
} else {
    // la query para  mostrar todos los pokemones
    $stmt = $conexion->prepare("SELECT * FROM pokemones");
    $stmt->execute();
    $result = $stmt->get_result();
}

$pokemones = mysqli_fetch_all($result, MYSQLI_ASSOC);

//MOSTRAMOS LOS POKEMONES
$tipos_pokemones_logo = ["Planta", "Agua", "Fuego"];

foreach ($pokemones as $pokemon) {
    
            echo "<div class='pokemon'>";
                echo "<img  src='../../src/img/" . $pokemon["imagen"] . "' alt='foto pokemon'></td>";
                echo "<div class='datos-pokemon'>";
                    echo "<p class='numero-pokemon'>N°" . $pokemon["numero"] . "</p>";
                    echo "<p class='nombre-pokemon'>" . $pokemon["nombre"] . "</p>";
                    if(in_array($pokemon["tipo"], $tipos_pokemones_logo)){
                        echo "<img width='40px' src='../../src/img-tipo/tipo-" . strtolower($pokemon["tipo"]) . ".png' alt='foto pokemon'></td>";
                    }else{
                        echo "<p class='tipo-pokemon " . strtolower($pokemon["tipo"]) . "'>" . $pokemon["tipo"] . "</p>";
                    }
                echo "</div>";
            echo "</a></div>";
}
?>

