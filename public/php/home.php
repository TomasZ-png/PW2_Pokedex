<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/homeStyles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css"/>
    <title>Pokedex - inicio</title>
</head>
<body>
<main>

<h1>Pokedex</h1>
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
    } else {
        echo "<h2>No hay pokemones para mostrar</h2>";
    }
?>
    </div>
</main>


<header class="header">
    <ul>
        <li class="agregar"><a class="nuevo-pokemon-button" href="AgregarPokemon.php"><i class="bi bi-plus-circle"></i>Agregar Pokemon</a></li>
    </ul>
</header>

</body>
</html>
