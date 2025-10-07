<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../css/agregarPokemonStyles.css">
    <link rel="icon" type="image/png" href="\PW2_Pokedex\src\img\favicon.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css"/>

    <title>Agregar Pokemon</title>
</head>
<body>
<div><a class="volver-btn" href="../controllers/home.php"><i class="bi bi-arrow-left-short"></i> Volver a inicio</a></div>

<main>
    <div class="form-container">
        <div class="formulario">
            <h1>Agregar Pokemon</h1>
            <div>
                <form action="AgregarPokemon.php" method="post" enctype="multipart/form-data">
                    <label for="numero-pokemon">Numero:</label>
                    <input type="number" name="numero" id="numero-pokemon" placeholder="Numero">
                    <label for="nombre-pokemon">Nombre:</label>
                    <input type="text" name="nombre" id="nombre-pokemon" placeholder="Nombre">
                    <label for="tipo-pokemon">Tipo de Pokemon:</label>
                    <select id="tipo-pokemon" name="tipo">
                        <option value="" disabled selected>-- Seleccione el tipo de Pokemon --</option>
                        <option value="Normal">Normal</option>
                        <option value="Fuego">Fuego</option>
                        <option value="Agua">Agua</option>
                        <option value="Planta">Planta</option>
                        <option value="Electrico">Eléctrico</option>
                        <option value="Hielo">Hielo</option>
                        <option value="Lucha">Lucha</option>
                        <option value="Veneno">Veneno</option>
                        <option value="Tierra">Tierra</option>
                        <option value="Volador">Volador</option>
                        <option value="Psiquico">Psíquico</option>
                        <option value="Bicho">Bicho</option>
                        <option value="Roca">Roca</option>
                        <option value="Fantasma">Fantasma</option>
                        <option value="Dragon">Dragón</option>
                        <option value="Siniestro">Siniestro</option>
                        <option value="Acero">Acero</option>
                        <option value="Hada">Hada</option>
                    </select>
                    <label for="descripcion-pokemon">Descripcion:</label>
                    <textarea name="descripcion" id="descripcion-pokemon" placeholder="Agrega una descripcion a tu Pokemon"></textarea>
                    <label for="imagen-pokemon">Imagen:</label>
                    <input type="file" name="imagen" id="imagen-pokemon" placeholder="Numero">
                    <div class="btn-form">
                        <button class="form-button" type="submit"><i class="bi bi-check2-circle"></i> Agregar Pokemon</button>
                        <a class="form-button" href="../controllers/home.php"><i class="bi bi-x-circle"></i> Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
</body>
</html>

