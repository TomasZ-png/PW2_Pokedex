<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="\PW2_Pokedex\src\img\favicon.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css"/>
    <link rel="stylesheet" href="../../css/loggin-style.css">
    <title>Iniciar Sesion</title>
</head>
<body>
<div class="header-arriba">
    <div class="titulo-logo-container">
        <div>
            <a href="../controllers/home.php"><img class="logo" src="../../../src/img/logo-pokebola.png" alt="logo pokebola"></a>
        </div>
        <div class="titulo-container">
            <h1>Pokédex</h1>
        </div>
    </div>
</div>
<main>
    <div class="contenedor-principal">
        <h1>Bienvenido de nuevo!</h1>
        <form action="login.php" method="post" enctype="multipart/form-data">
            <label for="correo">Correo:</label>
            <input id="correo" type="text" name="correo" placeholder="Correo">
            <label for="contrasenia">Contraseña:</label>
            <input id="contrasenia" type="password" name="password" placeholder="Contraseña">
            <button type="submit">Iniciar Sesion</button>
            <button><a class="registrarse-btn" href="registrarse.php">Registrarse</a></button>
        </form>
    </div>
    </div>
</main>
</body>
</html>