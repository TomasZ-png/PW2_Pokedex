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

<!--    <h3 class="buscar">Buscar Pokemon</h3>-->
<!--    <form action="pokemonBuscado.php" method="get">-->
<!--        <input type="text" name="nombre" id="nombre" placeholder="nombre">-->
<!--        <button type="submit">Buscar</button>-->
<!--    </form>-->


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

    <form class="buscar" action="pokemonBuscado.php" method="get">
        <input type="text" name="nombre" id="nombre" placeholder="Ingrese el nombre, tipo o número de pokemon">
        <button type="submit" class="btn-buscar">Buscar</button>
    </form>


 <?php

include_once(__DIR__ . "/../../src/Entities/MyDatabase.php");
$conexion = new MyDatabase();
$pokemones = []; // Inicializamos el array de pokemones vacío

// aca buscamos por nombre
if (isset($_GET["nombre"]) && $_GET["nombre"] != "") {
    $nombre = trim($_GET["nombre"]);
    $stmt = $conexion->prepare("SELECT * FROM pokemones WHERE nombre LIKE '$nombre%' 
                                        OR numero LIKE '$nombre%' OR tipo LIKE '$nombre%'");
    $stmt->execute();
    $result = $stmt->get_result();

    // si no encuentra resultados
    if (mysqli_num_rows($result) == 0) {
        echo "<div class='mensaje'><p><i class='bi bi-x-circle'></i> No se encontró el pokemon: <strong>'$nombre'</strong>. Mostrando todos los pokemones:</p></div>";
        echo '<div class="pokemones-container">';
        $stmt = $conexion->prepare("SELECT * FROM pokemones");
        $stmt->execute();
        $result = $stmt->get_result();
    }else{
        echo "<div class='mensaje'><p>Resultados encontrados de <strong>'$nombre'</strong>:</p></div>";
        echo '<div class="pokemones-container">';
        $pokemones = mysqli_fetch_all($result, MYSQLI_ASSOC);

        //MOSTRAMOS LOS POKEMONES
        $tipos_pokemones_logo = ["Planta", "Agua", "Fuego"];

        foreach ($pokemones as $pokemon) {
            echo "<div class='pokemon'>";
            echo "<a href='pokemonVista.php?id_pokemon=" . $pokemon["id_pokemon"] . "'>";
            echo "<div class='datos-pokemon'>";
            echo "<p class='numero-pokemon'>N°" . $pokemon["numero"] . "</p>";
            echo "<p class='nombre-pokemon'>" . $pokemon["nombre"] . "</p>";
            if(in_array($pokemon["tipo"], $tipos_pokemones_logo)){
                echo "<img width='40px' src='../../src/img-tipo/tipo-" . strtolower($pokemon["tipo"]) . ".png' alt='foto pokemon'>";

            }else{
                echo "<p class='tipo-pokemon " . strtolower($pokemon["tipo"]) . "'>" . $pokemon["tipo"] . "</p>";

            }
            echo "</div>";
            echo "<img width='150px' height='150px' src='../../src/img/" . $pokemon["imagen"] . "' alt='foto pokemon'>";
            echo "</a>";
            if(isset($_SESSION['id_usuario']) && isset($_SESSION['rol_usuario']) && $_SESSION['rol_usuario'] == 'ADMIN'){
                echo "<div class='acciones-admin'>";
                echo "<a class='admin-btn editar' href='EditarPokemon.php?id_pokemon=" . $pokemon["id_pokemon"] . "'><i class='bi bi-pencil-square'></i> Editar</a>";

                echo "</div>";
            }
            echo "</div>";
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
    echo "<a href='pokemonVista.php?id_pokemon=" . $pokemon["id_pokemon"] . "'>";
    echo "<div class='datos-pokemon'>";
    echo "<p class='numero-pokemon'>N°" . $pokemon["numero"] . "</p>";
    echo "<p class='nombre-pokemon'>" . $pokemon["nombre"] . "</p>";
    if(in_array($pokemon["tipo"], $tipos_pokemones_logo)){
        echo "<img width='40px' src='../../src/img-tipo/tipo-" . strtolower($pokemon["tipo"]) . ".png' alt='foto pokemon'>";

    }else{
        echo "<p class='tipo-pokemon " . strtolower($pokemon["tipo"]) . "'>" . $pokemon["tipo"] . "</p>";

    }
    echo "</div>";
    echo "<img width='150px' height='150px' src='../../src/img/" . $pokemon["imagen"] . "' alt='foto pokemon'>";
    echo "</a>";
    if(isset($_SESSION['id_usuario']) && isset($_SESSION['rol_usuario']) && $_SESSION['rol_usuario'] == 'ADMIN'){
        echo "<div class='acciones-admin'>";
        echo "<a class='admin-btn editar' href='EditarPokemon.php?id_pokemon=" . $pokemon["id_pokemon"] . "'><i class='bi bi-pencil-square'></i> Editar</a>";

        echo "</div>";
    }
    echo "</div>";

}
?>

</main>
</body>
</html>

