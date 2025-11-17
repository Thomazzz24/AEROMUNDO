-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-11-2025 a las 22:43:12
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `aerolinea`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `avion`
--

CREATE TABLE `avion` (
  `id_avion` int(11) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `capacidad` int(11) NOT NULL CHECK (`capacidad` > 0),
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `avion`
--

INSERT INTO `avion` (`id_avion`, `modelo`, `capacidad`, `estado`) VALUES
(1, 'Airbus A320', 180, 1),
(2, 'Boeing 737-800', 160, 1),
(3, 'Embraer E190', 100, 1),
(4, 'Airbus A320', 180, 1),
(5, 'Boeing 737 MAX', 200, 1),
(6, 'Embraer E190', 98, 1),
(7, '1945', 30, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `checkin`
--

CREATE TABLE `checkin` (
  `id_checkin` int(11) NOT NULL,
  `id_tiquete` int(11) NOT NULL,
  `fecha_checkin` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `checkin`
--

INSERT INTO `checkin` (`id_checkin`, `id_tiquete`, `fecha_checkin`) VALUES
(7, 4, '2025-11-19 18:20:00'),
(8, 5, '2025-11-19 18:25:00'),
(9, 6, '2025-11-20 19:10:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pasajero`
--

CREATE TABLE `pasajero` (
  `id_pasajero` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pasajero`
--

INSERT INTO `pasajero` (`id_pasajero`, `id_usuario`) VALUES
(3, 13),
(5, 13),
(4, 14),
(6, 14),
(7, 17),
(8, 18);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `piloto`
--

CREATE TABLE `piloto` (
  `id_piloto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `piloto`
--

INSERT INTO `piloto` (`id_piloto`, `id_usuario`, `foto_perfil`) VALUES
(2, 7, '1763336955.jpeg'),
(7, 16, '1763414411.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `nombre`) VALUES
(1, 'Administrador'),
(3, 'Pasajero'),
(2, 'Piloto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ruta`
--

CREATE TABLE `ruta` (
  `id_ruta` int(11) NOT NULL,
  `origen` varchar(100) NOT NULL,
  `destino` varchar(100) NOT NULL,
  `duracion_estimada` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ruta`
--

INSERT INTO `ruta` (`id_ruta`, `origen`, `destino`, `duracion_estimada`) VALUES
(1, 'Bogotá', 'Medellín', '01:00:00'),
(2, 'Bogotá', 'Cali', '01:10:00'),
(3, 'Bogotá', 'Cartagena', '01:25:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiquete`
--

CREATE TABLE `tiquete` (
  `id_tiquete` int(11) NOT NULL,
  `id_vuelo` int(11) NOT NULL,
  `id_pasajero` int(11) NOT NULL,
  `nombre_pasajero` varchar(150) NOT NULL,
  `documento` varchar(50) NOT NULL,
  `asiento` varchar(10) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `fecha_compra` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tiquete`
--

INSERT INTO `tiquete` (`id_tiquete`, `id_vuelo`, `id_pasajero`, `nombre_pasajero`, `documento`, `asiento`, `precio`, `fecha_compra`) VALUES
(4, 1, 3, 'Laura Gómez', 'CC123456', '12A', 250000.00, '2025-11-17 11:46:26'),
(5, 1, 4, 'Carlos Mora', 'CC654321', '12B', 250000.00, '2025-11-17 11:46:26'),
(6, 2, 3, 'Laura Gómez', 'CC123456', '10A', 300000.00, '2025-11-17 11:46:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `fecha_registro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellido`, `correo`, `clave`, `id_rol`, `estado`, `fecha_registro`) VALUES
(2, 'Daniel', 'Capador', 'dc@aero.com', '202cb962ac59075b964b07152d234b70', 1, 1, '2025-11-15 20:12:31'),
(3, 'Thomas', 'Aguirre', 'ta@aero.com', '202cb962ac59075b964b07152d234b70', 1, 1, '2025-11-15 20:13:56'),
(7, 'SAMUEL', 'Arevalo', 'sa@aero.com', '202cb962ac59075b964b07152d234b70', 2, 0, '2025-11-16 10:53:39'),
(13, 'Laura', 'Gómez', 'lg@aero.com', '202cb962ac59075b964b07152d234b70', 3, 1, '2025-11-17 11:43:17'),
(14, 'Marcos', 'Pérez', 'mp@aero.com', '202cb962ac59075b964b07152d234b70', 3, 1, '2025-11-17 11:43:17'),
(16, 'Johan', 'Aguirre', 'johanAguirre3@gmail.com', '202cb962ac59075b964b07152d234b70', 2, 1, '2025-11-17 16:20:11'),
(17, 'Thomas', 'Aguirre', 'SeSki@gmail.com', '202cb962ac59075b964b07152d234b70', 2, 1, '2025-11-17 16:21:18'),
(18, 'Thomas', 'Aguirre', 'Tato@lm.com', '289dff07669d7a23de0ef88d2f7129e7', 2, 1, '2025-11-17 16:21:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vuelo`
--

CREATE TABLE `vuelo` (
  `id_vuelo` int(11) NOT NULL,
  `id_ruta` int(11) NOT NULL,
  `id_avion` int(11) NOT NULL,
  `id_piloto_principal` int(11) NOT NULL,
  `id_copiloto` int(11) NOT NULL,
  `fecha_salida` datetime NOT NULL,
  `fecha_llegada` datetime NOT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vuelo`
--

INSERT INTO `vuelo` (`id_vuelo`, `id_ruta`, `id_avion`, `id_piloto_principal`, `id_copiloto`, `fecha_salida`, `fecha_llegada`, `estado`) VALUES
(1, 1, 1, 2, 2, '2025-11-20 08:00:00', '2025-11-20 09:00:00', 1),
(2, 2, 2, 2, 2, '2025-11-21 07:30:00', '2025-11-21 08:40:00', 1),
(3, 3, 3, 2, 2, '2025-11-22 10:00:00', '2025-11-22 11:25:00', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `avion`
--
ALTER TABLE `avion`
  ADD PRIMARY KEY (`id_avion`);

--
-- Indices de la tabla `checkin`
--
ALTER TABLE `checkin`
  ADD PRIMARY KEY (`id_checkin`),
  ADD KEY `id_tiquete` (`id_tiquete`);

--
-- Indices de la tabla `pasajero`
--
ALTER TABLE `pasajero`
  ADD PRIMARY KEY (`id_pasajero`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `piloto`
--
ALTER TABLE `piloto`
  ADD PRIMARY KEY (`id_piloto`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `ruta`
--
ALTER TABLE `ruta`
  ADD PRIMARY KEY (`id_ruta`),
  ADD UNIQUE KEY `origen` (`origen`,`destino`);

--
-- Indices de la tabla `tiquete`
--
ALTER TABLE `tiquete`
  ADD PRIMARY KEY (`id_tiquete`),
  ADD KEY `id_vuelo` (`id_vuelo`),
  ADD KEY `id_pasajero` (`id_pasajero`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `vuelo`
--
ALTER TABLE `vuelo`
  ADD PRIMARY KEY (`id_vuelo`),
  ADD KEY `id_ruta` (`id_ruta`),
  ADD KEY `id_avion` (`id_avion`),
  ADD KEY `id_piloto_principal` (`id_piloto_principal`),
  ADD KEY `id_copiloto` (`id_copiloto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `avion`
--
ALTER TABLE `avion`
  MODIFY `id_avion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `checkin`
--
ALTER TABLE `checkin`
  MODIFY `id_checkin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `pasajero`
--
ALTER TABLE `pasajero`
  MODIFY `id_pasajero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `piloto`
--
ALTER TABLE `piloto`
  MODIFY `id_piloto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ruta`
--
ALTER TABLE `ruta`
  MODIFY `id_ruta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tiquete`
--
ALTER TABLE `tiquete`
  MODIFY `id_tiquete` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `vuelo`
--
ALTER TABLE `vuelo`
  MODIFY `id_vuelo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `checkin`
--
ALTER TABLE `checkin`
  ADD CONSTRAINT `checkin_ibfk_1` FOREIGN KEY (`id_tiquete`) REFERENCES `tiquete` (`id_tiquete`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pasajero`
--
ALTER TABLE `pasajero`
  ADD CONSTRAINT `pasajero_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `piloto`
--
ALTER TABLE `piloto`
  ADD CONSTRAINT `piloto_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tiquete`
--
ALTER TABLE `tiquete`
  ADD CONSTRAINT `tiquete_ibfk_1` FOREIGN KEY (`id_vuelo`) REFERENCES `vuelo` (`id_vuelo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tiquete_ibfk_2` FOREIGN KEY (`id_pasajero`) REFERENCES `pasajero` (`id_pasajero`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `vuelo`
--
ALTER TABLE `vuelo`
  ADD CONSTRAINT `vuelo_ibfk_1` FOREIGN KEY (`id_ruta`) REFERENCES `ruta` (`id_ruta`) ON UPDATE CASCADE,
  ADD CONSTRAINT `vuelo_ibfk_2` FOREIGN KEY (`id_avion`) REFERENCES `avion` (`id_avion`) ON UPDATE CASCADE,
  ADD CONSTRAINT `vuelo_ibfk_3` FOREIGN KEY (`id_piloto_principal`) REFERENCES `piloto` (`id_piloto`) ON UPDATE CASCADE,
  ADD CONSTRAINT `vuelo_ibfk_4` FOREIGN KEY (`id_copiloto`) REFERENCES `piloto` (`id_piloto`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
