-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-06-2023 a las 20:58:24
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_transport`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `travel`
--

CREATE TABLE `travel` (
  `id_travel` int(11) NOT NULL,
  `id_load` int(11) NOT NULL,
  `kilometer` int(11) NOT NULL,
  `amount_fuel` int(11) NOT NULL,
  `truck` varchar(150) NOT NULL,
  `driver` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `travel`
--

INSERT INTO `travel` (`id_travel`, `id_load`, `kilometer`, `amount_fuel`, `truck`, `driver`) VALUES
(1, 1, 750, 1500, 'Marcelo', 'Mercedes Benz1633'),
(2, 3, 150, 3300, 'Marcelo', 'Iveco 330'),
(3, 2, 530, 1120, 'Gustavo', 'Mercedes Benz1620'),
(4, 2, 350, 11550, 'Mario', 'Mercedes Benz 1620'),
(5, 2, 215, 8815, 'Marcelo', 'Fiat 619'),
(6, 3, 185, 7585, 'Jose', 'Fiat 619'),
(7, 4, 485, 13095, 'Gaston', 'Volvo'),
(8, 5, 530, 13780, 'Martin', 'Renault 420');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `truck_load`
--

CREATE TABLE `truck_load` (
  `id_load` int(11) NOT NULL,
  `type_load` varchar(150) NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `truck_load`
--

INSERT INTO `truck_load` (`id_load`, `type_load`, `value`) VALUES
(1, 'Miaz', 47110),
(2, 'Soja', 93000),
(3, 'Papa', 187),
(4, 'Fertilizante', 23000),
(5, 'Harina', 1417);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `email`) VALUES
(1, 'admin', '$2y$10$jYQGO.17jS1u5OyBJW/BpeB0Yz5hazBAJAu6pTiaqK25k4Udf8Fh.', 'admin@gmail.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `travel`
--
ALTER TABLE `travel`
  ADD PRIMARY KEY (`id_travel`),
  ADD KEY `fk_travel_truck_load` (`id_load`);

--
-- Indices de la tabla `truck_load`
--
ALTER TABLE `truck_load`
  ADD PRIMARY KEY (`id_load`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `travel`
--
ALTER TABLE `travel`
  MODIFY `id_travel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `truck_load`
--
ALTER TABLE `truck_load`
  MODIFY `id_load` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `travel`
--
ALTER TABLE `travel`
  ADD CONSTRAINT `fk_travel_truck_load` FOREIGN KEY (`id_load`) REFERENCES `truck_load` (`id_load`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;