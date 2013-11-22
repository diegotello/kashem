-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 21, 2013 at 10:35 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `kashem`
--
CREATE DATABASE IF NOT EXISTS `kashem` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `kashem`;

-- --------------------------------------------------------

--
-- Table structure for table `actividad`
--

CREATE TABLE IF NOT EXISTS `actividad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `actividad`
--

INSERT INTO `actividad` (`id`, `nombre`, `descripcion`) VALUES
(1, 'montaÃ±ismo', NULL),
(2, 'senderismo', NULL),
(3, 'alta montaÃ±a', NULL),
(4, 'excursionismo', NULL),
(5, 'escalada', NULL),
(6, 'rappel', NULL),
(7, 'espeleologia', NULL),
(8, 'rafting', NULL),
(9, 'ciclismo mtb', NULL),
(10, 'nueva', 'esta es la actividad creada desde la aplicacion'),
(11, 'asdfff11', 'asdfff11'),
(12, 'qwer', 'qwer'),
(13, 'tyu', 'tyu'),
(14, 'uiop', 'qwer'),
(15, 'zxcv', 'asdf'),
(16, 'cvbn', 'wert'),
(17, 'rrr', ''),
(19, 'asdfasdf', ''),
(20, 'rrrr', 'tttt'),
(21, 'eeee', 'eeee iiii');

-- --------------------------------------------------------

--
-- Table structure for table `actividad_logro`
--

CREATE TABLE IF NOT EXISTS `actividad_logro` (
  `actividad_id` int(11) NOT NULL,
  `logro_id` int(11) NOT NULL,
  PRIMARY KEY (`actividad_id`,`logro_id`),
  KEY `fk_actividad_has_logro_logro1` (`logro_id`),
  KEY `fk_actividad_has_logro_actividad1` (`actividad_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `actividad_logro`
--

INSERT INTO `actividad_logro` (`actividad_id`, `logro_id`) VALUES
(1, 3),
(2, 3),
(3, 3),
(4, 3),
(7, 4),
(1, 5),
(2, 5),
(3, 5),
(4, 5),
(2, 6),
(3, 6),
(4, 6),
(5, 6),
(1, 7),
(2, 7),
(2, 8),
(3, 8),
(6, 9),
(7, 9),
(8, 9),
(6, 11),
(7, 11),
(8, 11),
(1, 12),
(2, 12),
(3, 12),
(1, 13),
(2, 13),
(1, 14),
(8, 15),
(9, 15),
(10, 15),
(1, 16),
(2, 16),
(3, 16);

-- --------------------------------------------------------

--
-- Table structure for table `alquiler`
--

CREATE TABLE IF NOT EXISTS `alquiler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `renta` date NOT NULL,
  `devolucion` date NOT NULL,
  `deposito` decimal(6,2) DEFAULT NULL,
  `comentario` text,
  PRIMARY KEY (`id`),
  KEY `cliente_id` (`cliente_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `alquiler_equipo`
--

CREATE TABLE IF NOT EXISTS `alquiler_equipo` (
  `alquiler_id` int(11) NOT NULL,
  `equipo_id` int(11) NOT NULL,
  PRIMARY KEY (`alquiler_id`,`equipo_id`),
  KEY `alquiler_equipo_alquiler_fk` (`alquiler_id`),
  KEY `alquiler_equipo_equipo_fk` (`equipo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`, `descripcion`) VALUES
(2, 'Novato', 'guia principiante1'),
(3, 'Intermedio', ''),
(4, 'Avanzado', ''),
(5, 'Experto', ''),
(6, 'Ninja', '');

-- --------------------------------------------------------

--
-- Table structure for table `cliente`
--

CREATE TABLE IF NOT EXISTS `cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pais_id` int(11) NOT NULL,
  `departamento_id` int(11) NOT NULL,
  `municipio_id` int(11) NOT NULL,
  `primer_nombre` varchar(50) NOT NULL,
  `segundo_nombre` varchar(50) DEFAULT NULL,
  `primer_apellido` varchar(50) NOT NULL,
  `segundo_apellido` varchar(50) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `genero` varchar(50) DEFAULT NULL,
  `dpi` varchar(50) NOT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `direccion` varchar(50) DEFAULT NULL,
  `correo_electronico` varchar(50) DEFAULT NULL,
  `usuario_facebook` varchar(50) DEFAULT NULL,
  `contacto_emergencia` varchar(50) DEFAULT NULL,
  `telefono_emergencia` varchar(50) DEFAULT NULL,
  `observacion_medica` text,
  `observacion_general` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dpi_UNIQUE` (`dpi`),
  KEY `fk_clientes_paises1` (`pais_id`),
  KEY `fk_clientes_departamento1` (`departamento_id`),
  KEY `fk_clientes_municipio1` (`municipio_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `cliente`
--

INSERT INTO `cliente` (`id`, `pais_id`, `departamento_id`, `municipio_id`, `primer_nombre`, `segundo_nombre`, `primer_apellido`, `segundo_apellido`, `fecha_nacimiento`, `genero`, `dpi`, `telefono`, `direccion`, `correo_electronico`, `usuario_facebook`, `contacto_emergencia`, `telefono_emergencia`, `observacion_medica`, `observacion_general`) VALUES
(1, 1, 7, 82, 'Diego', 'Paolo', 'Tello', 'Cifuentes', '1989-09-13', 'masculino', 'A-1 234555234', '54677428', 'abc def ghi', 'dietello1@gmail.com', 'diegotello', '', '99887766', 'ninguna', 'ninguna'),
(2, 1, 2, 22, 'aaaa', '', 'bbbb', '', '1990-09-13', 'femenino', '44665533', '77668822', 'asdf asdf as', '', '', '', '', 'Ã±aÃ±', ''),
(3, 1, 7, 82, 'bbbb', 'eeee', 'yyyy', 'jkl', '1978-11-21', 'masculino', '5', '', '', '', '', '', '', '', ''),
(4, 1, 2, 24, 'xxxyyy', '', 'yyyxxx', '', '1970-01-01', 'masculino', '6', '', '', '', '', '', '', '', ''),
(6, 1, 5, 55, 'qwer', '', 'tyui', '', '1970-01-01', '', '7', '', '', '', '', '', '', '', ''),
(7, 1, 5, 55, 'qwer', '', 'tyui', '', '1970-01-01', '', '8', '', '', '', '', '', '', '', ''),
(8, 1, 3, 26, 'oooo', '', 'ppppp', '', '1970-01-01', 'femenino', '9', '', '', '', '', '', '', '', ''),
(10, 1, 8, 116, 'pppppoooo', '', 'hhhhhhllll', '', '1970-01-01', '', '10', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `cliente_logro`
--

CREATE TABLE IF NOT EXISTS `cliente_logro` (
  `cliente_id` int(11) NOT NULL,
  `logro_id` int(11) NOT NULL,
  PRIMARY KEY (`cliente_id`,`logro_id`),
  KEY `fk_cliente_has_logro_logro1` (`logro_id`),
  KEY `fk_cliente_has_logro_cliente1` (`cliente_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cliente_viaje`
--

CREATE TABLE IF NOT EXISTS `cliente_viaje` (
  `cliente_id` int(11) NOT NULL,
  `viaje_id` int(11) NOT NULL,
  PRIMARY KEY (`cliente_id`,`viaje_id`),
  KEY `fk_cliente_has_viaje_viaje1` (`viaje_id`),
  KEY `fk_cliente_has_viaje_cliente1` (`cliente_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cuenta`
--

CREATE TABLE IF NOT EXISTS `cuenta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `alquiler_id` int(11) DEFAULT NULL,
  `viaje_id` int(11) DEFAULT NULL,
  `tipo_de_pago_id` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL COMMENT 'puede ser "viaje" o "alquiler"',
  `estado` varchar(50) NOT NULL COMMENT 'puede ser "pendiente" o "cancelado"',
  `monto` decimal(6,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cuenta_cliente_fk` (`cliente_id`),
  KEY `cuenta_viaje_fk` (`viaje_id`),
  KEY `cuenta_alquiler_fk` (`alquiler_id`),
  KEY `cuenta_tipo_de_pago_fk` (`tipo_de_pago_id`),
  KEY `cuenta_tipo_de_cuenta_fk` (`tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `departamento`
--

CREATE TABLE IF NOT EXISTS `departamento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pais_id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_departamento_paises1` (`pais_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `departamento`
--

INSERT INTO `departamento` (`id`, `pais_id`, `nombre`) VALUES
(1, 1, 'alta verapaz'),
(2, 1, 'baja verapaz'),
(3, 1, 'chimaltenango'),
(4, 1, 'chiquimula'),
(5, 1, 'el progreso'),
(6, 1, 'escuintla'),
(7, 1, 'guatemala'),
(8, 1, 'huehuetenango'),
(9, 1, 'izabal'),
(10, 1, 'jalapa'),
(11, 1, 'jutiapa'),
(12, 1, 'peten'),
(13, 1, 'quetzaltenango'),
(14, 1, 'quiche'),
(15, 1, 'retalhuleu'),
(16, 1, 'sacatepequez'),
(17, 1, 'san marcos'),
(18, 1, 'santa rosa'),
(19, 1, 'solola'),
(20, 1, 'suchitepequez'),
(21, 1, 'totonicapan'),
(22, 1, 'zacapa'),
(23, 1, 'xyzw'),
(24, 1, 'abncdeasdfasdfasdfasdf');

-- --------------------------------------------------------

--
-- Table structure for table `destino`
--

CREATE TABLE IF NOT EXISTS `destino` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pais_id` int(11) NOT NULL,
  `departamento_id` int(11) NOT NULL,
  `municipio_id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text,
  `lat` varchar(50) DEFAULT NULL,
  `long` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`),
  KEY `fk_destino_pais1` (`pais_id`),
  KEY `fk_destino_departamento1` (`departamento_id`),
  KEY `fk_destino_municipio1` (`municipio_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `destino`
--

INSERT INTO `destino` (`id`, `pais_id`, `departamento_id`, `municipio_id`, `nombre`, `descripcion`, `lat`, `long`) VALUES
(2, 1, 3, 27, 'destino 1', '', NULL, NULL),
(3, 1, 7, 82, 'centro historico', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `equipo`
--

CREATE TABLE IF NOT EXISTS `equipo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `identificador` varchar(50) NOT NULL,
  `disponible` tinyint(1) NOT NULL DEFAULT '1',
  `descripcion` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `identificador_UNIQUE` (`identificador`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `equipo`
--

INSERT INTO `equipo` (`id`, `nombre`, `identificador`, `disponible`, `descripcion`) VALUES
(5, 'Cuerda', 'c1', 1, ''),
(7, 'Cuerda', 'c2', 1, ''),
(8, 'Cuerda', 'c3', 1, ''),
(9, 'Cuerda', 'c4', 0, ''),
(10, 'Carpa pequeÃ±a', 'cp1', 0, ''),
(11, 'Carpa pequeÃ±a', 'cp2', 1, ''),
(12, 'Carpa pequeÃ±a', 'cp3', 1, ''),
(13, 'Carpa pequeÃ±a', 'cp4', 1, ''),
(14, 'Carpa grande', 'cg1', 1, ''),
(15, 'Carpa grande', 'cg2', 1, ''),
(16, 'Carpa grande', 'cg3', 1, ''),
(17, 'Carpa grande', 'cg4', 1, ''),
(18, 'Botas', 'b1', 1, ''),
(19, 'Botas', 'b2', 1, ''),
(20, 'Botas', 'b3', 1, ''),
(21, 'Botas', 'b4', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `guia`
--

CREATE TABLE IF NOT EXISTS `guia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_guia_cliente1` (`cliente_id`),
  KEY `fk_guia_categoria1` (`categoria_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `guia`
--

INSERT INTO `guia` (`id`, `cliente_id`, `categoria_id`) VALUES
(2, 2, 2),
(3, 4, 4),
(4, 7, 2),
(5, 3, 3),
(6, 1, 6),
(7, 10, 2);

-- --------------------------------------------------------

--
-- Table structure for table `guia_viaje`
--

CREATE TABLE IF NOT EXISTS `guia_viaje` (
  `guia_id` int(11) NOT NULL,
  `viaje_id` int(11) NOT NULL,
  PRIMARY KEY (`guia_id`,`viaje_id`),
  KEY `fk_guia_has_viaje_viaje1` (`viaje_id`),
  KEY `fk_guia_has_viaje_guia1` (`guia_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `logro`
--

CREATE TABLE IF NOT EXISTS `logro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `logro`
--

INSERT INTO `logro` (`id`, `nombre`) VALUES
(3, 'logro msae'),
(4, 'logro rappel-espeleologia'),
(7, 'ms'),
(13, 'ms1'),
(12, 'msa1'),
(16, 'msa5'),
(5, 'msae'),
(14, 'prueba solo montaÃ±ismo'),
(15, 'rcn'),
(9, 'rer'),
(11, 'rer1'),
(8, 'sa'),
(6, 'saee');

-- --------------------------------------------------------

--
-- Table structure for table `municipio`
--

CREATE TABLE IF NOT EXISTS `municipio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `departamento_id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_municipio_departamento1` (`departamento_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=334 ;

--
-- Dumping data for table `municipio`
--

INSERT INTO `municipio` (`id`, `departamento_id`, `nombre`) VALUES
(1, 1, 'fray bartolome de las casas'),
(2, 1, 'coban'),
(3, 1, 'chahal'),
(4, 1, 'san pedro carcha'),
(5, 1, 'cahabon'),
(6, 1, 'lanquin'),
(7, 1, 'senahu'),
(8, 1, 'panzos'),
(9, 1, 'san cristobal verapaz'),
(10, 1, 'san juan chamelco'),
(11, 1, 'santa cruz verapaz'),
(12, 1, 'tucuru'),
(13, 1, 'tamahu'),
(14, 1, 'tactic'),
(15, 1, 'santa catarina la tinta'),
(16, 1, 'raxruja'),
(17, 1, 'chisec'),
(18, 2, 'cubulco'),
(19, 2, 'purulha'),
(20, 2, 'san miguel chicaj'),
(21, 2, 'rabinal'),
(22, 2, 'salama'),
(23, 2, 'san jeronimo'),
(24, 2, 'el chol'),
(25, 2, 'granados'),
(26, 3, 'tecpan guatemala'),
(27, 3, 'san martin jilotepeque'),
(28, 3, 'san jose poaquil'),
(29, 3, 'santa apolonia'),
(30, 3, 'comalapa'),
(31, 3, 'chimaltenango'),
(32, 3, 'zaragoza'),
(33, 3, 'el tejar'),
(34, 3, 'patzun'),
(35, 3, 'santa cruz balanya'),
(36, 3, 'patzicia'),
(37, 3, 'san andres itzapa'),
(38, 3, 'parramos'),
(39, 3, 'pochuta'),
(40, 3, 'acatenango'),
(41, 3, 'yepocapa'),
(42, 4, 'camotan'),
(43, 4, 'jocotan'),
(44, 4, 'chiquimula'),
(45, 4, 'esquipulas'),
(46, 4, 'san juan la ermita'),
(47, 4, 'san jose la arada'),
(48, 4, 'olopa'),
(49, 4, 'san jacinto'),
(50, 4, 'quetzaltepeque'),
(51, 4, 'ipala'),
(52, 4, 'concepcion las minas'),
(53, 5, 'san agustin acasaguastlan'),
(54, 5, 'morazan'),
(55, 5, 'san cristobal acasguastlan'),
(56, 5, 'el jicaro'),
(57, 5, 'guastatoya'),
(58, 5, 'sanarate'),
(59, 5, 'san antonio la paz'),
(60, 5, 'sansare'),
(61, 6, 'escuintla'),
(62, 6, 'siquinala'),
(63, 6, 'palin'),
(64, 6, 'santa lucia cotzulmalguapa'),
(65, 6, 'san vicente pacaya'),
(66, 6, 'tiquisate'),
(67, 6, 'nueva concepcion'),
(68, 6, 'guanagazapa'),
(69, 6, 'la democracia'),
(70, 6, 'masagua'),
(71, 6, 'la gomera'),
(72, 6, 'san jose'),
(73, 6, 'iztapa'),
(74, 7, 'chuarrancho'),
(75, 7, 'san raymundo'),
(76, 7, 'san juan sacatepequez'),
(77, 7, 'san jose del golfo'),
(78, 7, 'san pedro ayampuc'),
(79, 7, 'chinautla'),
(80, 7, 'palencia'),
(81, 7, 'san pedro sacatepequez'),
(82, 7, 'guatemala'),
(83, 7, 'mixco'),
(84, 7, 'san jose pinula'),
(85, 7, 'santa catarina pinula'),
(86, 7, 'villa nueva'),
(87, 7, 'villa canales'),
(88, 7, 'fraijanes'),
(89, 7, 'petapa'),
(90, 7, 'amatitlan'),
(91, 8, 'barillas'),
(92, 8, 'san mateo ixtatan'),
(93, 8, 'nenton'),
(94, 8, 'san sebastian coatan'),
(95, 8, 'santa eulalia'),
(96, 8, 'jacaltenango'),
(97, 8, 'santa ana huista'),
(98, 8, 'san miguel acatan'),
(99, 8, 'san rafael la independencia'),
(100, 8, 'san antonio huista'),
(101, 8, 'soloma'),
(102, 8, 'la democracia'),
(103, 8, 'san juan ixcoy'),
(104, 8, 'chiantla'),
(105, 8, 'la libertad'),
(106, 8, 'cuilco'),
(107, 8, 'aguacatan'),
(108, 8, 'san juan atitan'),
(109, 8, 'san idelfonso ixtahuacan'),
(110, 8, 'san sebastian huehuetenango'),
(111, 8, 'colotenango'),
(112, 8, 'san rafael petzal'),
(113, 8, 'tectitan'),
(114, 8, 'san gaspar ixchil'),
(115, 8, 'santa barbara'),
(116, 8, 'huehuetenango'),
(117, 8, 'malacatancito'),
(118, 8, 'union cantinil'),
(119, 8, 'concepcion huista'),
(120, 8, 'santiago chimaltenango'),
(121, 8, 'san pedro necta'),
(122, 8, 'todos santos cuchumatan'),
(123, 9, 'puerto barrios'),
(124, 9, 'livingston'),
(125, 9, 'el estor'),
(126, 9, 'morales'),
(127, 9, 'los amates'),
(128, 10, 'san pedro pinula'),
(129, 10, 'jalapa'),
(130, 10, 'san luis jilotepeque'),
(131, 10, 'mataquescuintla'),
(132, 10, 'san manuel chaparron'),
(133, 10, 'monjas'),
(134, 10, 'san carlos alzatate'),
(135, 11, 'agua blanca'),
(136, 11, 'santa catarina mita'),
(137, 11, 'el progreso'),
(138, 11, 'jutiapa'),
(139, 11, 'asuncion mita'),
(140, 11, 'quesada'),
(141, 11, 'san jose acatempa'),
(142, 11, 'yupiltepeque'),
(143, 11, 'jalpatagua'),
(144, 11, 'atescatempa'),
(145, 11, 'comapa'),
(146, 11, 'el adelanto'),
(147, 11, 'zapotitlan'),
(148, 11, 'jerez'),
(149, 11, 'conguaco'),
(150, 11, 'moyuta'),
(151, 11, 'pasaco'),
(152, 12, 'melchor de mencos'),
(153, 12, 'flores'),
(154, 12, 'san jose'),
(155, 12, 'san andres'),
(156, 12, 'la libertad'),
(157, 12, 'san benito'),
(158, 12, 'santa ana'),
(159, 12, 'dolores'),
(160, 12, 'san francisco'),
(161, 12, 'sayaxche'),
(162, 12, 'poptun'),
(163, 12, 'san luis'),
(164, 13, 'san carlos sija'),
(165, 13, 'cabrican'),
(166, 13, 'huitan'),
(167, 13, 'sibilia'),
(168, 13, 'palestina de los altos'),
(169, 13, 'cajola'),
(170, 13, 'san francisco la union'),
(171, 13, 'san juan ostuncalco'),
(172, 13, 'san miguel siguila'),
(173, 13, 'olintepeque'),
(174, 13, 'la esperanza'),
(175, 13, 'salcaja'),
(176, 13, 'quetzaltenango'),
(177, 13, 'san mateo'),
(178, 13, 'concepcion chiquirichapa'),
(179, 13, 'cantel'),
(180, 13, 'san martin sacatepequez'),
(181, 13, 'colomba'),
(182, 13, 'almolonga'),
(183, 13, 'zunil'),
(184, 13, 'el palmar'),
(185, 13, 'coatepeque'),
(186, 13, 'flores costa cuca'),
(187, 13, 'genova'),
(188, 14, 'ixcan'),
(189, 14, 'nebaj'),
(190, 14, 'chajul'),
(191, 14, 'uspantan'),
(192, 14, 'chicaman'),
(193, 14, 'san juan cotzal'),
(194, 14, 'cunen'),
(195, 14, 'san andres sajcabaja'),
(196, 14, 'sacapulas'),
(197, 14, 'canilla'),
(198, 14, 'san pedro jocopilas'),
(199, 14, 'san bartolome jocotenango'),
(200, 14, 'zacualpa'),
(201, 14, 'san antonio ilotenango'),
(202, 14, 'santa cruz del quiche'),
(203, 14, 'joyabaj'),
(204, 14, 'chinique'),
(205, 14, 'chiche'),
(206, 14, 'patzite'),
(207, 14, 'chichicastenango'),
(208, 14, 'pachalum'),
(209, 15, 'nuevo san carlos'),
(210, 15, 'san felipe retalhuleu'),
(211, 15, 'el asintal'),
(212, 15, 'san andres villa seca'),
(213, 15, 'san martin zapotitlan'),
(214, 15, 'santa cruz mulua'),
(215, 15, 'san sebastian'),
(216, 15, 'retalhuleu'),
(217, 15, 'champerico'),
(218, 16, 'sumpango'),
(219, 16, 'santo domingo xenacoj'),
(220, 16, 'santiago sacatepequez'),
(221, 16, 'pastores'),
(222, 16, 'san lucas sacatepequez'),
(223, 16, 'san bartolome milpas altas'),
(224, 16, 'antigua guatemala'),
(225, 16, 'jocotenango'),
(226, 16, 'santa lucia milpas altas'),
(227, 16, 'santa catarina barahona'),
(228, 16, 'san antonio aguas calientes'),
(229, 16, 'san miguel dueñas'),
(230, 16, 'magdalena milpas altas'),
(231, 16, 'ciudad vieja'),
(232, 16, 'santa maria de jesus'),
(233, 16, 'alotenango'),
(234, 17, 'tacana'),
(235, 17, 'concepcion tutuapa'),
(236, 17, 'san miguel ixtahuacan'),
(237, 17, 'san jose ojetenam'),
(238, 17, 'sipacapa'),
(239, 17, 'tejutla'),
(240, 17, 'comitancillo'),
(241, 17, 'ixchiguan'),
(242, 17, 'sibinal'),
(243, 17, 'tajumulco'),
(244, 17, 'rio blanco'),
(245, 17, 'san marcos'),
(246, 17, 'san lorenzo'),
(247, 17, 'san pablo'),
(248, 17, 'malacatan'),
(249, 17, 'san pedro sacatepequez'),
(250, 17, 'san antonio sacatepequez'),
(251, 17, 'san rafael pie de la cuesta'),
(252, 17, 'esquipulas palo gordo'),
(253, 17, 'el rodeo'),
(254, 17, 'san cristobal cucho'),
(255, 17, 'el tumbador'),
(256, 17, 'nuevo progreso'),
(257, 17, 'catarina'),
(258, 17, 'la reforma'),
(259, 17, 'el quetzal'),
(260, 17, 'pajapita'),
(261, 17, 'ayutla'),
(262, 17, 'ocos'),
(263, 18, 'santa rosa de lima'),
(264, 18, 'san rafael las flores'),
(265, 18, 'casillas'),
(266, 18, 'nueva santa rosa'),
(267, 18, 'santa cruz naranjo'),
(268, 18, 'barberena'),
(269, 18, 'cuilapa'),
(270, 18, 'pueblo nuevo viñas'),
(271, 18, 'oratorio'),
(272, 18, 'santa maria ixhuatan'),
(273, 18, 'taxisco'),
(274, 18, 'chiquimulilla'),
(275, 18, 'guazacapan'),
(276, 18, 'san juan tecuaco'),
(277, 19, 'solola'),
(278, 19, 'nahuala'),
(279, 19, 'santa catarina ixtahuacan'),
(280, 19, 'santa lucia utatlan'),
(281, 19, 'san andres semetabaj'),
(282, 19, 'concepcion'),
(283, 19, 'san jose chacaya'),
(284, 19, 'panajachel'),
(285, 19, 'santa cruz la laguna'),
(286, 19, 'san marcos la laguna'),
(287, 19, 'san pablo la laguna'),
(288, 19, 'santa clara la laguna'),
(289, 19, 'santa catarina palapo'),
(290, 19, 'santa maria visitacion'),
(291, 19, 'san juan la laguna'),
(292, 19, 'san antonio palapo'),
(293, 19, 'san pedro la laguna'),
(294, 19, 'santiago atitlan'),
(295, 19, 'san lucas toliman'),
(296, 20, 'pueblo nuevo'),
(297, 20, 'san francisco zapotitlan'),
(298, 20, 'zunilito'),
(299, 20, 'chicacao'),
(300, 20, 'santo tomas la union'),
(301, 20, 'san pablo jocopila'),
(302, 20, 'cuyotenango'),
(303, 20, 'samayac'),
(304, 20, 'mazatenango'),
(305, 20, 'santa barbara'),
(306, 20, 'san antonio suchitepequez'),
(307, 20, 'patulul'),
(308, 20, 'san bernandino'),
(309, 20, 'san miguel panan'),
(310, 20, 'san gabriel'),
(311, 20, 'santo domingo suchitepequez'),
(312, 20, 'san lorenzo'),
(313, 20, 'san jose el idolo'),
(314, 20, 'rio bravo'),
(315, 20, 'san juan bautista'),
(316, 21, 'momostenango'),
(317, 21, 'santa lucia la reforma'),
(318, 21, 'san bartolo aguas calientes'),
(319, 21, 'santa maria chiquimula'),
(320, 21, 'san francisco el alto'),
(321, 21, 'san cristobal totonicapan'),
(322, 21, 'totonicapan'),
(323, 21, 'san andres xecul'),
(324, 22, 'gualan'),
(325, 22, 'rio hondo'),
(326, 22, 'teculutan'),
(327, 22, 'zacapa'),
(328, 22, 'usumatlan'),
(329, 22, 'estanzuela'),
(330, 22, 'la union'),
(331, 22, 'huite'),
(332, 22, 'cabañas'),
(333, 22, 'san diego');

-- --------------------------------------------------------

--
-- Table structure for table `pais`
--

CREATE TABLE IF NOT EXISTS `pais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `pais`
--

INSERT INTO `pais` (`id`, `nombre`) VALUES
(3, 'El Salvador'),
(1, 'guatemala');

-- --------------------------------------------------------

--
-- Table structure for table `rol`
--

CREATE TABLE IF NOT EXISTS `rol` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `descripcion_UNIQUE` (`descripcion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `rol`
--

INSERT INTO `rol` (`id`, `descripcion`) VALUES
(1, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_pago`
--

CREATE TABLE IF NOT EXISTS `tipo_pago` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tipo_pago`
--

INSERT INTO `tipo_pago` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Efectivo', ''),
(3, 'Cheque', ''),
(4, 'Tarjeta de credito', ''),
(5, 'Tarjeta de debito', '');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rol_id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`),
  KEY `fk_usuarios_rol1` (`rol_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `rol_id`, `nombre`, `password`) VALUES
(1, 1, 'admin', 'admin'),
(5, 1, 'ddt', 'admindt');

-- --------------------------------------------------------

--
-- Table structure for table `viaje`
--

CREATE TABLE IF NOT EXISTS `viaje` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `fecha_salida` date NOT NULL,
  `hora_salida` time NOT NULL,
  `fecha_regreso` date NOT NULL,
  `hora_regreso` time NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `viaje`
--

INSERT INTO `viaje` (`id`, `nombre`, `fecha_salida`, `hora_salida`, `fecha_regreso`, `hora_regreso`) VALUES
(1, 'viaje1 actualizado', '2013-11-28', '08:00:00', '2013-11-29', '22:00:00'),
(2, 'viaje2', '2013-11-21', '00:00:00', '2013-11-24', '12:00:00'),
(4, 'viaje3', '2013-11-21', '06:00:00', '2013-11-24', '00:00:00'),
(5, 'viaje5', '2013-11-21', '06:00:00', '2013-11-24', '00:00:00'),
(9, 'prueba creacion 1', '2013-11-30', '07:00:00', '2013-12-09', '06:00:00'),
(10, 'prueba 2', '2013-11-22', '08:00:00', '2013-11-27', '04:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `viaje_actividad`
--

CREATE TABLE IF NOT EXISTS `viaje_actividad` (
  `viaje_id` int(11) NOT NULL,
  `actividad_id` int(11) NOT NULL,
  PRIMARY KEY (`viaje_id`,`actividad_id`),
  KEY `fk_viaje_has_actividad_actividad1` (`actividad_id`),
  KEY `fk_viaje_has_actividad_viaje1` (`viaje_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `viaje_actividad`
--

INSERT INTO `viaje_actividad` (`viaje_id`, `actividad_id`) VALUES
(1, 1),
(4, 1),
(5, 1),
(1, 2),
(4, 2),
(5, 2),
(1, 3),
(4, 3),
(5, 3),
(9, 3),
(1, 4),
(5, 4),
(1, 5),
(5, 5),
(1, 6),
(5, 6),
(1, 7),
(5, 7),
(5, 8),
(1, 9),
(5, 9),
(1, 11),
(1, 13),
(1, 15),
(1, 17),
(1, 20);

-- --------------------------------------------------------

--
-- Table structure for table `viaje_destino`
--

CREATE TABLE IF NOT EXISTS `viaje_destino` (
  `viaje_id` int(11) NOT NULL,
  `destino_id` int(11) NOT NULL,
  PRIMARY KEY (`viaje_id`,`destino_id`),
  KEY `fk_viaje_has_destino_destino1` (`destino_id`),
  KEY `fk_viaje_has_destino_viaje1` (`viaje_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `viaje_destino`
--

INSERT INTO `viaje_destino` (`viaje_id`, `destino_id`) VALUES
(1, 2),
(4, 2),
(5, 2),
(9, 2),
(1, 3),
(4, 3),
(5, 3);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `actividad_logro`
--
ALTER TABLE `actividad_logro`
  ADD CONSTRAINT `fk_actividad_has_logro_actividad1` FOREIGN KEY (`actividad_id`) REFERENCES `actividad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_actividad_has_logro_logro1` FOREIGN KEY (`logro_id`) REFERENCES `logro` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `alquiler`
--
ALTER TABLE `alquiler`
  ADD CONSTRAINT `cliente_id` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `alquiler_equipo`
--
ALTER TABLE `alquiler_equipo`
  ADD CONSTRAINT `alquiler_equipo_alquiler_fk` FOREIGN KEY (`alquiler_id`) REFERENCES `alquiler` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `alquiler_equipo_equipo_fk` FOREIGN KEY (`equipo_id`) REFERENCES `equipo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `fk_clientes_departamento1` FOREIGN KEY (`departamento_id`) REFERENCES `departamento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_clientes_municipio1` FOREIGN KEY (`municipio_id`) REFERENCES `municipio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_clientes_paises1` FOREIGN KEY (`pais_id`) REFERENCES `pais` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `cliente_logro`
--
ALTER TABLE `cliente_logro`
  ADD CONSTRAINT `fk_cliente_has_logro_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cliente_has_logro_logro1` FOREIGN KEY (`logro_id`) REFERENCES `logro` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `cliente_viaje`
--
ALTER TABLE `cliente_viaje`
  ADD CONSTRAINT `fk_cliente_has_viaje_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cliente_has_viaje_viaje1` FOREIGN KEY (`viaje_id`) REFERENCES `viaje` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `cuenta`
--
ALTER TABLE `cuenta`
  ADD CONSTRAINT `cuenta_alquiler_fk` FOREIGN KEY (`alquiler_id`) REFERENCES `alquiler` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `cuenta_cliente_fk` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `cuenta_tipo_de_pago_fk` FOREIGN KEY (`tipo_de_pago_id`) REFERENCES `tipo_pago` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `cuenta_viaje_fk` FOREIGN KEY (`viaje_id`) REFERENCES `viaje` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `departamento`
--
ALTER TABLE `departamento`
  ADD CONSTRAINT `fk_departamento_paises1` FOREIGN KEY (`pais_id`) REFERENCES `pais` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `destino`
--
ALTER TABLE `destino`
  ADD CONSTRAINT `fk_destino_departamento1` FOREIGN KEY (`departamento_id`) REFERENCES `departamento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_destino_municipio1` FOREIGN KEY (`municipio_id`) REFERENCES `municipio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_destino_pais1` FOREIGN KEY (`pais_id`) REFERENCES `pais` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `guia`
--
ALTER TABLE `guia`
  ADD CONSTRAINT `fk_guia_categoria1` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_guia_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `guia_viaje`
--
ALTER TABLE `guia_viaje`
  ADD CONSTRAINT `fk_guia_has_viaje_guia1` FOREIGN KEY (`guia_id`) REFERENCES `guia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_guia_has_viaje_viaje1` FOREIGN KEY (`viaje_id`) REFERENCES `viaje` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `municipio`
--
ALTER TABLE `municipio`
  ADD CONSTRAINT `fk_municipio_departamento1` FOREIGN KEY (`departamento_id`) REFERENCES `departamento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuarios_rol1` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `viaje_actividad`
--
ALTER TABLE `viaje_actividad`
  ADD CONSTRAINT `fk_viaje_has_actividad_actividad1` FOREIGN KEY (`actividad_id`) REFERENCES `actividad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_viaje_has_actividad_viaje1` FOREIGN KEY (`viaje_id`) REFERENCES `viaje` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `viaje_destino`
--
ALTER TABLE `viaje_destino`
  ADD CONSTRAINT `fk_viaje_has_destino_destino1` FOREIGN KEY (`destino_id`) REFERENCES `destino` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_viaje_has_destino_viaje1` FOREIGN KEY (`viaje_id`) REFERENCES `viaje` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
