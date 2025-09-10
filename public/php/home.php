<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pokedex - inicio</title>
</head>
<body>
<h1>Pokedex</h1>
<?php

    include_once(__DIR__ . "/../../src/Entities/MyDatabase.php");
    $conexion = new MyDatabase();

    $query = "SELECT * FROM pokemones";

    $pokemones = $conexion->query($query);

    echo "<table border='1'>";
    foreach ($pokemones as $pokemon){
        echo "<tr>";
        echo "<td>".$pokemon["id_pokemon"]."</td>";
        echo "<td>".$pokemon["numero"]."</td>";
        echo "<td>".$pokemon["nombre"]."</td>";
        echo "<td>".$pokemon["tipo"]."</td>";
        echo "<td>".$pokemon["descripcion"]."</td>";
        echo "<td><img width='100px' src='../../src/img/" . $pokemon["imagen"] . "' alt='foto pokemon'></td>";
        echo "</tr>";
    }
    echo "</table>";
?>

<a href="AgregarPokemon.php">Nuevo Pokemon</a>

</body>
</html>
