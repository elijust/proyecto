-- phpMyAdmin SQL Dump

-- version 5.2.1

-- https://www.phpmyadmin.net/

--

-- Servidor: 127.0.0.1

-- Tiempo de generación: 29-08-2023 a las 22:42:13

-- Versión del servidor: 10.4.28-MariaDB

-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */

;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */

;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */

;

/*!40101 SET NAMES utf8mb4 */

;

--

-- Base de datos: `aplicacion`

--

-- --------------------------------------------------------

--

-- Estructura de tabla para la tabla `alumnos`

--

CREATE DATABASE aplicacion;

USE aplicacion;

CREATE TABLE
    `alumnos` (
        `id` int(255) NOT NULL,
        `nombre` varchar(255) NOT NULL,
        `apellidos` varchar(255) NOT NULL
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--

-- Volcado de datos para la tabla `alumnos`

--

INSERT INTO
    `alumnos` (`id`, `nombre`, `apellidos`)
VALUES (20, 'juan', 'valdes'), (22, 'Pedro', 'Sanchez'), (25, 'Esteban', 'Cataño'), (28, 'Elian', 'España');

-- --------------------------------------------------------

--

-- Estructura de tabla para la tabla `alumnos_cursos`

--

CREATE TABLE
    `alumnos_cursos` (
        `id` int(255) NOT NULL,
        `idalumno` int(255) NOT NULL,
        `idcurso` int(255) NOT NULL
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--

-- Volcado de datos para la tabla `alumnos_cursos`

--

INSERT INTO
    `alumnos_cursos` (`id`, `idalumno`, `idcurso`)
VALUES (13, 22, 3), (14, 22, 2), (30, 20, 5), (31, 20, 3), (32, 25, 8), (39, 28, 12);

-- --------------------------------------------------------

--

-- Estructura de tabla para la tabla `cargo`

--

CREATE TABLE
    `cargo` (
        `id` int(11) NOT NULL,
        `descripcion` varchar(255) NOT NULL
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--

-- Volcado de datos para la tabla `cargo`

--

INSERT INTO
    `cargo` (`id`, `descripcion`)
VALUES (1, 'Administrador'), (2, 'cliente'), (3, 'Aprendiz');

-- --------------------------------------------------------

--

-- Estructura de tabla para la tabla `cursos`

--

CREATE TABLE
    `cursos` (
        `id` int(255) NOT NULL,
        `nombre_curso` varchar(255) NOT NULL
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--

-- Volcado de datos para la tabla `cursos`

--

INSERT INTO
    `cursos` (`id`, `nombre_curso`)
VALUES (2, 'Felicitaciones'), (3, 'Citacion'), (5, 'plan de mejoramiento'), (8, 'Fallas acumuladas'), (10, 'hola'), (12, 'Uff papi, pa desercion'), (13, 'PLAN');

-- --------------------------------------------------------

--

-- Estructura de tabla para la tabla `mensajeria`

--

CREATE TABLE
    `mensajeria` (
        `id` int(11) NOT NULL,
        `idUsuarioEnvia` int(11) NOT NULL,
        `usuarioEnvia` text NOT NULL,
        `mensaje` text NOT NULL,
        `fecha` datetime NOT NULL,
        `idUsuarioDestino` int(11) NOT NULL,
        `usuarioDestino` text NOT NULL
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--

-- Volcado de datos para la tabla `mensajeria`

--

INSERT INTO
    `mensajeria` (
        `id`,
        `idUsuarioEnvia`,
        `usuarioEnvia`,
        `mensaje`,
        `fecha`,
        `idUsuarioDestino`,
        `usuarioDestino`
    )
VALUES (
        2,
        2,
        'Juan',
        'hola',
        '2023-08-26 20:29:42',
        1,
        'espanakmilo@gmail.com'
    ), (
        3,
        1,
        'Elian',
        'Hola',
        '2023-08-26 20:41:36',
        2,
        'ecespaa@soy.sena.edu.co'
    ), (
        4,
        2,
        'Juan',
        'Buenas tardes',
        '2023-08-26 20:47:40',
        1,
        'espanakmilo@gmail.com'
    ), (
        15,
        2,
        'Juan Esteban',
        'Hola',
        '2023-08-28 19:57:29',
        1,
        'Elian España'
    ), (
        22,
        1,
        'Elian España',
        'Hola soy yo',
        '2023-08-28 22:40:16',
        2,
        'Juan Esteban'
    );

-- --------------------------------------------------------

--

-- Estructura de tabla para la tabla `usuarios`

--

CREATE TABLE
    `usuarios` (
        `id` int(11) NOT NULL,
        `nombre` varchar(255) NOT NULL,
        `usuario` varchar(255) NOT NULL,
        `contraseña` varchar(300) NOT NULL,
        `id_cargo` int(11) NOT NULL,
        `correo` varchar(255) NOT NULL,
        `carpeta_personal` varchar(255) NOT NULL,
        `contraseña_expiracion` datetime DEFAULT NULL
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--

-- Volcado de datos para la tabla `usuarios`

--

INSERT INTO
    `usuarios` (
        `id`,
        `nombre`,
        `usuario`,
        `contraseña`,
        `id_cargo`,
        `correo`,
        `carpeta_personal`,
        `contraseña_expiracion`
    )
VALUES (
        1,
        'Elian España',
        'Elian',
        '$2y$10$ZToRqqzVEIjvOs7DFUuKg.DY/P5ADLE3NpIQ9yFvvvqYfqK.8eazK',
        1,
        'espanakmilo@gmail.com',
        'user_elian_españa',
        NULL
    ), (
        2,
        'Juan Esteban',
        'Juan',
        '$2y$10$XuS/SUNoT37MaxG3ZUCxeuskFkM9hU2G77iDFKCVMlwtGMKK5S0Vi',
        2,
        'ecespaa@soy.sena.edu.co',
        'carpeta_juan_esteban',
        NULL
    ), (
        3,
        'Andrea Suarez',
        'andrea',
        '$2y$10$ORp5zeo875fkHe1nkG/7gO5UCD5U4CoEfOutQfE3aMpwcxuv8KWbS',
        3,
        'ecespaa@misena.edu.co',
        'user_andrea_suarez',
        NULL
    ), (
        7,
        'Diego Romero',
        'Diego',
        '$2y$10$ifhi2g18vshEHJzHVN4CfOeq5x7mhFhXrB486QYgMEhzPk5yOHaBm',
        2,
        '\'\'',
        'user_diego_romero',
        NULL
    ), (
        8,
        'Johel Castro',
        'Johel',
        '$2y$10$gS2cQnI3nCyFyWoWEprywO6BO5pHKz2v27z4tBwh0j64FXBolEqta',
        1,
        '\'\'',
        'user_johel_castro',
        NULL
    ), (
        9,
        'Cristian Martinez',
        'Cristian',
        '$2y$10$SySZCE.Ta4agTf3sKz5o5uAhxsGBXwy//DMrNd.uWxUQi/MuVKFai',
        3,
        '\'\'',
        'carpeta_cristian_martinez',
        NULL
    ), (
        15,
        'Jose Roberto',
        'Jose',
        '$2y$10$TYDS17U1OZ5pQu/77yoZ9ON3Z253gxaAryKA1HishvPCTxhtRHVEi',
        3,
        '\'\'',
        'carpeta_jose_roberto',
        NULL
    ), (
        17,
        'Nicolas Cebolla',
        'Nicolas',
        '$2y$10$pN9llp.hAgkPxF3S8wm4netUeAEB/DnMve.Hpw3Mxi5sboHxQ5dQ2',
        2,
        '',
        'carpeta_nicolas_cebolla',
        NULL
    ), (
        18,
        'Miguel Almiron',
        'Miguel',
        '$2y$10$lxTAWWTYpNO.c1CLaED7XetF0tqFZ6TNJmy8zVWP88Wcc.vm4jiJu',
        3,
        '',
        'carpeta_miguel_almiron',
        NULL
    ), (
        19,
        'Alejo Miguel',
        'Alejo',
        '$2y$10$1Lv8jwye4dxA.YzP7.d1m.9lHjMBl3UIfRP1imOifDlXUFbxAU1DO',
        3,
        '',
        'carpeta_alejo_miguel',
        '2023-08-26 14:08:10'
    ), (
        20,
        'Hola Si',
        'Hola',
        '$2y$10$aaEE2EgPW69jtlJvPrHyfeLqI8S9S4r7HFTQaws4mIJ6vM9zKh02O',
        2,
        '',
        'carpeta_hola_si',
        '2023-08-26 15:38:43'
    );

--

-- Disparadores `usuarios`

--

DELIMITER $$

CREATE TRIGGER `AUTO_ASSIGN_CARGO` BEFORE INSERT ON 
`USUARIOS` FOR EACH ROW BEGIN DECLARE 
	DECLARE new_id_cargo INT;
	IF NEW.id_cargo IS NULL
	OR NEW.id_cargo = '' THEN
	SET new_id_cargo = 3;
	ELSE SET new_id_cargo = NEW.id_cargo;
	END IF;
	SET NEW.id_cargo = new_id_cargo;
	END $$ 


DELIMITER ;

DELIMITER $$

CREATE TRIGGER `FILL_CARPETA_PERSONAL` BEFORE INSERT 
ON `USUARIOS` FOR EACH ROW BEGIN SET 
	SET
	    NEW.carpeta_personal = CONCAT(
	        'carpeta_',
	        REPLACE
	(LOWER(NEW.nombre), ' ', '_')
	    );
	END $$ 


DELIMITER ;

DELIMITER $$

CREATE TRIGGER `GENERATE_TEMP_PASSWORD` BEFORE INSERT 
ON `USUARIOS` FOR EACH ROW BEGIN IF 
	IF NEW.contraseña IS NULL
	OR NEW.contraseña = '' THEN
	SET
	    NEW.contraseña = CONCAT(
	        'temp_pass_',
	        FLOOR(RAND() * 100000000)
	    );
	SET NEW.contraseña_expiracion = NOW() + INTERVAL 5 DAY;
	-- Expiración en 5 días
	END IF;
	END $$ 


DELIMITER ;

DELIMITER $$

CREATE TRIGGER `GENERATE_USERNAME` BEFORE INSERT ON 
`USUARIOS` FOR EACH ROW BEGIN SET 
	SET NEW.usuario = SUBSTRING_INDEX(NEW.nombre, ' ', 1);
	END $$ 


DELIMITER ;

--

-- Índices para tablas volcadas

--

--

-- Indices de la tabla `alumnos`

--

ALTER TABLE `alumnos` ADD PRIMARY KEY (`id`);

--

-- Indices de la tabla `alumnos_cursos`

--

ALTER TABLE `alumnos_cursos`
ADD PRIMARY KEY (`id`),
ADD
    KEY `idalumno` (`idalumno`),
ADD
    KEY `idcurso` (`idcurso`),
ADD
    KEY `idcurso_2` (`idcurso`);

--

-- Indices de la tabla `cargo`

--

ALTER TABLE `cargo` ADD PRIMARY KEY (`id`);

--

-- Indices de la tabla `cursos`

--

ALTER TABLE `cursos` ADD PRIMARY KEY (`id`);

--

-- Indices de la tabla `mensajeria`

--

ALTER TABLE `mensajeria`
ADD PRIMARY KEY (`id`),
ADD
    KEY `fk_envia_usuario` (`idUsuarioEnvia`),
ADD
    KEY `fk_destino_cargo` (`idUsuarioDestino`);

--

-- Indices de la tabla `usuarios`

--

ALTER TABLE `usuarios`
ADD PRIMARY KEY (`id`),
ADD
    KEY `id_cargo` (`id_cargo`);

--

-- AUTO_INCREMENT de las tablas volcadas

--

--

-- AUTO_INCREMENT de la tabla `alumnos`

--

ALTER TABLE
    `alumnos` MODIFY `id` int(255) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 31;

--

-- AUTO_INCREMENT de la tabla `alumnos_cursos`

--

ALTER TABLE
    `alumnos_cursos` MODIFY `id` int(255) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 43;

--

-- AUTO_INCREMENT de la tabla `cargo`

--

ALTER TABLE
    `cargo` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 4;

--

-- AUTO_INCREMENT de la tabla `cursos`

--

ALTER TABLE
    `cursos` MODIFY `id` int(255) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 14;

--

-- AUTO_INCREMENT de la tabla `mensajeria`

--

ALTER TABLE
    `mensajeria` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 23;

--

-- AUTO_INCREMENT de la tabla `usuarios`

--

ALTER TABLE
    `usuarios` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 21;

--

-- Restricciones para tablas volcadas

--

--

-- Filtros para la tabla `alumnos_cursos`

--

ALTER TABLE `alumnos_cursos`
ADD
    CONSTRAINT `alumnos_cursos_ibfk_1` FOREIGN KEY (`idalumno`) REFERENCES `alumnos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD
    CONSTRAINT `alumnos_cursos_ibfk_2` FOREIGN KEY (`idcurso`) REFERENCES `cursos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--

-- Filtros para la tabla `mensajeria`

--

ALTER TABLE `mensajeria`
ADD
    CONSTRAINT `fk_destino_cargo` FOREIGN KEY (`idUsuarioDestino`) REFERENCES `usuarios` (`id_cargo`),
ADD
    CONSTRAINT `fk_destino_usuario` FOREIGN KEY (`idUsuarioDestino`) REFERENCES `usuarios` (`id`),
ADD
    CONSTRAINT `fk_envia_usuario` FOREIGN KEY (`idUsuarioEnvia`) REFERENCES `usuarios` (`id`);

--

-- Filtros para la tabla `usuarios`

--

ALTER TABLE `usuarios`
ADD
    CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_cargo`) REFERENCES `cargo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */

;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */

;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */

;