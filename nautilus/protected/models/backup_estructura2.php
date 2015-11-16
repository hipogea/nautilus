-- phpMyAdmin SQL Dump
-- version 4.3.8
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 19-02-2015 a las 07:27:17
-- Versión del servidor: 5.5.40-36.1
-- Versión de PHP: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `neologys_razzo`
--
CREATE DATABASE IF NOT EXISTS `neologys_razzo` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `neologys_razzo`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ActiveRecordLog`
--

DROP TABLE IF EXISTS `ActiveRecordLog`;
CREATE TABLE IF NOT EXISTS `ActiveRecordLog` (
`id` int(10) unsigned NOT NULL,
`description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
`action` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
`model` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
`idModel` int(10) unsigned DEFAULT NULL,
`field` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
`creationdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
`userid` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
`idModelReal` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
`oldvalue` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
`newvalue` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
`nombrecampo` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=42631 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacendocs`
--

DROP TABLE IF EXISTS `almacendocs`;
CREATE TABLE IF NOT EXISTS `almacendocs` (
`fechavale` date DEFAULT NULL,
`creadopor` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
`modificadopor` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
`creadoel` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
`modificadoel` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
`codmovimiento` char(2) COLLATE utf8_unicode_ci DEFAULT NULL,
`numvale` char(12) COLLATE utf8_unicode_ci DEFAULT NULL,
`codtipovale` char(2) COLLATE utf8_unicode_ci DEFAULT NULL,
`codtrabajador` char(4) COLLATE utf8_unicode_ci DEFAULT NULL,
`codalmacen` char(3) COLLATE utf8_unicode_ci DEFAULT NULL,
`codcentro` char(4) COLLATE utf8_unicode_ci DEFAULT NULL,
`cestadovale` char(2) COLLATE utf8_unicode_ci DEFAULT NULL,
`codocu` char(3) COLLATE utf8_unicode_ci DEFAULT NULL,
`fechacont` date DEFAULT NULL,
`fechacre` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
`numdocref` char(15) COLLATE utf8_unicode_ci DEFAULT NULL,
`posic` char(3) COLLATE utf8_unicode_ci DEFAULT NULL,
`codocuref` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
`id` bigint(20) NOT NULL,
`correlativo` bigint(20) DEFAULT NULL,
`textolargo` text COLLATE utf8_unicode_ci,
`codaldestino` char(3) COLLATE utf8_unicode_ci DEFAULT NULL,
`codcendestino` char(4) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cruge_authassignment`
--

DROP TABLE IF EXISTS `cruge_authassignment`;
CREATE TABLE IF NOT EXISTS `cruge_authassignment` (
`userid` int(11) NOT NULL,
`bizrule` text COLLATE utf8_unicode_ci,
`data` text COLLATE utf8_unicode_ci,
`itemname` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cruge_authitem`
--

DROP TABLE IF EXISTS `cruge_authitem`;
CREATE TABLE IF NOT EXISTS `cruge_authitem` (
`name` varchar(64) CHARACTER SET utf8 NOT NULL,
`type` int(11) NOT NULL,
`description` longtext CHARACTER SET utf8,
`bizrule` longtext CHARACTER SET utf8,
`data` longtext CHARACTER SET utf8
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cruge_authitemchild`
--

DROP TABLE IF EXISTS `cruge_authitemchild`;
CREATE TABLE IF NOT EXISTS `cruge_authitemchild` (
`parent` varchar(64) CHARACTER SET utf8 NOT NULL,
`child` varchar(64) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cruge_field`
--

DROP TABLE IF EXISTS `cruge_field`;
CREATE TABLE IF NOT EXISTS `cruge_field` (
`idfield` int(11) NOT NULL,
`fieldname` varchar(20) CHARACTER SET utf8 NOT NULL,
`longname` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
`position` int(11) DEFAULT NULL,
`required` int(11) DEFAULT NULL,
`fieldtype` int(11) DEFAULT NULL,
`fieldsize` int(11) DEFAULT NULL,
`maxlength` int(11) DEFAULT NULL,
`showinreports` int(11) DEFAULT NULL,
`useregexp` text CHARACTER SET utf8,
`useregexpmsg` text CHARACTER SET utf8,
`predetvalue` text CHARACTER SET utf8
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cruge_fieldvalue`
--

DROP TABLE IF EXISTS `cruge_fieldvalue`;
CREATE TABLE IF NOT EXISTS `cruge_fieldvalue` (
`idfieldvalue` int(11) NOT NULL,
`iduser` int(11) NOT NULL,
`idfield` int(11) NOT NULL,
`value` text CHARACTER SET utf8
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cruge_session`
--

DROP TABLE IF EXISTS `cruge_session`;
CREATE TABLE IF NOT EXISTS `cruge_session` (
`idsession` int(11) NOT NULL,
`iduser` int(11) NOT NULL,
`created` bigint(20) DEFAULT NULL,
`expire` bigint(20) DEFAULT NULL,
`status` int(11) DEFAULT NULL,
`ipaddress` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
`usagecount` int(11) DEFAULT NULL,
`lastusage` bigint(20) DEFAULT NULL,
`logoutdate` bigint(20) DEFAULT NULL,
`ipaddressout` varchar(45) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=415 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cruge_system`
--

DROP TABLE IF EXISTS `cruge_system`;
CREATE TABLE IF NOT EXISTS `cruge_system` (
`idsystem` int(11) NOT NULL,
`name` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
`largename` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
`sessionmaxdurationmins` int(11) DEFAULT NULL,
`sessionmaxsameipconnections` int(11) DEFAULT NULL,
`sessionreusesessions` int(11) DEFAULT NULL,
`sessionmaxsessionsperday` int(11) DEFAULT NULL,
`sessionmaxsessionsperuser` int(11) DEFAULT NULL,
`systemnonewsessions` int(11) DEFAULT NULL,
`systemdown` int(11) DEFAULT NULL,
`registerusingcaptcha` int(11) DEFAULT NULL,
`registerusingterms` int(11) DEFAULT NULL,
`terms` text CHARACTER SET utf8,
`registerusingactivation` int(11) DEFAULT NULL,
`defaultroleforregistration` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
`registerusingtermslabel` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
`registrationonlogin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cruge_user`
--

DROP TABLE IF EXISTS `cruge_user`;
CREATE TABLE IF NOT EXISTS `cruge_user` (
`iduser` int(11) NOT NULL,
`regdate` bigint(20) DEFAULT NULL,
`actdate` bigint(20) DEFAULT NULL,
`logondate` bigint(20) DEFAULT NULL,
`username` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
`email` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
`password` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
`authkey` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
`state` int(11) DEFAULT NULL,
`totalsessioncounter` int(11) DEFAULT NULL,
`currentsessioncounter` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gallery`
--

DROP TABLE IF EXISTS `gallery`;
CREATE TABLE IF NOT EXISTS `gallery` (
`id` int(11) NOT NULL,
`versions_data` text COLLATE utf8_unicode_ci NOT NULL,
`name` tinyint(1) NOT NULL DEFAULT '1',
`description` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gallery_photo`
--

DROP TABLE IF EXISTS `gallery_photo`;
CREATE TABLE IF NOT EXISTS `gallery_photo` (
`id` int(11) NOT NULL,
`gallery_id` int(11) NOT NULL,
`rank` int(11) NOT NULL DEFAULT '0',
`name` varchar(512) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
`description` text COLLATE utf8_unicode_ci,
`file_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_aceites`
--

DROP TABLE IF EXISTS `public_aceites`;
CREATE TABLE IF NOT EXISTS `public_aceites` (
`nombre` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
`marca` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`prop1` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`comaterial` varchar(8) CHARACTER SET utf8 NOT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_acoplados`
--

DROP TABLE IF EXISTS `public_acoplados`;
CREATE TABLE IF NOT EXISTS `public_acoplados` (
`codacople` varchar(1) CHARACTER SET utf8 NOT NULL,
`acople` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_activos`
--

DROP TABLE IF EXISTS `public_activos`;
CREATE TABLE IF NOT EXISTS `public_activos` (
`idactivo` bigint(20) NOT NULL,
`idempla` bigint(20) DEFAULT NULL,
`codigoaf` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
`descripcionaf` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
`serie` varchar(18) CHARACTER SET utf8 DEFAULT NULL,
`arreglo` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`codigo` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`texto` longtext CHARACTER SET utf8,
`barra` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`tipomaquina` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`dimensiones` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
`codestado` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`marca` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modelo` varchar(22) CHARACTER SET utf8 DEFAULT NULL,
`capacidad` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`observaciones` longtext CHARACTER SET utf8,
`idinventario` bigint(20) DEFAULT NULL,
`barpadre` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`sociedad` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`foto` longblob,
`tienecarter` smallint(6) DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`codubi` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
`exempla` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
`codcen` varchar(4) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_albums`
--

DROP TABLE IF EXISTS `public_albums`;
CREATE TABLE IF NOT EXISTS `public_albums` (
`id` int(11) NOT NULL,
`pid` int(11) NOT NULL,
`url` longtext CHARACTER SET utf8 NOT NULL,
`translations` longtext CHARACTER SET utf8 NOT NULL,
`imgsorder` longtext CHARACTER SET utf8 NOT NULL,
`imgsinfo` longtext CHARACTER SET utf8 NOT NULL,
`cover` text CHARACTER SET utf8 NOT NULL,
`iteminfoshop` longtext CHARACTER SET utf8 NOT NULL,
`author` varchar(128) CHARACTER SET utf8 NOT NULL,
`tags` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_alconversiones`
--

DROP TABLE IF EXISTS `public_alconversiones`;
CREATE TABLE IF NOT EXISTS `public_alconversiones` (
`id` int(11) NOT NULL,
`um1` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`um2` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`numerador` double DEFAULT NULL,
`denominador` double DEFAULT NULL,
`codart` varchar(8) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_alentregas`
--

DROP TABLE IF EXISTS `public_alentregas`;
CREATE TABLE IF NOT EXISTS `public_alentregas` (
`id` bigint(20) NOT NULL,
`iddetcompra` bigint(20) DEFAULT NULL,
`cant` double DEFAULT NULL,
`fecha` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`idkardex` bigint(20) DEFAULT NULL,
`usuario` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`final` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`estado` char(2) COLLATE utf8_unicode_ci NOT NULL,
`punit` double NOT NULL,
`CODOCU` char(3) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_aliascampos`
--

DROP TABLE IF EXISTS `public_aliascampos`;
CREATE TABLE IF NOT EXISTS `public_aliascampos` (
`alias` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
`ordenbusqueda` int(11) DEFAULT NULL,
`nombrecampo` varchar(30) CHARACTER SET utf8 NOT NULL,
`nombretabla` varchar(30) CHARACTER SET utf8 NOT NULL,
`esclave` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`pordefecto` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_alinventario`
--

DROP TABLE IF EXISTS `public_alinventario`;
CREATE TABLE IF NOT EXISTS `public_alinventario` (
`codalm` varchar(3) CHARACTER SET utf8 NOT NULL,
`creadopor` longtext CHARACTER SET utf8,
`creadoel` longtext CHARACTER SET utf8,
`modificadopor` longtext CHARACTER SET utf8,
`modificadoel` longtext CHARACTER SET utf8,
`fechainicio` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`fechafin` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`periodocontable` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`codresponsable` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`codart` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`codcen` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`cantlibre` double DEFAULT NULL,
`canttran` double DEFAULT NULL,
`cantres` double DEFAULT NULL,
`ubicacion` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`lote` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`siid` bigint(20) DEFAULT NULL,
`ssiduser` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`punit` double DEFAULT NULL,
`punitdif` double NOT NULL DEFAULT '0',
`codmon` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`id` bigint(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=390256 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_alkardex`
--

DROP TABLE IF EXISTS `public_alkardex`;
CREATE TABLE IF NOT EXISTS `public_alkardex` (
`codart` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`codmov` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`cant` double DEFAULT NULL,
`alemi` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`aldes` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`fecha` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`coddoc` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`numdoc` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
`usuario` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`um` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`comentario` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`codocuref` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`numdocref` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
`codcentro` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`id` bigint(20) NOT NULL,
`codestado` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`prefijo` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`fechadoc` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`correlativo` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
`numkardex` varchar(14) CHARACTER SET utf8 DEFAULT NULL,
`solicitante` varchar(18) CHARACTER SET utf8 DEFAULT NULL,
`hidvale` bigint(20) DEFAULT NULL,
`idref` bigint(20) DEFAULT NULL,
`lote` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`valido` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`checki` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`destino` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`preciounit` double DEFAULT NULL,
`correlativ` bigint(20) DEFAULT NULL,
`codcendes` varchar(4) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1294 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_alkardextraslado`
--

DROP TABLE IF EXISTS `public_alkardextraslado`;
CREATE TABLE IF NOT EXISTS `public_alkardextraslado` (
`id` bigint(20) NOT NULL,
`hidkardexemi` bigint(20) NOT NULL,
`cant` double NOT NULL,
`hidkardexdes` bigint(20) NOT NULL,
`codestado` char(2) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_almacendocdet`
--

DROP TABLE IF EXISTS `public_almacendocdet`;
CREATE TABLE IF NOT EXISTS `public_almacendocdet` (
`id` int(11) NOT NULL,
`hidvale` bigint(20) NOT NULL,
`cant` double DEFAULT NULL,
`um` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`codvalematerial` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`numdoc` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`codestado` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`codocu` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`fecha` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`creadopor` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_almacendocs`
--

DROP TABLE IF EXISTS `public_almacendocs`;
CREATE TABLE IF NOT EXISTS `public_almacendocs` (
`fechavale` date DEFAULT NULL,
`creadopor` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
`modificadopor` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
`creadoel` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
`modificadoel` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
`codmovimiento` char(2) COLLATE utf8_unicode_ci DEFAULT NULL,
`numvale` char(12) COLLATE utf8_unicode_ci DEFAULT NULL,
`codtipovale` char(2) COLLATE utf8_unicode_ci DEFAULT NULL,
`codtrabajador` char(4) COLLATE utf8_unicode_ci DEFAULT NULL,
`codalmacen` char(3) COLLATE utf8_unicode_ci DEFAULT NULL,
`codcentro` char(4) COLLATE utf8_unicode_ci DEFAULT NULL,
`cestadovale` char(2) COLLATE utf8_unicode_ci DEFAULT NULL,
`codocu` char(3) COLLATE utf8_unicode_ci DEFAULT NULL,
`fechacont` date DEFAULT NULL,
`fechacre` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
`numdocref` char(15) COLLATE utf8_unicode_ci DEFAULT NULL,
`posic` char(3) COLLATE utf8_unicode_ci DEFAULT NULL,
`codocuref` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
`id` bigint(20) NOT NULL,
`correlativo` bigint(20) DEFAULT NULL,
`textolargo` text COLLATE utf8_unicode_ci,
`codaldestino` char(3) COLLATE utf8_unicode_ci DEFAULT NULL,
`codcendestino` char(4) COLLATE utf8_unicode_ci DEFAULT NULL,
`codsociedad` char(1) COLLATE utf8_unicode_ci NOT NULL,
`ceco` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=380 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_almacenes`
--

DROP TABLE IF EXISTS `public_almacenes`;
CREATE TABLE IF NOT EXISTS `public_almacenes` (
`codalm` varchar(3) CHARACTER SET utf8 NOT NULL,
`nomal` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`desalm` longtext CHARACTER SET utf8,
`tipo` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`codcen` varchar(4) CHARACTER SET utf8 NOT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`codsoc` varchar(1) CHARACTER SET utf8 NOT NULL,
`tipovaloracion` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`estructura` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
`id` int(11) NOT NULL,
`hiddirec` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_almacenkardex`
--

DROP TABLE IF EXISTS `public_almacenkardex`;
CREATE TABLE IF NOT EXISTS `public_almacenkardex` (
`codart` varchar(8) CHARACTER SET utf8 NOT NULL,
`fechamov` char(19) COLLATE utf8_unicode_ci NOT NULL,
`cantmov` double NOT NULL,
`refmov` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`codtransa` varchar(3) CHARACTER SET utf8 NOT NULL,
`coddocu` varchar(3) CHARACTER SET utf8 NOT NULL,
`numdoc` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
`saldo` double NOT NULL,
`idubicacion` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_almacenmovimientos`
--

DROP TABLE IF EXISTS `public_almacenmovimientos`;
CREATE TABLE IF NOT EXISTS `public_almacenmovimientos` (
`codmov` varchar(2) CHARACTER SET utf8 NOT NULL,
`movimiento` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`signo` int(11) DEFAULT NULL,
`codigo_objeto` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`ingreso` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`codocu` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`anticodmov` varchar(2) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_almacen_detalle_vale`
--

DROP TABLE IF EXISTS `public_almacen_detalle_vale`;
CREATE TABLE IF NOT EXISTS `public_almacen_detalle_vale` (
`hidvale` bigint(20) NOT NULL,
`idvaledetalle` bigint(20) NOT NULL,
`cant` double DEFAULT NULL,
`codvalematerial` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`numdoc` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`itdoc` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`estado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_almacen_inventario_detalle`
--

DROP TABLE IF EXISTS `public_almacen_inventario_detalle`;
CREATE TABLE IF NOT EXISTS `public_almacen_inventario_detalle` (
`idinvetariodetalle` bigint(20) NOT NULL,
`hidinventario` int(11) NOT NULL,
`codmaterial` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`cantidad` double DEFAULT NULL,
`valorunit` double DEFAULT NULL,
`ubicacion` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
`estadomaterial` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`estadoreserva` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`cod_objeto_reserva` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`num_objeto_reserva` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_almacen_objetos`
--

DROP TABLE IF EXISTS `public_almacen_objetos`;
CREATE TABLE IF NOT EXISTS `public_almacen_objetos` (
`codobjeto` varchar(3) CHARACTER SET utf8 NOT NULL,
`nombreobjeto` varchar(25) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_alreserva`
--

DROP TABLE IF EXISTS `public_alreserva`;
CREATE TABLE IF NOT EXISTS `public_alreserva` (
`id` bigint(20) NOT NULL,
`hidesolpe` bigint(20) DEFAULT NULL,
`estadoreserva` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`fechares` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`usuario` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`cant` double DEFAULT NULL,
`codocu` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`numreserva` int(11) NOT NULL,
`flag` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`rex` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
`atendido` char(19) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=126 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_alumnos`
--

DROP TABLE IF EXISTS `public_alumnos`;
CREATE TABLE IF NOT EXISTS `public_alumnos` (
`idalumno` int(11) NOT NULL,
`nombres` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`ap` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`edad` smallint(6) DEFAULT NULL,
`am` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`sexo` varchar(1) CHARACTER SET utf8 NOT NULL,
`dni` varchar(8) CHARACTER SET utf8 NOT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_archivador`
--

DROP TABLE IF EXISTS `public_archivador`;
CREATE TABLE IF NOT EXISTS `public_archivador` (
`id` int(11) NOT NULL,
`codocu` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`desarchivo` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`obsarchivo` longtext CHARACTER SET utf8,
`fechasubida` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`ndescargas` int(11) DEFAULT NULL,
`autor` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`nombre` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`peso` double DEFAULT NULL,
`extension` varchar(7) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_areas`
--

DROP TABLE IF EXISTS `public_areas`;
CREATE TABLE IF NOT EXISTS `public_areas` (
`codarea` varchar(3) CHARACTER SET utf8 NOT NULL,
`area` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`explica` longtext CHARACTER SET utf8,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_atencionreserva`
--

DROP TABLE IF EXISTS `public_atencionreserva`;
CREATE TABLE IF NOT EXISTS `public_atencionreserva` (
`id` bigint(20) NOT NULL,
`cant` double NOT NULL,
`hidreserva` bigint(20) NOT NULL,
`hidkardex` bigint(20) NOT NULL,
`estadoatencion` char(2) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_auditor`
--

DROP TABLE IF EXISTS `public_auditor`;
CREATE TABLE IF NOT EXISTS `public_auditor` (
`accion` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`nombreti` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`cuando` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`nivel` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`opcion` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`tabla` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`nag` smallint(6) DEFAULT NULL,
`nuevo` longtext CHARACTER SET utf8,
`anterior` longtext CHARACTER SET utf8,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_authassignment`
--

DROP TABLE IF EXISTS `public_authassignment`;
CREATE TABLE IF NOT EXISTS `public_authassignment` (
`itemname` varchar(64) CHARACTER SET utf8 NOT NULL,
`userid` varchar(64) CHARACTER SET utf8 NOT NULL,
`bizrule` longtext CHARACTER SET utf8,
`data` longtext CHARACTER SET utf8
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_authitem`
--

DROP TABLE IF EXISTS `public_authitem`;
CREATE TABLE IF NOT EXISTS `public_authitem` (
`name` varchar(64) CHARACTER SET utf8 NOT NULL,
`type` int(11) NOT NULL,
`description` longtext CHARACTER SET utf8,
`bizrule` longtext CHARACTER SET utf8,
`data` longtext CHARACTER SET utf8
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_autorizacion_personal`
--

DROP TABLE IF EXISTS `public_autorizacion_personal`;
CREATE TABLE IF NOT EXISTS `public_autorizacion_personal` (
`idpermiso` bigint(20) NOT NULL,
`numero` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`codep` varchar(3) CHARACTER SET utf8 NOT NULL,
`codpro` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`fechain` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`fechafin` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`detalle` longtext CHARACTER SET utf8,
`fecha` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`vbjefe` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`bvresponsable` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_autorizacion_personal_detalle`
--

DROP TABLE IF EXISTS `public_autorizacion_personal_detalle`;
CREATE TABLE IF NOT EXISTS `public_autorizacion_personal_detalle` (
`idaut` bigint(20) NOT NULL,
`hidaut` bigint(20) DEFAULT NULL,
`idpersona` int(11) DEFAULT NULL,
`item` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`vb` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_bandeja`
--

DROP TABLE IF EXISTS `public_bandeja`;
CREATE TABLE IF NOT EXISTS `public_bandeja` (
`coddocu` varchar(3) CHARACTER SET utf8 NOT NULL,
`usuario` varchar(35) CHARACTER SET utf8 NOT NULL,
`numdocu` varchar(12) CHARACTER SET utf8 NOT NULL,
`c_serie` varchar(3) CHARACTER SET utf8 NOT NULL,
`fechapuesta` char(19) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_bloqueos`
--

DROP TABLE IF EXISTS `public_bloqueos`;
CREATE TABLE IF NOT EXISTS `public_bloqueos` (
`id` bigint(20) NOT NULL,
`codocu` char(3) COLLATE utf8_unicode_ci NOT NULL,
`iduser` int(11) NOT NULL,
`fechabloqueo` datetime NOT NULL,
`iddocu` bigint(20) NOT NULL,
`ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
`idsesion` bigint(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=259 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_borrar`
--

DROP TABLE IF EXISTS `public_borrar`;
CREATE TABLE IF NOT EXISTS `public_borrar` (
`id` int(11) NOT NULL,
`fecha` longtext CHARACTER SET utf8
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_calificaciones`
--

DROP TABLE IF EXISTS `public_calificaciones`;
CREATE TABLE IF NOT EXISTS `public_calificaciones` (
`idcalificacion` bigint(20) NOT NULL,
`idalumno` int(11) DEFAULT NULL,
`nota` smallint(6) DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_camionetas`
--

DROP TABLE IF EXISTS `public_camionetas`;
CREATE TABLE IF NOT EXISTS `public_camionetas` (
`marca` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`placa` varchar(10) CHARACTER SET utf8 NOT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_cargos`
--

DROP TABLE IF EXISTS `public_cargos`;
CREATE TABLE IF NOT EXISTS `public_cargos` (
`codigocentro` varchar(4) CHARACTER SET utf8 NOT NULL,
`descargo` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
`m_cargo` longtext CHARACTER SET utf8,
`codjefe` varchar(4) CHARACTER SET utf8 NOT NULL,
`codentrega` varchar(4) CHARACTER SET utf8 NOT NULL,
`codrecibe` varchar(4) CHARACTER SET utf8 NOT NULL,
`fecdocumento` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`fecentrega` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`codtipocargo` varchar(2) CHARACTER SET utf8 NOT NULL,
`codigoestadocargo` varchar(2) CHARACTER SET utf8 NOT NULL,
`cnumcargo` varchar(10) CHARACTER SET utf8 NOT NULL,
`coddocucargo` varchar(3) CHARACTER SET utf8 NOT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`idcargo` bigint(20) DEFAULT NULL,
`avisarvencimiento` int(11) DEFAULT NULL,
`fechavencimiento` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`esalmacen` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_carteres`
--

DROP TABLE IF EXISTS `public_carteres`;
CREATE TABLE IF NOT EXISTS `public_carteres` (
`idequipo` int(11) DEFAULT NULL,
`capacidad` double DEFAULT NULL,
`tipoaceite` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`horascambio` int(11) DEFAULT NULL,
`tipocarter` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`haceite` int(11) DEFAULT NULL,
`hmuestra` int(11) DEFAULT NULL,
`nummuestras` int(11) DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`fulectura` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`fumuestra` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`fucambio` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`horometro` int(11) DEFAULT NULL,
`codigo` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`activo` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`hucambio` int(11) DEFAULT NULL,
`casco` int(11) DEFAULT NULL,
`id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_carteres_control`
--

DROP TABLE IF EXISTS `public_carteres_control`;
CREATE TABLE IF NOT EXISTS `public_carteres_control` (
`idcontrol` bigint(20) NOT NULL,
`idcater` int(11) DEFAULT NULL,
`fechacontrol` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`horas` int(11) DEFAULT NULL,
`tipoevento` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`numdoc` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`observacion` longtext CHARACTER SET utf8,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`idenvio` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_carteres_envios`
--

DROP TABLE IF EXISTS `public_carteres_envios`;
CREATE TABLE IF NOT EXISTS `public_carteres_envios` (
`idenvio` int(11) NOT NULL,
`idcarter` int(11) DEFAULT NULL,
`fechamuestra` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`estado` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`fecharespuesta` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`fechaenvio` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`c_numgui` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`observacion` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
`accion` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`horasmotor` int(11) DEFAULT NULL,
`horasaceite` int(11) DEFAULT NULL,
`txtobs` longtext CHARACTER SET utf8,
`numenvio` int(11) DEFAULT NULL,
`nshell` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_carteres_eventos`
--

DROP TABLE IF EXISTS `public_carteres_eventos`;
CREATE TABLE IF NOT EXISTS `public_carteres_eventos` (
`tipoevento` varchar(1) CHARACTER SET utf8 NOT NULL,
`evento` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_catvaloracion`
--

DROP TABLE IF EXISTS `public_catvaloracion`;
CREATE TABLE IF NOT EXISTS `public_catvaloracion` (
`codcatval` varchar(4) CHARACTER SET utf8 NOT NULL,
`descat` varchar(30) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_cc`
--

DROP TABLE IF EXISTS `public_cc`;
CREATE TABLE IF NOT EXISTS `public_cc` (
`codc` varchar(12) CHARACTER SET utf8 NOT NULL,
`cc` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`centro` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`desceco` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`vale` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`validodel` date DEFAULT NULL,
`validoal` date DEFAULT NULL,
`explicacion` longtext CHARACTER SET utf8,
`clasecolector` char(1) COLLATE utf8_unicode_ci NOT NULL,
`semaforopresup` char(1) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_ccgastos`
--

DROP TABLE IF EXISTS `public_ccgastos`;
CREATE TABLE IF NOT EXISTS `public_ccgastos` (
`id` int(11) NOT NULL,
`ceco` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
`fechacontable` date DEFAULT NULL,
`monto` double DEFAULT NULL,
`codmoneda` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`usuario` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`idref` bigint(20) DEFAULT NULL,
`tipo` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`ano` char(4) COLLATE utf8_unicode_ci NOT NULL,
`mes` char(2) COLLATE utf8_unicode_ci NOT NULL,
`clasecolector` char(1) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_centros`
--

DROP TABLE IF EXISTS `public_centros`;
CREATE TABLE IF NOT EXISTS `public_centros` (
`codcen` varchar(4) CHARACTER SET utf8 NOT NULL,
`codsoc` varchar(2) CHARACTER SET utf8 NOT NULL,
`nomcen` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`descricen` longtext CHARACTER SET utf8,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`n_dir` bigint(20) DEFAULT NULL,
`c_planta` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_centros_areas`
--

DROP TABLE IF EXISTS `public_centros_areas`;
CREATE TABLE IF NOT EXISTS `public_centros_areas` (
`id` int(11) NOT NULL,
`centro` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`area` varchar(2) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_choferes`
--

DROP TABLE IF EXISTS `public_choferes`;
CREATE TABLE IF NOT EXISTS `public_choferes` (
`nombre` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`brevete` varchar(10) CHARACTER SET utf8 NOT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_clases`
--

DROP TABLE IF EXISTS `public_clases`;
CREATE TABLE IF NOT EXISTS `public_clases` (
`codcla` varchar(5) CHARACTER SET utf8 NOT NULL,
`descla` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`obscla` longtext CHARACTER SET utf8,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`hija` varchar(5) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_clasesmaestro`
--

DROP TABLE IF EXISTS `public_clasesmaestro`;
CREATE TABLE IF NOT EXISTS `public_clasesmaestro` (
`codclasema` varchar(3) CHARACTER SET utf8 NOT NULL,
`nomclase` varchar(35) CHARACTER SET utf8 NOT NULL,
`creadopor` longtext CHARACTER SET utf8,
`modificadopor` longtext CHARACTER SET utf8,
`creadoel` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(30) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_claves`
--

DROP TABLE IF EXISTS `public_claves`;
CREATE TABLE IF NOT EXISTS `public_claves` (
`claves` varchar(1) CHARACTER SET utf8 NOT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_clipro`
--

DROP TABLE IF EXISTS `public_clipro`;
CREATE TABLE IF NOT EXISTS `public_clipro` (
`codpro` varchar(6) CHARACTER SET utf8 NOT NULL,
`despro` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
`rucpro` varchar(11) CHARACTER SET utf8 NOT NULL,
`telpro` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`emailpro` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
`tipo` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` longtext CHARACTER SET utf8,
`modificadopor` longtext CHARACTER SET utf8,
`creadoel` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`socio` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`correlativo` int(11) NOT NULL,
`prefijo` char(2) COLLATE utf8_unicode_ci NOT NULL,
`codocu` char(2) COLLATE utf8_unicode_ci NOT NULL,
`nombrecomercial` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_cnf_busquedas`
--

DROP TABLE IF EXISTS `public_cnf_busquedas`;
CREATE TABLE IF NOT EXISTS `public_cnf_busquedas` (
`idbusqueda` int(11) NOT NULL,
`nombre` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
`sqlbusqueda` longtext CHARACTER SET utf8,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_cnf_d_busquedas`
--

DROP TABLE IF EXISTS `public_cnf_d_busquedas`;
CREATE TABLE IF NOT EXISTS `public_cnf_d_busquedas` (
`idbusqueda` int(11) NOT NULL,
`aliascampo` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`nombrecampo` varchar(40) CHARACTER SET utf8 NOT NULL,
`idgrupo` smallint(6) DEFAULT NULL,
`activo` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`longitudcampo` smallint(6) DEFAULT NULL,
`id` int(11) NOT NULL,
`tipocampo` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`visible` smallint(6) DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_cnf_patrones`
--

DROP TABLE IF EXISTS `public_cnf_patrones`;
CREATE TABLE IF NOT EXISTS `public_cnf_patrones` (
`elemento` varchar(8) CHARACTER SET utf8 NOT NULL,
`longitud` int(11) NOT NULL,
`patron` varchar(120) CHARACTER SET utf8 DEFAULT NULL,
`descri` longtext CHARACTER SET utf8
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_collections`
--

DROP TABLE IF EXISTS `public_collections`;
CREATE TABLE IF NOT EXISTS `public_collections` (
`id` int(11) NOT NULL,
`pid` int(11) NOT NULL,
`url` longtext CHARACTER SET utf8 NOT NULL,
`translations` longtext CHARACTER SET utf8 NOT NULL,
`albums` varchar(128) CHARACTER SET utf8 NOT NULL,
`author` varchar(128) CHARACTER SET utf8 NOT NULL,
`tags` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_confcorreo`
--

DROP TABLE IF EXISTS `public_confcorreo`;
CREATE TABLE IF NOT EXISTS `public_confcorreo` (
`parametro` varchar(120) CHARACTER SET utf8 NOT NULL,
`valores` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
`orden` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_conformidades`
--

DROP TABLE IF EXISTS `public_conformidades`;
CREATE TABLE IF NOT EXISTS `public_conformidades` (
`idconfomidad` bigint(20) NOT NULL,
`iddetallecoti` bigint(20) NOT NULL,
`iddetallecoti_d` bigint(20) NOT NULL,
`fraccion` double NOT NULL,
`fechacreacion` char(19) COLLATE utf8_unicode_ci NOT NULL,
`monto` double NOT NULL,
`numerodocumento` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`coddocu` varchar(3) CHARACTER SET utf8 NOT NULL,
`creado` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificado` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`final` int(11) NOT NULL,
`atendido` int(11) NOT NULL,
`cotizacion` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`itemcot` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`fecha` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`codestado` varchar(2) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_contactos`
--

DROP TABLE IF EXISTS `public_contactos`;
CREATE TABLE IF NOT EXISTS `public_contactos` (
`c_hcod` varchar(6) CHARACTER SET utf8 NOT NULL,
`c_nombre` varchar(30) CHARACTER SET utf8 NOT NULL,
`c_cargo` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`c_tel` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`c_mail` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`correlativo` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`fecnacimiento` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`calificacion` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_controlactivos`
--

DROP TABLE IF EXISTS `public_controlactivos`;
CREATE TABLE IF NOT EXISTS `public_controlactivos` (
`idactivo` bigint(20) DEFAULT NULL,
`tipo` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`guiaremision` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`numerofactura` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`fecha` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`idemplazamientoactual` bigint(20) DEFAULT NULL,
`idemplazamientoanterior` bigint(20) DEFAULT NULL,
`codobraencurso` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
`ccanterior` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`ccactual` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`comentario` longtext CHARACTER SET utf8,
`numformato` varchar(17) CHARACTER SET utf8 DEFAULT NULL,
`codestado` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`almacen` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`valesalida` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`ocompra` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`coddocu` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`codepanterior` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`codep` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`codlugaranterior` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`codlugarnuevo` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`codcentro` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`solicitante` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`documento` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`numeroref` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`idformato` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_controlactivosemplazamientos`
--

DROP TABLE IF EXISTS `public_controlactivosemplazamientos`;
CREATE TABLE IF NOT EXISTS `public_controlactivosemplazamientos` (
`codtipo` varchar(1) CHARACTER SET utf8 NOT NULL,
`idemplaanterior` bigint(20) DEFAULT NULL,
`idemplaactual` bigint(20) DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_cont_categoriasvalor`
--

DROP TABLE IF EXISTS `public_cont_categoriasvalor`;
CREATE TABLE IF NOT EXISTS `public_cont_categoriasvalor` (
`id` int(11) NOT NULL,
`descat` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`sociedad` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`codcat` varchar(4) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_cont_determcuentas`
--

DROP TABLE IF EXISTS `public_cont_determcuentas`;
CREATE TABLE IF NOT EXISTS `public_cont_determcuentas` (
`id` int(11) NOT NULL,
`catval` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`operacion` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`cuentalm` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`cuentalmcontra` varchar(35) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_coordocs`
--

DROP TABLE IF EXISTS `public_coordocs`;
CREATE TABLE IF NOT EXISTS `public_coordocs` (
`id` int(11) NOT NULL,
`xgeneral` int(5) NOT NULL,
`ygeneral` int(5) NOT NULL,
`xlogo` int(5) NOT NULL,
`ylogo` int(11) NOT NULL,
`codocu` char(3) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_coti`
--

DROP TABLE IF EXISTS `public_coti`;
CREATE TABLE IF NOT EXISTS `public_coti` (
`numcot` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`codpro` varchar(6) CHARACTER SET utf8 NOT NULL,
`fecdoc` char(19) COLLATE utf8_unicode_ci NOT NULL,
`codcon` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`codestado` varchar(2) CHARACTER SET utf8 NOT NULL,
`texto` varchar(40) CHARACTER SET utf8 NOT NULL,
`textolargo` longtext CHARACTER SET utf8,
`tipologia` varchar(1) CHARACTER SET utf8 NOT NULL,
`moneda` varchar(3) CHARACTER SET utf8 NOT NULL,
`orcli` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
`descuento` smallint(6) NOT NULL,
`usuario` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`coddocu` varchar(3) CHARACTER SET utf8 NOT NULL,
`creado` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificado` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`codtipofac` varchar(2) CHARACTER SET utf8 NOT NULL,
`codsociedad` varchar(1) CHARACTER SET utf8 NOT NULL,
`codgrupoventas` varchar(3) CHARACTER SET utf8 NOT NULL,
`codtipocotizacion` varchar(1) CHARACTER SET utf8 NOT NULL,
`validez` int(11) NOT NULL,
`codcentro` varchar(4) CHARACTER SET utf8 NOT NULL,
`nigv` double NOT NULL,
`codobjeto` varchar(3) CHARACTER SET utf8 NOT NULL,
`fechapresentacion` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`fechanominal` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`tenorsup` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`tenorinf` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`montototal` double NOT NULL,
`idguia` int(11) NOT NULL,
`idcontacto` int(11) DEFAULT NULL,
`idobjeto` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_cruge_authassignment`
--

DROP TABLE IF EXISTS `public_cruge_authassignment`;
CREATE TABLE IF NOT EXISTS `public_cruge_authassignment` (
`userid` int(11) NOT NULL,
`bizrule` longtext CHARACTER SET utf8,
`data` longtext CHARACTER SET utf8,
`itemname` varchar(64) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_cruge_authitemchild`
--

DROP TABLE IF EXISTS `public_cruge_authitemchild`;
CREATE TABLE IF NOT EXISTS `public_cruge_authitemchild` (
`parent` varchar(64) CHARACTER SET utf8 NOT NULL,
`child` varchar(64) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_cruge_grupos_mail`
--

DROP TABLE IF EXISTS `public_cruge_grupos_mail`;
CREATE TABLE IF NOT EXISTS `public_cruge_grupos_mail` (
`id` int(11) NOT NULL,
`desgrupo` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`deslarga` longtext CHARACTER SET utf8
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_cruge_lista_mail`
--

DROP TABLE IF EXISTS `public_cruge_lista_mail`;
CREATE TABLE IF NOT EXISTS `public_cruge_lista_mail` (
`id` int(11) NOT NULL,
`hid` bigint(20) DEFAULT NULL,
`iduser` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_cursos`
--

DROP TABLE IF EXISTS `public_cursos`;
CREATE TABLE IF NOT EXISTS `public_cursos` (
`codcurso` varchar(5) CHARACTER SET utf8 NOT NULL,
`nombrecurso` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_dcotmateriales`
--

DROP TABLE IF EXISTS `public_dcotmateriales`;
CREATE TABLE IF NOT EXISTS `public_dcotmateriales` (
`id` bigint(20) NOT NULL,
`codart` varchar(8) CHARACTER SET utf8 NOT NULL,
`disp` varchar(2) CHARACTER SET utf8 NOT NULL,
`cant` double NOT NULL,
`punit` double NOT NULL,
`item` varchar(3) CHARACTER SET utf8 NOT NULL,
`descri` varchar(40) CHARACTER SET utf8 NOT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`stock` double DEFAULT NULL,
`detalle` longtext CHARACTER SET utf8,
`tipoitem` varchar(1) CHARACTER SET utf8 NOT NULL,
`estadodetalle` varchar(2) CHARACTER SET utf8 NOT NULL,
`coddocu` varchar(3) CHARACTER SET utf8 NOT NULL,
`um` varchar(3) CHARACTER SET utf8 NOT NULL,
`hidguia` bigint(20) DEFAULT NULL,
`codservicio` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`tipo` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`idpadre` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_dcotmateriales_d`
--

DROP TABLE IF EXISTS `public_dcotmateriales_d`;
CREATE TABLE IF NOT EXISTS `public_dcotmateriales_d` (
`id` bigint(20) NOT NULL,
`codart` varchar(8) CHARACTER SET utf8 NOT NULL,
`disp` varchar(2) CHARACTER SET utf8 NOT NULL,
`cant` double NOT NULL,
`punit` double NOT NULL,
`item` varchar(3) CHARACTER SET utf8 NOT NULL,
`descri` varchar(40) CHARACTER SET utf8 NOT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`stock` double DEFAULT NULL,
`detalle` longtext CHARACTER SET utf8,
`tipoitem` varchar(1) CHARACTER SET utf8 NOT NULL,
`estadodetalle` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`coddocu` varchar(3) CHARACTER SET utf8 NOT NULL,
`um` varchar(3) CHARACTER SET utf8 NOT NULL,
`hid` bigint(20) DEFAULT NULL,
`venta` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_dcottipo`
--

DROP TABLE IF EXISTS `public_dcottipo`;
CREATE TABLE IF NOT EXISTS `public_dcottipo` (
`codtipo` varchar(2) CHARACTER SET utf8 NOT NULL,
`destipo` varchar(25) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_defaultguia`
--

DROP TABLE IF EXISTS `public_defaultguia`;
CREATE TABLE IF NOT EXISTS `public_defaultguia` (
`socio` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`ndireccionpartida` int(11) DEFAULT NULL,
`cidireccionpartida` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
`coddestinatario` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`destinatario` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`ndireccionllegada` int(11) DEFAULT NULL,
`cdireccionllegada` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
`ccodtrans` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`c_transportista` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`id` int(11) NOT NULL,
`c_serie` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`impresora` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`usuario` longtext CHARACTER SET utf8,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`c_correos` longtext CHARACTER SET utf8
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_denvio`
--

DROP TABLE IF EXISTS `public_denvio`;
CREATE TABLE IF NOT EXISTS `public_denvio` (
`hnenvio` varchar(6) CHARACTER SET utf8 NOT NULL,
`c_itenvio` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`c_codart` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`c_descri` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`ncanti` double DEFAULT NULL,
`c_codep` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`c_codpadre` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`cafijo` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
`c_estenvio` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`ndenvio` bigint(20) DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_desolpe1`
--

DROP TABLE IF EXISTS `public_desolpe1`;
CREATE TABLE IF NOT EXISTS `public_desolpe1` (
`id` bigint(20) NOT NULL,
`numero` varchar(10) CHARACTER SET utf8 NOT NULL,
`tipimputacion` char(1) CHARACTER SET utf8 NOT NULL,
`centro` varchar(4) CHARACTER SET utf8 NOT NULL,
`codal` varchar(3) CHARACTER SET utf8 NOT NULL,
`codart` varchar(10) CHARACTER SET utf8 NOT NULL,
`txtmaterial` varchar(40) CHARACTER SET utf8 NOT NULL,
`grupocompras` char(3) CHARACTER SET utf8 NOT NULL,
`usuario` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`textodetalle` text CHARACTER SET utf8,
`fechacrea` datetime DEFAULT NULL,
`fechaent` date DEFAULT NULL,
`fechalib` datetime DEFAULT NULL,
`imputacion` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
`hidsolpe` bigint(20) DEFAULT NULL,
`codocu` char(3) CHARACTER SET utf8 DEFAULT NULL,
`tipsolpe` char(1) CHARACTER SET utf8 DEFAULT NULL,
`est` char(2) CHARACTER SET utf8 DEFAULT NULL,
`cant` float DEFAULT NULL,
`item` char(3) CHARACTER SET utf8 DEFAULT NULL,
`cantaten` float DEFAULT NULL,
`posicion` int(11) DEFAULT NULL,
`modificado` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`estadolib` char(1) CHARACTER SET utf8 DEFAULT NULL,
`solicitanet` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creado` datetime NOT NULL,
`um` char(3) CHARACTER SET utf8 DEFAULT NULL,
`firme` char(1) COLLATE utf8_unicode_ci NOT NULL,
`idreserva` bigint(20) NOT NULL,
`punitplan` double NOT NULL DEFAULT '0',
`punitreal` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=150 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_desolpecompra`
--

DROP TABLE IF EXISTS `public_desolpecompra`;
CREATE TABLE IF NOT EXISTS `public_desolpecompra` (
`id` int(11) NOT NULL,
`iddesolpe` bigint(20) DEFAULT NULL,
`iddocompra` bigint(20) DEFAULT NULL,
`cant` double DEFAULT NULL,
`fecha` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`user` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`codestado` char(2) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_detcargos`
--

DROP TABLE IF EXISTS `public_detcargos`;
CREATE TABLE IF NOT EXISTS `public_detcargos` (
`hidcargo` bigint(20) NOT NULL,
`coditem` varchar(3) CHARACTER SET utf8 NOT NULL,
`codmaterial` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`m_detcargo` longtext CHARACTER SET utf8,
`c_esdetcargo` varchar(2) CHARACTER SET utf8 NOT NULL,
`iddetcargo` bigint(20) NOT NULL,
`descrip` varchar(40) CHARACTER SET utf8 NOT NULL,
`coddocudetallecargo` varchar(3) CHARACTER SET utf8 NOT NULL,
`cantcargo` double NOT NULL,
`esactivo` int(11) DEFAULT NULL,
`esusado` int(11) DEFAULT NULL,
`umedida` varchar(3) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_detcontrolactivos`
--

DROP TABLE IF EXISTS `public_detcontrolactivos`;
CREATE TABLE IF NOT EXISTS `public_detcontrolactivos` (
`hidformato` bigint(20) DEFAULT NULL,
`iddetalle` bigint(20) NOT NULL,
`idactivo` bigint(20) DEFAULT NULL,
`idemplazamientoactual` bigint(20) DEFAULT NULL,
`idemplazamientoanterior` bigint(20) DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`adicional` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_detdocumentoscomponentes`
--

DROP TABLE IF EXISTS `public_detdocumentoscomponentes`;
CREATE TABLE IF NOT EXISTS `public_detdocumentoscomponentes` (
`hiddoc` bigint(20) DEFAULT NULL,
`id` bigint(20) DEFAULT NULL,
`cant` int(11) DEFAULT NULL,
`codigo` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`activo` bigint(20) DEFAULT NULL,
`codep` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`excodep` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`iddetalle` bigint(20) NOT NULL,
`codestado` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`obs` longtext CHARACTER SET utf8,
`protagonista` int(11) DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_detgui`
--

DROP TABLE IF EXISTS `public_detgui`;
CREATE TABLE IF NOT EXISTS `public_detgui` (
`n_hguia` bigint(20) DEFAULT NULL,
`c_itguia` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`n_cangui` double DEFAULT NULL,
`c_codgui` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`c_edgui` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`c_descri` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`m_obs` longtext CHARACTER SET utf8,
`c_um` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`c_codep` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`ndeenvio` bigint(20) DEFAULT NULL,
`id` bigint(20) NOT NULL,
`l_libre` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`n_hconformidad` bigint(20) DEFAULT NULL,
`c_estado` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`n_libre` int(11) DEFAULT NULL,
`n_idconformidad` bigint(20) DEFAULT NULL,
`c_af` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`c_codactivo` varchar(13) CHARACTER SET utf8 DEFAULT NULL,
`c_img` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`c_codsap` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`docref` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`docrefext` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
`hidref` bigint(20) DEFAULT NULL,
`codocu` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`codlugar` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`iduser` int(11) NOT NULL,
`idtemp` bigint(20) NOT NULL,
`idstatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_detrep`
--

DROP TABLE IF EXISTS `public_detrep`;
CREATE TABLE IF NOT EXISTS `public_detrep` (
`idrep` bigint(20) NOT NULL,
`hidrep` bigint(20) NOT NULL,
`idinventario` int(11) DEFAULT NULL,
`estado` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`oi` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
`detalle` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`pedido` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`om` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`presupuesto` varchar(16) CHARACTER SET utf8 DEFAULT NULL,
`idlog` bigint(20) DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_dfacrecibida`
--

DROP TABLE IF EXISTS `public_dfacrecibida`;
CREATE TABLE IF NOT EXISTS `public_dfacrecibida` (
`id` bigint(20) NOT NULL,
`hidfacrecibida` bigint(20) NOT NULL,
`cant` double NOT NULL,
`hientrega` bigint(20) NOT NULL,
`txtdetalle` text COLLATE utf8_unicode_ci NOT NULL,
`codestado` char(2) COLLATE utf8_unicode_ci NOT NULL,
`usuario` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
`creado` datetime NOT NULL,
`fechacont` date NOT NULL,
`column_10` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_direcciones`
--

DROP TABLE IF EXISTS `public_direcciones`;
CREATE TABLE IF NOT EXISTS `public_direcciones` (
`c_hcod` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`c_direc` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
`l_vale` bit(1) DEFAULT NULL,
`c_nomlug` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`n_valor` int(11) DEFAULT NULL,
`c_distrito` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`c_prov` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`c_departam` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`n_direc` int(11) NOT NULL,
`socio` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`codlugar` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`codplanta` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`ubigeo` varchar(6) CHARACTER SET utf8 NOT NULL,
`cospostal` varchar(2) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_direcen`
--

DROP TABLE IF EXISTS `public_direcen`;
CREATE TABLE IF NOT EXISTS `public_direcen` (
`codcen` varchar(5) CHARACTER SET utf8 NOT NULL,
`dire` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
`coddis` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`coddir` varchar(4) CHARACTER SET utf8 NOT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_dirsociedad`
--

DROP TABLE IF EXISTS `public_dirsociedad`;
CREATE TABLE IF NOT EXISTS `public_dirsociedad` (
`socio` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`n_dir` int(11) NOT NULL,
`direccion` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`depa` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
`prov` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
`dist` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_disponiblidad`
--

DROP TABLE IF EXISTS `public_disponiblidad`;
CREATE TABLE IF NOT EXISTS `public_disponiblidad` (
`codisp` varchar(2) CHARACTER SET utf8 NOT NULL,
`dedispo` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`coddocu` varchar(3) CHARACTER SET utf8 NOT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_docompra`
--

DROP TABLE IF EXISTS `public_docompra`;
CREATE TABLE IF NOT EXISTS `public_docompra` (
`id` bigint(20) NOT NULL,
`codart` varchar(8) CHARACTER SET utf8 NOT NULL,
`disp` varchar(2) CHARACTER SET utf8 NOT NULL,
`cant` double NOT NULL,
`punit` double NOT NULL,
`item` varchar(3) CHARACTER SET utf8 NOT NULL,
`descri` varchar(40) CHARACTER SET utf8 NOT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`stock` double DEFAULT NULL,
`detalle` longtext CHARACTER SET utf8,
`tipoitem` varchar(1) CHARACTER SET utf8 NOT NULL,
`estadodetalle` varchar(2) CHARACTER SET utf8 NOT NULL,
`coddocu` varchar(3) CHARACTER SET utf8 NOT NULL,
`um` varchar(3) CHARACTER SET utf8 NOT NULL,
`hidguia` bigint(20) DEFAULT NULL,
`codservicio` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`tipoimputacion` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`ceco` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
`orden` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
`codentro` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`codigoalma` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`punitdes` double DEFAULT NULL,
`iddesolpe` bigint(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_docompra_t`
--

DROP TABLE IF EXISTS `public_docompra_t`;
CREATE TABLE IF NOT EXISTS `public_docompra_t` (
`codart` varchar(8) CHARACTER SET utf8 NOT NULL,
`disp` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`cant` double NOT NULL,
`punit` double NOT NULL,
`item` varchar(3) CHARACTER SET utf8 NOT NULL,
`descri` varchar(40) CHARACTER SET utf8 NOT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`stock` double DEFAULT NULL,
`detalle` longtext CHARACTER SET utf8,
`tipoitem` varchar(1) CHARACTER SET utf8 NOT NULL,
`estadodetalle` varchar(2) CHARACTER SET utf8 NOT NULL,
`coddocu` varchar(3) CHARACTER SET utf8 NOT NULL,
`um` varchar(3) CHARACTER SET utf8 NOT NULL,
`hidguia` bigint(20) DEFAULT NULL,
`codservicio` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`tipoimputacion` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`ceco` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
`orden` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
`codentro` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`codigoalma` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`id` int(20) NOT NULL,
`efectuado` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`iddocompra` bigint(20) DEFAULT NULL,
`idsesion` bigint(20) DEFAULT NULL,
`punitdes` double DEFAULT NULL,
`iddesolpe` bigint(20) DEFAULT NULL,
`mensaje` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_docucorreos`
--

DROP TABLE IF EXISTS `public_docucorreos`;
CREATE TABLE IF NOT EXISTS `public_docucorreos` (
`usuario` longtext CHARACTER SET utf8 NOT NULL,
`coddocu` varchar(3) CHARACTER SET utf8 NOT NULL,
`codestado` varchar(2) CHARACTER SET utf8 NOT NULL,
`listainterna` longtext CHARACTER SET utf8 NOT NULL,
`listaexterna` longtext CHARACTER SET utf8 NOT NULL,
`asunto` varchar(60) CHARACTER SET utf8 NOT NULL,
`habilitado` int(11) DEFAULT NULL,
`mensajecabeza` longtext CHARACTER SET utf8 NOT NULL,
`mensajepie` longtext CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_documentos`
--

DROP TABLE IF EXISTS `public_documentos`;
CREATE TABLE IF NOT EXISTS `public_documentos` (
`coddocu` varchar(3) CHARACTER SET utf8 NOT NULL,
`desdocu` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
`clase` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`tipo` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`coddocupadre` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`tabla` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
`anuladesde` int(11) DEFAULT NULL,
`cactivo` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`abreviatura` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`prefijo` char(3) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_documentoscomponentes`
--

DROP TABLE IF EXISTS `public_documentoscomponentes`;
CREATE TABLE IF NOT EXISTS `public_documentoscomponentes` (
`iddoc` bigint(20) NOT NULL,
`numdoc` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`fedoc` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`ndirec` bigint(20) DEFAULT NULL,
`obs` longtext CHARACTER SET utf8,
`coddocu` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`codigo` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`activo` bigint(20) DEFAULT NULL,
`codestadodoc` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`modificado` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`creado` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_documentosfavoritos`
--

DROP TABLE IF EXISTS `public_documentosfavoritos`;
CREATE TABLE IF NOT EXISTS `public_documentosfavoritos` (
`id` bigint(20) NOT NULL,
`codocu` char(3) COLLATE utf8_unicode_ci NOT NULL,
`hidocu` bigint(20) NOT NULL,
`iduser` int(11) NOT NULL,
`nombre` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
`texto` text COLLATE utf8_unicode_ci NOT NULL,
`column_7` int(11) NOT NULL,
`compartido` char(1) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_docu_ingresados`
--

DROP TABLE IF EXISTS `public_docu_ingresados`;
CREATE TABLE IF NOT EXISTS `public_docu_ingresados` (
`id` int(11) NOT NULL,
`codprov` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`fecha` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`fechain` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`correlativo` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`tipodoc` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`moneda` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`descorta` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`codepv` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`monto` double DEFAULT NULL,
`codgrupo` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`codresponsable` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(23) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
`texv` longtext CHARACTER SET utf8,
`docref` varchar(14) CHARACTER SET utf8 DEFAULT NULL,
`codteniente` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`codlocal` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`numero` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`cod_estado` varchar(2) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_dpedido`
--

DROP TABLE IF EXISTS `public_dpedido`;
CREATE TABLE IF NOT EXISTS `public_dpedido` (
`item` varchar(3) CHARACTER SET utf8 NOT NULL,
`codart` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`cc` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`numped` varchar(8) CHARACTER SET utf8 NOT NULL,
`reserva` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`pcompra` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_dpeticion`
--

DROP TABLE IF EXISTS `public_dpeticion`;
CREATE TABLE IF NOT EXISTS `public_dpeticion` (
`id` bigint(20) NOT NULL,
`hidpeticion` bigint(20) NOT NULL,
`um` char(3) CHARACTER SET utf8 NOT NULL,
`codart` varchar(10) CHARACTER SET utf8 NOT NULL,
`punit` double NOT NULL,
`cant` double NOT NULL,
`comentario` text CHARACTER SET utf8 NOT NULL,
`codestado` char(2) CHARACTER SET utf8 NOT NULL,
`codcen` varchar(4) CHARACTER SET utf8 NOT NULL,
`codal` varchar(3) CHARACTER SET utf8 NOT NULL,
`codocu` char(3) CHARACTER SET utf8 NOT NULL,
`usuario` varchar(23) CHARACTER SET utf8 NOT NULL,
`iduser` int(11) NOT NULL,
`disponibilidad` char(2) CHARACTER SET utf8 NOT NULL,
`idtemp` bigint(20) NOT NULL,
`item` char(3) COLLATE utf8_unicode_ci DEFAULT NULL,
`idusertemp` int(11) NOT NULL,
`descripcion` varchar(40) CHARACTER SET utf8 NOT NULL,
`idstatus` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=173 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_embarcaciones`
--

DROP TABLE IF EXISTS `public_embarcaciones`;
CREATE TABLE IF NOT EXISTS `public_embarcaciones` (
`codep` varchar(3) CHARACTER SET utf8 NOT NULL,
`nomep` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`matricula` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
`cbodega` int(11) DEFAULT NULL,
`activa` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`codsap` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`codcentro` varchar(4) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_embarcacionesperu`
--

DROP TABLE IF EXISTS `public_embarcacionesperu`;
CREATE TABLE IF NOT EXISTS `public_embarcacionesperu` (
`nomep` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`matricula` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
`tipocasco` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`fechacon` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_emplazamientos`
--

DROP TABLE IF EXISTS `public_emplazamientos`;
CREATE TABLE IF NOT EXISTS `public_emplazamientos` (
`idempla` bigint(20) NOT NULL,
`codsistema` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`codsistemapadre` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`codep` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`general` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`descripcion` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`codarea` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_envio`
--

DROP TABLE IF EXISTS `public_envio`;
CREATE TABLE IF NOT EXISTS `public_envio` (
`nenvio` varchar(7) CHARACTER SET utf8 NOT NULL,
`fenvio` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`uuoo` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`ingresosalida` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`destinatario` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`foto` longblob,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_equipo`
--

DROP TABLE IF EXISTS `public_equipo`;
CREATE TABLE IF NOT EXISTS `public_equipo` (
`codigo` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`codigohijo` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`cant` int(11) DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_errores`
--

DROP TABLE IF EXISTS `public_errores`;
CREATE TABLE IF NOT EXISTS `public_errores` (
`usuario` varchar(35) CHARACTER SET utf8 NOT NULL,
`sesion` int(11) NOT NULL,
`numeroerror` int(11) DEFAULT NULL,
`textoservidor` longtext CHARACTER SET utf8,
`mensaje` longtext CHARACTER SET utf8,
`aliastabla` varchar(70) CHARACTER SET utf8 DEFAULT NULL,
`nombretabla` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
`ip` longtext CHARACTER SET utf8,
`aliascampo` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
`nombrecampo` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
`tiempo` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`item` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_errores_carteres`
--

DROP TABLE IF EXISTS `public_errores_carteres`;
CREATE TABLE IF NOT EXISTS `public_errores_carteres` (
`idcarter` int(11) DEFAULT NULL,
`mensaje` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
`horometro` int(11) DEFAULT NULL,
`textolargo` longtext CHARACTER SET utf8,
`documento` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_especie`
--

DROP TABLE IF EXISTS `public_especie`;
CREATE TABLE IF NOT EXISTS `public_especie` (
`id` int(11) NOT NULL,
`nomespecie` varchar(50) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_estado`
--

DROP TABLE IF EXISTS `public_estado`;
CREATE TABLE IF NOT EXISTS `public_estado` (
`codestado` varchar(2) CHARACTER SET utf8 NOT NULL,
`codocu` varchar(3) CHARACTER SET utf8 NOT NULL,
`estado` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`ordenn` smallint(6) DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`eseditable` int(11) DEFAULT NULL,
`esanulable` int(11) DEFAULT NULL,
`id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=238 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_estados`
--

DROP TABLE IF EXISTS `public_estados`;
CREATE TABLE IF NOT EXISTS `public_estados` (
`codestado` varchar(1) CHARACTER SET utf8 NOT NULL,
`nomestado` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_estructura`
--

DROP TABLE IF EXISTS `public_estructura`;
CREATE TABLE IF NOT EXISTS `public_estructura` (
`tabla` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`campo` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`estructura` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`codigoestructura` varchar(5) CHARACTER SET utf8 NOT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_eventos`
--

DROP TABLE IF EXISTS `public_eventos`;
CREATE TABLE IF NOT EXISTS `public_eventos` (
`id` int(11) NOT NULL,
`codocu` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`estadofinal` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`estadoinicial` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`descripcion` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
`titulomsg1` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`titulomsg2` varchar(40) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_explosiones`
--

DROP TABLE IF EXISTS `public_explosiones`;
CREATE TABLE IF NOT EXISTS `public_explosiones` (
`hiddoc` bigint(20) DEFAULT NULL,
`id` bigint(20) DEFAULT NULL,
`cant` int(11) DEFAULT NULL,
`codigo` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`activo` bigint(20) DEFAULT NULL,
`codep` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`excodep` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`iddetalle` bigint(20) DEFAULT NULL,
`codestado` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`obs` longtext CHARACTER SET utf8,
`protagonista` int(11) DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_factu`
--

DROP TABLE IF EXISTS `public_factu`;
CREATE TABLE IF NOT EXISTS `public_factu` (
`codserie` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`numcot` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`codpro` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`fechaemision` date NOT NULL,
`codestado` varchar(2) CHARACTER SET utf8 NOT NULL,
`texto` varchar(40) CHARACTER SET utf8 NOT NULL,
`textolargo` longtext CHARACTER SET utf8,
`tipologia` varchar(1) CHARACTER SET utf8 NOT NULL,
`moneda` varchar(3) CHARACTER SET utf8 NOT NULL,
`orcli` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
`descuento` smallint(6) DEFAULT NULL,
`coddocu` varchar(3) CHARACTER SET utf8 NOT NULL,
`creado` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificado` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`codtipofac` varchar(2) CHARACTER SET utf8 NOT NULL,
`codsociedad` varchar(1) CHARACTER SET utf8 NOT NULL,
`codgrupoventas` varchar(3) CHARACTER SET utf8 NOT NULL,
`codtipocotizacion` int(11) NOT NULL,
`codcentro` varchar(3) CHARACTER SET utf8 NOT NULL,
`nigv` double NOT NULL,
`codobjeto` varchar(3) CHARACTER SET utf8 NOT NULL,
`fechapresentacion` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`fechanominal` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`fechacancelacion` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`id` bigint(20) NOT NULL,
`tenorsup` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`tenorinf` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`numerocheque` varchar(24) CHARACTER SET utf8 DEFAULT NULL,
`montototal` double NOT NULL,
`condetalle` int(11) NOT NULL,
`subto` double DEFAULT NULL,
`ubltag` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
`firmadigital` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_facturd`
--

DROP TABLE IF EXISTS `public_facturd`;
CREATE TABLE IF NOT EXISTS `public_facturd` (
`id` bigint(20) NOT NULL,
`numcot` varchar(7) CHARACTER SET utf8 DEFAULT NULL,
`codart` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`disp` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`cant` double NOT NULL,
`punit` double NOT NULL,
`item` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`descri` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`stock` double DEFAULT NULL,
`detalle` longtext CHARACTER SET utf8,
`tipoitem` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`estadodetalle` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`coddocu` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`um` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`hidguia` bigint(20) NOT NULL,
`itemcot` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`fraccion` double DEFAULT NULL,
`tipdoc` char(1) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_fifo`
--

DROP TABLE IF EXISTS `public_fifo`;
CREATE TABLE IF NOT EXISTS `public_fifo` (
`uno` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_formularios`
--

DROP TABLE IF EXISTS `public_formularios`;
CREATE TABLE IF NOT EXISTS `public_formularios` (
`codigo` varchar(5) CHARACTER SET utf8 NOT NULL,
`codtransa` varchar(5) CHARACTER SET utf8 NOT NULL,
`nombreformulario` varchar(45) CHARACTER SET utf8 NOT NULL,
`codmodulo` varchar(2) CHARACTER SET utf8 NOT NULL,
`grupo` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`tecla` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
`orden` smallint(6) DEFAULT NULL,
`mensaje` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
`codigo_a_ejecutar` longtext CHARACTER SET utf8,
`activo` smallint(6) DEFAULT NULL,
`flag` smallint(6) DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_gallery`
--

DROP TABLE IF EXISTS `public_gallery`;
CREATE TABLE IF NOT EXISTS `public_gallery` (
`id` int(11) NOT NULL,
`versions_data` longtext CHARACTER SET utf8 NOT NULL,
`name` int(11) NOT NULL,
`description` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_galleryconfig`
--

DROP TABLE IF EXISTS `public_galleryconfig`;
CREATE TABLE IF NOT EXISTS `public_galleryconfig` (
`type` varchar(16) CHARACTER SET utf8 NOT NULL,
`config` longtext CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_gallery_photo`
--

DROP TABLE IF EXISTS `public_gallery_photo`;
CREATE TABLE IF NOT EXISTS `public_gallery_photo` (
`id` int(11) NOT NULL,
`gallery_id` int(11) NOT NULL,
`rank` int(11) NOT NULL DEFAULT '0',
`name` varchar(512) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
`description` text COLLATE utf8_unicode_ci,
`file_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_grupocompras`
--

DROP TABLE IF EXISTS `public_grupocompras`;
CREATE TABLE IF NOT EXISTS `public_grupocompras` (
`codgrupo` varchar(4) CHARACTER SET utf8 NOT NULL,
`codalm` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`nomgru` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`desgru` longtext CHARACTER SET utf8,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`codsociedad` varchar(1) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_grupousuarios`
--

DROP TABLE IF EXISTS `public_grupousuarios`;
CREATE TABLE IF NOT EXISTS `public_grupousuarios` (
`codigo` varchar(3) CHARACTER SET utf8 NOT NULL,
`desgrupo` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_grupoventas`
--

DROP TABLE IF EXISTS `public_grupoventas`;
CREATE TABLE IF NOT EXISTS `public_grupoventas` (
`codgrupo` varchar(3) CHARACTER SET utf8 NOT NULL,
`codalm` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`nomgru` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`desgru` longtext CHARACTER SET utf8,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`codsociedad` varchar(1) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_guia`
--

DROP TABLE IF EXISTS `public_guia`;
CREATE TABLE IF NOT EXISTS `public_guia` (
`c_numgui` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`c_coclig` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`d_fecgui` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`c_estgui` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`c_rsguia` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`c_codtra` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`c_trans` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`c_motivo` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`c_placa` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
`c_licon` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`d_fectra` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`c_desgui` longtext CHARACTER SET utf8,
`n_direc` int(11) DEFAULT NULL,
`c_texto` longtext CHARACTER SET utf8,
`c_dirsoc` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`c_serie` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`n_direcformaldes` int(11) DEFAULT NULL,
`n_directran` int(11) DEFAULT NULL,
`c_creado` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`n_guia` bigint(20) NOT NULL,
`c_estado` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`n_dirsoc` int(11) DEFAULT NULL,
`c_modificado` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`n_agencia` int(11) DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`codcentro` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`codobjeto` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`d_fecentrega` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`c_salida` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`codocu` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`cod_cen` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`id` bigint(20) NOT NULL,
`codocuaux` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`iddocuaux` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_hcontrolactivos`
--

DROP TABLE IF EXISTS `public_hcontrolactivos`;
CREATE TABLE IF NOT EXISTS `public_hcontrolactivos` (
`hidformato` bigint(20) DEFAULT NULL,
`iddetalle` bigint(20) NOT NULL,
`idactivo` bigint(20) DEFAULT NULL,
`idemplazamientoactual` bigint(20) DEFAULT NULL,
`idemplazamientoanterior` bigint(20) DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_hpedido`
--

DROP TABLE IF EXISTS `public_hpedido`;
CREATE TABLE IF NOT EXISTS `public_hpedido` (
`numped` varchar(8) CHARACTER SET utf8 NOT NULL,
`fecped` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`desped` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
`codgru` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`codplazo` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`estado` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`usuario` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`provesug` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificador` varchar(15) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_hsolpe`
--

DROP TABLE IF EXISTS `public_hsolpe`;
CREATE TABLE IF NOT EXISTS `public_hsolpe` (
`numero` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`tipo` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`textocabecera` longtext CHARACTER SET utf8,
`creado` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`autor` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
`estado` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`fechadoc` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`fechanec` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`id` int(11) NOT NULL,
`codocu` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`fechamod` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`horamod` longtext CHARACTER SET utf8,
`escompra` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`correlativ` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_igv`
--

DROP TABLE IF EXISTS `public_igv`;
CREATE TABLE IF NOT EXISTS `public_igv` (
`valor` double NOT NULL,
`creadoel` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`id` int(11) NOT NULL,
`tipo` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`Descripcion` varchar(30) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_imagen`
--

DROP TABLE IF EXISTS `public_imagen`;
CREATE TABLE IF NOT EXISTS `public_imagen` (
`campo1` longblob,
`campo2` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_intereses_mant`
--

DROP TABLE IF EXISTS `public_intereses_mant`;
CREATE TABLE IF NOT EXISTS `public_intereses_mant` (
`codinteres` varchar(2) CHARACTER SET utf8 NOT NULL,
`Interes` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`activo` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_inventario`
--

DROP TABLE IF EXISTS `public_inventario`;
CREATE TABLE IF NOT EXISTS `public_inventario` (
`idinventario` bigint(20) NOT NULL,
`codigo` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`c_estado` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`codep` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`comentario` longtext CHARACTER SET utf8,
`fecha` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`coddocu` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`codlugar` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`codigosap` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`codigoaf` varchar(14) CHARACTER SET utf8 DEFAULT NULL,
`descripcion` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`marca` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
`modelo` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`serie` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`clasefoto` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`codigopadre` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`numerodocumento` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`adicional` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
`codigoafant` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`posicion` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`codcentro` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`codcentrooriginal` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`codeporiginal` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`rocoto` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`codepanterior` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`codcentroanterior` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`clase` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`baja` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`n_direc` bigint(20) DEFAULT NULL,
`ubicacion` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`tipo` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`codestado` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`tienecarter` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`codarea` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`iddocu` bigint(20) DEFAULT NULL,
`codigodoc` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`portransporte` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`historial` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_kardexcompo`
--

DROP TABLE IF EXISTS `public_kardexcompo`;
CREATE TABLE IF NOT EXISTS `public_kardexcompo` (
`idkardex` bigint(20) NOT NULL,
`codigo` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`fecha` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`cant` int(11) DEFAULT NULL,
`tipmov` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`estado` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`codocu` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_keel_cooler`
--

DROP TABLE IF EXISTS `public_keel_cooler`;
CREATE TABLE IF NOT EXISTS `public_keel_cooler` (
`idkeel` int(11) NOT NULL,
`codep` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`idequipo` int(11) DEFAULT NULL,
`volumen` int(11) DEFAULT NULL,
`carga_inicial` int(11) DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_keel_resultados`
--

DROP TABLE IF EXISTS `public_keel_resultados`;
CREATE TABLE IF NOT EXISTS `public_keel_resultados` (
`id_keel` bigint(20) DEFAULT NULL,
`id_keel_re` bigint(20) NOT NULL,
`fecha_muestra` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`dureza` int(11) DEFAULT NULL,
`ph` double DEFAULT NULL,
`std` int(11) DEFAULT NULL,
`color_agua` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`residual` double DEFAULT NULL,
`dosis_faltante` int(11) DEFAULT NULL,
`comentario` longtext CHARACTER SET utf8,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_kits`
--

DROP TABLE IF EXISTS `public_kits`;
CREATE TABLE IF NOT EXISTS `public_kits` (
`codart` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`hcodart` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`cant` smallint(6) DEFAULT NULL,
`codgrupo` varchar(4) CHARACTER SET utf8 NOT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_locales`
--

DROP TABLE IF EXISTS `public_locales`;
CREATE TABLE IF NOT EXISTS `public_locales` (
`codlocal` varchar(2) CHARACTER SET utf8 NOT NULL,
`local` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_localidades`
--

DROP TABLE IF EXISTS `public_localidades`;
CREATE TABLE IF NOT EXISTS `public_localidades` (
`codlocalidad` varchar(3) CHARACTER SET utf8 NOT NULL,
`nombreloc` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_logactivos`
--

DROP TABLE IF EXISTS `public_logactivos`;
CREATE TABLE IF NOT EXISTS `public_logactivos` (
`idactivo` bigint(20) DEFAULT NULL,
`idempla` bigint(20) DEFAULT NULL,
`codigoaf` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
`descripcionaf` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
`serie` varchar(18) CHARACTER SET utf8 DEFAULT NULL,
`arreglo` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`codigo` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`texto` longtext CHARACTER SET utf8,
`idlog` bigint(20) DEFAULT NULL,
`fecha` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`tipo` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`codestado` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`idformato` bigint(20) DEFAULT NULL,
`tipomodificacion` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`usuario` longtext CHARACTER SET utf8,
`fechamod` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`barra` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`tipomaquina` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`dimensiones` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
`marca` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modelo` varchar(22) CHARACTER SET utf8 DEFAULT NULL,
`capacidad` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`observaciones` longtext CHARACTER SET utf8,
`idinventario` bigint(20) DEFAULT NULL,
`barpadre` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`sociedad` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`foto` longblob,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_logcotizaciones`
--

DROP TABLE IF EXISTS `public_logcotizaciones`;
CREATE TABLE IF NOT EXISTS `public_logcotizaciones` (
`codigo` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`coddocu` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`codep` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`fechadoc` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`monto` double DEFAULT NULL,
`codestado` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`numero` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`modificado` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_logdesolpe`
--

DROP TABLE IF EXISTS `public_logdesolpe`;
CREATE TABLE IF NOT EXISTS `public_logdesolpe` (
`mensa` longtext CHARACTER SET utf8
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_logdocumentos`
--

DROP TABLE IF EXISTS `public_logdocumentos`;
CREATE TABLE IF NOT EXISTS `public_logdocumentos` (
`coddocu` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`numdoc` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`tipmod` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`usuario` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`timemod` longtext CHARACTER SET utf8,
`fecmod` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`puerto` int(11) DEFAULT NULL,
`ipremoto` longtext CHARACTER SET utf8,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_logimpresiones`
--

DROP TABLE IF EXISTS `public_logimpresiones`;
CREATE TABLE IF NOT EXISTS `public_logimpresiones` (
`codocu` varchar(3) CHARACTER SET utf8 NOT NULL,
`codestado` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`numdoc` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`numeorip` longtext CHARACTER SET utf8,
`usuario` longtext CHARACTER SET utf8,
`fechaimpresion` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`idodcu` bigint(20) NOT NULL,
`c_serie` varchar(3) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_loginventario`
--

DROP TABLE IF EXISTS `public_loginventario`;
CREATE TABLE IF NOT EXISTS `public_loginventario` (
`idlog` bigint(20) NOT NULL,
`hidinventario` bigint(20) NOT NULL,
`c_estado` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`codep` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`comentario` longtext CHARACTER SET utf8,
`fecha` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`coddocu` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`codlugar` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`codigopadre` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`numerodocumento` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`adicional` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
`codestado` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`codepanterior` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`codlugarant` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`iddocu` bigint(20) DEFAULT NULL,
`codcentro` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`portransporte` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`iddocucausante` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_logmaestrocomponentes`
--

DROP TABLE IF EXISTS `public_logmaestrocomponentes`;
CREATE TABLE IF NOT EXISTS `public_logmaestrocomponentes` (
`codigo` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`um` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`descripcion` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_logtablas`
--

DROP TABLE IF EXISTS `public_logtablas`;
CREATE TABLE IF NOT EXISTS `public_logtablas` (
`tabla` longtext CHARACTER SET utf8,
`campo` longtext CHARACTER SET utf8,
`id` bigint(20) DEFAULT NULL,
`valor` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
`quien` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`operacion` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_logvalidaciones`
--

DROP TABLE IF EXISTS `public_logvalidaciones`;
CREATE TABLE IF NOT EXISTS `public_logvalidaciones` (
`nombretabla` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
`usuario` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`problema` longtext CHARACTER SET utf8,
`nivel` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`operacion` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`puerto` int(11) DEFAULT NULL,
`ipremoto` longtext CHARACTER SET utf8,
`campo` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
`valorcampo` longtext CHARACTER SET utf8,
`posi` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_log_modificaciones`
--

DROP TABLE IF EXISTS `public_log_modificaciones`;
CREATE TABLE IF NOT EXISTS `public_log_modificaciones` (
`idregistro` bigint(20) DEFAULT NULL,
`nombrecampo` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`valorant` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`valoract` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`fecha` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`quien` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`modificacion` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_lotes`
--

DROP TABLE IF EXISTS `public_lotes`;
CREATE TABLE IF NOT EXISTS `public_lotes` (
`id` bigint(20) NOT NULL,
`numlote` int(11) NOT NULL,
`fechacreacion` datetime NOT NULL,
`fechainicio` datetime NOT NULL,
`fechavenc` datetime NOT NULL,
`usuario` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
`cant` double NOT NULL,
`hidinventario` bigint(20) NOT NULL,
`loteprov` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'lote del proveedor',
`comentario` text COLLATE utf8_unicode_ci NOT NULL,
`codestado` char(2) COLLATE utf8_unicode_ci NOT NULL COMMENT '''10'' creado, ''20'' agotado, '
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_lugares`
--

DROP TABLE IF EXISTS `public_lugares`;
CREATE TABLE IF NOT EXISTS `public_lugares` (
`codlugar` varchar(6) CHARACTER SET utf8 NOT NULL,
`deslugar` varchar(50) CHARACTER SET utf8 NOT NULL,
`provincia` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`claselugar` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`codpro` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`n_direc` int(11) NOT NULL,
`codplanta` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_maestroclipro`
--

DROP TABLE IF EXISTS `public_maestroclipro`;
CREATE TABLE IF NOT EXISTS `public_maestroclipro` (
`id` int(11) NOT NULL,
`codart` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`codpro` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`codmon` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`precio` double DEFAULT NULL,
`centro` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`um` varchar(3) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_maestrocomponentes`
--

DROP TABLE IF EXISTS `public_maestrocomponentes`;
CREATE TABLE IF NOT EXISTS `public_maestrocomponentes` (
`codigo` varchar(10) CHARACTER SET utf8 NOT NULL,
`marca` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`modelo` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`nparte` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`codpadre` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`um` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`descripcion` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
`detalle` longtext CHARACTER SET utf8,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`clase` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
`codmaterial` varchar(16) CHARACTER SET utf8 DEFAULT NULL,
`flag` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`codtipo` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`id` int(11) NOT NULL,
`correlativo` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
`correl` int(11) DEFAULT NULL,
`seri` int(11) NOT NULL,
`codocu` char(3) COLLATE utf8_unicode_ci NOT NULL,
`esrotativo` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
`codean` varchar(14) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_maestrodetalle`
--

DROP TABLE IF EXISTS `public_maestrodetalle`;
CREATE TABLE IF NOT EXISTS `public_maestrodetalle` (
`codart` varchar(8) CHARACTER SET utf8 NOT NULL,
`codcentro` varchar(4) CHARACTER SET utf8 NOT NULL,
`codal` varchar(3) CHARACTER SET utf8 NOT NULL,
`codgrupoventas` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`canaldist` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`canteconomica` double DEFAULT NULL,
`cantreposic` double DEFAULT NULL,
`cantreorden` double DEFAULT NULL,
`leadtime` int(11) DEFAULT NULL,
`catval` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`punitv` double DEFAULT NULL,
`punitstd` double DEFAULT NULL,
`controlprecio` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`supervisionautomatica` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`sujetolote` char(1) COLLATE utf8_unicode_ci NOT NULL,
`lifofifo` varchar(2) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_maestrodetallecentros`
--

DROP TABLE IF EXISTS `public_maestrodetallecentros`;
CREATE TABLE IF NOT EXISTS `public_maestrodetallecentros` (
`id` bigint(20) NOT NULL,
`hcodart` varchar(10) CHARACTER SET utf8 NOT NULL,
`iqf` char(1) CHARACTER SET utf8 NOT NULL,
`catvalor` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`codcen` varchar(4) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=46703 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_maestrogrupos`
--

DROP TABLE IF EXISTS `public_maestrogrupos`;
CREATE TABLE IF NOT EXISTS `public_maestrogrupos` (
`codgrupo` varchar(3) CHARACTER SET utf8 NOT NULL,
`descri1` varchar(23) CHARACTER SET utf8 DEFAULT NULL,
`descri2` varchar(40) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_maestrosector`
--

DROP TABLE IF EXISTS `public_maestrosector`;
CREATE TABLE IF NOT EXISTS `public_maestrosector` (
`codsector` varchar(3) CHARACTER SET utf8 NOT NULL,
`descr` varchar(30) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_maestrosolicitudescabecera`
--

DROP TABLE IF EXISTS `public_maestrosolicitudescabecera`;
CREATE TABLE IF NOT EXISTS `public_maestrosolicitudescabecera` (
`id` int(11) NOT NULL,
`codcentro` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`correlativo` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`fecha` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`creadopor` varchar(26) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`solicitante` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`codigoestado` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`coddocu` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`descripcion` varchar(25) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_maestrotipos`
--

DROP TABLE IF EXISTS `public_maestrotipos`;
CREATE TABLE IF NOT EXISTS `public_maestrotipos` (
`esrotativo` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT 'Especiofica si es rotativo o no',
`id` int(11) NOT NULL,
`codtipo` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`destipo` varchar(30) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_maestro_atributos`
--

DROP TABLE IF EXISTS `public_maestro_atributos`;
CREATE TABLE IF NOT EXISTS `public_maestro_atributos` (
`nombreat` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`hid` bigint(20) DEFAULT NULL,
`abreviatura` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`padre` bigint(20) DEFAULT NULL,
`jerarquia` int(11) DEFAULT NULL,
`respaldo` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
`respaldo2` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
`respaldo3` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
`texto` longtext CHARACTER SET utf8,
`tieneum` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_maestro_grupos`
--

DROP TABLE IF EXISTS `public_maestro_grupos`;
CREATE TABLE IF NOT EXISTS `public_maestro_grupos` (
`descri` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`texto` longtext CHARACTER SET utf8,
`chapas` varchar(75) CHARACTER SET utf8 DEFAULT NULL,
`id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_maestro_solicitudes`
--

DROP TABLE IF EXISTS `public_maestro_solicitudes`;
CREATE TABLE IF NOT EXISTS `public_maestro_solicitudes` (
`id` int(11) NOT NULL,
`descripcioncorta` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`marca` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`modelo` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`numeroparte` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`descripcion` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`um` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`codclase` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`codgrupo` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`codsector` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`textolargo` longtext CHARACTER SET utf8,
`codigoestado` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`codigodoc` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`codigocreado` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
`descripcionfinal` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`centro` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`correlativo` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`fecha` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`hid` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_maestro_valores`
--

DROP TABLE IF EXISTS `public_maestro_valores`;
CREATE TABLE IF NOT EXISTS `public_maestro_valores` (
`nombrevalor` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`hidat` bigint(20) DEFAULT NULL,
`abreviatura` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`texto` longtext CHARACTER SET utf8,
`respaldo1` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`respaldo2` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`respaldo3` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`id` int(11) NOT NULL,
`resultado` varchar(10) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_master_activos`
--

DROP TABLE IF EXISTS `public_master_activos`;
CREATE TABLE IF NOT EXISTS `public_master_activos` (
`codigo` varchar(70) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_materiales`
--

DROP TABLE IF EXISTS `public_materiales`;
CREATE TABLE IF NOT EXISTS `public_materiales` (
`codart` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`numcot` varchar(7) CHARACTER SET utf8 DEFAULT NULL,
`item` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`oper` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`cant` smallint(6) DEFAULT NULL,
`idmat` bigint(20) NOT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_ma_cargos`
--

DROP TABLE IF EXISTS `public_ma_cargos`;
CREATE TABLE IF NOT EXISTS `public_ma_cargos` (
`codcargo` varchar(3) CHARACTER SET utf8 NOT NULL,
`cargo` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_mensajes`
--

DROP TABLE IF EXISTS `public_mensajes`;
CREATE TABLE IF NOT EXISTS `public_mensajes` (
`id` int(11) NOT NULL,
`usuario` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
`cuando` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`codocu` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`enviadoel` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`nombrefichero` text CHARACTER SET utf8,
`hidocu` bigint(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_mensajesd`
--

DROP TABLE IF EXISTS `public_mensajesd`;
CREATE TABLE IF NOT EXISTS `public_mensajesd` (
`correodestinatario` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
`esinterno` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`hidevento` bigint(20) DEFAULT NULL,
`id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_menu`
--

DROP TABLE IF EXISTS `public_menu`;
CREATE TABLE IF NOT EXISTS `public_menu` (
`codigo` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`idmenu` int(11) NOT NULL,
`hidmenu` int(11) DEFAULT NULL,
`menu` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_menugeneral`
--

DROP TABLE IF EXISTS `public_menugeneral`;
CREATE TABLE IF NOT EXISTS `public_menugeneral` (
`codigo` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`codpadre` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`opcion` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`tecla` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
`orden` smallint(6) DEFAULT NULL,
`mensaje` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
`codigo_a_ejecutar` longtext CHARACTER SET utf8,
`activo` smallint(6) DEFAULT NULL,
`flag` smallint(6) DEFAULT NULL,
`codmodulo` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_modulos`
--

DROP TABLE IF EXISTS `public_modulos`;
CREATE TABLE IF NOT EXISTS `public_modulos` (
`codigo` varchar(2) CHARACTER SET utf8 NOT NULL,
`descripcion` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`observacion` longtext CHARACTER SET utf8,
`codparametro` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`icono` longblob,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_motivo`
--

DROP TABLE IF EXISTS `public_motivo`;
CREATE TABLE IF NOT EXISTS `public_motivo` (
`codmotivo` varchar(3) CHARACTER SET utf8 NOT NULL,
`desmotivo` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_mot_materiales`
--

DROP TABLE IF EXISTS `public_mot_materiales`;
CREATE TABLE IF NOT EXISTS `public_mot_materiales` (
`fecha` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`id` int(11) NOT NULL,
`descripcion` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`numero` varchar(11) CHARACTER SET utf8 DEFAULT NULL,
`codcentro` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`codplanta` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`codtraba` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` longtext CHARACTER SET utf8,
`codep` varchar(3) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_mot_mat_det`
--

DROP TABLE IF EXISTS `public_mot_mat_det`;
CREATE TABLE IF NOT EXISTS `public_mot_mat_det` (
`id` int(11) NOT NULL,
`hidmot` bigint(20) DEFAULT NULL,
`item` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`codigo` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
`descripcion` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`obs` longtext CHARACTER SET utf8,
`um` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`codigoequipo` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`estado` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`codocu` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`cantidad` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_movimientos`
--

DROP TABLE IF EXISTS `public_movimientos`;
CREATE TABLE IF NOT EXISTS `public_movimientos` (
`codmov` varchar(3) CHARACTER SET utf8 NOT NULL,
`desmov` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`tipmov` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`IS` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_noticias`
--

DROP TABLE IF EXISTS `public_noticias`;
CREATE TABLE IF NOT EXISTS `public_noticias` (
`id` int(10) unsigned NOT NULL,
`txtnoticia` longtext CHARACTER SET utf8,
`fecha` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`autor` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
`expira` int(11) DEFAULT NULL,
`tiponoticia` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`mensaje` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`aprobado` int(11) DEFAULT NULL,
`fechapublicacion` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`fechapropuesta` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`fexpira` char(19) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_novedades`
--

DROP TABLE IF EXISTS `public_novedades`;
CREATE TABLE IF NOT EXISTS `public_novedades` (
`hidparte` int(11) DEFAULT NULL,
`codsistema` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`codigosap` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`codigoaf` varchar(13) CHARACTER SET utf8 DEFAULT NULL,
`descri` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`descridetalle` longtext CHARACTER SET utf8,
`criticidad` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`idnovedad` int(11) NOT NULL,
`idpartepesca` bigint(20) DEFAULT NULL,
`hora` longtext CHARACTER SET utf8,
`latitud` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`meridiano` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`lugar` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`ultimares` longtext CHARACTER SET utf8,
`usuario` varchar(25) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_nuke_authors`
--

DROP TABLE IF EXISTS `public_nuke_authors`;
CREATE TABLE IF NOT EXISTS `public_nuke_authors` (
`aid` varchar(25) CHARACTER SET utf8 NOT NULL,
`name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
`url` varchar(255) CHARACTER SET utf8 NOT NULL,
`email` varchar(255) CHARACTER SET utf8 NOT NULL,
`pwd` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`counter` bigint(20) NOT NULL,
`radminsuper` int(11) NOT NULL,
`admlanguage` varchar(30) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_nuke_cities`
--

DROP TABLE IF EXISTS `public_nuke_cities`;
CREATE TABLE IF NOT EXISTS `public_nuke_cities` (
`id` int(11) NOT NULL,
`local_id` int(11) NOT NULL,
`city` varchar(65) CHARACTER SET utf8 NOT NULL,
`cc` varchar(2) CHARACTER SET utf8 NOT NULL,
`country` varchar(35) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_nuke_pages`
--

DROP TABLE IF EXISTS `public_nuke_pages`;
CREATE TABLE IF NOT EXISTS `public_nuke_pages` (
`pid` int(11) NOT NULL,
`cid` int(11) NOT NULL,
`title` varchar(255) CHARACTER SET utf8 NOT NULL,
`subtitle` varchar(255) CHARACTER SET utf8 NOT NULL,
`active` int(11) NOT NULL,
`page_header` longtext CHARACTER SET utf8 NOT NULL,
`text` longtext CHARACTER SET utf8 NOT NULL,
`page_footer` longtext CHARACTER SET utf8 NOT NULL,
`signature` longtext CHARACTER SET utf8 NOT NULL,
`date` char(19) COLLATE utf8_unicode_ci NOT NULL,
`counter` int(11) NOT NULL,
`clanguage` varchar(30) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_nuke_stats_date`
--

DROP TABLE IF EXISTS `public_nuke_stats_date`;
CREATE TABLE IF NOT EXISTS `public_nuke_stats_date` (
`year` int(11) NOT NULL,
`month` int(11) NOT NULL,
`date` int(11) NOT NULL,
`hits` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_nuke_users`
--

DROP TABLE IF EXISTS `public_nuke_users`;
CREATE TABLE IF NOT EXISTS `public_nuke_users` (
`user_id` int(11) NOT NULL,
`name` varchar(60) CHARACTER SET utf8 NOT NULL,
`username` varchar(25) CHARACTER SET utf8 NOT NULL,
`user_email` varchar(255) CHARACTER SET utf8 NOT NULL,
`femail` varchar(255) CHARACTER SET utf8 NOT NULL,
`user_website` varchar(255) CHARACTER SET utf8 NOT NULL,
`user_avatar` varchar(255) CHARACTER SET utf8 NOT NULL,
`user_regdate` varchar(20) CHARACTER SET utf8 NOT NULL,
`user_icq` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
`user_occ` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
`user_from` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
`user_interests` varchar(150) CHARACTER SET utf8 NOT NULL,
`user_sig` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
`user_viewemail` int(11) DEFAULT NULL,
`user_theme` int(11) DEFAULT NULL,
`user_aim` varchar(18) CHARACTER SET utf8 DEFAULT NULL,
`user_yim` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`user_msnm` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`user_password` varchar(40) CHARACTER SET utf8 NOT NULL,
`storynum` int(11) NOT NULL,
`umode` varchar(10) CHARACTER SET utf8 NOT NULL,
`uorder` int(11) NOT NULL,
`thold` int(11) NOT NULL,
`noscore` int(11) NOT NULL,
`bio` longtext CHARACTER SET utf8 NOT NULL,
`ublockon` int(11) NOT NULL,
`ublock` longtext CHARACTER SET utf8 NOT NULL,
`theme` varchar(255) CHARACTER SET utf8 NOT NULL,
`commentmax` int(11) NOT NULL,
`counter` int(11) NOT NULL,
`newsletter` int(11) NOT NULL,
`user_posts` int(11) NOT NULL,
`user_attachsig` int(11) NOT NULL,
`user_rank` int(11) NOT NULL,
`user_level` int(11) NOT NULL,
`broadcast` int(11) NOT NULL,
`popmeson` int(11) NOT NULL,
`user_active` int(11) DEFAULT NULL,
`user_session_time` int(11) NOT NULL,
`user_session_page` int(11) NOT NULL,
`user_lastvisit` int(11) NOT NULL,
`user_timezone` int(11) NOT NULL,
`user_style` int(11) DEFAULT NULL,
`user_lang` varchar(255) CHARACTER SET utf8 NOT NULL,
`user_dateformat` varchar(14) CHARACTER SET utf8 NOT NULL,
`user_new_privmsg` int(11) NOT NULL,
`user_unread_privmsg` int(11) NOT NULL,
`user_last_privmsg` int(11) NOT NULL,
`user_emailtime` int(11) DEFAULT NULL,
`user_allowhtml` int(11) DEFAULT NULL,
`user_allowbbcode` int(11) DEFAULT NULL,
`user_allowsmile` int(11) DEFAULT NULL,
`user_allowavatar` int(11) NOT NULL,
`user_allow_pm` int(11) NOT NULL,
`user_allow_viewonline` int(11) NOT NULL,
`user_notify` int(11) NOT NULL,
`user_notify_pm` int(11) NOT NULL,
`user_popup_pm` int(11) NOT NULL,
`user_avatar_type` int(11) NOT NULL,
`user_sig_bbcode_uid` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`user_actkey` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
`user_newpasswd` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
`points` int(11) DEFAULT NULL,
`last_ip` varchar(15) CHARACTER SET utf8 NOT NULL,
`karma` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_nuke_users_temp`
--

DROP TABLE IF EXISTS `public_nuke_users_temp`;
CREATE TABLE IF NOT EXISTS `public_nuke_users_temp` (
`user_id` int(11) NOT NULL,
`username` varchar(25) CHARACTER SET utf8 NOT NULL,
`user_email` varchar(255) CHARACTER SET utf8 NOT NULL,
`user_password` varchar(40) CHARACTER SET utf8 NOT NULL,
`user_regdate` varchar(20) CHARACTER SET utf8 NOT NULL,
`check_num` varchar(50) CHARACTER SET utf8 NOT NULL,
`time` varchar(14) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_numerosobtenidos`
--

DROP TABLE IF EXISTS `public_numerosobtenidos`;
CREATE TABLE IF NOT EXISTS `public_numerosobtenidos` (
`usuario` longtext CHARACTER SET utf8,
`numero` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`nombretabla` longtext CHARACTER SET utf8,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_numerostemporales`
--

DROP TABLE IF EXISTS `public_numerostemporales`;
CREATE TABLE IF NOT EXISTS `public_numerostemporales` (
`numero` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
`tabla` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`usuario` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`ip` longtext CHARACTER SET utf8,
`puerto` int(11) DEFAULT NULL,
`modo` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_objetos_cliente`
--

DROP TABLE IF EXISTS `public_objetos_cliente`;
CREATE TABLE IF NOT EXISTS `public_objetos_cliente` (
`codpro` varchar(6) CHARACTER SET utf8 NOT NULL,
`codobjeto` varchar(3) CHARACTER SET utf8 NOT NULL,
`nombreobjeto` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`descripcionobjeto` longtext CHARACTER SET utf8,
`estado` int(11) DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_obras`
--

DROP TABLE IF EXISTS `public_obras`;
CREATE TABLE IF NOT EXISTS `public_obras` (
`descriobra` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`codigoaf` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
`fechasol` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`codep` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`fechacierre` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`cc` varchar(11) CHARACTER SET utf8 DEFAULT NULL,
`estado` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`om` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`obs` longtext CHARACTER SET utf8,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`centro` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`numero` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`prefijo` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`idobra` int(11) NOT NULL,
`fechacreacion` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`codigocompleto` varchar(16) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_observaciones`
--

DROP TABLE IF EXISTS `public_observaciones`;
CREATE TABLE IF NOT EXISTS `public_observaciones` (
`hidinventario` bigint(20) DEFAULT NULL,
`fecha` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`descri` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`mobs` longtext CHARACTER SET utf8,
`usuario` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`id` int(11) NOT NULL,
`codestado` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`codocu` varchar(3) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_observacionesdetalle`
--

DROP TABLE IF EXISTS `public_observacionesdetalle`;
CREATE TABLE IF NOT EXISTS `public_observacionesdetalle` (
`hidobservaciones` bigint(20) DEFAULT NULL,
`comentario` longtext CHARACTER SET utf8,
`usuario` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`id` int(11) NOT NULL,
`fecha` char(19) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_ocompra`
--

DROP TABLE IF EXISTS `public_ocompra`;
CREATE TABLE IF NOT EXISTS `public_ocompra` (
`numcot` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`codpro` varchar(6) CHARACTER SET utf8 NOT NULL,
`fecdoc` char(19) COLLATE utf8_unicode_ci NOT NULL,
`codcon` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`codestado` varchar(2) CHARACTER SET utf8 NOT NULL,
`texto` varchar(40) CHARACTER SET utf8 NOT NULL,
`textolargo` longtext CHARACTER SET utf8,
`tipologia` varchar(1) CHARACTER SET utf8 NOT NULL,
`moneda` varchar(3) CHARACTER SET utf8 NOT NULL,
`orcli` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
`descuento` smallint(6) NOT NULL,
`usuario` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`coddocu` varchar(3) CHARACTER SET utf8 NOT NULL,
`creado` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificado` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`codtipofac` varchar(2) CHARACTER SET utf8 NOT NULL,
`codsociedad` varchar(1) CHARACTER SET utf8 NOT NULL,
`codgrupoventas` varchar(3) CHARACTER SET utf8 NOT NULL,
`codtipocotizacion` varchar(1) CHARACTER SET utf8 NOT NULL,
`validez` int(11) NOT NULL,
`codcentro` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`nigv` double NOT NULL,
`codobjeto` varchar(3) CHARACTER SET utf8 NOT NULL,
`fechapresentacion` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`fechanominal` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`tenorsup` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`tenorinf` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`montototal` double NOT NULL,
`idguia` int(11) NOT NULL,
`idcontacto` int(11) DEFAULT NULL,
`correlativ` bigint(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_oficios`
--

DROP TABLE IF EXISTS `public_oficios`;
CREATE TABLE IF NOT EXISTS `public_oficios` (
`codof` varchar(3) CHARACTER SET utf8 NOT NULL,
`oficio` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_opciones`
--

DROP TABLE IF EXISTS `public_opciones`;
CREATE TABLE IF NOT EXISTS `public_opciones` (
`codigo` varchar(5) CHARACTER SET utf8 NOT NULL,
`codpadre` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`codform` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`transaccion` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
`codmodulo` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`grupo` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`tecla` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
`orden` smallint(6) DEFAULT NULL,
`mensaje` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
`codigo_a_ejecutar` longtext CHARACTER SET utf8,
`activo` smallint(6) DEFAULT NULL,
`flag` smallint(6) DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_opcionescamposdocu`
--

DROP TABLE IF EXISTS `public_opcionescamposdocu`;
CREATE TABLE IF NOT EXISTS `public_opcionescamposdocu` (
`id` int(11) NOT NULL,
`codocu` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`campo` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`nombrecampo` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`tipodato` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`longitud` int(11) DEFAULT NULL,
`nombredelmodelo` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`primercampolista` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`segundocampolista` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`seleccionable` longtext CHARACTER SET utf8
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_opcionesdocumentos`
--

DROP TABLE IF EXISTS `public_opcionesdocumentos`;
CREATE TABLE IF NOT EXISTS `public_opcionesdocumentos` (
`id` int(11) NOT NULL,
`usuario` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`codparam` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`valor` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`tipodato` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`seleccionador` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`codocu` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`idusuario` bigint(20) DEFAULT NULL,
`nombrecampo` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`nombretabla` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`idopdoc` bigint(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_opciones_envio_muestras`
--

DROP TABLE IF EXISTS `public_opciones_envio_muestras`;
CREATE TABLE IF NOT EXISTS `public_opciones_envio_muestras` (
`codpro` varchar(6) CHARACTER SET utf8 NOT NULL,
`ndirec` int(11) NOT NULL,
`chofer` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`codtra` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`usuario` varchar(50) CHARACTER SET utf8 NOT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_operaciones`
--

DROP TABLE IF EXISTS `public_operaciones`;
CREATE TABLE IF NOT EXISTS `public_operaciones` (
`numcot` varchar(7) CHARACTER SET utf8 DEFAULT NULL,
`item` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`idopera` bigint(20) NOT NULL,
`oper` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`operacionmayor` longtext CHARACTER SET utf8,
`mo` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_papa`
--

DROP TABLE IF EXISTS `public_papa`;
CREATE TABLE IF NOT EXISTS `public_papa` (
`cdopa` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`codp` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`descu` varchar(26) CHARACTER SET utf8 DEFAULT NULL,
`tete` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_papi`
--

DROP TABLE IF EXISTS `public_papi`;
CREATE TABLE IF NOT EXISTS `public_papi` (
`cc` longtext CHARACTER SET utf8,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_parametros`
--

DROP TABLE IF EXISTS `public_parametros`;
CREATE TABLE IF NOT EXISTS `public_parametros` (
`codpar` varchar(5) CHARACTER SET utf8 NOT NULL,
`codpadre` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`parametro` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`valor` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`apunta` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_parametrosdocumentos`
--

DROP TABLE IF EXISTS `public_parametrosdocumentos`;
CREATE TABLE IF NOT EXISTS `public_parametrosdocumentos` (
`codpara` varchar(5) CHARACTER SET utf8 NOT NULL,
`desparam` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`codigodoc` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`nivel` varchar(6) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_paraqueva`
--

DROP TABLE IF EXISTS `public_paraqueva`;
CREATE TABLE IF NOT EXISTS `public_paraqueva` (
`cmotivo` varchar(2) CHARACTER SET utf8 NOT NULL,
`motivo` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_pareto`
--

DROP TABLE IF EXISTS `public_pareto`;
CREATE TABLE IF NOT EXISTS `public_pareto` (
`ranking` int(11) NOT NULL,
`clase` char(1) COLLATE utf8_unicode_ci NOT NULL,
`acumulado` double NOT NULL,
`porcentaje` double NOT NULL,
`hinventario` bigint(20) NOT NULL,
`idsesion` int(11) NOT NULL,
`column_7` int(11) NOT NULL,
`porcentajeac` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_partes`
--

DROP TABLE IF EXISTS `public_partes`;
CREATE TABLE IF NOT EXISTS `public_partes` (
`numero` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`fecha` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`puerto` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`puertodes` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`horometro` int(11) DEFAULT NULL,
`horometrodes` int(11) DEFAULT NULL,
`numerodecalas` int(11) DEFAULT NULL,
`codep` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`velocidad` int(11) DEFAULT NULL,
`tempagua` int(11) DEFAULT NULL,
`presionaceite` int(11) DEFAULT NULL,
`idusuario` int(11) DEFAULT NULL,
`zarpo` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`causa` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`m_rpm` int(11) DEFAULT NULL,
`m_velocidad` double DEFAULT NULL,
`m_tempagua` int(11) DEFAULT NULL,
`m_presionaceite` int(11) DEFAULT NULL,
`m_tempaceite` int(11) DEFAULT NULL,
`m_difpaceite` int(11) DEFAULT NULL,
`m_presionpetroleo` int(11) DEFAULT NULL,
`m_difpfpetroleo` int(11) DEFAULT NULL,
`m_restfairebr` int(11) DEFAULT NULL,
`m_restfaireer` int(11) DEFAULT NULL,
`m_taireadm` int(11) DEFAULT NULL,
`m_tgasesturbo` int(11) DEFAULT NULL,
`m_tgases1y2` int(11) DEFAULT NULL,
`m_tgases3y4` int(11) DEFAULT NULL,
`m_tgases5y6` int(11) DEFAULT NULL,
`m_tgases7y8` int(11) DEFAULT NULL,
`m_tgases9y10` int(11) DEFAULT NULL,
`m_tgases11y12` int(11) DEFAULT NULL,
`m_tgases13y14` int(11) DEFAULT NULL,
`m_tgases15y16` int(11) DEFAULT NULL,
`caja_taceite` int(11) DEFAULT NULL,
`caja_paceite` int(11) DEFAULT NULL,
`panga_rpm` int(11) DEFAULT NULL,
`panga_taguamot` int(11) DEFAULT NULL,
`panga_paceitemotor` int(11) DEFAULT NULL,
`panga_paceitecaja` int(11) DEFAULT NULL,
`d2_zarpe` double DEFAULT NULL,
`d2_arribo` double DEFAULT NULL,
`d2_estimadohora` double DEFAULT NULL,
`d2_observaciones` longtext CHARACTER SET utf8,
`acylu_consumomotor` int(11) DEFAULT NULL,
`acylu_consumocaja` int(11) DEFAULT NULL,
`acylu_consumohid` int(11) DEFAULT NULL,
`acylu_consumograsa` int(11) DEFAULT NULL,
`acylu_observaciones` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
`acylu_fechaultimocambiomotor` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`acylu_horometroultimocambio` int(11) DEFAULT NULL,
`acylu_fechaultimocambiocaja` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`acylu_horometroultimocambiocaja` int(11) DEFAULT NULL,
`observacionesfinales` longtext CHARACTER SET utf8,
`fechazarpe` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`fechaarribo` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_pedido`
--

DROP TABLE IF EXISTS `public_pedido`;
CREATE TABLE IF NOT EXISTS `public_pedido` (
`numped` varchar(8) CHARACTER SET utf8 NOT NULL,
`fecped` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`desped` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
`codgru` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`codplazo` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`estado` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`usuario` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`provesug` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_periodos`
--

DROP TABLE IF EXISTS `public_periodos`;
CREATE TABLE IF NOT EXISTS `public_periodos` (
`id` int(11) NOT NULL,
`mes` char(2) COLLATE utf8_unicode_ci NOT NULL,
`anno` char(2) COLLATE utf8_unicode_ci NOT NULL,
`usuario` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
`creacion` datetime NOT NULL,
`inicio` date NOT NULL,
`final` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_permisos`
--

DROP TABLE IF EXISTS `public_permisos`;
CREATE TABLE IF NOT EXISTS `public_permisos` (
`idpermiso` int(11) DEFAULT NULL,
`coddocu` varchar(3) CHARACTER SET utf8 NOT NULL,
`codpermiso` varchar(2) CHARACTER SET utf8 NOT NULL,
`rolusuario` varchar(30) CHARACTER SET utf8 NOT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_permisoscentros`
--

DROP TABLE IF EXISTS `public_permisoscentros`;
CREATE TABLE IF NOT EXISTS `public_permisoscentros` (
`nombrerol` longtext CHARACTER SET utf8,
`nombretabla` longtext CHARACTER SET utf8,
`nombrecampo` longtext CHARACTER SET utf8,
`valorcampo` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_permisosgenerales`
--

DROP TABLE IF EXISTS `public_permisosgenerales`;
CREATE TABLE IF NOT EXISTS `public_permisosgenerales` (
`despermiso` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
`codpermiso` varchar(2) CHARACTER SET utf8 NOT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_personal`
--

DROP TABLE IF EXISTS `public_personal`;
CREATE TABLE IF NOT EXISTS `public_personal` (
`codpersona` varchar(4) CHARACTER SET utf8 NOT NULL,
`nombres` varchar(25) CHARACTER SET utf8 NOT NULL,
`ap` varchar(40) CHARACTER SET utf8 NOT NULL,
`am` varchar(25) CHARACTER SET utf8 NOT NULL,
`dni` varchar(8) CHARACTER SET utf8 NOT NULL,
`d_fecna` char(19) COLLATE utf8_unicode_ci NOT NULL,
`sexo` varchar(1) CHARACTER SET utf8 NOT NULL,
`foto` longblob,
`d_fecin` char(19) COLLATE utf8_unicode_ci NOT NULL,
`activo` int(11) NOT NULL,
`codpuesto` varchar(3) CHARACTER SET utf8 NOT NULL,
`gruposang` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`alergico` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`telefonos` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`descri` longtext CHARACTER SET utf8,
`ubnac` varchar(6) CHARACTER SET utf8 NOT NULL,
`ubvi` varchar(6) CHARACTER SET utf8 NOT NULL,
`domicilio` varchar(50) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_personal_calendario`
--

DROP TABLE IF EXISTS `public_personal_calendario`;
CREATE TABLE IF NOT EXISTS `public_personal_calendario` (
`id` bigint(20) NOT NULL,
`orden` int(11) NOT NULL,
`fecha` char(19) COLLATE utf8_unicode_ci NOT NULL,
`hid` bigint(20) NOT NULL,
`hinicio` longtext CHARACTER SET utf8 NOT NULL,
`hfinal` longtext CHARACTER SET utf8 NOT NULL,
`feriado` int(11) NOT NULL,
`laborable` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_personal_externo`
--

DROP TABLE IF EXISTS `public_personal_externo`;
CREATE TABLE IF NOT EXISTS `public_personal_externo` (
`idpersona` int(11) NOT NULL,
`codpro` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`apaterno` varchar(35) CHARACTER SET utf8 NOT NULL,
`amaterno` varchar(35) CHARACTER SET utf8 NOT NULL,
`nombres` varchar(25) CHARACTER SET utf8 NOT NULL,
`dni` varchar(8) CHARACTER SET utf8 NOT NULL,
`chapa` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
`tiposangre` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`telefono` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`familiarcercano` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`parentesco` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
`oficio` varchar(3) CHARACTER SET utf8 NOT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_personal_periodo`
--

DROP TABLE IF EXISTS `public_personal_periodo`;
CREATE TABLE IF NOT EXISTS `public_personal_periodo` (
`id` bigint(20) NOT NULL,
`nombre del periodo` varchar(40) CHARACTER SET utf8 NOT NULL,
`finicio` char(19) COLLATE utf8_unicode_ci NOT NULL,
`ftermino` char(19) COLLATE utf8_unicode_ci NOT NULL,
`codcentro` varchar(3) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_personal_turnos`
--

DROP TABLE IF EXISTS `public_personal_turnos`;
CREATE TABLE IF NOT EXISTS `public_personal_turnos` (
`codturno` varchar(3) CHARACTER SET utf8 NOT NULL,
`desturno` varchar(40) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_personal_turno_detalle`
--

DROP TABLE IF EXISTS `public_personal_turno_detalle`;
CREATE TABLE IF NOT EXISTS `public_personal_turno_detalle` (
`codturno` varchar(3) CHARACTER SET utf8 NOT NULL,
`dia` varchar(2) CHARACTER SET utf8 NOT NULL,
`hingreso` longtext CHARACTER SET utf8 NOT NULL,
`hinrefri` longtext CHARACTER SET utf8 NOT NULL,
`hsarefri` longtext CHARACTER SET utf8 NOT NULL,
`hsalida` longtext CHARACTER SET utf8 NOT NULL,
`tolerancia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_pescaterceros`
--

DROP TABLE IF EXISTS `public_pescaterceros`;
CREATE TABLE IF NOT EXISTS `public_pescaterceros` (
`id` int(11) NOT NULL,
`codplanta` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`pesca` int(11) DEFAULT NULL,
`numeroep` int(11) DEFAULT NULL,
`fecha` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`factor` double DEFAULT NULL,
`idespecie` int(11) DEFAULT NULL,
`idtemporada` int(11) DEFAULT NULL,
`semana` int(11) DEFAULT NULL,
`zonalitoral` varchar(3) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_peticion`
--

DROP TABLE IF EXISTS `public_peticion`;
CREATE TABLE IF NOT EXISTS `public_peticion` (
`id` bigint(20) NOT NULL,
`codpro` varchar(6) CHARACTER SET utf8 NOT NULL,
`numero` varchar(12) CHARACTER SET utf8 NOT NULL,
`fecha` date NOT NULL,
`usuario` varchar(25) CHARACTER SET utf8 NOT NULL,
`fechacreac` datetime NOT NULL,
`comentario` text CHARACTER SET utf8 NOT NULL,
`textocorto` varchar(40) CHARACTER SET utf8 NOT NULL,
`idcontacto` int(11) NOT NULL,
`iduser` int(11) NOT NULL,
`codocu` char(3) CHARACTER SET utf8 NOT NULL,
`codestado` char(2) CHARACTER SET utf8 NOT NULL,
`correlativo` int(11) NOT NULL,
`prefijo` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
`codmon` char(3) CHARACTER SET utf8 NOT NULL,
`descuento` decimal(10,0) NOT NULL,
`idtemp` bigint(20) NOT NULL,
`item` char(3) COLLATE utf8_unicode_ci DEFAULT NULL,
`grupocompras` char(3) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=151 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_plantas`
--

DROP TABLE IF EXISTS `public_plantas`;
CREATE TABLE IF NOT EXISTS `public_plantas` (
`codplanta` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`desplanta` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`codigozona` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`capacidad` int(11) DEFAULT NULL,
`factor` double DEFAULT NULL,
`activa` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`ID_` int(11) DEFAULT NULL,
`des` int(11) DEFAULT NULL,
`id` int(11) NOT NULL,
`centrito` varchar(4) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_player`
--

DROP TABLE IF EXISTS `public_player`;
CREATE TABLE IF NOT EXISTS `public_player` (
`iplayer` int(11) NOT NULL,
`firstname` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`lastname` varchar(30) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_post`
--

DROP TABLE IF EXISTS `public_post`;
CREATE TABLE IF NOT EXISTS `public_post` (
`id` int(11) NOT NULL,
`author_id` int(11) NOT NULL,
`thread_id` int(11) NOT NULL,
`editor_id` int(11) DEFAULT NULL,
`content` longtext CHARACTER SET utf8 NOT NULL,
`created` int(11) NOT NULL,
`updated` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_preferencias_campos`
--

DROP TABLE IF EXISTS `public_preferencias_campos`;
CREATE TABLE IF NOT EXISTS `public_preferencias_campos` (
`id` bigint(20) NOT NULL,
`usuario` longtext CHARACTER SET utf8 NOT NULL,
`nombrevista` longtext CHARACTER SET utf8 NOT NULL,
`campo` longtext CHARACTER SET utf8 NOT NULL,
`aliascampo` longtext CHARACTER SET utf8 NOT NULL,
`activo` int(11) NOT NULL,
`orden` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_presupuesto`
--

DROP TABLE IF EXISTS `public_presupuesto`;
CREATE TABLE IF NOT EXISTS `public_presupuesto` (
`codep` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`anno` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`codsistema` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`tipo` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`idpresupuesto` bigint(20) NOT NULL,
`moneda` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`tipooperacion` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`enero` double DEFAULT NULL,
`febrero` double DEFAULT NULL,
`marzo` double DEFAULT NULL,
`abril` double DEFAULT NULL,
`mayo` double DEFAULT NULL,
`junio` double DEFAULT NULL,
`julio` double DEFAULT NULL,
`agosto` double DEFAULT NULL,
`setiembre` double DEFAULT NULL,
`octubre` double DEFAULT NULL,
`noviembre` double DEFAULT NULL,
`diciembre` double DEFAULT NULL,
`porcentajemo` double DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_prueba`
--

DROP TABLE IF EXISTS `public_prueba`;
CREATE TABLE IF NOT EXISTS `public_prueba` (
`uno` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
`dos` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_pruebas`
--

DROP TABLE IF EXISTS `public_pruebas`;
CREATE TABLE IF NOT EXISTS `public_pruebas` (
`name` varchar(23) CHARACTER SET utf8 DEFAULT NULL,
`apellido` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`codigo` varchar(4) CHARACTER SET utf8 NOT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_puente`
--

DROP TABLE IF EXISTS `public_puente`;
CREATE TABLE IF NOT EXISTS `public_puente` (
`codocu1` varchar(3) CHARACTER SET utf8 NOT NULL,
`id1` bigint(20) NOT NULL,
`codocu2` varchar(3) CHARACTER SET utf8 NOT NULL,
`id2` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_puestos`
--

DROP TABLE IF EXISTS `public_puestos`;
CREATE TABLE IF NOT EXISTS `public_puestos` (
`codpuesto` varchar(3) CHARACTER SET utf8 NOT NULL,
`despuesto` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_pupu`
--

DROP TABLE IF EXISTS `public_pupu`;
CREATE TABLE IF NOT EXISTS `public_pupu` (
`codi` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`descri` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_rangousuario`
--

DROP TABLE IF EXISTS `public_rangousuario`;
CREATE TABLE IF NOT EXISTS `public_rangousuario` (
`codrango` varchar(2) CHARACTER SET utf8 NOT NULL,
`rango` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_rangousuariomodulo`
--

DROP TABLE IF EXISTS `public_rangousuariomodulo`;
CREATE TABLE IF NOT EXISTS `public_rangousuariomodulo` (
`codigo` varchar(2) CHARACTER SET utf8 NOT NULL,
`codrango` varchar(2) CHARACTER SET utf8 NOT NULL,
`usuario` varchar(25) CHARACTER SET utf8 NOT NULL,
`modpor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`fechamod` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_reparaciones`
--

DROP TABLE IF EXISTS `public_reparaciones`;
CREATE TABLE IF NOT EXISTS `public_reparaciones` (
`numrep` varchar(8) CHARACTER SET utf8 NOT NULL,
`desrep` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`fecha` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`codep` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`texto` longtext CHARACTER SET utf8,
`estado` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`idrep` bigint(20) NOT NULL,
`codobjetivo` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`ordenpm` varchar(7) CHARACTER SET utf8 DEFAULT NULL,
`codigo` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`codigoplaca` varchar(11) CHARACTER SET utf8 DEFAULT NULL,
`link` longtext CHARACTER SET utf8,
`iplink` varchar(14) CHARACTER SET utf8 DEFAULT NULL,
`codocu` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`codtrabajador` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`cnumcargo` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`codcentro` varchar(4) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_reportepesca`
--

DROP TABLE IF EXISTS `public_reportepesca`;
CREATE TABLE IF NOT EXISTS `public_reportepesca` (
`codep` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`id` int(11) NOT NULL,
`semana` int(11) DEFAULT NULL,
`fecha` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`harribo` longtext CHARACTER SET utf8,
`hzarpe` longtext CHARACTER SET utf8,
`codplantadestino` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`codplantazarpe` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`declarada` int(11) DEFAULT NULL,
`descargada` double DEFAULT NULL,
`d2` int(11) DEFAULT NULL,
`codzarpe` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`r1` int(11) DEFAULT NULL,
`r2` int(11) DEFAULT NULL,
`r3` int(11) DEFAULT NULL,
`r4` int(11) DEFAULT NULL,
`r5` int(11) DEFAULT NULL,
`r6` int(11) DEFAULT NULL,
`r7` int(11) DEFAULT NULL,
`r8` int(11) DEFAULT NULL,
`r9` int(11) DEFAULT NULL,
`r10` int(11) DEFAULT NULL,
`r11` int(11) DEFAULT NULL,
`r12` int(11) DEFAULT NULL,
`zona` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`idespecie` int(11) DEFAULT NULL,
`idtemporada` int(11) DEFAULT NULL,
`comenatrio` longtext CHARACTER SET utf8,
`latitud` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`meridiano` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`zonapesca` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`evento` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`fechazarpe` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`fechaarribo` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`descargada1` double DEFAULT NULL,
`capbodega` int(11) DEFAULT NULL,
`zonalitoral` varchar(3) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_reportepesca_coor`
--

DROP TABLE IF EXISTS `public_reportepesca_coor`;
CREATE TABLE IF NOT EXISTS `public_reportepesca_coor` (
`hidreporte` bigint(20) DEFAULT NULL,
`latitud` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`meridiano` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`aliaszona` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_reportes`
--

DROP TABLE IF EXISTS `public_reportes`;
CREATE TABLE IF NOT EXISTS `public_reportes` (
`codocu` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`nombrecampo` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
`etiqueta` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
`absisa` int(11) DEFAULT NULL,
`ordenada` int(11) DEFAULT NULL,
`fuente` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`tamanofuente` int(11) DEFAULT NULL,
`id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_repuestos`
--

DROP TABLE IF EXISTS `public_repuestos`;
CREATE TABLE IF NOT EXISTS `public_repuestos` (
`codigocompo` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`codigorep` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`cant` double DEFAULT NULL,
`modo` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_resumenpresupuesto`
--

DROP TABLE IF EXISTS `public_resumenpresupuesto`;
CREATE TABLE IF NOT EXISTS `public_resumenpresupuesto` (
`anno` varchar(4) CHARACTER SET utf8 NOT NULL,
`codep` varchar(3) CHARACTER SET utf8 NOT NULL,
`codsistema` varchar(5) CHARACTER SET utf8 NOT NULL,
`gastoacumulado` double DEFAULT NULL,
`totpres` double DEFAULT NULL,
`totpresanual` double DEFAULT NULL,
`totpresbarco` double DEFAULT NULL,
`tipo` varchar(1) CHARACTER SET utf8 NOT NULL,
`mes` double DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_roles`
--

DROP TABLE IF EXISTS `public_roles`;
CREATE TABLE IF NOT EXISTS `public_roles` (
`idrol` smallint(6) NOT NULL,
`codigorol` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`desrol` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`codmodulo` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_rolesopciones`
--

DROP TABLE IF EXISTS `public_rolesopciones`;
CREATE TABLE IF NOT EXISTS `public_rolesopciones` (
`idrol` longtext CHARACTER SET utf8,
`codopcion` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`valido` int(11) DEFAULT NULL,
`usuario` longtext CHARACTER SET utf8,
`fechamodificacion` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`modificado` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_rolestransa`
--

DROP TABLE IF EXISTS `public_rolestransa`;
CREATE TABLE IF NOT EXISTS `public_rolestransa` (
`idrol` int(11) DEFAULT NULL,
`codtransa` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_seleccionable`
--

DROP TABLE IF EXISTS `public_seleccionable`;
CREATE TABLE IF NOT EXISTS `public_seleccionable` (
`codsel` varchar(3) CHARACTER SET utf8 NOT NULL,
`desel` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`codigo` longtext CHARACTER SET utf8
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_servidorremoto`
--

DROP TABLE IF EXISTS `public_servidorremoto`;
CREATE TABLE IF NOT EXISTS `public_servidorremoto` (
`servidor` varchar(100) CHARACTER SET utf8 NOT NULL,
`detalle` varchar(150) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_sesiones`
--

DROP TABLE IF EXISTS `public_sesiones`;
CREATE TABLE IF NOT EXISTS `public_sesiones` (
`ip` varchar(15) CHARACTER SET utf8 NOT NULL,
`usuario` varchar(25) CHARACTER SET utf8 NOT NULL,
`horacon` varchar(18) CHARACTER SET utf8 DEFAULT NULL,
`nombrepc` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`puerto` int(11) DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_sesionesweb`
--

DROP TABLE IF EXISTS `public_sesionesweb`;
CREATE TABLE IF NOT EXISTS `public_sesionesweb` (
`sesion` text CHARACTER SET utf8,
`usuario` longtext CHARACTER SET utf8,
`horainicio` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`ipmaquina` longtext CHARACTER SET utf8,
`rol` longtext CHARACTER SET utf8,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_sistemas`
--

DROP TABLE IF EXISTS `public_sistemas`;
CREATE TABLE IF NOT EXISTS `public_sistemas` (
`codsistema` varchar(5) CHARACTER SET utf8 NOT NULL,
`sistema` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`codpadre` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`descripcion` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_sociedades`
--

DROP TABLE IF EXISTS `public_sociedades`;
CREATE TABLE IF NOT EXISTS `public_sociedades` (
`socio` varchar(1) CHARACTER SET utf8 NOT NULL,
`dsocio` varchar(40) CHARACTER SET utf8 NOT NULL,
`rucsoc` varchar(11) CHARACTER SET utf8 NOT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_solpe`
--

DROP TABLE IF EXISTS `public_solpe`;
CREATE TABLE IF NOT EXISTS `public_solpe` (
`numero` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`tipo` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`textocabecera` longtext CHARACTER SET utf8,
`creado` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`autor` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
`estado` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`fechadoc` date DEFAULT NULL,
`fechanec` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`id` bigint(20) NOT NULL,
`codocu` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`escompra` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`correlativ` bigint(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=259 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_subclase`
--

DROP TABLE IF EXISTS `public_subclase`;
CREATE TABLE IF NOT EXISTS `public_subclase` (
`codcla` varchar(3) CHARACTER SET utf8 NOT NULL,
`subcla` varchar(3) CHARACTER SET utf8 NOT NULL,
`desub` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`obsub` longtext CHARACTER SET utf8,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_subcomponentes`
--

DROP TABLE IF EXISTS `public_subcomponentes`;
CREATE TABLE IF NOT EXISTS `public_subcomponentes` (
`codigo` varchar(8) CHARACTER SET utf8 NOT NULL,
`cant` bigint(20) DEFAULT NULL,
`codalternativo` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`codpadre` varchar(8) CHARACTER SET utf8 NOT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_submodulos`
--

DROP TABLE IF EXISTS `public_submodulos`;
CREATE TABLE IF NOT EXISTS `public_submodulos` (
`codgrupo` varchar(3) CHARACTER SET utf8 NOT NULL,
`desgrupomodulo` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`codmodulo` varchar(2) CHARACTER SET utf8 NOT NULL,
`orden` int(11) DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_sys_access`
--

DROP TABLE IF EXISTS `public_sys_access`;
CREATE TABLE IF NOT EXISTS `public_sys_access` (
`idaccess` int(11) NOT NULL,
`desc_access` varchar(45) CHARACTER SET utf8 NOT NULL,
`datefrom` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`dateto` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`maxlevel` int(11) NOT NULL,
`terminal` varchar(20) CHARACTER SET utf8 NOT NULL,
`username` varchar(20) CHARACTER SET utf8 NOT NULL,
`ts` char(19) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_sys_accessforms`
--

DROP TABLE IF EXISTS `public_sys_accessforms`;
CREATE TABLE IF NOT EXISTS `public_sys_accessforms` (
`idaccess` int(11) NOT NULL,
`idform` int(11) NOT NULL,
`level1` bit(1) NOT NULL,
`level2` bit(1) NOT NULL,
`level3` bit(1) NOT NULL,
`level4` bit(1) NOT NULL,
`level5` bit(1) NOT NULL,
`terminal` varchar(20) CHARACTER SET utf8 NOT NULL,
`username` varchar(20) CHARACTER SET utf8 NOT NULL,
`ts` char(19) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_sys_errorlogs`
--

DROP TABLE IF EXISTS `public_sys_errorlogs`;
CREATE TABLE IF NOT EXISTS `public_sys_errorlogs` (
`iderrorlog` int(11) NOT NULL,
`errorno` int(11) NOT NULL,
`errorole` int(11) NOT NULL,
`errormsg` varchar(150) CHARACTER SET utf8 NOT NULL,
`errorstack` longtext CHARACTER SET utf8 NOT NULL,
`terminal` varchar(20) CHARACTER SET utf8 NOT NULL,
`username` varchar(20) CHARACTER SET utf8 NOT NULL,
`ts` char(19) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_sys_forms`
--

DROP TABLE IF EXISTS `public_sys_forms`;
CREATE TABLE IF NOT EXISTS `public_sys_forms` (
`idform` int(11) NOT NULL,
`form` varchar(50) CHARACTER SET utf8 NOT NULL,
`desc_form` varchar(80) CHARACTER SET utf8 NOT NULL,
`level1` bit(1) NOT NULL,
`level2` bit(1) NOT NULL,
`level3` bit(1) NOT NULL,
`level4` bit(1) NOT NULL,
`level5` bit(1) NOT NULL,
`system` bit(1) NOT NULL,
`terminal` varchar(20) CHARACTER SET utf8 NOT NULL,
`username` varchar(20) CHARACTER SET utf8 NOT NULL,
`ts` char(19) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_sys_languages`
--

DROP TABLE IF EXISTS `public_sys_languages`;
CREATE TABLE IF NOT EXISTS `public_sys_languages` (
`idlanguage` int(11) NOT NULL,
`desc_language` varchar(50) CHARACTER SET utf8 NOT NULL,
`terminal` varchar(20) CHARACTER SET utf8 NOT NULL,
`username` varchar(20) CHARACTER SET utf8 NOT NULL,
`ts` char(19) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_sys_languageword`
--

DROP TABLE IF EXISTS `public_sys_languageword`;
CREATE TABLE IF NOT EXISTS `public_sys_languageword` (
`idlanguage` int(11) NOT NULL,
`idword` int(11) NOT NULL,
`word` varchar(250) CHARACTER SET utf8 NOT NULL,
`terminal` varchar(20) CHARACTER SET utf8 NOT NULL,
`username` varchar(20) CHARACTER SET utf8 NOT NULL,
`ts` char(19) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_sys_menues`
--

DROP TABLE IF EXISTS `public_sys_menues`;
CREATE TABLE IF NOT EXISTS `public_sys_menues` (
`idmenu` int(11) NOT NULL,
`menu` varchar(50) CHARACTER SET utf8 NOT NULL,
`submenu` varchar(50) CHARACTER SET utf8 NOT NULL,
`orderby` int(11) NOT NULL,
`name` varchar(50) CHARACTER SET utf8 NOT NULL,
`command` varchar(100) CHARACTER SET utf8 NOT NULL,
`iconopath` varchar(100) CHARACTER SET utf8 NOT NULL,
`terminal` varchar(20) CHARACTER SET utf8 NOT NULL,
`username` varchar(20) CHARACTER SET utf8 NOT NULL,
`ts` char(19) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_sys_tableconfig`
--

DROP TABLE IF EXISTS `public_sys_tableconfig`;
CREATE TABLE IF NOT EXISTS `public_sys_tableconfig` (
`idtable` int(11) NOT NULL,
`tablename` varchar(50) CHARACTER SET utf8 NOT NULL,
`keyfield` varchar(30) CHARACTER SET utf8 NOT NULL,
`idautoinc` bit(1) NOT NULL,
`lastnumber` int(11) NOT NULL,
`cryptfield` varchar(100) CHARACTER SET utf8 NOT NULL,
`terminal` varchar(20) CHARACTER SET utf8 NOT NULL,
`username` varchar(20) CHARACTER SET utf8 NOT NULL,
`ts` char(19) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_sys_userconfig`
--

DROP TABLE IF EXISTS `public_sys_userconfig`;
CREATE TABLE IF NOT EXISTS `public_sys_userconfig` (
`idcxu` int(11) NOT NULL,
`iduser` int(11) NOT NULL,
`normaltextforecolor` int(11) NOT NULL,
`normaltextbackcolor` int(11) NOT NULL,
`prkeytextforecolor` int(11) NOT NULL,
`prkeytextbackcolor` int(11) NOT NULL,
`labelforecolor` int(11) NOT NULL,
`gridbackcolorline1` int(11) NOT NULL,
`gridbackcolorline2` int(11) NOT NULL,
`gridactuallinebackcolor` int(11) NOT NULL,
`gridforecolortext` int(11) NOT NULL,
`objectdisabledbackcolor` int(11) NOT NULL,
`objectdisabledforecolor` int(11) NOT NULL,
`modulobackcolor` int(11) NOT NULL,
`hiperlinkforecolor` int(11) NOT NULL,
`formabmbackcolor` int(11) NOT NULL,
`formpadrebackcolor` int(11) NOT NULL,
`formwebbackcolor` int(11) NOT NULL,
`webstyle` varchar(1) CHARACTER SET utf8 NOT NULL,
`backstandardbutton` int(11) NOT NULL,
`forestandardbutton` int(11) NOT NULL,
`backacceptbutton` int(11) NOT NULL,
`foreacceptbutton` int(11) NOT NULL,
`backcancelbutton` int(11) NOT NULL,
`forecancelbutton` int(11) NOT NULL,
`terminal` varchar(20) CHARACTER SET utf8 NOT NULL,
`username` varchar(50) CHARACTER SET utf8 NOT NULL,
`ts` char(19) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_sys_users`
--

DROP TABLE IF EXISTS `public_sys_users`;
CREATE TABLE IF NOT EXISTS `public_sys_users` (
`iduser` int(11) NOT NULL,
`idaccess` int(11) NOT NULL,
`idlanguage` int(11) NOT NULL,
`lastname` varchar(30) CHARACTER SET utf8 NOT NULL,
`firstname` varchar(30) CHARACTER SET utf8 NOT NULL,
`login` varchar(20) CHARACTER SET utf8 NOT NULL,
`password` varchar(20) CHARACTER SET utf8 NOT NULL,
`active` varchar(1) CHARACTER SET utf8 NOT NULL,
`finaldate` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`changepwd` varchar(1) CHARACTER SET utf8 NOT NULL,
`terminal` varchar(20) CHARACTER SET utf8 NOT NULL,
`username` varchar(20) CHARACTER SET utf8 NOT NULL,
`ts` char(19) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_sys_words`
--

DROP TABLE IF EXISTS `public_sys_words`;
CREATE TABLE IF NOT EXISTS `public_sys_words` (
`idword` int(11) NOT NULL,
`keyword` varchar(50) CHARACTER SET utf8 NOT NULL,
`terminal` varchar(20) CHARACTER SET utf8 NOT NULL,
`username` varchar(20) CHARACTER SET utf8 NOT NULL,
`ts` char(19) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_tablaigv`
--

DROP TABLE IF EXISTS `public_tablaigv`;
CREATE TABLE IF NOT EXISTS `public_tablaigv` (
`valorigv` double NOT NULL,
`fechainicio` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`fechafin` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`activo` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_tbl_albums`
--

DROP TABLE IF EXISTS `public_tbl_albums`;
CREATE TABLE IF NOT EXISTS `public_tbl_albums` (
`id` int(11) NOT NULL,
`pid` int(11) NOT NULL,
`url` longtext CHARACTER SET utf8 NOT NULL,
`translations` longtext CHARACTER SET utf8 NOT NULL,
`imgsorder` longtext CHARACTER SET utf8 NOT NULL,
`imgsinfo` longtext CHARACTER SET utf8 NOT NULL,
`cover` text CHARACTER SET utf8 NOT NULL,
`iteminfoshop` longtext CHARACTER SET utf8 NOT NULL,
`author` varchar(128) CHARACTER SET utf8 NOT NULL,
`tags` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_tbl_category`
--

DROP TABLE IF EXISTS `public_tbl_category`;
CREATE TABLE IF NOT EXISTS `public_tbl_category` (
`id` int(11) NOT NULL,
`name` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
`position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_tbl_collections`
--

DROP TABLE IF EXISTS `public_tbl_collections`;
CREATE TABLE IF NOT EXISTS `public_tbl_collections` (
`id` int(11) NOT NULL,
`pid` int(11) NOT NULL,
`url` longtext CHARACTER SET utf8 NOT NULL,
`translations` longtext CHARACTER SET utf8 NOT NULL,
`albums` varchar(128) CHARACTER SET utf8 NOT NULL,
`author` varchar(128) CHARACTER SET utf8 NOT NULL,
`tags` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_tbl_comment`
--

DROP TABLE IF EXISTS `public_tbl_comment`;
CREATE TABLE IF NOT EXISTS `public_tbl_comment` (
`id` int(11) NOT NULL,
`content` longtext CHARACTER SET utf8 NOT NULL,
`userid` int(11) NOT NULL,
`created` int(11) NOT NULL,
`updated` int(11) NOT NULL,
`topicid` int(11) NOT NULL,
`rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_tbl_galleryconfig`
--

DROP TABLE IF EXISTS `public_tbl_galleryconfig`;
CREATE TABLE IF NOT EXISTS `public_tbl_galleryconfig` (
`type` varchar(16) CHARACTER SET utf8 NOT NULL,
`config` longtext CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_tbl_menu`
--

DROP TABLE IF EXISTS `public_tbl_menu`;
CREATE TABLE IF NOT EXISTS `public_tbl_menu` (
`parent_id` int(11) DEFAULT NULL,
`title` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`position` int(11) DEFAULT NULL,
`id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_tbl_profiles`
--

DROP TABLE IF EXISTS `public_tbl_profiles`;
CREATE TABLE IF NOT EXISTS `public_tbl_profiles` (
`user_id` int(11) NOT NULL,
`lastname` varchar(50) CHARACTER SET utf8 NOT NULL,
`firstname` varchar(50) CHARACTER SET utf8 NOT NULL,
`dni` varchar(8) CHARACTER SET utf8 NOT NULL,
`codep` varchar(3) CHARACTER SET utf8 NOT NULL,
`amaterno` varchar(20) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_tbl_profiles_fields`
--

DROP TABLE IF EXISTS `public_tbl_profiles_fields`;
CREATE TABLE IF NOT EXISTS `public_tbl_profiles_fields` (
`id` int(11) NOT NULL,
`varname` varchar(50) CHARACTER SET utf8 NOT NULL,
`title` varchar(255) CHARACTER SET utf8 NOT NULL,
`field_type` varchar(50) CHARACTER SET utf8 NOT NULL,
`field_size` varchar(15) CHARACTER SET utf8 NOT NULL,
`field_size_min` varchar(15) CHARACTER SET utf8 NOT NULL,
`required` int(11) NOT NULL,
`match` varchar(255) CHARACTER SET utf8 NOT NULL,
`range` varchar(255) CHARACTER SET utf8 NOT NULL,
`error_message` varchar(255) CHARACTER SET utf8 NOT NULL,
`other_validator` text CHARACTER SET utf8 NOT NULL,
`widget` varchar(255) CHARACTER SET utf8 NOT NULL,
`widgetparams` text CHARACTER SET utf8 NOT NULL,
`position` int(11) NOT NULL,
`visible` int(11) NOT NULL,
`default` varchar(255) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_tbl_topic`
--

DROP TABLE IF EXISTS `public_tbl_topic`;
CREATE TABLE IF NOT EXISTS `public_tbl_topic` (
`id` int(11) NOT NULL,
`title` varchar(128) CHARACTER SET utf8 NOT NULL,
`content` longtext CHARACTER SET utf8 NOT NULL,
`status` int(11) NOT NULL,
`created` int(11) DEFAULT NULL,
`updated` int(11) DEFAULT NULL,
`userid` int(11) NOT NULL,
`category` int(11) NOT NULL,
`sticky` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_tbl_users`
--

DROP TABLE IF EXISTS `public_tbl_users`;
CREATE TABLE IF NOT EXISTS `public_tbl_users` (
`id` int(11) NOT NULL,
`username` varchar(20) CHARACTER SET utf8 NOT NULL,
`password` varchar(128) CHARACTER SET utf8 NOT NULL,
`email` varchar(128) CHARACTER SET utf8 NOT NULL,
`activkey` varchar(128) CHARACTER SET utf8 NOT NULL,
`create_at` char(19) COLLATE utf8_unicode_ci NOT NULL,
`lastvisit_at` char(19) COLLATE utf8_unicode_ci NOT NULL,
`superuser` int(11) NOT NULL,
`status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_temp`
--

DROP TABLE IF EXISTS `public_temp`;
CREATE TABLE IF NOT EXISTS `public_temp` (
`dat1` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`dat2` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`dat3` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`dat4` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`dat5` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_tempdetgui`
--

DROP TABLE IF EXISTS `public_tempdetgui`;
CREATE TABLE IF NOT EXISTS `public_tempdetgui` (
`n_hguia` bigint(20) DEFAULT NULL,
`c_itguia` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`n_cangui` double DEFAULT NULL,
`c_codgui` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`c_edgui` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`c_descri` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`m_obs` longtext CHARACTER SET utf8,
`c_um` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`c_codep` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`ndeenvio` bigint(20) DEFAULT NULL,
`l_libre` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`n_hconformidad` bigint(20) DEFAULT NULL,
`c_estado` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`n_libre` int(11) DEFAULT NULL,
`n_idconformidad` bigint(20) DEFAULT NULL,
`c_af` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`c_codactivo` varchar(13) CHARACTER SET utf8 DEFAULT NULL,
`c_img` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`c_codsap` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`docref` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`docrefext` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
`hidref` bigint(20) DEFAULT NULL,
`codocu` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`codlugar` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`iduser` int(11) NOT NULL,
`idtemp` bigint(20) NOT NULL,
`idstatus` int(11) NOT NULL,
`id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_tempdpeticion`
--

DROP TABLE IF EXISTS `public_tempdpeticion`;
CREATE TABLE IF NOT EXISTS `public_tempdpeticion` (
`id` bigint(20) NOT NULL,
`idusertemp` int(11) NOT NULL,
`hidpeticion` bigint(20) NOT NULL,
`um` char(3) CHARACTER SET utf8 NOT NULL,
`codart` varchar(10) CHARACTER SET utf8 NOT NULL,
`punit` double NOT NULL,
`cant` double NOT NULL,
`comentario` text CHARACTER SET utf8 NOT NULL,
`codestado` char(2) CHARACTER SET utf8 NOT NULL,
`codcen` varchar(4) CHARACTER SET utf8 NOT NULL,
`codal` varchar(3) CHARACTER SET utf8 NOT NULL,
`codocu` char(3) CHARACTER SET utf8 NOT NULL,
`usuario` varchar(23) CHARACTER SET utf8 NOT NULL,
`iduser` int(11) NOT NULL,
`disponibilidad` char(2) CHARACTER SET utf8 NOT NULL,
`idtemp` bigint(20) NOT NULL,
`item` char(3) COLLATE utf8_unicode_ci DEFAULT NULL,
`descripcion` varchar(40) CHARACTER SET utf8 NOT NULL,
`idstatus` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1126 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_tempito`
--

DROP TABLE IF EXISTS `public_tempito`;
CREATE TABLE IF NOT EXISTS `public_tempito` (
`cc` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`flag` varchar(1) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_tempo`
--

DROP TABLE IF EXISTS `public_tempo`;
CREATE TABLE IF NOT EXISTS `public_tempo` (
`dat1` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`dat2` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`dat3` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`dat5` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`dat4` longtext CHARACTER SET utf8,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_temporadas`
--

DROP TABLE IF EXISTS `public_temporadas`;
CREATE TABLE IF NOT EXISTS `public_temporadas` (
`id` int(11) NOT NULL,
`destemporada` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
`inicio` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`termino` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`cuota_anchoveta` int(11) DEFAULT NULL,
`cuota_jurel` int(11) DEFAULT NULL,
`cuota_global_anchoveta` int(11) DEFAULT NULL,
`zonalitoral` varchar(3) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_temporalids`
--

DROP TABLE IF EXISTS `public_temporalids`;
CREATE TABLE IF NOT EXISTS `public_temporalids` (
`id` bigint(20) DEFAULT NULL,
`usuario` longtext CHARACTER SET utf8,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_temppeticion`
--

DROP TABLE IF EXISTS `public_temppeticion`;
CREATE TABLE IF NOT EXISTS `public_temppeticion` (
`idusertemp` int(11) NOT NULL,
`codpro` varchar(6) CHARACTER SET utf8 NOT NULL,
`numero` varchar(12) CHARACTER SET utf8 NOT NULL,
`fecha` date NOT NULL,
`usuario` varchar(25) CHARACTER SET utf8 NOT NULL,
`fechacreac` datetime NOT NULL,
`comentario` text CHARACTER SET utf8 NOT NULL,
`textocorto` varchar(40) CHARACTER SET utf8 NOT NULL,
`idcontacto` int(11) NOT NULL,
`iduser` int(11) NOT NULL,
`codocu` char(3) CHARACTER SET utf8 NOT NULL,
`codestado` char(2) CHARACTER SET utf8 NOT NULL,
`correlativo` int(11) NOT NULL,
`prefijo` int(11) NOT NULL,
`codmon` char(3) CHARACTER SET utf8 NOT NULL,
`descuento` decimal(10,0) NOT NULL,
`id` bigint(20) NOT NULL,
`idtemp` bigint(20) NOT NULL,
`item` char(3) COLLATE utf8_unicode_ci DEFAULT NULL,
`grupocompras` char(3) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=150 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_temp_carteres`
--

DROP TABLE IF EXISTS `public_temp_carteres`;
CREATE TABLE IF NOT EXISTS `public_temp_carteres` (
`idcarter` int(11) NOT NULL,
`idequipo` int(11) DEFAULT NULL,
`capacidad` double DEFAULT NULL,
`tipoaceite` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`horascambio` int(11) DEFAULT NULL,
`tipocarter` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`haceite` int(11) DEFAULT NULL,
`hmuestra` int(11) DEFAULT NULL,
`nummuestras` int(11) DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_temp_carteres_control`
--

DROP TABLE IF EXISTS `public_temp_carteres_control`;
CREATE TABLE IF NOT EXISTS `public_temp_carteres_control` (
`idcontrol` bigint(20) NOT NULL,
`idcater` int(11) DEFAULT NULL,
`fechacontrol` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`horas` int(11) DEFAULT NULL,
`tipoevento` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`numdoc` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`observacion` longtext CHARACTER SET utf8,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_temp_guia`
--

DROP TABLE IF EXISTS `public_temp_guia`;
CREATE TABLE IF NOT EXISTS `public_temp_guia` (
`c_numgui` varchar(8) CHARACTER SET utf8 NOT NULL,
`c_coclig` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`d_fecgui` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`c_estgui` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`c_rsguia` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`c_codtra` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`c_trans` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`c_motivo` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`c_placa` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
`c_licon` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`d_fectra` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`c_desgui` longtext CHARACTER SET utf8,
`n_direc` int(11) DEFAULT NULL,
`c_texto` longtext CHARACTER SET utf8,
`c_dirsoc` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`c_serie` varchar(3) CHARACTER SET utf8 NOT NULL,
`n_direcformaldes` int(11) DEFAULT NULL,
`n_directran` int(11) DEFAULT NULL,
`c_creado` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`n_guia` bigint(20) DEFAULT NULL,
`c_estado` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`n_dirsoc` int(11) DEFAULT NULL,
`c_modificado` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`n_agencia` int(11) DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`m_nota_interna` longtext CHARACTER SET utf8,
`adicional` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_tenores`
--

DROP TABLE IF EXISTS `public_tenores`;
CREATE TABLE IF NOT EXISTS `public_tenores` (
`coddocu` varchar(3) CHARACTER SET utf8 NOT NULL,
`mensaje` longtext CHARACTER SET utf8,
`posicion` varchar(1) CHARACTER SET utf8 NOT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`activo` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`logo` text CHARACTER SET utf8,
`id` int(11) NOT NULL,
`sociedad` varchar(1) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_test`
--

DROP TABLE IF EXISTS `public_test`;
CREATE TABLE IF NOT EXISTS `public_test` (
`col` longtext CHARACTER SET utf8,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_thread`
--

DROP TABLE IF EXISTS `public_thread`;
CREATE TABLE IF NOT EXISTS `public_thread` (
`id` int(11) NOT NULL,
`forum_id` bigint(20) NOT NULL,
`subject` varchar(120) CHARACTER SET utf8 NOT NULL,
`is_sticky` int(11) NOT NULL,
`is_locked` int(11) NOT NULL,
`view_count` int(11) NOT NULL,
`created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_tipimputa`
--

DROP TABLE IF EXISTS `public_tipimputa`;
CREATE TABLE IF NOT EXISTS `public_tipimputa` (
`codimpu` varchar(1) CHARACTER SET utf8 NOT NULL,
`desimputa` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_tipoactivos`
--

DROP TABLE IF EXISTS `public_tipoactivos`;
CREATE TABLE IF NOT EXISTS `public_tipoactivos` (
`id` int(11) NOT NULL,
`letra` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`tipodeactivo` varchar(35) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_tipocambio`
--

DROP TABLE IF EXISTS `public_tipocambio`;
CREATE TABLE IF NOT EXISTS `public_tipocambio` (
`codmon1` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`codmon2` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`id` int(11) NOT NULL,
`denominador` int(11) DEFAULT NULL,
`numerador` int(11) DEFAULT NULL,
`ultima` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`creadopor` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`compra` double DEFAULT NULL,
`venta` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_tipocargos`
--

DROP TABLE IF EXISTS `public_tipocargos`;
CREATE TABLE IF NOT EXISTS `public_tipocargos` (
`codtipocargo` varchar(2) CHARACTER SET utf8 NOT NULL,
`destipocargo` varchar(30) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_tipofacturacion`
--

DROP TABLE IF EXISTS `public_tipofacturacion`;
CREATE TABLE IF NOT EXISTS `public_tipofacturacion` (
`codtipofac` varchar(2) CHARACTER SET utf8 NOT NULL,
`tipofacturacion` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_tipoformato`
--

DROP TABLE IF EXISTS `public_tipoformato`;
CREATE TABLE IF NOT EXISTS `public_tipoformato` (
`codigo` varchar(1) CHARACTER SET utf8 NOT NULL,
`descripciontipo` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`abrevia` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_tipomaquina`
--

DROP TABLE IF EXISTS `public_tipomaquina`;
CREATE TABLE IF NOT EXISTS `public_tipomaquina` (
`codtipo` varchar(2) CHARACTER SET utf8 NOT NULL,
`tipo` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_tipoobjeto`
--

DROP TABLE IF EXISTS `public_tipoobjeto`;
CREATE TABLE IF NOT EXISTS `public_tipoobjeto` (
`codigo` varchar(3) CHARACTER SET utf8 NOT NULL,
`descripcion` varchar(40) CHARACTER SET utf8 NOT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_tiposolicitudesactivos`
--

DROP TABLE IF EXISTS `public_tiposolicitudesactivos`;
CREATE TABLE IF NOT EXISTS `public_tiposolicitudesactivos` (
`codtipo` varchar(1) CHARACTER SET utf8 NOT NULL,
`destipo` varchar(40) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_tiposolpe`
--

DROP TABLE IF EXISTS `public_tiposolpe`;
CREATE TABLE IF NOT EXISTS `public_tiposolpe` (
`codsolpe` varchar(3) CHARACTER SET utf8 NOT NULL,
`destipo` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_tipospresupuestales`
--

DROP TABLE IF EXISTS `public_tipospresupuestales`;
CREATE TABLE IF NOT EXISTS `public_tipospresupuestales` (
`tipo` varchar(1) CHARACTER SET utf8 NOT NULL,
`nombretipo` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`esingresable` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_tipozarpe`
--

DROP TABLE IF EXISTS `public_tipozarpe`;
CREATE TABLE IF NOT EXISTS `public_tipozarpe` (
`codtipo` varchar(2) CHARACTER SET utf8 NOT NULL,
`motivozarpe` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`cuentahoras` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`cuentapetroleo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_tmpcoti`
--

DROP TABLE IF EXISTS `public_tmpcoti`;
CREATE TABLE IF NOT EXISTS `public_tmpcoti` (
`numcot` varchar(7) CHARACTER SET utf8 NOT NULL,
`codpro` varchar(6) CHARACTER SET utf8 NOT NULL,
`fecdoc` char(19) COLLATE utf8_unicode_ci NOT NULL,
`codcon` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`estado` varchar(5) CHARACTER SET utf8 NOT NULL,
`texto` varchar(40) CHARACTER SET utf8 NOT NULL,
`textolargo` longtext CHARACTER SET utf8,
`tipologia` varchar(1) CHARACTER SET utf8 NOT NULL,
`moneda` varchar(3) CHARACTER SET utf8 NOT NULL,
`orcli` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
`validez` varchar(3) CHARACTER SET utf8 NOT NULL,
`descuento` smallint(6) DEFAULT NULL,
`usuario` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`coddocu` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_tmpparametro`
--

DROP TABLE IF EXISTS `public_tmpparametro`;
CREATE TABLE IF NOT EXISTS `public_tmpparametro` (
`usuario` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
`parametro` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`valorparametro` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
`codpar` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_tmp_controlactivos`
--

DROP TABLE IF EXISTS `public_tmp_controlactivos`;
CREATE TABLE IF NOT EXISTS `public_tmp_controlactivos` (
`idactivo` bigint(20) DEFAULT NULL,
`tipo` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`guiaremision` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`numerofactura` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`fecha` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`idemplazamientoactual` bigint(20) DEFAULT NULL,
`idemplazamientoanterior` bigint(20) DEFAULT NULL,
`codobraencurso` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
`ccanterior` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`ccactual` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`comentario` longtext CHARACTER SET utf8,
`numformato` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`idformato` bigint(20) NOT NULL,
`codestado` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`almacen` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`valesalida` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`ocompra` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_tmp_detcontrolactivos`
--

DROP TABLE IF EXISTS `public_tmp_detcontrolactivos`;
CREATE TABLE IF NOT EXISTS `public_tmp_detcontrolactivos` (
`hidformato` bigint(20) DEFAULT NULL,
`iddetalle` bigint(20) NOT NULL,
`idactivo` bigint(20) DEFAULT NULL,
`idemplazamientoactual` bigint(20) DEFAULT NULL,
`idemplazamientoanterior` bigint(20) DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`adicional` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_toolbar_estados`
--

DROP TABLE IF EXISTS `public_toolbar_estados`;
CREATE TABLE IF NOT EXISTS `public_toolbar_estados` (
`tag` varchar(30) CHARACTER SET utf8 NOT NULL,
`E1` int(11) DEFAULT NULL,
`E2` int(11) DEFAULT NULL,
`E3` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_trabajadores`
--

DROP TABLE IF EXISTS `public_trabajadores`;
CREATE TABLE IF NOT EXISTS `public_trabajadores` (
`codigotra` varchar(4) CHARACTER SET utf8 NOT NULL,
`ap` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`am` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`nombres` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`dni` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
`codpuesto` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`cumple` date DEFAULT NULL,
`fecingreso` date DEFAULT NULL,
`domicilio` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
`tiposangre` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`telfijo` varchar(8) CHARACTER SET utf8 DEFAULT NULL,
`telmoviles` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`referencia` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`activo` char(1) COLLATE utf8_unicode_ci NOT NULL,
`iduser` int(11) DEFAULT NULL,
`prefijo` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
`correlativo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_trabajos`
--

DROP TABLE IF EXISTS `public_trabajos`;
CREATE TABLE IF NOT EXISTS `public_trabajos` (
`descor` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`deslarga` longtext CHARACTER SET utf8,
`responsable` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`id` bigint(20) NOT NULL,
`idcoti` bigint(20) DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_transacciones`
--

DROP TABLE IF EXISTS `public_transacciones`;
CREATE TABLE IF NOT EXISTS `public_transacciones` (
`codigo` varchar(5) CHARACTER SET utf8 NOT NULL,
`codtransa` varchar(10) CHARACTER SET utf8 NOT NULL,
`transaccion` varchar(45) CHARACTER SET utf8 NOT NULL,
`grupo` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`orden` smallint(6) DEFAULT NULL,
`activo` smallint(6) DEFAULT NULL,
`codmodulo` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_transacciongrupo`
--

DROP TABLE IF EXISTS `public_transacciongrupo`;
CREATE TABLE IF NOT EXISTS `public_transacciongrupo` (
`codgrupo` varchar(2) CHARACTER SET utf8 NOT NULL,
`codmodulo` varchar(2) CHARACTER SET utf8 NOT NULL,
`desgrupo` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_t_conectores_idiomas`
--

DROP TABLE IF EXISTS `public_t_conectores_idiomas`;
CREATE TABLE IF NOT EXISTS `public_t_conectores_idiomas` (
`cod_lang` varchar(2) CHARACTER SET utf8 NOT NULL,
`interseccion` varchar(20) CHARACTER SET utf8 NOT NULL,
`centenas` varchar(25) CHARACTER SET utf8 NOT NULL,
`millares` varchar(25) CHARACTER SET utf8 NOT NULL,
`millon` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`millones` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`valor_critico` int(11) DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_t_contac`
--

DROP TABLE IF EXISTS `public_t_contac`;
CREATE TABLE IF NOT EXISTS `public_t_contac` (
`c_hcod` varchar(6) CHARACTER SET utf8 NOT NULL,
`c_mail` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`c_nombre` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`c_cargo` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`c_tel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_t_cuentas`
--

DROP TABLE IF EXISTS `public_t_cuentas`;
CREATE TABLE IF NOT EXISTS `public_t_cuentas` (
`codcuenta` varchar(18) CHARACTER SET utf8 NOT NULL,
`descuenta` varchar(35) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_t_default`
--

DROP TABLE IF EXISTS `public_t_default`;
CREATE TABLE IF NOT EXISTS `public_t_default` (
`nombretabla` longtext CHARACTER SET utf8 NOT NULL,
`nombrecampo` longtext CHARACTER SET utf8 NOT NULL,
`aliascampo` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
`idd` longtext CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_t_default_roles`
--

DROP TABLE IF EXISTS `public_t_default_roles`;
CREATE TABLE IF NOT EXISTS `public_t_default_roles` (
`hidd` bigint(20) NOT NULL,
`idrol` longtext CHARACTER SET utf8 NOT NULL,
`valor` varchar(40) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_t_departamentos`
--

DROP TABLE IF EXISTS `public_t_departamentos`;
CREATE TABLE IF NOT EXISTS `public_t_departamentos` (
`coddepa` varchar(3) CHARACTER SET utf8 NOT NULL,
`codpostal` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`depa` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`comen` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_t_direcc`
--

DROP TABLE IF EXISTS `public_t_direcc`;
CREATE TABLE IF NOT EXISTS `public_t_direcc` (
`n_direc` int(11) DEFAULT NULL,
`c_hcod` varchar(6) CHARACTER SET utf8 NOT NULL,
`c_direc` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
`l_vale` bit(1) DEFAULT NULL,
`c_nomlug` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
`n_valor` int(11) DEFAULT NULL,
`c_distrito` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`c_prov` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`c_departam` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_t_letras`
--

DROP TABLE IF EXISTS `public_t_letras`;
CREATE TABLE IF NOT EXISTS `public_t_letras` (
`valor` int(11) NOT NULL,
`texto` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`lenguaje` varchar(2) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_t_maestro`
--

DROP TABLE IF EXISTS `public_t_maestro`;
CREATE TABLE IF NOT EXISTS `public_t_maestro` (
`codart` varchar(10) CHARACTER SET utf8 NOT NULL,
`descri` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`marca` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`numcar` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
`codsu` varchar(4) CHARACTER SET utf8 DEFAULT NULL,
`um` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`chapa` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_t_mascaras`
--

DROP TABLE IF EXISTS `public_t_mascaras`;
CREATE TABLE IF NOT EXISTS `public_t_mascaras` (
`codelelemto` varchar(3) CHARACTER SET utf8 NOT NULL,
`elemento` varchar(25) CHARACTER SET utf8 NOT NULL,
`mascara` varchar(50) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_t_mensajes`
--

DROP TABLE IF EXISTS `public_t_mensajes`;
CREATE TABLE IF NOT EXISTS `public_t_mensajes` (
`codmensaje` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
`idioma` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
`mensaje` longtext CHARACTER SET utf8,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_t_moneda`
--

DROP TABLE IF EXISTS `public_t_moneda`;
CREATE TABLE IF NOT EXISTS `public_t_moneda` (
`codmoneda` varchar(3) CHARACTER SET utf8 NOT NULL,
`simbolo` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
`desmon` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_t_servicios`
--

DROP TABLE IF EXISTS `public_t_servicios`;
CREATE TABLE IF NOT EXISTS `public_t_servicios` (
`codservicio` varchar(6) CHARACTER SET utf8 NOT NULL,
`servicio` varchar(35) CHARACTER SET utf8 NOT NULL,
`cuenta` varchar(18) CHARACTER SET utf8 NOT NULL,
`tipo` varchar(1) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_t_sistemas`
--

DROP TABLE IF EXISTS `public_t_sistemas`;
CREATE TABLE IF NOT EXISTS `public_t_sistemas` (
`codsistema` varchar(2) CHARACTER SET utf8 NOT NULL,
`descripcion` varchar(50) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_t_ubicaciones`
--

DROP TABLE IF EXISTS `public_t_ubicaciones`;
CREATE TABLE IF NOT EXISTS `public_t_ubicaciones` (
`codcen` varchar(4) CHARACTER SET utf8 NOT NULL,
`codubi` varchar(62) CHARACTER SET utf8 NOT NULL,
`nomubi` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`ceco` varchar(20) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_t_um`
--

DROP TABLE IF EXISTS `public_t_um`;
CREATE TABLE IF NOT EXISTS `public_t_um` (
`desum` varchar(6) CHARACTER SET utf8 NOT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`descri` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`l_condicion` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`l_kit` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`um_despacho` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
`c_maxima` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_ubigeos`
--

DROP TABLE IF EXISTS `public_ubigeos`;
CREATE TABLE IF NOT EXISTS `public_ubigeos` (
`coddpto` varchar(2) CHARACTER SET utf8 NOT NULL,
`codprov` varchar(2) CHARACTER SET utf8 NOT NULL,
`coddist` varchar(2) CHARACTER SET utf8 NOT NULL,
`nombre` varchar(30) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_ubl`
--

DROP TABLE IF EXISTS `public_ubl`;
CREATE TABLE IF NOT EXISTS `public_ubl` (
`id` int(11) NOT NULL,
`codocu` char(3) CHARACTER SET utf8 NOT NULL,
`nombrecampo` varchar(50) CHARACTER SET utf8 NOT NULL,
`ubltag` varchar(300) CHARACTER SET utf8 NOT NULL COMMENT 'tqirqa ubl, pra hacer los taqgs XML',
`xmltag` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_ums`
--

DROP TABLE IF EXISTS `public_ums`;
CREATE TABLE IF NOT EXISTS `public_ums` (
`um` varchar(3) CHARACTER SET utf8 NOT NULL,
`desum` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_usuarios`
--

DROP TABLE IF EXISTS `public_usuarios`;
CREATE TABLE IF NOT EXISTS `public_usuarios` (
`usuario` longtext CHARACTER SET utf8 NOT NULL,
`ap` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`am` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`nombres` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
`clave` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
`correo` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
`rol` longtext CHARACTER SET utf8,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`centrodefault` varchar(4) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_usuarioscentro`
--

DROP TABLE IF EXISTS `public_usuarioscentro`;
CREATE TABLE IF NOT EXISTS `public_usuarioscentro` (
`usuario` longtext CHARACTER SET utf8 NOT NULL,
`centro` varchar(4) CHARACTER SET utf8 NOT NULL,
`vale` int(11) DEFAULT NULL,
`id` int(11) NOT NULL,
`idus` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_usuariosfavoritos`
--

DROP TABLE IF EXISTS `public_usuariosfavoritos`;
CREATE TABLE IF NOT EXISTS `public_usuariosfavoritos` (
`id` int(11) NOT NULL,
`hiduser` bigint(20) DEFAULT NULL,
`url` text CHARACTER SET utf8,
`fecharegistro` char(19) COLLATE utf8_unicode_ci DEFAULT NULL,
`valido` varchar(1) CHARACTER SET utf8 DEFAULT NULL,
`chapa` varchar(40) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_vcodestado`
--

DROP TABLE IF EXISTS `public_vcodestado`;
CREATE TABLE IF NOT EXISTS `public_vcodestado` (
`codestado` varchar(2) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_vistas`
--

DROP TABLE IF EXISTS `public_vistas`;
CREATE TABLE IF NOT EXISTS `public_vistas` (
`idvista` bigint(20) NOT NULL,
`nombrevista` longtext CHARACTER SET utf8 NOT NULL,
`creadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`creadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`modificadopor` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
`modificadoel` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
`coddocu` varchar(3) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `public_vistas_campos`
--

DROP TABLE IF EXISTS `public_vistas_campos`;
CREATE TABLE IF NOT EXISTS `public_vistas_campos` (
`idcampo` bigint(20) NOT NULL,
`nombrecampo` longtext CHARACTER SET utf8 NOT NULL,
`alias` varchar(35) CHARACTER SET utf8 NOT NULL,
`hidvista` bigint(20) NOT NULL,
`descripcion` longtext CHARACTER SET utf8,
`tipodedato` varchar(1) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vw_activosolo`
--

DROP TABLE IF EXISTS `vw_activosolo`;
CREATE TABLE IF NOT EXISTS `vw_activosolo` (
`idactivo` bigint(20) DEFAULT NULL,
`nomep` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
`codsistema` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
`codsistemapadre` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
`general` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
`idempla` bigint(20) DEFAULT NULL,
`codep` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
`codigoaf` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
`descripcionaf` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
`serie` varchar(18) COLLATE utf8_unicode_ci DEFAULT NULL,
`arreglo` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
`codigo` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
`texto` longtext COLLATE utf8_unicode_ci,
`foto` longblob,
`barra` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
`tipomaquina` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
`dimensiones` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
`codestado` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
`marca` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
`modelo` varchar(22) COLLATE utf8_unicode_ci DEFAULT NULL,
`capacidad` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
`observaciones` longtext COLLATE utf8_unicode_ci,
`tipo` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
`nomestado` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
`dede` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vw_alconversiones`
--

DROP TABLE IF EXISTS `vw_alconversiones`;
CREATE TABLE IF NOT EXISTS `vw_alconversiones` (
`id` int(11) DEFAULT NULL,
`um1` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
`um2` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
`numerador` double DEFAULT NULL,
`denominador` double DEFAULT NULL,
`codart` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
`desum1` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
`descripcion` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
`desum2` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_alinventario`
--
DROP VIEW IF EXISTS `vw_alinventario`;
CREATE TABLE IF NOT EXISTS `vw_alinventario` (
`codalm` varchar(3)
,`creadopor` longtext
,`creadoel` longtext
,`modificadopor` longtext
,`modificadoel` longtext
,`fechainicio` char(19)
,`fechafin` char(19)
,`periodocontable` varchar(4)
,`codresponsable` varchar(4)
,`codart` varchar(10)
,`codcen` varchar(4)
,`um` varchar(3)
,`cantlibre` double
,`canttran` double
,`cantres` double
,`ubicacion` varchar(10)
,`lote` varchar(10)
,`siid` bigint(20)
,`ssiduser` varchar(30)
,`id` bigint(20)
,`punit` double
,`codmon` varchar(3)
,`descripcion` varchar(60)
,`codtipo` varchar(2)
,`desum` varchar(20)
,`ptlibre` double(20,3)
,`pttran` double(20,3)
,`ptres` double(20,3)
,`pttotal` double(20,3)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Vw_alinventario_resumen`
--

DROP TABLE IF EXISTS `Vw_alinventario_resumen`;
CREATE TABLE IF NOT EXISTS `Vw_alinventario_resumen` (
`stocklibre` double(20,3) DEFAULT NULL,
`stocktran` double(20,3) DEFAULT NULL,
`stockres` double(20,3) DEFAULT NULL,
`stocktotal` double(20,3) DEFAULT NULL,
`codalm` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
`codcen` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
`codtipo` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_alreservas`
--
DROP VIEW IF EXISTS `vw_alreservas`;
CREATE TABLE IF NOT EXISTS `vw_alreservas` (
`codart` varchar(10)
,`txtmaterial` varchar(40)
,`id` bigint(20)
,`cant` double
,`numreserva` int(11)
,`atendido` char(19)
,`usuario` varchar(25)
,`fechares` char(19)
,`estadoreserva` varchar(2)
,`codocu` varchar(3)
,`desum` varchar(20)
,`estado` varchar(25)
,`desdocu` varchar(45)
,`numero` varchar(10)
,`item` char(3)
,`um` char(3)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_atencionessolpe`
--
DROP VIEW IF EXISTS `vw_atencionessolpe`;
CREATE TABLE IF NOT EXISTS `vw_atencionessolpe` (
`item` char(3)
,`iddesolpe` bigint(20)
,`cantdesolpe` float
,`numvale` char(12)
,`desumsolpe` varchar(20)
,`idsolpe` bigint(20)
,`umsolpe` char(3)
,`cantreserva` double
,`codocu` varchar(3)
,`numreserva` int(11)
,`estadoreserva` varchar(2)
,`id` bigint(20)
,`cant` double
,`hidreserva` bigint(20)
,`hidkardex` bigint(20)
,`estadoatencion` char(2)
,`codmov` varchar(2)
,`um` varchar(3)
,`numkardex` varchar(14)
,`usuario` varchar(25)
,`codart` varchar(10)
,`preciounit` double
,`fecha` char(19)
,`monto` double
,`ceco` varchar(12)
,`txtmaterial` varchar(40)
,`desumkardex` varchar(20)
,`movimiento` varchar(35)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_contactos`
--
DROP VIEW IF EXISTS `vw_contactos`;
CREATE TABLE IF NOT EXISTS `vw_contactos` (
`id` int(11)
,`c_nombre` varchar(30)
,`correlativo` varchar(5)
,`c_hcod` varchar(6)
,`despro` varchar(100)
,`c_cargo` varchar(30)
,`c_mail` varchar(30)
,`c_tel` varchar(30)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_docu_ingresados`
--
DROP VIEW IF EXISTS `vw_docu_ingresados`;
CREATE TABLE IF NOT EXISTS `vw_docu_ingresados` (
`id` int(11)
,`codprov` varchar(6)
,`fecha` char(19)
,`fechain` char(19)
,`correlativo` varchar(8)
,`tipodoc` varchar(3)
,`moneda` varchar(1)
,`descorta` varchar(25)
,`codepv` varchar(3)
,`monto` double
,`codgrupo` varchar(3)
,`codresponsable` varchar(4)
,`creadopor` varchar(23)
,`creadoel` varchar(15)
,`texv` longtext
,`docref` varchar(14)
,`codteniente` varchar(4)
,`codlocal` varchar(4)
,`numero` varchar(20)
,`despro` varchar(100)
,`rucpro` varchar(11)
,`desdocu` varchar(45)
,`nomep` varchar(25)
,`responsable` varchar(92)
,`apoderado` varchar(92)
,`nomcen` varchar(35)
,`estado` varchar(25)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_inventario`
--
DROP VIEW IF EXISTS `vw_inventario`;
CREATE TABLE IF NOT EXISTS `vw_inventario` (
`codestado` varchar(2)
,`rocoto` varchar(1)
,`iddocu` bigint(20)
,`coddocu` varchar(3)
,`posicion` varchar(6)
,`codlugar` varchar(6)
,`codep` varchar(3)
,`idinventario` bigint(20)
,`codigo` varchar(6)
,`c_estado` varchar(1)
,`modificadopor` varchar(25)
,`modificadoel` varchar(20)
,`codigosap` varchar(6)
,`codigoaf` varchar(14)
,`descripcion` varchar(40)
,`marca` varchar(15)
,`modelo` varchar(25)
,`comentario` longtext
,`fecha` char(19)
,`serie` varchar(20)
,`clasefoto` varchar(30)
,`codigopadre` varchar(5)
,`adicional` varchar(15)
,`numerodocumento` varchar(20)
,`codeporiginal` varchar(3)
,`codepanterior` varchar(3)
,`baja` varchar(1)
,`tipo` varchar(1)
,`desdocu` varchar(45)
,`nomep` varchar(25)
,`nombreepanterior` varchar(25)
,`nombreeporiginal` varchar(25)
,`deslugar` varchar(50)
,`nomcen` varchar(35)
,`despro` varchar(100)
,`area` varchar(25)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_kardex`
--
DROP VIEW IF EXISTS `vw_kardex`;
CREATE TABLE IF NOT EXISTS `vw_kardex` (
`numvale` char(12)
,`codart` varchar(10)
,`codmov` varchar(2)
,`valido` varchar(1)
,`destino` varchar(20)
,`checki` varchar(1)
,`cant` double
,`idref` bigint(20)
,`alemi` varchar(3)
,`aldes` varchar(3)
,`fecha` char(19)
,`coddoc` varchar(3)
,`numdoc` varchar(15)
,`usuario` varchar(25)
,`creadopor` varchar(25)
,`creadoel` varchar(20)
,`modificadopor` varchar(25)
,`modificadoel` varchar(20)
,`um` varchar(3)
,`comentario` varchar(20)
,`codocuref` varchar(3)
,`numdocref` varchar(15)
,`codcentro` varchar(4)
,`id` bigint(20)
,`codestado` varchar(2)
,`prefijo` varchar(2)
,`fechadoc` char(19)
,`correlativo` varchar(12)
,`numkardex` varchar(14)
,`solicitante` varchar(18)
,`hidvale` bigint(20)
,`descripcion` varchar(60)
,`desdocu` varchar(45)
,`movimiento` varchar(35)
,`desum` varchar(20)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_lugares`
--
DROP VIEW IF EXISTS `vw_lugares`;
CREATE TABLE IF NOT EXISTS `vw_lugares` (
`despro` varchar(100)
,`codlugar` varchar(6)
,`deslugar` varchar(50)
,`provincia` varchar(30)
,`claselugar` varchar(3)
,`codpro` varchar(6)
,`n_direc` int(11)
,`c_direc` varchar(100)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_observaciones`
--
DROP VIEW IF EXISTS `vw_observaciones`;
CREATE TABLE IF NOT EXISTS `vw_observaciones` (
`idinventario` bigint(20)
,`hidinventario` bigint(20)
,`fecha` char(19)
,`descri` varchar(30)
,`mobs` longtext
,`usuario` varchar(40)
,`id` int(11)
,`codestado` varchar(2)
,`estado` varchar(25)
,`codigoaf` varchar(14)
,`codigosap` varchar(6)
,`codlugar` varchar(6)
,`descripcion` varchar(40)
,`marca` varchar(15)
,`modelo` varchar(25)
,`serie` varchar(20)
,`codcentro` varchar(4)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_ocompra`
--
DROP VIEW IF EXISTS `vw_ocompra`;
CREATE TABLE IF NOT EXISTS `vw_ocompra` (
`numcot` varchar(8)
,`codpro` varchar(6)
,`fecdoc` char(19)
,`codcon` varchar(5)
,`codestado` varchar(2)
,`texto` varchar(40)
,`textolargo` longtext
,`tipologia` varchar(1)
,`moneda` varchar(3)
,`orcli` varchar(12)
,`desum` varchar(20)
,`descuento` smallint(6)
,`usuario` varchar(35)
,`coddocu` varchar(3)
,`creado` varchar(20)
,`modificado` varchar(20)
,`creadopor` varchar(25)
,`creadoel` varchar(20)
,`modificadopor` varchar(25)
,`modificadoel` varchar(20)
,`codtipofac` varchar(2)
,`codsociedad` varchar(1)
,`codgrupoventas` varchar(3)
,`codtipocotizacion` varchar(1)
,`validez` int(11)
,`codcentro` varchar(4)
,`nigv` double
,`codobjeto` varchar(3)
,`fechapresentacion` char(19)
,`fechanominal` char(19)
,`idguia` int(11)
,`id` bigint(20)
,`codentro` varchar(4)
,`codigoalma` varchar(3)
,`codart` varchar(8)
,`disp` varchar(2)
,`cant` double
,`punit` double
,`item` varchar(3)
,`descri` varchar(40)
,`stock` double
,`detalle` longtext
,`tipoitem` varchar(1)
,`estadodetalle` varchar(2)
,`um` varchar(3)
,`hidguia` bigint(20)
,`codservicio` varchar(6)
,`tipoimputacion` varchar(1)
,`subto` double
,`desmon` varchar(10)
,`tipofacturacion` varchar(35)
,`estado` varchar(25)
,`rucsoc` varchar(11)
,`dsocio` varchar(40)
,`c_nombre` varchar(30)
,`simbolo` varchar(3)
,`c_cargo` varchar(30)
,`despro` varchar(100)
,`rucpro` varchar(11)
,`emailpro` varchar(60)
,`desdocu` varchar(45)
,`textocabeza` longtext
,`textopie` longtext
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_ocosubtotal`
--
DROP VIEW IF EXISTS `vw_ocosubtotal`;
CREATE TABLE IF NOT EXISTS `vw_ocosubtotal` (
`idguia` int(11)
,`hidguia` bigint(20)
,`nigv` double
,`descuento` smallint(6)
,`simbolo` varchar(3)
,`subtotal` double(19,2)
,`destotal` double(19,2)
,`subtotaldes` double(19,2)
,`impuesto` double(19,2)
,`total` double(19,2)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_opcionesdocumentos`
--
DROP VIEW IF EXISTS `vw_opcionesdocumentos`;
CREATE TABLE IF NOT EXISTS `vw_opcionesdocumentos` (
`desdocu` varchar(45)
,`idopdoc` bigint(20)
,`campo` varchar(30)
,`nombrecampo` varchar(30)
,`tipodato` varchar(1)
,`longitud` int(11)
,`id` int(11)
,`idusuario` bigint(20)
,`username` varchar(64)
,`coddocu` varchar(3)
,`valor` varchar(40)
,`seleccionable` longtext
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_solpe`
--
DROP VIEW IF EXISTS `vw_solpe`;
CREATE TABLE IF NOT EXISTS `vw_solpe` (
`identidad` bigint(20)
,`numero` varchar(10)
,`posicion` int(11)
,`tipimputacion` char(1)
,`centro` varchar(4)
,`codal` varchar(3)
,`codart` varchar(10)
,`txtmaterial` varchar(40)
,`grupocompras` char(3)
,`usuario` varchar(35)
,`modificado` varchar(25)
,`textodetalle` text
,`fechacrea` datetime
,`fechaent` date
,`fechalib` datetime
,`estadolib` char(1)
,`imputacion` varchar(12)
,`solicitanet` varchar(25)
,`hidsolpe` bigint(20)
,`creado` datetime
,`creadopor` varchar(25)
,`creadoel` varchar(25)
,`escompra` varchar(1)
,`modificadopor` varchar(25)
,`modificadoel` varchar(25)
,`id` bigint(20)
,`desum` varchar(20)
,`codocu` char(3)
,`um` char(3)
,`tipsolpe` char(1)
,`est` char(2)
,`cant` float
,`item` char(3)
,`numsolpe` varchar(10)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_solpeatencion`
--
DROP VIEW IF EXISTS `vw_solpeatencion`;
CREATE TABLE IF NOT EXISTS `vw_solpeatencion` (
`numero` varchar(10)
,`centro` varchar(4)
,`codal` varchar(3)
,`usuario` varchar(35)
,`fechacrea` datetime
,`fechaent` date
,`imputacion` varchar(12)
,`hidsolpe` bigint(20)
,`codocu` char(3)
,`id` bigint(20)
,`item` char(3)
,`cant` float
,`txtmaterial` varchar(40)
,`codart` varchar(10)
,`desum` varchar(20)
,`cantlibre` double
,`umbase` varchar(20)
,`canttran` double
,`cantres` double
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_solpereservas`
--
DROP VIEW IF EXISTS `vw_solpereservas`;
CREATE TABLE IF NOT EXISTS `vw_solpereservas` (
`desum` varchar(20)
,`identidad` bigint(20)
,`numero` varchar(10)
,`posicion` int(11)
,`escompra` varchar(1)
,`tipimputacion` char(1)
,`centro` varchar(4)
,`codal` varchar(3)
,`codart` varchar(10)
,`txtmaterial` varchar(40)
,`grupocompras` char(3)
,`usuariodesolpe` varchar(35)
,`modificado` varchar(25)
,`textodetalle` text
,`fechacrea` datetime
,`fechaent` date
,`fechalib` datetime
,`estadolib` char(1)
,`imputacion` varchar(12)
,`solicitanet` varchar(25)
,`hidsolpe` bigint(20)
,`creado` datetime
,`creadopor` varchar(25)
,`creadoel` varchar(25)
,`modificadopor` varchar(25)
,`modificadoel` varchar(25)
,`iddesolpe` bigint(20)
,`codocusolpe` char(3)
,`um` char(3)
,`tipsolpe` char(1)
,`est` char(2)
,`cantdesolpe` float
,`item` char(3)
,`numsolpe` varchar(10)
,`id` bigint(20)
,`hidesolpe` bigint(20)
,`estadoreserva` varchar(2)
,`fechares` char(19)
,`usuario` varchar(25)
,`cant` double
,`codocu` varchar(3)
,`numreserva` int(11)
,`flag` varchar(1)
,`rex` varchar(100)
,`atendido` char(19)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_trabajadores`
--
DROP VIEW IF EXISTS `vw_trabajadores`;
CREATE TABLE IF NOT EXISTS `vw_trabajadores` (
`codigotra` varchar(4)
,`nombrecompleto` varchar(92)
,`codpuesto` varchar(3)
,`ap` varchar(30)
,`am` varchar(35)
,`nombres` varchar(25)
,`dni` varchar(12)
,`oficio` varchar(45)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_alinventario`
--
DROP TABLE IF EXISTS `vw_alinventario`;

CREATE ALGORITHM=UNDEFINED DEFINER=`neologys`@`190.117.170.37` SQL SECURITY DEFINER VIEW `vw_alinventario` AS select `t`.`codalm` AS `codalm`,`t`.`creadopor` AS `creadopor`,`t`.`creadoel` AS `creadoel`,`t`.`modificadopor` AS `modificadopor`,`t`.`modificadoel` AS `modificadoel`,`t`.`fechainicio` AS `fechainicio`,`t`.`fechafin` AS `fechafin`,`t`.`periodocontable` AS `periodocontable`,`t`.`codresponsable` AS `codresponsable`,`t`.`codart` AS `codart`,`t`.`codcen` AS `codcen`,`c`.`um` AS `um`,`t`.`cantlibre` AS `cantlibre`,`t`.`canttran` AS `canttran`,`t`.`cantres` AS `cantres`,`t`.`ubicacion` AS `ubicacion`,`t`.`lote` AS `lote`,`t`.`siid` AS `siid`,`t`.`ssiduser` AS `ssiduser`,`t`.`id` AS `id`,`t`.`punit` AS `punit`,`t`.`codmon` AS `codmon`,`a`.`descripcion` AS `descripcion`,`a`.`codtipo` AS `codtipo`,`c`.`desum` AS `desum`,round((`t`.`punit` * `t`.`cantlibre`),3) AS `ptlibre`,round((`t`.`punit` * `t`.`canttran`),3) AS `pttran`,round((`t`.`punit` * `t`.`cantres`),3) AS `ptres`,round((((`t`.`punit` * `t`.`cantlibre`) + (`t`.`punit` * `t`.`canttran`)) + (`t`.`punit` * `t`.`cantres`)),3) AS `pttotal` from ((`public_alinventario` `t` join `public_maestrocomponentes` `a`) join `public_ums` `c`) where ((`t`.`codart` = `a`.`codigo`) and (`a`.`um` = `c`.`um`));

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_alreservas`
--
DROP TABLE IF EXISTS `vw_alreservas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`neologys`@`localhost` SQL SECURITY DEFINER VIEW `vw_alreservas` AS select `a`.`codart` AS `codart`,`a`.`txtmaterial` AS `txtmaterial`,`c`.`id` AS `id`,`c`.`cant` AS `cant`,`c`.`numreserva` AS `numreserva`,`c`.`atendido` AS `atendido`,`c`.`usuario` AS `usuario`,`c`.`fechares` AS `fechares`,`c`.`estadoreserva` AS `estadoreserva`,`c`.`codocu` AS `codocu`,`d`.`desum` AS `desum`,`e`.`estado` AS `estado`,`f`.`desdocu` AS `desdocu`,`g`.`numero` AS `numero`,`a`.`item` AS `item`,`a`.`um` AS `um` from (((((`public_desolpe1` `a` join `public_alreserva` `c`) join `public_ums` `d`) join `public_estado` `e`) join `public_documentos` `f`) join `public_solpe` `g`) where ((`a`.`hidsolpe` = `g`.`id`) and (`a`.`id` = `c`.`hidesolpe`) and (`c`.`codocu` = `e`.`codocu`) and (`c`.`estadoreserva` = `e`.`codestado`) and (`c`.`codocu` = `f`.`coddocu`) and (`a`.`um` = `d`.`um`));

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_atencionessolpe`
--
DROP TABLE IF EXISTS `vw_atencionessolpe`;

CREATE ALGORITHM=UNDEFINED DEFINER=`neologys`@`localhost` SQL SECURITY DEFINER VIEW `vw_atencionessolpe` AS select `d`.`item` AS `item`,`d`.`id` AS `iddesolpe`,`d`.`cant` AS `cantdesolpe`,`h`.`numvale` AS `numvale`,`k`.`desum` AS `desumsolpe`,`d`.`hidsolpe` AS `idsolpe`,`d`.`um` AS `umsolpe`,`u`.`cant` AS `cantreserva`,`u`.`codocu` AS `codocu`,`u`.`numreserva` AS `numreserva`,`u`.`estadoreserva` AS `estadoreserva`,`t`.`id` AS `id`,`t`.`cant` AS `cant`,`t`.`hidreserva` AS `hidreserva`,`t`.`hidkardex` AS `hidkardex`,`t`.`estadoatencion` AS `estadoatencion`,`s`.`codmov` AS `codmov`,`s`.`um` AS `um`,`s`.`numkardex` AS `numkardex`,`s`.`usuario` AS `usuario`,`s`.`codart` AS `codart`,`s`.`preciounit` AS `preciounit`,`s`.`fecha` AS `fecha`,`g`.`monto` AS `monto`,`g`.`ceco` AS `ceco`,`d`.`txtmaterial` AS `txtmaterial`,`j`.`desum` AS `desumkardex`,`f`.`movimiento` AS `movimiento` from ((((((((`public_atencionreserva` `t` join `public_alkardex` `s`) join `public_alreserva` `u`) join `public_ccgastos` `g`) join `public_desolpe1` `d`) join `public_ums` `j`) join `public_ums` `k`) join `public_almacenmovimientos` `f`) join `public_almacendocs` `h`) where ((`t`.`hidkardex` = `s`.`id`) and (`u`.`id` = `t`.`hidreserva`) and (`s`.`id` = `g`.`idref`) and (`d`.`id` = `u`.`hidesolpe`) and (`s`.`um` = `j`.`um`) and (`f`.`codmov` = `s`.`codmov`) and (`k`.`um` = `d`.`um`) and (`s`.`hidvale` = `h`.`id`));

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_contactos`
--
DROP TABLE IF EXISTS `vw_contactos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`neologys`@`localhost` SQL SECURITY DEFINER VIEW `vw_contactos` AS select `b`.`id` AS `id`,`b`.`c_nombre` AS `c_nombre`,`b`.`correlativo` AS `correlativo`,`b`.`c_hcod` AS `c_hcod`,`a`.`despro` AS `despro`,`b`.`c_cargo` AS `c_cargo`,`b`.`c_mail` AS `c_mail`,`b`.`c_tel` AS `c_tel` from (`public_contactos` `b` join `public_clipro` `a`) where (`a`.`codpro` = `b`.`c_hcod`);

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_docu_ingresados`
--
DROP TABLE IF EXISTS `vw_docu_ingresados`;

CREATE ALGORITHM=UNDEFINED DEFINER=`neologys`@`localhost` SQL SECURITY DEFINER VIEW `vw_docu_ingresados` AS select `a`.`id` AS `id`,`a`.`codprov` AS `codprov`,`a`.`fecha` AS `fecha`,`a`.`fechain` AS `fechain`,`a`.`correlativo` AS `correlativo`,`a`.`tipodoc` AS `tipodoc`,`a`.`moneda` AS `moneda`,`a`.`descorta` AS `descorta`,`a`.`codepv` AS `codepv`,`a`.`monto` AS `monto`,`a`.`codgrupo` AS `codgrupo`,`a`.`codresponsable` AS `codresponsable`,`a`.`creadopor` AS `creadopor`,`a`.`creadoel` AS `creadoel`,`a`.`texv` AS `texv`,`a`.`docref` AS `docref`,`a`.`codteniente` AS `codteniente`,`a`.`codlocal` AS `codlocal`,`a`.`numero` AS `numero`,`b`.`despro` AS `despro`,`b`.`rucpro` AS `rucpro`,`c`.`desdocu` AS `desdocu`,`d`.`nomep` AS `nomep`,`e`.`nombrecompleto` AS `responsable`,`f`.`nombrecompleto` AS `apoderado`,`g`.`nomcen` AS `nomcen`,`h`.`estado` AS `estado` from (((((((`public_docu_ingresados` `a` join `public_clipro` `b` on((`a`.`codprov` = `b`.`codpro`))) join `public_estado` `h` on(((`a`.`cod_estado` = `h`.`codestado`) and (`h`.`codocu` = '040')))) join `public_documentos` `c` on((`a`.`tipodoc` = `c`.`coddocu`))) join `public_embarcaciones` `d` on((`a`.`codepv` = `d`.`codep`))) join `vw_trabajadores` `e` on((`a`.`codresponsable` = `e`.`codigotra`))) left join `vw_trabajadores` `f` on((`a`.`codteniente` = `f`.`codigotra`))) join `public_centros` `g` on((`a`.`codlocal` = `g`.`codcen`)));

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_inventario`
--
DROP TABLE IF EXISTS `vw_inventario`;

CREATE ALGORITHM=UNDEFINED DEFINER=`neologys`@`localhost` SQL SECURITY DEFINER VIEW `vw_inventario` AS select `inventario`.`codestado` AS `codestado`,`inventario`.`rocoto` AS `rocoto`,`inventario`.`iddocu` AS `iddocu`,`inventario`.`coddocu` AS `coddocu`,`inventario`.`posicion` AS `posicion`,`inventario`.`codlugar` AS `codlugar`,`inventario`.`codep` AS `codep`,`inventario`.`idinventario` AS `idinventario`,`inventario`.`codigo` AS `codigo`,`inventario`.`c_estado` AS `c_estado`,`inventario`.`modificadopor` AS `modificadopor`,`inventario`.`modificadoel` AS `modificadoel`,`inventario`.`codigosap` AS `codigosap`,`inventario`.`codigoaf` AS `codigoaf`,`inventario`.`descripcion` AS `descripcion`,`inventario`.`marca` AS `marca`,`inventario`.`modelo` AS `modelo`,`inventario`.`comentario` AS `comentario`,`inventario`.`fecha` AS `fecha`,`inventario`.`serie` AS `serie`,`inventario`.`clasefoto` AS `clasefoto`,`inventario`.`codigopadre` AS `codigopadre`,`inventario`.`adicional` AS `adicional`,`inventario`.`numerodocumento` AS `numerodocumento`,`inventario`.`codeporiginal` AS `codeporiginal`,`inventario`.`codepanterior` AS `codepanterior`,`inventario`.`baja` AS `baja`,`inventario`.`tipo` AS `tipo`,`documentos`.`desdocu` AS `desdocu`,`embarcaciones`.`nomep` AS `nomep`,`epanterior`.`nomep` AS `nombreepanterior`,`eporiginal`.`nomep` AS `nombreeporiginal`,`lugares`.`deslugar` AS `deslugar`,`centros`.`nomcen` AS `nomcen`,`clipro`.`despro` AS `despro`,`areas`.`area` AS `area` from ((((((((`public_inventario` `inventario` join `public_documentos` `documentos`) join `public_embarcaciones` `embarcaciones`) join `public_embarcaciones` `epanterior`) join `public_embarcaciones` `eporiginal`) join `public_lugares` `lugares`) join `public_centros` `centros`) join `public_clipro` `clipro`) join `public_areas` `areas`) where ((`inventario`.`coddocu` = `documentos`.`coddocu`) and (`inventario`.`codep` = `embarcaciones`.`codep`) and (`inventario`.`codeporiginal` = `eporiginal`.`codep`) and (`inventario`.`codepanterior` = `epanterior`.`codep`) and (`inventario`.`codlugar` = `lugares`.`codlugar`) and (`inventario`.`codcentro` = `centros`.`codcen`) and (`lugares`.`codpro` = `clipro`.`codpro`) and (`inventario`.`codarea` = `areas`.`codarea`));

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_kardex`
--
DROP TABLE IF EXISTS `vw_kardex`;

CREATE ALGORITHM=UNDEFINED DEFINER=`neologys`@`localhost` SQL SECURITY DEFINER VIEW `vw_kardex` AS select `s`.`numvale` AS `numvale`,`t`.`codart` AS `codart`,`t`.`codmov` AS `codmov`,`t`.`valido` AS `valido`,`t`.`destino` AS `destino`,`t`.`checki` AS `checki`,`t`.`cant` AS `cant`,`t`.`idref` AS `idref`,`t`.`alemi` AS `alemi`,`t`.`aldes` AS `aldes`,`t`.`fecha` AS `fecha`,`t`.`coddoc` AS `coddoc`,`t`.`numdoc` AS `numdoc`,`t`.`usuario` AS `usuario`,`t`.`creadopor` AS `creadopor`,`t`.`creadoel` AS `creadoel`,`t`.`modificadopor` AS `modificadopor`,`t`.`modificadoel` AS `modificadoel`,`t`.`um` AS `um`,`t`.`comentario` AS `comentario`,`t`.`codocuref` AS `codocuref`,`t`.`numdocref` AS `numdocref`,`t`.`codcentro` AS `codcentro`,`t`.`id` AS `id`,`t`.`codestado` AS `codestado`,`t`.`prefijo` AS `prefijo`,`t`.`fechadoc` AS `fechadoc`,`t`.`correlativo` AS `correlativo`,`t`.`numkardex` AS `numkardex`,`t`.`solicitante` AS `solicitante`,`t`.`hidvale` AS `hidvale`,`a`.`descripcion` AS `descripcion`,`b`.`desdocu` AS `desdocu`,`c`.`movimiento` AS `movimiento`,`x`.`desum` AS `desum` from (((((`public_alkardex` `t` join `public_maestrocomponentes` `a`) join `public_documentos` `b`) join `public_almacenmovimientos` `c`) join `public_ums` `x`) join `public_almacendocs` `s`) where ((`s`.`id` = `t`.`hidvale`) and (`t`.`codart` = `a`.`codigo`) and (`t`.`codocuref` = `b`.`coddocu`) and (`t`.`codmov` = `c`.`codmov`) and (`t`.`um` = `x`.`um`));

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_lugares`
--
DROP TABLE IF EXISTS `vw_lugares`;

CREATE ALGORITHM=UNDEFINED DEFINER=`neologys`@`localhost` SQL SECURITY DEFINER VIEW `vw_lugares` AS select `a`.`despro` AS `despro`,`b`.`codlugar` AS `codlugar`,`b`.`deslugar` AS `deslugar`,`b`.`provincia` AS `provincia`,`b`.`claselugar` AS `claselugar`,`b`.`codpro` AS `codpro`,`b`.`n_direc` AS `n_direc`,`c`.`c_direc` AS `c_direc` from ((`public_clipro` `a` join `public_lugares` `b`) join `public_direcciones` `c`) where ((`a`.`codpro` = `b`.`codpro`) and (`c`.`n_direc` = `b`.`n_direc`));

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_observaciones`
--
DROP TABLE IF EXISTS `vw_observaciones`;

CREATE ALGORITHM=UNDEFINED DEFINER=`neologys`@`localhost` SQL SECURITY DEFINER VIEW `vw_observaciones` AS select `c`.`idinventario` AS `idinventario`,`a`.`hidinventario` AS `hidinventario`,`a`.`fecha` AS `fecha`,`a`.`descri` AS `descri`,`a`.`mobs` AS `mobs`,`a`.`usuario` AS `usuario`,`a`.`id` AS `id`,`a`.`codestado` AS `codestado`,`b`.`estado` AS `estado`,`c`.`codigoaf` AS `codigoaf`,`c`.`codigosap` AS `codigosap`,`c`.`codlugar` AS `codlugar`,`c`.`descripcion` AS `descripcion`,`c`.`marca` AS `marca`,`c`.`modelo` AS `modelo`,`c`.`serie` AS `serie`,`c`.`codcentro` AS `codcentro` from ((`public_observaciones` `a` join `public_estado` `b`) join `public_inventario` `c`) where ((`a`.`codestado` = `b`.`codestado`) and (`a`.`hidinventario` = `c`.`idinventario`) and (`b`.`codocu` = '033'));

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_ocompra`
--
DROP TABLE IF EXISTS `vw_ocompra`;

CREATE ALGORITHM=UNDEFINED DEFINER=`neologys`@`localhost` SQL SECURITY DEFINER VIEW `vw_ocompra` AS select `coti`.`numcot` AS `numcot`,`coti`.`codpro` AS `codpro`,`coti`.`fecdoc` AS `fecdoc`,`coti`.`codcon` AS `codcon`,`coti`.`codestado` AS `codestado`,`coti`.`texto` AS `texto`,`coti`.`textolargo` AS `textolargo`,`coti`.`tipologia` AS `tipologia`,`coti`.`moneda` AS `moneda`,`coti`.`orcli` AS `orcli`,`ums`.`desum` AS `desum`,`coti`.`descuento` AS `descuento`,`coti`.`usuario` AS `usuario`,`coti`.`coddocu` AS `coddocu`,`coti`.`creado` AS `creado`,`coti`.`modificado` AS `modificado`,`coti`.`creadopor` AS `creadopor`,`coti`.`creadoel` AS `creadoel`,`coti`.`modificadopor` AS `modificadopor`,`coti`.`modificadoel` AS `modificadoel`,`coti`.`codtipofac` AS `codtipofac`,`coti`.`codsociedad` AS `codsociedad`,`coti`.`codgrupoventas` AS `codgrupoventas`,`coti`.`codtipocotizacion` AS `codtipocotizacion`,`coti`.`validez` AS `validez`,`coti`.`codcentro` AS `codcentro`,`coti`.`nigv` AS `nigv`,`coti`.`codobjeto` AS `codobjeto`,`coti`.`fechapresentacion` AS `fechapresentacion`,`coti`.`fechanominal` AS `fechanominal`,`coti`.`idguia` AS `idguia`,`x`.`id` AS `id`,`x`.`codentro` AS `codentro`,`x`.`codigoalma` AS `codigoalma`,`x`.`codart` AS `codart`,`x`.`disp` AS `disp`,`x`.`cant` AS `cant`,`x`.`punit` AS `punit`,`x`.`item` AS `item`,`x`.`descri` AS `descri`,`x`.`stock` AS `stock`,`x`.`detalle` AS `detalle`,`x`.`tipoitem` AS `tipoitem`,`x`.`estadodetalle` AS `estadodetalle`,`x`.`um` AS `um`,`x`.`hidguia` AS `hidguia`,`x`.`codservicio` AS `codservicio`,`x`.`tipoimputacion` AS `tipoimputacion`,(`x`.`punit` * `x`.`cant`) AS `subto`,`t_moneda`.`desmon` AS `desmon`,`tipofacturacion`.`tipofacturacion` AS `tipofacturacion`,`estado`.`estado` AS `estado`,`sociedades`.`rucsoc` AS `rucsoc`,`sociedades`.`dsocio` AS `dsocio`,`contactos`.`c_nombre` AS `c_nombre`,`t_moneda`.`simbolo` AS `simbolo`,`contactos`.`c_cargo` AS `c_cargo`,`clipro`.`despro` AS `despro`,`clipro`.`rucpro` AS `rucpro`,`clipro`.`emailpro` AS `emailpro`,`documentos`.`desdocu` AS `desdocu`,`tenores`.`mensaje` AS `textocabeza`,`tenores1`.`mensaje` AS `textopie` from (((((((((((`public_ocompra` `coti` join `public_docompra` `x`) join `public_sociedades` `sociedades`) join `public_documentos` `documentos`) join `public_clipro` `clipro`) join `public_contactos` `contactos`) join `public_tipofacturacion` `tipofacturacion`) join `public_t_moneda` `t_moneda`) join `public_tenores` `tenores`) join `public_tenores` `tenores1`) join `public_estado` `estado`) join `public_ums` `ums`) where ((`coti`.`codsociedad` = `sociedades`.`socio`) and (`coti`.`coddocu` = `documentos`.`coddocu`) and (`coti`.`codpro` = `clipro`.`codpro`) and (`coti`.`idcontacto` = `contactos`.`id`) and (`coti`.`codtipofac` = `tipofacturacion`.`codtipofac`) and (`coti`.`moneda` = `t_moneda`.`codmoneda`) and (`coti`.`tenorsup` = `tenores`.`posicion`) and (`coti`.`coddocu` = `tenores`.`coddocu`) and (`coti`.`tenorinf` = `tenores1`.`posicion`) and (`coti`.`coddocu` = `tenores1`.`coddocu`) and (`x`.`um` = `ums`.`um`) and (`coti`.`idguia` = `x`.`hidguia`) and (`coti`.`codestado` = `estado`.`codestado`) and (`coti`.`coddocu` = `estado`.`codocu`)) order by `x`.`item`;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_ocosubtotal`
--
DROP TABLE IF EXISTS `vw_ocosubtotal`;

CREATE ALGORITHM=UNDEFINED DEFINER=`neologys`@`localhost` SQL SECURITY DEFINER VIEW `vw_ocosubtotal` AS select `a`.`idguia` AS `idguia`,`b`.`hidguia` AS `hidguia`,`a`.`nigv` AS `nigv`,`a`.`descuento` AS `descuento`,`f`.`simbolo` AS `simbolo`,round(sum((`b`.`punit` * `b`.`cant`)),2) AS `subtotal`,round(((sum((`b`.`punit` * `b`.`cant`)) * `a`.`descuento`) / 100),2) AS `destotal`,round((sum((`b`.`punit` * `b`.`cant`)) - ((sum((`b`.`punit` * `b`.`cant`)) * `a`.`descuento`) / 100)),2) AS `subtotaldes`,round((sum((`b`.`punit` * `b`.`cant`)) * `a`.`nigv`),2) AS `impuesto`,round(((sum((`b`.`punit` * `b`.`cant`)) - ((sum((`b`.`punit` * `b`.`cant`)) * `a`.`descuento`) / 100)) + (sum((`b`.`punit` * `b`.`cant`)) * `a`.`nigv`)),2) AS `total` from ((`public_ocompra` `a` join `public_docompra` `b`) join `public_t_moneda` `f`) where ((`a`.`idguia` = `b`.`hidguia`) and (`a`.`moneda` = `f`.`codmoneda`)) group by `a`.`idguia`,`a`.`nigv`,`a`.`descuento`,`b`.`hidguia`,`f`.`simbolo`;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_opcionesdocumentos`
--
DROP TABLE IF EXISTS `vw_opcionesdocumentos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`neologys`@`localhost` SQL SECURITY DEFINER VIEW `vw_opcionesdocumentos` AS select `documentos`.`desdocu` AS `desdocu`,`opcionesdocumentos`.`idopdoc` AS `idopdoc`,`opcionescamposdocu`.`campo` AS `campo`,`opcionescamposdocu`.`nombrecampo` AS `nombrecampo`,`opcionescamposdocu`.`tipodato` AS `tipodato`,`opcionescamposdocu`.`longitud` AS `longitud`,`opcionesdocumentos`.`id` AS `id`,`opcionesdocumentos`.`idusuario` AS `idusuario`,`cruge_user`.`username` AS `username`,`documentos`.`coddocu` AS `coddocu`,`opcionesdocumentos`.`valor` AS `valor`,`opcionescamposdocu`.`seleccionable` AS `seleccionable` from (((`public_documentos` `documentos` join `cruge_user`) join `public_opcionescamposdocu` `opcionescamposdocu`) join `public_opcionesdocumentos` `opcionesdocumentos`) where ((`documentos`.`coddocu` = `opcionescamposdocu`.`codocu`) and (`opcionesdocumentos`.`idopdoc` = `opcionescamposdocu`.`id`) and (`opcionesdocumentos`.`idusuario` = `cruge_user`.`iduser`));

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_solpe`
--
DROP TABLE IF EXISTS `vw_solpe`;

CREATE ALGORITHM=UNDEFINED DEFINER=`neologys`@`localhost` SQL SECURITY DEFINER VIEW `vw_solpe` AS select `a`.`id` AS `identidad`,`t`.`numero` AS `numero`,`t`.`posicion` AS `posicion`,`t`.`tipimputacion` AS `tipimputacion`,`t`.`centro` AS `centro`,`t`.`codal` AS `codal`,`t`.`codart` AS `codart`,`t`.`txtmaterial` AS `txtmaterial`,`t`.`grupocompras` AS `grupocompras`,`t`.`usuario` AS `usuario`,`t`.`modificado` AS `modificado`,`t`.`textodetalle` AS `textodetalle`,`t`.`fechacrea` AS `fechacrea`,`t`.`fechaent` AS `fechaent`,`t`.`fechalib` AS `fechalib`,`t`.`estadolib` AS `estadolib`,`t`.`imputacion` AS `imputacion`,`t`.`solicitanet` AS `solicitanet`,`t`.`hidsolpe` AS `hidsolpe`,`t`.`creado` AS `creado`,`t`.`creadopor` AS `creadopor`,`t`.`creadoel` AS `creadoel`,`a`.`escompra` AS `escompra`,`t`.`modificadopor` AS `modificadopor`,`t`.`modificadoel` AS `modificadoel`,`t`.`id` AS `id`,`x`.`desum` AS `desum`,`t`.`codocu` AS `codocu`,`t`.`um` AS `um`,`t`.`tipsolpe` AS `tipsolpe`,`t`.`est` AS `est`,`t`.`cant` AS `cant`,`t`.`item` AS `item`,`a`.`numero` AS `numsolpe` from ((`public_solpe` `a` join `public_desolpe1` `t`) join `public_ums` `x`) where ((`a`.`id` = `t`.`hidsolpe`) and (`t`.`um` = `x`.`um`) and (`t`.`est` <> '99'));

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_solpeatencion`
--
DROP TABLE IF EXISTS `vw_solpeatencion`;

CREATE ALGORITHM=UNDEFINED DEFINER=`neologys`@`190.117.170.37` SQL SECURITY DEFINER VIEW `vw_solpeatencion` AS select `q`.`numero` AS `numero`,`t`.`centro` AS `centro`,`t`.`codal` AS `codal`,`t`.`usuario` AS `usuario`,`t`.`fechacrea` AS `fechacrea`,`t`.`fechaent` AS `fechaent`,`t`.`imputacion` AS `imputacion`,`t`.`hidsolpe` AS `hidsolpe`,`t`.`codocu` AS `codocu`,`t`.`id` AS `id`,`t`.`item` AS `item`,`t`.`cant` AS `cant`,`t`.`txtmaterial` AS `txtmaterial`,`t`.`codart` AS `codart`,`s`.`desum` AS `desum`,`r`.`cantlibre` AS `cantlibre`,`u`.`desum` AS `umbase`,`r`.`canttran` AS `canttran`,`r`.`cantres` AS `cantres` from (((((`public_desolpe1` `t` join `public_solpe` `q`) join `public_ums` `s`) join `public_alinventario` `r`) join `public_ums` `u`) join `public_maestrocomponentes` `m`) where ((`t`.`hidsolpe` = `q`.`id`) and (`t`.`um` = `s`.`um`) and (`t`.`centro` = `r`.`codcen`) and (`t`.`codal` = `r`.`codalm`) and (`t`.`codart` = `r`.`codart`) and (`r`.`codart` = `m`.`codigo`) and (`m`.`um` = `u`.`um`));

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_solpereservas`
--
DROP TABLE IF EXISTS `vw_solpereservas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`neologys`@`localhost` SQL SECURITY DEFINER VIEW `vw_solpereservas` AS select `k`.`desum` AS `desum`,`a`.`id` AS `identidad`,`t`.`numero` AS `numero`,`t`.`posicion` AS `posicion`,`a`.`escompra` AS `escompra`,`t`.`tipimputacion` AS `tipimputacion`,`t`.`centro` AS `centro`,`t`.`codal` AS `codal`,`t`.`codart` AS `codart`,`t`.`txtmaterial` AS `txtmaterial`,`t`.`grupocompras` AS `grupocompras`,`t`.`usuario` AS `usuariodesolpe`,`t`.`modificado` AS `modificado`,`t`.`textodetalle` AS `textodetalle`,`t`.`fechacrea` AS `fechacrea`,`t`.`fechaent` AS `fechaent`,`t`.`fechalib` AS `fechalib`,`t`.`estadolib` AS `estadolib`,`t`.`imputacion` AS `imputacion`,`t`.`solicitanet` AS `solicitanet`,`t`.`hidsolpe` AS `hidsolpe`,`t`.`creado` AS `creado`,`t`.`creadopor` AS `creadopor`,`t`.`creadoel` AS `creadoel`,`t`.`modificadopor` AS `modificadopor`,`t`.`modificadoel` AS `modificadoel`,`t`.`id` AS `iddesolpe`,`t`.`codocu` AS `codocusolpe`,`t`.`um` AS `um`,`t`.`tipsolpe` AS `tipsolpe`,`t`.`est` AS `est`,`t`.`cant` AS `cantdesolpe`,`t`.`item` AS `item`,`a`.`numero` AS `numsolpe`,`w`.`id` AS `id`,`w`.`hidesolpe` AS `hidesolpe`,`w`.`estadoreserva` AS `estadoreserva`,`w`.`fechares` AS `fechares`,`w`.`usuario` AS `usuario`,`w`.`cant` AS `cant`,`w`.`codocu` AS `codocu`,`w`.`numreserva` AS `numreserva`,`w`.`flag` AS `flag`,`w`.`rex` AS `rex`,`w`.`atendido` AS `atendido` from (((`public_solpe` `a` join `public_desolpe1` `t`) join `public_alreserva` `w`) join `public_ums` `k`) where ((`a`.`id` = `t`.`hidsolpe`) and (`t`.`est` <> '99') and (`t`.`id` = `w`.`hidesolpe`) and (`t`.`um` = `k`.`um`));

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_trabajadores`
--
DROP TABLE IF EXISTS `vw_trabajadores`;

CREATE ALGORITHM=UNDEFINED DEFINER=`neologys`@`localhost` SQL SECURITY DEFINER VIEW `vw_trabajadores` AS select `trabajadores`.`codigotra` AS `codigotra`,concat(`trabajadores`.`ap`,'-',`trabajadores`.`am`,'-',`trabajadores`.`nombres`) AS `nombrecompleto`,`trabajadores`.`codpuesto` AS `codpuesto`,`trabajadores`.`ap` AS `ap`,`trabajadores`.`am` AS `am`,`trabajadores`.`nombres` AS `nombres`,`trabajadores`.`dni` AS `dni`,`oficios`.`oficio` AS `oficio` from (`public_trabajadores` `trabajadores` join `public_oficios` `oficios`) where (`trabajadores`.`codpuesto` = `oficios`.`codof`);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ActiveRecordLog`
--
ALTER TABLE `ActiveRecordLog`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cruge_authassignment`
--
ALTER TABLE `cruge_authassignment`
ADD PRIMARY KEY (`userid`,`itemname`), ADD KEY `fk_cruge_authassignment_cruge_authitem1` (`itemname`);

--
-- Indices de la tabla `cruge_authitem`
--
ALTER TABLE `cruge_authitem`
ADD PRIMARY KEY (`name`);

--
-- Indices de la tabla `cruge_authitemchild`
--
ALTER TABLE `cruge_authitemchild`
ADD PRIMARY KEY (`parent`,`child`);

--
-- Indices de la tabla `cruge_field`
--
ALTER TABLE `cruge_field`
ADD PRIMARY KEY (`idfield`);

--
-- Indices de la tabla `cruge_fieldvalue`
--
ALTER TABLE `cruge_fieldvalue`
ADD PRIMARY KEY (`idfieldvalue`);

--
-- Indices de la tabla `cruge_session`
--
ALTER TABLE `cruge_session`
ADD PRIMARY KEY (`idsession`);

--
-- Indices de la tabla `cruge_system`
--
ALTER TABLE `cruge_system`
ADD PRIMARY KEY (`idsystem`);

--
-- Indices de la tabla `cruge_user`
--
ALTER TABLE `cruge_user`
ADD PRIMARY KEY (`iduser`);

--
-- Indices de la tabla `gallery`
--
ALTER TABLE `gallery`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `gallery_photo`
--
ALTER TABLE `gallery_photo`
ADD PRIMARY KEY (`id`), ADD KEY `fk_gallery_photo_gallery1` (`gallery_id`);

--
-- Indices de la tabla `public_aceites`
--
ALTER TABLE `public_aceites`
ADD PRIMARY KEY (`comaterial`);

--
-- Indices de la tabla `public_acoplados`
--
ALTER TABLE `public_acoplados`
ADD PRIMARY KEY (`codacople`);

--
-- Indices de la tabla `public_activos`
--
ALTER TABLE `public_activos`
ADD PRIMARY KEY (`idactivo`);

--
-- Indices de la tabla `public_albums`
--
ALTER TABLE `public_albums`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_alconversiones`
--
ALTER TABLE `public_alconversiones`
ADD PRIMARY KEY (`id`), ADD KEY `fki_conamagerial` (`codart`), ADD KEY `fki_flflkf` (`um2`), ADD KEY `fki_ums` (`um1`);

--
-- Indices de la tabla `public_alentregas`
--
ALTER TABLE `public_alentregas`
ADD PRIMARY KEY (`id`), ADD KEY `fki_detcvompas` (`iddetcompra`), ADD KEY `fki_oetret` (`idkardex`);

--
-- Indices de la tabla `public_aliascampos`
--
ALTER TABLE `public_aliascampos`
ADD PRIMARY KEY (`nombrecampo`,`nombretabla`);

--
-- Indices de la tabla `public_alinventario`
--
ALTER TABLE `public_alinventario`
ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `uk_registroinv` (`codart`,`codalm`,`codcen`), ADD KEY `bk_codart` (`codart`), ADD KEY `k_centros` (`codcen`), ADD KEY `k_almacend` (`codalm`);

--
-- Indices de la tabla `public_alkardex`
--
ALTER TABLE `public_alkardex`
ADD PRIMARY KEY (`id`), ADD KEY `fki_movis` (`codmov`), ADD KEY `fki_oetoetee` (`hidvale`), ADD KEY `fki_codigomat` (`codart`), ADD KEY `fki_cemitr` (`codcentro`), ADD KEY `fki_docirer` (`codocuref`), ADD KEY `fki_deod` (`coddoc`), ADD KEY `bk_codcendes` (`codcendes`);

--
-- Indices de la tabla `public_alkardextraslado`
--
ALTER TABLE `public_alkardextraslado`
ADD PRIMARY KEY (`id`), ADD KEY `hidkardexemi` (`hidkardexemi`), ADD KEY `hidkardexdes` (`hidkardexdes`);

--
-- Indices de la tabla `public_almacendocdet`
--
ALTER TABLE `public_almacendocdet`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_almacendocs`
--
ALTER TABLE `public_almacendocs`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_almacenes`
--
ALTER TABLE `public_almacenes`
ADD PRIMARY KEY (`codalm`), ADD KEY `FKI_AL_234` (`codcen`), ADD KEY `FKI_AL_1234` (`codsoc`);

--
-- Indices de la tabla `public_almacenmovimientos`
--
ALTER TABLE `public_almacenmovimientos`
ADD PRIMARY KEY (`codmov`), ADD KEY `fki_docui` (`codocu`);

--
-- Indices de la tabla `public_almacen_detalle_vale`
--
ALTER TABLE `public_almacen_detalle_vale`
ADD PRIMARY KEY (`hidvale`,`idvaledetalle`);

--
-- Indices de la tabla `public_almacen_inventario_detalle`
--
ALTER TABLE `public_almacen_inventario_detalle`
ADD PRIMARY KEY (`idinvetariodetalle`,`hidinventario`);

--
-- Indices de la tabla `public_almacen_objetos`
--
ALTER TABLE `public_almacen_objetos`
ADD PRIMARY KEY (`codobjeto`);

--
-- Indices de la tabla `public_alreserva`
--
ALTER TABLE `public_alreserva`
ADD PRIMARY KEY (`id`), ADD KEY `fki_fk` (`codocu`), ADD KEY `fki_eitet` (`estadoreserva`,`codocu`), ADD KEY `hidesolpe` (`hidesolpe`);

--
-- Indices de la tabla `public_alumnos`
--
ALTER TABLE `public_alumnos`
ADD PRIMARY KEY (`idalumno`);

--
-- Indices de la tabla `public_archivador`
--
ALTER TABLE `public_archivador`
ADD PRIMARY KEY (`id`), ADD KEY `fki_documn` (`codocu`);

--
-- Indices de la tabla `public_areas`
--
ALTER TABLE `public_areas`
ADD PRIMARY KEY (`codarea`);

--
-- Indices de la tabla `public_atencionreserva`
--
ALTER TABLE `public_atencionreserva`
ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `bkhidakded4s` (`hidkardex`), ADD KEY `bk_idreserva` (`hidreserva`), ADD KEY `hidkardex` (`hidkardex`), ADD KEY `hidreserva` (`hidreserva`);

--
-- Indices de la tabla `public_authassignment`
--
ALTER TABLE `public_authassignment`
ADD PRIMARY KEY (`itemname`,`userid`);

--
-- Indices de la tabla `public_authitem`
--
ALTER TABLE `public_authitem`
ADD PRIMARY KEY (`name`);

--
-- Indices de la tabla `public_autorizacion_personal`
--
ALTER TABLE `public_autorizacion_personal`
ADD PRIMARY KEY (`idpermiso`);

--
-- Indices de la tabla `public_autorizacion_personal_detalle`
--
ALTER TABLE `public_autorizacion_personal_detalle`
ADD PRIMARY KEY (`idaut`);

--
-- Indices de la tabla `public_bandeja`
--
ALTER TABLE `public_bandeja`
ADD PRIMARY KEY (`coddocu`,`usuario`,`numdocu`);

--
-- Indices de la tabla `public_bloqueos`
--
ALTER TABLE `public_bloqueos`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_borrar`
--
ALTER TABLE `public_borrar`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_calificaciones`
--
ALTER TABLE `public_calificaciones`
ADD PRIMARY KEY (`idcalificacion`);

--
-- Indices de la tabla `public_camionetas`
--
ALTER TABLE `public_camionetas`
ADD PRIMARY KEY (`placa`);

--
-- Indices de la tabla `public_cargos`
--
ALTER TABLE `public_cargos`
ADD PRIMARY KEY (`cnumcargo`), ADD KEY `fki_auto` (`codjefe`), ADD KEY `fki_fd` (`codentrega`), ADD KEY `fki_traba` (`codentrega`);

--
-- Indices de la tabla `public_carteres`
--
ALTER TABLE `public_carteres`
ADD PRIMARY KEY (`id`), ADD KEY `FKI_CSTRES_MAESTRO_` (`tipoaceite`), ADD KEY `fki_FK-CATERES_EQUIPOS` (`idequipo`);

--
-- Indices de la tabla `public_carteres_control`
--
ALTER TABLE `public_carteres_control`
ADD PRIMARY KEY (`idcontrol`);

--
-- Indices de la tabla `public_carteres_envios`
--
ALTER TABLE `public_carteres_envios`
ADD PRIMARY KEY (`idenvio`);

--
-- Indices de la tabla `public_carteres_eventos`
--
ALTER TABLE `public_carteres_eventos`
ADD PRIMARY KEY (`tipoevento`);

--
-- Indices de la tabla `public_catvaloracion`
--
ALTER TABLE `public_catvaloracion`
ADD PRIMARY KEY (`codcatval`);

--
-- Indices de la tabla `public_cc`
--
ALTER TABLE `public_cc`
ADD PRIMARY KEY (`codc`);

--
-- Indices de la tabla `public_ccgastos`
--
ALTER TABLE `public_ccgastos`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_centros`
--
ALTER TABLE `public_centros`
ADD PRIMARY KEY (`codcen`);

--
-- Indices de la tabla `public_centros_areas`
--
ALTER TABLE `public_centros_areas`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_choferes`
--
ALTER TABLE `public_choferes`
ADD PRIMARY KEY (`brevete`);

--
-- Indices de la tabla `public_clases`
--
ALTER TABLE `public_clases`
ADD PRIMARY KEY (`codcla`);

--
-- Indices de la tabla `public_clasesmaestro`
--
ALTER TABLE `public_clasesmaestro`
ADD PRIMARY KEY (`codclasema`);

--
-- Indices de la tabla `public_clipro`
--
ALTER TABLE `public_clipro`
ADD PRIMARY KEY (`codpro`), ADD KEY `i_codpro` (`codpro`);

--
-- Indices de la tabla `public_cnf_patrones`
--
ALTER TABLE `public_cnf_patrones`
ADD PRIMARY KEY (`elemento`);

--
-- Indices de la tabla `public_collections`
--
ALTER TABLE `public_collections`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_confcorreo`
--
ALTER TABLE `public_confcorreo`
ADD PRIMARY KEY (`parametro`);

--
-- Indices de la tabla `public_conformidades`
--
ALTER TABLE `public_conformidades`
ADD PRIMARY KEY (`idconfomidad`);

--
-- Indices de la tabla `public_contactos`
--
ALTER TABLE `public_contactos`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_controlactivos`
--
ALTER TABLE `public_controlactivos`
ADD PRIMARY KEY (`idformato`);

--
-- Indices de la tabla `public_controlactivosemplazamientos`
--
ALTER TABLE `public_controlactivosemplazamientos`
ADD PRIMARY KEY (`codtipo`);

--
-- Indices de la tabla `public_cont_categoriasvalor`
--
ALTER TABLE `public_cont_categoriasvalor`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_cont_determcuentas`
--
ALTER TABLE `public_cont_determcuentas`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_coordocs`
--
ALTER TABLE `public_coordocs`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_coti`
--
ALTER TABLE `public_coti`
ADD PRIMARY KEY (`idguia`), ADD KEY `fki_coti_mioneda2` (`moneda`), ADD KEY `FKI_CLCO` (`codpro`), ADD KEY `FKI_GPVEf2` (`codgrupoventas`), ADD KEY `FKI_SOCO2` (`codsociedad`), ADD KEY `fki_` (`codtipofac`), ADD KEY `FKI_EDCOTIf` (`codestado`,`coddocu`), ADD KEY `FKI_GPVE2` (`codgrupoventas`), ADD KEY `fki_coanmahs` (`idcontacto`), ADD KEY `fki_contactos_coti` (`codpro`,`codcon`), ADD KEY `FKI_CENTROS` (`codcentro`), ADD KEY `fki_coti_docuf` (`coddocu`), ADD KEY `fki_contactos_cotif2` (`codpro`,`codcon`), ADD KEY `FKI_CENTROSf2` (`codcentro`), ADD KEY `fki_coti_tenorsupf` (`coddocu`,`tenorsup`), ADD KEY `fki_coti_mioneda` (`moneda`), ADD KEY `FKI_CLCOf2` (`codpro`), ADD KEY `fki_coanmahs2` (`idcontacto`), ADD KEY `fki_coti_docu` (`coddocu`), ADD KEY `fki_coti_mionedaf` (`moneda`), ADD KEY `fki_f2` (`codtipofac`), ADD KEY `fki_2` (`codtipofac`), ADD KEY `FKI_CENTROS2` (`codcentro`), ADD KEY `FKI_SOCOf2` (`codsociedad`), ADD KEY `fki_coti_cod_objeto` (`codpro`,`codobjeto`), ADD KEY `fki_coti_tenorsup2` (`coddocu`,`tenorsup`), ADD KEY `FKI_EDCOTI2` (`codestado`,`coddocu`), ADD KEY `FKI_EDCOTIf2` (`codestado`,`coddocu`), ADD KEY `FKI_GPVE` (`codgrupoventas`), ADD KEY `FKI_SOCO` (`codsociedad`), ADD KEY `fki_coti_cod_objeto2` (`codpro`,`codobjeto`);

--
-- Indices de la tabla `public_cruge_authassignment`
--
ALTER TABLE `public_cruge_authassignment`
ADD PRIMARY KEY (`userid`,`itemname`);

--
-- Indices de la tabla `public_cruge_authitemchild`
--
ALTER TABLE `public_cruge_authitemchild`
ADD PRIMARY KEY (`parent`,`child`);

--
-- Indices de la tabla `public_cruge_grupos_mail`
--
ALTER TABLE `public_cruge_grupos_mail`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_cruge_lista_mail`
--
ALTER TABLE `public_cruge_lista_mail`
ADD PRIMARY KEY (`id`), ADD KEY `fki_grupos_crumal` (`hid`), ADD KEY `fki_cruge_users` (`iduser`);

--
-- Indices de la tabla `public_cursos`
--
ALTER TABLE `public_cursos`
ADD PRIMARY KEY (`codcurso`);

--
-- Indices de la tabla `public_dcotmateriales`
--
ALTER TABLE `public_dcotmateriales`
ADD PRIMARY KEY (`id`), ADD KEY `fki_detcot_materiales2` (`codart`), ADD KEY `fki_hija_coti` (`hidguia`), ADD KEY `fki_dospi_coti` (`disp`), ADD KEY `fki_dospi_coti2` (`disp`), ADD KEY `fki_hija_coti2` (`hidguia`), ADD KEY `fki_es_det_coti2` (`coddocu`,`estadodetalle`), ADD KEY `fki_detcot_materiales` (`codart`), ADD KEY `fki_es_det_coti` (`coddocu`,`estadodetalle`);

--
-- Indices de la tabla `public_dcotmateriales_d`
--
ALTER TABLE `public_dcotmateriales_d`
ADD PRIMARY KEY (`id`), ADD KEY `FKI_DETALLE_D_COTI` (`hid`);

--
-- Indices de la tabla `public_dcottipo`
--
ALTER TABLE `public_dcottipo`
ADD PRIMARY KEY (`codtipo`);

--
-- Indices de la tabla `public_defaultguia`
--
ALTER TABLE `public_defaultguia`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_denvio`
--
ALTER TABLE `public_denvio`
ADD PRIMARY KEY (`hnenvio`);

--
-- Indices de la tabla `public_desolpe1`
--
ALTER TABLE `public_desolpe1`
ADD PRIMARY KEY (`id`), ADD KEY `codart` (`codart`), ADD KEY `k_codal` (`codal`), ADD KEY `k_centro` (`centro`), ADD KEY `bk_hidesolpe` (`hidsolpe`), ADD KEY `fk_Pdfdffd` (`um`), ADD KEY `bk_registroinv` (`codart`,`codal`,`centro`);

--
-- Indices de la tabla `public_desolpecompra`
--
ALTER TABLE `public_desolpecompra`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_detcargos`
--
ALTER TABLE `public_detcargos`
ADD PRIMARY KEY (`iddetcargo`);

--
-- Indices de la tabla `public_detcontrolactivos`
--
ALTER TABLE `public_detcontrolactivos`
ADD PRIMARY KEY (`iddetalle`);

--
-- Indices de la tabla `public_detdocumentoscomponentes`
--
ALTER TABLE `public_detdocumentoscomponentes`
ADD PRIMARY KEY (`iddetalle`);

--
-- Indices de la tabla `public_detgui`
--
ALTER TABLE `public_detgui`
ADD PRIMARY KEY (`id`), ADD KEY `I_CODSAP` (`c_codsap`), ADD KEY `i_pc_estado` (`c_estado`), ADD KEY `fki_detgui_paraqueva` (`c_edgui`), ADD KEY `i_n_hguia` (`n_hguia`), ADD KEY `I_CDOAF` (`c_codactivo`), ADD KEY `i_cedgui` (`c_edgui`), ADD KEY `i_citguia` (`c_itguia`);

--
-- Indices de la tabla `public_detrep`
--
ALTER TABLE `public_detrep`
ADD PRIMARY KEY (`idrep`);

--
-- Indices de la tabla `public_dfacrecibida`
--
ALTER TABLE `public_dfacrecibida`
ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `unique_id` (`id`), ADD UNIQUE KEY `bk_ds` (`hientrega`);

--
-- Indices de la tabla `public_direcciones`
--
ALTER TABLE `public_direcciones`
ADD PRIMARY KEY (`n_direc`), ADD KEY `i_ndirecc` (`n_direc`), ADD KEY `FKI_CLIPRO_DIRECCIONES` (`c_hcod`);

--
-- Indices de la tabla `public_dirsociedad`
--
ALTER TABLE `public_dirsociedad`
ADD PRIMARY KEY (`n_dir`);

--
-- Indices de la tabla `public_disponiblidad`
--
ALTER TABLE `public_disponiblidad`
ADD PRIMARY KEY (`codisp`);

--
-- Indices de la tabla `public_docompra`
--
ALTER TABLE `public_docompra`
ADD PRIMARY KEY (`id`), ADD KEY `fki_centrterot` (`codentro`), ADD KEY `fki_fK-ocapmra` (`hidguia`), ADD KEY `fki_maestrocompotrn e` (`codart`), ADD KEY `fki_fK-ocapmrat` (`hidguia`), ADD KEY `fki_docueme` (`estadodetalle`,`coddocu`), ADD KEY `fki_docuemet` (`estadodetalle`,`coddocu`), ADD KEY `fki_maestrocompotrn et` (`codart`), ADD KEY `fki_oeteoyjeyet` (`codigoalma`,`codentro`,`codart`), ADD KEY `fki_oeteoyjeye` (`codigoalma`,`codentro`,`codart`), ADD KEY `fki_almandetete` (`codigoalma`), ADD KEY `fki_almandetetet` (`codigoalma`), ADD KEY `fki_centrterott` (`codentro`), ADD KEY `fki_material` (`codart`), ADD KEY `fk_docompra_docu` (`coddocu`);

--
-- Indices de la tabla `public_docompra_t`
--
ALTER TABLE `public_docompra_t`
ADD PRIMARY KEY (`id`), ADD KEY `fki_ordencompra` (`punitdes`), ADD KEY `fk_docomprat_docu` (`coddocu`), ADD KEY `codart` (`codart`);

--
-- Indices de la tabla `public_documentos`
--
ALTER TABLE `public_documentos`
ADD PRIMARY KEY (`coddocu`);

--
-- Indices de la tabla `public_documentoscomponentes`
--
ALTER TABLE `public_documentoscomponentes`
ADD PRIMARY KEY (`iddoc`);

--
-- Indices de la tabla `public_documentosfavoritos`
--
ALTER TABLE `public_documentosfavoritos`
ADD PRIMARY KEY (`id`), ADD KEY `codocu` (`codocu`), ADD KEY `hidocu` (`hidocu`);

--
-- Indices de la tabla `public_docu_ingresados`
--
ALTER TABLE `public_docu_ingresados`
ADD PRIMARY KEY (`id`), ADD KEY `fki_tra` (`codresponsable`), ADD KEY `fki_pro` (`codprov`), ADD KEY `fki_doc` (`tipodoc`), ADD KEY `fki_orwer` (`codepv`);

--
-- Indices de la tabla `public_dpeticion`
--
ALTER TABLE `public_dpeticion`
ADD PRIMARY KEY (`id`), ADD KEY `hidpeticion` (`hidpeticion`), ADD KEY `um` (`um`), ADD KEY `codart` (`codart`), ADD KEY `codestado` (`codestado`), ADD KEY `codcen` (`codcen`), ADD KEY `codocu` (`codocu`), ADD KEY `codal` (`codal`);

--
-- Indices de la tabla `public_embarcaciones`
--
ALTER TABLE `public_embarcaciones`
ADD PRIMARY KEY (`codep`), ADD KEY `i_c_codepw` (`codep`), ADD KEY `IK_BARCOS` (`codep`);

--
-- Indices de la tabla `public_emplazamientos`
--
ALTER TABLE `public_emplazamientos`
ADD PRIMARY KEY (`idempla`);

--
-- Indices de la tabla `public_envio`
--
ALTER TABLE `public_envio`
ADD PRIMARY KEY (`nenvio`);

--
-- Indices de la tabla `public_errores`
--
ALTER TABLE `public_errores`
ADD PRIMARY KEY (`usuario`,`sesion`);

--
-- Indices de la tabla `public_especie`
--
ALTER TABLE `public_especie`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_estado`
--
ALTER TABLE `public_estado`
ADD PRIMARY KEY (`id`), ADD KEY `i_pc_estado1` (`codocu`), ADD KEY `i_codestado` (`codestado`);

--
-- Indices de la tabla `public_estados`
--
ALTER TABLE `public_estados`
ADD PRIMARY KEY (`codestado`);

--
-- Indices de la tabla `public_eventos`
--
ALTER TABLE `public_eventos`
ADD PRIMARY KEY (`id`), ADD KEY `fki_docioure` (`codocu`);

--
-- Indices de la tabla `public_factu`
--
ALTER TABLE `public_factu`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_facturd`
--
ALTER TABLE `public_facturd`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_formularios`
--
ALTER TABLE `public_formularios`
ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `public_gallery`
--
ALTER TABLE `public_gallery`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_galleryconfig`
--
ALTER TABLE `public_galleryconfig`
ADD PRIMARY KEY (`type`);

--
-- Indices de la tabla `public_gallery_photo`
--
ALTER TABLE `public_gallery_photo`
ADD PRIMARY KEY (`id`), ADD KEY `fk_gallery_photo_gallery22` (`gallery_id`);

--
-- Indices de la tabla `public_grupocompras`
--
ALTER TABLE `public_grupocompras`
ADD PRIMARY KEY (`codgrupo`);

--
-- Indices de la tabla `public_grupoventas`
--
ALTER TABLE `public_grupoventas`
ADD PRIMARY KEY (`codgrupo`);

--
-- Indices de la tabla `public_guia`
--
ALTER TABLE `public_guia`
ADD PRIMARY KEY (`id`), ADD KEY `fki_guia_socio` (`c_rsguia`), ADD KEY `FKI_HHJ` (`c_coclig`), ADD KEY `i_codobjeto` (`codobjeto`), ADD KEY `i_coestgui` (`c_estgui`), ADD KEY `FKI_DIRECCIONES` (`n_direc`), ADD KEY `i_n_directran` (`n_directran`), ADD KEY `fki_guia_objetos` (`c_coclig`,`codobjeto`), ADD KEY `i_c_serie` (`c_serie`), ADD KEY `i_crsguia` (`c_rsguia`), ADD KEY `i_n_hguias` (`n_guia`), ADD KEY `FKI_GUIA_DIREC_DEST` (`n_direcformaldes`), ADD KEY `FKI_GUIA_ESTADO` (`c_estgui`,`codocu`), ADD KEY `fki_trans` (`c_codtra`), ADD KEY `i_c_seriea` (`c_numgui`), ADD KEY `i_n_direcformaldes` (`n_direcformaldes`), ADD KEY `i_n_direc` (`n_direc`), ADD KEY `FKI_GUIA_DIRECC_TRANSP` (`n_directran`), ADD KEY `i_ndirsoc` (`n_dirsoc`), ADD KEY `i_c_codtra` (`c_codtra`), ADD KEY `i_c_coclig` (`c_coclig`), ADD KEY `FKI_CLIPRO_GUIA_TRANSPORT` (`c_codtra`);

--
-- Indices de la tabla `public_hcontrolactivos`
--
ALTER TABLE `public_hcontrolactivos`
ADD PRIMARY KEY (`iddetalle`);

--
-- Indices de la tabla `public_igv`
--
ALTER TABLE `public_igv`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_intereses_mant`
--
ALTER TABLE `public_intereses_mant`
ADD PRIMARY KEY (`codinteres`);

--
-- Indices de la tabla `public_inventario`
--
ALTER TABLE `public_inventario`
ADD PRIMARY KEY (`idinventario`), ADD KEY `fki_PK_CODLUGAR` (`codlugar`), ADD KEY `fki_estad` (`codestado`,`codigodoc`), ADD KEY `fki_fk-areas` (`codarea`), ADD KEY `fki_dlssfslkflsf` (`codlugar`);

--
-- Indices de la tabla `public_kardexcompo`
--
ALTER TABLE `public_kardexcompo`
ADD PRIMARY KEY (`idkardex`);

--
-- Indices de la tabla `public_keel_cooler`
--
ALTER TABLE `public_keel_cooler`
ADD PRIMARY KEY (`idkeel`);

--
-- Indices de la tabla `public_keel_resultados`
--
ALTER TABLE `public_keel_resultados`
ADD PRIMARY KEY (`id_keel_re`);

--
-- Indices de la tabla `public_locales`
--
ALTER TABLE `public_locales`
ADD PRIMARY KEY (`codlocal`);

--
-- Indices de la tabla `public_localidades`
--
ALTER TABLE `public_localidades`
ADD PRIMARY KEY (`codlocalidad`);

--
-- Indices de la tabla `public_logimpresiones`
--
ALTER TABLE `public_logimpresiones`
ADD PRIMARY KEY (`codocu`,`idodcu`);

--
-- Indices de la tabla `public_loginventario`
--
ALTER TABLE `public_loginventario`
ADD PRIMARY KEY (`idlog`), ADD KEY `fki_logcodepant` (`codepanterior`), ADD KEY `fki_logincode` (`hidinventario`), ADD KEY `fki_logincodod` (`coddocu`), ADD KEY `fki_log_codep` (`codep`);

--
-- Indices de la tabla `public_logtablas`
--
ALTER TABLE `public_logtablas`
ADD KEY `IDX_ID` (`id`);

--
-- Indices de la tabla `public_log_modificaciones`
--
ALTER TABLE `public_log_modificaciones`
ADD PRIMARY KEY (`id`), ADD KEY `ik_fecha` (`quien`), ADD KEY `ik_` (`quien`), ADD KEY `ik_quien` (`quien`), ADD KEY `IK_idlog` (`idregistro`);

--
-- Indices de la tabla `public_lotes`
--
ALTER TABLE `public_lotes`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_lugares`
--
ALTER TABLE `public_lugares`
ADD PRIMARY KEY (`id`), ADD KEY `fki_direccio` (`n_direc`), ADD KEY `fki_fk-centros` (`codplanta`), ADD KEY `fki_wewojfw` (`codpro`);

--
-- Indices de la tabla `public_maestroclipro`
--
ALTER TABLE `public_maestroclipro`
ADD PRIMARY KEY (`id`), ADD KEY `fki_centos_clipor_maestro` (`centro`), ADD KEY `fki_oereor` (`um`), ADD KEY `codart` (`codart`);

--
-- Indices de la tabla `public_maestrocomponentes`
--
ALTER TABLE `public_maestrocomponentes`
ADD PRIMARY KEY (`codigo`), ADD KEY `FKI_UMS` (`um`), ADD KEY `codtipo` (`codtipo`);

--
-- Indices de la tabla `public_maestrodetalle`
--
ALTER TABLE `public_maestrodetalle`
ADD PRIMARY KEY (`codart`,`codcentro`,`codal`), ADD KEY `FKI_ROIOTRY` (`codart`), ADD KEY `FKI_CATVAL` (`catval`), ADD KEY `fki_ceejet` (`codcentro`), ADD KEY `fki_maesgtrodetae` (`codart`), ADD KEY `fki_alammde` (`codal`);

--
-- Indices de la tabla `public_maestrodetallecentros`
--
ALTER TABLE `public_maestrodetallecentros`
ADD PRIMARY KEY (`id`), ADD KEY `hcodart` (`hcodart`);

--
-- Indices de la tabla `public_maestrogrupos`
--
ALTER TABLE `public_maestrogrupos`
ADD PRIMARY KEY (`codgrupo`);

--
-- Indices de la tabla `public_maestrosector`
--
ALTER TABLE `public_maestrosector`
ADD PRIMARY KEY (`codsector`);

--
-- Indices de la tabla `public_maestrosolicitudescabecera`
--
ALTER TABLE `public_maestrosolicitudescabecera`
ADD PRIMARY KEY (`id`), ADD KEY `fki_cenro` (`codcentro`);

--
-- Indices de la tabla `public_maestrotipos`
--
ALTER TABLE `public_maestrotipos`
ADD PRIMARY KEY (`id`), ADD KEY `codtipo` (`codtipo`);

--
-- Indices de la tabla `public_maestro_atributos`
--
ALTER TABLE `public_maestro_atributos`
ADD PRIMARY KEY (`id`), ADD KEY `fki_rryry` (`hid`);

--
-- Indices de la tabla `public_maestro_grupos`
--
ALTER TABLE `public_maestro_grupos`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_maestro_solicitudes`
--
ALTER TABLE `public_maestro_solicitudes`
ADD PRIMARY KEY (`id`), ADD KEY `fki_centrosoli` (`centro`), ADD KEY `fki_e94jhege` (`codgrupo`), ADD KEY `fki_iuyietye23` (`codclase`);

--
-- Indices de la tabla `public_maestro_valores`
--
ALTER TABLE `public_maestro_valores`
ADD PRIMARY KEY (`id`), ADD KEY `fki_nndj` (`hidat`);

--
-- Indices de la tabla `public_master_activos`
--
ALTER TABLE `public_master_activos`
ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `public_ma_cargos`
--
ALTER TABLE `public_ma_cargos`
ADD PRIMARY KEY (`codcargo`);

--
-- Indices de la tabla `public_mensajes`
--
ALTER TABLE `public_mensajes`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_mensajesd`
--
ALTER TABLE `public_mensajesd`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_modulos`
--
ALTER TABLE `public_modulos`
ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `public_motivo`
--
ALTER TABLE `public_motivo`
ADD PRIMARY KEY (`codmotivo`);

--
-- Indices de la tabla `public_mot_materiales`
--
ALTER TABLE `public_mot_materiales`
ADD PRIMARY KEY (`id`), ADD KEY `fki_barcos` (`codep`);

--
-- Indices de la tabla `public_mot_mat_det`
--
ALTER TABLE `public_mot_mat_det`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_noticias`
--
ALTER TABLE `public_noticias`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_novedades`
--
ALTER TABLE `public_novedades`
ADD PRIMARY KEY (`idnovedad`), ADD KEY `fki_gffgf` (`idpartepesca`);

--
-- Indices de la tabla `public_nuke_authors`
--
ALTER TABLE `public_nuke_authors`
ADD PRIMARY KEY (`aid`);

--
-- Indices de la tabla `public_nuke_cities`
--
ALTER TABLE `public_nuke_cities`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_nuke_pages`
--
ALTER TABLE `public_nuke_pages`
ADD PRIMARY KEY (`pid`), ADD KEY `nuke_pages_cid_idx` (`cid`);

--
-- Indices de la tabla `public_nuke_users`
--
ALTER TABLE `public_nuke_users`
ADD PRIMARY KEY (`user_id`), ADD KEY `nuke_users_karma_idx` (`karma`);

--
-- Indices de la tabla `public_nuke_users_temp`
--
ALTER TABLE `public_nuke_users_temp`
ADD PRIMARY KEY (`user_id`);

--
-- Indices de la tabla `public_objetos_cliente`
--
ALTER TABLE `public_objetos_cliente`
ADD PRIMARY KEY (`id`), ADD KEY `i_codobjetocli` (`codpro`), ADD KEY `i_codobjetos` (`codobjeto`);

--
-- Indices de la tabla `public_obras`
--
ALTER TABLE `public_obras`
ADD PRIMARY KEY (`idobra`);

--
-- Indices de la tabla `public_observaciones`
--
ALTER TABLE `public_observaciones`
ADD PRIMARY KEY (`id`), ADD KEY `fki_inventar` (`hidinventario`);

--
-- Indices de la tabla `public_observacionesdetalle`
--
ALTER TABLE `public_observacionesdetalle`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_ocompra`
--
ALTER TABLE `public_ocompra`
ADD PRIMARY KEY (`idguia`);

--
-- Indices de la tabla `public_oficios`
--
ALTER TABLE `public_oficios`
ADD PRIMARY KEY (`codof`);

--
-- Indices de la tabla `public_opciones`
--
ALTER TABLE `public_opciones`
ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `public_opcionescamposdocu`
--
ALTER TABLE `public_opcionescamposdocu`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_opcionesdocumentos`
--
ALTER TABLE `public_opcionesdocumentos`
ADD PRIMARY KEY (`id`), ADD KEY `fki_roeruoe` (`codocu`), ADD KEY `fki_ereprerre2242` (`idopdoc`), ADD KEY `fki_fK_wi9weuwe` (`idusuario`);

--
-- Indices de la tabla `public_opciones_envio_muestras`
--
ALTER TABLE `public_opciones_envio_muestras`
ADD PRIMARY KEY (`codpro`,`ndirec`,`usuario`);

--
-- Indices de la tabla `public_parametrosdocumentos`
--
ALTER TABLE `public_parametrosdocumentos`
ADD PRIMARY KEY (`codpara`);

--
-- Indices de la tabla `public_paraqueva`
--
ALTER TABLE `public_paraqueva`
ADD PRIMARY KEY (`cmotivo`), ADD KEY `i_parqueva` (`cmotivo`);

--
-- Indices de la tabla `public_pareto`
--
ALTER TABLE `public_pareto`
ADD PRIMARY KEY (`hinventario`);

--
-- Indices de la tabla `public_partes`
--
ALTER TABLE `public_partes`
ADD PRIMARY KEY (`id`), ADD KEY `fki_plantas` (`puerto`), ADD KEY `fki_hdhf` (`codep`), ADD KEY `fki_puedes` (`puertodes`);

--
-- Indices de la tabla `public_periodos`
--
ALTER TABLE `public_periodos`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_permisos`
--
ALTER TABLE `public_permisos`
ADD PRIMARY KEY (`coddocu`,`codpermiso`,`rolusuario`);

--
-- Indices de la tabla `public_permisosgenerales`
--
ALTER TABLE `public_permisosgenerales`
ADD PRIMARY KEY (`codpermiso`);

--
-- Indices de la tabla `public_personal`
--
ALTER TABLE `public_personal`
ADD PRIMARY KEY (`codpersona`);

--
-- Indices de la tabla `public_personal_calendario`
--
ALTER TABLE `public_personal_calendario`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_personal_externo`
--
ALTER TABLE `public_personal_externo`
ADD PRIMARY KEY (`idpersona`), ADD KEY `fki_oficios` (`oficio`);

--
-- Indices de la tabla `public_personal_periodo`
--
ALTER TABLE `public_personal_periodo`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_personal_turnos`
--
ALTER TABLE `public_personal_turnos`
ADD PRIMARY KEY (`codturno`);

--
-- Indices de la tabla `public_personal_turno_detalle`
--
ALTER TABLE `public_personal_turno_detalle`
ADD PRIMARY KEY (`codturno`,`dia`);

--
-- Indices de la tabla `public_pescaterceros`
--
ALTER TABLE `public_pescaterceros`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_peticion`
--
ALTER TABLE `public_peticion`
ADD PRIMARY KEY (`id`), ADD KEY `codpro` (`codpro`), ADD KEY `idcontacto` (`idcontacto`), ADD KEY `iduser` (`iduser`), ADD KEY `codocu` (`codocu`), ADD KEY `codestado` (`codestado`), ADD KEY `codmon` (`codmon`);

--
-- Indices de la tabla `public_plantas`
--
ALTER TABLE `public_plantas`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_player`
--
ALTER TABLE `public_player`
ADD PRIMARY KEY (`iplayer`);

--
-- Indices de la tabla `public_post`
--
ALTER TABLE `public_post`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_preferencias_campos`
--
ALTER TABLE `public_preferencias_campos`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_presupuesto`
--
ALTER TABLE `public_presupuesto`
ADD PRIMARY KEY (`idpresupuesto`);

--
-- Indices de la tabla `public_puente`
--
ALTER TABLE `public_puente`
ADD PRIMARY KEY (`codocu1`,`id1`,`codocu2`,`id2`);

--
-- Indices de la tabla `public_puestos`
--
ALTER TABLE `public_puestos`
ADD PRIMARY KEY (`codpuesto`);

--
-- Indices de la tabla `public_reparaciones`
--
ALTER TABLE `public_reparaciones`
ADD PRIMARY KEY (`numrep`);

--
-- Indices de la tabla `public_reportepesca`
--
ALTER TABLE `public_reportepesca`
ADD PRIMARY KEY (`id`), ADD KEY `fki_trt` (`idespecie`), ADD KEY `fki_plantadetino` (`codplantadestino`), ADD KEY `fki_tempora` (`idtemporada`);

--
-- Indices de la tabla `public_reportepesca_coor`
--
ALTER TABLE `public_reportepesca_coor`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_reportes`
--
ALTER TABLE `public_reportes`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_resumenpresupuesto`
--
ALTER TABLE `public_resumenpresupuesto`
ADD PRIMARY KEY (`anno`,`codep`,`codsistema`,`tipo`);

--
-- Indices de la tabla `public_seleccionable`
--
ALTER TABLE `public_seleccionable`
ADD PRIMARY KEY (`codsel`);

--
-- Indices de la tabla `public_servidorremoto`
--
ALTER TABLE `public_servidorremoto`
ADD PRIMARY KEY (`servidor`);

--
-- Indices de la tabla `public_sistemas`
--
ALTER TABLE `public_sistemas`
ADD PRIMARY KEY (`codsistema`);

--
-- Indices de la tabla `public_sociedades`
--
ALTER TABLE `public_sociedades`
ADD PRIMARY KEY (`socio`), ADD KEY `i_socio` (`socio`);

--
-- Indices de la tabla `public_solpe`
--
ALTER TABLE `public_solpe`
ADD PRIMARY KEY (`id`), ADD KEY `fki_kdfkd` (`estado`,`codocu`), ADD KEY `fki_solpe_docu` (`codocu`);

--
-- Indices de la tabla `public_subcomponentes`
--
ALTER TABLE `public_subcomponentes`
ADD PRIMARY KEY (`codigo`,`codpadre`);

--
-- Indices de la tabla `public_submodulos`
--
ALTER TABLE `public_submodulos`
ADD PRIMARY KEY (`codgrupo`);

--
-- Indices de la tabla `public_sys_access`
--
ALTER TABLE `public_sys_access`
ADD KEY `sk_sys_access_idaccess` (`idaccess`);

--
-- Indices de la tabla `public_sys_accessforms`
--
ALTER TABLE `public_sys_accessforms`
ADD KEY `sk_sys_accessforms_idaccess` (`idaccess`), ADD KEY `sk_sys_accessforms_idform` (`idform`);

--
-- Indices de la tabla `public_sys_errorlogs`
--
ALTER TABLE `public_sys_errorlogs`
ADD KEY `sk_sys_errorlogs_iderrorlog` (`iderrorlog`);

--
-- Indices de la tabla `public_sys_forms`
--
ALTER TABLE `public_sys_forms`
ADD KEY `sk_sys_forms_idform` (`idform`);

--
-- Indices de la tabla `public_sys_languages`
--
ALTER TABLE `public_sys_languages`
ADD KEY `sk_sys_languages_idlanguage` (`idlanguage`);

--
-- Indices de la tabla `public_sys_languageword`
--
ALTER TABLE `public_sys_languageword`
ADD KEY `sk_sys_languageword_idlanguage` (`idlanguage`), ADD KEY `sk_sys_languageword_idword` (`idword`);

--
-- Indices de la tabla `public_sys_menues`
--
ALTER TABLE `public_sys_menues`
ADD KEY `sk_sys_menues_idmenu` (`idmenu`);

--
-- Indices de la tabla `public_sys_tableconfig`
--
ALTER TABLE `public_sys_tableconfig`
ADD KEY `sk_sys_tableconfig_idtable` (`idtable`);

--
-- Indices de la tabla `public_sys_userconfig`
--
ALTER TABLE `public_sys_userconfig`
ADD KEY `sk_sys_userconfig_idcxu` (`idcxu`);

--
-- Indices de la tabla `public_sys_users`
--
ALTER TABLE `public_sys_users`
ADD KEY `sk_sys_users_iduser` (`iduser`);

--
-- Indices de la tabla `public_sys_words`
--
ALTER TABLE `public_sys_words`
ADD KEY `sk_sys_words_idword` (`idword`);

--
-- Indices de la tabla `public_tablaigv`
--
ALTER TABLE `public_tablaigv`
ADD PRIMARY KEY (`valorigv`);

--
-- Indices de la tabla `public_tbl_albums`
--
ALTER TABLE `public_tbl_albums`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_tbl_category`
--
ALTER TABLE `public_tbl_category`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_tbl_collections`
--
ALTER TABLE `public_tbl_collections`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_tbl_comment`
--
ALTER TABLE `public_tbl_comment`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_tbl_galleryconfig`
--
ALTER TABLE `public_tbl_galleryconfig`
ADD PRIMARY KEY (`type`);

--
-- Indices de la tabla `public_tbl_menu`
--
ALTER TABLE `public_tbl_menu`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_tbl_profiles`
--
ALTER TABLE `public_tbl_profiles`
ADD PRIMARY KEY (`user_id`);

--
-- Indices de la tabla `public_tbl_profiles_fields`
--
ALTER TABLE `public_tbl_profiles_fields`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_tbl_topic`
--
ALTER TABLE `public_tbl_topic`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_tbl_users`
--
ALTER TABLE `public_tbl_users`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_tempdetgui`
--
ALTER TABLE `public_tempdetgui`
ADD PRIMARY KEY (`idtemp`), ADD KEY `I_CODSAP` (`c_codsap`), ADD KEY `i_pc_estado` (`c_estado`), ADD KEY `fki_detgui_paraqueva` (`c_edgui`), ADD KEY `i_n_hguia` (`n_hguia`), ADD KEY `I_CDOAF` (`c_codactivo`), ADD KEY `i_cedgui` (`c_edgui`), ADD KEY `i_citguia` (`c_itguia`);

--
-- Indices de la tabla `public_tempdpeticion`
--
ALTER TABLE `public_tempdpeticion`
ADD PRIMARY KEY (`idtemp`) COMMENT 'p', ADD KEY `um` (`um`), ADD KEY `codestado` (`codestado`), ADD KEY `codocu` (`codocu`);

--
-- Indices de la tabla `public_temporadas`
--
ALTER TABLE `public_temporadas`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_temppeticion`
--
ALTER TABLE `public_temppeticion`
ADD PRIMARY KEY (`idtemp`) COMMENT 'p', ADD KEY `codpro` (`codpro`), ADD KEY `idcontacto` (`idcontacto`);

--
-- Indices de la tabla `public_tenores`
--
ALTER TABLE `public_tenores`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_thread`
--
ALTER TABLE `public_thread`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_tipoactivos`
--
ALTER TABLE `public_tipoactivos`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_tipocambio`
--
ALTER TABLE `public_tipocambio`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_tipocargos`
--
ALTER TABLE `public_tipocargos`
ADD PRIMARY KEY (`codtipocargo`);

--
-- Indices de la tabla `public_tipofacturacion`
--
ALTER TABLE `public_tipofacturacion`
ADD PRIMARY KEY (`codtipofac`);

--
-- Indices de la tabla `public_tipoformato`
--
ALTER TABLE `public_tipoformato`
ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `public_tipomaquina`
--
ALTER TABLE `public_tipomaquina`
ADD PRIMARY KEY (`codtipo`);

--
-- Indices de la tabla `public_tipoobjeto`
--
ALTER TABLE `public_tipoobjeto`
ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `public_tiposolicitudesactivos`
--
ALTER TABLE `public_tiposolicitudesactivos`
ADD PRIMARY KEY (`codtipo`);

--
-- Indices de la tabla `public_tipospresupuestales`
--
ALTER TABLE `public_tipospresupuestales`
ADD PRIMARY KEY (`tipo`);

--
-- Indices de la tabla `public_tipozarpe`
--
ALTER TABLE `public_tipozarpe`
ADD PRIMARY KEY (`codtipo`);

--
-- Indices de la tabla `public_toolbar_estados`
--
ALTER TABLE `public_toolbar_estados`
ADD PRIMARY KEY (`tag`);

--
-- Indices de la tabla `public_trabajadores`
--
ALTER TABLE `public_trabajadores`
ADD PRIMARY KEY (`codigotra`), ADD KEY `FKI_OFICIOS` (`codpuesto`);

--
-- Indices de la tabla `public_transacciones`
--
ALTER TABLE `public_transacciones`
ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `public_transacciongrupo`
--
ALTER TABLE `public_transacciongrupo`
ADD PRIMARY KEY (`codgrupo`,`codmodulo`);

--
-- Indices de la tabla `public_t_conectores_idiomas`
--
ALTER TABLE `public_t_conectores_idiomas`
ADD PRIMARY KEY (`cod_lang`);

--
-- Indices de la tabla `public_t_contac`
--
ALTER TABLE `public_t_contac`
ADD PRIMARY KEY (`c_hcod`);

--
-- Indices de la tabla `public_t_cuentas`
--
ALTER TABLE `public_t_cuentas`
ADD PRIMARY KEY (`codcuenta`);

--
-- Indices de la tabla `public_t_direcc`
--
ALTER TABLE `public_t_direcc`
ADD PRIMARY KEY (`c_hcod`);

--
-- Indices de la tabla `public_t_letras`
--
ALTER TABLE `public_t_letras`
ADD PRIMARY KEY (`valor`,`lenguaje`);

--
-- Indices de la tabla `public_t_mascaras`
--
ALTER TABLE `public_t_mascaras`
ADD PRIMARY KEY (`codelelemto`);

--
-- Indices de la tabla `public_t_moneda`
--
ALTER TABLE `public_t_moneda`
ADD PRIMARY KEY (`codmoneda`);

--
-- Indices de la tabla `public_t_servicios`
--
ALTER TABLE `public_t_servicios`
ADD PRIMARY KEY (`codservicio`);

--
-- Indices de la tabla `public_t_sistemas`
--
ALTER TABLE `public_t_sistemas`
ADD PRIMARY KEY (`codsistema`);

--
-- Indices de la tabla `public_t_ubicaciones`
--
ALTER TABLE `public_t_ubicaciones`
ADD PRIMARY KEY (`codubi`);

--
-- Indices de la tabla `public_t_um`
--
ALTER TABLE `public_t_um`
ADD PRIMARY KEY (`desum`);

--
-- Indices de la tabla `public_ubl`
--
ALTER TABLE `public_ubl`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_ums`
--
ALTER TABLE `public_ums`
ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `k_ums` (`um`);

--
-- Indices de la tabla `public_usuarios`
--
ALTER TABLE `public_usuarios`
ADD KEY `fki_centritos` (`centrodefault`);

--
-- Indices de la tabla `public_usuarioscentro`
--
ALTER TABLE `public_usuarioscentro`
ADD PRIMARY KEY (`id`), ADD KEY `fki_ierreperr` (`idus`);

--
-- Indices de la tabla `public_usuariosfavoritos`
--
ALTER TABLE `public_usuariosfavoritos`
ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `public_vistas`
--
ALTER TABLE `public_vistas`
ADD PRIMARY KEY (`idvista`);

--
-- Indices de la tabla `public_vistas_campos`
--
ALTER TABLE `public_vistas_campos`
ADD PRIMARY KEY (`idcampo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ActiveRecordLog`
--
ALTER TABLE `ActiveRecordLog`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=42631;
--
-- AUTO_INCREMENT de la tabla `cruge_field`
--
ALTER TABLE `cruge_field`
MODIFY `idfield` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `cruge_fieldvalue`
--
ALTER TABLE `cruge_fieldvalue`
MODIFY `idfieldvalue` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `cruge_session`
--
ALTER TABLE `cruge_session`
MODIFY `idsession` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=415;
--
-- AUTO_INCREMENT de la tabla `cruge_user`
--
ALTER TABLE `cruge_user`
MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT de la tabla `gallery`
--
ALTER TABLE `gallery`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `gallery_photo`
--
ALTER TABLE `gallery_photo`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `public_alconversiones`
--
ALTER TABLE `public_alconversiones`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `public_alentregas`
--
ALTER TABLE `public_alentregas`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `public_alinventario`
--
ALTER TABLE `public_alinventario`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=390256;
--
-- AUTO_INCREMENT de la tabla `public_alkardex`
--
ALTER TABLE `public_alkardex`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1294;
--
-- AUTO_INCREMENT de la tabla `public_alkardextraslado`
--
ALTER TABLE `public_alkardextraslado`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT de la tabla `public_almacendocs`
--
ALTER TABLE `public_almacendocs`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=380;
--
-- AUTO_INCREMENT de la tabla `public_alreserva`
--
ALTER TABLE `public_alreserva`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=126;
--
-- AUTO_INCREMENT de la tabla `public_atencionreserva`
--
ALTER TABLE `public_atencionreserva`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=69;
--
-- AUTO_INCREMENT de la tabla `public_bloqueos`
--
ALTER TABLE `public_bloqueos`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=259;
--
-- AUTO_INCREMENT de la tabla `public_ccgastos`
--
ALTER TABLE `public_ccgastos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=85;
--
-- AUTO_INCREMENT de la tabla `public_contactos`
--
ALTER TABLE `public_contactos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT de la tabla `public_coordocs`
--
ALTER TABLE `public_coordocs`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `public_desolpe1`
--
ALTER TABLE `public_desolpe1`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=150;
--
-- AUTO_INCREMENT de la tabla `public_desolpecompra`
--
ALTER TABLE `public_desolpecompra`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `public_detgui`
--
ALTER TABLE `public_detgui`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `public_dfacrecibida`
--
ALTER TABLE `public_dfacrecibida`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `public_direcciones`
--
ALTER TABLE `public_direcciones`
MODIFY `n_direc` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT de la tabla `public_docompra`
--
ALTER TABLE `public_docompra`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `public_docompra_t`
--
ALTER TABLE `public_docompra_t`
MODIFY `id` int(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT de la tabla `public_documentosfavoritos`
--
ALTER TABLE `public_documentosfavoritos`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `public_dpeticion`
--
ALTER TABLE `public_dpeticion`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=173;
--
-- AUTO_INCREMENT de la tabla `public_estado`
--
ALTER TABLE `public_estado`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=238;
--
-- AUTO_INCREMENT de la tabla `public_eventos`
--
ALTER TABLE `public_eventos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT de la tabla `public_factu`
--
ALTER TABLE `public_factu`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `public_gallery`
--
ALTER TABLE `public_gallery`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `public_gallery_photo`
--
ALTER TABLE `public_gallery_photo`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `public_guia`
--
ALTER TABLE `public_guia`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `public_lotes`
--
ALTER TABLE `public_lotes`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `public_lugares`
--
ALTER TABLE `public_lugares`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `public_maestroclipro`
--
ALTER TABLE `public_maestroclipro`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `public_maestrodetallecentros`
--
ALTER TABLE `public_maestrodetallecentros`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=46703;
--
-- AUTO_INCREMENT de la tabla `public_maestrotipos`
--
ALTER TABLE `public_maestrotipos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `public_mensajes`
--
ALTER TABLE `public_mensajes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `public_noticias`
--
ALTER TABLE `public_noticias`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `public_objetos_cliente`
--
ALTER TABLE `public_objetos_cliente`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `public_ocompra`
--
ALTER TABLE `public_ocompra`
MODIFY `idguia` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `public_opcionescamposdocu`
--
ALTER TABLE `public_opcionescamposdocu`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT de la tabla `public_opcionesdocumentos`
--
ALTER TABLE `public_opcionesdocumentos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=77;
--
-- AUTO_INCREMENT de la tabla `public_periodos`
--
ALTER TABLE `public_periodos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `public_peticion`
--
ALTER TABLE `public_peticion`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=151;
--
-- AUTO_INCREMENT de la tabla `public_solpe`
--
ALTER TABLE `public_solpe`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=259;
--
-- AUTO_INCREMENT de la tabla `public_tempdetgui`
--
ALTER TABLE `public_tempdetgui`
MODIFY `idtemp` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `public_tempdpeticion`
--
ALTER TABLE `public_tempdpeticion`
MODIFY `idtemp` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1126;
--
-- AUTO_INCREMENT de la tabla `public_temppeticion`
--
ALTER TABLE `public_temppeticion`
MODIFY `idtemp` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=150;
--
-- AUTO_INCREMENT de la tabla `public_ubl`
--
ALTER TABLE `public_ubl`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `public_ums`
--
ALTER TABLE `public_ums`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT de la tabla `public_usuariosfavoritos`
--
ALTER TABLE `public_usuariosfavoritos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `public_alconversiones`
--
ALTER TABLE `public_alconversiones`
ADD CONSTRAINT `public_alconversiones_ibfk_2` FOREIGN KEY (`um2`) REFERENCES `public_ums` (`um`),
ADD CONSTRAINT `public_alconversiones_ibfk_1` FOREIGN KEY (`um1`) REFERENCES `public_ums` (`um`);

--
-- Filtros para la tabla `public_alinventario`
--
ALTER TABLE `public_alinventario`
ADD CONSTRAINT `public_alinventario_ibfk_1` FOREIGN KEY (`codart`) REFERENCES `public_maestrocomponentes` (`codigo`);

--
-- Filtros para la tabla `public_alkardex`
--
ALTER TABLE `public_alkardex`
ADD CONSTRAINT `public_alkardex_ibfk_1` FOREIGN KEY (`codart`) REFERENCES `public_maestrocomponentes` (`codigo`);

--
-- Filtros para la tabla `public_alkardextraslado`
--
ALTER TABLE `public_alkardextraslado`
ADD CONSTRAINT `public_alkardextraslado_ibfk_2` FOREIGN KEY (`hidkardexdes`) REFERENCES `public_alkardex` (`id`),
ADD CONSTRAINT `public_alkardextraslado_ibfk_1` FOREIGN KEY (`hidkardexemi`) REFERENCES `public_alkardex` (`id`);

--
-- Filtros para la tabla `public_alreserva`
--
ALTER TABLE `public_alreserva`
ADD CONSTRAINT `public_alreserva_ibfk_1` FOREIGN KEY (`hidesolpe`) REFERENCES `public_desolpe1` (`id`);

--
-- Filtros para la tabla `public_desolpe1`
--
ALTER TABLE `public_desolpe1`
ADD CONSTRAINT `public_desolpe1_ibfk_4` FOREIGN KEY (`um`) REFERENCES `public_ums` (`um`),
ADD CONSTRAINT `public_desolpe1_ibfk_1` FOREIGN KEY (`codart`, `codal`, `centro`) REFERENCES `public_alinventario` (`codart`, `codalm`, `codcen`),
ADD CONSTRAINT `public_desolpe1_ibfk_2` FOREIGN KEY (`codart`) REFERENCES `public_maestrocomponentes` (`codigo`),
ADD CONSTRAINT `public_desolpe1_ibfk_3` FOREIGN KEY (`um`) REFERENCES `public_ums` (`um`);

--
-- Filtros para la tabla `public_dfacrecibida`
--
ALTER TABLE `public_dfacrecibida`
ADD CONSTRAINT `public_dfacrecibida_ibfk_1` FOREIGN KEY (`hientrega`) REFERENCES `public_alentregas` (`id`);

--
-- Filtros para la tabla `public_docompra_t`
--
ALTER TABLE `public_docompra_t`
ADD CONSTRAINT `public_docompra_t_ibfk_1` FOREIGN KEY (`codart`) REFERENCES `public_maestrocomponentes` (`codigo`);

--
-- Filtros para la tabla `public_dpeticion`
--
ALTER TABLE `public_dpeticion`
ADD CONSTRAINT `public_dpeticion_ibfk_1` FOREIGN KEY (`um`) REFERENCES `public_ums` (`um`),
ADD CONSTRAINT `public_dpeticion_ibfk_10` FOREIGN KEY (`codal`) REFERENCES `public_almacenes` (`codalm`),
ADD CONSTRAINT `public_dpeticion_ibfk_11` FOREIGN KEY (`codestado`) REFERENCES `public_estado` (`codestado`),
ADD CONSTRAINT `public_dpeticion_ibfk_12` FOREIGN KEY (`codocu`) REFERENCES `public_documentos` (`coddocu`),
ADD CONSTRAINT `public_dpeticion_ibfk_2` FOREIGN KEY (`um`) REFERENCES `public_ums` (`um`),
ADD CONSTRAINT `public_dpeticion_ibfk_3` FOREIGN KEY (`um`) REFERENCES `public_ums` (`um`),
ADD CONSTRAINT `public_dpeticion_ibfk_4` FOREIGN KEY (`codart`) REFERENCES `public_maestrocomponentes` (`codigo`),
ADD CONSTRAINT `public_dpeticion_ibfk_5` FOREIGN KEY (`codcen`) REFERENCES `public_centros` (`codcen`),
ADD CONSTRAINT `public_dpeticion_ibfk_6` FOREIGN KEY (`codal`) REFERENCES `public_almacenes` (`codalm`),
ADD CONSTRAINT `public_dpeticion_ibfk_7` FOREIGN KEY (`um`) REFERENCES `public_ums` (`um`),
ADD CONSTRAINT `public_dpeticion_ibfk_8` FOREIGN KEY (`codart`) REFERENCES `public_maestrocomponentes` (`codigo`),
ADD CONSTRAINT `public_dpeticion_ibfk_9` FOREIGN KEY (`codcen`) REFERENCES `public_centros` (`codcen`);

--
-- Filtros para la tabla `public_maestroclipro`
--
ALTER TABLE `public_maestroclipro`
ADD CONSTRAINT `public_maestroclipro_ibfk_1` FOREIGN KEY (`codart`) REFERENCES `public_maestrocomponentes` (`codigo`);

--
-- Filtros para la tabla `public_maestrocomponentes`
--
ALTER TABLE `public_maestrocomponentes`
ADD CONSTRAINT `public_maestrocomponentes_ibfk_1` FOREIGN KEY (`um`) REFERENCES `public_ums` (`um`),
ADD CONSTRAINT `public_maestrocomponentes_ibfk_2` FOREIGN KEY (`um`) REFERENCES `public_ums` (`um`),
ADD CONSTRAINT `public_maestrocomponentes_ibfk_3` FOREIGN KEY (`codtipo`) REFERENCES `public_maestrotipos` (`codtipo`);

--
-- Filtros para la tabla `public_maestrodetalle`
--
ALTER TABLE `public_maestrodetalle`
ADD CONSTRAINT `public_maestrodetalle_ibfk_1` FOREIGN KEY (`codart`) REFERENCES `public_maestrocomponentes` (`codigo`);

--
-- Filtros para la tabla `public_peticion`
--
ALTER TABLE `public_peticion`
ADD CONSTRAINT `public_peticion_ibfk_5` FOREIGN KEY (`codocu`) REFERENCES `public_documentos` (`coddocu`),
ADD CONSTRAINT `public_peticion_ibfk_1` FOREIGN KEY (`codpro`) REFERENCES `public_clipro` (`codpro`),
ADD CONSTRAINT `public_peticion_ibfk_2` FOREIGN KEY (`codpro`) REFERENCES `public_clipro` (`codpro`),
ADD CONSTRAINT `public_peticion_ibfk_3` FOREIGN KEY (`idcontacto`) REFERENCES `public_contactos` (`id`),
ADD CONSTRAINT `public_peticion_ibfk_4` FOREIGN KEY (`codestado`) REFERENCES `public_estado` (`codestado`);

--
-- Filtros para la tabla `public_tempdpeticion`
--
ALTER TABLE `public_tempdpeticion`
ADD CONSTRAINT `public_tempdpeticion_ibfk_1` FOREIGN KEY (`um`) REFERENCES `public_ums` (`um`),
ADD CONSTRAINT `public_tempdpeticion_ibfk_2` FOREIGN KEY (`um`) REFERENCES `public_ums` (`um`),
ADD CONSTRAINT `public_tempdpeticion_ibfk_3` FOREIGN KEY (`codestado`) REFERENCES `public_estado` (`codestado`),
ADD CONSTRAINT `public_tempdpeticion_ibfk_4` FOREIGN KEY (`codocu`) REFERENCES `public_documentos` (`coddocu`);

--
-- Filtros para la tabla `public_temppeticion`
--
ALTER TABLE `public_temppeticion`
ADD CONSTRAINT `public_temppeticion_ibfk_1` FOREIGN KEY (`codpro`) REFERENCES `public_clipro` (`codpro`),
ADD CONSTRAINT `public_temppeticion_ibfk_2` FOREIGN KEY (`idcontacto`) REFERENCES `public_contactos` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
