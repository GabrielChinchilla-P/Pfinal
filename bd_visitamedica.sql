-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-11-2025 a las 21:26:37
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
-- Base de datos: `bd_visitamedica`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bonificaciones`
--

CREATE TABLE `bonificaciones` (
  `id` int(11) NOT NULL,
  `id_visitador` int(11) NOT NULL,
  `nombre_visitador` varchar(100) NOT NULL,
  `ventas_totales` decimal(10,2) NOT NULL,
  `bonificacion` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bonificaciones`
--

INSERT INTO `bonificaciones` (`id`, `id_visitador`, `nombre_visitador`, `ventas_totales`, `bonificacion`) VALUES
(2, 1000, 'Angélica ', 75000.00, 11250.00),
(3, 200, 'Elizabeth', 85500.00, 12825.00),
(4, 100, 'Marta Gonzalez', 0.00, 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `depto` varchar(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `distancia` decimal(10,2) NOT NULL DEFAULT 0.00,
  `alojamiento` decimal(10,2) NOT NULL,
  `combustible` decimal(10,2) NOT NULL,
  `alimentacion` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`depto`, `descripcion`, `distancia`, `alojamiento`, `combustible`, `alimentacion`) VALUES
('1', 'Alta Verapaz', 200.31, 310.00, 349.57, 210.00),
('2', 'Baja Verapaz', 105.22, 450.00, 183.62, 210.00),
('3', 'Chimaltenango', 87.79, 200.00, 153.21, 150.00),
('4', 'Chiquimula', 190.76, 476.00, 332.90, 90.00),
('5', 'Petén', 416.27, 420.00, 726.45, 150.00),
('6', 'El Progreso', 85.65, 210.00, 149.47, 90.00),
('7', 'Escuintla', 54.83, 450.00, 95.69, 90.00),
('8', 'Guatemala', 20.72, 220.00, 36.16, 90.00),
('9', 'Huehuetenango', 256.67, 500.00, 447.93, 150.00),
('10', 'Izabal', 264.11, 550.00, 460.91, 210.00),
('11', 'Jalapa', 104.56, 450.00, 182.47, 90.00),
('12', 'Jutiapa', 112.60, 366.00, 196.50, 90.00),
('13', 'Quetzaltenango', 250.84, 531.00, 437.75, 150.00),
('14', 'Quiché', 251.54, 420.00, 438.97, 150.00),
('15', 'Retalhuleu', 183.08, 350.00, 319.50, 90.00),
('16', 'Sacatepéquez', 36.51, 200.00, 63.72, 90.00),
('17', 'San Marcos', 269.94, 350.00, 471.08, 150.00),
('18', 'Santa Rosa', 81.67, 250.00, 142.53, 90.00),
('19', 'Sololá', 146.57, 350.00, 255.79, 150.00),
('20', 'Suchitepéquez', 149.33, 415.00, 260.60, 150.00),
('21', 'Totonicapán', 197.11, 300.00, 343.99, 150.00),
('22', 'Zacapa', 154.61, 300.00, 269.82, 90.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `cod_empleado` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `departamento` varchar(50) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `usuario` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`cod_empleado`, `nombre`, `apellido`, `departamento`, `fecha_ingreso`, `usuario`) VALUES
(100, 'Marta', 'Gonzalez', 'Gerencia', '2010-05-25', 'Admin'),
(200, 'Elizabeth', 'Monroy', 'Visitador', '2013-02-01', 'Empleado'),
(300, 'Sandra', 'Pacheco', 'Auditoria', '2015-05-05', 'Empleado'),
(400, 'Luis', 'Cáceres', 'Cómputo', '2020-08-05', 'RRHH'),
(500, 'Sergio', 'Ramírez', 'Gerencia', '2011-11-06', 'Admin'),
(600, 'Carlos', 'Hernández', 'Visitador', '2018-08-11', 'Empleado'),
(700, 'Leticia', 'Méndez', 'Auditoria', '2019-11-12', 'Empleado'),
(800, 'Edwin', 'Alonso', 'Cómputo', '2013-04-13', 'Empleado'),
(900, 'Evelin', 'Rivas', 'Gerencia', '2012-07-09', 'Supervisor'),
(1000, 'Angélica', 'Garcia', 'Visitador', '2016-06-14', 'Empleado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informe_gastos`
--

CREATE TABLE `informe_gastos` (
  `id_informe` int(10) NOT NULL,
  `cod_empleado` varchar(10) DEFAULT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `departamento` varchar(50) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `fecha_visita` date NOT NULL,
  `cod_depto` varchar(10) DEFAULT NULL,
  `descripcion` varchar(255) NOT NULL,
  `otros` decimal(12,2) DEFAULT 0.00,
  `total` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `informe_gastos`
--

INSERT INTO `informe_gastos` (`id_informe`, `cod_empleado`, `nombre`, `apellido`, `departamento`, `fecha_inicio`, `fecha_fin`, `fecha_visita`, `cod_depto`, `descripcion`, `otros`, `total`) VALUES
(1, '200', 'Elizabeth', 'Monroy', 'Visitador', '2025-07-01', '2025-07-01', '2025-07-01', '2', 'Baja Verapaz', 150.00, 993.62),
(2, '1000', 'Angélica', 'Garcia', 'Visitador', '2025-09-19', '2025-09-19', '2025-09-19', '2', 'baja verapaz', 2800.00, 3643.62);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nomina`
--

CREATE TABLE `nomina` (
  `id_nomina` int(11) NOT NULL,
  `id_visitador` int(11) DEFAULT NULL,
  `cod_empleado` int(11) DEFAULT NULL,
  `nombre_empleado` varchar(100) DEFAULT NULL,
  `departamento` varchar(100) DEFAULT NULL,
  `sueldo_base` decimal(10,2) DEFAULT NULL,
  `bonificacion` decimal(10,2) DEFAULT NULL,
  `IGSS` decimal(10,2) DEFAULT NULL,
  `otros_desc` decimal(10,2) DEFAULT NULL,
  `liquido` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `nomina`
--

INSERT INTO `nomina` (`id_nomina`, `id_visitador`, `cod_empleado`, `nombre_empleado`, `departamento`, `sueldo_base`, `bonificacion`, `IGSS`, `otros_desc`, `liquido`) VALUES
(1, 200, 200, 'Elizabeth', 'Visitador', 2400.00, 9000.00, 550.62, 150.00, 10699.38),
(2, 200, 200, 'Elizabeth', 'Visitador', 3600.00, 9000.00, 608.58, 0.00, 11991.42),
(3, NULL, 600, 'Carlos Hernández', 'Visitador', 2400.00, 250.00, 115.92, 0.00, 2534.08),
(4, NULL, 1000, 'Angélica Garcia', 'Visitador', 2400.00, 250.00, 115.92, 0.00, 2534.08),
(5, NULL, 700, 'Leticia Méndez', 'Auditoria', 4500.00, 250.00, 217.35, 0.00, 4532.65),
(6, NULL, 200, 'Elizabeth Monroy', 'Visitador', 2400.00, 250.00, 115.92, 150.00, 2384.08),
(7, NULL, 400, 'Luis Cáceres', 'Cómputo', 4800.00, 250.00, 231.84, 200.00, 4618.16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol` enum('admin','rrhh','supervisor','empleado') NOT NULL DEFAULT 'empleado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `correo`, `usuario`, `contrasena`, `rol`) VALUES
(6, 'Gabriel', 'admin@correo.com', '', '$2y$10$nKqevDGHPwiUN5lHyPdYAepJykp.uzOOFBYpPna.NyJ1vIybnHOYC', 'admin'),
(7, 'Eduardo', 'admin1@correo.com', '', '$2y$10$2IRv5CtkfrIJzl3eAL9sSeCiBdTQlIMQgwPcNDWGn6ZB1LjhjfF7u', 'rrhh'),
(8, 'Luis', 'admin2@correo.com', '', '$2y$10$5fDDR7DIwy7u2Nb8HVWmI.WpfBkKR8nUectw76XpE.899fftqMk5C', 'supervisor');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bonificaciones`
--
ALTER TABLE `bonificaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`cod_empleado`);

--
-- Indices de la tabla `informe_gastos`
--
ALTER TABLE `informe_gastos`
  ADD PRIMARY KEY (`id_informe`);

--
-- Indices de la tabla `nomina`
--
ALTER TABLE `nomina`
  ADD PRIMARY KEY (`id_nomina`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bonificaciones`
--
ALTER TABLE `bonificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `cod_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1001;

--
-- AUTO_INCREMENT de la tabla `nomina`
--
ALTER TABLE `nomina`
  MODIFY `id_nomina` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
