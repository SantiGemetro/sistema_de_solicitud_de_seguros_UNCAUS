-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-11-2026 a las 01:59:18
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `seguros_bd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coordinador`
--

CREATE TABLE `coordinador` (
  `id_coordinador` int(11) NOT NULL,
  `firma_aclaracion` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `correo` varchar(155) NOT NULL,
  `nombre` varchar(155) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `tipo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE `estudiante` (
  `dni_estudiante` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `domicilio` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fechas_formulario`
--

CREATE TABLE `fechas_formulario` (
  `id_fecha` int(11) NOT NULL,
  `id_formulario` int(11) NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
  `id_solicitante` int(11) DEFAULT NULL,
  `id_operador_confirma` int(11) DEFAULT NULL,
  `estado` varchar(30) NOT NULL DEFAULT 'PENDIENTE_AVAL'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `formulario`
--

INSERT INTO `formulario` (`id_formulario`, `nom_lugar`, `dir_lugar`, `materia`, `actividad`, `carrera`, `id_solicitante`, `id_operador_confirma`, `estado`) VALUES
(1, 'uncaus', 'avenida al corta', 'Sistemas Operativos', 'asdasdasdasd', 'Ingeniería en Sistemas', NULL, NULL, 'ACEPTADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nomina_estudiantes`
--

CREATE TABLE `nomina_estudiantes` (
  `id_formulario` int(11) NOT NULL,
  `dni_estudiante` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nomina_profesores`
--

CREATE TABLE `nomina_profesores` (
  `id_formulario` int(11) NOT NULL,
  `dni_profesor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operador_de_be`
--

CREATE TABLE `operador_de_be` (
  `id_operador_de_BE` int(11) NOT NULL,
  `contraseña` varchar(255) DEFAULT NULL,
  `nombre` varchar(155) DEFAULT NULL,
  `correo` varchar(155) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor`
--

CREATE TABLE `profesor` (
  `dni_profesor` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `domicilio` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitante`
--

CREATE TABLE `solicitante` (
  `id_solicitante` int(11) NOT NULL,
  `correo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
  ADD KEY `fk_formulario_operador_de_BE1_idx` (`id_operador_confirma`);

--
-- Indices de la tabla `nomina_estudiantes`
--
ALTER TABLE `nomina_estudiantes`
  ADD PRIMARY KEY (`id_formulario`,`dni_estudiante`),
  ADD KEY `fk_formulario_has_estudiante_estudiante1_idx` (`dni_estudiante`),
  ADD KEY `fk_formulario_has_estudiante_formulario1_idx` (`id_formulario`);

--
-- Indices de la tabla `nomina_profesores`
--
ALTER TABLE `nomina_profesores`
  ADD PRIMARY KEY (`id_formulario`,`dni_profesor`),
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
  MODIFY `id_coordinador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fechas_formulario`
--
ALTER TABLE `fechas_formulario`
  MODIFY `id_fecha` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `formulario`
--
ALTER TABLE `formulario`
  MODIFY `id_formulario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `operador_de_be`
--
ALTER TABLE `operador_de_be`
  MODIFY `id_operador_de_BE` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitante`
--
ALTER TABLE `solicitante`
  MODIFY `id_solicitante` int(11) NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `fk_formulario_operador_de_BE1` FOREIGN KEY (`id_operador_confirma`) REFERENCES `operador_de_be` (`id_operador_de_BE`) ON DELETE NO ACTION ON UPDATE NO ACTION,
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
