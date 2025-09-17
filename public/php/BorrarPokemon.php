<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/agregarPokemonStyles.css">
    <title>Agregar Pokemon</title>
</head>
<body>
<a href="home.php">Volver a inicio</a>


<h1>Borrar Pokemon</h1>
    <div class="form-container">
        <form action="" method="get">
            <label for="nombreEliminar">Nombre:</label>
            <input type="text" name="nombreEliminar" id="nombreEliminar" placeholder="Nombre">
            <button type="submit">Eliminar Pokemon</button>
        </form>
    </div>
    
</body>
</html>


<?php

session_start();

        if(!isset($_SESSION["rol_usuario"]) && $_SESSION["rol_usuario"] != "ADMIN"){
            header("location: home.php");
        }

        include_once(__DIR__ . "/../../src/Entities/MyDatabase.php");
        $conexion = new MyDatabase();
        $conn = $conexion->getConexion();


 //eliminar pokemon
   if(isset($_GET["nombreEliminar"]) && !empty($_GET["nombreEliminar"])) {
    $nombreEliminar = $_GET["nombreEliminar"];

    // aca hace la query con el delete del nombre
    $stmt = $conexion->prepare("DELETE FROM pokemones WHERE nombre = '$nombreEliminar'");
    $stmt->execute();
    
    // aca chequea si fue eliminado o no
    if ($stmt->affected_rows > 0) {
        echo "<p>El Pokémon '" . htmlspecialchars($nombreEliminar) . "' fue eliminado con éxito.</p>";
    } else {

        echo "<p>Error: No se encontró un Pokémon con el nombre '" . htmlspecialchars($nombreEliminar) . "' o ya fue eliminado.</p>";
    }
}

//aca hacemos la query para mostrar la lista de kokemones y l omostramos
$stmt = $conexion->prepare("SELECT * FROM pokemones");
$stmt->execute();
$result = $stmt->get_result();
$pokemones = mysqli_fetch_all($result, MYSQLI_ASSOC);

if (empty($pokemones)) {
    echo "<p>No hay Pokémon para mostrar.</p>";
} else {
    $tipos_con_logo = ["Planta", "Agua", "Fuego"];
    
    foreach ($pokemones as $pokemon) { 
        echo "<div class='pokemon'>";
        echo "<img src='../../src/img/" . htmlspecialchars($pokemon["imagen"]) . "' alt='foto pokemon'>";
        echo "<div class='datos-pokemon'>";
        echo "<p class='numero-pokemon'>N°" . htmlspecialchars($pokemon["numero"]) . "</p>";
        echo "<p class='nombre-pokemon'>" . htmlspecialchars($pokemon["nombre"]) . "</p>";
        echo "<p class='descripcion-pokemon'>" . htmlspecialchars($pokemon["descripcion"]) . "</p>";
        
        if (in_array($pokemon["tipo"], $tipos_con_logo)) {
            echo "<img width='40px' src='../../src/img-tipo/tipo-" . strtolower($pokemon["tipo"]) . ".png' alt='foto tipo pokemon'>";
        } else {
            echo "<p class='tipo-pokemon " . strtolower($pokemon["tipo"]) . "'>" . htmlspecialchars($pokemon["tipo"]) . "</p>";
        }
        
        echo "</div>";
        echo "</div>"; 
    }
}

?>


    
