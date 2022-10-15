-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-10-2022 a las 23:20:58
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `infobdn`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `nombre_Usuario` varchar(20) NOT NULL,
  `passwd` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`nombre_Usuario`, `passwd`) VALUES
('admin', '0cc175b9c0f1b6a831c399e269772661');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `DNI` varchar(9) NOT NULL,
  `email` varchar(20) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellidos` varchar(20) NOT NULL,
  `edad` int(2) NOT NULL,
  `fotografia` varchar(50) NOT NULL,
  `passwd` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`DNI`, `email`, `nombre`, `apellidos`, `edad`, `fotografia`, `passwd`) VALUES
('11111111M', 'salma@', 'Salma', 'Alami', 19, 'img/alumna.jpeg', '03c7c0ace395d80182db07ae2c30f034'),
('22222222X', 'jordi@', 'Jordi', 'Lopez', 24, 'img/alumno.jpeg', '363b122c528f54df4a0446b6bab05515');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `codigo` int(10) NOT NULL,
  `nombreC` varchar(20) NOT NULL,
  `descripcion` text NOT NULL,
  `horas` int(6) NOT NULL,
  `fechaInicio` date NOT NULL,
  `fechaFinal` date NOT NULL,
  `profesor` varchar(9) DEFAULT NULL,
  `Estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`codigo`, `nombreC`, `descripcion`, `horas`, `fechaInicio`, `fechaFinal`, `profesor`, `Estado`) VALUES
(76, 'Daw', 'Desarrolo applicaciones web', 2000, '2022-10-21', '2022-10-28', '14785236V', 1),
(77, 'Programacion', 'Java-Python', 400, '2022-10-07', '2022-10-14', '12345678W', 1),
(78, 'HTML', 'Bases de HTML', 90, '2022-10-05', '2022-10-13', '14785236V', 1),
(79, 'Bases de datos', 'Mysql-Oracle', 100, '2022-10-01', '2022-10-14', '12345678W', 1),
(80, 'Imagen y sonido', 'Photoshop', 200, '2022-09-26', '2022-10-08', '12345678W', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matricula`
--

CREATE TABLE `matricula` (
  `email_alumno` varchar(20) NOT NULL,
  `codigo_curso` int(11) NOT NULL,
  `nota` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `matricula`
--

INSERT INTO `matricula` (`email_alumno`, `codigo_curso`, `nota`) VALUES
('jordi@', 76, NULL),
('jordi@', 77, 0),
('salma@', 76, NULL),
('salma@', 77, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

CREATE TABLE `profesores` (
  `DNI` varchar(9) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellidos` varchar(20) NOT NULL,
  `titulo_academico` varchar(20) NOT NULL,
  `fotografia` varchar(400) NOT NULL,
  `passwd` varchar(50) NOT NULL,
  `NombreUsu` varchar(20) NOT NULL,
  `estadop` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`DNI`, `nombre`, `apellidos`, `titulo_academico`, `fotografia`, `passwd`, `NombreUsu`, `estadop`) VALUES
('12345678W', 'Olga', 'Domen', 'programadora', 'img/descarga (1).png', 'd95679752134a2d9eb61dbd7b91c4bcc', 'OlgaD', 1),
('14785236V', 'Oriol', 'Puig', 'analista', 'img/profesor.png', 'd95679752134a2d9eb61dbd7b91c4bcc', 'OriolP', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`nombre_Usuario`);

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`DNI`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `DNI` (`DNI`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`codigo`),
  ADD UNIQUE KEY `nombre` (`nombreC`),
  ADD KEY `cursos_ibfk_1` (`profesor`);

--
-- Indices de la tabla `matricula`
--
ALTER TABLE `matricula`
  ADD KEY `codigo_curso` (`codigo_curso`),
  ADD KEY `email_alumno` (`email_alumno`);

--
-- Indices de la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD PRIMARY KEY (`DNI`),
  ADD UNIQUE KEY `DNI` (`DNI`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `codigo` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD CONSTRAINT `cursos_ibfk_1` FOREIGN KEY (`profesor`) REFERENCES `profesores` (`DNI`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `matricula`
--
ALTER TABLE `matricula`
  ADD CONSTRAINT `matricula_ibfk_1` FOREIGN KEY (`codigo_curso`) REFERENCES `cursos` (`codigo`),
  ADD CONSTRAINT `matricula_ibfk_2` FOREIGN KEY (`email_alumno`) REFERENCES `alumnos` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
