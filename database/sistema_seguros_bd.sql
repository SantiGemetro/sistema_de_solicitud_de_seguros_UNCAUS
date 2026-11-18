-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-11-2026 a las 13:21:34
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
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrera`
--

CREATE TABLE `carrera` (
  `id_carrera` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `carrera` varchar(155) DEFAULT NULL,
  `contraseña` varchar(155) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `coordinador`
--

INSERT INTO `coordinador` (`id_coordinador`, `firma_aclaracion`, `correo`, `nombre`, `telefono`, `tipo`, `carrera`, `contraseña`) VALUES
(1, '', 'ana.perez@uncaus.edu.ar', 'Ana Pérez', '3644123456', 'carrera', 'Licenciatura en Administración', ''),
(2, '', 'cordi1@uncaus.edu.ar', 'cordi1', '+54 9 364 400-0000', 'carrera', 'Licenciatura en Administración', 'cordi1'),
(3, 'cosito de asi.png', 'paty@gmail.com', 'Patricia', '+54 9 364 499-2116', 'carrera', 'Ingeniería en Sistemas', '54321'),
(4, 'cosito de asi.png', 'josue@gmail.com', 'Josue', '+54 9 364 455-5555', 'area', 'Deportes', '123');

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
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(21, 13, '2026-11-19', '08:00:00', '11:00:00'),
(22, 14, '2026-11-26', '08:00:00', '12:00:00'),
(23, 14, '2026-11-27', '08:00:00', '12:00:00'),
(24, 15, '2026-11-25', '08:00:00', '12:00:00'),
(25, 15, '2026-11-26', '08:00:00', '12:00:00'),
(26, 16, '2026-11-26', '08:00:00', '12:00:00'),
(27, 16, '2026-11-27', '08:00:00', '12:00:00'),
(28, 16, '2026-11-28', '08:00:00', '12:00:00'),
(29, 17, '2026-12-16', '08:00:00', '12:00:00'),
(30, 17, '2026-12-18', '08:00:00', '12:00:00'),
(31, 17, '2026-12-23', '08:00:00', '12:00:00');

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
(9, 'direl', 'locked', 'Programación I', 'actividad', 'Ingeniería en Sistemas', 'avalado/listo', 4),
(10, 'fabrica est', 'direc fab', 'Administración General', 'acti a reali', 'Licenciatura en Administración', 'pendiente', NULL),
(11, 'Fabrica de algodon', 'ave 12', 'Auditoría', 'Paseo academico', 'Contador Público', 'pendiente', 4),
(12, 'Empresa admin', 'ea dire', 'Administración General', 'a', 'Licenciatura en Administración', 'pendiente', 4),
(13, 'Info Avances', 'calle sarmiento 7', 'Ingeniería de Software', 'Visita a una empresa de software', 'Ingeniería en Sistemas', 'avalado/listo', 2),
(14, 'DayTime', 'avella 3', 'Sistemas Operativos', 'jsfjksjf', 'Ingeniería en Sistemas', 'avalado/listo', 2),
(15, 'jkdnbann', 'jehbd ak', 'Economía', 'hashahhj', 'Licenciatura en Administración', 'pendiente', 2),
(16, 'kdncnojascka', 'pomdapnskc', 'Marketing', 'jkdscna', 'Licenciatura en Administración', 'avalado/listo', 7),
(17, 'LlLlLlLLlL', 'lalaallalala', 'Economía', 'lLlLlLl', 'Licenciatura en Administración', 'avalado/listo', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materia`
--

CREATE TABLE `materia` (
  `id_materia` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `id_carrera` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_11_11_082156_create_carreras_table', 2),
(5, '2026_11_11_082307_create_materias_table', 2),
(6, '2026_11_15_213026_update_formulario_structure_add_estado', 2),
(7, '2026_11_16_002416_mig_solicitante', 3),
(8, '2026_11_16_084254_mig_fechas_formulario', 4),
(9, '2026_11_16_235726_mig_nomi_profes', 5),
(10, '2026_11_16_235746_mig_nomi_estuds', 5),
(11, '2026_11_17_012716_corregir_nomina_estudiantes', 6),
(12, '2026_11_17_014006_corregir_nomina_profesores', 7),
(13, '2026_11_17_061335_modificar_coordinadores_table', 8),
(14, '2026_11_18_062015_mig_cordi_agregar_cotraseña', 9);

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
(13, '01010'),
(13, '010110'),
(13, '47474747'),
(13, '92929292'),
(14, '010110'),
(14, '47474747'),
(15, '01010'),
(15, '010110'),
(15, '47474747'),
(15, '92929292'),
(16, '01010'),
(16, '010110'),
(16, '47474747'),
(16, '92929292'),
(17, '47474747'),
(17, '92929292');

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
(13, '47474747'),
(14, '010110'),
(15, '01010'),
(15, '010110'),
(15, '47474747'),
(15, '92929292'),
(16, '01010'),
(16, '010110'),
(16, '47474747'),
(16, '92929292'),
(17, '47474747'),
(17, '92929292');

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
(1, 'op123', 'op1', 'op1@gmail.com'),
(2, '12345', 'Maria', 'marimar@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('JhYr2PMAftyxgauio8DURKdVED4j8m7wsJ8ltL7P', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.146.0 Chrome/150.0.7871.250 Electron/43.8.6 Safari/537.36', 'YToxMDp7czo2OiJfdG9rZW4iO3M6NDA6IndRRklkcjIwOFlUTnl5bVVCdzZTT09GU0ZBQnRmTTA0Q0tNeENBWTkiO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMzOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvY29vcmRpbmFkb3IiO3M6NToicm91dGUiO3M6MjE6ImNvb3JkaW5hZG9yLmRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MTY6ImNvb3JkaW5hZG9yX3RpcG8iO3M6NDoiYXJlYSI7czoxODoiY29vcmRpbmFkb3JfY29ycmVvIjtzOjE1OiJqb3N1ZUBnbWFpbC5jb20iO3M6MTE6Im9wZXJhZG9yX2lkIjtpOjE7czoxNToib3BlcmFkb3Jfbm9tYnJlIjtzOjM6Im9wMSI7czoxOToiY29vcmRpbmFkb3JfY2FycmVyYSI7czo4OiJEZXBvcnRlcyI7czoxNDoiY29vcmRpbmFkb3JfaWQiO2k6NDtzOjE4OiJjb29yZGluYWRvcl9ub21icmUiO3M6NToiSm9zdWUiO30=', 1795004424);

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
(7, 'huhu@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', '2026-11-18 08:33:52', '$2y$12$S4y3w4yU/rsIBYcpmRiV1OwWhwpy16HSMBeqSdGYBA6bN6DenYWDm', 'UegAWqPZIb', '2026-11-18 08:33:52', '2026-11-18 08:33:52');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indices de la tabla `carrera`
--
ALTER TABLE `carrera`
  ADD PRIMARY KEY (`id_carrera`),
  ADD UNIQUE KEY `carrera_nombre_unique` (`nombre`);

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
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `materia`
--
ALTER TABLE `materia`
  ADD PRIMARY KEY (`id_materia`),
  ADD UNIQUE KEY `materia_id_carrera_nombre_unique` (`id_carrera`,`nombre`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

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
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `profesor`
--
ALTER TABLE `profesor`
  ADD PRIMARY KEY (`dni_profesor`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `solicitante`
--
ALTER TABLE `solicitante`
  ADD PRIMARY KEY (`id_solicitante`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrera`
--
ALTER TABLE `carrera`
  MODIFY `id_carrera` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `coordinador`
--
ALTER TABLE `coordinador`
  MODIFY `id_coordinador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fechas_formulario`
--
ALTER TABLE `fechas_formulario`
  MODIFY `id_fecha` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `formulario`
--
ALTER TABLE `formulario`
  MODIFY `id_formulario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `materia`
--
ALTER TABLE `materia`
  MODIFY `id_materia` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `operador_de_be`
--
ALTER TABLE `operador_de_be`
  MODIFY `id_operador_de_BE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `solicitante`
--
ALTER TABLE `solicitante`
  MODIFY `id_solicitante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- Filtros para la tabla `materia`
--
ALTER TABLE `materia`
  ADD CONSTRAINT `materia_id_carrera_foreign` FOREIGN KEY (`id_carrera`) REFERENCES `carrera` (`id_carrera`) ON UPDATE CASCADE;

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
