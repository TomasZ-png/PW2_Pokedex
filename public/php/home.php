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
    <div class="imagen-contenedor">
        <a href="home.php"><img class="logo" src="../../src/img/logo-pokebola.png" alt="logo pokebola"></a>
    </div>
    <div class="titulo-container">
        <h1>Pokédex</h1>
    </div>
</div>
    <div class="pokemones-container">
<?php

    include_once(__DIR__ . "/../../src/Entities/MyDatabase.php");
    $conexion = new MyDatabase();

    $stmt = $conexion->prepare("SELECT * FROM pokemones");
    $stmt->execute();
    $result = $stmt->get_result();

    $query = "SELECT * FROM pokemones";

    if($result->num_rows > 0){

        $pokemones = $result;

        $tipos_pokemones_logo = ["Planta", "Agua", "Fuego"];

        foreach ($pokemones as $pokemon){
        echo "<div class='pokemon'>";
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
        echo "</div>";
        }
    } else {
        echo "<h2>No hay pokemones para mostrar</h2>";
    }
?>


    </div>
        <a class="agregar-btn" href="AgregarPokemon.php"><i class="bi bi-plus-circle"></i> Agregar Pokemon</a>
</main>


<!--<header class="header">-->
<!--    <div class="agregar-boton">-->
<!--        <a class="nuevo-pokemon-button circle" href="AgregarPokemon.php">-->
<!--            <i class="bi bi-plus-circle"></i>-->
<!--        </a>-->
<!--        <span>Agregar Pokemon</span>-->
<!--    </div>-->
<!--</header>-->

</body>
</html>
