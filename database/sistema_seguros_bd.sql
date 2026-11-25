-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-11-2026 a las 07:01:04
-- Versión del servidor: 10.11.16-MariaDB
-- Versión de PHP: 8.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema_seguros_bd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coordinador`
--

CREATE TABLE `coordinador` (
  `id_coordinador` int(11) NOT NULL,
  `firma_aclaracion` varchar(255) DEFAULT NULL,
  `correo` varchar(155) NOT NULL,
  `contraseña` varchar(255) DEFAULT NULL,
  `nombre` varchar(155) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `tipo` enum('area','carrera') NOT NULL,
  `carrera` varchar(155) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `coordinador`
--

INSERT INTO `coordinador` (`id_coordinador`, `firma_aclaracion`, `correo`, `contraseña`, `nombre`, `telefono`, `tipo`, `carrera`) VALUES
(1, '', 'ana.perez@uncaus.edu.ar', NULL, 'Ana Pérez', '3644123456', 'carrera', 'Licenciatura en Administración'),
(2, '', 'cordi1@uncaus.edu.ar', 'cordi1', 'cordi1', '+54 9 364 400-0000', 'carrera', 'Licenciatura en Administración'),
(3, '', 'JPerez@gmail.com', 'asdasd', 'Juan Perez', '+54 9 431 1234-1231', 'carrera', 'Abogacía'),
(4, '', 'CordiSistemas@gmail.com', 'sis123', 'CordiSis', '+54 9 431 321-582', 'carrera', 'Ingeniería en Sistemas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE `estudiante` (
  `dni_estudiante` varchar(20) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `domicilio` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `estudiante`
--

INSERT INTO `estudiante` (`dni_estudiante`, `nombre`, `domicilio`) VALUES
('01010', 'Carlos', 'ave5'),
('010110', 'Pablo', 'ave 6'),
('10131013', 'Lana', 'lock termi'),
('38.921.405', 'Benítez, Facundo', '23/8/1995'),
('41.556.712', 'Fernández, Gonzalo', '19/2/1999'),
('42.384.192', 'Acosta, Mariela', '12/5/1998'),
('44.893.210', 'Giménez, Rocío', '30/6/2002'),
('45.102.394', 'Domínguez, Lucía', '4/11/2003'),
('47474747', 'Manu', 'ave 2'),
('92929292', 'Elen', 'ave 4');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fechas_formulario`
--

CREATE TABLE `fechas_formulario` (
  `id_fecha` int(11) NOT NULL,
  `id_formulario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `fechas_formulario`
--

INSERT INTO `fechas_formulario` (`id_fecha`, `id_formulario`, `fecha`, `hora_inicio`, `hora_fin`) VALUES
(1, 9, '2026-11-16', '08:00:00', '12:00:00'),
(2, 9, '2026-11-17', '08:00:00', '12:00:00'),
(3, 9, '2026-11-19', '08:00:00', '12:00:00'),
(4, 9, '2026-11-21', '08:00:00', '12:00:00'),
(5, 10, '2026-11-16', '08:00:00', '12:00:00'),
(6, 10, '2026-11-17', '08:00:00', '12:00:00'),
(7, 10, '2026-11-18', '08:00:00', '12:00:00'),
(8, 10, '2026-11-20', '08:00:00', '12:00:00'),
(9, 10, '2026-11-28', '08:00:00', '12:00:00'),
(10, 10, '2026-11-21', '08:00:00', '12:00:00'),
(11, 11, '2026-11-17', '08:00:00', '12:00:00'),
(12, 11, '2026-11-20', '02:05:00', '18:06:00'),
(13, 11, '2026-11-25', '08:00:00', '16:00:00'),
(14, 11, '2026-11-26', '08:00:00', '12:00:00'),
(15, 12, '2026-11-17', '08:00:00', '12:00:00'),
(16, 12, '2026-11-18', '08:00:00', '12:00:00'),
(17, 12, '2026-12-09', '08:00:00', '12:00:00'),
(18, 12, '2026-12-10', '08:00:00', '12:00:00'),
(19, 12, '2026-12-11', '08:00:00', '12:00:00'),
(20, 12, '2026-12-13', '08:00:00', '12:00:00'),
(21, 13, '2026-11-17', '08:00:00', '12:00:00'),
(22, 14, '2026-11-17', '08:00:00', '12:00:00'),
(23, 14, '2026-11-18', '08:00:00', '12:00:00'),
(24, 15, '2026-11-23', '08:00:00', '12:00:00'),
(25, 15, '2026-11-24', '08:00:00', '12:00:00'),
(26, 15, '2026-11-25', '08:00:00', '12:00:00'),
(27, 16, '2026-11-24', '08:00:00', '12:00:00'),
(28, 16, '2026-11-26', '08:00:00', '12:00:00'),
(29, 17, '2026-11-30', '08:00:00', '11:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formulario`
--

CREATE TABLE `formulario` (
  `id_formulario` int(11) NOT NULL,
  `nom_lugar` varchar(155) NOT NULL,
  `dir_lugar` varchar(155) NOT NULL,
  `materia` varchar(65) DEFAULT NULL,
  `actividad` varchar(255) NOT NULL,
  `carrera` varchar(65) DEFAULT NULL,
  `estado` enum('pendiente','avalado/listo','enviado') NOT NULL DEFAULT 'pendiente',
  `id_solicitante` int(11) DEFAULT NULL,
  `id_coordinador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `formulario`
--

INSERT INTO `formulario` (`id_formulario`, `nom_lugar`, `dir_lugar`, `materia`, `actividad`, `carrera`, `estado`, `id_solicitante`, `id_coordinador`) VALUES
(2, 'Metalurgicas del sur', 'rrivadavia 123', 'Programación I', 'uwu', 'Ingeniería en Sistemas', 'pendiente', NULL, NULL),
(5, 'hdjds', 'ldklkskl', 'Programación I', 'hshsh', 'Ingeniería en Sistemas', 'pendiente', NULL, NULL),
(6, 'eeeeeeeeede', 'ssjdjdjkd', 'Programación I', 'aaa', 'Ingeniería en Sistemas', 'pendiente', NULL, NULL),
(7, 'asa', 'sasas', 'Sistemas Operativos', 'aaaa', 'Ingeniería en Sistemas', 'pendiente', NULL, NULL),
(8, 'metal', 'plantaaa', 'Derecho Penal', 'azal', 'Abogacía', 'pendiente', NULL, NULL),
(9, 'direl', 'locked', 'Programación I', 'actividad', 'Ingeniería en Sistemas', 'pendiente', 4, NULL),
(10, 'fabrica est', 'direc fab', 'Administración General', 'acti a reali', 'Licenciatura en Administración', 'pendiente', NULL, NULL),
(11, 'Fabrica de algodon', 'ave 12', 'Auditoría', 'Paseo academico', 'Contador Público', 'enviado', 4, NULL),
(12, 'Empresa admin', 'ea dire', 'Administración General', 'a', 'Licenciatura en Administración', 'pendiente', 4, NULL),
(13, 'qweqwe', 'qweqweqw', 'Programación II', 'opiopiopi', 'Ingeniería en Sistemas', 'enviado', 7, NULL),
(14, 'qweqwe', 'qweqweqw', 'Programación I', 'asdasdasd', 'Ingeniería en Sistemas', 'enviado', 7, NULL),
(15, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'sssssssssssssssssssssssssssssssssss', 'Derecho Penal', 'cvbbsbdfb', 'Abogacía', 'enviado', 8, NULL),
(16, 'Oficina de marketing de la municipalidad', 'Sarmiento 551', 'Marketing', 'Salida tecnica', 'Licenciatura en Administración', 'enviado', 8, NULL),
(17, 'Camara de comercio de la provincia', 'Contitución 2143', 'Derecho Constitucional', 'Visita guiada a camara de comercio', 'Abogacía', 'pendiente', 8, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nomina_estudiantes`
--

CREATE TABLE `nomina_estudiantes` (
  `id_formulario` int(11) NOT NULL,
  `dni_estudiante` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `nomina_estudiantes`
--

INSERT INTO `nomina_estudiantes` (`id_formulario`, `dni_estudiante`) VALUES
(12, '010110'),
(12, '47474747'),
(12, '92929292'),
(13, '38.921.405'),
(13, '41.556.712'),
(13, '42.384.192'),
(13, '44.893.210'),
(13, '45.102.394'),
(14, '38.921.405'),
(14, '41.556.712'),
(14, '42.384.192'),
(14, '44.893.210'),
(14, '45.102.394'),
(15, '38.921.405'),
(15, '41.556.712'),
(15, '42.384.192'),
(15, '44.893.210'),
(15, '45.102.394'),
(16, '38.921.405'),
(16, '41.556.712'),
(16, '42.384.192'),
(16, '44.893.210'),
(16, '45.102.394'),
(17, '38.921.405'),
(17, '41.556.712'),
(17, '42.384.192'),
(17, '44.893.210'),
(17, '45.102.394');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nomina_profesores`
--

CREATE TABLE `nomina_profesores` (
  `id_formulario` int(11) NOT NULL,
  `dni_profesor` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `nomina_profesores`
--

INSERT INTO `nomina_profesores` (`id_formulario`, `dni_profesor`) VALUES
(12, '01010'),
(12, '47474747'),
(12, '92929292'),
(13, '39.448.227'),
(14, '39.448.227'),
(15, '39.448.227'),
(16, '39.448.227'),
(17, '39.448.227');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operador_de_be`
--

CREATE TABLE `operador_de_be` (
  `id_operador_de_BE` int(11) NOT NULL,
  `contraseña` varchar(255) DEFAULT NULL,
  `nombre` varchar(155) DEFAULT NULL,
  `correo` varchar(155) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `operador_de_be`
--

INSERT INTO `operador_de_be` (`id_operador_de_BE`, `contraseña`, `nombre`, `correo`) VALUES
(1, 'op123', 'op1', 'op1@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor`
--

CREATE TABLE `profesor` (
  `dni_profesor` varchar(20) NOT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  `domicilio` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `profesor`
--

INSERT INTO `profesor` (`dni_profesor`, `nombre`, `domicilio`) VALUES
('01010', 'Carlos', 'ave5'),
('010110', 'Pablo', 'ave 6'),
('39.448.227', 'Sosa, Matías', '8/7/1994'),
('47474747', 'Manu', 'ave 2'),
('73736363', 'Fabricio', 'ave 2'),
('900990', 'Oscar', 'ave 6'),
('92929292', 'Elen', 'ave 4');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitante`
--

CREATE TABLE `solicitante` (
  `id_solicitante` int(11) NOT NULL,
  `correo_solicitante` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `solicitante`
--

INSERT INTO `solicitante` (`id_solicitante`, `correo_solicitante`) VALUES
(2, NULL),
(3, 'lonely@example.com'),
(4, 'corre@gmail.com'),
(5, 'lanita@gmail.com'),
(6, 'lonely@gmail.com'),
(7, 'asdasdasd@gmail.com'),
(8, 'SMatias@gmail.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `coordinador`
--
ALTER TABLE `coordinador`
  ADD PRIMARY KEY (`id_coordinador`);

--
-- Indices de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`dni_estudiante`);

--
-- Indices de la tabla `fechas_formulario`
--
ALTER TABLE `fechas_formulario`
  ADD PRIMARY KEY (`id_fecha`),
  ADD KEY `fk_fechas_formulario_formulario1_idx` (`id_formulario`);

--
-- Indices de la tabla `formulario`
--
ALTER TABLE `formulario`
  ADD PRIMARY KEY (`id_formulario`),
  ADD KEY `fk_formulario_solicitante1_idx` (`id_solicitante`),
  ADD KEY `fk_formulario_coordinador_idx` (`id_coordinador`);

--
-- Indices de la tabla `nomina_estudiantes`
--
ALTER TABLE `nomina_estudiantes`
  ADD PRIMARY KEY (`id_formulario`,`dni_estudiante`),
  ADD UNIQUE KEY `nomina_estudiantes_unique` (`id_formulario`,`dni_estudiante`),
  ADD KEY `fk_formulario_has_estudiante_estudiante1_idx` (`dni_estudiante`),
  ADD KEY `fk_formulario_has_estudiante_formulario1_idx` (`id_formulario`);

--
-- Indices de la tabla `nomina_profesores`
--
ALTER TABLE `nomina_profesores`
  ADD PRIMARY KEY (`id_formulario`,`dni_profesor`),
  ADD UNIQUE KEY `nomina_profesores_unique` (`id_formulario`,`dni_profesor`),
  ADD KEY `fk_formulario_has_profesor_profesor1_idx` (`dni_profesor`),
  ADD KEY `fk_formulario_has_profesor_formulario1_idx` (`id_formulario`);

--
-- Indices de la tabla `operador_de_be`
--
ALTER TABLE `operador_de_be`
  ADD PRIMARY KEY (`id_operador_de_BE`);

--
-- Indices de la tabla `profesor`
--
ALTER TABLE `profesor`
  ADD PRIMARY KEY (`dni_profesor`);

--
-- Indices de la tabla `solicitante`
--
ALTER TABLE `solicitante`
  ADD PRIMARY KEY (`id_solicitante`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `coordinador`
--
ALTER TABLE `coordinador`
  MODIFY `id_coordinador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `fechas_formulario`
--
ALTER TABLE `fechas_formulario`
  MODIFY `id_fecha` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `formulario`
--
ALTER TABLE `formulario`
  MODIFY `id_formulario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `operador_de_be`
--
ALTER TABLE `operador_de_be`
  MODIFY `id_operador_de_BE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `solicitante`
--
ALTER TABLE `solicitante`
  MODIFY `id_solicitante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `fechas_formulario`
--
ALTER TABLE `fechas_formulario`
  ADD CONSTRAINT `fk_fechas_formulario_formulario1` FOREIGN KEY (`id_formulario`) REFERENCES `formulario` (`id_formulario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `formulario`
--
ALTER TABLE `formulario`
  ADD CONSTRAINT `fk_formulario_coordinador` FOREIGN KEY (`id_coordinador`) REFERENCES `coordinador` (`id_coordinador`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_formulario_solicitante1` FOREIGN KEY (`id_solicitante`) REFERENCES `solicitante` (`id_solicitante`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `nomina_estudiantes`
--
ALTER TABLE `nomina_estudiantes`
  ADD CONSTRAINT `fk_formulario_has_estudiante_estudiante1` FOREIGN KEY (`dni_estudiante`) REFERENCES `estudiante` (`dni_estudiante`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_formulario_has_estudiante_formulario1` FOREIGN KEY (`id_formulario`) REFERENCES `formulario` (`id_formulario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `nomina_profesores`
--
ALTER TABLE `nomina_profesores`
  ADD CONSTRAINT `fk_formulario_has_profesor_formulario1` FOREIGN KEY (`id_formulario`) REFERENCES `formulario` (`id_formulario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_formulario_has_profesor_profesor1` FOREIGN KEY (`dni_profesor`) REFERENCES `profesor` (`dni_profesor`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
