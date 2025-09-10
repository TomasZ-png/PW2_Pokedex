<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/homeStyles.css">
    <title>Pokedex - inicio</title>
</head>
<body>
<main>

<h1>Pokedex</h1>
    <div class="pokemones-container">
<?php

    include_once(__DIR__ . "/../../src/Entities/MyDatabase.php");
    $conexion = new MyDatabase();

    $query = "SELECT * FROM pokemones";

    $pokemones = $conexion->query($query);

    foreach ($pokemones as $pokemon){
    echo "<div class='pokemon'>";
        echo "<div class='datos-pokemon'>";
        echo "<p class='numero-pokemon'>N°" . $pokemon["numero"] . "</p>";
        echo "<p class='nombre-pokemon'>" . $pokemon["nombre"] . "</p>";
        echo "<p class='tipo-pokemon'>" . $pokemon["tipo"] . "</p>";
        echo "</div>";
        echo "<img width='100px' src='../../src/img/" . $pokemon["imagen"] . "' alt='foto pokemon'></td>";
    echo "</div>";
    }
?>
    </div>
</main>
<a href="AgregarPokemon.php">Nuevo Pokemon</a>

</body>
</html>
