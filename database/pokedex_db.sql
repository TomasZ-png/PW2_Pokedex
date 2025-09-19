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

INSERT INTO pokemones (numero, nombre, tipo, descripcion, imagen) VALUES
(1, 'Bulbasaur', 'Planta', 'Un Pokémon que lleva una semilla en su lomo desde el nacimiento.', 'Bulbasaur.png'),
(2, 'Ivysaur', 'Planta', 'La forma evolucionada de Bulbasaur, con una flor que empieza a crecer en su lomo.', 'Ivysaur.png'),
(4, 'Charmander', 'Fuego', 'Un Pokémon de tipo fuego con una llama en la cola.', 'Charmander.png'),
(7, 'Squirtle', 'Agua', 'Una pequeña tortuga con caparazón duro y cola rizada.', 'Squirtle.png'),
(8, 'Wartortle', 'Agua', 'La forma evolucionada de Squirtle, con orejas y cola más desarrolladas.', 'Wartortle.png'),
(10, 'Caterpie', 'Bicho', 'Una oruga pequeña y verde que evoluciona rápidamente.', 'Caterpie.png'),
(20, 'Raticate', 'Normal', 'La forma evolucionada de Rattata, más agresiva y veloz.', 'Raticate.png'),
(23, 'Ekans', 'Veneno', 'Una serpiente venenosa que se enrolla y ataca con rapidez.', 'Ekans.png'),
(25, 'Pikachu', 'Eléctrico', 'El icónico ratón eléctrico que almacena energía en sus mejillas.', 'Pikachu.png'),
(27, 'Sandshrew', 'Tierra', 'Un Pokémon pequeño y cubierto de escamas que cava madrigueras.', 'Sandshrew.png'),
(39, 'Jigglypuff', 'Hada', 'Un Pokémon redondo que canta para dormir a sus oponentes.', 'Jigglypuff.png'),
(50, 'Diglett', 'Tierra', 'Un Pokémon que vive bajo tierra y asoma solo su cabeza.', 'Diglett.png'),
(54, 'Psyduck', 'Agua', 'Siempre con dolor de cabeza, pero puede usar poderes psíquicos.', 'Psyduck.png'),
(66, 'Machop', 'Lucha', 'Un pequeño pero fuerte Pokémon de tipo lucha.', 'Machop.png'),
(81, 'Magnemite', 'Acero', 'Un Pokémon metálico que flota usando magnetismo.', 'Magnemite.png'),
(88, 'Grimer', 'Veneno', 'Un Pokémon compuesto de lodo tóxico que se expande y contamina todo a su paso.', 'Grimer.png'),
(133, 'Eevee', 'Normal', 'Un Pokémon con muchas posibles evoluciones.', 'Eevee.png'),
(143, 'Snorlax', 'Normal', 'Un Pokémon gigante que duerme la mayor parte del tiempo.', 'Snorlax.png');


CREATE TABLE usuario(
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol VARCHAR(50) NOT NULL
);

INSERT INTO usuario (nombre, correo, password, rol)
VALUES ('Admin', 'admin@test.com', '1234', 'ADMIN');