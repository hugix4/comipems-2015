-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-07-2015 a las 21:40:25
-- Versión del servidor: 5.6.24
-- Versión de PHP: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `mysql`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comipems`
--

CREATE TABLE IF NOT EXISTS `comipems` (
  `Id` int(10) NOT NULL,
  `Folio` varchar(6) COLLATE latin1_general_ci NOT NULL,
  `Evento` varchar(12) COLLATE latin1_general_ci NOT NULL,
  `Periodo` varchar(4) COLLATE latin1_general_ci NOT NULL,
  `Minutos` tinyint(4) NOT NULL DEFAULT '30',
  `Vuelta` tinyint(4) NOT NULL DEFAULT '0',
  `Segundos` tinyint(4) NOT NULL DEFAULT '60',
  `Etapa` varchar(2) COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `Bin1` varchar(10) COLLATE latin1_general_ci NOT NULL DEFAULT '-',
  `Bin2` varchar(10) COLLATE latin1_general_ci NOT NULL DEFAULT '-',
  `Bin3` varchar(10) COLLATE latin1_general_ci NOT NULL DEFAULT '-',
  `Bin4` varchar(10) COLLATE latin1_general_ci NOT NULL DEFAULT '-',
  `Bin5` varchar(10) COLLATE latin1_general_ci NOT NULL DEFAULT '-',
  `Bin6` varchar(10) COLLATE latin1_general_ci NOT NULL DEFAULT '-',
  `Rc1` text COLLATE latin1_general_ci NOT NULL,
  `Rc2` text COLLATE latin1_general_ci NOT NULL,
  `Rc3` text COLLATE latin1_general_ci NOT NULL,
  `Rc4` text COLLATE latin1_general_ci NOT NULL,
  `Rc5` text COLLATE latin1_general_ci NOT NULL,
  `Rc6` text COLLATE latin1_general_ci NOT NULL,
  `Calificacion` varchar(6) COLLATE latin1_general_ci NOT NULL,
  `Seccion` varchar(2) COLLATE latin1_general_ci NOT NULL,
  `Resultado` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `Inicio` timestamp NULL DEFAULT NULL,
  `Salida` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Termino` varchar(1) COLLATE latin1_general_ci NOT NULL DEFAULT 'N'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comipems`
--
ALTER TABLE `comipems`
  ADD UNIQUE KEY `Id` (`Id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comipems`
--
ALTER TABLE `comipems`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
