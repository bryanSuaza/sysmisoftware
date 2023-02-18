-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-01-2021 a las 17:44:47
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hotel`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `categoria_id` int(11) NOT NULL,
  `nombre` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `cliente_id` int(11) NOT NULL,
  `tercero_id` int(11) NOT NULL,
  `banco` varchar(45) DEFAULT NULL,
  `numero_cuenta` varchar(45) DEFAULT NULL,
  `estado` char(1) NOT NULL DEFAULT 'A',
  `fecha_registro` datetime DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `usuario_actualiza_id` int(11) DEFAULT NULL,
  `fecha_actualiza` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_factura`
--

CREATE TABLE `detalle_factura` (
  `detalle_factura_id` int(11) NOT NULL,
  `factura_id` int(11) NOT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `servicio_id` int(11) DEFAULT NULL,
  `concepto` varchar(45) NOT NULL,
  `cantidad` varchar(3) NOT NULL,
  `valor_unitario` double NOT NULL,
  `descuento` double DEFAULT NULL,
  `iva` double DEFAULT NULL,
  `valor_descuento` double DEFAULT NULL,
  `valor_iva` double DEFAULT NULL,
  `subtotal` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_rol_permiso`
--

CREATE TABLE `detalle_rol_permiso` (
  `detalle_rol_permiso_id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `permiso_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalle_rol_permiso`
--

INSERT INTO `detalle_rol_permiso` (`detalle_rol_permiso_id`, `rol_id`, `permiso_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 5),
(5, 2, 1),
(6, 2, 2),
(7, 2, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_servicio`
--

CREATE TABLE `detalle_servicio` (
  `detalle_servicio_id` int(11) NOT NULL,
  `servicio_id` int(11) NOT NULL,
  `habitacion_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `concepto` varchar(45) DEFAULT NULL,
  `cantidad` varchar(2) NOT NULL,
  `valor` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `empresa_id` int(11) NOT NULL,
  `tercero_id` int(11) NOT NULL,
  `representante` varchar(50) DEFAULT NULL,
  `ubicacion` text NOT NULL,
  `direccion` text NOT NULL,
  `pagina` text DEFAULT NULL,
  `logo_empresa` text DEFAULT NULL,
  `registro_mercantil` text DEFAULT NULL,
  `camara_comercio` text DEFAULT NULL,
  `foto_empresa` text DEFAULT NULL,
  `doc_registro` text DEFAULT NULL,
  `doc_camara` text DEFAULT NULL,
  `estado` char(1) NOT NULL DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `factura_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `base` double DEFAULT NULL,
  `valor_total` double DEFAULT NULL,
  `fecha` date NOT NULL,
  `estado` char(1) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT NULL,
  `usuario_actualiza_id` int(11) DEFAULT NULL,
  `fecha_actualiza` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitacion`
--

CREATE TABLE `habitacion` (
  `habitacion_id` int(11) NOT NULL,
  `numero` varchar(45) DEFAULT NULL,
  `valor` double NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` char(1) DEFAULT 'D',
  `tipo_habitacion_id` int(11) NOT NULL,
  `imagen` varchar(200) DEFAULT NULL,
  `fecha_registra` datetime DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  `usuario_actualiza_id` int(11) DEFAULT NULL,
  `fecha_actualiza` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parqueadero`
--

CREATE TABLE `parqueadero` (
  `parqueadero_id` int(11) NOT NULL,
  `codigo_ticket` int(20) NOT NULL,
  `placa` varchar(8) NOT NULL,
  `tipo_vehiculo_id` int(11) NOT NULL,
  `fecha_hora_ingreso` datetime NOT NULL,
  `fecha_hora_salida` datetime DEFAULT NULL,
  `valor_servicio` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` char(1) NOT NULL COMMENT 'A:activo F:finalizado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `permiso_id` int(11) NOT NULL,
  `permiso` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`permiso_id`, `permiso`) VALUES
(1, 'GUARDAR'),
(2, 'ACTUALIZAR'),
(3, 'ELIMINAR'),
(5, 'LEER');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `producto_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `valor_costo` double NOT NULL,
  `valor_venta` double NOT NULL,
  `estado` char(1) NOT NULL DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `rol_id` int(11) NOT NULL,
  `rol` varchar(45) DEFAULT NULL,
  `estado` char(1) NOT NULL DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`rol_id`, `rol`, `estado`) VALUES
(1, 'ADMINISTRADOR', 'A'),
(2, 'OPERADOR', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `servicio_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `estado` char(1) NOT NULL DEFAULT 'A',
  `usuario_id` int(11) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT NULL,
  `usuario_actualiza_id` int(11) DEFAULT NULL,
  `fecha_actualiza` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarifas_parqueadero`
--

CREATE TABLE `tarifas_parqueadero` (
  `tarifas_parqueadero_id` int(11) NOT NULL,
  `tipo_vehiculo_id` int(11) NOT NULL,
  `valor_hora_diurna` double NOT NULL,
  `valor_hora_nocturna` double DEFAULT NULL,
  `valor_medio_dia` double DEFAULT NULL,
  `valor_dia` double NOT NULL,
  `valor_mes` double DEFAULT NULL,
  `estado` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tercero`
--

CREATE TABLE `tercero` (
  `tercero_id` int(11) NOT NULL,
  `numero_identificacion` varchar(45) NOT NULL,
  `digito_verificacion` varchar(1) DEFAULT NULL,
  `primer_nombre` varchar(45) DEFAULT NULL,
  `segundo_nombre` varchar(45) DEFAULT NULL,
  `primer_apellido` varchar(45) DEFAULT NULL,
  `segundo_apellido` varchar(45) DEFAULT NULL,
  `razon_social` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `tipo_persona_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tercero`
--

INSERT INTO `tercero` (`tercero_id`, `numero_identificacion`, `digito_verificacion`, `primer_nombre`, `segundo_nombre`, `primer_apellido`, `segundo_apellido`, `razon_social`, `email`, `telefono`, `tipo_persona_id`) VALUES
(1, '202020202020', NULL, 'admin', '', 'principal', '', NULL, 'admin@admin.co', '22222222222', 1),
(2, '1110551372', NULL, 'Bryan', '', 'Suaza', 'Gil', NULL, 'bryansugi@gmail.com', '3222420599', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_de_servicio`
--

CREATE TABLE `tipos_de_servicio` (
  `tipo_servicio_id` int(11) NOT NULL,
  `tipo_servicio` text NOT NULL,
  `estado` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipos_de_servicio`
--

INSERT INTO `tipos_de_servicio` (`tipo_servicio_id`, `tipo_servicio`, `estado`) VALUES
(1, 'HORA DIURNA', 'A'),
(2, 'HORA NOCTURNA', 'A'),
(3, 'MEDIO DIA', 'A'),
(4, 'DIA', 'A'),
(5, 'MES', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_habitacion`
--

CREATE TABLE `tipo_habitacion` (
  `tipo_habitacion_id` int(11) NOT NULL,
  `tipo` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_habitacion`
--

INSERT INTO `tipo_habitacion` (`tipo_habitacion_id`, `tipo`) VALUES
(1, 'SENCILLA'),
(2, 'DOBLE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_persona`
--

CREATE TABLE `tipo_persona` (
  `tipo_persona_id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_persona`
--

INSERT INTO `tipo_persona` (`tipo_persona_id`, `nombre`, `descripcion`) VALUES
(1, 'NATURAL', 'PERSONA NATURAL'),
(2, 'JURIDICA', 'PERSONA JURIDICA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_vehiculo`
--

CREATE TABLE `tipo_vehiculo` (
  `tipo_vehiculo_id` int(11) NOT NULL,
  `tipo` text NOT NULL,
  `estado` char(1) NOT NULL COMMENT 'A:activo I:inactivo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_vehiculo`
--

INSERT INTO `tipo_vehiculo` (`tipo_vehiculo_id`, `tipo`, `estado`) VALUES
(1, 'AUTOMOVIL', 'A'),
(2, 'MOTOCICLETA', 'A'),
(3, 'BICICLETA', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `estado` char(1) NOT NULL DEFAULT 'A',
  `tercero_id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `username`, `password`, `estado`, `tercero_id`, `rol_id`) VALUES
(1, 'admin', 'admin', 'A', 1, 1),
(2, 'bryan', '1110551372', 'A', 2, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`categoria_id`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cliente_id`),
  ADD KEY `fk_user` (`usuario_id`),
  ADD KEY `fk_tercero` (`tercero_id`);

--
-- Indices de la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD PRIMARY KEY (`detalle_factura_id`),
  ADD KEY `fk_factura` (`factura_id`),
  ADD KEY `fk_servicio_id` (`servicio_id`),
  ADD KEY `fk_producto_id` (`producto_id`);

--
-- Indices de la tabla `detalle_rol_permiso`
--
ALTER TABLE `detalle_rol_permiso`
  ADD PRIMARY KEY (`detalle_rol_permiso_id`),
  ADD KEY `permiso_fk` (`permiso_id`),
  ADD KEY `rol_fk` (`rol_id`);

--
-- Indices de la tabla `detalle_servicio`
--
ALTER TABLE `detalle_servicio`
  ADD PRIMARY KEY (`detalle_servicio_id`),
  ADD KEY `fk_servicio` (`servicio_id`),
  ADD KEY `fk_habitacion` (`habitacion_id`),
  ADD KEY `fk_producto` (`producto_id`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`empresa_id`),
  ADD KEY `tercero_fk` (`tercero_id`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`factura_id`),
  ADD KEY `cliente_fk` (`cliente_id`),
  ADD KEY `usuario_fk` (`usuario_id`),
  ADD KEY `usuario_actualiza_fk` (`usuario_actualiza_id`);

--
-- Indices de la tabla `habitacion`
--
ALTER TABLE `habitacion`
  ADD PRIMARY KEY (`habitacion_id`),
  ADD KEY `FK_usuario` (`usuario_id`),
  ADD KEY `FK_tipo_habitacion` (`tipo_habitacion_id`);

--
-- Indices de la tabla `parqueadero`
--
ALTER TABLE `parqueadero`
  ADD PRIMARY KEY (`parqueadero_id`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`permiso_id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`producto_id`),
  ADD KEY `fk_categoria` (`categoria_id`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`rol_id`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`servicio_id`);

--
-- Indices de la tabla `tarifas_parqueadero`
--
ALTER TABLE `tarifas_parqueadero`
  ADD PRIMARY KEY (`tarifas_parqueadero_id`),
  ADD KEY `fk_tipo_vehiculo_id` (`tipo_vehiculo_id`);

--
-- Indices de la tabla `tercero`
--
ALTER TABLE `tercero`
  ADD PRIMARY KEY (`tercero_id`);

--
-- Indices de la tabla `tipos_de_servicio`
--
ALTER TABLE `tipos_de_servicio`
  ADD PRIMARY KEY (`tipo_servicio_id`);

--
-- Indices de la tabla `tipo_habitacion`
--
ALTER TABLE `tipo_habitacion`
  ADD PRIMARY KEY (`tipo_habitacion_id`);

--
-- Indices de la tabla `tipo_persona`
--
ALTER TABLE `tipo_persona`
  ADD PRIMARY KEY (`tipo_persona_id`);

--
-- Indices de la tabla `tipo_vehiculo`
--
ALTER TABLE `tipo_vehiculo`
  ADD PRIMARY KEY (`tipo_vehiculo_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `fk_tercero` FOREIGN KEY (`tercero_id`) REFERENCES `tercero` (`tercero_id`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`);

--
-- Filtros para la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD CONSTRAINT `fk_factura` FOREIGN KEY (`factura_id`) REFERENCES `factura` (`factura_id`),
  ADD CONSTRAINT `fk_producto_id` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`producto_id`),
  ADD CONSTRAINT `fk_servicio_id` FOREIGN KEY (`servicio_id`) REFERENCES `servicio` (`servicio_id`);

--
-- Filtros para la tabla `detalle_rol_permiso`
--
ALTER TABLE `detalle_rol_permiso`
  ADD CONSTRAINT `permiso_fk` FOREIGN KEY (`permiso_id`) REFERENCES `permiso` (`permiso_id`),
  ADD CONSTRAINT `rol_fk` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`rol_id`);

--
-- Filtros para la tabla `detalle_servicio`
--
ALTER TABLE `detalle_servicio`
  ADD CONSTRAINT `fk_habitacion` FOREIGN KEY (`habitacion_id`) REFERENCES `habitacion` (`habitacion_id`),
  ADD CONSTRAINT `fk_producto` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`producto_id`),
  ADD CONSTRAINT `fk_servicio` FOREIGN KEY (`servicio_id`) REFERENCES `servicio` (`servicio_id`);

--
-- Filtros para la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD CONSTRAINT `tercero_fk` FOREIGN KEY (`tercero_id`) REFERENCES `tercero` (`tercero_id`);

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `cliente_fk` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`cliente_id`),
  ADD CONSTRAINT `usuario_fk` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`);

--
-- Filtros para la tabla `habitacion`
--
ALTER TABLE `habitacion`
  ADD CONSTRAINT `FK_tipo_habitacion` FOREIGN KEY (`tipo_habitacion_id`) REFERENCES `tipo_habitacion` (`tipo_habitacion_id`),
  ADD CONSTRAINT `FK_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`categoria_id`);

--
-- Filtros para la tabla `tarifas_parqueadero`
--
ALTER TABLE `tarifas_parqueadero`
  ADD CONSTRAINT `fk_tipo_vehiculo_id` FOREIGN KEY (`tipo_vehiculo_id`) REFERENCES `tipo_vehiculo` (`tipo_vehiculo_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
