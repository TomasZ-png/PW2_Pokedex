

<?php

    include_once(__DIR__ . "/../../src/Entities/MyDatabase.php");
    $config = parse_ini_file(__DIR__ . "/../../config/config.ini");

    $conexion = new MyDatabase(
        $config["server"],
        $config["user"],
        $config["pass"],
        $config["database"]
    );

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
        echo "<td>".$pokemon["imagen"]."</td>";
        echo "</tr>";
    }
    echo "</table>";
?>