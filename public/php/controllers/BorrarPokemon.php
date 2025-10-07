<?php
    include_once('../vistas/BorrarPokemonVista.php');
    if(!isset($_SESSION["rol_usuario"]) && $_SESSION["rol_usuario"] != "ADMIN"){
        header("location: home.php");
    }

    if(isset($_GET["id_pokemon"])){
        $id_pokemon = $_GET["id_pokemon"];
    } else{
        $id_pokemon = "";
    }

    global $conn;

    $stmtBuscar = $conn->prepare("SELECT nombre FROM pokemones WHERE id_pokemon = ?");
    $stmtBuscar->bind_param("i", $id_pokemon);
    $stmtBuscar->execute();
    $resultado = ($stmtBuscar->get_result())->fetch_assoc();

    if($resultado){
        $nombrePokemon = $resultado["nombre"];
    }

    if (empty($resultado)){
        $nombrePokemon = "";
    }

    echo '<div class="form-container">
        <div class="formulario">

    <h1>Borrar Pokemon</h1>
        <form action="" method="get">
            <label for="nombreEliminar">Nombre:</label>
            <input type="text" name="nombreEliminar" id="nombreEliminar" placeholder="Nombre" value="' . $nombrePokemon . '">
            <div class="btn-form">
                <button class="form-button" type="submit"><i class="bi bi-check2-circle"></i> Eliminar Pokemon</button>
                <a class="form-button" href="index.php?request=home"><i class="bi bi-x-circle"></i> Cancelar</a>
            </div>
        </form>
    </div>
        </div>

<div class="pokemones-container">';


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
        echo "<a href='index.php?request=vista-pokemon&id_pokemon=" . $pokemon["id_pokemon"] . "'>";
        echo "<div class='datos-pokemon'>";
        echo "<p class='numero-pokemon'>N°" . $pokemon["numero"] . "</p>";
        echo "<p class='nombre-pokemon'>" . $pokemon["nombre"] . "</p>";
        if(in_array($pokemon["tipo"], $tipos_con_logo)){
            echo "<img width='40px' src='../../src/img-tipo/tipo-" . strtolower($pokemon["tipo"]) . ".png' alt='foto pokemon'>";

        }else{
            echo "<p class='tipo-pokemon " . strtolower($pokemon["tipo"]) . "'>" . $pokemon["tipo"] . "</p>";

        }
        echo "</div>";
        echo "<img width='150px' height='150px' src='../../src/img/" . $pokemon["imagen"] . "' alt='foto pokemon'>";
        echo "</a>";
        if(isset($_SESSION['id_usuario']) && isset($_SESSION['rol_usuario']) && $_SESSION['rol_usuario'] == 'ADMIN'){
            echo "<div class='acciones-admin'>";
            echo "<a class='admin-btn editar' href='index.php?request=editar-pokemon&id_pokemon=" . $pokemon["id_pokemon"] . "'><i class='bi bi-pencil-square'></i> Editar</a>";
            echo "<a class='borrar-btn admin-btn' href='index.php?request=eliminar-pokemon&id_pokemon=" . $pokemon["id_pokemon"] . "'><i class='bi bi-trash'></i> Borrar</a>";
            echo "</div>";
        }
        echo "</div>";
    }
}
