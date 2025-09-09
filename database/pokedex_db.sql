CREATE DATABASE IF NOT EXISTS pokedex_db;

use pokedex_db;

CREATE TABLE pokemones (
    id_pokemon INT AUTO_INCREMENT PRIMARY KEY,
    numero INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    tipo VARCHAR(100) NOT NULL,
    descripcion TEXT,
    imagen VARCHAR(255)
);

INSERT INTO pokemones (numero, nombre, tipo, descripcion, imagen)
VALUES (1, 'Charmander', 'Fuego', 'Prefiere lugares calientes', 'charmander.jpg');