 <?php

 if(isset($_SESSION["id_usuario"]) && isset($_SESSION["rol_usuario"]) && $_SESSION["rol_usuario"] == "ADMIN"){
            echo '<div class="admin-btn-container">';
            echo '<a class="agregar-btn" href="index.php?request=agregar-pokemon"><i class="bi bi-plus-circle"></i> Agregar Pokemon</a>';
            echo '</div>';
        }

        include_once('../vistas/partials/header.php');
        include_once('../vistas/HomeVista.php');

    $stmt = $conexion->prepare("SELECT * FROM pokemones");
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){

        $pokemones = $result;

        $tipos_pokemones_logo = ["Planta", "Agua", "Fuego"];
        echo ' <div class="pokemones-container">';
        foreach ($pokemones as $pokemon){
        echo "<div class='pokemon'>";
            echo "<a href='index.php?request=vista-pokemon&id_pokemon={$pokemon["id_pokemon"]}'>";

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
                echo "<a class='admin-btn editar' href='index.php?request=editar-pokemon&id_pokemon=" . $pokemon["id_pokemon"] . "'><i class='bi bi-pencil-square'></i> Editar</a>";
                echo "<a class='borrar-btn admin-btn' href='index.php?request=eliminar-pokemon&?id_pokemon=" . $pokemon["id_pokemon"] . "'><i class='bi bi-trash'></i> Borrar</a>";
                echo "</div>";
            }
        echo "</div>";
        }
    } else {
        echo "<h2>No hay pokemones para mostrar</h2>";
    }