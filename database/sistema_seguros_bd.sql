-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-11-2026 a las 19:26:00
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
  `firma_aclaracion` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `correo` varchar(155) NOT NULL,
  `nombre` varchar(155) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `tipo` enum('area','carrera') NOT NULL,
  `carrera` varchar(155) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `coordinador`
--

INSERT INTO `coordinador` (`id_coordinador`, `firma_aclaracion`, `correo`, `nombre`, `telefono`, `tipo`, `carrera`) VALUES
(1, '', 'ana.perez@uncaus.edu.ar', 'Ana Pérez', '3644123456', 'carrera', 'Licenciatura en Administración');

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
(20, 12, '2026-12-13', '08:00:00', '12:00:00');

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
  `id_solicitante` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `formulario`
--

INSERT INTO `formulario` (`id_formulario`, `nom_lugar`, `dir_lugar`, `materia`, `actividad`, `carrera`, `estado`, `id_solicitante`) VALUES
(2, 'Metalurgicas del sur', 'rrivadavia 123', 'Programación I', 'uwu', 'Ingeniería en Sistemas', 'pendiente', NULL),
(5, 'hdjds', 'ldklkskl', 'Programación I', 'hshsh', 'Ingeniería en Sistemas', 'pendiente', NULL),
(6, 'eeeeeeeeede', 'ssjdjdjkd', 'Programación I', 'aaa', 'Ingeniería en Sistemas', 'pendiente', NULL),
(7, 'asa', 'sasas', 'Sistemas Operativos', 'aaaa', 'Ingeniería en Sistemas', 'pendiente', NULL),
(8, 'metal', 'plantaaa', 'Derecho Penal', 'azal', 'Abogacía', 'pendiente', NULL),
(9, 'direl', 'locked', 'Programación I', 'actividad', 'Ingeniería en Sistemas', 'pendiente', 4),
(10, 'fabrica est', 'direc fab', 'Administración General', 'acti a reali', 'Licenciatura en Administración', 'pendiente', NULL),
(11, 'Fabrica de algodon', 'ave 12', 'Auditoría', 'Paseo academico', 'Contador Público', 'pendiente', 4),
(12, 'Empresa admin', 'ea dire', 'Administración General', 'a', 'Licenciatura en Administración', 'pendiente', 4);

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
(12, '92929292');

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
(12, '92929292');

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
(6, 'lonely@gmail.com');

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
  ADD KEY `fk_formulario_solicitante1_idx` (`id_solicitante`);

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
  MODIFY `id_coordinador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `fechas_formulario`
--
ALTER TABLE `fechas_formulario`
  MODIFY `id_fecha` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `formulario`
--
ALTER TABLE `formulario`
  MODIFY `id_formulario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `operador_de_be`
--
ALTER TABLE `operador_de_be`
  MODIFY `id_operador_de_BE` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitante`
--
ALTER TABLE `solicitante`
  MODIFY `id_solicitante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
