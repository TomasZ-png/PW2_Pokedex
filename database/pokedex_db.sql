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

CREATE TABLE usuario(
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol VARCHAR(50) NOT NULL
);

INSERT INTO usuario (nombre, correo, password, rol)
VALUES ('Admin', 'admin@test.com', '1234', 'ADMIN');