-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-01-2020 a las 02:53:14
-- Versión del servidor: 10.4.6-MariaDB
-- Versión de PHP: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `binarytree`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trees`
--

CREATE TABLE `trees` (
  `id` int(11) NOT NULL,
  `description` varchar(30) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `trees`
--

INSERT INTO `trees` (`id`, `description`, `user_id`, `created`) VALUES
(1, 'Arbol #1', 4, '2020-01-10 09:33:45'),
(2, 'Arbol #2', 4, '2020-01-10 10:55:27'),
(3, 'Arbol #3', 4, '2020-01-11 01:53:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tree_details`
--

CREATE TABLE `tree_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tree_id` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tree_details`
--

INSERT INTO `tree_details` (`id`, `user_id`, `tree_id`, `value`, `created`) VALUES
(21, 4, 1, 67, '2020-01-10 20:18:21'),
(22, 4, 1, 39, '2020-01-10 20:18:24'),
(23, 4, 1, 76, '2020-01-10 20:18:26'),
(24, 4, 1, 28, '2020-01-10 20:18:35'),
(25, 4, 1, 44, '2020-01-10 20:18:38'),
(26, 4, 1, 29, '2020-01-10 20:18:50'),
(27, 4, 1, 74, '2020-01-10 20:18:52'),
(28, 4, 1, 85, '2020-01-10 20:19:09'),
(29, 4, 1, 83, '2020-01-10 20:19:12'),
(30, 4, 1, 87, '2020-01-10 20:19:14'),
(31, 4, 2, 2, '2020-01-11 01:52:32'),
(32, 4, 2, 5, '2020-01-11 01:52:35'),
(33, 4, 2, 6, '2020-01-11 01:52:37'),
(34, 4, 2, 8, '2020-01-11 01:52:40'),
(35, 4, 2, 70, '2020-01-11 01:52:43'),
(36, 4, 2, 65, '2020-01-11 01:52:45'),
(37, 4, 3, 70, '2020-01-11 01:54:23'),
(40, 4, 3, 80, '2020-01-11 01:56:12'),
(41, 4, 3, 90, '2020-01-11 01:56:15'),
(42, 4, 3, 45, '2020-01-11 01:56:20'),
(43, 4, 3, 35, '2020-01-11 01:56:38'),
(44, 4, 3, 76, '2020-01-11 01:56:40'),
(45, 4, 3, 87, '2020-01-11 01:56:42'),
(46, 4, 3, 98, '2020-01-11 01:56:43'),
(47, 4, 3, 5, '2020-01-11 01:56:46'),
(48, 4, 3, 3, '2020-01-11 01:56:48'),
(49, 4, 3, 76, '2020-01-11 01:56:50'),
(50, 4, 3, 75, '2020-01-11 01:56:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL DEFAULT 'default.svg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `name`, `photo`) VALUES
(4, 'admin', 'jmsg78@gmail.com', '$2y$10$zGW0eQBj6cTD94icYq.ste9icHfflRAWD.k504O4ae49mnM8aqAum', 'jose salazar', 'default.svg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `trees`
--
ALTER TABLE `trees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `tree_details`
--
ALTER TABLE `tree_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tree_id` (`tree_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `trees`
--
ALTER TABLE `trees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tree_details`
--
ALTER TABLE `tree_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `trees`
--
ALTER TABLE `trees`
  ADD CONSTRAINT `trees_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `tree_details`
--
ALTER TABLE `tree_details`
  ADD CONSTRAINT `tree_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tree_details_ibfk_2` FOREIGN KEY (`tree_id`) REFERENCES `trees` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
