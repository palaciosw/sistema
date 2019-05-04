-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Servidor: localhost
-- Tiempo de generación: 19-09-2013 a las 17:06:01
-- Versión del servidor: 5.0.51
-- Versión de PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Base de datos: `webfinanza`
-- 

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `concepto`
-- 

CREATE TABLE `concepto` (
  `id` int(11) NOT NULL auto_increment,
  `idgrupo` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idgrupo` (`idgrupo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `concepto`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `cuenta`
-- 

CREATE TABLE `cuenta` (
  `id` int(11) NOT NULL auto_increment,
  `identidad` int(11) NOT NULL,
  `idmoneda` char(2) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `defecto` char(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `identidad` (`identidad`),
  KEY `idmoneda` (`idmoneda`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `cuenta`
-- 

INSERT INTO `cuenta` VALUES (1, 1, 'SS', 'Caja Chica', '1');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `entidad`
-- 

CREATE TABLE `entidad` (
  `id` int(11) NOT NULL auto_increment,
  `descripcion` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `entidad`
-- 

INSERT INTO `entidad` VALUES (1, 'Caja Particular');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `grupo`
-- 

CREATE TABLE `grupo` (
  `id` int(11) NOT NULL auto_increment,
  `descripcion` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `grupo`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `moneda`
-- 

CREATE TABLE `moneda` (
  `id` char(2) NOT NULL,
  `descripcion` varchar(30) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Volcar la base de datos para la tabla `moneda`
-- 

INSERT INTO `moneda` VALUES ('DD', 'Dolares Americanos');
INSERT INTO `moneda` VALUES ('SS', 'Nuevos Soles');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `movimiento`
-- 

CREATE TABLE `movimiento` (
  `id` int(11) NOT NULL auto_increment,
  `idpersona` int(11) default NULL,
  `idmoneda` char(2) NOT NULL,
  `idconcepto` int(11) NOT NULL,
  `idcuenta` int(11) default NULL,
  `tipo` char(1) NOT NULL,
  `fecha` date NOT NULL,
  `importe` decimal(14,2) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idpersona` (`idpersona`),
  KEY `idmoneda` (`idmoneda`),
  KEY `idconcepto` (`idconcepto`),
  KEY `idcuenta` (`idcuenta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `movimiento`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `persona`
-- 

CREATE TABLE `persona` (
  `id` int(11) NOT NULL auto_increment,
  `nombres` varchar(200) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `persona`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `usuario`
-- 

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL auto_increment,
  `login` varchar(50) NOT NULL,
  `clave` varchar(50) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `registro` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `usuario`
-- 

INSERT INTO `usuario` VALUES (1, 'usuario', '0f3d014eead934bbdbacb62a01dc4831', 'Usuario', 'usuario@outlook.com', '2013-09-18 12:48:55');

-- 
-- Filtros para las tablas descargadas (dump)
-- 

-- 
-- Filtros para la tabla `concepto`
-- 
ALTER TABLE `concepto`
  ADD CONSTRAINT `concepto_ibfk_1` FOREIGN KEY (`idgrupo`) REFERENCES `grupo` (`id`);

-- 
-- Filtros para la tabla `cuenta`
-- 
ALTER TABLE `cuenta`
  ADD CONSTRAINT `cuenta_ibfk_1` FOREIGN KEY (`identidad`) REFERENCES `entidad` (`id`),
  ADD CONSTRAINT `cuenta_ibfk_2` FOREIGN KEY (`idmoneda`) REFERENCES `moneda` (`id`);

-- 
-- Filtros para la tabla `movimiento`
-- 
ALTER TABLE `movimiento`
  ADD CONSTRAINT `movimiento_ibfk_1` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`id`),
  ADD CONSTRAINT `movimiento_ibfk_2` FOREIGN KEY (`idmoneda`) REFERENCES `moneda` (`id`),
  ADD CONSTRAINT `movimiento_ibfk_3` FOREIGN KEY (`idconcepto`) REFERENCES `concepto` (`id`),
  ADD CONSTRAINT `movimiento_ibfk_4` FOREIGN KEY (`idcuenta`) REFERENCES `cuenta` (`id`);
